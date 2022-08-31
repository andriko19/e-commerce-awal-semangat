<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_model extends CI_Model {

  public function getTransaksi(){
    $this->db->select("*");
    $this->db->join("admin", "payment_transaction.id_admin=admin.id");
    $this->db->order_by("payment_transaction.id", "desc");
    return $this->db->get("payment_transaction");
  }

  public function getTransaksiKasir($id_admin){
    $this->db->select("*");
    $this->db->from("payment_transaction");
    $this->db->join("admin", "payment_transaction.id_admin=admin.id");
    $this->db->where('payment_transaction.id_admin', $id_admin);
    $this->db->order_by("payment_transaction.id", "desc");
    return $this->db->get();
  }

  public function getSearchTransaksi($key,$number,$offset){
    $this->db->select("*");
    // $this->db->join("categories", "products.category=categories.id");
    $this->db->like('payment_transaction.id_nota', $key);
    $this->db->or_like('payment_transaction.price', $key);
    $this->db->or_like('payment_transaction.status', $key);
    $this->db->order_by("payment_transaction.id", "desc");
    return $this->db->get("payment_transaction");
}

  public function getTransaksiById($id_nota){
    $this->db->select("*");
    $this->db->from("payment_transaction");
    $this->db->join("admin", "payment_transaction.id_admin=admin.id");
    $this->db->where('payment_transaction.id_nota', $id_nota);
    return $this->db->get()->row_array();
  }

  public function getDetailTransaksiById($id_nota){
    $this->db->select("*, (price * qty) AS total_harga");
    $this->db->from("payment_transaction_detail");
    $this->db->where('payment_transaction_detail.id_nota', $id_nota);
    return $this->db->get();
  }

  public function getLaporan($tanggal_awal, $tanggal_akhir){
    $this->db->select("*");
    $this->db->join("admin", "payment_transaction.id_admin=admin.id");
    $this->db->order_by("payment_transaction.id", "desc");
    $query = $this->db->get_where('payment_transaction', array('date>=' => $tanggal_awal, 'date<=' => $tanggal_akhir));
    // $this->db->order_by("payment_transaction.id", "desc");
    return $query->result_array();
  }

  public function search_product($key)
	{
		$this->db->select('*');
		$this->db->like('title', $key);
		$this->db->or_like('id', $key);
		$this->db->limit(10);
		$query = $this->db->get('products');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
				$hasil[] = $data;
			}

			return $hasil;
		}
	}

  public function get_id_nota()
  {
    $q = $this->db->query("SELECT MAX(RIGHT(id,4)) AS kd_max FROM payment_transaction WHERE DATE(date)=CURDATE()");
    $kd = "";
    if($q->num_rows()>0){
        foreach($q->result() as $k){
            $tmp = ((int)$k->kd_max)+1;
            $kd = sprintf("%04s", $tmp);
        }
    }else{
        $kd = "0001";
    }
    date_default_timezone_set('Asia/Jakarta');
    return date('dmy').$kd;
  }

  public function find_merchant()
	{
		$this->db->select('*');

		return $this->db->get('payment_transaction')->row();
	}

  public function create_order($order)
	{
		return $this->db->insert('payment_transaction', $order);
	}

  public function create_detail_order($detailOrder)
	{
		return $this->db->insert('payment_transaction_detail', $detailOrder);
	}

}