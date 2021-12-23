<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class ApiItemRetireController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index_post($id)
    {
        if ($id) {

            $installed_inventory = $this->db->get_where('installed_inventory', array('id' => $id))->result_array();
            $assets = $this->db->get_where('assets', array('id' => $installed_inventory[0]['asset_id']))->result_array();

            $date = date("Y-m-d H:i:s");
            $installing_data = array(
                'transaction_type' => "6",
                'user_type' => "1",
                'user_name' => $this->input->post('supervisor_id'),
                'action_date' => $date,
            );
            $this->db->where('id', $id);
            $this->db->update('installed_inventory', $installing_data);

            $assets_data = array('action_status' => '6');
            $this->db->where('set_no', $assets[0]['set_no']);
            $this->db->update('assets', $assets_data);

            if ($installed_inventory[0]['have_sub_items'] == 1) {
                $subitems = $this->db->get_where('installed_subitems', array('installed_id' => $installed_inventory[0]['id']))->result_array();
                foreach ($subitems as $subasset) {
                    $installing_subitem_data = array(
                        'transaction_type' => 6,
                        'action_by_user_type' => "2",
                        'action_by_user' => $this->input->post('supervisor_id'),
                        'action_date' => $date,
                        'comments' => $this->input->post('retire_reason'),
                    );
                    $this->db->where('id', $subasset['id']);
                    $this->db->update('installed_subitems', $installing_subitem_data);

                    $this->db->where('identification_no', $subasset['identification_no']);
                    $this->db->delete('faulty_equipment_list');

                    $data = array(
                        'asset_id' => $subasset['asset_id'],
                        'installed_id' => $id,
                        'installed_subitem_id' => $subasset['id'],
                        'item_id' => $subasset['item_id'],
                        'subitem_id' => $subasset['subitem_id'],
                        'serial_no' => $subasset['serial_no'],
                        'identification_no' => $subasset['identification_no'],
                        'is_sub_item' => 1,
                        'transaction_type' => "6",
                        'action_date' => $date,
                        'retire_type' => $this->input->post('retire_type'),
                        'route' => $subasset['route'],
                        'site' => $subasset['site'],
                        'retire_date' => $this->input->post('retire_date'),
                        'action_comments' => $this->input->post('retire_reason')
                    );
                    $this->db->insert('asset_transaction', $data);
                    $this->response('item with components retire!', 200);
                }
            }
            if ($installed_inventory[0]['have_sub_items'] == 0) {
                $this->db->where('identification_no', $installed_inventory[0]['identification_no']);
                $this->db->delete('faulty_equipment_list');

                $data = array(
                    'installed_id' => $id,
                    'asset_id' => $installed_inventory[0]['asset_id'],
                    'item_id' => $installed_inventory[0]['name'],
                    'serial_no' => $installed_inventory[0]['serial_no'],
                    'identification_no' => $installed_inventory[0]['identification_no'],
                    'transaction_type' => "6",
                    'retire_type' => $this->input->post('retire_type'),
                    'route' => $installed_inventory[0]['route'],
                    'site' => $installed_inventory[0]['site'],
                    'retire_date' => $this->input->post('retire_date'),
                    'user_type' => "2",
                    'added_by' => $this->input->post('supervisor_id'),
                    'action_date' => $date,
                    'action_comments' => $this->input->post('retire_reason')
                );
                $this->db->insert('asset_transaction', $data);
                $this->response('item retire!', 200);
            }
        } else {
            $this->response('record not found', 404);
        }
    }
}
