<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Sales_model');
    }

    public function index() {
        $data['sales'] = $this->Sales_model->get_all_sales();
        $this->load->view('templates/header');
        $this->load->view('sales/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah() {
        $this->load->view('templates/header');
        $this->load->view('sales/form_sales');
        $this->load->view('templates/footer');
    }

    public function insert() {
        $data = [
            'nama_sales' => $this->input->post('nama_sales')
        ];

        if ($this->Sales_model->insert_sales($data)) {
            $this->session->set_flashdata('success', 'Data sales berhasil ditambahkan.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan sales.');
        }

        redirect('sales');
    }

public function hapus($id) {
    $sales_orders = $this->db->get_where('salesorder', ['idsales' => $id])->result();

    foreach ($sales_orders as $so) {
        $this->db->where('idso', $so->idso);
        $this->db->delete('detail_so');
        $this->db->where('idso', $so->idso);
        $this->db->delete('salesorder');
    }
    $this->Sales_model->delete_sales($id);

    $this->session->set_flashdata('success', 'Sales berhasil dihapus.');
    redirect('sales');
}

    public function edit($id) {
        $data['sales'] = $this->Sales_model->get_sales_by_id($id);
        $this->load->view('templates/header');
        $this->load->view('sales/edit_sales', $data);
        $this->load->view('templates/footer');
    }

    public function update($id) {
        $data = [
            'nama_sales' => $this->input->post('nama_sales')
        ];

        $this->Sales_model->update_sales($id, $data);
        redirect('sales');
    }
      public function laporan()
    {
        $this->load->view('templates/header');
        $this->load->view('sales/laporan_form');
        $this->load->view('templates/footer');
    }

    public function cetak_laporan()
    {
        $tanggal_dari = $this->input->post('tanggal_dari');
        $tanggal_sampai = $this->input->post('tanggal_sampai');

        $data['sales'] = $this->Sales_model->get_laporan_sales($tanggal_dari, $tanggal_sampai);
        $data['tanggal_dari'] = $tanggal_dari;
        $data['tanggal_sampai'] = $tanggal_sampai;
        $this->load->view('templates/header');
        $this->load->view('sales/laporan_hasil', $data);
        $this->load->view('templates/footer');
    }
    }