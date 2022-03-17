<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ApiLoginModel extends CI_Model
{
    public function get_supervisor($userName, $password)
    {
        $query = $this->db->get_where('tpsupervisor', array('username' => $userName, 'password' => $password));
        return $query->result_array();
    }
}
