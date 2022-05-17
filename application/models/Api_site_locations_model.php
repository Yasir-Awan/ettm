<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Api_site_locations_model extends CI_Model
{
    public function get_site_locations($id)
    {
        $asset_query = $this->db->get_where('locations', array('site' => $id))->result_array();
        return $asset_query;
        // $query = $this->db->get_where('tpsupervisor', array('username' => $userName, 'password' => $password));
    }
}
