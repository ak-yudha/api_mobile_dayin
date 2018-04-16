<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/Restdata.php';

class Apistatecontroller extends Restdata{

  public function __construct(){
    parent::__construct();
    $this->load->model('mymodel');    
  }

  function state_get(){

    $id = (string) $this->get('id',TRUE);
    //jika user menambahkan id maka akan di select berdasarkan id, jika tidak maka akan di select seluruhnya
    $data = ($id) ? $this->mymodel->selectstatewhere($id) : $this->mymodel->selectstate();

    if ($data) {
      //mengembalikan respon http ok 200 dengan data dari select di atas
      $this->response($data,Restdata::HTTP_OK);
    }else {
        $this->notfound('Data Rumah Sakit Tidak Di Temukan');

    }

  }
}
