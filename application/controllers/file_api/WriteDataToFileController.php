<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class WriteDataToFileController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ApiAdminLoginModel');
    }
    public function index_post()
    {
        echo "yasir";
        exit;
    }
}
