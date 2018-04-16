<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/Restdata.php';

class Apisaldocontroller extends Restdata{

  public function __construct(){
    parent::__construct();
    $this->load->model('mymodel');
    //mengecek token pada class Restdata, di mana jika token invalid maka akan melakukan exit
    // $this->cektoken();
    $this->ndata = isset($_GET["ndata"]) ? $this->input->get("ndata") : 0;
		$this->page = isset($_GET["page"]) ? $this->input->get("page") : 0;
  }

  function saldo_get(){
    $no_member = (string) $this->get('no_member',TRUE);
    // echo $no_member; die;
    $uw_year = (int) $this->get('uw_year',TRUE);
    $cover_type = (string) $this->get('cover_type',TRUE);
    //jika user menambahkan id maka akan di select berdasarkan id, jika tidak maka akan di select seluruhnya
    // $data = ($no_member) ? $this->mymodel->selectsaldowhere($no_member, $uw_year, $cover_type) : $this->mymodel->selectsaldo();
    $data = (!empty($this->ndata)) ? $this->mymodel->selectsaldowhere($no_member, $uw_year, $cover_type, $this->ndata, $this->page) : $this->mymodel->selectsaldo($no_member);


    if ($data) {
      //mengembalikan respon http ok 200 dengan data dari select di atas
      $this->response($data,Restdata::HTTP_OK);
    }else {
        $this->notfound('Data saldo Tidak Di Temukan');

    }

  }
}
