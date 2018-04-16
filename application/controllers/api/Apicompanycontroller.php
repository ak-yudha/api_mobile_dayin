<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/Restdata.php';

class Apicompanycontroller extends Restdata{

  public function __construct(){
    parent::__construct();
    $this->load->model('mymodel');
    //mengecek token pada class Restdata, di mana jika token invalid maka akan melakukan exit
    // $this->cektoken();
  }

  function company_get(){

    $id = (int) $this->get('id',TRUE);
    //jika user menambahkan id maka akan di select berdasarkan id, jika tidak maka akan di select seluruhnya
    $data = ($id) ? $this->mymodel->selectcompanywhere($id) : $this->mymodel->selectcompany();


    if ($data) {
      //mengembalikan respon http ok 200 dengan data dari select di atas
      $this->response($data,Restdata::HTTP_OK);
    }else {
        $this->notfound('Anggota Tidak Di Temukan');

    }

  }
}
