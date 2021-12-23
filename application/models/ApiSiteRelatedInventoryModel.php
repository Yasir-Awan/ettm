<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ApiSiteRelatedInventoryModel extends CI_Model
{
    public function get_SiteInventory($site)
    {
        $query = $this->db->get_where('view_installed_inventory', array('site' => $site))->result();
        return $query;
    }
}
