<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salesorder_model extends CI_Model {

    public function get_all_orders() {
        $this->db->select('so.*, p.nama as nama_pelanggan, s.nama_sales');
        $this->db->from('salesorder so');
        $this->db->join('pelanggan p', 'so.idpelanggan = p.idpelanggan');
        $this->db->join('sales s', 'so.idsales = s.idsales');
        $this->db->order_by('so.tanggal', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_order_by_id($idso) {
        $this->db->select('so.*, p.nama as nama_pelanggan, s.nama_sales');
        $this->db->from('salesorder so');
        $this->db->join('pelanggan p', 'so.idpelanggan = p.idpelanggan');
        $this->db->join('sales s', 'so.idsales = s.idsales');
        $this->db->where('so.idso', $idso);
        $order = $this->db->get()->row_array();

        if ($order) {
            $order['details'] = $this->db->select('dso.*, pr.nama_produk, pr.harga')
                ->from('detail_so dso')
                ->join('produk pr', 'dso.idproduk = pr.idproduk')
                ->where('dso.idso', $idso)
                ->get()->result_array();
        }
        return $order;
    }

    public function insert_order($data, $details) {
        $this->db->trans_start();

        $this->db->insert('salesorder', $data);
        $idso = $this->db->insert_id();

        foreach ($details as $item) {
            $item['idso'] = $idso;
            $this->db->insert('detail_so', $item);

            // Kurangi stok produk
            $this->db->set('stok', 'stok - ' . intval($item['jumlah']), FALSE);
            $this->db->where('idproduk', $item['idproduk']);
            $this->db->update('produk');
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function update_order($idso, $data, $details) {
        $this->db->trans_start();

        // Update salesorder
        $this->db->where('idso', $idso);
        $this->db->update('salesorder', $data);

        // Dapatkan detail lama untuk kembalikan stok
        $old_details = $this->db->get_where('detail_so', ['idso' => $idso])->result_array();

        // Kembalikan stok produk lama
        foreach ($old_details as $item) {
            $this->db->set('stok', 'stok + ' . intval($item['jumlah']), FALSE);
            $this->db->where('idproduk', $item['idproduk']);
            $this->db->update('produk');
        }

        // Hapus detail lama
        $this->db->delete('detail_so', ['idso' => $idso]);

        // Insert detail baru dan update stok
        foreach ($details as $item) {
            $item['idso'] = $idso;
            $this->db->insert('detail_so', $item);

            // Kurangi stok produk baru
            $this->db->set('stok', 'stok - ' . intval($item['jumlah']), FALSE);
            $this->db->where('idproduk', $item['idproduk']);
            $this->db->update('produk');
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function delete_order($idso) {
        $this->db->trans_start();

        // Dapatkan detail order
        $details = $this->db->get_where('detail_so', ['idso' => $idso])->result_array();

        // Kembalikan stok produk
        foreach ($details as $item) {
            $this->db->set('stok', 'stok + ' . intval($item['jumlah']), FALSE);
            $this->db->where('idproduk', $item['idproduk']);
            $this->db->update('produk');
        }

        // Hapus detail_so
        $this->db->delete('detail_so', ['idso' => $idso]);

        // Hapus salesorder
        $this->db->delete('salesorder', ['idso' => $idso]);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function getById($id) {
        return $this->db->get_where('salesorder', ['idso' => $id])->row_array();
    }

    public function getDetailById($id) {
        return $this->db->get_where('detail_so', ['idso' => $id])->result_array();
    }

    public function get_laporan_salesorder($tanggal_dari, $tanggal_sampai) {
        $this->db->select('so.*, p.nama as nama_pelanggan, s.nama_sales');
        $this->db->from('salesorder so');
        $this->db->join('pelanggan p', 'so.idpelanggan = p.idpelanggan');
        $this->db->join('sales s', 'so.idsales = s.idsales');
        $this->db->where('so.tanggal >=', $tanggal_dari);
        $this->db->where('so.tanggal <=', $tanggal_sampai);
        $this->db->order_by('so.tanggal', 'ASC');
        return $this->db->get()->result(); 
    }

    public function updateSalesOrder($idso, $data) {
        $this->db->where('idso', $idso);
        return $this->db->update('salesorder', $data);
    }
}