<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_model extends CI_Model {

  public function getTransaksi($number,$offset){
    $this->db->select("*");
    // $this->db->join("categories", "products.category=categories.id");
    $this->db->order_by("payment_transaction.id", "desc");
    return $this->db->get("payment_transaction",$number,$offset);
  }

  public function getTransaksiById($id_nota){
    $this->db->select("*");
    $this->db->from("payment_transaction");
    $this->db->where('payment_transaction.id_nota', $id_nota);
    return $this->db->get()->row_array();
  }

  public function getDetailTransaksiById($id_nota){
    $this->db->select("*, (price * qty) AS total_harga");
    $this->db->from("payment_transaction_detail");
    $this->db->where('payment_transaction_detail.id_nota', $id_nota);
    return $this->db->get();
  }

}