<?php 
class Inventory_model extends CI_MODEL
{
    function __construct()
    {
		parent::__construct();	
    }
    function getsites()
    {
      $sites = $this->db->get('sites')->result_array();
      return $sites;
    }

    function asset_related_sites()
    {
      $sites = $this->db->select('*')->order_by('site','desc')->get('site_related_assets')->result_array();
      echo "<pre>"; print_r($sites); exit;
      return $sites;
    }

    function get_Items()
    {
      $items = $this->db->select('*')->order_by('id','desc')->get('items')->result_array();
      // echo "<pre>"; print_r($items); exit;
      return $items;
    }	

    function get_locations()
    {
      $locations = $this->db->get('locations')->result_array();
      return $locations;
    }	

    function get_suppliers()
    {
      $suppliers = $this->db->get('suppliers')->result_array();
      return $suppliers;
    }
    
    function get_tsps()
    {
      $tsps = $this->db->get('tsp')->result_array();
      return $tsps;
    }
    function get_manufacturers()
    {
      $manufacturers = $this->db->get('manufacturers')->result_array();
      return $manufacturers;
    }
    function get_assets()
    {
      $assets = $this->db->select('*')->order_by('add_date','desc')->get('assets')->result_array();
      
      return $assets;
    }

    function get_installed()
    {
      $installs = $this->db->select('*')->order_by('action_date','desc')->get('installed_inventory')->result_array();
      
      return $installs;
    }

    function get_installed_subitems()
    {
      $sub_installs = $this->db->select('*')->order_by('action_date','desc')->get('installed_subitems')->result_array();
      
      return $sub_installs;
    }

    function get_asset_transactions()
    {
      $asset_transactions = $this->db->get('asset_transaction')->result_array();
      
      return $asset_transactions;
    }
    function random_string($length = 10, $letters = 'q1wer23ty45uiop67lkjh89gfdsam0nbvcxz'){
      $s = '';
      $lettersLength = strlen($letters)-1;
      for($i = 0 ; $i < $length ; $i++){
          $s .= $letters[rand(0,$lettersLength)]; 
      }           
      return strtoupper($s);
  }
  
  function generate_id(){
      $s = $this->random_string(6);
      return  strtoupper($s);
  }
}