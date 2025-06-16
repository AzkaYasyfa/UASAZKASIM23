<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Pelanggan_model');
    }

    public function index() {
        $data['pelanggan'] = $this->Pelanggan_model->get_all_pelanggan();
        $this->load->view('templates/header');
        $this->load->view('pelanggan/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah() {
        $this->load->view('templates/header');
        $this->load->view('pelanggan/form_pelanggan');
        $this->load->view('templates/footer');
    }

    public function insert() {
        $data = [
            'nama'     => $this->input->post('nama'),
            'alamat'   => $this->input->post('alamat'),
            'no_telp'  => $this->input->post('no_telp')
        ];

        if ($this->Pelanggan_model->insert_pelanggan($data)) {
            $this->session->set_flashdata('success', 'Data pelanggan berhasil ditambahkan.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan pelanggan.');
        }
        redirect('pelanggan');
    }

   public function hapus($id) {
    $sales_orders = $this->db->get_where('salesorder', ['idpelanggan' => $id])->result();

    foreach ($sales_orders as $so) {
        $this->db->where('idso', $so->idso);
        $this->db->delete('detail_so');
        $this->db->where('idso', $so->idso);
        $this->db->delete('salesorder');
    }

    $this->Pelanggan_model->delete_pelanggan($id);

    $this->session->set_flashdata('success', 'Pelanggan dan data terkait berhasil dihapus.');
    redirect('pelanggan');
}

    public function edit($id) {
        $data['pelanggan'] = $this->Pelanggan_model->get_pelanggan_by_id($id);
        $this->load->view('templates/header');
        $this->load->view('pelanggan/edit_pelanggan', $data);
        $this->load->view('templates/footer');
    }

    public function update($id) {
        $data = [
            'nama'     => $this->input->post('nama'),
            'alamat'   => $this->input->post('alamat'),
            'no_telp'  => $this->input->post('no_telp')
        ];

        $this->Pelanggan_model->update_pelanggan($id, $data);
        redirect('pelanggan');
    }
}