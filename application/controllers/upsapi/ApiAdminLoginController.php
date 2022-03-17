<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class ApiAdminLoginController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ApiAdminLoginModel');
    }
    public function index_post()
    {
        $JwtSecretKey = "Mysecretwordshere";
        $userName = $this->post('username');
        $password = sha1($this->post('password'));
        $admin = new ApiAdminLoginModel;
        $admin_info = $admin->get_admin($userName, $password);
        // echo "<pre>";
        // print_r($admin_info);
        if (!empty($admin_info)) {
            $data = array(
                'admin_id' => $admin_info[0]['id'],
                'site' => $admin_info[0]['site'],
                'admin_name' => $admin_info[0]['fname'] . ' ' . $admin_info[0]['lname'],
                'username' => $admin_info[0]['username'],
                'contact' => $admin_info[0]['contact'],
                'role' => $admin_info[0]['role'],
                'status' => $admin_info[0]['status'],
            );
            $jwt = new JWT();
            $token = $jwt->encode($data, $JwtSecretKey, 'HS256');

            // $this->session->sess_destroy();
            $this->session->set_userdata('admin_id', $admin_info[0]['id']);
            $this->session->set_userdata('fname', $admin_info[0]['fname']);
            $this->session->set_userdata('lname', $admin_info[0]['lname']);
            $this->session->set_userdata('role', $admin_info[0]['role']);
            $this->session->set_userdata('site', $admin_info[0]['site']);
            $this->session->set_userdata('access_token', $token);
            // $this->response($token, 200);
            $this->response($token, 200);
            // $this->response($token, 200);
        } else {
            // echo "in else";
            // exit;
            $this->response(['status' => 401, 'message' => 'No User Found.'], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
