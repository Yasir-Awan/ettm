<?php
defined('BASEPATH') OR EXIT('NO DIRECT SCRIPT ALLOWED');
class Member_inventory extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('member_id'))
		{
			redirect(base_url().'home');
		}
		$this->page_data = array();
		$this->load->model("General");
        $this->load->model('Member_model');
        $this->load->model('Inventory_model');
	}	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url().'home','refresh');
    }
    
    public function first_page()
	{
		$this->page_data['page_name'] = 'inventory';
				
		$this->page_data['sites'] = $this->Inventory_model->getsites();
		$this->page_data['items'] = $this->Inventory_model->get_items();
	    $this->load->view('front/member/includes/header', $this->page_data);
		$this->load->view('front/member_inventory/first_page', $this->page_data);
		$this->load->view('front/member/includes/footer', $this->page_data);
	}

	/** Tabs START */
	public function tabs($para1 = '' )
	{  
		if(!$this->session->userdata('member_id')){
			return redirect('home/member_login');
		}

		if($para1 == 'items')
		{
			$this->page_data['items'] = $this->Inventory_model->get_items();
			$this->load->view('front/member_inventory/items', $this->page_data);
		}
		elseif($para1 == 'assets')
		{
			return redirect('member_inventory/assets/list/');
		}
		elseif($para1 == 'sites')
		{
			return redirect('member_inventory/sites/list/');
		}
		elseif($para1 == 'locations')
		{
			return redirect('member_inventory/locations/list/');
		}
		elseif($para1 == 'suppliers')
		{
			return redirect('member_inventory/suppliers/list/');
		}
		elseif($para1 == 'support_providers')
		{
			return redirect('member_inventory/tsp/list/');
		}
		elseif($para1 == 'manufacturers')
		{
			return redirect('member_inventory/manufacturers/list/');
		}
	}/** Tabs END */

		/** Assets area START */
