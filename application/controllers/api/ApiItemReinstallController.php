<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class ApiItemReinstallController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index_post($id)
    {
        if ($id) {
            $unit_repair_cost = $this->input->post('repair_price') / $this->input->post('quantity');
            $last_transaction_data = $this->db->select('*')->order_by('id', 'desc')->limit(1)->get_where('asset_transaction', array('installed_id' => $id, 'transaction_type' => 4))->result_array();
            $assets = $this->db->get_where('assets', array('id' => $last_transaction_data[0]['asset_id']))->result_array();
            $date = date("Y-m-d H:i:s");

            $installing_data = array(
                'transaction_type' => "9",
                'user_type' => "2",
                'user_name' => $this->input->post('supervisor_id'),
                'action_date' => $date,
            );
            $this->db->where('id', $id);
            $this->db->update('installed_inventory', $installing_data);

            if ($last_transaction_data[0]['is_sub_item'] == 1) {
                $subitems = $this->db->get_where('installed_subitems', array('installed_id' => $last_transaction_data[0]['installed_id']))->result_array();
                $assets_data = array('action_status' => '9');
                $this->db->where('set_no', $assets[0]['set_no']);
                $this->db->update('assets', $assets_data);

                foreach ($subitems as $subasset) {
                    $installing_subitem_data = array(
                        'transaction_type' => 9,
                        'company_type' => $subasset['company_type'],
                        'company_name' => $subasset['company_name'],
                        'company_address' => $subasset['company_address'],
                        'company_person_type' => $subasset['company_person_type'],
                        'person_name' => $subasset['person_name'],
                        'person_contact' => $subasset['person_contact'],
                        'faulty_time_omc' => '',
                        'faulty_date' => '',
                        'est_cost' => '',
                        'comments' => $this->input->post('end_repair_comments'),
                        'action_by_user_type' => "2",
                        'action_by_user' => $this->input->post('supervisor_id'),
                        'action_date' => $date,
                    );
                    $this->db->where('id', $subasset['id']);
                    $this->db->update('installed_subitems', $installing_subitem_data);

                    $this->db->where('identification_no', $subasset['identification_no']);
                    $this->db->delete('faulty_equipment_list');

                    $data = array(
                        'asset_id' => $subasset['asset_id'],
                        'installed_id' => $subasset['installed_id'],
                        'installed_subitem_id' => $subasset['id'],
                        'item_id' => $subasset['item_id'],
                        'subitem_id' => $subasset['subitem_id'],
                        'serial_no' => $subasset['serial_no'],
                        'identification_no' => $subasset['identification_no'],
                        'unit_repairing_cost' => $this->input->post('repair_price'),
                        'organisation_type' => $subasset['company_type'],
                        'organisation' => $subasset['company_name'],
                        'organisation_address' => $subasset['company_address'],
                        'repairing_person_type' => $subasset['company_person_type'],
                        'person' => $subasset['person_name'],
                        'person_contact' => $subasset['person_contact'],
                        'is_sub_item' => 1,
                        'transaction_type' => "9",
                        'route' => $subasset['route'],
                        'site' => $subasset['site'],
                        'location' => $subasset['location'],
                        'user_type' => "2",
                        'added_by' => $this->input->post('supervisor_id'),
                        'action_date' => $date,
                        'return_date' => $this->input->post('repair_completion'),
                        'action_comments' => $this->input->post('end_repair_comments'),
                    );
                    $this->db->insert('asset_transaction', $data);
                    $this->response('reinstalled item & its Components', 200);
                }
            }
            if ($last_transaction_data[0]['is_sub_item'] == 0) {
                $this->db->where('identification_no', $last_transaction_data[0]['identification_no']);
                $this->db->delete('faulty_equipment_list');

                $data = array(
                    'asset_id' => $last_transaction_data[0]['asset_id'],
                    'installed_id' => $id,
                    'installed_subitem_id' => $last_transaction_data[0]['installed_subitem_id'],
                    'item_id' => $last_transaction_data[0]['item_id'],
                    'serial_no' => $last_transaction_data['serial_no'],
                    'identification_no' => $last_transaction_data['identification_no'],
                    'unit_repairing_cost' => $this->input->post('repair_price'),
                    'organisation_type' => $last_transaction_data['organisation_type'],
                    'organisation' => $last_transaction_data['organisation'],
                    'organisation_address' => $last_transaction_data['organisation_address'],
                    'repairing_person_type' => $last_transaction_data['repairing_person_type'],
                    'person' => $last_transaction_data['person'],
                    'person_contact' => $last_transaction_data['person_contact'],
                    'is_sub_item' => 0,
                    'transaction_type' => "9",
                    'route' => $last_transaction_data['route'],
                    'site' => $last_transaction_data['site'],
                    'location' => $last_transaction_data['location'],
                    'user_type' => "2",
                    'added_by' => $this->input->post('supervisor_id'),
                    'action_date' => $date,
                    'return_date' => $this->input->post('repair_completion'),
                    'action_comments' => $this->input->post('end_repair_comments'),
                );
                $assets_data = array('action_status' => '9');
                $this->db->where('set_no', $assets[0]['set_no']);
                $this->db->update('assets', $assets_data);
                $this->db->insert('asset_transaction', $data);
                $this->response('reinstalled item', 200);
            }
        } else {
            $this->response('record not found', 404);
        }
    }
}
