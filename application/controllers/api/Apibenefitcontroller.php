<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/Restdata.php';

class Apibenefitcontroller extends Restdata{

  public function __construct(){
    parent::__construct();
    $this->load->model('mymodel');
    //mengecek token pada class Restdata, di mana jika token invalid maka akan melakukan exit
    // $this->cektoken();
  }

  function benefit_get(){
    $card_no = (int) $this->get('card_no',TRUE);
    $uw_year = (int) $this->get('uw_year',TRUE);
    $cover_type = (string) $this->get('cover_type',TRUE);
    //jika user menambahkan id maka akan di select berdasarkan id, jika tidak maka akan di select seluruhnya
    $data = ($card_no) ? $this->mymodel->selectbenefitwhere($card_no, $uw_year, $cover_type) : $this->mymodel->selectbenefit();


    if ($data) {
      //mengembalikan respon http ok 200 dengan data dari select di atas
      $this->response($data,Restdata::HTTP_OK);
    }else {
        $this->notfound('Data Benefit Tidak Di Temukan');

    }

  }
}
