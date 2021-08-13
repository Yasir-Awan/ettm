<?php
defined('BASEPATH') OR exit('No direct script access Allowed');
class Inventory_dashboard extends CI_Controller{
    public function __construct()
	{
		parent::__construct();
		$this->page_data = array();
		$this->page_data['page_url'] = current_url();
		$this->load->model('Inventory_model');
     }

    function index()
    {
        $para = $this->input->post('site'); 
        $this->page_data['page'] = 'Inventory Dashboard';
        $this->page_data['installed'] = $this->Inventory_model->installed_inventory($para);
        $this->page_data['specificSite'] = $this->Inventory_model->GetSpecificSite($this->page_data['installed'][0]['site']);
        $installed_inventory = $this->page_data['installed'];
        $installed_id = array();
        $identification_no = array(); 
        $item_name = array();
        $general_location = array();
        $north = array();
        $south = array();
        $north_inside_booth = array(); 
        $south_inside_booth = array();
        foreach($installed_inventory as $row)
        {
             $installed_id[] = $row['id'];
             $location =  $this->db->select('*')->where('id', $row['location'])->get('locations')->result_array();
             if($location[0]['location_type']==1)
             {
                if (in_array($location[0]['id'], $general_location))
                  {

                  }
                else
                  {
                    $general_location[] = $location[0]['id'];
                  }
             }
             if($location[0]['location_type']==2)
             {
                 if($location[0]['inside_booth']==0)
                 {
                     if (in_array($location[0]['id'], $north))
                     {

                     }
                   else
                     {
                        $north[] = $location[0]['id'];
                     }
                 }
                 if($location[0]['inside_booth']==1)
                 {
                     if (in_array($location[0]['id'], $north_inside_booth))
                     {

                     }
                   else
                     {
                        $north_inside_booth[] = $location[0]['id'];
                        // echo $north_inside_booth;
                     }
                 }
             }

             if($location[0]['location_type']==3)
             {
                 if($location[0]['inside_booth']==0)
                 {
                     if (in_array($location[0]['id'], $south))
                     {
                    //  echo "do nothing";
                     }
                   else
                     {
                        $south[] = $location[0]['id'];
                     }
                 }
                 if($location[0]['inside_booth']==1)
                 {
                     if (in_array($location[0]['id'], $south_inside_booth))
                     {
                    //  echo "do nothing";
                     }
                   else
                     {
                        $south_inside_booth[] = $location[0]['id'];
                        // echo $south_inside_booth;
                     }
                 }
             }
        }
        $installed = $this->db->get('installed_inventory')->result_array();
        $general_location_data = array();
        $north_data = array();
        $south_data = array();
        $north_inside_booth_data = array();
        $south_inside_booth_data = array();
        $counter = 0;
        $n_counter = 0;
        $s_counter = 0;
        $nbCounter = 0;
        $sbCounter = 0;
        foreach($installed as $row)
        {
            if(!empty($general_location[$counter]))
            {
                if($general_location[$counter]==$row['location'])
                {
                    $general_location_data[] =  $this->db->select('*')->where('location', $row['location'])->get('installed_inventory')->result_array();
                    $counter++;
                }
            }
            if(!empty($north[$n_counter]))
            {
                if($north[$n_counter]==$row['location'])
                {
                    $north_data[] =  $this->db->select('*')->where('location', $row['location'])->get('installed_inventory')->result_array();
                    $n_counter++;
                }
            }
            if(!empty($south[$s_counter]))
            {
                if($south[$s_counter]==$row['location'])
                {
                    $south_data[] =  $this->db->select('*')->where('location', $row['location'])->get('installed_inventory')->result_array();
                    $s_counter++;
                }
            }
            if(!empty($north_inside_booth[$nbCounter]))
            {
                if($north_inside_booth[$nbCounter]==$row['location'])
                {
                    $north_inside_booth_data[] =  $this->db->select('*')->where('location', $row['location'])->get('installed_inventory')->result_array();
                    $nbCounter++;
                }
            }
            if(!empty($south_inside_booth[$sbCounter]))
            {
                if($south_inside_booth[$sbCounter]==$row['location'])
                {
                    $south_inside_booth_data[] =  $this->db->select('*')->where('location', $row['location'])->get('installed_inventory')->result_array();
                    $sbCounter++;
                }
            }
        }
        $this->page_data['gl'] = $general_location;
        $this->page_data['north'] = $north;
        $this->page_data['south'] = $south;
        $this->page_data['north_inside_booth'] = $north_inside_booth; 
        $this->page_data['south_inside_booth'] = $south_inside_booth;
        $max_gen_data = 0;
        $max_north_data = 0;
        $max_south_data = 0;
        $max_north_booth_data = 0;
        $max_south_booth_data = 0;
        $this->page_data['gd'] = $general_location_data;
        if(!empty($this->page_data['gd']))
        {
            foreach($this->page_data['gd'] as $general_data)
            {
                if($max_gen_data < count($general_data)){
                    $max_gen_data = count($general_data); 
                    $this->page_data['max_gen_data'] = $max_gen_data;
                }   
            }
        }
        $this->page_data['nd'] = $north_data;
        if(!empty($this->page_data['nd']))
        {
            foreach($this->page_data['nd'] as $row)
            {
                if($max_north_data < count($row)){
                    $max_north_data = count($row);
                    $this->page_data['max_north_data'] = $max_north_data; 
                }   
            }
        }   
        $this->page_data['sd'] = $south_data;
        if(!empty($this->page_data['sd']))
        {
            foreach($this->page_data['sd'] as $s_data)
            {
                if($max_south_data < count($s_data)){
                    $max_south_data = count($s_data);
                    $this->page_data['max_south_data'] = $max_south_data;
                }   
            }
        }
        $this->page_data['nbd'] = $north_inside_booth_data; 
        if(!empty($this->page_data['nbd']))
        {
            foreach($this->page_data['nbd'] as $north_booth_data)
            {
                if($max_north_booth_data < count($north_booth_data)){
                    $max_north_booth_data = count($north_booth_data);
                    $this->page_data['max_north_booth_data'] = $max_north_booth_data;
                }   
            }
        }
        $this->page_data['sbd'] = $south_inside_booth_data;
        if(!empty($this->page_data['sbd']))
        {
            foreach($this->page_data['sbd'] as $south_booth_data)
            {
                if($max_south_booth_data < count($south_booth_data)){
                    $max_south_booth_data = count($south_booth_data);
                    $this->page_data['max_south_booth_data'] = $max_south_booth_data; 
                }   
            }
        }

        $this->load->view('back/inventory_dashboard',$this->page_data);
    }
    
