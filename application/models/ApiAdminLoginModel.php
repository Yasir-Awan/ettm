<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ApiAdminLoginModel extends CI_Model
{
    public function get_admin($userName, $password)
    {
        $query = $this->db->get_where('admin', array('username' => $userName, 'password' => $password));
        return $query->result_array();
    }
}
