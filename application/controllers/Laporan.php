<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('laporan_model');
    }

    public function index() {
        $this->load->view('templates/header');
        $this->load->view('laporan/form_laporan');
        $this->load->view('templates/footer');
    }

    public function cetak_laporan() {
        $tanggal_awal = $this->input->post('tanggal_dari');
        $tanggal_akhir = $this->input->post('tanggal_sampai');
        $data['laporan'] = $this->laporan_model->get_laporan($tanggal_awal, $tanggal_akhir);
        $data['tanggal_awal'] = $tanggal_awal;
        $data['tanggal_akhir'] = $tanggal_akhir;
        $this->load->view('templates/header');
        $this->load->view('laporan/hasil_laporan', $data);
        $this->load->view('templates/footer');
    }
}