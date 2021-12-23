<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ApiSupervisorDetailsModel extends CI_Model
{
    public function get_supervisor_detail($id)
    {
        $detail = $this->db->get_where('tpsupervisor', array('id' => $id))->result_array();
        return $detail;
    }
}
