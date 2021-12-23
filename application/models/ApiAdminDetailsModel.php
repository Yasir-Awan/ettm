<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ApiAdminDetailsModel extends CI_Model
{
    public function get_admin_detail($id)
    {
        $detail = $this->db->get_where('admin', array('id' => $id))->result_array();
        return $detail;
    }
}
