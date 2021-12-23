<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class ApiLoginController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ApiLoginModel');
    }
    public function index_post()
    {
        $userName = $this->post('username');
        $password = sha1($this->post('password'));
        $supervisor = new ApiLoginModel;
        $supervisor_info = $supervisor->get_supervisor($userName, $password);
        if (!empty($supervisor_info)) {
            $this->session->set_userdata('supervisor_id', $supervisor_info[0]['id']);
            $this->session->set_userdata('fname', $supervisor_info[0]['fname']);
            $this->session->set_userdata('lname', $supervisor_info[0]['lname']);
            $this->session->set_userdata('role', $supervisor_info[0]['role']);
            $this->session->set_userdata('site', $supervisor_info[0]['site']);

            $this->response($supervisor_info, 200);
        } else {
            $this->response(['status' => FALSE, 'message' => 'No User Found.'], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
