<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class ApiItemRepairStandardController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index_post($company_type)
    {
        if ($company_type == 1) {

            $id_no = $this->input->post('identification_no');
            $date = date("Y-m-d H:i:s");
            $install = $this->db->get_where('installed_inventory', array('identification_no' => $id_no))->result_array();
            $asset = $this->db->get_where('assets', array('id' => $install[0]['asset_id']))->result_array();

            $installing_data = array(
                'transaction_type' => "4",
                'user_type' => "2",
                'user_name' => $this->input->post('supervisor_id'),
                'action_date' => $date,
            );
            $this->db->where('id', $id_no);
            $this->db->update('installed_inventory', $installing_data);

            if ($install[0]['have_sub_items'] == 1) {
                $subitems = $this->db->get_where('installed_subitems', array('installed_id' => $install[0]['id']))->result_array();
                foreach ($subitems as $subasset) {

                    $assets_data = array('action_status' => '4');
                    $this->db->where('set_no', $asset[0]['set_no']);
                    $this->db->update('assets', $assets_data);

                    $installing_subitem_data = array(
                        'transaction_type' => 4,
                        'company_type' => '1',
                        'company_name' => $this->input->post('repairing_tsp'),
                        'company_address' => $this->input->post('tsp_address'),
                        'company_person_type' => $this->input->post('tsp_person_type'),
                        'person_name' => $this->input->post('tsp_person'),
                        'person_contact' => $this->input->post('tsp_person_contact'),
                        'faulty_time_omc' => '',
                        'faulty_date' => '',
                        'est_cost' => '',
                        'comments' => $this->input->post('start_repair_reason'),
                        'action_by_user_type' => "1",
                        'action_by_user' => $this->session->userdata('adminid'),
                        'action_date' => $date,
                    );
                    $this->db->where('id', $subasset['id']);
                    $this->db->update('installed_subitems', $installing_subitem_data);

                    $data = array(
                        'asset_id' => $install[0]['asset_id'],
                        'installed_id' => $install[0]['id'],
                        'installed_subitem_id' => $subasset['id'],
                        'item_id' => $subasset['item_id'],
                        'subitem_id' => $subasset['subitem_id'],
                        'serial_no' => $subasset['serial_no'],
                        'identification_no' => $subasset['identification_no'],
                        'is_sub_item' => 1,
                        'transaction_type' => "4",
                        'route' => $subasset['route'],
                        'site' => $subasset['site'],
                        'location' => $subasset['location'],
                        'repair_type' => $this->input->post('repair_type'),
                        'available' => $this->input->post('item_availability'),
                        'user_type' => "2",
                        'added_by' => $this->input->post('supervisor_id'),
                        'action_date' => $date,
                        'organisation_type' => 1,
                        'organisation' => $this->input->post('repairing_tsp'),
                        'organisation_address' => $this->input->post('tsp_address'),
                        'repairing_person_type' => $this->input->post('tsp_person_type'),
                        'person' => $this->input->post('tsp_person'),
                        'person_contact' => $this->input->post('tsp_person_contact'),
                        'return_date' => $this->input->post('expected_completion'),
                        'action_comments' => $this->input->post('start_repair_reason'),
                    );
                    $this->db->insert('asset_transaction', $data);
                    $this->response("repairing Mode with components", 200);
                }
            }
            if ($install[0]['have_sub_items'] == 0) {
                $assets_data = array('action_status' => '4');
                $this->db->where('set_no', $asset[0]['set_no']);
                $this->db->update('assets', $assets_data);
                $data = array(
                    'asset_id' => $install[0]['asset_id'],
                    'installed_id' => $install[0]['id'],
                    'item_id' => $install[0]['name'],
                    'serial_no' => $install[0]['serial_no'],
                    'identification_no' => $install[0]['identification_no'],
                    'is_sub_item' => 0,
                    'have_sub_items' => 0,
                    'transaction_type' => "4",
                    'route' => $install[0]['route'],
                    'site' => $install[0]['site'],
                    'location' => $install[0]['location'],
                    'repair_type' => $this->input->post('repair_type'),
                    'available' => $this->input->post('item_availability'),
                    'user_type' => "2",
                    'added_by' => $this->input->post('supervisor_id'),
                    'action_date' => $date,
                    'organisation_type' => 1,
                    'organisation' => $this->input->post('repairing_tsp'),
                    'organisation_address' => $this->input->post('tsp_address'),
                    'repairing_person_type' => $this->input->post('tsp_person_type'),
                    'person' => $this->input->post('tsp_person'),
                    'person_contact' => $this->input->post('tsp_person_contact'),
                    'return_date' => $this->input->post('expected_completion'),
                    'action_comments' => $this->input->post('start_repair_reason'),
                );
                $this->db->insert('asset_transaction', $data);
                $this->response("repairing Mode item", 200);
            }
            // echo json_encode(array('response' => true, 'message' => 'Repairing Starts.', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
            exit;
        }
        if ($company_type == 2) {
            $id_no = $this->input->post('identification_no');
            $date = date("Y-m-d H:i:s");
            $install = $this->db->get_where('installed_inventory', array('identification_no' => $id_no))->result_array();
            // echo "<pre>";
            // print_r($install);
            // exit;
            $asset = $this->db->get_where('assets', array('id' => $install[0]['asset_id']))->result_array();

            $installing_data = array(
                'transaction_type' => "4",
                'user_type' => "2",
                'user_name' => $this->input->post('supervisor_id'),
                'action_date' => $date,
            );
            $this->db->where('id', $install[0]['id']);
            $this->db->update('installed_inventory', $installing_data);

            if ($install[0]['have_sub_items'] == 1) {
                $subitems = $this->db->get_where('installed_subitems', array('installed_id' => $install[0]['id']))->result_array();
                $assets_data = array('action_status' => '4');
                $this->db->where('set_no', $asset[0]['set_no']);
                $this->db->update('assets', $assets_data);
                foreach ($subitems as $subasset) {

                    $installing_subitem_data = array(
                        'transaction_type' => 4,
                        'company_type' => '2',
                        'company_name' => $this->input->post('outer_company_name'),
                        'company_address' => $this->input->post('outer_company_address'),
                        'person_name' => $this->input->post('outsider_name'),
                        'person_contact' => $this->input->post('outsider_contact'),
                        'faulty_time_omc' => '',
                        'faulty_date' => '',
                        'est_cost' => '',
                        'comments' => $this->input->post('start_repair_reason'),
                        'action_by_user_type' => "1",
                        'action_by_user' => $this->session->userdata('adminid'),
                        'action_date' => $date,
                    );
                    $this->db->where('id', $subasset['id']);
                    $this->db->update('installed_subitems', $installing_subitem_data);

                    $data = array(
                        'asset_id' => $install[0]['asset_id'],
                        'installed_id' => $install[0]['id'],
                        'installed_subitem_id' => $subasset['id'],
                        'item_id' => $subasset['item_id'],
                        'subitem_id' => $subasset['subitem_id'],
                        'serial_no' => $subasset['serial_no'],
                        'identification_no' => $subasset['identification_no'],
                        'is_sub_item' => 1,
                        'transaction_type' => "4",
                        'route' => $subasset['route'],
                        'site' => $subasset['site'],
                        'location' => $subasset['location'],
                        'repair_type' => $this->input->post('repair_type'),
                        'available' => $this->input->post('item_availability'),
                        'user_type' => "2",
                        'added_by' => $this->input->post('supervisor_id'),
                        'action_date' => $date,
                        'organisation_type' => 2,
                        'organisation' => $this->input->post('outer_company_name'),
                        'organisation_address' => $this->input->post('outer_company_address'),
                        'person' => $this->input->post('outsider_name'),
                        'person_contact' => $this->input->post('outsider_contact'),
                        'return_date' => $this->input->post('expected_completion'),
                        'action_comments' => $this->input->post('start_repair_reason'),
                    );
                    $this->db->insert('asset_transaction', $data);
                    $this->response("repairing Mode item with components", 200);
                }
            }
            if ($install[0]['have_sub_items'] == 0) {

                $assets_data = array('action_status' => '4');
                $this->db->where('set_no', $asset[0]['set_no']);
                $this->db->update('assets', $assets_data);
                $data = array(
                    'asset_id' => $install[0]['asset_id'],
                    'installed_id' => $install[0]['id'],
                    'item_id' => $install[0]['name'],
                    'serial_no' => $install[0]['serial_no'],
                    'identification_no' => $install[0]['identification_no'],
                    'is_sub_item' => 0,
                    'have_sub_items' => 0,
                    'transaction_type' => "4",
                    'route' => $install[0]['route'],
                    'site' => $install[0]['site'],
                    'location' => $install[0]['location'],
                    'repair_type' => $this->input->post('repair_type'),
                    'available' => $this->input->post('item_availability'),
                    'user_type' => "2",
                    'added_by' => $this->input->post('supervisor_id'),
                    'action_date' => $date,
                    'organisation_type' => 2,
                    'organisation' => $this->input->post('outer_company_name'),
                    'organisation_address' => $this->input->post('outer_company_address'),
                    'person' => $this->input->post('outsider_name'),
                    'person_contact' => $this->input->post('outsider_contact'),
                    'return_date' => $this->input->post('expected_completion'),
                    'action_comments' => $this->input->post('start_repair_reason'),
                );
                $this->db->insert('asset_transaction', $data);
                $this->response("repairing Mode item", 200);
            }

            // echo json_encode(array('response' => true, 'message' => 'Repairing Starts.', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
            exit;
        }
    }
}
