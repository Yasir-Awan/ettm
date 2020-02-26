<?php
// defined('BASEPATH') OR exit('No direct script access Allowed');
class Get_coords extends CI_Controller{
    // public function __construct()
    // {
    //     parent::__construct();
    // //     $this->load->library('form_validation');
    // //     $this->load->library('encrypt');
    // //    // $this->load->model('register_model');
    // }

    function index()
    {
       
        $this->load->view('front/road_crash/get_coords');

    }
}
?>