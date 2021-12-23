<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ApiItemDetailModel extends CI_Model
{
    public function get_item_detail($id)
    {

        $query = $this->db->get_where('view_installed_inventory', array('id' => $id))->result_array();

        $asset_query = $this->db->get_where('assets', array('id' => $query[0]['asset_id']))->result_array();
        return array('inventory' => $query, 'assets' => $asset_query);
        // $query = $this->db->get_where('tpsupervisor', array('username' => $userName, 'password' => $password));
    }
}
