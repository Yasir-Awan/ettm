<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class ApiSiteLocations extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api_site_locations_model');
    }
    public function index_get($id)
    {
        // echo "yasir";
        // exit;
        $headers = apache_request_headers();

        $head = explode(" ", $headers['Authorization']);

        $token = $head[0];



        if ($token == $this->session->userdata('access_token')) {

            if ($id) {
                $locationDetail = new Api_site_locations_model;
                $location_detail = $locationDetail->get_site_locations($id);
                if (!empty($location_detail)) {
                    $this->response($location_detail, 200);
                }
            }
        } else {
            $this->response('UnAuthorized Access', 401);
        }
    }
}
