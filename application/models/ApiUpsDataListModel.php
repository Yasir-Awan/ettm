<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ApiUpsDataListModel extends CI_Model
{
    public function get_SiteInventory($site)
    {
        $query = $this->db->get_where('ups_data')->result();
        return $query;
    }
}
