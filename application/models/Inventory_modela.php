<?php 
class Inventory_model extends CI_MODEL
{
    function __construct()
    {
		parent::__construct();	
    }
    function getsites()
    {
      if($this->session->userdata('role')==1||$this->session->userdata('role')==2){
      $sites = $this->db->select('*')->get('sites')->result_array();
      }
    if($this->session->userdata('role')==3){
      $sites = $this->db->select('*')->where('route', 3)->get('sites')->result_array();
      }
      if($this->session->userdata('role')==4){
        $sites = $this->db->select('*')->where('route', 4)->get('sites')->result_array();
        }
      return $sites;
    }
    function GetSitesByType($para='')
    {
      if($this->session->userdata('role')==1||$this->session->userdata('role')==2){
        $sites = $this->db->get_where('sites',array('site_type'=>$para))->result_array();
      }
      if($this->session->userdata('role')==3){
        $sites = $this->db->get_where('sites',array('site_type'=>$para, 'route' => 3))->result_array();
      }
      if($this->session->userdata('role')==5){
        $sites = $this->db->get_where('sites',array('site_type'=>$para, 'route' => 5))->result_array();
      }
      return $sites;
    }
    function GetSitesWhereInventoryIsInstalled($para1)
    {
      $inventory = $this->db->select('*')->group_by('site')->get('installed_inventory')->result_array();
      $siteId = array();
      foreach($inventory as $row)
      {
        $siteId [] = $row['site'];
      }
      $site = array();
      foreach($siteId as $id)
      {
        if($para1==1){
          $site[] = $this->db->select('*')->where('id', $id)->where('site_type!=', 2)->get('sites')->result_array();
          // $this->db->get_where('sites',array('id'=>$id,'site_type' => 1))->result_array();
        }
        if($para1==2){
          $site[] = $this->db->get_where('sites',array('id'=>$id,'site_type' => 2))->result_array();
        }
      }

      $sites = array();
      foreach($site as $row){
        if(!empty($row[0]['route'])){
        if($this->session->userdata('role')==5 && $row[0]['route']==5){
          $sites[] = $row[0];
        }
        elseif($this->session->userdata('role')==3 && $row[0]['route']==3){
          $sites[] = $row[0];
        }elseif($this->session->userdata('role')==1 || $this->session->userdata('role')==2){
          $sites[] = $row[0];
        }
        else{
          $sites[] = " ";
        }
      }
      }
      return $sites;
    }
    function GetSpecificSite($para='')
    {
      $specificSite = $this->db->select('*')->where('id', $para)->get('sites')->result_array();
      return $specificSite;
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
      if($this->session->userdata('role')==3){
      $assets = $this->db->select('*')->where('route', 3)->group_by('name')->order_by('add_date','desc')->get('assets')->result_array();
      }
      if($this->session->userdata('role')==5){
        $assets = $this->db->select('*')->where('route', 5)->group_by('name')->order_by('add_date','desc')->get('assets')->result_array();
        }
      if($this->session->userdata('role')==1 || $this->session->userdata('role')==2){
        $assets = $this->db->select('*')->where('route', 1)->group_by('name')->order_by('add_date','desc')->get('assets')->result_array();
        }
      return $assets;
    }
    function getExpandedAsset($para1="")
    {
      $ast =  $this->db->select('*')->where('name', $para1)->get('assets')->result_array();
      if($this->session->userdata('role')==5){
        $expandedAssets =  $this->db->select('*')->where('route', 5)->where('name', $para1)->group_by('set_no')->order_by('add_date','desc')->get('assets')->result_array();
      }
      if($this->session->userdata('role')==3){
        $expandedAssets =  $this->db->select('*')->where('route', 3)->where('name', $para1)->group_by('set_no')->order_by('add_date','desc')->get('assets')->result_array();
      }
      if($this->session->userdata('role')==1 || $this->session->userdata('role')==2){
        $expandedAssets =  $this->db->select('*')->where('route', 1)->where('name', $para1)->group_by('set_no')->order_by('add_date','desc')->get('assets')->result_array();
      }
      return $expandedAssets;
    }

    function get_installed()
    {
      if($this->session->userdata('role')==3){
        $installs = $this->db->select('*')->where('route', 3)->order_by('action_date','desc')->get('installed_inventory')->result_array();
      }
      if($this->session->userdata('role')==5){
        $installs = $this->db->select('*')->where('route', 5)->order_by('action_date','desc')->get('installed_inventory')->result_array();
      }
      if($this->session->userdata('role')==1 || $this->session->userdata('role')==2){
        $installs = $this->db->select('*')->where('route', 1)->order_by('action_date','desc')->get('installed_inventory')->result_array();
      }
      return $installs;
    }

    function installed_inventory($para='')
    {
      if($this->session->userdata('role')==3)
      {
        $site = $this->db->get_where('sites',array('route' => 3))->result_array();
        $installs = $this->db->select('*')->where('site', $site[0]['id'])->get('installed_inventory')->result_array();
      }
      if($this->session->userdata('role')==5)
      {
        $site = $this->db->get_where('sites',array('route' => 5))->result_array();
        $installs = $this->db->select('*')->where('site', $site[0]['id'])->get('installed_inventory')->result_array();
        
      }
      if(empty($para) && $this->session->userdata('role')!=3 && $this->session->userdata('role')!=4)
      {
      $installs = $this->db->select('*')->where('site', 12)->get('installed_inventory')->result_array();
      }
      if(!empty($para))
      {
        $installs = $this->db->select('*')->where('site', $para)->get('installed_inventory')->result_array();
      }
      return $installs;
    }

    function get_installed_subitems()
    {
      if($this->session->userdata('role')==5){
        $sub_installs = $this->db->select('*')->where('route', 5)->order_by('action_date','desc')->get('installed_subitems')->result_array();
      }
      if($this->session->userdata('role')==3){
        $sub_installs = $this->db->select('*')->where('route', 3)->order_by('action_date','desc')->get('installed_subitems')->result_array();
      }
      if($this->session->userdata('role')==1|| $this->session->userdata('role')==2){
        $sub_installs = $this->db->select('*')->where('route', 1)->order_by('action_date','desc')->get('installed_subitems')->result_array();
      }
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

  function item_has_subitems_or_not($para1='')
  {
    $sub_items = $this->db->get_where('sub_items',array('item_id'=>$para1))->result_array(); 
    return $sub_items;
  }

  function getItemsBySetNo($para1='')
  {
    $items = $this->db->get_where('assets',array('set_no'=>$para1))->result_array(); 
    return $items;
  }
  function getSubItemsBySetNo($para1='',$para2='')
  {
    $subItems = $this->db->get_where('sub_items',array('item_id'=>$para1))->result_array(); 
    return $subItems;
  }
  function Inventory_Report($para1='')
  {
    $report_data = $this->db->select('*')->where('site', $para1)->order_by('action_date','desc')->get('installed_inventory')->result_array();
    return $report_data;
  }
  function Site_Locations($para1='')
  {
    $locations = $this->db->select('*')->where('site', $para1)->get('locations')->result_array();
    return $locations;
  }
  function specific_item_report($para1='',$para2)
  {
    $locations = $this->db->select('*')->where('site', $para1)->get('locations')->result_array();
    return $locations;
  }
}