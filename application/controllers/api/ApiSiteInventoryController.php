<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class ApiSiteInventoryController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ApiSiteRelatedInventoryModel');
    }
    public function index_get($site)
    {
        if ($site) {

            $inventory = new ApiSiteRelatedInventoryModel;
            $site_inventory = $inventory->get_SiteInventory($site);

            if (!empty($site_inventory)) {
                $this->response($site_inventory, 200);
            } else {
                $this->response(['status' => FALSE, 'message' => 'Inventory Not Found.'], REST_Controller::HTTP_NOT_FOUND);
            }
        } else {
            echo "in else";
            exit;
        }
        // echo "<pre>";
        // print_r($site_inventory);
        // exit;
    }
}