public function assets($para1 = '' , $para2 = '', $para3 =''){
	
	if($para1 == 'list')
	{	
		$this->page_data['assets'] = $this->Inventory_model->get_assets();
		$this->page_data['sites'] = $this->Inventory_model->getsites();
		$this->page_data['items'] = $this->Inventory_model->get_Items();
		$this->page_data['asset_transactions'] = $this->Inventory_model->get_asset_transactions();
		$this->load->view('front/member_inventory/display_assets',$this->page_data);	
	}
	elseif($para1 == 'delete'){
		$this->db->where('id', $para2);
		$this->db->delete('assets');
		echo json_encode(array('response' => true, 'message' => 'Deleted successfully','is_redirect' => True,'redirect_url' => base_url().'member_inventory/first_page/')); exit;
	}elseif ($para1 == 'assets_publish_set') {
					$article = $para2;
					if ($para3 == 'true') {
							$data['status'] = '1';
					} else {
							$data['status'] = '0';
					}
					$this->db->where('id', $article);
					$this->db->update('assets', $data);
		
				 echo $para3;
			}else{
				$this->page_data['page'] = 'assets';
		$this->load->view('front/member_inventory/first_page', $this->page_data);
	}
}

	/** items area START */	
	public function items($para1 = '' , $para2 = '', $para3 =''){
		if(!$this->session->userdata('member_id')){
			
			return redirect('home/member_login');

		}
		if($para1 == 'list'){
			$this->page_data['items'] = $this->db->get('items')->result_array();
			$this->load->view('front/member_inventory/display_items', $this->page_data);	
		}
		elseif($para1 == 'delete'){
			$this->db->where('id', $para2);
			$this->db->delete('items');
			echo json_encode(array('response' => true, 'message' => 'Deleted successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page/')); exit;
		}elseif ($para1 == 'item_publish_set') {
            $article = $para2;
            if ($para3 == 'true') {
                $data['status'] = '1';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('id', $article);
            $this->db->update('items', $data);
			
           echo $para3;
        }else{
        	$this->page_data['page'] = 'Items';
			$this->load->view('front/member_inventory/first_page', $this->page_data);
		}
	}

	public function add_item()
	{  
		if(!$this->session->userdata('adminid'))
		{
			return redirect('admin/login');
		}
		$this->load->view('back/inventory/add_items');
		
     }

	
	public function selected_asset($para1 = '' , $para2 = '', $para3 =''){
		$this->page_data['page'] = 'selected_assets';
		if(!$this->session->userdata('member_id')){
		return redirect('home/member_login');
		}
		if($para1 == 'list')
		{
			$this->page_data['selected_asset_transaction'] = $this->db->select('*')->where('asset_id', $para2)->order_by('id','desc')->get('asset_transaction')->result_array();
		//	$this->page_data['selected_asset_history'] = $this->db->select('*')->where('asset_id', $para2)->get('asset_transaction')->result_array();
			$this->page_data['selected_assets'] = $this->db->get_where('assets',array('id' => $para2))->result_array();		
			$this->load->view('front/member_inventory/display_selected_assets',$this->page_data);	
		}
		/*
				*/else{
					$this->page_data['page'] = 'selected_assets';
				
			        //$this->load->view('back_inventory/first_page', $this->page_data);
		             }
	}

	public function add_asset()
	{  
		if(!$this->session->userdata('member_id'))
		{
			return redirect('home/member_login');
		}
		$this->page_data['sites'] = $this->Inventory_model->getsites();
		$this->page_data['suppliers'] = $this->Inventory_model->get_suppliers();
		$this->page_data['items'] = $this->Inventory_model->get_Items();
		//$this->page_data['locations'] = $this->Inventory_model->get_locations();
		$this->page_data['manufacturers'] = $this->Inventory_model->get_manufacturers();
		$this->load->view('front/member_inventory/add_asset', $this->page_data);
	 }




	 public function add_asset_do()
	 {
	 //	echo "<pre>";
	 //	print_r($_POST); exit;
	  $this->load->library('form_validation');
	  $this->form_validation->set_rules('item_type','Item Type','required|trim');
	  $this->form_validation->set_rules('asset_name',' Asset Name','required|trim');
	  $this->form_validation->set_rules('product_model_no',' Product Model Number','required|trim');
	  $this->form_validation->set_rules('supplier_id',' Supplier Name','required|trim');
	  $this->form_validation->set_rules('manufacturer_id',' Manufacturer Name','required|trim');
	  $this->form_validation->set_rules('id_no',' Identification Number','required|trim|is_unique[assets.identification_no]',array('is_unique' => 'Given Identification Number already exists.'));
	  $this->form_validation->set_rules('asset_price',' Product Price','required|trim');	 
	  $this->form_validation->set_rules('site_id',' Site Name','required|trim');
	  $this->form_validation->set_rules('quantity',' Quantity','required|trim');
	  $this->form_validation->set_rules('purchase_date',' Purchase Date','required|trim');
	  $this->form_validation->set_rules('warranty_type',' Warranty type','required|trim');
	  $this->form_validation->set_rules('warranty_duration','Warranty Duration','trim');
	  if($this->form_validation->run() == TRUE)
	  {
		  if($this->session->userdata('member_id'))
		  {
			  if($this->input->post('quantity')>1)
			  {
				  $quantity = $this->input->post('quantity');
				  $cost = $this->input->post('asset_price');
				  $unit_cost = $cost/$quantity;
				  $id_no = $this->input->post('id_no');
				  $description = $this->db->get_where('items',array('id'=>$this->input->post('asset_name')))->result_array();
				  //$date = date("Y-m-d H:i:s");				
				  $data = array();
				  for( $qty=0; $qty < $this->input->post('quantity'); $qty++)
				  {
				  $data[$qty] = array(
					  'item_type' => $this->input->post('item_type'),
					'name' => $this->input->post('asset_name'),
					'product_model_no' => $this->input->post('product_model_no'),
					  'identification_no' => $id_no++,
					  'manufacturer' => $this->input->post('manufacturer_id'),
					'cost_price' => $unit_cost,
					'supplier' => $this->input->post('supplier_id'),
					'site' => $this->input->post('site_id'),
					  'purchased_on' => $this->input->post('purchase_date'),
					  'warranty_type' => $this->input->post('warranty_type'),
					  'warranty_duration' => $this->input->post('warranty_duration'),
					  'user_type' => '3',
					  'checkin_by' => $this->session->userdata('member_id'),
					  'add_date' => time()
				  );
					 }	
					 
					 $this->db->insert_batch('assets',$data);
 
				 echo json_encode(array('response' => true, 'message' =>'Asset Stock Created Successfully','is_redirect' => True,'redirect_url' => base_url().'member_inventory/first_page')); exit;
			 
			 }
			  else
			  {
			   $description = $this->db->get_where('items',array('id'=>$this->input->post('asset_name')))->result_array();
				 // $date = date("Y-m-d H:i:s");
				 $data = array(
				 'item_type' => $this->input->post('item_type'),
			   'name' => $this->input->post('asset_name'),
			   'product_model_no' => $this->input->post('product_model_no'),
			   'identification_no' => $this->input->post('id_no'),
			   'cost_price' => $this->input->post('asset_price'),
				 'supplier' => $this->input->post('supplier_id'),
				 'manufacturer' => $this->input->post('manufacturer_id'),
			   'site' => $this->input->post('site_id'),
				 'purchased_on' => $this->input->post('purchase_date'),
				 'warranty_type' => $this->input->post('warranty_type'),
				 'warranty_duration' => $this->input->post('warranty_duration'),
				 'user_type' => '3',
				 'checkin_by' => $this->session->userdata('member_id'),
				 'add_date' => time()
			  );
			  $this->db->insert('assets',$data);
			echo json_encode(array('response' => true, 'message' =>'Asset Created Successfully','is_redirect' => True,'redirect_url' => base_url().'member_inventory/first_page')); exit;
		   }
		 }		 		 
	  } 
	  else
	  {
		 echo json_encode(array('response' => TRUE ,'message' => validation_errors())); exit;
	  }
	 }


	 public function asset_edit($para1 = ''){
		if(!$para1){
			echo '<div class="alert alert-dismissible alert-danger">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>OOPS!</strong> Invalid Request
				</div>'; exit;
		}
		$this->page_data['asset'] = $this->db->get_where('assets',array('id' => $para1))->result_array();
		$this->page_data['sites'] = $this->Inventory_model->getsites();
		$this->page_data['suppliers'] = $this->Inventory_model->get_suppliers();
		$this->page_data['items'] = $this->Inventory_model->get_Items();
		//$this->page_data['locations'] = $this->Inventory_model->get_locations();
		$this->page_data['manufacturers'] = $this->Inventory_model->get_manufacturers();
		$this->load->view('front/member_inventory/edit_asset', $this->page_data);
	}



	public function edit_asset_do($asset_id = ''){
    //	echo "<pre>";
		//	print_r($_POST); exit;
		if(!$asset_id)
		{
			echo json_encode(array('response' => TRUE , 'message' => 'Invalid Request')); exit;
		}
	 $this->load->library('form_validation');
	 $this->form_validation->set_rules('item_type','Item Type','required|trim');
	 $this->form_validation->set_rules('asset_name',' Asset Name','required|trim');
	 $this->form_validation->set_rules('product_model_no',' Product Model Number','required|trim');
	 $this->form_validation->set_rules('supplier_id',' Supplier Name','required|trim');
	 $this->form_validation->set_rules('manufacturer_id',' Manufacturer Name','required|trim');
	 $this->form_validation->set_rules('asset_price',' Product Price','required|trim');	 
	 $this->form_validation->set_rules('site_id',' Site Name','required|trim');
	 $this->form_validation->set_rules('purchase_on',' Purchase Date','required|trim');
	 $this->form_validation->set_rules('warranty_type','Warranty Type','required|trim');
	 $this->form_validation->set_rules('warranty_duration','Warranty Duration','required|trim');
	 if($this->form_validation->run() == TRUE)
	 {
		 if($this->session->userdata('member_id'))
		 { 
			  $description = $this->db->get_where('items',array('id'=>$this->input->post('asset_name')))->result_array();
			  $data = array(
				'item_type' => $this->input->post('item_type'),
			  'name' => $this->input->post('asset_name'),
			  'product_model_no' => $this->input->post('product_model_no'),
			  'identification_no' => $this->input->post('id_no'),
			  'cost_price' => $this->input->post('asset_price'),
				'supplier' => $this->input->post('supplier_id'),
				'manufacturer' => $this->input->post('manufacturer_id'),
			  'site' => $this->input->post('site_id'),
				'purchased_on' => $this->input->post('purchase_on'),
				'warranty_type' => $this->input->post('warranty_type'),
				'warranty_duration' => $this->input->post('warranty_duration'),
			  'user_type' => '1',
			  'checkin_by' => $this->session->userdata('adminid'),
			 );
			 $this->db->where('id',$asset_id);
			 $this->db->update('assets',$data);
		   echo json_encode(array('response' => true, 'message' =>'Asset Created Successfully','is_redirect' => True,'redirect_url' => base_url().'member_inventory/first_page')); exit;
		}

	 } 
	 else
	 {
		echo json_encode(array('response' => TRUE ,'message' => validation_errors())); exit;
	 }
	}
//** Action Area Start */
	public function action_on_asset($para1 = '' , $para2 = '', $para3 ='')
	{
		
		if(!$this->session->userdata('member_id'))
		{
			return redirect('home/member_login');
		}
		if($para1 == 'checkin')
		{		
			$this->page_data['checkins'] = explode(',', $_POST['asset']);
			$checkins = $this->page_data['checkins'];
			$data = array();
			foreach($checkins as $checkin)
			{
				$data[] = $this->db->get_where('assets',array('id' => $checkin))->result_array();
			}
			$data2 = array();
			foreach($data as $row)
			{
					if($row[0]['action_status']=='0'  )
					{
						echo "Brand New items cannot be Checked In."; exit;
					}
					if($row[0]['action_status']=='2'  )
					{
						echo "Some Selected items Already Checked in."; exit;
					}
					if($row[0]['action_status']=='3'  )
					{
						echo "Some Selected items Already Installed. You cannot Checkin them."; exit;
					}
					if($row[0]['action_status']=='4'  )
					{
						echo "Some Selected items are in repairing mode. You cannot Checkin them."; exit;
					}
					if($row[0]['action_status']=='5'  )
					{
						echo "Some Selected items are Repaired. You cannot Checkin them But you can Install them."; exit;
					}
					if($row[0]['action_status']=='6'  )
					{
						echo "Some Selected items are Retired. You cannot Checkin them."; exit;
					}
			}
			$data3 = array();
		 foreach($checkins as $checkin)
		 {
			 $checkin_names = $this->db->get_where('assets',array('id' => $checkin))->result_array();
			 $this->db->select('assets.name AS temp_id,items.*');
       $this->db->from('assets');
       $this->db->join('items','assets.name = items.id');
       $this->db->where('assets.id',$checkin);
       $query=$this->db->get();
			 $data3[]= $query->result_array();
			 $this->page_data['data'] = $data3; 		
		 }
		 $this->page_data['data1'] = $data;
		 $this->page_data['sites'] = $this->Inventory_model->getsites();

			$this->load->view('front/member_inventory/checkin',$this->page_data);	
		}


	elseif($para1 == 'checkin_do')
	{
	  $this->load->library('form_validation');
	  $this->form_validation->set_rules('site_id','Site Name','required|trim');
	  $this->form_validation->set_rules('checkin_comments','Comment for Checkin','required|trim');
	 
	  if($this->form_validation->run() == TRUE)
	  {
		  if($this->session->userdata('member_id'))
		  { 
			 // echo "<pre>"; print_r($_POST); exit;
			  $description = $this->db->get_where('items',array('id'=>$this->input->post('asset_name')))->result_array();
				$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
				$asset_ids = $this->page_data['assets_ids'];	
			//	echo "<pre>"; print_r($asset_ids); exit;
				foreach ($asset_ids as $id){
					$date = date("Y-m-d H:i:s");
				  $data = array(
					'asset_id' => $id,
					'transaction_type' => "2",
					'site' => $this->input->post('site_id'),
					'action_date' => $date,
					'action_comments' => $this->input->post('checkin_comments'),
					'user_type' =>"1",
					'added_by' => $this->session->userdata('member_id'),
				   );
			   //	echo "<pre>"; print_r($data); exit;
				 $assets_data = array('checkout_to'=> "",'action_status'=>'2','checkout_user_type'=>"0",'site'=>$this->input->post('site_id'));
				 $this->db->where('id',$id);
				 $this->db->update('assets',$assets_data);
				 $this->db->insert('asset_transaction',$data);
			   }
		   echo json_encode(array('response' => true, 'message' =>'Asset Checked In Successfully','is_redirect' => True,'redirect_url' => base_url().'member_inventory/first_page')); exit;
			 }
			
			}
		}
	


		elseif($para1 == 'checkout'){
		//	$this->db->where('id', $para2);
		//	$this->db->delete('assets');
		//	echo json_encode(array('response' => true, 'message' => 'Deleted successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page/')); exit;
		$this->page_data['checkouts'] = explode(',', $_POST['asset']);
		                               
		$this->page_data['sites'] = $this->Inventory_model->getsites();
		$checkouts = $this->page_data['checkouts'];

		$data = array();
			foreach($checkouts as $checkout)
			{
				$data[] = $this->db->get_where('assets',array('id' => $checkout))->result_array();
			}
			$data2 = array();
			foreach($data as $row)
			{
					if($row[0]['action_status']=="1")
					{
						echo "Some Selected items already Checked out. Therefore you cannot Check out them again."; exit;
					}
					if($row[0]['action_status']=="4")
					{
						echo "Some Selected items in Repair Mode. Therefore you cannot Check Out them."; exit;
					}
					if($row[0]['action_status']=="5")
					{
						echo "Some Selected items are repaired. Therefore you cannot Check Out them but you can install them."; exit;
					}
					if($row[0]['action_status']=="6")
					{
						echo "Some Selected items are retired. Therefore you cannot perform any action on them."; exit;
					}
			}
		$data3 = array();
		foreach($checkouts as $checkout)
		{
			$checkout_names = $this->db->get_where('assets',array('id' => $checkout))->result_array();
			$this->db->select('assets.name AS temp_id,items.*');
      $this->db->from('assets');
      $this->db->join('items','assets.name = items.id');
      $this->db->where('assets.id',$checkout);
      $query=$this->db->get();
			$data3[]= $query->result_array();
			$this->page_data['data'] = $data3; 		
		} 
//    echo "<pre>"; print_r($this->page_data['data']); exit;
		$this->load->view('front/member_inventory/checkout',$this->page_data);
		}
		elseif($para1 == 'checkout_do')
		{
	 $this->load->library('form_validation');
	 $this->form_validation->set_rules('return_date',' Return Date','trim');
	 $this->form_validation->set_rules('issue_permanent',' Return Infinite','trim');
	 $this->form_validation->set_rules('user_role','User Role','required|trim');
	 $this->form_validation->set_rules('person_contact','Person Contact No','required|trim');
	 $this->form_validation->set_rules('role',' Checkout To Name','required|trim');
	 $this->form_validation->set_rules('checkout_site',' Checkout Site Name','required|trim');
	 $this->form_validation->set_rules('checkout_reason','Checkout Reason','required|trim');	 
	 if($this->form_validation->run() == TRUE)
	 {
		 if($this->session->userdata('member_id'))
		 { 
			// echo "<pre>"; print_r($_POST); exit;
			  $description = $this->db->get_where('items',array('id'=>$this->input->post('asset_name')))->result_array();
				$return_date = $this->input->post('return_date');

				
					$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
					$asset_ids = $this->page_data['assets_ids'];
				  foreach ($asset_ids as $id){
					$date = date("Y-m-d H:i:s");
				  $data = array(
					'asset_id' => $id,
					'transaction_type' => "1",
					'issuance_type' => $this->input->post('issuance_type'),
			    'return_date' => $this->input->post('return_date'),
					'checkout_user_role' => $this->input->post('user_role'),
					'user_type' => "1",
					'person' => $this->input->post('role'),
					'person_contact' => $this->input->post('person_contact'),
					'added_by' => $this->session->userdata('member_id'),
					'site' => $this->input->post('checkout_site'),
					'checkout_from_site' => $this->session->userdata('site'),
					'action_date' => $date,
				  'action_comments' => $this->input->post('checkout_reason'),
				  );
			   	// echo "<pre>"; print_r($data); exit;
				$assets_data = array(
														 'checkout_to'=> $this->input->post('role'),
														 'checkout_user_type'=> $this->input->post('user_role'),
														 'action_status'=>'1',
														 'site' => $this->input->post('checkout_site') );
					 
					$this->db->where('id',$id);
				  $this->db->update('assets',$assets_data);
			    $this->db->insert('asset_transaction',$data);
			   }
		   echo json_encode(array('response' => true, 'message' =>'Asset Checkedout Successfully','is_redirect' => True,'redirect_url' => base_url().'member_inventory/first_page')); exit;
			
			}
		}
	}
	
		elseif ($para1 == 'install')
		{
			  $this->page_data['installs'] = explode(',', $_POST['asset']);
			  $installs = $this->page_data['installs'];
			  $data = array();
			  foreach($installs as $install)
			  {
				  $data[] = $this->db->get_where('assets',array('id' => $install))->result_array();
				}
			 //	echo "<pre>"; print_r($data); exit;
			  $data2 = array();
			  foreach($data as $row)
			  {
					  if($row[0]['action_status'] == "0" )
					  {
						  echo "Brand New Items selected You must Check Out them first."; exit;
						}
						if($row[0]['action_status'] == "2" )
					  {
						  echo "Checked In Items selected You must Check Out them first."; exit;
						}
						if($row[0]['action_status'] == "4" )
					  {
						  echo "Repairing Mode Items selected You cannot install them."; exit;
						}
						if($row[0]['action_status'] == "6" )
					  {
						  echo "Retired Items Selected. You cannot Install them."; exit;
					  }
			  }
			  $data3 = array();
		   foreach($installs as $install)
		   {
			   $installing_names = $this->db->get_where('assets',array('id' => $install))->result_array();
			   $this->db->select('assets.name AS temp_id,items.*');
         $this->db->from('assets');
         $this->db->join('items','assets.name = items.id');
         $this->db->where('assets.id',$install);
         $query=$this->db->get();
			   $data3[]= $query->result_array();
			   $this->page_data['data'] = $data3; 		
		   }
		    $this->page_data['data1'] = $data;
				$this->page_data['sites'] = $this->Inventory_model->getsites();
				$this->page_data['locations'] = $this->Inventory_model->get_locations();
			  $this->load->view('front/member_inventory/install',$this->page_data);	
	 }


	 elseif ($para1 == 'install_do')
	 {
			  $this->load->library('form_validation');
	 $this->form_validation->set_rules('site_id','Site Name','required|trim');
	 $this->form_validation->set_rules('location_id','Location Name','required|trim');
	 $this->form_validation->set_rules('install_comments','Installing Comments','required|trim');	
	 if($this->form_validation->run() == TRUE)
	 {
		 if($this->session->userdata('member_id'))
		 { 
			// // echo "<pre>"; print_r($_POST); exit;
			//   $description = $this->db->get_where('items',array('id'=>$this->input->post('asset_name')))->result_array();
			// 	$return_date = $this->input->post('return_date');

			// 	if($return_date)
				// {
					$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
					$asset_ids = $this->page_data['assets_ids'];
				  foreach ($asset_ids as $id){
					$date = date("Y-m-d H:i:s");
				  $data = array(
					'asset_id' => $id,
					'transaction_type' => "3",
			    'site' => $this->input->post('site_id'),
					'location' => $this->input->post('location_id'),
					'user_type' => "3",
					'added_by' => $this->session->userdata('member_id'),
					'action_date' => $date,
				  'action_comments' => $this->input->post('install_comments'),
				  );
			   //	echo "<pre>"; print_r($data); exit;
				$assets_data = array('checkout_to'=> "",'action_status'=>'3','checkout_user_type' =>"",'site' => $this->input->post('site_id') );
				 $this->db->where('id',$id);
				 $this->db->update('assets',$assets_data);
			   $this->db->insert('asset_transaction',$data);
			   }
		   echo json_encode(array('response' => true, 'message' =>'Installation Successfull.','is_redirect' => True,'redirect_url' => base_url().'member_inventory/first_page')); exit;
			//  }
			
			}
		}
	}

	elseif ($para1 == 'start_repair')
	{
			$this->page_data['repairs'] = explode(',', $_POST['asset']);
			$repairs = $this->page_data['repairs'];
			$data = array();
			foreach($repairs as $repair)
			{
				$data[] = $this->db->get_where('assets',array('id' => $repair))->result_array();
			}
		 //	echo "<pre>"; print_r($data); exit;
			$data2 = array();
			foreach($data as $row)
			{
					if($row[0]['action_status'] == "0")
					{
						echo "Brand New item cannot be repair."; exit;
					}
					if($row[0]['action_status'] == "1")
					{
						echo "Checked Out item cannot be repair."; exit;
					}
					if($row[0]['action_status'] == "4")
					{
						echo "Selected item already in repairing mode."; exit;
					}
					if($row[0]['action_status'] == "5")
					{
						echo "Selected item's repairing recently completed."; exit;
					}
					if($row[0]['action_status'] == "6")
					{
						echo "Retire item cannot be repair."; exit;
					}
			}
			$data3 = array();
		 foreach($repairs as $repair)
		 {
			 $installing_names = $this->db->get_where('assets',array('id' => $repair))->result_array();
			 $this->db->select('assets.name AS temp_id,items.*');
			 $this->db->from('assets');
			 $this->db->join('items','assets.name = items.id');
			 $this->db->where('assets.id',$repair);
			 $query=$this->db->get();
			 $data3[]= $query->result_array();
			 $this->page_data['data'] = $data3; 		
		 }
			$this->page_data['data1'] = $data;
			$this->page_data['sites'] = $this->Inventory_model->getsites();
			$this->page_data['locations'] = $this->Inventory_model->get_locations();
			$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
			$this->load->view('front/member_inventory/start_repair',$this->page_data);	
 }

 elseif ($para1 == 'start_repair_do')
 {
 $this->load->library('form_validation');
 $this->form_validation->set_rules('item_location','Item Location','required|trim');
 $this->form_validation->set_rules('item_availability','Item Availability','required|trim');
 $this->form_validation->set_rules('repair_type','Repair Type','required|trim');
 $this->form_validation->set_rules('repairing_company','Repairing Company','required|trim');
 $this->form_validation->set_rules('expected_completion','Expected Repair Completion Date','required|trim');
 $this->form_validation->set_rules('start_repair_reason','Reason For Repairing','required|trim');
 	
 if($this->form_validation->run() == TRUE)
 {
	 if($this->session->userdata('member_id'))
	 { 
		// // echo "<pre>"; print_r($_POST); exit;
		//   $description = $this->db->get_where('items',array('id'=>$this->input->post('asset_name')))->result_array();
		// 	$return_date = $this->input->post('return_date');

			if($this->input->post('repairing_company')=="1")
			{
				$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
				$asset_ids = $this->page_data['assets_ids'];
				
				foreach ($asset_ids as $id){
				$date = date("Y-m-d H:i:s");
				$data = array(
				'asset_id' => $id,
				'transaction_type' => "4",
				'site' => $this->session->userdata('site'),
				'location' => $this->input->post('item_location'),
				'repair_type' => $this->input->post('repair_type'),
				'available' => $this->input->post('item_availability'),
				'user_type' => "3",
				'added_by' => $this->session->userdata('member_id'),
				'action_date' => $date,
				'organisation' => $this->input->post('repairing_tsp'),
				'organisation_address' => $this->input->post('tsp_address'),
				'repairing_person_type' => $this->input->post('tsp_person_type'),
				'person' => $this->input->post('tsp_person'),
				'person_contact' => $this->input->post('tsp_person_contact'),
				'return_date' => $this->input->post('expected_completion'),
				'action_comments' => $this->input->post('start_repair_reason'),
				);
			 	// echo "<pre>"; print_r($data); exit;
			$assets_data = array('action_status'=>'4','user_type' => "3",'checkin_by' => $this->session->userdata('member_id'));
			 $this->db->where('id',$id);
			 $this->db->update('assets',$assets_data);
			 $this->db->insert('asset_transaction',$data);
			 }
		 echo json_encode(array('response' => true, 'message' =>'Repairing Starts.','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;
			}
			if($this->input->post('repairing_company')=="2")
			{
				$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
				$asset_ids = $this->page_data['assets_ids'];
				foreach ($asset_ids as $id){
				$date = date("Y-m-d H:i:s");
				$data = array(
					'asset_id' => $id,
					'transaction_type' => "4",
					'site' => $this->session->userdata('site'),
					'location' => $this->input->post('item_location'),
					'repair_type' => $this->input->post('repair_type'),
					'available' => $this->input->post('item_availability'),
					'user_type' => "3",
					'added_by' => $this->session->userdata('member_id'),
					'action_date' => $date,
					'organisation' => $this->input->post('outer_company_name'),
					'organisation_address' => $this->input->post('outer_company_address'),
					'person' => $this->input->post('outsider_name'),
					'person_contact' => $this->input->post('outsider_contact'),
					'return_date' => $this->input->post('expected_completion'),
					'action_comments' => $this->input->post('start_repair_reason'),
					);
			 //	echo "<pre>"; print_r($data); exit;
			$assets_data = array('action_status'=>'4','user_type' => "3",'checkin_by' => $this->session->userdata('member_id'));
			 $this->db->where('id',$id);
			 $this->db->update('assets',$assets_data);
			 $this->db->insert('asset_transaction',$data);
			 }
		 echo json_encode(array('response' => true, 'message' =>'Repairing Starts.','is_redirect' => True,'redirect_url' => base_url().'member_inventory/first_page')); exit;
		  }
		
		}
	}
}

elseif ($para1 == 'end_repair')
	{
			$this->page_data['end_repairs'] = explode(',', $_POST['asset']);
			$end_repairs = $this->page_data['end_repairs'];
			$data = array();
			$asset_transaction = array();
			$locations = array();
			$quantity = 0;
			foreach($end_repairs as $repair)
			{
				$quantity++;
				$data[] = $this->db->get_where('assets',array('id' => $repair))->result_array();
				$asset_transaction[] = $this->db->get_where('asset_transaction',array( 'asset_id'=> $repair , 'transaction_type' => "4"))->result_array();
				$locations[] = $this->db->get_where('asset_transaction',array( 'asset_id'=> $repair , 'transaction_type' => "4" , 'site' => $this->session->userdata('site')))->result_array();	
			}

			$data2 = array();
			foreach($data as $row)
			{
					if($row[0]['action_status'] == "0" )
					{
						echo "Brand New items cannot be repaired."; exit;
					}
					if($row[0]['action_status'] == "1" )
					{
						echo "Checked Out item Selected.Only Repairing Mode items you can select."; exit;
					}
					if($row[0]['action_status'] == "2" )
					{
						echo "Checked In item Selected.Only Repairing Mode items you can select."; exit;
					}
					if($row[0]['action_status'] == "3" )
					{
						echo "Installed item Selected.Only Repairing Mode items you can select."; exit;
					}
					if($row[0]['action_status'] == "5" )
					{
						echo "Repaired item Selected.Only Repairing Mode items you can select."; exit;
					}
					if($row[0]['action_status'] == "6" )
					{
						echo "Retired item Selected.Only Repairing Mode items you can select."; exit;
					}
			}
      $selected_sites = array();
			foreach($locations as $location)
			{
          $selected_sites[] = $location[0]['site'];
			}
		//	echo "<pre>"; print_r($selected_sites); exit;
		$selected_locations = array();
		foreach($locations as $location)
		{
				$selected_locations[] = $location[0]['location'];
		}
			  

			
			foreach($asset_transaction as $row)
			{
					if($row[0]['site'] !== $this->session->userdata('site') )
					{
						echo "Only that person who start repairing. Any person of only that site can end Repairing."; exit;
					}
			}	
		 $data3 = array();
		 foreach($end_repairs as $repair)
		 {
			 $installing_names = $this->db->get_where('assets',array('id' => $repair))->result_array();
			 $this->db->select('assets.name AS temp_id,items.*');
			 $this->db->from('assets');
			 $this->db->join('items','assets.name = items.id');
			 $this->db->where('assets.id',$repair);
			 $query=$this->db->get();
			 $data3[]= $query->result_array();
			 $this->page_data['data'] = $data3; 		
		 }
			$this->page_data['locations'] = $selected_locations;
			$this->page_data['data1'] = $data;
			$this->page_data['selected_sites'] = $selected_sites;			
			$this->page_data['sites'] = $this->Inventory_model->getsites();
			$this->page_data['quantity'] = $quantity;
			$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
			$this->load->view('front/member_inventory/end_repair',$this->page_data);	
 }



 elseif ($para1 == 'end_repair_do')
 {
 $this->load->library('form_validation');
 $this->form_validation->set_rules('repair_completion','Repair Completed Date','required|trim');
 $this->form_validation->set_rules('end_repair_comments','Repairing Comments ','required|trim');
 	
 if($this->form_validation->run() == TRUE)
 {
	 if($this->session->userdata('member_id'))
	 {
				$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
				$asset_ids = $this->page_data['assets_ids'];
				$unit_repair_cost = $this->input->post('repair_price')/$this->input->post('quantity');
				$locations = explode(',',$this->input->post('selected_locations'));
				 //print_r($locations); exit;
				$counter = 0;
				foreach ($asset_ids as $id){
				$date = date("Y-m-d H:i:s");
				$data = array(
				'asset_id' => $id,
				'transaction_type' => "5",
				'site' => $this->session->userdata('site'),
				'location' => $locations[$counter],
				'unit_repairing_cost' => $unit_repair_cost,
				'user_type' => "3",
				'added_by' => $this->session->userdata('member_id'),
				'action_date' => $date,
				'return_date' => $this->input->post('repair_completion'),
				'action_comments' => $this->input->post('end_repair_comments'),
				);
				$counter++;
			 	 //echo "<pre>"; print_r($data); exit;
			$assets_data = array('action_status'=>'5','user_type' => "3",'checkin_by' => $this->session->userdata('member_id'));
			 $this->db->where('id',$id);
			 $this->db->update('assets',$assets_data);
			 $this->db->insert('asset_transaction',$data);
			 }
		 echo json_encode(array('response' => true, 'message' =>'Repairing Completed.','is_redirect' => True,'redirect_url' => base_url().'member_inventory/first_page')); exit;
			
	 }
	}
}



elseif ($para1 == 'retire')
{
	
			  $this->page_data['retiring_assets'] = explode(',', $_POST['asset']);
			  $retiring_items = $this->page_data['retiring_assets'];
			  $data = array();
			  foreach($retiring_items as $item)
			  {
				  $data[] = $this->db->get_where('assets',array('id' => $item))->result_array();
				}
			 //	echo "<pre>"; print_r($data); exit;
			  $data2 = array();
			  foreach($data as $row)
			  {
					  if($row[0]['action_status'] == "0" )
					  {
						  echo "Brand New  Items cannot be Retire ."; exit;
						}
						if($row[0]['action_status'] == "1" )
					  {
						  echo "Checked Out Items cannot be Retire ."; exit;
						}
						if($row[0]['action_status'] == "4" )
					  {
						  echo "Repairing Items cannot be Retire ."; exit;
						}
						if($row[0]['action_status'] == "6" )
					  {
						  echo "Already Retired Items cannot be Retire ."; exit;
					  }
			  }
			  $data3 = array();
		   foreach($retiring_items as $item)
		   {
				 $retiring_items = $this->db->get_where('assets',array('id' => $item))->result_array();
			   $this->db->select('assets.name AS temp_id,items.*');
         $this->db->from('assets');
         $this->db->join('items','assets.name = items.id');
         $this->db->where('assets.id',$item);
         $query=$this->db->get();
			   $data3[]= $query->result_array();
			    		
			 }
			  $this->page_data['data'] = $data3;
			 //echo "<pre>"; print_r($data3); exit;
		    $this->page_data['data1'] = $data;
				$this->page_data['sites'] = $this->Inventory_model->getsites();
				$this->page_data['locations'] = $this->Inventory_model->get_locations();
			
		$this->load->view('front/member_inventory/retire',$this->page_data);
	}



  elseif ($para1 == 'retire_do')
 {
 $this->load->library('form_validation');
 $this->form_validation->set_rules('retire_type','Retire Type','required|trim');
 $this->form_validation->set_rules('retire_date','Retire Date','required|trim');
 $this->form_validation->set_rules('retire_reason','Retire Reason ','required|trim');
 	
 if($this->form_validation->run() == TRUE)
 {
	 if($this->session->userdata('member_id'))
	 {
				$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
				$asset_ids = $this->page_data['assets_ids'];
			
				foreach ($asset_ids as $id){
				$date = date("Y-m-d H:i:s");
				$data = array(
				'asset_id' => $id,
				'transaction_type' => "6",
				'user_type' => "3",
				'added_by' => $this->session->userdata('member_id'),
				'action_date' => $date,
				'retire_type' => $this->input->post('retire_type'),
				'retire_date' => $this->input->post('retire_date'),
				'action_comments' => $this->input->post('retire_reason'),
				);
				
			//echo "<pre>"; print_r($data); exit;
			$assets_data = array('action_status'=>'6','user_type' => "3",'checkin_by' => $this->session->userdata('member_id'));
			 $this->db->where('id',$id);
			 $this->db->update('assets',$assets_data);
			 $this->db->insert('asset_transaction',$data);
			 }
		 echo json_encode(array('response' => true, 'message' =>'Retired.','is_redirect' => True,'redirect_url' => base_url().'member_inventory/first_page')); exit;
			
	 }
	}
}

	



		elseif ($para1 == 'change_role')
		{
			if($para2==1)
			{
				$admins = $this->db->get('admin')->result_array();
				echo json_encode($admins);
			}
			elseif($para2==2)
			{
				$members = $this->db->get('member')->result_array();
				echo json_encode($members);
			}
			elseif($para2==3)
			{
				$supervisors = $this->db->get('tpsupervisor')->result_array();
				echo json_encode($supervisors); 
			}
			else
			{
				echo "please Select the User Role";
			}
		
		}

		elseif ($para1 == 'repairing_tsp')
		{
			$tsp = $this->db->get_where('tsp',array('id' => $para2))->result_array();
			$tsp[0]['address'];
			if($para3=="1")
			{
				$person_names = $this->db->get_where('admin',array('tsp' => $para2))->result_array();
				if($person_names)
				{
					$data = array( 'person_names'=>$person_names,'address'=>$tsp[0]['address']);	
				echo json_encode($data); 
				}
				else
				{
					echo json_encode("No Person exist of This TSP.");
				}
			}
			if($para3=="2")
			{
				$person_names = $this->db->get_where('member',array('tsp' => $para2))->result_array();
			  if($person_names)
				{
					$data = array( 'person_names'=>$person_names,'address'=>$tsp[0]['address']);	
				echo json_encode($data); 
				}
				else
				{
					echo json_encode("No Person exist of This TSP.");
				}
			}
			if($para3=="3")
			{
				$person_names = $this->db->get_where('tpsupervisor',array('tsp' => $para2))->result_array();
				if($person_names)
				{
					$data = array('person_names'=> $person_names,'address'=>$tsp[0]['address']);	
				echo json_encode($data); 
				}
				else
				{
					echo json_encode("No Person exist of This TSP.");
				}
			}
		  //  $tsp = $this->db->get_where('tsp',array('id' => $para2))->result_array();
			// 		$address = $tsp[0]['address'];
			// 		$person_name = $tsp[0]['person_name'];
			// 		$person_contact = $tsp[0]['person_contact'];
			// 		$data = array('address'=>$address,'person_name'=>$person_name,'person_contact'=>$person_contact);
			// 	  echo json_encode($data);			
		//	$this->load->view('back/inventory/retire');
		}

		elseif ($para1 == 'person_contact')
		{
			// echo $para2; echo $para3; exit;
			// $tsp = $this->db->get_where('tsp',array('id' => $para2))->result_array();
			// $tsp[0]['address'];
			if($para2=="1")
			{
				$person_contact = $this->db->get_where('admin',array('id' => $para3))->result_array();
				if($person_contact)
				{
					$data = array( 'contact'=>$person_contact[0]['contact']);	
				  echo json_encode($data); 
				}
				else
				{
					echo json_encode("No Contact exist of This User.");
				}
			}
			if($para2=="2")
			{
				$person_contact = $this->db->get_where('member',array('id' => $para3))->result_array();
			  if($person_contact)
				{
					$data = array( 'contact'=>$person_name[0]['contact']);	
				  echo json_encode($data); 
				}
				else
				{
					echo json_encode("No contact exist of This Person.");
				}
			}
			if($para2=="3")
			{
				$person_contact = $this->db->get_where('tpsupervisor',array('id' => $para3))->result_array();
				if($person_contact)
				{
					$data = array('contact'=> $person_contact[0]['contact']);	
				  echo json_encode($data); 
				}
				else
				{
					echo json_encode("No contact exist of This person.");
				}
			}
		  //  $tsp = $this->db->get_where('tsp',array('id' => $para2))->result_array();
			// 		$address = $tsp[0]['address'];
			// 		$person_name = $tsp[0]['person_name'];
			// 		$person_contact = $tsp[0]['person_contact'];
			// 		$data = array('address'=>$address,'person_name'=>$person_name,'person_contact'=>$person_contact);
			// 	  echo json_encode($data);			
		//	$this->load->view('back/inventory/retire');
		}

		elseif($para1 == 'extend_checkout')
		{
			
			//	$this->db->where('id', $para2);
			//	$this->db->delete('assets');
			//	echo json_encode(array('response' => true, 'message' => 'Deleted successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page/')); exit;
			$this->load->view('back/inventory/extend_checkout');
		}
		elseif ($para1 == 'assets_publish_set') {
						$article = $para2;
						if ($para3 == 'true') 
						{
							 $data['status'] = '1';
						} 
						else 
						{
								$data['status'] = '0';
						}
						$this->db->where('id', $article);
						$this->db->update('assets', $data);	
					 echo $para3;
				}
				else
				{
					$this->page_data['page'] = 'assets';
			$this->load->view('back/inventory/first_page', $this->page_data);
		}
	}//** Action Area End */

		/** Site area START */
		public function sites($para1 = '' , $para2 = '', $para3 =''){
			if(!$this->session->userdata('member_id')){
				
				return redirect('home/member_login');
	
			}
			if($para1 == 'list'){
				$this->page_data['sites'] = $this->Inventory_model->getsites();
				$this->load->view('front/member_inventory/display_sites',$this->page_data);	
			}
			elseif($para1 == 'delete'){
				$this->db->where('id', $para2);
				$this->db->delete('sites');
				echo json_encode(array('response' => true, 'message' => 'Deleted successfully','is_redirect' => True,'redirect_url' => base_url().'member_inventory/first_page/')); exit;
			}elseif ($para1 == 'site_publish_set') {
							$article = $para2;
							if ($para3 == 'true') {
									$data['status'] = '1';
							} else {
									$data['status'] = '0';
							}
							$this->db->where('id', $article);
							$this->db->update('sites', $data);
				
						 echo $para3;
					}else{
						$this->page_data['page'] = 'sites';
				$this->load->view('front/member_inventory/first_page', $this->page_data);
			}
		}  
	
		public function site_edit($para1 = ''){
			if(!$para1){
				echo '<div class="alert alert-dismissible alert-danger">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>OOPS!</strong> Invalid Request
					</div>'; exit;
	
			}
			$this->page_data['site'] = $this->db->get_where('sites',array('id' => $para1))->result_array();
			$this->load->view('front/member_inventory/edit_sites', $this->page_data);
		}
	
		public function edit_site_do($site_id = ''){
			if(!$site_id){
				echo json_encode(array('response' => TRUE , 'message' => 'Invalid Request')); exit;
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('site-name',' Site Name','required|trim');
			
			if($this->form_validation->run() == TRUE){
				$data = array(
					'name' => $this->input->post('site-name')
					);
				$this->db->where('id',$site_id);
				$this->db->update('sites',$data);
					echo json_encode(array('response' => true, 'message' => 'Site updated successfully','is_redirect' => True,'redirect_url' => base_url().'member_inventory/first_page/')); exit;
				}else{
	
					echo json_encode(array('response' => TRUE , 'message' => validation_errors())); exit;
	
			}
		}
	
	
	
		public function add_site()
		{  
			if(!$this->session->userdata('member_id'))
			{
				return redirect('home/member_login');
			}
			$this->load->view('front/member_inventory/add_sites');
			
		 }
		 
		 public function add_site_do()
		 {
			 $this->load->library('form_validation');
			$this->form_validation->set_rules('site_name',' Site Name','required|trim');
		 
			if($this->form_validation->run() == TRUE)
			{
			 $data = array(
				 'name' => $this->input->post('site_name')
				 );
			 $this->db->insert('sites',$data);
			 echo json_encode(array('response' => true, 'message' =>'Site Added Successfully','is_redirect' => True,'redirect_url' => base_url().'member_inventory/first_page')); exit;
			} 
			else
			{
			 echo json_encode(array('response' => TRUE ,'message' => validation_errors())); exit;
			}
		 }
			 /** Site area END*/

	/** Location area START */
public function locations($para1 = '' , $para2 = '', $para3 =''){
	if(!$this->session->userdata('member_id')){
		
		return redirect('home/member_login');

	}
	if($para1 == 'list'){
		$this->page_data['locations'] = $this->Inventory_model->get_locations();
		$this->load->view('front/member_inventory/display_locations',$this->page_data);	
	}
	elseif($para1 == 'delete'){
		$this->db->where('id', $para2);
		$this->db->delete('locations');
		echo json_encode(array('response' => true, 'message' => 'Deleted successfully','is_redirect' => True,'redirect_url' => base_url().'member_inventory/first_page/')); exit;
	}elseif ($para1 == 'location_publish_set') {
					$article = $para2;
					if ($para3 == 'true') {
							$data['status'] = '1';
					} else {
							$data['status'] = '0';
					}
					$this->db->where('id', $article);
					$this->db->update('locations', $data);
		
				 echo $para3;
			}else{
				$this->page_data['page'] = 'locations';
		$this->load->view('front/member_inventory/first_page', $this->page_data);
	}
} 
	public function add_location()
	{  
		if(!$this->session->userdata('member_id'))
		{
			return redirect('home/member_login');
		}
		$this->load->view('front/member_inventory/add_locations');
		
	 }
	 

    public function add_location_do()
    {
      $this->load->library('form_validation');
	 $this->form_validation->set_rules('location_name',' Location Name','required|trim');
	 if($this->form_validation->run() == TRUE)
	 {
		$data = array(
			'name' => $this->input->post('location_name')
			);
		$this->db->insert('locations',$data);
		echo json_encode(array('response' => true, 'message' =>'Location Added Successfully','is_redirect' => True,'redirect_url' => base_url().'member_inventory/first_page')); exit;
	 } 
	 else
	 {
		echo json_encode(array('response' => TRUE ,'message' => validation_errors())); exit;
	 }
	}

	public function location_edit($para1 = ''){
		if(!$para1){
			echo '<div class="alert alert-dismissible alert-danger">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>OOPS!</strong> Invalid Request
				</div>'; exit;

		}
		$this->page_data['location'] = $this->db->get_where('locations',array('id' => $para1))->result_array();
		$this->load->view('front/member_inventory/edit_locations', $this->page_data);
	}

	public function edit_location_do($location_id = ''){
		if(!$location_id){
			echo json_encode(array('response' => TRUE , 'message' => 'Invalid Request')); exit;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('location-name',' Location Name','required|trim');
		
		if($this->form_validation->run() == TRUE){
			$data = array(
				'name' => $this->input->post('location-name')
				);
			$this->db->where('id',$location_id);
			$this->db->update('locations',$data);
				echo json_encode(array('response' => true, 'message' => 'Location updated successfully','is_redirect' => True,'redirect_url' => base_url().'member_inventory/first_page/')); exit;
			}else{

				echo json_encode(array('response' => TRUE , 'message' => validation_errors())); exit;

		}
	}
	/** Location area END */

	 /** Suppliers area START */
public function suppliers($para1 = '' , $para2 = '', $para3 =''){
	if(!$this->session->userdata('member_id')){
		
		return redirect('home/member_login');

	}
	if($para1 == 'list')
	{
		$this->page_data['suppliers'] = $this->Inventory_model->get_suppliers();
		$this->load->view('front/member_inventory/display_suppliers',$this->page_data);	
	}
	elseif($para1 == 'delete'){
		$this->db->where('id', $para2);
		$this->db->delete('suppliers');
		echo json_encode(array('response' => true, 'message' => 'Deleted successfully','is_redirect' => True,'redirect_url' => base_url().'member_inventory/first_page/')); exit;
	}elseif ($para1 == 'supplier_publish_set') {
					$article = $para2;
					if ($para3 == 'true') {
							$data['status'] = '1';
					} else {
							$data['status'] = '0';
					}
					$this->db->where('id', $article);
					$this->db->update('suppliers', $data);
		
				 echo $para3;
			}else{
				$this->page_data['page'] = 'suppliers';
		$this->load->view('front/member_inventory/first_page', $this->page_data);
	}
} 
	public function add_supplier()
	{  
		if(!$this->session->userdata('member_id'))
		{
			return redirect('home/member_login');
		}
		$this->load->view('front/member_inventory/add_suppliers');
		
	 }
	 

    public function add_supplier_do()
    {
      $this->load->library('form_validation');
	 $this->form_validation->set_rules('supplier_name',' Supplier Name','required|trim');
	 $this->form_validation->set_rules('focal_name',' Focal Person Name','required|trim');
	 $this->form_validation->set_rules('contact',' Focal Person Contact','required|trim');
	 $this->form_validation->set_rules('address_[description]',' Supplier"s" Address','required|trim');
	 $this->form_validation->set_rules('supplier_[description]',' Supplier"s" Description','required|trim');
	 if($this->form_validation->run() == TRUE)
	 {
		$data = array(
			'name' => $this->input->post('supplier_name'),
			'description' => $this->input->post('supplier_[description]'),
			'focal_person' => $this->input->post('focal_name'),
			'contact' => $this->input->post('contact'),
			'address' => $this->input->post('address_[description]')
			);
		$this->db->insert('suppliers',$data);
		echo json_encode(array('response' => true, 'message' =>'Supplier Added Successfully','is_redirect' => True,'redirect_url' => base_url().'member_inventory/first_page')); exit;
	 } 
	 else
	 {
		echo json_encode(array('response' => TRUE ,'message' => validation_errors())); exit;
	 }
	}

	public function supplier_edit($para1 = ''){
		if(!$para1){
			echo '<div class="alert alert-dismissible alert-danger">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>OOPS!</strong> Invalid Request
				</div>'; exit;

		}
		$this->page_data['supplier'] = $this->db->get_where('suppliers',array('id' => $para1))->result_array();
		$this->load->view('front/member_inventory/edit_supplier', $this->page_data);
	}

	public function edit_supplier_do($supplier_id = ''){
		if(!$supplier_id){
			echo json_encode(array('response' => TRUE , 'message' => 'Invalid Request')); exit;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('supplier_name',' Supplier Name','required|trim');
	 $this->form_validation->set_rules('focal_name',' Focal Person Name','required|trim');
	 $this->form_validation->set_rules('contact',' Focal Person Contact','required|trim');
	 $this->form_validation->set_rules('address_[description]',' Supplier"s" Address','required|trim');
	 $this->form_validation->set_rules('supplier_[description]',' Supplier"s" Description','required|trim');
		
		if($this->form_validation->run() == TRUE){
			$data = array(
				'name' => $this->input->post('supplier_name'),
				'description' => $this->input->post('supplier_[description]'),
				'focal_person' => $this->input->post('focal_name'),
				'contact' => $this->input->post('contact'),
				'address' => $this->input->post('address_[description]')
				);
			$this->db->where('id',$supplier_id);
			$this->db->update('suppliers',$data);
				echo json_encode(array('response' => true, 'message' => 'Supplier updated successfully','is_redirect' => True,'redirect_url' => base_url().'member_inventory/first_page/')); exit;
			}else{

				echo json_encode(array('response' => TRUE , 'message' => validation_errors())); exit;

		}
	}
	/** Suppliers area END */


	  /** T.S.P area START */
public function tsp($para1 = '' , $para2 = '', $para3 =''){
	if(!$this->session->userdata('member_id')){
		
		return redirect('home/member_login');

	}
	if($para1 == 'list')
	{
		$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
		$this->load->view('front/member_inventory/display_tsps',$this->page_data);	
	}
	elseif($para1 == 'delete'){
		$this->db->where('id', $para2);
		$this->db->delete('tsp');
		echo json_encode(array('response' => true, 'message' => 'Deleted successfully','is_redirect' => True,'redirect_url' => base_url().'member_inventory/first_page/')); exit;
	}elseif ($para1 == 'tsp_publish_set') {
					$article = $para2;
					if ($para3 == 'true') {
							$data['status'] = '1';
					} else {
							$data['status'] = '0';
					}
					$this->db->where('id', $article);
					$this->db->update('t_s_p', $data);
		
				 echo $para3;
			}else{
				$this->page_data['page'] = 'tsp';
		$this->load->view('front/member_inventory/first_page', $this->page_data);
	}
} 
	public function add_tsps()
	{  
		if(!$this->session->userdata('member_id'))
		{
			return redirect('home/member_login');
		}
		$this->load->view('front/member_inventory/add_tsps');
	 
	 }

    public function add_tsps_do()
    {
      $this->load->library('form_validation');
	 $this->form_validation->set_rules('name',' TSP Name','required|trim');
	 $this->form_validation->set_rules('contract_name',' Contract Name','required|trim');
	 $this->form_validation->set_rules('employee_name',' Employee Name','required|trim');
	 $this->form_validation->set_rules('employee_contact',' Emplyee Contact','required|trim');
	 $this->form_validation->set_rules('tsp_address',' TSP Address','required|trim');
	 $this->form_validation->set_rules('employee_designation',' Employee Designation','trim');
	 $this->form_validation->set_rules('commencement_date',' Contract Commencement Date','trim');
	 $this->form_validation->set_rules('expiry_date',' Contract Expiry Date','trim');
	 if($this->form_validation->run() == TRUE)
	 {
		$data = array(
			'name' => $this->input->post('name'),
			'contract_name' => $this->input->post('contract_name'),
			'contract_commence_date' => $this->input->post('commencement_date'),
			'contract_expire_date' => $this->input->post('expiry_date'),
			'person_name' => $this->input->post('employee_name'),
			'person_designation' => $this->input->post('employee_designation'),
			'person_contact' => $this->input->post('employee_contact'),
			'address' => $this->input->post('tsp_address'),
			);
		$this->db->insert('tsp',$data);
		echo json_encode(array('response' => true, 'message' =>'TSP Added Successfully','is_redirect' => True,'redirect_url' => base_url().'member_inventory/first_page')); exit;
	 } 
	 else
	 {
		echo json_encode(array('response' => TRUE ,'message' => validation_errors())); exit;
	 }
	}

	public function tsp_edit($para1 = ''){
		if(!$para1){
			echo '<div class="alert alert-dismissible alert-danger">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>OOPS!</strong> Invalid Request
				</div>'; exit;

		}
		$this->page_data['tsp'] = $this->db->get_where('tsp',array('id' => $para1))->result_array();
		$this->load->view('front/member_inventory/edit_tsp', $this->page_data);
	}

	public function edit_tsp_do($tsp_id = ''){
		if(!$tsp_id){
			echo json_encode(array('response' => TRUE , 'message' => 'Invalid Request')); exit;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name',' TSP Name','required|trim');
		$this->form_validation->set_rules('contract_name',' Contract Name','required|trim');
		$this->form_validation->set_rules('employee_name',' Employee Name','required|trim');
		$this->form_validation->set_rules('employee_contact',' Emplyee Contact','required|trim');
		$this->form_validation->set_rules('tsp_address',' TSP Address','required|trim');
		$this->form_validation->set_rules('employee_designation',' Employee Designation','trim');
		$this->form_validation->set_rules('commencement_date',' Contract Commencement Date','trim');
		$this->form_validation->set_rules('expiry_date',' Contract Expiry Date','trim');
		
		if($this->form_validation->run() == TRUE){
			$data = array(
				'name' => $this->input->post('name'),
				'contract_name' => $this->input->post('contract_name'),
				'contract_commence_date' => $this->input->post('commencement_date'),
				'contract_expire_date' => $this->input->post('expiry_date'),
				'person_name' => $this->input->post('employee_name'),
				'person_designation' => $this->input->post('employee_designation'),
				'person_contact' => $this->input->post('employee_contact'),
				'address' => $this->input->post('tsp_address'),
				);
			$this->db->where('id',$tsp_id);
			$this->db->update('tsp',$data);
				echo json_encode(array('response' => true, 'message' => 'Supplier updated successfully','is_redirect' => True,'redirect_url' => base_url().'member_inventory/first_page/')); exit;
			}else{

				echo json_encode(array('response' => TRUE , 'message' => validation_errors())); exit;

		}
	}
	/** T.S.P area END */

	/** Manufacturer area START */
public function manufacturers($para1 = '' , $para2 = '', $para3 =''){
	if(!$this->session->userdata('member_id')){
		
		return redirect('home/member_login');

	}
	if($para1 == 'list')
	{
		$this->page_data['manufacturers'] = $this->Inventory_model->get_manufacturers();
		$this->load->view('front/member_inventory/display_manufacturers',$this->page_data);	
	}
	elseif($para1 == 'delete'){
		$this->db->where('id', $para2);
		$this->db->delete('manufacturers');
		echo json_encode(array('response' => true, 'message' => 'Deleted successfully','is_redirect' => True,'redirect_url' => base_url().'member_inventory/first_page/')); exit;
	}elseif ($para1 == 'manufacturers_publish_set') {
					$article = $para2;
					if ($para3 == 'true') {
							$data['status'] = '1';
					} else {
							$data['status'] = '0';
					}
					$this->db->where('id', $article);
					$this->db->update('manufacturers', $data);
		
				 echo $para3;
			}else{
				$this->page_data['page'] = 'manufacturer';
		$this->load->view('front/inventory/first_page', $this->page_data);
	}
} 
	public function add_manufacturer()
	{  
		if(!$this->session->userdata('member_id'))
		{
			return redirect('home/member_login');
		}
		$this->load->view('front/member_inventory/add_manufacturer');
	 }
	 

    public function add_manufacturer_do()
    {
      $this->load->library('form_validation');
	 $this->form_validation->set_rules('manufacturer_name',' Manufacturer Name','required|trim');
	 $this->form_validation->set_rules('manufacturer_[description]',' Manufacturer Description','required|trim');
	 if($this->form_validation->run() == TRUE)
	 {
		$data = array(
			'name' => $this->input->post('manufacturer_name'),
			'description' => $this->input->post('manufacturer_[description]')
			);
		$this->db->insert('manufacturers',$data);
		echo json_encode(array('response' => true, 'message' =>'Manufacturer Added Successfully','is_redirect' => True,'redirect_url' => base_url().'member_inventory/first_page')); exit;
	 } 
	 else
	 {
		echo json_encode(array('response' => TRUE ,'message' => validation_errors())); exit;
	 }
	}

	public function manufacturer_edit($para1 = ''){
		if(!$para1){
			echo '<div class="alert alert-dismissible alert-danger">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>OOPS!</strong> Invalid Request
				</div>'; exit;
		}
		$this->page_data['manufacturer'] = $this->db->get_where('manufacturers',array('id' => $para1))->result_array();
		$this->load->view('front/member_inventory/edit_manufacturer', $this->page_data);
	}

	public function edit_manufacturer_do($manufacturer_id = ''){
		if(!$manufacturer_id){
			echo json_encode(array('response' => TRUE , 'message' => 'Invalid Request')); exit;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('manufacturer_name',' Manufacturer Name','required|trim');
	  $this->form_validation->set_rules('manufacturer_[description]',' Manufacturer Description','required|trim');
		
		if($this->form_validation->run() == TRUE){
			$data = array(
				'name' => $this->input->post('manufacturer_name'),
				'description' => $this->input->post('manufacturer_[description]')
				);
			$this->db->where('id',$manufacturer_id);
			$this->db->update('manufacturers',$data);
				echo json_encode(array('response' => true, 'message' => 'Manufacturer updated successfully','is_redirect' => True,'redirect_url' => base_url().'member_inventory/first_page/')); exit;
			}else{

				echo json_encode(array('response' => TRUE , 'message' => validation_errors())); exit;

		}
	}
	/** Manufacturer area END */






		
}//class End

?>

	


	


