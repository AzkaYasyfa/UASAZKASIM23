<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends MY_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Produk_model');
    }

    public function index(){
        $data['produk'] = $this->Produk_model->get_all_produk();
        $this->load->view('templates/header');
        $this->load->view('produk/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah(){
        $this->load->view('templates/header');
        $this->load->view('produk/form_produk');
        $this->load->view('templates/footer');
    }

    public function insert(){
        $kode_produk = $this->input->post('kode_produk');
        $nama_produk = $this->input->post('nama_produk');
        $harga = $this->input->post('harga');
        $stok = $this->input->post('stok');

        $data = array(
            'kode_produk' => $kode_produk,
            'nama_produk' => $nama_produk,
            'harga' => $harga,
            'stok' => $stok
        );

        $result = $this->Produk_model->insert_produk($data);

        if($result){
            $this->session->set_flashdata('success','Produk berhasil disimpan');
            redirect('produk');
        } else {
            $this->session->set_flashdata('error','Produk gagal disimpan');
            redirect('produk');
        }
    }

    public function hapus($idproduk){

    $this->db->where('idproduk', $idproduk);
    $this->db->delete('detail_so');

    $this->Produk_model->delete_produk($idproduk);

    $this->session->set_flashdata('success', 'Produk dan detail SO terkait berhasil dihapus.');
    redirect('produk');
}

    public function edit($idproduk){
        $data['produk'] = $this->Produk_model->get_produk_by_id($idproduk);
        $this->load->view('templates/header');
        $this->load->view('produk/edit_produk', $data);
        $this->load->view('templates/footer');
    }

    public function update($id){
        $this->form_validation->set_rules('kode_produk', 'Kode Produk', 'required');
        $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');
        $this->form_validation->set_rules('stok', 'Stok', 'required|numeric');

        if ($this->form_validation->run() === FALSE){
            return $this->edit($id);
        } else {
            $kode_produk = $this->input->post('kode_produk');

            if ($this->Produk_model->cek_kode_produk_duplikat($kode_produk, $id)) {
                $this->session->set_flashdata('error', 'Kode Produk sudah digunakan produk lain.');
                return $this->edit($id);
            }

            $data = [
                'kode_produk' => $kode_produk,
                'nama_produk' => $this->input->post('nama_produk'),
                'harga' => $this->input->post('harga'),
                'stok' => $this->input->post('stok')
            ];

            $this->Produk_model->update_produk($id, $data);
            $this->session->set_flashdata('success', 'Produk berhasil diperbarui.');
            redirect('produk');
        }
    }
}