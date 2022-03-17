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
        $jwt = new JWT();
        $JwtSecretKey = "Mysecretwordshere";
        $userName = $this->post('username');
        $password = sha1($this->post('password'));
        $supervisor = new ApiLoginModel;
        $supervisor_info = $supervisor->get_supervisor($userName, $password);
        if (!empty($supervisor_info)) {
            $data = array(
                'supervisor_id' => $supervisor_info[0]['id'],
                'site' => $supervisor_info[0]['site'],
                'supervisor_name' => $supervisor_info[0]['fname'] . ' ' . $supervisor_info[0]['lname'],
                'username' => $supervisor_info[0]['username'],
                'contact' => $supervisor_info[0]['contact'],
                'role' => $supervisor_info[0]['role'],
                'status' => $supervisor_info[0]['status'],
            );

            $token = $jwt->encode($data, $JwtSecretKey, 'HS256');
            $site = $this->db->select('*')->where('id', $supervisor_info[0]['site'])->get('sites')->result_array();
            // echo "<pre>";
            // print_r($site);
            // exit;
            $locations = $this->db->select('*')->where('site', $supervisor_info[0]['site'])->get('locations')->result_array();
            $resp = array(
                'token' => $token,
                'site_id' => $site[0]['id'],
                'site_name' => $site[0]['name'],
                // 'locations' => $locations,
            );
            // echo "<pre>";
            // print_r($resp);
            // exit;
            // $this->session->sess_destroy();
            $this->session->set_userdata('supervisor_id', $supervisor_info[0]['id']);
            $this->session->set_userdata('fname', $supervisor_info[0]['fname']);
            $this->session->set_userdata('lname', $supervisor_info[0]['lname']);
            $this->session->set_userdata('role', $supervisor_info[0]['role']);
            $this->session->set_userdata('site', $supervisor_info[0]['site']);
            $this->session->set_userdata('access_token', $token);
            // $this->response($token, 200);
            $this->response($resp, 200);
            // $this->response($token, 200);
        } else {
            $this->response(['status' => FALSE, 'message' => 'No User Found.'], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
