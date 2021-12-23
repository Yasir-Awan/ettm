<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ApiManufacturerDetailsModel extends CI_Model
{
    public function get_manufacturer_detail($id)
    {

        $query = $this->db->get_where('manufacturers', array('id' => $id))->result_array();

        return $query;
    }
}
