<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/Restdata.php';

class Apiadmincontroller extends Restdata{

  public function __construct(){
    parent::__construct();
    $this->load->model('mymodel');
  }

  //method untuk melakukan penambahan admin (post)
  function admin_post(){    
    $data = [
      'nama'=>$this->post('nama'),
      'password'=>password_hash($this->post('password'),PASSWORD_DEFAULT),
      'no_card'=>$this->post('no_card'),
      'id_no_pls'=>$this->post('id_no_pls')
    ];

    $this->form_validation->set_rules('nama','Nama','trim|max_length[50]|is_unique[admin.nama]');
    $this->form_validation->set_rules('password','Password','trim|min_length[8]');
    $this->form_validation->set_rules('no_card','No Card','trim|min_length[5]');
    $this->form_validation->set_rules('id_no_pls','ID No PLS','trim|min_length[5]');

    if ($this->form_validation->run()==false) {

      $this->badreq($this->validation_errors());

    }else {

      $no_card = $data['no_card'];
      $result = $this->mymodel->selectnocard($no_card);
      if(empty($result)){
        $this->response([
          'message'=>'User Gagal di buat karena kesalahan pada NO. Card'
        ],Restdata::HTTP_BAD_REQUEST); 
      } else {
        // print_r($data); die;
        if ($this->mymodel->insertadmin($data)) {

          $this->response([
            'message'=>'Admin Berhasil Di Buat',
            'status'=>true
          ],Restdata::HTTP_OK);

        }else {

          $this->response([
            'message'=>'Admin Gagal Di Buat',
            'status'=>false
          ],Restdata::HTTP_BAD_REQUEST);

        }
      }
    }
  }




}
