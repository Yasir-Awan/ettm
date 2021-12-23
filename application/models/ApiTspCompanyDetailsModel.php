<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ApiTspCompanyDetailsModel extends CI_Model
{
    public function get_tsp_detail($id)
    {

        $query = $this->db->get_where('tsp', array('id' => $id))->result_array();

        return $query;
    }
}
