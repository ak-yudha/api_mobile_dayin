<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loginmodel extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    $this->load->database();

  }

  public function is_valid($nama){
    // $this->db->select('*');
    // $this->db->from('admin');
    // $this->db->where('nama',$nama);
    // $query = $this->db->get();
    // return $query->row();

    $this->db->select('admin.id, admin.nama as nama, admin.password as password, admin.no_card as no_card, admin.id_no_pls as id_no_pls, benefit_header.CARD_NO, benefit_header.NO_MEMBER, benefit_header.UW_YEAR, benefit_header.EXPIRED_DT , benefit_header.MEMBER_NM');
    $this->db->from('admin');
    $this->db->join('benefit_header','admin.no_card = benefit_header.CARD_NO');    
    $this->db->where('admin.nama',$nama);
    $query = $this->db->get();
    return $query->row();
  }

  public function is_valid_num($nama){
    $this->db->select('*');
    $this->db->from('admin');
    $this->db->where('nama',$nama);
    $query = $this->db->get();
    return $query->num_rows();
  }

}
