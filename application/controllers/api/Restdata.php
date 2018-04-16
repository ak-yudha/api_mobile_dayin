<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

//uncomment di bawah ini atau gunakan autoload yang di config->config->composer_autoload default ada di composer_autoload
//require_once FCPATH . 'vendor/autoload.php';

use Restserver\Libraries\REST_Controller;

use \Firebase\JWT\JWT;

class Restdata extends REST_Controller{

  private $secretkey = 'ini rahasia untuk encode dan decode';

  public function __construct(){
    parent::__construct();
    $this->load->library('form_validation');
  }


  //method untuk not found 404
  public function notfound($pesan){

    $this->response([
      'status'=>FALSE,
      'message'=>$pesan
    ],REST_Controller::HTTP_NOT_FOUND);

  }

  //method untuk bad request 400
  public function badreq($pesan){
    $this->response([
      'status'=>FALSE,
      'message'=>$pesan
    ],REST_Controller::HTTP_BAD_REQUEST);
  }

  //method untuk melihat token pada user
  public function viewtoken_post(){
    $this->load->model('loginmodel');

    $date = new DateTime();

    $nama = $this->post('nama',TRUE);
    $pass = $this->post('password',TRUE);

    $dataadmin = $this->loginmodel->is_valid($nama);
    // print_r($dataadmin); die;
    if ($dataadmin) {      
      if (password_verify($pass,$dataadmin->password)) {      
          
        $payload['id'] = $dataadmin->id;
        $payload['nama'] = $dataadmin->nama;
        $payload['iat'] = $date->getTimestamp(); //waktu di buat
        $payload['exp'] = $date->getTimestamp() + 2629746; //satu bulan

        $output['nama'] = $dataadmin->MEMBER_NM;
        $output['no_card'] = $dataadmin->no_card;
        $output['no_member'] = $dataadmin->NO_MEMBER;
        $output['underwritin_year'] = $dataadmin->UW_YEAR;
        $output['expired_date'] = $dataadmin->EXPIRED_DT;
        $output['id_no_pls'] = $dataadmin->id_no_pls;
        $output['id_token'] = JWT::encode($payload,$this->secretkey);
        // print_r($this->response($output,REST_Controller::HTTP_OK));  
        $this->response($output,REST_Controller::HTTP_OK);

      }else {

        $this->viewtokenfail();

      }

    }else {
      $this->viewtokenfail();
    }

  }

  //method untuk jika view token diatas fail
  public function viewtokenfail(){
    // $output['id_token'] = 'failed';
    // $this->response($output);
    $this->response([
      'status'=>FALSE,
      // 'nama'=>$nama,
      // 'password'=>$pass,
      'message'=>'Invalid Credentials!!'
      ],REST_Controller::HTTP_BAD_REQUEST);
  }

//method untuk mengecek token setiap melakukan post, put, etc
  public function cektoken(){
    $this->load->model('loginmodel');
    $jwt = $this->input->get_request_header('Authorization');

    try {

      $decode = JWT::decode($jwt,$this->secretkey,array('HS256'));
      //melakukan pengecekan database, jika nama tersedia di database maka return true
      if ($this->loginmodel->is_valid_num($decode->nama)>0) {
        return true;
      }

    } catch (Exception $e) {
      exit('Wrong Token');
    }


  }




}
