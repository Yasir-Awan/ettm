<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class ApiItemFaultyController extends REST_Controller
{
    public function __construct()
    {
        // if (!$this->session->userdata('supervisor_id')) {
        //     return redirect('api/ApiLoginController/index');
        // }
        parent::__construct();
        // $this->load->model('ApiItemFaultyModel');
    }
    public function index_post($id)
    {

        $headers = apache_request_headers();
        $head = explode(" ", $headers['Authorization']);
        // echo "<pre>";
        // print_r($head);
        // exit;

        $token = $head[1];
        if ($token == $this->session->userdata('access_token')) {

            if ($id) {
                $identification_no = $this->post('identification_no');
                $supervisor_id = $this->post('supervisor_id');
                $installed_items = $this->db->get_where('installed_inventory', array('identification_no' => $identification_no))->result_array();

                $faulty_time_omc = $this->post('faulty_time_omc');
                $faulty_date = $this->post('faulty_date');
                $est_cost = $this->post('est_cost');
                $comments = $this->post('comments');
                $serial_no = $installed_items[0]['serial_no'];
                $route = $installed_items[0]['route'];
                $item_id = $installed_items[0]['name'];
                $person_type = $installed_items[0]['company_person_type'];
                $person = $installed_items[0]['person_name'];
                $asset_id = $installed_items[0]['asset_id'];

                $site = $installed_items[0]['site'];
                $location = $installed_items[0]['location'];
                $have_subitems = $installed_items[0]['have_sub_items'];

                $date = date("Y-m-d H:i:s");

                if ($have_subitems == 1) {
                    $subitems = $this->db->get_where('installed_subitems', array('installed_id' => $id))->result_array();
                    $asset = $this->db->get_where('assets', array('id' => $subitems[0]['asset_id']))->result_array();
                    $asset_data = array(
                        'action_status' => "10",
                        // 'user_type' => "2",
                        // 'checkin_by' => $this->session->userdata('supervisor_id'),
                        // 'add_date' => time(),
                    );
                    $this->db->where('set_no', $asset[0]['set_no']);
                    $this->db->update('assets', $asset_data);
                    $overAllEstCost = "Overall Estimate Cost of Equipment," . $est_cost;
                    foreach ($subitems as $subasset) {

                        $installing_data = array(
                            'transaction_type' => "10",
                            'subitem_id' => $subasset['subitem_id'],
                            // 'company_type' => '',
                            // 'company_name' => '',
                            // 'company_address' => '',
                            // 'company_person_type' => '',
                            // 'person_name' => '',
                            // 'person_contact' => '',
                            'faulty_time_omc' => $faulty_time_omc,
                            'faulty_date' => $faulty_date,
                            'est_cost' => $est_cost,
                            'user_type' => "2",
                            'user_name' => $supervisor_id,
                            'action_date' => $date,
                        );
                        $this->db->where('id', $id);
                        $this->db->update('installed_inventory', $installing_data);

                        $installing_subitem_data = array(
                            'transaction_type' => 10,
                            // 'company_type' => '',
                            // 'company_name' => '',
                            // 'company_address' => '',
                            // 'company_person_type' => '',
                            // 'person_name' => '',
                            // 'person_contact' => '',
                            'faulty_time_omc' => $faulty_time_omc,
                            'faulty_date' => $faulty_date,
                            'est_cost' => $overAllEstCost,
                            'comments' => $comments,
                            'action_by_user_type' => "2",
                            'action_by_user' => $supervisor_id,
                            'action_date' => $date,
                        );
                        $this->db->where('id', $subasset['id']);
                        $this->db->update('installed_subitems', $installing_subitem_data);

                        $faulty_data = array(
                            'asset_id' => $subasset['asset_id'],
                            'installed_id' => $subasset['installed_id'],
                            'subitem_id' => $subasset['subitem_id'],
                            'serial_no' => $subasset['serial_no'],
                            'identification_no' => $subasset['identification_no'],
                            'item_id' => $subasset['item_id'],
                            'is_sub_item' => 1,
                            'installed_subitem_id' => $subasset['id'],
                            'route' => $subasset['route'],
                            'site' => $subasset['site'],
                            'location' => $subasset['location'],
                            'faulty_time_omc' => $faulty_time_omc,
                            'faulty_date' => $faulty_date,
                            'est_cost' => $overAllEstCost,
                            'comments' => $comments,
                        );
                        $this->db->insert('faulty_equipment_list', $faulty_data);

                        $asset_transaction_data = array(
                            'installed_id' => $id,
                            'item_id' => $subasset['item_id'],
                            'subitem_id' => $subasset['subitem_id'],
                            'serial_no' => $subasset['serial_no'],
                            'identification_no' => $subasset['identification_no'],
                            'is_sub_item' => 1,
                            'installed_subitem_id' => $subasset['id'],
                            'asset_id' => $subasset['asset_id'],
                            'transaction_type' => "10",
                            'route' => $subasset['route'],
                            'site' => $subasset['site'],
                            'location' => $subasset['location'],
                            'faulty_time_omc' => $faulty_time_omc,
                            'faulty_date' => $faulty_date,
                            'estimated_cost' => $overAllEstCost,
                            'user_type' => "2",
                            'added_by' => $supervisor_id,
                            'action_date' => $date,
                            'action_comments' => $comments,
                        );
                        $this->db->insert('asset_transaction', $asset_transaction_data);
                        $this->response('faulty done', 200);
                    }
                }
                if ($have_subitems == 0) {

                    $asset_data = array(
                        'action_status' => "10",
                        // 'user_type' => "2",
                        // 'checkin_by' => $this->session->userdata('supervisor_id'),
                        // 'add_date' => time(),
                    );
                    $this->db->where('id', $asset_id);
                    $this->db->update('assets', $asset_data);

                    $installing_data = array(
                        'transaction_type' => "10",
                        // 'company_type' => '',
                        // 'company_name' => '',
                        // 'company_address' => '',
                        // 'company_person_type' => '',
                        // 'person_name' => '',
                        // 'person_contact' => '',
                        'faulty_time_omc' => $faulty_time_omc,
                        'faulty_date' => $faulty_date,
                        'est_cost' => $est_cost,
                        'user_type' => "2",
                        'user_name' => $this->session->userdata('supervisor_id'),
                        'action_date' => $date,
                    );
                    $this->db->where('id', $id);
                    $this->db->update('installed_inventory', $installing_data);

                    $faulty_data = array(
                        'asset_id' => $asset_id,
                        'installed_id' => $id,
                        'item_id' => $item_id,
                        'serial_no' => $serial_no,
                        'identification_no' => $identification_no,
                        'is_sub_item' => $have_subitems,
                        'route' => $route,
                        'site' => $site,
                        'location' => $location,
                        'faulty_time_omc' => $faulty_time_omc,
                        'faulty_date' => $faulty_date,
                        'est_cost' => $est_cost,
                        'comments' => $comments,
                    );
                    $this->db->insert('faulty_equipment_list', $faulty_data);

                    $asset_transaction_data = array(
                        'installed_id' => $id,
                        'item_id' => $item_id,
                        'serial_no' => $serial_no,
                        'identification_no' => $identification_no,
                        'asset_id' => $asset_id,
                        'have_sub_items' => $have_subitems,
                        'transaction_type' => "10",
                        'route' => $route,
                        'site' => $site,
                        'location' => $location,
                        'faulty_time_omc' => $faulty_time_omc,
                        'faulty_date' => $faulty_date,
                        'estimated_cost' => $est_cost,
                        'user_type' => 2,
                        'added_by' => $person,
                        'action_date' => $date,
                        'action_comments' => $comments,
                    );
                    $this->db->insert('asset_transaction', $asset_transaction_data);
                    $this->response('updated status', 200);
                    echo json_encode(array('response' => TRUE, 'message' => 'Added Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'supervisor_inventory/first_page'));
                    exit;
                }
            }
        } else {
            $this->response('Unauthorized Access', 401);
            echo json_encode(array('respose' => FALSE, 'message' => 'Unauthorized Access'));
            exit;
        }
    }
}
