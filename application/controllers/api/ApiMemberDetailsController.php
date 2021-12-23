<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class ApiMemberDetailsController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ApiAdminDetailsModel');
    }
    public function index_get($id)
    {
        if ($id) {
            $itemDetail = new ApiMemberDetailsModel;
            $item_detail = $itemDetail->get_member_detail($id);
            if (!empty($item_detail)) {
                $this->response($item_detail, 200);
            }
        } else {
            $this->response(['status' => FALSE, 'message' => 'No Record Found.'], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