    public function SiteType($para=''){
        $sites = $this->Inventory_model->GetSitesWhereInventoryIsInstalled($para);
        echo json_encode($sites);
    }

    public function Inventory_Report($para='',$para2=''){
        $this->page_data['page'] = 'Inventory Report';
        $data = $this->Inventory_model->Inventory_Report($para);
        $locations = $this->Inventory_model->Site_Locations($para);
        $siteName = $this->db->select('*')->where('id', $para)->get('sites')->result_array();
        $item_group_data = $this->db->select('*')->where('site', $para)->group_by('name')->order_by('id','desc')->get('installed_inventory')->result_array();
        $item_vise_count = array();
        $item_name = array();
        $item_name_ids = array();
        $item_ids = array();
        $location_vise_data = array();
        $location_vise_count = array();
        $names = array();
        $operational = 0;
        $nonOperational = 0;
        $index = 0;
        $item_index = 0;
        // Code to find items quantity in ascending order START
        foreach($item_group_data as $row){
            $item_ids[] = $row['name'];
        }

        foreach($item_ids as $row){
            $item_vise_data[] = $this->db->select('*')->where('site', $para)->where('name',$row)->order_by('id','desc')->get('installed_inventory')->result_array();
            $varia = $this->db->select('*')->where('id', $row)->get('items')->result_array();
            $item_name_ids[$row] = $varia[0]['name']; 
        }
        foreach($item_vise_data as $row){
            $item_vise_count[$item_ids[$item_index]] = count($row);
            $item_index++;
        }
        arsort($item_vise_count);
        foreach($item_vise_count as $key => $value){
            $i_name = $this->db->select('*')->where('id', $key)->get('items')->result_array();
            $item_name[$i_name[0]['name']] = $value;
        }
        // Code to find items quantity in ascending order END
        foreach($locations as $row){
            $names[] = $row['location'];
            $location_vise_data[$row['location']] = $this->db->select('*')->where('site', $para)->where('location', $row['id'])->order_by('id','desc')->get('installed_inventory')->result_array();
        }
        foreach($location_vise_data as $row){
             $location_vise_count[$names[$index]] = count($row);
             $index++;
        }
        foreach($data as $row){
            if($row['transaction_type']==3 || $row['transaction_type']==9 || $row['transaction_type']==14){ $operational++; }
            else{ $nonOperational++; }
        }
        $this->page_data['item_id_with_name'] = $item_name_ids;
        $this->page_data['item_ids'] = $item_ids;
        $this->page_data['sitename'] = $siteName[0]['name'];
        $this->page_data['sitetype'] = $siteName[0]['site_type'];
        $this->page_data['total_items'] = count($data);
        $this->page_data['operational'] = $operational;
        $this->page_data['nonOperational'] = $nonOperational;
        $this->page_data['itemqty'] = $item_name;
        $this->page_data['name'] = $names;
        $this->page_data['location_vise_count'] = $location_vise_count;
        $this->page_data['report_data'] = $location_vise_data;
        // echo "<pre>"; print_r($this->page_data); exit;
        $this->load->view('back/inventory/inventory_report',$this->page_data);
    }

    public function FaultyEquipmentList(){
        $faulty_data = $this->Inventory_model->get_faulty_data();
        $location_name = array();
        $site_name = array();
        $item_name = array();
        $subitem_name = array();
        foreach($faulty_data as $row){
            $location = $this->db->select('*')->where('id', $row['location'])->get('locations')->result_array();
            $site = $this->db->select('*')->where('id', $row['site'])->get('sites')->result_array();
            $item = $this->db->select('*')->where('id', $row['item_id'])->get('items')->result_array();
            if($row['is_sub_item']==1){
                $subitem = $this->db->select('*')->where('id', $row['subitem_id'])->get('sub_items')->result_array();
                $subitem_name[] = $subitem[0]['name'];
            }
            $location_name[] = $location[0]['location'];
            $site_name[] = $site[0]['name'];
            $item_name[] = $item[0]['name'];
        } 
        $this->page_data['site_name'] = $site_name;
        $this->page_data['location_name'] = $location_name;
        $this->page_data['item_name'] = $item_name;
        $this->page_data['subitem_name'] = $subitem_name;
        $this->page_data['faulty_data'] = $faulty_data;
        $this->page_data['page'] = 'faulty equipment list';
        $this->load->view('back/list_faulty_equipment',$this->page_data);
    }
}
?>