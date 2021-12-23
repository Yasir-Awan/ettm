<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ApiMemberDetailsModel extends CI_Model
{
    public function get_member_detail($id)
    {
        $detail = $this->db->get_where('member', array('id' => $id))->result_array();
        return $detail;
    }
}
