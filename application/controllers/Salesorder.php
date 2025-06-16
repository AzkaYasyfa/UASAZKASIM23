<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salesorder extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load model yang dibutuhkan
        $this->load->model('Salesorder_model');
        $this->load->model('Produk_model');
        $this->load->model('Pelanggan_model');
        $this->load->model('Sales_model');
        $this->load->library('form_validation');
    }

    // Menampilkan daftar sales order
    public function index() {
        $data['orders'] = $this->Salesorder_model->get_all_orders();
        $this->load->view('templates/header');
        $this->load->view('salesorder/index', $data);
        $this->load->view('templates/footer');
    }

    // Form tambah sales order baru
    public function tambah() {
        $data['produk'] = $this->Produk_model->get_all_produk();
        $data['pelanggan'] = $this->Pelanggan_model->get_all_pelanggan();
        $data['sales'] = $this->Sales_model->get_all_sales();

        $this->load->view('templates/header');
        $this->load->view('salesorder/form_salesorder', $data);
        $this->load->view('templates/footer');
    }
    public function edit($id)
{
    $this->load->model('Salesorder_model');
    $this->load->model('Pelanggan_model');
    $this->load->model('Sales_model');
    $this->load->model('Produk_model');

    $data['salesorder'] = $this->Salesorder_model->getById($id);
    $data['detail'] = $this->Salesorder_model->getDetailById($id);
    $data['pelanggan'] = $this->Pelanggan_model->get_all_pelanggan();
    $data['sales'] = $this->Sales_model->get_all_sales();
    $data['produk'] = $this->Produk_model->get_all_produk();
    $data['status'] = $this->Produk_model->get_all_produk();

    if (!$data['salesorder']) {
        show_404(); // jika id tidak ditemukan
    }

    $this->load->view('templates/header');
    $this->load->view('salesorder/edit_salesorder', $data);
    $this->load->view('templates/footer');
}

public function edit_status($id)
{
    $data['salesorder'] = $this->Salesorder_model->getById($id);

    if (!$data['salesorder']) {
        show_404();
    }

    $this->load->view('templates/header');
    $this->load->view('salesorder/edit_status', $data);
    $this->load->view('templates/footer');
}
public function update_status($id)
{
    $status = $this->input->post('status');

    $this->Salesorder_model->updateSalesOrder($id, ['status' => $status]);

    $this->session->set_flashdata('success', 'Status sales order berhasil diperbarui.');
    redirect('salesorder');
}

    // Simpan data sales order baru
    public function insert() {
        $this->form_validation->set_rules('kode_so', 'Kode SO', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('idpelanggan', 'Pelanggan', 'required');
        $this->form_validation->set_rules('idsales', 'Sales', 'required');

        if ($this->form_validation->run() == FALSE) {
            return $this->tambah();
        }

        $kode_so = $this->input->post('kode_so');
        $tanggal = $this->input->post('tanggal');
        $idpelanggan = $this->input->post('idpelanggan');
        $idsales = $this->input->post('idsales');
        $produk = $this->input->post('produk');
        $jumlah = $this->input->post('jumlah');

        $total_harga = 0;
        $details = [];

        foreach ($produk as $key => $idproduk) {
            if (!$idproduk || !$jumlah[$key]) continue;

            $jumlah_produk = intval($jumlah[$key]);
            $produk_detail = $this->Produk_model->get_produk_by_id($idproduk);
            $subtotal = $produk_detail['harga'] * $jumlah_produk;
            $total_harga += $subtotal;

            $details[] = [
                'idproduk' => $idproduk,
                'jumlah' => $jumlah_produk,
                'subtotal' => $subtotal,
            ];
        }

        $data = [
            'kode_so' => $kode_so,
            'tanggal' => $tanggal,
            'idpelanggan' => $idpelanggan,
            'idsales' => $idsales,
            'status' => 'draft',
            'total_harga' => $total_harga,
        ];

        if ($this->Salesorder_model->insert_order($data, $details)) {
            $this->session->set_flashdata('success', 'Sales order berhasil disimpan');
            redirect('salesorder');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan sales order');
            redirect('salesorder/tambah');
        }
    }

    public function laporan() {
        $this->load->view('templates/header');
        $this->load->view('salesorder/laporan_form');
        $this->load->view('templates/footer');
    }

    public function cetak_laporan() {
        $tanggal_dari = $this->input->post('tanggal_dari');
        $tanggal_sampai = $this->input->post('tanggal_sampai');
        $data['salesorder'] = $this->Salesorder_model->get_laporan_salesorder($tanggal_dari, $tanggal_sampai);
        $data['tanggal_dari'] = $tanggal_dari;
        $data['tanggal_sampai'] = $tanggal_sampai;

        $this->load->view('templates/header');
        $this->load->view('salesorder/laporan_hasil', $data);
        $this->load->view('templates/footer');
    }

    public function update($idso) {
        $this->form_validation->set_rules('kode_so', 'Kode SO', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('idpelanggan', 'Pelanggan', 'required');
        $this->form_validation->set_rules('idsales', 'Sales', 'required');

        if ($this->form_validation->run() == FALSE) {
            return $this->edit($idso);
        }

        $kode_so = $this->input->post('kode_so');
        $tanggal = $this->input->post('tanggal');
        $idpelanggan = $this->input->post('idpelanggan');
        $idsales = $this->input->post('idsales');
        $status = $this->input->post('status');
        $produk = $this->input->post('produk');
        $jumlah = $this->input->post('jumlah');

        $total_harga = 0;
        $details = [];

        foreach ($produk as $key => $idproduk) {
            if (!$idproduk || !$jumlah[$key]) continue;

            $jumlah_produk = intval($jumlah[$key]);
            $produk_detail = $this->Produk_model->get_produk_by_id($idproduk);
            $subtotal = $produk_detail['harga'] * $jumlah_produk;
            $total_harga += $subtotal;

            $details[] = [
                'idproduk' => $idproduk,
                'jumlah' => $jumlah_produk,
                'subtotal' => $subtotal,
            ];
        }

        $data = [
            'kode_so' => $kode_so,
            'tanggal' => $tanggal,
            'idpelanggan' => $idpelanggan,
            'idsales' => $idsales,
            'status' => $status,
            'total_harga' => $total_harga,
        ];

        if ($this->Salesorder_model->update_order($idso, $data, $details)) {
            $this->session->set_flashdata('success', 'Sales order berhasil diperbarui');
            redirect('salesorder');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui sales order');
            redirect('salesorder/edit/'.$idso);
        }
    }

    public function delete($idso) {
        if ($this->Salesorder_model->delete_order($idso)) {
            $this->session->set_flashdata('success', 'Sales order berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus sales order');
        }
        redirect('salesorder');
    }
}