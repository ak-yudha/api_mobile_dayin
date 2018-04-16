<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mymodel extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function selectanggota(){
    $this->db->select('*');
    $this->db->from('anggota');
    $query = $this->db->get();
    return $query->result();
  }

  public function selectanggotawhere($id){
    $this->db->select('*');
    $this->db->from('anggota');
    $this->db->where('id',$id);
    $query = $this->db->get();
    return $query->row();
  }

  public function insertanggota($data){
    if ($this->db->insert('anggota',$data)) {
      return true;
    }
  }

  public function updateanggota($id,$data){
    $this->db->set($data);
    $this->db->where('id',$id);
    if ($this->db->update('anggota')) {
      return true;
    }
  }

  public function deleteanggota($id){
    $this->db->where('id',$id);
    $this->db->delete('anggota');
    if ($this->db->affected_rows()>0) {
      return true;
    }
  }

  public function insertadmin($data){
    if ($this->db->insert('admin',$data)) {
      return true;
    }
  }

  public function selectbuku(){
    $this->db->select('*');
    $this->db->from('buku');
    $query = $this->db->get();
    return $query->result();
  }

  public function selectbukuwhere($id){
    $this->db->select('*');
    $this->db->from('buku');
    $this->db->where('id',$id);
    $query = $this->db->get();
    return $query->row();
  }

  public function insertbuku($data){
    if ($this->db->insert('buku',$data)) {
      return true;
    }
  }

  public function updatebuku($id,$data){
    $this->db->set($data);
    $this->db->where('id',$id);
    if ($this->db->update('buku')) {
      return true;
    }
  }

  public function deletebuku($id){
    $this->db->where('id',$id);
    $this->db->delete('buku');
    if ($this->db->affected_rows()>0) {
      return true;
    }
  }


  //--------pinjam-----

  public function selectidbuku(){
    $this->db->select('id');
    $this->db->from('buku');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function selectidanggota(){
    $this->db->select('id');
    $this->db->from('anggota');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function insertpinjam($data){
    if ($this->db->insert('pinjam',$data)) {
      return true;
    }
  }

  public function selectpinjam(){
    $this->db->select('pinjam.id, anggota.nama, buku.judul, pinjam.tgl_pinjam, pinjam.denda');
    $this->db->from('pinjam');
    $this->db->join('anggota','pinjam.id_anggota = anggota.id');
    $this->db->join('buku','pinjam.id_buku = buku.id');
    $query = $this->db->get();
    return $query->result();
  }

  public function selectpinjamwhere($idpinjam){
    $this->db->select('pinjam.id, anggota.nama, buku.judul, pinjam.tgl_pinjam, pinjam.denda');
    $this->db->from('pinjam');
    $this->db->join('anggota','pinjam.id_anggota = anggota.id');
    $this->db->join('buku','pinjam.id_buku = buku.id');
    $this->db->where('pinjam.id',$idpinjam);
    $query = $this->db->get();
    return $query->result();
  }

  public function updatepinjam($id,$data){
    $this->db->set($data);
    $this->db->where('id',$id);
    if ($this->db->update('pinjam')) {
      return true;
    }
  }

  public function deletepinjam($id){
    $this->db->where('id',$id);
    $this->db->delete('pinjam');
    if ($this->db->affected_rows()>0) {
      return true;
    }
  }

  // new yudha
  public function selectnocard($id_card){
    $this->db->select('CARD_NO');
    $this->db->from('benefit_header');
    $this->db->where('CARD_NO',$id_card);
    $query = $this->db->get();
    return $query->row();
  }

  public function selectrumahsakit($id){    
    $this->db->select('*');
    $this->db->from('Hospital');
    if (!empty($id)) $this->db->where('HospitalID', $id);
    $query = $this->db->get();
    // return $this->db->last_query();
    return $query->row();
  }

  public function selectrumahsakitwhere($page=1, $ndata=0, $state, $city){
    $query = $this->db->get('Hospital');
		if ($query)
		{
			$arr['totaldata'] = count($query->result());
			$arr['ndata'] = $ndata;

			$this->db->select('*');
			$this->db->from('Hospital');
      if (!empty($state)) $this->db->where('State', $state);
      if (!empty($city)) $this->db->where('City', $city);
			if (!empty($ndata)) $this->db->limit($ndata, ($page-1)*$ndata);
			if (!empty($order)) $this->db->order_by($order, $ascdesc);
			$query = $this->db->get();

			$arr['nrows'] = count($query->result());
			$arr['npage'] = $ndata > 0 ? ceil($arr['totaldata'] / $ndata) : 1;
			$arr['page'] = $page;
			$arr['results'] = $query->result();

			return $arr;
		}
		else
			return array('status' => '0', "msg" => "mysql ".$this->db->_error_number()." ".$this->db->_error_message());
  }

  public function selectbenefit(){
    $this->db->distinct();
    $this->db->select('benefit_header.NO_MEMBER, benefit_header.MEMBER_NM, benefit_header.COMPANY_NM, benefit_detail.MAX_COVER, benefit_detail.BENEF_DSC, benefit_detail.LIMIT_MAX, benefit_detail.SATUAN');
    $this->db->from('benefit_header');
    $this->db->join('benefit_detail', 'benefit_header.NO_MEMBER = benefit_detail.MEMBER_ID');
    $this->db->where('benefit_header.CARD_NO', '1020151160000021');
    $this->db->where('benefit_detail.TAHUN', '2017');
    $this->db->where('benefit_detail.BENEF_CD', 'H10');
    $query = $this->db->get();
    // return $this->db->last_query();
    return $query->result();
  }

  public function selectbenefitwhere($card_no, $uw_year, $cover_type){    
    $this->db->distinct();
    $this->db->select('benefit_header.NO_MEMBER, benefit_header.MEMBER_NM, benefit_header.COMPANY_NM, benefit_detail.MAX_COVER, benefit_detail.BENEF_DSC, benefit_detail.LIMIT_MAX, benefit_detail.SATUAN, benefit_detail.COVER_TYPE');
    $this->db->from('benefit_header');
    $this->db->join('benefit_detail', 'benefit_header.NO_MEMBER = benefit_detail.MEMBER_ID');
    if (!empty($card_no)) $this->db->where('benefit_header.CARD_NO', $card_no);
    if (!empty($uw_year)) $this->db->where('benefit_detail.TAHUN', $uw_year);
    if (!empty($cover_type)) $this->db->where('benefit_detail.COVER_TYPE', $cover_type);
    $this->db->order_by('benefit_detail.BENEF_DSC', 'asc');
    $query = $this->db->get();
    // return $this->db->last_query();
    return $query->result();
  }

  public function selectklaim(){
    $this->db->distinct();
    $this->db->select('claim_header.ADMISON_DATE, claim_header.MEMBER_NM, claim_header.DIAGNOSIS_CODE, claim_header.DIAGNOSIS_DESC, claim_header.AMT_INCURED, claim_header.AMT_APROVE, claim_detail.BENEFIT_CODE, claim_detail.BENEFIT_DSC');
    $this->db->from('claim_header');
    $this->db->join('claim_detail', 'claim_header.CLAIM_NO = claim_detail.CLAIM_NO');
    $this->db->where('claim_header.MEMBER_ID', '717005200010');
    $query = $this->db->get();
    // return $this->db->last_query();
    return $query->result();
  }

  public function selectklaimwhere($no_member, $uw_year, $cover_type){
    $query = $this->db->select('a.admison_date as ADMISON_DATE, TRIM(a.diagnosis_desc) AS DIAGNOSIS_DESC, TRIM(b.benefit_dsc) AS BENEFIT_DSC, b.amt_incured AS AMT_INCURED, b.amt_approv AS AMT_APROVE, b.not_approv AS NOT_APPROVE');
		$query = $this->db->from('claim_header AS a');
    $query = $this->db->join('claim_detail AS b', 'a.CLAIM_NO = b.CLAIM_NO');
    $this->db->where('a.claim_no = b.claim_no');
    $this->db->where('a.ref_no = b.ref_no');
    if (!empty($no_member)) $this->db->where('a.MEMBER_ID', $no_member);
    if (!empty($uw_year)) $this->db->where('a.UW_YEAR', $uw_year);
    if (!empty($cover_type)) $this->db->where('a.COVERAGE_TYPE', $cover_type);

    $query = $this->db->get();
    // return $this->db->last_query();
    return $query->result();
    // if ($query)
    // {
    //   $arr['totaldata'] = count($query->result());
    //   $arr['ndata'] = $ndata;

    //   $this->db->select('*');
    //   $this->db->from('Hospital');
    //   if (!empty($id)) $this->db->where('HospitalID', $id);
    //   if (!empty($ndata)) $this->db->limit($ndata, ($page-1)*$ndata);
    //   if (!empty($order)) $this->db->order_by($order, $ascdesc);
    //   $query = $this->db->get();

    //   $arr['nrows'] = count($query->result());
    //   $arr['npage'] = $ndata > 0 ? ceil($arr['totaldata'] / $ndata) : 1;
    //   $arr['page'] = $page;
    //   $arr['results'] = $query->result();

    //   return $arr;
    // }
    // else
		//   return array('status' => '0', "msg" => "mysql ".$this->db->_error_number()." ".$this->db->_error_message());
    // $this->db->select('b.COMPANY_NM, c.MEMBER_NM');
    // $this->db->from('benefit_header as b');
    // $this->db->join('claim_header as c','b.NO_MEMBER = c.MEMBER_ID');
    // $this->db->where('b.NO_MEMBER',$id);
    // $this->db->limit(10,20);
    // $query = $this->db->get();
    // return $query->result();
  }

  public function selectcompany(){
    $this->db->distinct();
    $this->db->select("NO_PLS, COMPANY_NM");
    $this->db->from('benefit_header');
    $query = $this->db->get();
    return $query->result();
  }

  public function selectcompanywhere($id){
    $this->db->distinct();
    $this->db->select("NO_PLS, COMPANY_NM");
    $this->db->from('benefit_header');
    $this->db->where('NO_PLS',$id);
    $query = $this->db->get();
    return $query->row();
  }

  public function selectsaldo(){
    $this->db->distinct();
    $this->db->select('claim_header.POLICY_NO, claim_header.MEMBER_NM, claim_header.DIAGNOSIS_CODE, claim_header.DIAGNOSIS_DESC, claim_header.AMT_INCURED, claim_header.AMT_APROVE, claim_detail.BENEFIT_CODE, claim_detail.BENEFIT_DSC');
    $this->db->from('claim_header');
    $this->db->join('claim_detail', 'claim_header.CLAIM_NO = claim_detail.CLAIM_NO');
    $this->db->where('claim_header.MEMBER_ID', '717005200010');
    $query = $this->db->get();
    // return $this->db->last_query();
    return $query->result();
  }

  public function selectsaldowhere($no_member, $uw_year, $cover_type, $page=1, $ndata=0){
    $query = $this->db->select('a.member_nm, a.'.$cover_type.', a.'.$cover_type.'_limit AS YEAR_LIMIT, a.'.$cover_type.'_limit - SUM(b.amt_aprove) AS SALDO');
    $query = $this->db->from('benefit_header a');
    $query = $this->db->join('claim_header b', 'a.NO_MEMBER = b.MEMBER_ID');

    $where1 = "a.no_pls = b.Policy_no";
    $this->db->where($where1);

    $where2 = "a.no_member = b.member_id";
    $this->db->where($where2);

    $where3 = "a.$cover_type = b.plan_id";
    $this->db->where($where3);

    $where4 = "a.$cover_type IS NOT NULL";
    $this->db->where($where4);

    $where5 = "b.claim_sts = 'PAID'";
    $this->db->where($where5);

    $where6 = "a.no_member = $no_member";
    $this->db->where($where6);

    $this->db->group_by(array("a.$cover_type", "b.Policy_no", "b.member_id", "b.plan_id")); 
    $query = $this->db->get();
    // return $this->db->last_query();
    if ($query)
    {
      $arr['totaldata'] = count($query->result());
      $arr['ndata'] = $ndata;

      $query = $this->db->select('a.member_nm, a.'.$cover_type.', a.'.$cover_type.'_limit AS YEAR_LIMIT, a.'.$cover_type.'_limit - SUM(b.amt_aprove) AS SALDO');
      $query = $this->db->from('benefit_header a');
      $query = $this->db->join('claim_header b', 'a.NO_MEMBER = b.MEMBER_ID');

      $where1 = "a.no_pls = b.Policy_no";
      $this->db->where($where1);

      $where2 = "a.no_member = b.member_id";
      $this->db->where($where2);

      $where3 = "a.$cover_type = b.plan_id";
      $this->db->where($where3);

      $where4 = "a.$cover_type IS NOT NULL";
      $this->db->where($where4);

      $where5 = "b.claim_sts = 'PAID'";
      $this->db->where($where5);

      $where6 = "a.no_member = $no_member";
      $this->db->where($where6);

      $this->db->group_by(array("a.$cover_type", "b.Policy_no", "b.member_id", "b.plan_id")); 
      // $query = $this->db->get();
      if (!empty($ndata)) $this->db->limit($ndata, ($page-1)*$ndata);
      if (!empty($order)) $this->db->order_by($order, $ascdesc);
      $query = $this->db->get();
      // return $this->db->last_query();

      $arr['nrows'] = count($query->result());
      $arr['npage'] = $ndata > 0 ? ceil($arr['totaldata'] / $ndata) : 1;
      $arr['page'] = $page;
      $arr['results'] = $query->result();

      return $arr;
    }
    else
      return array('status' => '0', "msg" => "mysql ".$this->db->_error_number()." ".$this->db->_error_message());
  }  

  public function selectstate(){
    $this->db->distinct();
    $this->db->select('state');
    $this->db->from('Hospital');
    $this->db->order_by('state', 'asc');
    $query = $this->db->get();    
    return $query->result();
  }

  public function selectstatewhere($id){
    $this->db->distinct();
    $this->db->select('City');
    $this->db->from('Hospital');
    $this->db->where('State', $id);
    $this->db->order_by('City', 'asc');
    $query = $this->db->get();
    return $query->result();
  }
}