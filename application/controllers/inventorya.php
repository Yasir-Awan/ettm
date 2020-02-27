<?php 
defined('BASEPATH') OR EXIT('NO DIRECT SCRIPT ALLOWED');
class Inventory extends CI_Controller
{
     public function __construct()
	{
		parent::__construct();
		$this->page_data = array();
		$this->page_data['page_url'] = current_url();
		$this->load->model('Inventory_model');
     }
     /************************************************************/
	/************************ Inventory START *******************/
	/************************************************************/
	/** First Page START */
	public function first_page()
	{
		$this->page_data['page'] = 'inventory';
		$this->load->model('Inventory_model');
		if($this->session->userdata('adminid'))
		{
		$this->page_data['sites'] = $this->Inventory_model->getsites();
		$this->page_data['items'] = $this->Inventory_model->get_Items();
	    $this->load->view('back/includes/header', $this->page_data);
		$this->load->view('back/inventory/first_page', $this->page_data);
		$this->load->view('back/includes/footer', $this->page_data);
		}	
	}
	/** First Page END */

  /** Tabs START */
	public function tabs($para1 = '' )
	{  
		if(!$this->session->userdata('adminid')){
			return redirect('admin/login');
		}

		if($para1 == 'items')
		{
			$this->page_data['items'] = $this->Inventory_model->get_Items();
			$this->load->view('back/inventory/display_items', $this->page_data);
		}
		elseif($para1 == 'assets')
		{
			return redirect('inventory/assets/list/');
		}
		elseif($para1 == 'installed')
		{
			return redirect('inventory/installed_inventory/list/');
		}
		elseif($para1 == 'sites')
		{
			return redirect('inventory/sites/list/');
		}
		elseif($para1 == 'suppliers')
		{
			return redirect('inventory/suppliers/list/');
		}
		elseif($para1 == 'support_providers')
		{
			return redirect('inventory/tsp/list/');
		}
		elseif($para1 == 'manufacturers')
		{
			return redirect('inventory/manufacturers/list/');
		}
		elseif($para1 == 'subitems')
		{
			return redirect('inventory/subitems/list/');
		}
		elseif($para1 == 'installed_subitems')
		{
			return redirect('inventory/installed_sub_inventory/list/');
		}
	}
	/** Tabs END */
		
	
	
	/** items area START */	
	public function items($para1 = '' , $para2 = '', $para3 =''){
		if(!$this->session->userdata('adminid')){
			
			return redirect('admin/login');

		}
		if($para1 == 'reload'){
			return redirect('inventory/tabs/items/');	
		}
		if($para1 == 'list'){
			$this->page_data['items'] = $this->Inventory_model->get_Items();
			$this->load->view('back/inventory/display_items', $this->page_data);	
		}
		elseif($para1 == 'delete'){

			$this->db->where('item_id', $para2);
			$this->db->delete('faulty_equipment_list');

			$this->db->where('name', $para2);
			$this->db->delete('installed_inventory');

			$this->db->where('item_id', $para2);
			$this->db->delete('installed_subitems');

			$this->db->where('item_id', $para2);
			$this->db->delete('sub_assets');

			$this->db->where('item_id', $para2);
			$this->db->delete('sub_items');

			$this->db->where('name', $para2);
			$this->db->delete('assets');

			$this->db->where('item_id', $para2);
			$this->db->delete('asset_transaction');
			$this->db->where('id', $para2);
			$this->db->delete('items');
			echo json_encode(array('response' => true, 'message' => 'Deleted successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page/')); exit;
		}
		elseif ($para1 == 'item_publish_set'){
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
			$this->load->view('back/inventory/first_page', $this->page_data);
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
    
    public function add_item_do()
    {
      $this->load->library('form_validation');
	 $this->form_validation->set_rules('item_name',' ITEM Name','required|trim');
	 $this->form_validation->set_rules('item_type',' ITEM Type','required|trim');
	 $this->form_validation->set_rules('subitems',' Have Sub Items','required|trim');
	 $this->form_validation->set_rules('item_[description]',' ITEM Description','required|trim');
	 if($this->form_validation->run() == TRUE)
	 {
		$data = array(
			'item_type' => $this->input->post('item_type'),
			'name' => $this->input->post('item_name'),
			'have_sub_items' => $this->input->post('subitems'),
			'description' => $this->input->post('item_[description]'),
			'date'		  => time(),
			'user_type'		  => 1,
			'user'		  => $this->session->userdata('adminid'),
			);
		$this->db->insert('items',$data);
		echo json_encode(array('response' => true, 'message' =>'Item Added Successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;
	 } 
	 else
	 {
		echo json_encode(array('response' => TRUE ,'message' => validation_errors())); exit;
	 }
	}
	
	public function items_edit($para1 = ''){
		if(!$para1){
			echo '<div class="alert alert-dismissible alert-danger">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>OOPS!</strong> Invalid Request
				</div>'; exit;
		}
		$this->page_data['item'] = $this->db->get_where('items',array('id' => $para1))->result_array();
		$this->load->view('back/inventory/edit_items', $this->page_data);
	}

	public function edit_item_do($item_id = ''){
		if(!$item_id){
			echo json_encode(array('response' => TRUE , 'message' => 'Invalid Request')); exit;
		}
		$this->load->library('form_validation');
	 $this->form_validation->set_rules('item-name',' ITEM Name','required|trim');
	 $this->form_validation->set_rules('item_type',' ITEM Type','required|trim');
	 $this->form_validation->set_rules('subitems',' Have Sub Items','required|trim');
	 $this->form_validation->set_rules('item-[description]',' ITEM Description','required|trim');
		if($this->form_validation->run() == TRUE){
			$data = array(
				'item_type' => $this->input->post('item_type'),
				'name' => $this->input->post('item-name'),
				'have_sub_items' => $this->input->post('subitems'),
				'description' => $this->input->post('item-[description]'),
				'date'		  => time(),
				'user_type'		  => 1,
				'user'		  => $this->session->userdata('adminid'),
				);
			$this->db->where('id',$item_id);
			$this->db->update('items',$data);
				echo json_encode(array('response' => true, 'message' => 'Item updated successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page/')); exit;
			}
			else
			{
				echo json_encode(array('response' => TRUE , 'message' => validation_errors())); exit;
		}
	}
	/**  items area END */

	/** Subitems area START */
	public function subitems($para1 = '' , $para2 = '', $para3 =''){
		if(!$this->session->userdata('adminid')){
			
			return redirect('admin/login');

		}
		if($para1 == 'reload'){
			return redirect('inventory/tabs/subitems/');	
		}
		if($para1 == 'list'){
			$this->page_data['subitems'] = $this->db->get('sub_items')->result_array();
			$this->load->view('back/inventory/display_subitems', $this->page_data);	
		}
		elseif($para1 == 'delete'){

			$this->db->where('subitem_id', $para2);
			$this->db->delete('faulty_equipment_list');

			$this->db->where('subitem_id', $para2);
			$this->db->delete('installed_subitems');

			$this->db->where('subitem_id', $para2);
			$this->db->delete('sub_assets');

			$this->db->where('subitem_id', $para2);
			$this->db->delete('asset_transaction');
			
			$this->db->where('id', $para2);
			$this->db->delete('sub_items');
			echo json_encode(array('response' => true, 'message' => 'Deleted successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page/')); exit;
		}elseif ($para1 == 'item_publish_set') {
            $article = $para2;
            if ($para3 == 'true') {
                $data['status'] = '1';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('id', $article);
            $this->db->update('sub_items', $data);
			
           echo $para3;
        }else{
        	$this->page_data['page'] = 'Subitems';
			$this->load->view('back/inventory/first_page', $this->page_data);
		}
	}
	
	public function add_subitem()
	{  
		if(!$this->session->userdata('adminid'))
		{
			return redirect('admin/login');
		}
		$items = $this->db->get_where('items',array('have_sub_items' => 1))->result_array();
		$this->page_data['item_category'] = $items;
		$this->load->view('back/inventory/add_subitems', $this->page_data);
		
     }
    
    public function add_subitem_do()
    {
      $this->load->library('form_validation');
	 $this->form_validation->set_rules('item_name',' ITEM Name','required|trim');
	 $this->form_validation->set_rules('subitem_name',' SubItem Name','required|trim');
	 $this->form_validation->set_rules('item_category',' ITEM Category','required|trim');
	 $this->form_validation->set_rules('item_[description]',' ITEM Description','required|trim');
	 if($this->form_validation->run() == TRUE)
	 { 
		$asset = $this->db->get_where('assets',array('name' => $this->input->post('item_name')))->result_array();  
		if(empty($asset)){
			if($this->input->post('quantity')>1){
				$quantity = $this->input->post('quantity');
			   //   echo "<pre>"; print_r($qty); exit;
				for($i=0; $i<$quantity; $i++){
				   $data = array(
					   'item_type' => $this->input->post('item_category'),
					   'item_id' => $this->input->post('item_name'),
					   'name' => $this->input->post('subitem_name'),
					   'description' => $this->input->post('item_[description]'),
					   'action_date' => date("Y-m-d H:i:s"),
					   'same' => 1,
					   'action_by_user_type' => 1,
					   'action_by_user' => $this->session->userdata('adminid')
					   );
				   $this->db->insert('sub_items',$data);
				}
			}
			else
			{
			   $data = array(
				   'item_type' => $this->input->post('item_category'),
				   'item_id' => $this->input->post('item_name'),
				   'name' => $this->input->post('subitem_name'),
				   'description' => $this->input->post('item_[description]'),
				   'action_date'		  => date("Y-m-d H:i:s"),
				   'action_by_user_type'		  => 1,
				   'action_by_user'		  => $this->session->userdata('adminid')
				   );
			   $this->db->insert('sub_items',$data);
			}
			echo json_encode(array('response' => true, 'message' =>'Sub Item Added Successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;
		}
		if(!empty($asset))
		{
			if($asset[0]['action_status']==0){
				if($this->input->post('quantity')>1){
					$quantity = $this->input->post('quantity');
				   //   echo "<pre>"; print_r($qty); exit;
					for($i=0; $i<$quantity; $i++){
					    $data = array(
							'item_type' => $this->input->post('item_category'),
							'item_id' => $this->input->post('item_name'),
							'name' => $this->input->post('subitem_name'),
							'description' => $this->input->post('item_[description]'),
							'action_date'		  => date("Y-m-d H:i:s"),
							'same'		  => 1,
							'action_by_user_type'		  => 1,
							'action_by_user'		  => $this->session->userdata('adminid')
							);
						$this->db->insert('sub_items',$data);

	 
						$subAssetsData = array(
							'subitem_id' => $ref_id,
							'equipment_warranty'=>1,
							'product_model_no' => $asset[0]['product_model_no'],
							'cost_price' => $asset[0]['cost_price'],
							'supplier' => $asset[0]['supplier'],
							'manufacturer' => $asset[0]['manufacturer'],
							'site' => $asset[0]['site'],
							'purchased_on' => $asset[0]['purchased_on'],
							'warranty_type' => $asset[0]['warranty_type'],
							'warranty_duration' => $asset[0]['warranty_duration'],
							'item_id' => $asset[0]['name'],
							'asset_id' => $asset[0]['id'],
						    'user_type' => '1',
						    'user' => $this->session->userdata('adminid'),
						    'action_date' => date("Y-m-d H:i:s")
					  );
					  $this->db->insert('sub_assets',$subAssetsData);
					  

					}
				}
				else{
					$data = array(
						'item_type' => $this->input->post('item_category'),
						'item_id' => $this->input->post('item_name'),
						'name' => $this->input->post('subitem_name'),
						'description' => $this->input->post('item_[description]'),
						'action_date'		  => date("Y-m-d H:i:s"),
						'action_by_user_type'		  => 1,
						'action_by_user'		  => $this->session->userdata('adminid')
						);
					$this->db->insert('sub_items',$data);
					$ref_id = $this->db->insert_id('');

 
					$subAssetsData = array(
						'subitem_id' => $ref_id,
						'equipment_warranty'=>1,
						'product_model_no' => $asset[0]['product_model_no'],
						'cost_price' => $asset[0]['cost_price'],
						'supplier' => $asset[0]['supplier'],
						'manufacturer' => $asset[0]['manufacturer'],
						'site' => $asset[0]['site'],
						'purchased_on' => $asset[0]['purchased_on'],
						'warranty_type' => $asset[0]['warranty_type'],
						'warranty_duration' => $asset[0]['warranty_duration'],
						'item_id' => $asset[0]['name'],
						'asset_id' => $asset[0]['id'],
					 'user_type' => '1',
					 'user' => $this->session->userdata('adminid'),
					 'action_date' => date("Y-m-d H:i:s")
				  );
				  $this->db->insert('sub_assets',$subAssetsData);
				}
			}
			if($asset[0]['action_status']!=0){

				if($this->input->post('quantity')>1){
					$quantity = $this->input->post('quantity');
				   //   echo "<pre>"; print_r($qty); exit;
					for($i=0; $i<$quantity; $i++){
					   $data = array(
						   'item_type' => $this->input->post('item_category'),
						   'item_id' => $this->input->post('item_name'),
						   'name' => $this->input->post('subitem_name'),
						   'description' => $this->input->post('item_[description]'),
						   'action_date'		  => date("Y-m-d H:i:s"),
						   'same'		  => 1,
						   'action_by_user_type'		  => 1,
						   'action_by_user'		  => $this->session->userdata('adminid')
						   );
					   $this->db->insert('sub_items',$data);
					   $subitem_id = $this->db->insert_id();
                          
					   $subAssetsData = array(
						'subitem_id' => $subitem_id,
						'equipment_warranty'=>0,
						'action_status'=>3,
						'product_model_no' => $this->input->post('comp_model'),
						'cost_price' => $this->input->post('subasset_price'),
						'supplier' => $this->input->post('supplier'),
						'manufacturer' => $this->input->post('manufacturer'),
						'site' => $asset[0]['site'],
						'purchased_on' => $this->input->post('cmp_purchase_date'),
						'warranty_type' => $this->input->post('warranty_type'),
						'warranty_duration' => $this->input->post('warranty_duration'),
						'item_id' => $this->input->post('item_name'),
						'asset_id' => $asset[0]['id'],
					 'user_type' => '1',
					 'user' => $this->session->userdata('adminid'),
					 'action_date' => date("Y-m-d H:i:s"),
				  );
				  $this->db->insert('sub_assets',$subAssetsData);
				  $subAssetId = $this->db->insert_id();

					 $installed = $this->db->get_where('installed_inventory',array('asset_id' => $asset[0]['id']))->result_array();
                      foreach($installed as $install){
						// $this->db->get_where('installed_inventory',array('asset_id' => $asset[0]['id']))->result_array();
						$sub_installed_data = array(
							'item_id'=>$this->input->post('item_name'),
							'subasset_id'=>$subAssetId,
							'subitem_id'=>$subitem_id,
							'asset_id'=>$asset[0]['id'],
							'installed_id'=>$install['id'],
							'serial_no'=>$this->input->post('comp_serial'),
							'model_no'=>$this->input->post('comp_model'),
							'manufacturer'=>$this->input->post('manufacturer'),
							'supplier'=>$this->input->post('supplier'),
							'cost'=>$this->input->post('subasset_price'),
							'purchased_on'=>$this->input->post('cmp_purchase_date'),
							'warranty_type'=>$this->input->post('warranty_type'),
							'warranty_duration'=>$this->input->post('warranty_duration'),
							'site'=>$install['site'],
							'location'=>$install['location'],
							'comments'=> $this->input->post('item_[description]'),
							'transaction_type'=> 3,
							'action_date' => date("Y-m-d H:i:s"),
							'action_by_user_type' => 1,
							'action_by_user' => $this->session->userdata('adminid')
						);
						$this->db->insert('installed_subitems',$sub_installed_data);
						$subInstallId = $this->db->insert_id();
	
						$asset_transaction_data = array(
							'asset_id' => $asset[0]['id'],
							'installed_id' => $install['id'],
							'item_id'=>$install['name'],
							'subitem_id'=>$subitem_id,
							'is_sub_item' => 1,
							'serial_no'=>$this->input->post('comp_serial'),
							'installed_subitem_id' => $subInstallId,
							'transaction_type' => "3",
							'site' => $install['site'],
							'location' => $install['location'],
							'user_type' => "1",
							'added_by' => $this->session->userdata('adminid'),
							'action_date' => date("Y-m-d H:i:s"),
							'organisation_type' => $install['company_type'],
							'organisation' => $install['company_name'],
							'organisation_address' => $install['company_address'],
							'repairing_person_type' => $install['company_person_type'],
							'person' => $install['person_name'],
							'person_contact' => $install['person_contact'],
							'cost' => $this->input->post('subasset_price'),
							'action_comments' => $this->input->post('item_[description]'),
							);
						 $this->db->insert('asset_transaction',$asset_transaction_data);
					  }
					}
				}
				else{
					$data = array(
						'item_type' => $this->input->post('item_category'),
						'item_id' => $this->input->post('item_name'),
						'name' => $this->input->post('subitem_name'),
						'description' => $this->input->post('item_[description]'),
						'action_date'		  => date("Y-m-d H:i:s"),
						'action_by_user_type'		  => 1,
						'action_by_user'		  => $this->session->userdata('adminid')
						);
					$this->db->insert('sub_items',$data);
					$subitem_id = $this->db->insert_id();
 
					$subAssetsData = array(
						'subitem_id' => $subitem_id,
						'equipment_warranty'=>0,
						'action_status'=>3,
						'product_model_no' => $this->input->post('comp_model'),
						'cost_price' => $this->input->post('subasset_price'),
						'supplier' => $this->input->post('supplier'),
						'manufacturer' => $this->input->post('manufacturer'),
						'site' => $asset[0]['site'],
						'purchased_on' => $this->input->post('cmp_purchase_date'),
						'warranty_type' => $this->input->post('warranty_type'),
						'warranty_duration' => $this->input->post('warranty_duration'),
						'item_id' => $this->input->post('item_name'),
						'asset_id' => $asset[0]['id'],
					 'user_type' => '1',
					 'user' => $this->session->userdata('adminid'),
					 'action_date' => date("Y-m-d H:i:s"),
				  );
				  $this->db->insert('sub_assets',$subAssetsData);
				  $subAssetId = $this->db->insert_id();

				  $installed = $this->db->get_where('installed_inventory',array('asset_id' => $asset[0]['id']))->result_array();
				   foreach($installed as $install){
					 // $this->db->get_where('installed_inventory',array('asset_id' => $asset[0]['id']))->result_array();
					 $sub_installed_data = array(
						'item_id'=>$this->input->post('item_name'),
						'subasset_id'=>$subAssetId,
						'subitem_id'=>$subitem_id,
						'asset_id'=>$asset[0]['id'],
						'installed_id'=>$install['id'],
						'serial_no'=>$this->input->post('comp_serial'),
						'model_no'=>$this->input->post('comp_model'),
						'manufacturer'=>$this->input->post('manufacturer'),
						'supplier'=>$this->input->post('supplier'),
						'cost'=>$this->input->post('subasset_price'),
						'purchased_on'=>$this->input->post('cmp_purchase_date'),
						'warranty_type'=>$this->input->post('warranty_type'),
						'warranty_duration'=>$this->input->post('warranty_duration'),
						'site'=>$install['site'],
						'location'=>$install['location'],
						'comments'=> $this->input->post('item_[description]'),
						'transaction_type'=> 3,
						'action_date' => date("Y-m-d H:i:s"),
						'action_by_user_type' => 1,
						'action_by_user' => $this->session->userdata('adminid')
					);
					$this->db->insert('installed_subitems',$sub_installed_data);
					$subInstallId = $this->db->insert_id();

					$asset_transaction_data = array(
						'asset_id' => $asset[0]['id'],
						'installed_id' => $install['id'],
						'item_id'=>$install['name'],
						'subitem_id'=>$subitem_id,
						'is_sub_item' => 1,
						'serial_no'=>$this->input->post('comp_serial'),
						'installed_subitem_id' => $subInstallId,
						'transaction_type' => "3",
						'site' => $install['site'],
						'location' => $install['location'],
						'user_type' => "1",
						'added_by' => $this->session->userdata('adminid'),
						'action_date' => date("Y-m-d H:i:s"),
						'organisation_type' => $install['company_type'],
						'organisation' => $install['company_name'],
						'organisation_address' => $install['company_address'],
						'repairing_person_type' => $install['company_person_type'],
						'person' => $install['person_name'],
						'person_contact' => $install['person_contact'],
						'cost' => $this->input->post('subasset_price'),
						'action_comments' => $this->input->post('item_[description]'),
						);
					 $this->db->insert('asset_transaction',$asset_transaction_data);
				   }
				}
		}
		
		echo json_encode(array('response' => true, 'message' =>'Sub Item Added Successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;
	 } 
	}
	 else
	 {
		echo json_encode(array('response' => TRUE ,'message' => validation_errors())); exit;
	 }
	}
	
	public function subitems_edit($para1 = ''){
		if(!$para1){
			echo '<div class="alert alert-dismissible alert-danger">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>OOPS!</strong> Invalid Request
				</div>'; exit;
		}
		$this->page_data['subitems'] = $this->db->get_where('sub_items',array('id' => $para1))->result_array();
		$this->load->view('back/inventory/edit_subitems', $this->page_data);
	}

	public function edit_subitem_do($subitem_id = ''){
		if(!$subitem_id){
			echo json_encode(array('response' => TRUE , 'message' => 'Invalid Request')); exit;
		}
		$this->load->library('form_validation');
		// $this->form_validation->set_rules('item_name',' ITEM Name','required|trim');
		$this->form_validation->set_rules('subitem_name',' SubItem Name','required|trim');
		$this->form_validation->set_rules('item_category',' ITEM Category','required|trim');
		$this->form_validation->set_rules('subitem_[description]',' ITEM Description','required|trim');
		if($this->form_validation->run() == TRUE){
			$data = array(
				'item_type' => $this->input->post('item_category'),
				'item_id' => $this->input->post('item_name'),
				'name' => $this->input->post('subitem_name'),
				'description' => $this->input->post('subitem_[description]'),
				'action_date'		  => time(),
				'action_by_user_type'		  => 1,
				'action_by_user'		  => $this->session->userdata('adminid')
				);
			$this->db->where('id',$subitem_id);
			$this->db->update('sub_items',$data);
				echo json_encode(array('response' => true, 'message' => 'Sub Item updated successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page/')); exit;
			}
			else
			{
				echo json_encode(array('response' => TRUE , 'message' => validation_errors())); exit;
		}
	}

	public function items_have_subitems($para1 = '')
	{  
		$items = $this->db->get_where('items',array('item_type' => $para1, 'have_sub_items' => 1))->result_array();
		if($items)
		{   
			$data = array( 'items'=>$items);	
		  echo json_encode($data); 
		}
		else
		{
			echo json_encode("No Item exist of This type.");
		}
		
	 }
	 
	 public function item_installed_or_not($para1 = '')
	 {  
		 $items = $this->db->get_where('assets',array('name' => $para1, 'have_sub_assets' => 1))->result_array();
		 if(isset($items))
		 {   
			 foreach($items as $row){
				 if($row['action_status']!=0){
					$data = 1;	
					echo json_encode($data);
				 }
				 if($row['action_status']==0){
					$data = 0;	
					echo json_encode($data);
				 }
			 } 
		 }
		 else
		 {
			$data = 0;	
			echo json_encode($data);
		 }
		 
	  }
	/** Subitems area END */


	/** Site area START */
	public function sites($para1 = '' , $para2 = '', $para3 =''){
		if(!$this->session->userdata('adminid')){
			
			return redirect('admin/login');

		}
		if($para1 == 'list'){
			$this->page_data['sites'] = $this->Inventory_model->getsites();
			$this->load->view('back/inventory/display_sites',$this->page_data);	
		}
		elseif($para1 == 'delete'){
			$this->db->where('id', $para2);
			$this->db->delete('sites');
			$this->db->where('site', $para2);
			$this->db->delete('locations');
			echo json_encode(array('response' => true, 'message' => 'Deleted successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page/')); exit;
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
			$this->load->view('back/inventory/first_page', $this->page_data);
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
		$this->load->view('back/inventory/edit_sites', $this->page_data);
	}

	public function edit_site_do($site_id = ''){
		//echo $site_id; exit;
		if(!$site_id){
			echo json_encode(array('response' => TRUE , 'message' => 'Invalid Request')); exit;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('site_name',' Site Name','required|trim');
		
		if($this->form_validation->run() == TRUE){
			$data = array(
				'name' => $this->input->post('site_name')
				);
			$this->db->where('id',$site_id);
			$this->db->update('sites',$data);
			// $site_id = $this->db->insert_id();
   
			$locationNames = $this->input->post('site_location_name');
			$locationIds = $this->input->post('site_location_id');
		
			 $counter = 0;
			foreach($locationIds as $id)
			{
				
			   		$dataForLocations = array(
				   	'location' => $locationNames[$counter],
				   	);
				   $counter++;
				   $this->db->where('id',$id);
				   $this->db->update('locations',$dataForLocations);
				   	
			}
			echo json_encode(array('response' => true, 'message' =>'Site Updated Successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;
			}
			else
			{
				echo json_encode(array('response' => TRUE , 'message' => validation_errors())); exit;
		    }
	    }



	public function add_site()
	{  
		if(!$this->session->userdata('adminid'))
		{
			return redirect('admin/login');
		}
		$this->load->view('back/inventory/add_sites');
		
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
		 $site_id = $this->db->insert_id();


			$general = $this->input->post('general[]');
			if(isset($general))
			{
				foreach($general as $gnrl)
				{
					$gdata = array(
						'site' => $site_id,
						'location_type' => 1,
						'location' => $gnrl,						
					);
					$this->db->insert('locations',$gdata);
				}
			}

			$north = $this->input->post('north[]');
			if(isset($north))
			{
				foreach($north as $nrth)
				{
					$ndata = array(
						'site' => $site_id,
						'location_type' => 2,
						'location' => $nrth,						
					);
					$this->db->insert('locations',$ndata);
				}
			}

			$northBooths = $this->input->post('northBooths[]');
			if(isset($northBooths))
			{
				foreach($northBooths as $nb)
				{
					$nBData = array(
						'site' => $site_id,
						'location_type' => 2,
						'inside_booth' => 1,
						'location' => $nb,						
					);
					$this->db->insert('locations',$nBData);
				}
			}

			$south = $this->input->post('south[]');
			if(isset($south))
			{
				foreach($south as $sth)
				{
					$sdata = array(
						'site' => $site_id,
						'location_type' => 3,
						'location' => $sth,						
					);
					$this->db->insert('locations',$sdata);
				}
			}

			$southBooths = $this->input->post('southBooths[]');
			if(isset($southBooths))
			{
				foreach($southBooths as $sthBth)
				{
					$sBData = array(
						'site' => $site_id,
						'location_type' => 3,
						'inside_booth' => 1,
						'location' => $sthBth,						
					);
					$this->db->insert('locations',$sBData);
				}
			}
		 
		 echo json_encode(array('response' => true, 'message' =>'Site Added Successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;
	  } 
	  else
	  {
		 echo json_encode(array('response' => TRUE ,'message' => validation_errors())); exit;
	  }
	 }
	/** Site area END*/

	 

	

	
// /** Location area START */
// public function locations($para1 = '' , $para2 = '', $para3 =''){
// 	if(!$this->session->userdata('adminid'))
// 	{	
// 		return redirect('admin/login');
// 	}
// 	if($para1 == 'list')
// 	{
// 		$this->page_data['locations'] = $this->Inventory_model->get_locations();
// 		$this->load->view('back/inventory/display_locations',$this->page_data);	
// 	}
// 	elseif($para1 == 'delete')
// 	{
// 		$this->db->where('id', $para2);
// 		$this->db->delete('locations');
// 		echo json_encode(array('response' => true, 'message' => 'Deleted successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page/')); exit;
// 	}
// 	elseif ($para1 == 'location_publish_set') 
// 	{
// 					$article = $para2;
// 					if ($para3 == 'true') {
// 							$data['status'] = '1';
// 					} else {
// 							$data['status'] = '0';
// 					}
// 					$this->db->where('id', $article);
// 					$this->db->update('locations', $data);
		
// 				 echo $para3;
// 			}else{
// 				$this->page_data['page'] = 'locations';
// 		$this->load->view('back/inventory/first_page', $this->page_data);
// 	}
// } 
// 	public function add_location()
// 	{  
// 		if(!$this->session->userdata('adminid'))
// 		{
// 			return redirect('admin/login');
// 		}
// 		$this->load->view('back/inventory/add_locations');
		
// 	 }
	 

//     public function add_location_do()
//     {
//       $this->load->library('form_validation');
// 	 $this->form_validation->set_rules('location_name',' Location Name','required|trim');
// 	 if($this->form_validation->run() == TRUE)
// 	 {
// 		$data = array(
// 			'name' => $this->input->post('location_name')
// 			);
// 		$this->db->insert('locations',$data);
// 		echo json_encode(array('response' => true, 'message' =>'Location Added Successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;
// 	 } 
// 	 else
// 	 {
// 		echo json_encode(array('response' => TRUE ,'message' => validation_errors())); exit;
// 	 }
// 	}

// 	public function location_edit($para1 = ''){
// 		if(!$para1){
// 			echo '<div class="alert alert-dismissible alert-danger">
//   				<button type="button" class="close" data-dismiss="alert">&times;</button>
//   				<strong>OOPS!</strong> Invalid Request
// 				</div>'; exit;

// 		}
// 		$this->page_data['location'] = $this->db->get_where('locations',array('id' => $para1))->result_array();
// 		$this->load->view('back/inventory/edit_locations', $this->page_data);
// 	}

// 	public function edit_location_do($location_id = ''){
// 		if(!$location_id){
// 			echo json_encode(array('response' => TRUE , 'message' => 'Invalid Request')); exit;
// 		}
// 		$this->load->library('form_validation');
// 		$this->form_validation->set_rules('location-name',' Location Name','required|trim');
		
// 		if($this->form_validation->run() == TRUE){
// 			$data = array(
// 				'name' => $this->input->post('location-name')
// 				);
// 			$this->db->where('id',$location_id);
// 			$this->db->update('locations',$data);
// 				echo json_encode(array('response' => true, 'message' => 'Location updated successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page/')); exit;
// 			}else{

// 				echo json_encode(array('response' => TRUE , 'message' => validation_errors())); exit;

// 		}
// 	}
	/** Location area END */
  

  /** Suppliers area START */
public function suppliers($para1 = '' , $para2 = '', $para3 =''){
	if(!$this->session->userdata('adminid')){
		
		return redirect('admin/login');

	}
	if($para1 == 'list')
	{
		$this->page_data['suppliers'] = $this->Inventory_model->get_suppliers();
		$this->load->view('back/inventory/display_suppliers',$this->page_data);	
	}
	elseif($para1 == 'delete'){
		$this->db->where('id', $para2);
		$this->db->delete('suppliers');
		echo json_encode(array('response' => true, 'message' => 'Deleted successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page/')); exit;
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
		$this->load->view('back/inventory/first_page', $this->page_data);
	}
} 
	public function add_supplier()
	{  
		if(!$this->session->userdata('adminid'))
		{
			return redirect('admin/login');
		}
		$this->load->view('back/inventory/add_suppliers');
		
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
		echo json_encode(array('response' => true, 'message' =>'Supplier Added Successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;
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
		$this->load->view('back/inventory/edit_supplier', $this->page_data);
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
				echo json_encode(array('response' => true, 'message' => 'Supplier updated successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page/')); exit;
			}else{

				echo json_encode(array('response' => TRUE , 'message' => validation_errors())); exit;

		}
	}
	/** Suppliers area END */

	  /** T.S.P area START */
public function tsp($para1 = '' , $para2 = '', $para3 =''){
	if(!$this->session->userdata('adminid')){
		
		return redirect('admin/login');

	}
	if($para1 == 'list')
	{
		$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
		$this->load->view('back/inventory/display_tsps',$this->page_data);	
	}
	elseif($para1 == 'delete'){
		$this->db->where('id', $para2);
		$this->db->delete('tsp');
		echo json_encode(array('response' => true, 'message' => 'Deleted successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page/')); exit;
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
		$this->load->view('back/inventory/first_page', $this->page_data);
	}
} 
	public function add_tsps()
	{  
		if(!$this->session->userdata('adminid'))
		{
			return redirect('admin/login');
		}
		$this->load->view('back/inventory/add_tsps');
	 
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
		echo json_encode(array('response' => true, 'message' =>'TSP Added Successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;
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
		$this->load->view('back/inventory/edit_tsp', $this->page_data);
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
				echo json_encode(array('response' => true, 'message' => 'Supplier updated successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page/')); exit;
			}else{

				echo json_encode(array('response' => TRUE , 'message' => validation_errors())); exit;

		}
	}
	/** T.S.P area END */

	/** Manufacturer area START */
public function manufacturers($para1 = '' , $para2 = '', $para3 =''){
	if(!$this->session->userdata('adminid')){
		
		return redirect('admin/login');

	}
	if($para1 == 'list')
	{
		$this->page_data['manufacturers'] = $this->Inventory_model->get_manufacturers();
		$this->load->view('back/inventory/display_manufacturers',$this->page_data);	
	}
	elseif($para1 == 'delete'){
		$this->db->where('id', $para2);
		$this->db->delete('manufacturers');
		echo json_encode(array('response' => true, 'message' => 'Deleted successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page/')); exit;
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
		$this->load->view('back/inventory/first_page', $this->page_data);
	}
} 
	public function add_manufacturer()
	{  
		if(!$this->session->userdata('adminid'))
		{
			return redirect('admin/login');
		}
		$this->load->view('back/inventory/add_manufacturer');
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
		echo json_encode(array('response' => true, 'message' =>'Manufacturer Added Successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;
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
		$this->load->view('back/inventory/edit_manufacturer', $this->page_data);
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
				echo json_encode(array('response' => true, 'message' => 'Manufacturer updated successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page/')); exit;
			}else{

				echo json_encode(array('response' => TRUE , 'message' => validation_errors())); exit;

		}
	}
	/** Manufacturer area END */


		/** Installed Subitems Area Start */
		public function installed_sub_inventory($para1 = '' , $para2 = '', $para3 =''){
			if(!$this->session->userdata('adminid')){
				return redirect('admin/login');
			}

			if($para1 == 'list')
			{
				$this->page_data['installs'] = $this->Inventory_model->get_installed_subitems();
				$this->page_data['sites'] = $this->Inventory_model->getsites();
				$this->page_data['items'] = $this->Inventory_model->get_Items();
				$this->page_data['asset_transactions'] = $this->Inventory_model->get_asset_transactions();
				$this->load->view('back/inventory/display_installed_subitems', $this->page_data);	
			}

			elseif($para1 == 'delete'){
				$this->db->where('alert_type', 1);
				$this->db->where('ref_id', $para2);
				$this->db->delete('notifications');
				$this->db->where('asset_id', $para2);
				$this->db->delete('asset_transaction');
				$this->db->where('id', $para2);
				$this->db->delete('assets');
				echo json_encode(array('response' => true, 'message' => 'Deleted successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page/')); exit;
			}
			elseif ($para1 == 'assets_publish_set') 
			{
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
				$this->load->view('back/inventory/first_page', $this->page_data);
			}
		}
	
		public function selected_sub_install($para1 = '' , $para2 = '', $para3 =''){
			$this->page_data['page'] = 'selected_installed';
			if(!$this->session->userdata('adminid')){
			return redirect('admin/login');
			}
			if($para1 == 'list')
			{
				$this->page_data['selected_installed'] = $this->db->select('*')->where('id', $para2)->order_by('id','desc')->limit(1)->get('installed_inventory')->result_array();
				$this->page_data['selected_installed_transaction'] = $this->db->select('*')->where('installed_id', $para2)->order_by('id','desc')->limit(1)->get('asset_transaction')->result_array();
				$this->page_data['selected_assets'] = $this->db->get_where('assets',array('id' => $this->page_data['selected_installed'][0]['asset_id']))->result_array();		
				$this->page_data['install_transactions'] = $this->db->select('*')->where('installed_id', $para2)->order_by('id','desc')->get('asset_transaction')->result_array();
				$this->load->view('back/inventory/display_selected_installs',$this->page_data);	
			}
		}
		/** Installed Subitems Area End */





	/** Installed Area Start */
	public function installed_inventory($para1 = '' , $para2 = '', $para3 =''){
		if(!$this->session->userdata('adminid')){
			
			return redirect('admin/login');
	
		}
		if($para1 == 'list')
		{
			$this->page_data['installs'] = $this->Inventory_model->get_installed();
			
			foreach($this->page_data['installs'] as $install){	
				if($install['transaction_type']==11){
					$faulty_comp = $this->db->get_where('sub_items',array('id' => $install['subitem_id']))->result_array();
					$this->page_data['faulty_comp_name'] = $faulty_comp[0]['name'];
					$this->page_data['faulty_component'] = $faulty_comp ;
				}	
				if($install['transaction_type']==12){
					$installed_comp = $this->db->get_where('installed_subitems',array('installed_id' => $install['id'],'transaction_type' => $install['transaction_type']))->result_array();
					$compName = $this->db->get_where('sub_items',array('id' => $installed_comp[0]['subitem_id'],))->result_array();
					$this->page_data['faulty_comp_name'] = $compName[0]['name'];
					$this->page_data['faulty_component'] = $compName ;
				}
				if($install['transaction_type']==13){
					$faulty_comp = $this->db->get_where('sub_items',array('id' => $install['subitem_id']))->result_array();
					$this->page_data['faulty_comp_name'] = $faulty_comp[0]['name'];
					$this->page_data['faulty_component'] = $faulty_comp ;
				}
				if($install['transaction_type']==14){
					$faulty_comp = $this->db->get_where('sub_items',array('id' => $install['subitem_id']))->result_array();
					$this->page_data['faulty_comp_name'] = $faulty_comp[0]['name'];
					$this->page_data['faulty_component'] = $faulty_comp ;
				}	
				if($install['transaction_type']==15){
					$faulty_comp = $this->db->get_where('sub_items',array('id' => $install['subitem_id']))->result_array();
					$this->page_data['faulty_comp_name'] = $faulty_comp[0]['name'];
					$this->page_data['faulty_component'] = $faulty_comp ;
				}		  
			}

			$this->page_data['sites'] = $this->Inventory_model->getsites();
			$this->page_data['items'] = $this->Inventory_model->get_Items();
			$this->page_data['asset_transactions'] = $this->Inventory_model->get_asset_transactions();
			$this->load->view('back/inventory/display_installed', $this->page_data);	
		}
		elseif($para1 == 'delete'){
			
			$this->db->where('alert_type', 1);
			$this->db->where('ref_id', $para2);
			$this->db->delete('notifications');
			$this->db->where('installed_id', $para2);
			$this->db->delete('asset_transaction');
			$this->db->where('installed_id', $para2);
			$this->db->delete('installed_subitems');
			$this->db->where('installed_id', $para2);
			$this->db->delete('faulty_equipment_list');
			$this->db->where('installed_id', $para2);
			$this->db->delete('serial_no');
			$this->db->where('id', $para2);
			$this->db->delete('installed_inventory');
			echo json_encode(array('response' => true, 'message' => 'Deleted successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page/')); exit;
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
			$this->load->view('back/inventory/first_page', $this->page_data);
		}
	}

	public function selected_install($para1 = '' , $para2 = '', $para3 =''){
		$this->page_data['page'] = 'selected_installed';
		if(!$this->session->userdata('adminid')){
		return redirect('admin/login');
		}
		if($para1 == 'list')
		{
			$this->page_data['selected_installed'] = $this->db->select('*')->where('id', $para2)->order_by('id','desc')->limit(1)->get('installed_inventory')->result_array();
			$this->page_data['selected_installed_transaction'] = $this->db->select('*')->where('installed_id', $para2)->where('installed_id', $para2)->order_by('id','desc')->limit(1)->get('asset_transaction')->result_array();
			$this->page_data['selected_assets'] = $this->db->get_where('assets',array('id' => $this->page_data['selected_installed'][0]['asset_id']))->result_array();		
			$installed_transactions = $this->db->select('*')->where('installed_id', $para2)->where('is_sub_item', 1)->order_by('id','desc')->get('asset_transaction')->result_array();
				//    echo "<pre>"; print_r($installed_transactions); exit;
			$this->page_data['install_transactions'] = $installed_transactions;
			$this->load->view('back/inventory/display_selected_installs',$this->page_data);	
		}
	}
	/** Installed Area End */

	/** Assets area START */
public function assets($para1 = '' , $para2 = '', $para3 =''){
	if(!$this->session->userdata('adminid')){
		
		return redirect('admin/login');

	}
	if($para1 == 'list')
	{
		// $site_related_assets = $this->db->get_where('installed_inventory',array('site' => 7))->result_array();
        // foreach($site_related_assets as $row){
		// 	$sra = array(
		// 		'asset' => $row['asset_id'],
		// 		'site' => $row['site'],                
		// 		 );
		// 		 $this->db->insert('site_related_assets',$sra);
		// }
		$this->page_data['assets'] = $this->Inventory_model->get_assets();
		foreach($this->page_data['assets'] as $asset){	
			if($asset['action_status']==11){
				$installed_comp = $this->db->get_where('installed_subitems',array('asset_id' => $asset['id'],'transaction_type' => 11))->result_array();
				$faulty_comp = $this->db->get_where('sub_items',array('id' => $installed_comp[0]['subitem_id']))->result_array();
				$this->page_data['faulty_comp_name'] = $faulty_comp[0]['name'];
			}	
			if($asset['action_status']==12){
				$installed_comp = $this->db->get_where('installed_subitems',array('asset_id' => $asset['id'],'transaction_type' => 12))->result_array();
				$faulty_comp = $this->db->get_where('sub_items',array('id' => $installed_comp[0]['subitem_id']))->result_array();
				$this->page_data['faulty_comp_name'] = $faulty_comp[0]['name'];
			}
			if($asset['action_status']==13){
				$installed_comp = $this->db->get_where('installed_subitems',array('asset_id' => $asset['id'],'transaction_type' => 13))->result_array();
				$faulty_comp = $this->db->get_where('sub_items',array('id' => $installed_comp[0]['subitem_id']))->result_array();
				$this->page_data['faulty_comp_name'] = $faulty_comp[0]['name'];
			}
			if($asset['action_status']==14){
				$installed_comp = $this->db->get_where('installed_subitems',array('asset_id' => $asset['id'],'transaction_type' => 14))->result_array();
				$faulty_comp = $this->db->get_where('sub_items',array('id' => $installed_comp[0]['subitem_id']))->result_array();
				$this->page_data['faulty_comp_name'] = $faulty_comp[0]['name'];
			}	
			if($asset['action_status']==15){
				$installed_comp = $this->db->get_where('installed_subitems',array('asset_id' => $asset['id'],'transaction_type' => 15))->result_array();
				$faulty_comp = $this->db->get_where('sub_items',array('id' => $installed_comp[0]['subitem_id']))->result_array();
				$this->page_data['faulty_comp_name'] = $faulty_comp[0]['name'];
			}		  
		}
		
		$this->page_data['sites'] = $this->Inventory_model->getsites();
		// $this->page_data['sites'] = $this->Inventory_model->asset_related_sites();
		$this->page_data['items'] = $this->Inventory_model->get_Items();
		$this->page_data['asset_transactions'] = $this->Inventory_model->get_asset_transactions();
		$this->load->view('back/inventory/display_assets',$this->page_data);	
	}
	elseif($para1 == 'delete'){
		$this->db->where('alert_type', 1);
		$this->db->where('ref_id', $para2);
		$this->db->delete('notifications');
		$this->db->where('asset_id', $para2);
		$this->db->delete('asset_transaction');
		$this->db->where('asset_id', $para2);
		$this->db->delete('installed_subitems');
		$this->db->where('asset_id', $para2);
		$this->db->delete('sub_assets');
		$this->db->where('asset_id', $para2);
		$this->db->delete('faulty_equipment_list');
		$this->db->where('asset_id', $para2);
		$this->db->delete('serial_no');
		$this->db->where('asset', $para2);
		$this->db->delete('site_related_assets');
		$this->db->where('asset_id', $para2);
		$this->db->delete('installed_inventory');
		$this->db->where('id', $para2);
		$this->db->delete('assets');
		echo json_encode(array('response' => true, 'message' => 'Deleted successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page/')); exit;
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
		$this->load->view('back/inventory/first_page', $this->page_data);
	}
}

public function selected_asset($para1 = '' , $para2 = '', $para3 =''){
	$this->page_data['page'] = 'selected_assets';
	if(!$this->session->userdata('adminid')){
	return redirect('admin/login');
	}
	if($para1 == 'list')
	{
		$this->page_data['transactions'] = $this->db->select('*')->where('asset_id', $para2)->order_by('id','desc')->limit(2)->get('asset_transaction')->result_array();
		$this->page_data['selected_asset_transaction'] = $this->db->select('*')->where('asset_id', $para2)->order_by('id','desc')->limit(1)->get('asset_transaction')->result_array();
		$this->page_data['selected_assets'] = $this->db->get_where('assets',array('id' => $para2))->result_array();		
		$this->load->view('back/inventory/display_selected_assets',$this->page_data);	
	}
}


	public function add_asset()
	{  
		if(!$this->session->userdata('adminid'))
		{
			return redirect('admin/login');
		}
		$this->page_data['sites'] = $this->Inventory_model->getsites();
		$this->page_data['suppliers'] = $this->Inventory_model->get_suppliers();
		$this->page_data['items'] = $this->Inventory_model->get_Items();
		//$this->page_data['locations'] = $this->Inventory_model->get_locations();
		$this->page_data['manufacturers'] = $this->Inventory_model->get_manufacturers();
		$this->load->view('back/inventory/add_asset', $this->page_data);
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
	//  $this->form_validation->set_rules('id_no',' Identification Number','required|trim|is_unique[assets.identification_no]',array('is_unique' => 'Given Identification Number already exists.'));
	 $this->form_validation->set_rules('asset_price',' Product Price','required|trim');	 
	 $this->form_validation->set_rules('site_id',' Site Name','required|trim');
	 $this->form_validation->set_rules('quantity',' Quantity','required|trim');
	 $this->form_validation->set_rules('purchase_date',' Purchase Date','required|trim');
	 $this->form_validation->set_rules('warranty_type',' Warranty type','required|trim');
	 $this->form_validation->set_rules('warranty_duration','Warranty Duration','trim');
	 if($this->form_validation->run() == TRUE)
	 {
		 if($this->session->userdata('adminid'))
		 {
			 if($this->input->post('quantity')>1)
			 {
				 $quantity = $this->input->post('quantity');
				 $cost = $this->input->post('asset_price');
				 $unit_cost = $cost/$quantity;
				 $description = $this->db->get_where('items',array('id'=>$this->input->post('asset_name')))->result_array();
				 
				 //$date = date("Y-m-d H:i:s");				
				 $data = array();
				 $ref_id = array();
				 for( $qty=0; $qty < $this->input->post('quantity'); $qty++)
				 {
			     $data = array(
					 'item_type' => $this->input->post('item_type'),
				     'name' => $this->input->post('asset_name'),
				     'product_model_no' => $this->input->post('product_model_no'),
					 'identification_no' => $this->Inventory_model->generate_id(),
				     'manufacturer' => $this->input->post('manufacturer_id'),
				     'cost_price' => $unit_cost,
				     'supplier' => $this->input->post('supplier_id'),
				     'site' => $this->input->post('site_id'),
					 'purchased_on' => $this->input->post('purchase_date'),
					 'warranty_type' => $this->input->post('warranty_type'),
					 'warranty_duration' => $this->input->post('warranty_duration'),
					 'user_type' => '1',
					 'checkin_by' => $this->session->userdata('adminid'),
					 'add_date' => time()
				 ); 
				 $this->db->insert('assets',$data);
				 $ref_id[] = $this->db->insert_id();			 
				 }

				 foreach($ref_id as $id)
				 {
					$supervisor = $this->db->get('tpsupervisor')->result_array();
					$counter = 0;
					foreach($supervisor as $sp_id)
					{				 
					$data11 = array(
						'user_id' => $this->session->userdata('adminid'),
						'user_type' => 3,
						'for_user_id' =>  $sp_id['id'],
						'for_user_type' => 1,
						'ref_id' 	=> $id,
						'alert_type'  => 1,
						'date' => date("Y-m-d H:i:s"),
						'is_read' => 0,
						'notification_msg' => 'A new Asset Added by Admin.'                
						 );
						 $counter++;
						$this->db->insert('notifications', $data11); 
					}
				 }
			    echo json_encode(array('response' => true, 'message' =>'Asset Stock Created Successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;
			}
			 else
			 {
			  $items = $this->db->get_where('items',array('id'=>$this->input->post('asset_name')))->result_array();
				// echo "<pre>"; print_r($items); exit;
			  // $date = date("Y-m-d H:i:s");
				
				$data = array(
				'item_type' => $this->input->post('item_type'),
			    'name' => $this->input->post('asset_name'),
			    'product_model_no' => $this->input->post('product_model_no'),
			    'have_sub_assets' => $items[0]['have_sub_items'],
			    'cost_price' => $this->input->post('asset_price'),
				'supplier' => $this->input->post('supplier_id'),
				'manufacturer' => $this->input->post('manufacturer_id'),
			    'site' => $this->input->post('site_id'),
				'purchased_on' => $this->input->post('purchase_date'),
				'warranty_type' => $this->input->post('warranty_type'),
				'warranty_duration' => $this->input->post('warranty_duration'),
				'user_type' => '1',
				'checkin_by' => $this->session->userdata('adminid'),
				'add_date' => time()
			 );
			 $this->db->insert('assets',$data);
			 $ref_id = $this->db->insert_id('assets');

			//  if($items[0]['have_sub_items']==1){				 
			// 	$subitems = $this->db->get_where('sub_items',array('item_id'=>$items[0]['id']))->result_array();
			// 	foreach($subitems as $subAsset){
			// 		$subAssetsData = array(
			// 			'item_id' => $subAsset['item_id'],
			// 			'subitem_id' => $subAsset['id'],
			// 			'asset_id' => $ref_id,
			// 			'equipment_warranty'=>1,
			// 			'product_model_no' => $this->input->post('product_model_no'),
			// 			'cost_price' => $this->input->post('asset_price'),
			// 			'supplier' => $this->input->post('supplier_id'),
			// 			'manufacturer' => $this->input->post('manufacturer_id'),
			// 			'site' => $this->input->post('site_id'),
			// 			'purchased_on' => $this->input->post('purchase_date'),
			// 			'warranty_type' => $this->input->post('warranty_type'),
			// 			'warranty_duration' => $this->input->post('warranty_duration'),
			// 			'user_type' => '1',
			// 			'user' => $this->session->userdata('adminid'),
			// 			'action_date' => time()
			// 		 );
			// 		 $this->db->insert('sub_assets',$subAssetsData);
			// 	}
			//  }


			 $supervisor = $this->db->get('tpsupervisor')->result_array();
			 $counter = 0;
			 foreach($supervisor as $sp_id)
			 {				 
			 $data11 = array(
				 'user_id' => $this->session->userdata('adminid'),
				 'user_type' => 3,
				 'for_user_id' =>  $sp_id['id'],
				 'for_user_type' => 1,
				 'ref_id' 	=> $ref_id,
				 'alert_type'  => 1,
				 'date' => date("Y-m-d H:i:s"),
				 'is_read' => 0,
				 'notification_msg' => 'A new Asset Added by Admin.'                
				  );
				  $counter++;
				 $this->db->insert('notifications', $data11); 
			 }
		   echo json_encode(array('response' => true, 'message' =>'Asset Created Successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;
		  }
		}
		
		// elseif($this->session->userdata('supervisor_id'))
		// {
		// 	if($this->input->post('quantity')>1)
		// 	{	
		// 	 $description = $this->db->get_where('items',array('description'=>$this->input->post('asset_name')))->result_array();
		// 	 $date = date("Y-m-d H:i:s");
		// 	 $data = array(
		// 		'item_type' => $this->input->post('item_type'),
		// 		 'name' => $this->input->post('asset_name'),
		// 		 'description' => $description[0]['description'],
		// 		 'product_model_no' => $this->input->post('product_model_no'),
		// 		 'identification_no' => $this->input->post('id_no'),
		// 		 'cost_price' => $this->input->post('asset_price'),
		// 		 'qty' => $this->input->post('quantity'),
		// 		 'supplier' => $this->input->post('supplier_id'),
		// 		 'site' => $this->input->post('site_id'),
		// 		 'purchased_on' => $this->input->post('purchase_date'),
		// 		 'warranty_type' => $this->input->post('warranty_type'),
		// 		 'warranty_duration' => $this->input->post('warranty_duration'),
		// 		 'user_type' => '2',
		// 		 'checkin_by' => $this->session->userdata('supervisor_id'),
		// 		 'add_date' => $date
		// 	  );
		// 	  $this->db->insert('assets',$data);
		// 	  echo json_encode(array('response' => true, 'message' =>'Asset Stock Created Successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;
		// 	 }
		// 	 else
		// 	 {
		// 	  $description = $this->db->get_where('items',array('description'=>$this->input->post('asset_name')))->result_array();
		// 		$date = date("Y-m-d H:i:s");
		// 		$data = array(
		// 		'item_type' => $this->input->post('item_type'),
		// 	  'name' => $this->input->post('asset_name'),
		// 	  'description' => $description[0]['description'],
		// 	  'product_model_no' => $this->input->post('product_model_no'),
		// 	  'identification_no' => $this->input->post('id_no'),
		// 	  'cost_price' => $this->input->post('asset_price'),
		// 	  'supplier' => $this->input->post('supplier_id'),
		// 	  'site' => $this->input->post('site_id'),
		// 		'purchased_on' => $this->input->post('purchase_date'),
		// 		'warranty_type' => $this->input->post('warranty_type'),
		// 		'warranty_duration' => $this->input->post('warranty_duration'),
		// 	  'user_type' => '2',
		// 		'checkin_by' => $this->session->userdata('supervisor_id'),
		// 		'add_date' => $date
		// 		 );
		// 		 $this->db->insert('assets',$data);
		// 		 echo json_encode(array('response' => true, 'message' =>'Asset Created Successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;
		// 	 }
		// }
		
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
		$this->load->view('back/inventory/edit_asset', $this->page_data);
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
		 if($this->session->userdata('adminid'))
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
		      echo json_encode(array('response' => true, 'message' =>'Asset Created Successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;
		}
		
		elseif($this->session->userdata('supervisor_id'))
		{
			  $description = $this->db->get_where('items',array('description'=>$this->input->post('asset_name')))->result_array();
			  $data = array(
				'item_type' => $this->input->post('item_type'),
			    'name' => $this->input->post('asset_name'),
			    'description' => $description[0]['description'],
			    'product_model_no' => $this->input->post('product_model_no'),
			    'identification_no' => $this->input->post('id_no'),
			    'cost_price' => $this->input->post('asset_price'),
			    'supplier' => $this->input->post('supplier_id'),
			    'site' => $this->input->post('site_id'),
				'purchased_on' => $this->input->post('purchase_on'),
				'warranty_type' => $this->input->post('warranty_type'),
				'warranty_duration' => $this->input->post('warranty_duration'),
			    'user_type' => '2',
			    'checkin_by' => $this->session->userdata('supervisor_id'),
				 );
				$this->db->where('id',$asset_id);
			    $this->db->update('assets',$data);
				 echo json_encode(array('response' => true, 'message' =>'Asset Created Successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;	 
		}
		
		elseif($this->session->userdata('member_id'))
		{
			  $description = $this->db->get_where('items',array('description'=>$this->input->post('asset_name')))->result_array();
			  $data = array(
				'item_type' => $this->input->post('item_type'),
			    'name' => $this->input->post('asset_name'),
			    'description' => $description[0]['description'],
			    'product_model_no' => $this->input->post('product_model_no'),
			    'identification_no' => $this->input->post('id_no'),
			    'cost_price' => $this->input->post('asset_price'),
			    'supplier' => $this->input->post('supplier_id'),
			    'site' => $this->input->post('site_id'),
				'purchased_on' => $this->input->post('purchase_on'),
				'warranty_type' => $this->input->post('warranty_type'),
				'warranty_duration' => $this->input->post('warranty_duration'),
			    'user_type' => '3',
			    'checkin_by' => $this->session->userdata('member_id'),
		  	);
				$this->db->where('id',$asset_id);
			    $this->db->update('assets',$data);
			    echo json_encode(array('response' => true, 'message' =>'Asset Updated Successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit; 
		}
		
		
	 } 
	 else
	 {
		echo json_encode(array('response' => TRUE ,'message' => validation_errors())); exit;
	 }
	}
   /** Asset Area End */

   /** action area start */

	public function action_on_asset($para1 = '' , $para2 = '', $para3 ='')
	{
		if(!$this->session->userdata('adminid'))
		{
			return redirect('admin/login');
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
			$this->load->view('back/inventory/checkin',$this->page_data);	
		}

	elseif($para1 == 'checkin_do')
	{
	  $this->load->library('form_validation');
	  $this->form_validation->set_rules('site_id','Site Name','required|trim');
	  $this->form_validation->set_rules('checkin_comments','Comment for Checkin','required|trim');
	 
	  if($this->form_validation->run() == TRUE)
	  {
		  if($this->session->userdata('adminid'))
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
					'added_by' => $this->session->userdata('adminid'),
				   );
			   //	echo "<pre>"; print_r($data); exit;
				 $assets_data = array('checkout_to'=> "",'action_status'=>'2','checkout_user_type'=>"0",'site'=>$this->input->post('site_id'));
				 $this->db->where('id',$id);
				 $this->db->update('assets',$assets_data);
				 $this->db->insert('asset_transaction',$data);
			   }
		   echo json_encode(array('response' => true, 'message' =>'Asset Checked In Successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;
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
		$this->load->view('back/inventory/checkout',$this->page_data);
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
		 if($this->session->userdata('adminid'))
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
					'added_by' => $this->session->userdata('adminid'),
					'site' => $this->input->post('checkout_site'),
					'checkout_from_site' => $this->session->userdata('adminid'),
					'action_date' => $date,
				  'action_comments' => $this->input->post('checkout_reason'),
				  );
			   	// echo "<pre>"; print_r($data); exit;
				$assets_data = array(
					            'site'=>$this->input->post('checkout_site'),
								'checkout_to'=> $this->input->post('role'),
								'checkout_user_type'=> $this->input->post('user_role'),
								'action_status'=>'1'
								);
					 
					$this->db->where('id',$id);
				  $this->db->update('assets',$assets_data);
				$this->db->insert('asset_transaction',$data);
				/** Query to insert Action Noification in Table */
				$supervisors = $this->db->get('tpsupervisor')->result_array();
				foreach($supervisors as $sp_id)
				{
				$data11 = array(
					'for_user_id' => $sp_id['id'],
					'for_user_type' => 1,
					'user_id' => $this->session->userdata('adminid'),
					'user_type' => 3,
					'ref_id' 	=> $id,
					'alert_type'  => 1,
					'date' => date("Y-m-d H:i:s"),
					'is_read' => 0,
					'notification_msg' => 'An Asset Checked Out by Admin.'                
					 );
					$this->db->insert('notifications', $data11);
				} 
				/** Query to insert Action Noification in Table */
			   }
		   echo json_encode(array('response' => true, 'message' =>'Asset Checkedout Successfully','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;
			
			}
		}
	}

	if($para1 == 'clone')
		{
			  $this->page_data['installs'] = explode(',', $_POST['asset']);;
			  $installs = $this->page_data['installs'];
			  $this->page_data['quantity'] = $para2;
			  foreach($installs as $install){
			  $data = $this->db->get_where('installed_inventory',array('id' => $install))->result_array(); 
			  }
			  foreach($data as $row)
			  {
		        	//   if($row[0]['action_status'] == "0" )
					//   {
					// 	  echo "Brand New Items selected You must Check Out them first."; exit;
					// 	}
						if($row['transaction_type'] != "3" )
					    {
						  echo "Only Installed Equipment Clone"; exit;
						}
			  } 

			  foreach($data as $row){
				if($row['have_sub_items']==1){
					$data2 = $this->db->get_where('installed_subitems',array('installed_id' => $row['id'],'item_id' => $row['name']))->result_array();
					// $this->page_data['comp_data'] = $data2;
					$this->page_data['equip_id'] = $row['name'];
				    $data4 = $this->db->get_where('items',array('id' => $row['name']))->result_array();
			 	    $this->page_data['equip_name'] = $data4[0]['name'];
					// foreach($data2 as $comp){
					// 	$this->page_data['comp_id'] = $comp['subitem_id'];
					// 	$data3 = $this->db->get_where('sub_items',array('id' => $comp['subitem_id']))->result_array();
					// 	$this->page_data['comp_name'] = $data3[0]['name'];
					// }
					$this->page_data['have_component'] = $row['have_sub_items'];
					$this->page_data['asset_id'] = $row['asset_id'];
					$this->page_data['item_type'] = $row['item_type'];
					$this->page_data['transaction_type'] = $row['transaction_type'];
					$this->page_data['site'] = $row['site'];
					$data5 = $this->db->get_where('locations',array('site' => $row['site']))->result_array();
					$this->page_data['locations'] = $data5;
					$this->page_data['company_type'] = $row['company_type'];
					$this->page_data['company_name'] = $row['company_name'];
					$this->page_data['company_address'] = $row['company_address'];
					$this->page_data['company_person_type'] = $row['company_person_type'];
					$this->page_data['person_name'] = $row['person_name'];
					$this->page_data['person_contact'] = $row['person_contact'];
					$this->page_data['cost'] = $row['cost'];
				}
				if($row['have_sub_items']==0){
				$this->page_data['have_component'] = $row['have_sub_items'];
				$this->page_data['equip_id'] = $row['name'];
				$this->page_data['asset_id'] = $row['asset_id'];
				$this->page_data['item_type'] = $row['item_type'];
				$data4 = $this->db->get_where('items',array('id' => $row['name']))->result_array();
				$this->page_data['equip_name'] = $data4[0]['name'];
				$this->page_data['transaction_type'] = $row['transaction_type'];
				$this->page_data['site'] = $row['site'];
				$data5 = $this->db->get_where('locations',array('site' => $row['site']))->result_array();
				$this->page_data['locations'] = $data5;
				$this->page_data['company_type'] = $row['company_type'];
				$this->page_data['company_name'] = $row['company_name'];
				$this->page_data['company_address'] = $row['company_address'];
				$this->page_data['company_person_type'] = $row['company_person_type'];
				$this->page_data['person_name'] = $row['person_name'];
				$this->page_data['person_contact'] = $row['person_contact'];
				$this->page_data['cost'] = $row['cost'];
				}
			  }
			  $this->load->view('back/inventory/clone',$this->page_data);	
		}

		elseif($para1=='clone_do'){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('clone_comments[]','Comments','required|trim');
		$this->form_validation->set_rules('equip_serial[]', 'Equipment Serial No', 'required|is_unique[serial_no.serial_no]');
		$this->form_validation->set_rules('cost[]','Installation Cost','required|trim');
		$this->form_validation->set_rules('locations[]','Location','required');
		if(!empty($this->input->post('subitem_id'))){
			$this->form_validation->set_rules('comp_serial[]', 'Component Serial No', 'required|is_unique[serial_no.serial_no]');
			$this->form_validation->set_rules('comp_model[]', 'Component Model No', 'required|trim');
		}

		if($this->form_validation->run() == FALSE)
		{
			if(form_error('clone_comments[]')){
				echo json_encode(array('response' => true, 'message' =>'The Comments Field Missing .')); exit;
			}
			if(form_error('cost[]')){
				echo json_encode(array('response' => true, 'message' =>'Installation Cost Required .')); exit;
			}
			if(form_error('locations[]')){
				echo json_encode(array('response' => true, 'message' =>'Locations Required .')); exit;
			}
			if(form_error('equip_serial[]')){
				echo json_encode(array('response' => true, 'message' =>'The Equipment Serial No field must contain a unique value.')); exit;
			}
			if(form_error('comp_serial[]')){
				echo json_encode(array('response' => true, 'message' =>'The Component Serial No field must contain a unique value.')); exit;
			}
			if(form_error('comp_model[]')){
				echo json_encode(array('response' => true, 'message' =>'The Component Model field found blank.')); exit;
			}	
		}
		if($this->form_validation->run() == TRUE)
		{
			// echo "<pre>"; print_r($_POST); exit;
			$compId = $this->input->post('subitem_id');
			$compSerial = $this->input->post('comp_serial');
			$compModel = $this->input->post('comp_model');
			$companyType = $this->input->post('company_type');
			$companyName = $this->input->post('company_name');
			$companyAddress = $this->input->post('company_address');
			$companyPersonType = $this->input->post('company_person_type');
			$personName = $this->input->post('person_name');
			$personContact = $this->input->post('person_contact');
			$equipId = $this->input->post('equip_id');
			$equipSerial = $this->input->post('equip_serial');
			$comment = $this->input->post('clone_comments');
			$cost = $this->input->post('cost');
			$location = $this->input->post('locations');
			$haveComp = $this->input->post('have_comp');
			$site = $this->input->post('site');
			$assetId = $this->input->post('asset_id');
			$equipType = $this->input->post('item_type');
			// echo "<pre>"; print_r($compId); exit;
			// echo "<pre>"; print_r($compSerial); exit;
			$data = $this->db->get_where('assets',array('id' => $assetId))->result_array();
			if($equipId)
			{
					$counter = 0;
					$max = sizeof($equipId);
					for($i = 0; $i< $max; $i++){
					$date = date("Y-m-d H:i:s");
					$assets_data = array(
						'checkout_to'=> "",
						'have_sub_assets'=> $haveComp,
						'action_status'=>'3',
						'checkout_user_type' =>"",
						'site'=>$site,
						'add_date'=> time(),
					);
					 $this->db->where('id',$assetId);
					 $this->db->update('assets',$assets_data);

					 $sra = array(
						'asset' => $assetId,
						'site'=>$site,                
						 );
						 $this->db->insert('site_related_assets',$sra);

					$equip_id = $equipId[$i];
					$equip_serial = $equipSerial[$i];
					$locations = $location[$i];
					$instl_cost = $cost[$i];
					$clone_comment = $comment[$i];

					 $installing_data = array(
						'asset_id' => $assetId,
						'item_type' => $equipType,
						'name' => $equip_id,
						'have_sub_items'=> $haveComp,
						'transaction_type' => "3",
						'identification_no' => $this->Inventory_model->generate_id(), 
						'serial_no'=> $equip_serial,
						'site' => $site,
						'location' => $locations,
						'company_type' => $companyType,
						'company_name' => $companyName,
						'company_address' => $companyAddress,
						'company_person_type' => $companyPersonType,
						'person_name' => $personName,
						'person_contact' => $personContact,
						'cost' => $instl_cost,
						'comments' => $clone_comment,
						'user_type' => "1",
						'user_name' => $this->session->userdata('adminid'),
						'action_date' => $date,
						);
					$this->db->insert('installed_inventory',$installing_data);
					$install_id = $this->db->insert_id('');

					 $es_no = array(
						'equipment' => 1,
						'serial_no'=>$equip_serial, 
						'asset_id'=>$assetId, 
						'installed_id'=>$install_id,                
						 );
						 $this->db->insert('serial_no',$es_no);

						 $maxIndex = count($compId);
						 $cmpIndex;
						 $compCounter;
						 $loopTerminater;

					 if($haveComp==1){						
						if(isset($compCounter))
						{
							$compCounter = $compCounter+$loopTerminater;
							$ci = $cmpIndex+1;						   
						}
						if(empty($compCounter))
						{
							$compCounter = $maxIndex/$max;
							$loopTerminater = $maxIndex/$max;
							$ci = 0; 
						}
						$installing_cost = "cost of main item".$instl_cost ;

						for($ci; $ci<$compCounter ; $cmpIndex=$ci++ ){
								$comp_serial = $compSerial[$ci];
								$comp_id = $compId[$ci];
								$comp_model = $compModel[$ci];
								
							$cs_no = array(
								'component' => 1,
								'serial_no'=>$comp_serial, 
								'asset_id'=>$assetId, 
								'installed_id'=>$install_id,                   
								 );
								 $this->db->insert('serial_no',$cs_no);

							$installing_subitem_data = array(
								'asset_id' => $assetId,
								'installed_id'=> $install_id,
								'item_id' => $equip_id,
								'serial_no'=> $comp_serial,
								'model_no'=> $comp_model,
								'subitem_id' => $comp_id,
								'transaction_type' => "3", 
								'site' => $site,
								'location' => $locations,
								'company_type' => $companyType,
								'company_name' => $companyName,
								'company_address' => $companyAddress,
								'company_person_type' => $companyPersonType,
								'person_name' => $personName,
								'person_contact' => $personContact,
								'cost' => $installing_cost,
								'comments' => $clone_comment,
								'action_by_user_type' => "1",
								'action_by_user' => $this->session->userdata('adminid'),
								'action_date' => $date,
								);
								$this->db->insert('installed_subitems',$installing_subitem_data);
								$sub_install_id = $this->db->insert_id('');
                               $equipPurchaseCost = "Equipment Purchase Cose".$data[0]['cost_price'];
								$subAssetsData = array(
									'asset_id' => $assetId,
									'installed_id'=> $install_id,
									'item_id' => $equip_id,
									'subitem_id' => $comp_id,
									'equipment_warranty'=>1,
									'product_model_no' => $comp_model,
									'cost_price' => $equipPurchaseCost,
									'supplier' => $data[0]['supplier'],
									'manufacturer' => $data[0]['manufacturer'],
									'site' => $site,
									'purchased_on' => $data[0]['purchased_on'],
									'warranty_type' => $data[0]['warranty_type'],
									'warranty_duration' => $data[0]['warranty_duration'],
									'user_type' => '1',
									'user' => $this->session->userdata('adminid'),
									'action_date' => date("Y-m-d H:i:s")
									);
								$this->db->insert('sub_assets',$subAssetsData);
								
								$asset_transaction_data = array(
									'asset_id' => $assetId,
									'installed_id' => $install_id,
									'item_id' => $equip_id,
									'subitem_id'=> $comp_id,
									'is_sub_item' => 1,
									'installed_subitem_id' => $sub_install_id,
									'serial_no'=> $comp_serial,
									'transaction_type' => "3",
									'site' => $site,
									'location' => $locations,
									'user_type' => "1",
									'added_by' => $this->session->userdata('adminid'),
									'action_date' => $date,
									'organisation_type' => $companyType,
									'organisation' => $companyName,
									'organisation_address' => $companyAddress,
									'repairing_person_type' => $companyPersonType,
									'person' => $personName,
									'person_contact' => $personContact,
									'cost' => $installing_cost,
									'action_comments' => $clone_comment,
									);
	
								 $this->db->insert('asset_transaction',$asset_transaction_data);		
						}
					 }

					 if($haveComp==0){
					 $data = array(
						'asset_id' => $assetId,
						'installed_id' => $install_id,
						'item_id' => $equip_id,
						'have_sub_items' => $haveComp,
						'serial_no'=> $equip_serial,
						'transaction_type' => "3",
						'site' => $site,
						'location' => $locations,
						'user_type' => "1",
						'added_by' => $this->session->userdata('adminid'),
						'action_date' => $date,
						'organisation_type' => $companyType,
						'organisation' => $companyName,
						'organisation_address' => $companyAddress,
						'repairing_person_type' => $companyPersonType,
						'person' => $personName,
						'person_contact' => $personContact,
						'cost' => $instl_cost,
						'action_comments' => $clone_comment,
						);
					 $this->db->insert('asset_transaction',$data);	
					}		 
			   }
		   echo json_encode(array('response' => true, 'message' =>'Clone Installation Successfull.','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;
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
				  $data = $this->db->get_where('assets',array('id' => $install))->result_array();
			  }
				 // echo "<pre>"; print_r($data); exit;
				 $components = array() ;
	
			  $data2 = array();
			  foreach($data as $row)
			  {
				  if($row['have_sub_assets']==1){
					  $data2 = $this->db->get_where('sub_items',array('item_id' => $row['name']))->result_array();
				  }
					//   if($row[0]['action_status'] == "0" )
					//   {
					// 	  echo "Brand New Items selected You must Check Out them first."; exit;
					// 	}
						if($row['action_status'] == "2" )
					  {
						  echo "Checked In Items selected You must Check Out them first."; exit;
						}
						if($row['action_status'] == "4" )
					  {
						  echo "Repairing Mode Items selected You cannot install them."; exit;
						}
						if($row['action_status'] == "6" )
					  {
						  echo "Retired Items Selected. You cannot Install them."; exit;
					  }
			  }
			  $this->page_data['data2'] = $data2;
			//   echo "<pre>"; print_r($data2); exit;
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
				// $this->page_data['locations'] = $this->Inventory_model->get_locations();
				$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
			  $this->load->view('back/inventory/install',$this->page_data);	
	 }


	 elseif ($para1 == 'install_do')
	 {
		//  echo "<pre>"; print_r($_POST); exit;
		$locations = $this->input->post('location');
		// echo "<pre>"; print_r($locations); exit;
		if(empty($locations)){
			echo json_encode(array('respose' => FALSE , 'message' => 'Please choose location'));exit;	
		}
		$loc_Counter = 0;
		foreach($locations as $location)
		{
			$loc_Counter++;
		}
	 $this->load->library('form_validation');
	 $this->form_validation->set_rules('site_id','Site Name','required|trim');
	 $this->form_validation->set_rules('repairing_company','Repairing Company','required|trim');
	 $this->form_validation->set_rules('install_comments','Installing Comments','required|trim');	
	 if($this->form_validation->run() == TRUE)
	 {
		if($this->session->userdata('adminid'))
		{
			if($loc_Counter>1){
	// 		if($this->input->post('repairing_company')=="1")
	// 		{
	// 				$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
	// 				$asset_ids = $this->page_data['assets_ids'];
					
	// 		        $install_id = array();
	// 			    foreach ($locations as $location){
	// 				$date = date("Y-m-d H:i:s");
	// 				$asset = $this->db->get_where('assets',array('id' => $asset_ids[0]))->result_array();
	// 			    // echo "<pre>"; print_r($asset); exit;
	// 			  $assets_data = array(
	// 				'checkout_to'=> "",
	// 				'have_sub_assets'=> $asset[0]['have_sub_assets'],
	// 				'action_status'=>'3',
	// 				'checkout_user_type' =>"",
	// 				'site'=>$this->input->post('site_id'),
	// 				'add_date'=> time(),
	// 			);
	// 			 $this->db->where('id',$asset_ids[0]);
	// 			 $this->db->update('assets',$assets_data);

	// 			 $sra = array(
	// 				'asset' => $asset_ids[0],
	// 				'site'=>$this->input->post('site_id'),                
	// 				 );
	// 				 $this->db->insert('site_related_assets',$sra);

	// 			 $installing_data = array(
	// 				'asset_id' => $asset_ids[0],
	// 				'item_type' => $asset[0]['item_type'],
	// 				'name' => $asset[0]['name'],
	// 				'have_sub_items'=> $asset[0]['have_sub_assets'],
	// 				'transaction_type' => "3",
	// 				'identification_no' => $this->Inventory_model->generate_id(), 
	// 				'site' => $this->input->post('site_id'),
	// 				'location' => $location,
	// 				'company_type' => 1,
	// 				'company_name' => $this->input->post('repairing_tsp'),
	// 				'company_address' => $this->input->post('tsp_address'),
	// 				'company_person_type' => $this->input->post('tsp_person_type'),
	// 				'person_name' => $this->input->post('tsp_person'),
	// 				'person_contact' => $this->input->post('tsp_person_contact'),
	// 				'cost' => $this->input->post('cost'),
	// 				'comments' => $this->input->post('install_comments'),
	// 				'user_type' => "1",
	// 				'user_name' => $this->session->userdata('adminid'),
	// 				'action_date' => $date,
	// 				);
	// 			 $this->db->insert('installed_inventory',$installing_data);
	// 			 $install_id = $this->db->insert_id('');

	// 			 if($asset[0]['have_sub_assets']==1){
	// 				$subitems = $this->db->get_where('sub_items',array('item_id' => $asset[0]['name']))->result_array();
    //                  $installing_cost = "cost of main item".$this->input->post('cost') ;
	// 				foreach($subitems as $subasset)
	// 				{
	// 					$installing_subitem_data = array(
	// 						'asset_id' => $asset_ids[0],
	// 						'installed_id'=> $install_id,
	// 						'item_id' => $asset[0]['name'],
	// 						'subitem_id' => $subasset['id'],
	// 						'transaction_type' => "3", 
	// 						'site' => $this->input->post('site_id'),
	// 						'location' => $location,
	// 						'company_type' => 1,
	// 				        'company_name' => $this->input->post('repairing_tsp'),
	// 				        'company_address' => $this->input->post('tsp_address'),
	// 				        'company_person_type' => $this->input->post('tsp_person_type'),
	// 				        'person_name' => $this->input->post('tsp_person'),
	// 						'person_contact' => $this->input->post('tsp_person_contact'),
	// 						'cost' => $installing_cost,
	// 						'comments' => $this->input->post('install_comments'),
	// 						'action_by_user_type' => "1",
	// 						'action_by_user' => $this->session->userdata('adminid'),
	// 						'action_date' => $date,
	// 						);
	// 						$this->db->insert('installed_subitems',$installing_subitem_data);
	// 						$sub_install_id = $this->db->insert_id('');
                            
	// 						$asset_transaction_data = array(
	// 							'asset_id' => $asset_ids[0],
	// 							'installed_id' => $install_id,
	// 							'item_id'=> $asset[0]['name'],
	// 							'subitem_id'=> $subasset['id'],
	// 							'is_sub_item' => 1,
	// 							'installed_subitem_id' => $sub_install_id,
	// 							'transaction_type' => "3",
	// 							'site' => $this->input->post('site_id'),
	// 							'location' => $location,
	// 							'user_type' => "1",
	// 							'added_by' => $this->session->userdata('adminid'),
	// 							'action_date' => $date,
	// 							'organisation_type' => 1,
	// 							'organisation' => $this->input->post('repairing_tsp'),
	// 							'organisation_address' => $this->input->post('tsp_address'),
	// 							'repairing_person_type' => $this->input->post('tsp_person_type'),
	// 							'person' => $this->input->post('tsp_person'),
	// 							'person_contact' => $this->input->post('tsp_person_contact'),
	// 							'cost' => $installing_cost,
	// 							'action_comments' => $this->input->post('install_comments'),
	// 							);
	// 						 $this->db->insert('asset_transaction',$asset_transaction_data);
	// 				}	
	// 			 }
	// 			 if($asset[0]['have_sub_assets']==0){

	// 			 $data = array(
	// 				'asset_id' => $asset_ids[0],
	// 				'installed_id' => $install_id,
	// 				'item_id'=> $asset[0]['name'],
	// 				'have_sub_items' => 0,
	// 				'transaction_type' => "3",
	// 		        'site' => $this->input->post('site_id'),
	// 				'location' => $location,
	// 				'user_type' => "1",
	// 				'added_by' => $this->session->userdata('adminid'),
	// 				'action_date' => $date,
	// 				'organisation_type' => 1,
	// 				'organisation' => $this->input->post('repairing_tsp'),
	// 				'organisation_address' => $this->input->post('tsp_address'),
	// 				'repairing_person_type' => $this->input->post('tsp_person_type'),
	// 				'person' => $this->input->post('tsp_person'),
	// 				'person_contact' => $this->input->post('tsp_person_contact'),
	// 				'cost' => $this->input->post('cost'),
	// 			    'action_comments' => $this->input->post('install_comments'),
	// 			    );
	// 			 $this->db->insert('asset_transaction',$data);	
	// 			}			 
	// 		   } 
	// 	   echo json_encode(array('response' => true, 'message' =>'Installation Successfull.','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;
	// 		}
	// 		if($this->input->post('repairing_company')=="2")
	// 		{
	// 			$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
	// 			$asset_ids = $this->page_data['assets_ids'];
				
	// 		    foreach ($locations as $location){
	// 			$date = date("Y-m-d H:i:s");
	// 			$asset = $this->db->get_where('assets',array('id' => $asset_ids[0]))->result_array();
 
	// 			$assets_data = array(
	// 				'checkout_to'=> "",
	// 				'have_sub_assets'=> $asset[0]['have_sub_assets'],
	// 				'action_status'=>'3',
	// 				'checkout_user_type' =>"",
	// 				'site'=>$this->input->post('site_id'),
	// 				'add_date'=> time(),
	// 			);
	// 			 $this->db->where('id',$asset_ids[0]);
	// 			 $this->db->update('assets',$assets_data);

	// 			 $sra = array(
	// 				'asset' => $asset_ids[0],
	// 				'site'=>$this->input->post('site_id'),                
	// 				 );
	// 				 $this->db->insert('site_related_assets',$sra);

	// 			 $installing_data = array(
	// 				'asset_id' => $asset_ids[0],
	// 				'item_type' => $asset[0]['item_type'],
	// 				'name' => $asset[0]['name'],
	// 				'have_sub_items'=> $asset[0]['have_sub_assets'],
	// 				'transaction_type' => "3",
	// 				'identification_no' => $this->Inventory_model->generate_id(), 
	// 				'site' => $this->input->post('site_id'),
	// 				'location' => $location,
	// 				'company_type' => 2,
	// 				'company_name' => $this->input->post('outer_company_name'),
	// 				'company_address' => $this->input->post('outer_company_address'),
	// 				'person_name' => $this->input->post('outsider_name'),
	// 				'person_contact' => $this->input->post('outsider_contact'),
	// 				'comments' => $this->input->post('install_comments'),
	// 				'cost' => $this->input->post('cost'),
	// 				'user_type' => "1",
	// 				'user_name' => $this->session->userdata('adminid'),
	// 				'action_date' => $date,
	// 				);
	// 			 $this->db->insert('installed_inventory',$installing_data);
	// 			 $install_id = $this->db->insert_id('');

	// 			 if($asset[0]['have_sub_assets']==1){
					
	// 				$subitems = $this->db->get_where('sub_items',array('item_id' => $asset[0]['name']))->result_array();
	// 				$installing_cost = "cost of main item".$this->input->post('cost') ;
	// 				foreach($subitems as $subasset){
	
	// 					$installing_subitem_data = array(
	// 						'asset_id' => $asset_ids[0],
	// 						'installed_id'=> $install_id,
	// 						'item_id' => $asset[0]['name'],
	// 						'subitem_id' => $subasset['id'],
	// 						'transaction_type' => "3", 
	// 						'site' => $this->input->post('site_id'),
	// 						'location' => $location,
	// 						'company_type' => 2,
	// 						'company_name' => $this->input->post('outer_company_name'),
	// 						'company_address' => $this->input->post('outer_company_address'),
	// 						'person_name' => $this->input->post('outsider_name'),
	// 						'person_contact' => $this->input->post('outsider_contact'),
	// 						'comments' => $this->input->post('install_comments'),
	// 						'cost' => $installing_cost,
	// 						'comments' => $this->input->post('install_comments'),
	// 						'action_by_user_type' => "1",
	// 						'action_by_user' => $this->session->userdata('adminid'),
	// 						'action_date' => $date,
	// 						);
	// 						$this->db->insert('installed_subitems',$installing_subitem_data);
	// 						$sub_install_id = $this->db->insert_id('');
                            
	// 						$asset_transaction_data = array(
	// 							'asset_id' => $asset_ids[0],
	// 							'installed_id' => $install_id,
	// 							'item_id'=> $asset[0]['name'],
	// 							'subitem_id'=> $subasset['id'],
	// 							'is_sub_item' => 1,
	// 							'installed_subitem_id' => $sub_install_id,
	// 							'transaction_type' => "3",
	// 							'site' => $this->input->post('site_id'),
	// 							'location' => $location,
	// 							'user_type' => "1",
	// 							'added_by' => $this->session->userdata('adminid'),
	// 							'action_date' => $date,
	// 							'organisation_type' => 2,
	// 							'organisation' => $this->input->post('outer_company_name'),
	// 							'organisation_address' => $this->input->post('outer_company_address'),
	// 							'person' => $this->input->post('outsider_name'),
	// 							'person_contact' => $this->input->post('outsider_contact'),
	// 							'cost' => $installing_cost,
	// 							'action_comments' => $this->input->post('install_comments'),
	// 							);

	// 						 $this->db->insert('asset_transaction',$asset_transaction_data);
	// 				}	
	// 			 }

    //               if($asset[0]['have_sub_assets']==0){
	// 			 $data = array(
	// 				'asset_id' => $asset_ids[0],
	// 				'installed_id' => $install_id,
	// 				'item_id'=> $asset[0]['name'],
	// 				'have_sub_items' => $asset[0]['have_sub_assets'],
	// 				'transaction_type' => "3",
	// 		        'site' => $this->input->post('site_id'),
	// 				'location' => $location,
	// 				'user_type' => "1",
	// 				'added_by' => $this->session->userdata('adminid'),
	// 				'action_date' => $date,
	// 				'organisation_type' => 2,
	// 				'organisation' => $this->input->post('outer_company_name'),
	// 				'organisation_address' => $this->input->post('outer_company_address'),
	// 				'person' => $this->input->post('outsider_name'),
	// 				'person_contact' => $this->input->post('outsider_contact'),
	// 				'cost' => $this->input->post('cost'),
	// 			    'action_comments' => $this->input->post('install_comments'),
	// 			    );
	// 			 $this->db->insert('asset_transaction',$data);
	// 			}
	// 	   }
	//    echo json_encode(array('response' => true, 'message' =>'Installation Successfull.','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;
	// 		}
		}//end of locations greater than 1
		if($loc_Counter=1)
		{
			// echo "yasir"; exit;
			$comp_serial = $this->input->post('comp_serial');
			$comp_model = $this->input->post('comp_model');

			if($this->input->post('repairing_company')=="1")
			{
					$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
					$asset_ids = $this->page_data['assets_ids'];
					// echo "<pre>"; print_r($asset_ids); exit;
					
				  foreach ($asset_ids as $id){
					$asset = $this->db->get_where('assets',array('id' => $id))->result_array();
					$date = date("Y-m-d H:i:s");

					$assets_data = array(
						'checkout_to'=> "",
						'have_sub_assets'=> $asset[0]['have_sub_assets'],
						'action_status'=>'3',
						'checkout_user_type' =>"",
						'site'=>$this->input->post('site_id'),
						'add_date'=> time(),
					);
					 $this->db->where('id',$id);
					 $this->db->update('assets',$assets_data);

					 $sra = array(
						'asset' => $id,
						'site'=>$this->input->post('site_id'),                
						 );
						 $this->db->insert('site_related_assets',$sra);

					 $installing_data = array(
						'asset_id' => $id,
						'item_type' => $asset[0]['item_type'],
						'name' => $asset[0]['name'],
						'have_sub_items'=> $asset[0]['have_sub_assets'],
						'transaction_type' => "3",
						'identification_no' => $this->Inventory_model->generate_id(), 
						'serial_no'=> $this->input->post('equip_serial'),
						'site' => $this->input->post('site_id'),
						'location' => $locations[0],
						'company_type' => 1,
						'company_name' => $this->input->post('repairing_tsp'),
						'company_address' => $this->input->post('tsp_address'),
						'company_person_type' => $this->input->post('tsp_person_type'),
						'person_name' => $this->input->post('tsp_person'),
						'person_contact' => $this->input->post('tsp_person_contact'),
						'cost' => $this->input->post('cost'),
						'comments' => $this->input->post('install_comments'),
						'user_type' => "1",
						'user_name' => $this->session->userdata('adminid'),
						'action_date' => $date,
						);
					 $this->db->insert('installed_inventory',$installing_data);
					 $install_id = $this->db->insert_id('');

					 $es_no = array(
						'equipment' => 1,
						'serial_no'=>$this->input->post('equip_serial'), 
						'asset_id'=>$id, 
						'installed_id'=>$install_id,                
						 );
						 $this->db->insert('serial_no',$es_no);

					 if($asset[0]['have_sub_assets']==1){
					
						$subitems = $this->db->get_where('sub_items',array('item_id' => $asset[0]['name']))->result_array();
						$installing_cost = "Equipment Installing Cost".$this->input->post('cost') ;
						$counter=0;
						foreach($subitems as $subasset){

							$cs_no = array(
								'component' => 1,
								'serial_no'=>$comp_serial[$counter], 
								'asset_id'=>$id, 
								'installed_id'=>$install_id,                   
								 );
								 $this->db->insert('serial_no',$cs_no);

							$installing_subitem_data = array(
								'asset_id' => $asset_ids[0],
								'installed_id'=> $install_id,
								'item_id' => $asset[0]['name'],
								'subitem_id' => $subasset['id'],
								'serial_no'=> $comp_serial[$counter],
								'model_no'=>$comp_model[$counter],
								'transaction_type' => "3", 
								'site' => $this->input->post('site_id'),
								'location' => $locations[0],
								'company_type' => 1,
								'company_name' => $this->input->post('repairing_tsp'),
								'company_address' => $this->input->post('tsp_address'),
								'company_person_type' => $this->input->post('tsp_person_type'),
								'person_name' => $this->input->post('tsp_person'),
								'person_contact' => $this->input->post('tsp_person_contact'),
								'cost' => $installing_cost,
								'comments' => $this->input->post('install_comments'),
								'action_by_user_type' => "1",
								'action_by_user' => $this->session->userdata('adminid'),
								'action_date' => $date,
								);
								$this->db->insert('installed_subitems',$installing_subitem_data);
								$sub_install_id = $this->db->insert_id('');

								$equipPurchaseCost = "Equipment Purchase CosT".$asset[0]['cost_price'];
								$subAssetsData = array(
									'asset_id' => $id,
									'installed_id'=> $install_id,
									'item_id' => $asset[0]['name'],
									'subitem_id' => $subasset['id'],
									'equipment_warranty'=>1,
									'product_model_no' => $comp_model[$counter],
									'cost_price' => $equipPurchaseCost,
									'supplier' => $asset[0]['supplier'],
									'manufacturer' => $asset[0]['manufacturer'],
									'site' => $this->input->post('site_id'),
									'purchased_on' => $asset[0]['purchased_on'],
									'warranty_type' => $asset[0]['warranty_type'],
									'warranty_duration' => $asset[0]['warranty_duration'],
									'user_type' => '1',
									'user' => $this->session->userdata('adminid'),
									'action_date' => date("Y-m-d H:i:s")
									);
								$this->db->insert('sub_assets',$subAssetsData);
								
								$asset_transaction_data = array(
									'asset_id' => $asset_ids[0],
									'installed_id' => $install_id,
									'item_id'=> $asset[0]['name'],
									'subitem_id'=> $subasset['id'],
									'is_sub_item' => 1,
									'installed_subitem_id' => $sub_install_id,
									'serial_no'=> $comp_serial[$counter],
									'transaction_type' => "3",
									'site' => $this->input->post('site_id'),
									'location' => $locations[0],
									'user_type' => "1",
									'added_by' => $this->session->userdata('adminid'),
									'action_date' => $date,
									'organisation_type' => 1,
									'organisation' => $this->input->post('repairing_tsp'),
									'organisation_address' => $this->input->post('tsp_address'),
									'repairing_person_type' => $this->input->post('tsp_person_type'),
									'person' => $this->input->post('tsp_person'),
									'person_contact' => $this->input->post('tsp_person_contact'),
									'cost' => $installing_cost,
									'action_comments' => $this->input->post('install_comments'),
									);
	
								 $this->db->insert('asset_transaction',$asset_transaction_data);
								 $counter++;
						}	
					 }

					 if($asset[0]['have_sub_assets']==0){
					 $data = array(
						'asset_id' => $asset_ids[0],
						'installed_id' => $install_id,
						'item_id'=> $asset[0]['name'],
						'have_sub_items' => $asset[0]['have_sub_assets'],
						'serial_no'=> $this->input->post('equip_serial'),
						'transaction_type' => "3",
						'site' => $this->input->post('site_id'),
						'location' => $locations[0],
						'user_type' => "1",
						'added_by' => $this->session->userdata('adminid'),
						'action_date' => $date,
						'organisation_type' => 1,
						'organisation' => $this->input->post('repairing_tsp'),
						'organisation_address' => $this->input->post('tsp_address'),
						'repairing_person_type' => $this->input->post('tsp_person_type'),
						'person' => $this->input->post('tsp_person'),
						'person_contact' => $this->input->post('tsp_person_contact'),
						'cost' => $this->input->post('cost'),
						'action_comments' => $this->input->post('install_comments'),
						);
					 $this->db->insert('asset_transaction',$data);	
					}			 
			   }
		   echo json_encode(array('response' => true, 'message' =>'Installation Successfull.','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;
			}
			if($this->input->post('repairing_company')=="2")
			{
				$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
				$asset_ids = $this->page_data['assets_ids'];
				// echo "<pre>"; print_r($asset_ids); exit;
			  foreach ($asset_ids as $id){
				$asset = $this->db->get_where('assets',array('id' => $id))->result_array();
				$date = date("Y-m-d H:i:s");

				$assets_data = array(
					'checkout_to'=> "",
					'have_sub_assets'=> $asset[0]['have_sub_assets'],
					'action_status'=>'3',
					'checkout_user_type' =>"",
					'site'=>$this->input->post('site_id'),
					'add_date'=> time(),
				);
				 $this->db->where('id',$id);
				 $this->db->update('assets',$assets_data);

				 $sra = array(
					'asset' => $id,
					'site'=>$this->input->post('site_id'),                
					 );
					 $this->db->insert('site_related_assets',$sra);


				 $installing_data = array(
					'asset_id' => $id,
					'item_type' => $asset[0]['item_type'],
					'name' => $asset[0]['name'],
					'have_sub_items'=> $asset[0]['have_sub_assets'],
					'transaction_type' => "3",
					'identification_no' => $this->Inventory_model->generate_id(),
					'serial_no'=> $this->input->post('equip_serial'), 
					'site' => $this->input->post('site_id'),
					'location' => $locations[0],
					'company_type' => 2,
					'company_name' => $this->input->post('outer_company_name'),
					'company_address' => $this->input->post('outer_company_address'),
					'person_name' => $this->input->post('outsider_name'),
					'person_contact' => $this->input->post('outsider_contact'),
					'cost' => $this->input->post('cost'),
					'comments' => $this->input->post('install_comments'),
					'user_type' => "1",
					'user_name' => $this->session->userdata('adminid'),
					'action_date' => $date,
					);
				 $this->db->insert('installed_inventory',$installing_data);
				 $install_id = $this->db->insert_id('');

				 $es_no = array(
					'equipment' => 1,
					'serial_no'=>$this->input->post('equip_serial'), 
					'asset_id'=>$id, 
					'installed_id'=>$install_id,                   
					);
				 $this->db->insert('serial_no',$es_no);


				 if($asset[0]['have_sub_assets']==1){
					
					$subitems = $this->db->get_where('sub_items',array('item_id' => $asset[0]['name']))->result_array();
					$installing_cost = "Equipment Installing Cost".$this->input->post('cost') ; 
					foreach($subitems as $subasset){

						$cs_no = array(
							'component' => 1,
							'serial_no'=>$comp_serial[$counter],
							'asset_id'=>$id, 
							'installed_id'=>$install_id,                    
							 );
							 $this->db->insert('serial_no',$cs_no);
	
						$installing_subitem_data = array(
							'asset_id' => $asset_ids[0],
							'installed_id'=> $install_id,
							'item_id' => $asset[0]['name'],
							'subitem_id' => $subasset['id'],
							'serial_no'=> $comp_serial[$counter],
							'model_no'=>$comp_model[$counter],
							'transaction_type' => "3", 
							'site' => $this->input->post('site_id'),
							'location' => $locations[0],
							'company_type' => 2,
							'company_name' => $this->input->post('outer_company_name'),
							'company_address' => $this->input->post('outer_company_address'),
							'person_name' => $this->input->post('outsider_name'),
							'person_contact' => $this->input->post('outsider_contact'),
							'cost' => $installing_cost,
							'comments' => $this->input->post('install_comments'),
							'action_by_user_type' => "1",
							'action_by_user' => $this->session->userdata('adminid'),
							'action_date' => $date,
							);
							$this->db->insert('installed_subitems',$installing_subitem_data);
							$sub_install_id = $this->db->insert_id('');

							$equipPurchaseCost = "Equipment Purchase Cost".$asset[0]['cost_price'];
							$subAssetsData = array(
								'asset_id' => $id,
								'installed_id'=> $install_id,
								'item_id' => $asset[0]['name'],
								'subitem_id' => $subasset['id'],
								'equipment_warranty'=>1,
								'product_model_no' => $comp_model[$counter],
								'cost_price' => $equipPurchaseCost,
								'supplier' => $asset[0]['supplier'],
								'manufacturer' => $asset[0]['manufacturer'],
								'site' => $this->input->post('site_id'),
								'purchased_on' => $asset[0]['purchased_on'],
								'warranty_type' => $asset[0]['warranty_type'],
								'warranty_duration' => $asset[0]['warranty_duration'],
								'user_type' => '1',
								'user' => $this->session->userdata('adminid'),
								'action_date' => date("Y-m-d H:i:s")
								);
							$this->db->insert('sub_assets',$subAssetsData);


							
							$asset_transaction_data = array(
								'asset_id' => $asset_ids[0],
								'installed_id' => $install_id,
								'item_id'=> $asset[0]['name'],
								'subitem_id'=> $subasset['id'],
								'is_sub_item' => 1,
								'installed_subitem_id' => $sub_install_id,
								'serial_no'=> $comp_serial[$counter],
								'transaction_type' => "3",
								'site' => $this->input->post('site_id'),
								'location' => $locations[0],
								'user_type' => "1",
								'added_by' => $this->session->userdata('adminid'),
								'action_date' => $date,
								'organisation_type' => 2,
								'organisation' => $this->input->post('outer_company_name'),
								'organisation_address' => $this->input->post('outer_company_address'),
								'person' => $this->input->post('outsider_name'),
								'person_contact' => $this->input->post('outsider_contact'),
								'cost' => $installing_cost,
								'action_comments' => $this->input->post('install_comments'),
								);

							 $this->db->insert('asset_transaction',$asset_transaction_data);
					}	
				 }
			     if($asset[0]['have_sub_assets']==0){
				 $data = array(
				'asset_id' => $id,
				'installed_id' => $install_id,
				'item_id'=> $asset[0]['name'],
			    'have_sub_items' => $asset[0]['have_sub_assets'],
				'transaction_type' => "3",
				'site' => $this->input->post('site_id'),
				'serial_no'=> $this->input->post('equip_serial'),
				'location' => $locations[0],
				'user_type' => "1",
				'added_by' => $this->session->userdata('adminid'),
				'action_date' => $date,
				'organisation_type' => 2,
				'organisation' => $this->input->post('outer_company_name'),
				'organisation_address' => $this->input->post('outer_company_address'),
				'person' => $this->input->post('outsider_name'),
				'person_contact' => $this->input->post('outsider_contact'),
				'cost' => $this->input->post('cost'),
			  'action_comments' => $this->input->post('install_comments'),
			  );
			  $this->db->insert('asset_transaction',$data);
			 }
		   }
	   echo json_encode(array('response' => true, 'message' =>'Installation Successfull.','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;
			}
		}
			
			}
		}
	}

	elseif ($para1 == 'faulty')
	{
			$this->page_data['repairs'] = explode(',', $_POST['asset']);
			$repairs = $this->page_data['repairs'];
			$data = array();
			foreach($repairs as $repair)
			{
				$data[] = $this->db->get_where('installed_inventory',array('id' => $repair))->result_array();
			}
		 	// echo "<pre>"; print_r($data); exit;
			$data2 = array();
			foreach($data as $row)
			{
					if($row[0]['transaction_type'] == "10")
					{
						echo "Selected item already faulty."; exit;
					}
					if($row[0]['transaction_type'] == "4")
					{
						echo "Selected item already in repairing mode."; exit;
					}
					if($row[0]['transaction_type'] == "5")
					{
						echo "Selected item's repairing recently completed."; exit;
					}
					if($row[0]['transaction_type'] == "6")
					{
						echo "Retire item cannot be repair."; exit;
					}
			}
			$data3 = array();
		 foreach($repairs as $repair)
		 {
			 $installing_names = $this->db->get_where('installed_inventory',array('id' => $repair))->result_array();
			 $this->db->select('installed_inventory.name AS temp_id,items.*');
			 $this->db->from('installed_inventory');
			 $this->db->join('items','installed_inventory.name = items.id');
			 $this->db->where('installed_inventory.id',$repair);
			 $query=$this->db->get();
			 $data3[]= $query->result_array();
			 $this->page_data['data'] = $data3; 		
		 }
		 
		 foreach($repairs as $repair)
		 {
			 $installed_location = $this->db->get_where('installed_inventory',array('id' => $repair,'transaction_type'=> 3))->result_array();
			 $locationNames = $this->db->get_where('locations',array('id' => $installed_location[0]['location']))->result_array();
			 $siteNames = $this->db->get_where('sites',array('id' => $locationNames[0]['site']))->result_array();			 
			 $this->page_data['sites'] = $siteNames;
			 $this->page_data['locations'] = $locationNames;
			 		
		 }
			$this->page_data['data1'] = $data;
			$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
			$this->load->view('back/inventory/faulty',$this->page_data);	
 }

 elseif ($para1 == 'faulty_do')
 { 
 $this->load->library('form_validation');
 $this->form_validation->set_rules('omc_name','OMC Name','required|trim');
 $this->form_validation->set_rules('faulty_date','Faulty Date ','required|trim');
 	
 if($this->form_validation->run() == TRUE)
 {
	 if($this->session->userdata('adminid'))
	 {
			$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
			$install_ids = $this->page_data['assets_ids'];
				
			$counter = 0;
			foreach ($install_ids as $id)
			{
				$repairing_start = $this->db->get_where('installed_inventory',array('id' => $id))->result_array();				
				//  echo "<pre>"; print_r($repairing_start); exit;
				$date = date("Y-m-d H:i:s");

				$asset_data = array
				(
				'action_status' => "10",
				'user_type' => "1",
				'checkin_by' => $this->session->userdata('adminid'),
				'add_date' => time() ,
				);
				$this->db->where('id',$repairing_start[0]['asset_id']);
				$this->db->update('assets',$asset_data);
				
			if($repairing_start[0]['have_sub_items']==1){	
				$subitems = $this->db->get_where('installed_subitems',array('installed_id' => $repairing_start[0]['id']))->result_array();
				$overAllEstCost = "Overall Estimate Cost of Equipment,".$this->input->post('estimated_cost');
				foreach($subitems as $subasset){

					$installing_data = array(
						'transaction_type' => "10",
						'subitem_id'=> $subasset['subitem_id'],
						'company_type'=>'',
						'company_name'=>'',
						'company_address'=>'',
						'company_person_type'=>'',
						'person_name'=>'',
						'person_contact'=>'',
						'faulty_time_omc' => $this->input->post('omc_name'),
						'faulty_date' => $this->input->post('faulty_date'),
						'est_cost' => $this->input->post('estimated_cost'),
						'user_type' => "1",
						'user_name' => $this->session->userdata('adminid'),
						'action_date' => $date,
						);
						$this->db->where('id',$id);
					$this->db->update('installed_inventory',$installing_data);

					$subAsset_data = array
					(
					'action_status' => "10",
					'user_type' => "1",
					'user' => $this->session->userdata('adminid'),
					'action_date' => $date ,
					);
					$this->db->where('id',$repairing_start[0]['asset_id']);
					$this->db->update('sub_assets',$subAsset_data);

					$installing_subitem_data = array(
						'transaction_type' => 10,
						'company_type'=>'',
						'company_name'=>'',
						'company_address'=>'',
						'company_person_type'=>'',
						'person_name'=>'',
						'person_contact'=>'',
						'faulty_time_omc' => $this->input->post('omc_name'),
						'faulty_date' => $this->input->post('faulty_date'),
						'est_cost' => $overAllEstCost,
						'comments' => $this->input->post('faulty_reason'),
						'action_by_user_type' => "1",
						'action_by_user' => $this->session->userdata('adminid'),
						'action_date' => $date,
						);
						$this->db->where('id',$subasset['id']);
						$this->db->update('installed_subitems',$installing_subitem_data);

						$faulty_data = array(
							'asset_id'=> $subasset['asset_id'],
							'installed_id' => $id,
							'subitem_id' => $subasset['subitem_id'],
							'item_id' => $subasset['item_id'],
							'is_sub_item' => 1,
							'installed_subitem_id' => $subasset['id'],
							'site' => $subasset['site'],
							'location' => $subasset['location'],
							'faulty_time_omc' => $this->input->post('omc_name'),
							'faulty_date' => $this->input->post('faulty_date'),
							'est_cost' => $overAllEstCost,
							'comments' => $this->input->post('faulty_reason'),
							);

						 $this->db->insert('faulty_equipment_list',$faulty_data);
											
						$asset_transaction_data = array(
							'installed_id' => $id,
							'item_id' => $subasset['item_id'],
							'subitem_id' => $subasset['subitem_id'],
							'is_sub_item' => 1,
							'installed_subitem_id' => $subasset['id'],
							'asset_id'=> $subasset['asset_id'],
							'transaction_type' => "10",
							'site' => $subasset['site'],
							'location' => $subasset['location'],
							'faulty_time_omc' => $this->input->post('omc_name'),
							'faulty_date' => $this->input->post('faulty_date'),
							'estimated_cost' => $overAllEstCost,
							'user_type' => "1",
							'added_by' => $this->session->userdata('adminid'),
							'action_date' => $date,
							'action_comments' => $this->input->post('faulty_reason'),
							);
						 $this->db->insert('asset_transaction',$asset_transaction_data);
				}	
			 }
			 if($repairing_start[0]['have_sub_items']==0){

				$installing_data = array(
					'transaction_type' => "10",
					'company_type'=>'',
					'company_name'=>'',
					'company_address'=>'',
					'company_person_type'=>'',
					'person_name'=>'',
					'person_contact'=>'',
					'faulty_time_omc' => $this->input->post('omc_name'),
					'faulty_date' => $this->input->post('faulty_date'),
					'est_cost' => $this->input->post('estimated_cost'),
					'user_type' => "1",
					'user_name' => $this->session->userdata('adminid'),
					'action_date' => $date,
					);
					$this->db->where('id',$id);
				$this->db->update('installed_inventory',$installing_data);

				$faulty_data = array(
					'asset_id'=> $repairing_start[0]['asset_id'],
					'installed_id' => $id,
					'item_id' => $repairing_start[0]['name'],
					'is_sub_item' => $repairing_start[0]['have_sub_items'],
					'site' => $repairing_start[0]['site'],
					'location' => $repairing_start[0]['location'],
					'faulty_time_omc' => $this->input->post('omc_name'),
					'faulty_date' => $this->input->post('faulty_date'),
					'est_cost' => $this->input->post('estimated_cost'),
					'comments' => $this->input->post('faulty_reason'),
					);

				 $this->db->insert('faulty_equipment_list',$faulty_data);

			$data = array(
			'installed_id' => $id,
			'item_id' => $repairing_start[0]['name'],
			'asset_id'=> $repairing_start[0]['asset_id'],
			'have_sub_items' => $repairing_start[0]['have_sub_items'],
			'transaction_type' => "10",
			'site' => $repairing_start[0]['site'],
			'location' => $repairing_start[0]['location'],
			'faulty_time_omc' => $this->input->post('omc_name'),
			'faulty_date' => $this->input->post('faulty_date'),
			'estimated_cost' => $this->input->post('estimated_cost'),
			'user_type' => "1",
			'added_by' => $this->session->userdata('adminid'),
			'action_date' => $date,
			'action_comments' => $this->input->post('faulty_reason'),
			);
			$counter++;
			// echo "<pre>"; print_r($data); exit;  
				  
			$this->db->insert('asset_transaction',$data);
			}
		}
		 echo json_encode(array('response' => true, 'message' =>'Faulty Done.','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;	
	 }
	}
}   
	/** Component Faulty Start */
elseif ($para1 == 'component_faulty')
{
		$this->page_data['repairs'] = explode(',', $_POST['asset']);
		$components = $this->page_data['repairs'];
		$data = array();
		foreach($components as $component)
		{
			$data = $this->db->get_where('installed_subitems',array('id' => $component))->result_array();
		}
		//   echo "<pre>"; print_r($data); exit;
		$data2 = array();
		foreach($data as $row)
		{
				if($row['transaction_type'] == "10")
				{
					echo "Selected Component already faulty."; exit;
				}
				if($row['transaction_type'] == "11")
				{
					echo "Selected Component already faulty."; exit;
				}
				if($row['transaction_type'] == "4")
				{
					echo "Selected Component already in repairing mode."; exit;
				}
				// if($row['transaction_type'] == "5")
				// {
				// 	echo "Selected Component's repairing recently completed."; exit;
				// }
				// if($row['transaction_type'] == "6")
				// {
				// 	echo "Retired Component cannot be repair."; exit;
				// }
				if($row['transaction_type'] == "13")
				{
					echo "Repairing Mode Component cannot be Faulty."; exit;
				}
				if($row['transaction_type'] == "15")
				{
					echo "Retired Component cannot be repair."; exit;
				}
		}

		foreach($data as $record){
			$items = $this->db->get_where('items',array('id' => $record['item_id']))->result_array();
			$this->page_data['equipment_name'] = $items[0]['name'];
			$this->page_data['equipment_id'] = $items[0]['id']; 
		}

		$data3 = array();
	 foreach($components as $component)
	 {
		 $installed_comp = $this->db->get_where('installed_subitems',array('id' => $component))->result_array();
		 $this->db->select('installed_subitems.subitem_id AS temp_id,sub_items.*');
		 $this->db->from('installed_subitems');
		 $this->db->join('sub_items','installed_subitems.subitem_id = sub_items.id');
		 $this->db->where('installed_subitems.id',$component);
		 $query=$this->db->get();
		 $data3= $query->result_array();
		 $this->page_data['data'] = $data3; 		
	 }
	//  echo "<pre>"; print_r($data3); exit;
	 
	 foreach($components as $component)
	 {
		 $installed_location = $this->db->get_where('installed_subitems',array('id' => $component))->result_array();
		 $locationNames = $this->db->get_where('locations',array('id' => $installed_location[0]['location']))->result_array();
		 $siteNames = $this->db->get_where('sites',array('id' => $locationNames[0]['site']))->result_array();			 
		 $this->page_data['sites'] = $siteNames;
		 $this->page_data['locations'] = $locationNames;		 
	 }

		$this->page_data['data1'] = $data;
		$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
		$this->load->view('back/inventory/component_faulty',$this->page_data);	
}
/** component faulty End */

/** component faulty do Start */
elseif ($para1 == 'component_faulty_do')
 { 
 $this->load->library('form_validation');
 $this->form_validation->set_rules('omc_name','OMC Name','required|trim');
 $this->form_validation->set_rules('faulty_date','Faulty Date ','required|trim');
 	
 if($this->form_validation->run() == TRUE)
 {
	 if($this->session->userdata('adminid'))
	 {
			$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
			$component_id = $this->page_data['assets_ids'];		
			$counter = 0;	
				$subitems = $this->db->get_where('installed_subitems',array('id' => $component_id[0]))->result_array();
				
				foreach($subitems as $subasset){

					$date = date("Y-m-d H:i:s");

					$asset_data = array
					(
					'action_status' => "11",
					'user_type' => "1",
					'checkin_by' => $this->session->userdata('adminid'),
					'add_date' => time() ,
					);
					$this->db->where('id',$subasset['asset_id']);
					$this->db->update('assets',$asset_data);

					$installing_data = array(
						'transaction_type' => "11",
						'subitem_id'=>$subasset['subitem_id'],
						'company_type'=>'',
						'company_name'=>'',
						'company_address'=>'',
						'company_person_type'=>'',
						'person_name'=>'',
						'person_contact'=>'',
						'faulty_time_omc' => $this->input->post('omc_name'),
						'faulty_date' => $this->input->post('faulty_date'),
						'est_cost' => $this->input->post('estimated_cost'),
						'user_type' => "1",
						'user_name' => $this->session->userdata('adminid'),
						'action_date' => $date,
						);
						$this->db->where('id',$subasset['installed_id']);
					    $this->db->update('installed_inventory',$installing_data);

					$faulty_subitem_data = array(
						'transaction_type' => 11,
						'company_type'=>'',
						'company_name'=>'',
						'company_address'=>'',
						'company_person_type'=>'',
						'person_name'=>'',
						'person_contact'=>'',
						'faulty_time_omc' => $this->input->post('omc_name'),
						'faulty_date' => $this->input->post('faulty_date'),
						'est_cost' => $this->input->post('estimated_cost'),
						'comments' => $this->input->post('faulty_reason'),
						'action_by_user_type' => "1",
						'action_by_user' => $this->session->userdata('adminid'),
						'action_date' => $date,
						);
						$this->db->where('id',$subasset['id']);
						$this->db->update('installed_subitems',$faulty_subitem_data);

						$faulty_data = array(
							'asset_id'=> $subasset['asset_id'],
							'installed_id' => $subasset['installed_id'],
							'subitem_id' => $subasset['subitem_id'],
							'item_id' => $subasset['item_id'],
							'is_sub_item' => 1,
							'installed_subitem_id' => $subasset['id'],
							'site' => $subasset['site'],
							'location' => $subasset['location'],
							'faulty_time_omc' => $this->input->post('omc_name'),
							'faulty_date' => $this->input->post('faulty_date'),
							'est_cost' => $this->input->post('estimated_cost'),
							'comments' => $this->input->post('faulty_reason'),
							);
						 $this->db->insert('faulty_equipment_list',$faulty_data);
											
						$asset_transaction_data = array(
							'installed_id' => $subasset['installed_id'],
							'item_id' => $subasset['item_id'],
							'subitem_id' => $subasset['subitem_id'],
							'is_sub_item' => 1,
							'installed_subitem_id' => $subasset['id'],
							'asset_id'=> $subasset['asset_id'],
							'transaction_type' => "11",
							'site' => $subasset['site'],
							'location' => $subasset['location'],
							'faulty_time_omc' => $this->input->post('omc_name'),
							'faulty_date' => $this->input->post('faulty_date'),
							'estimated_cost' => $this->input->post('estimated_cost'),
							'user_type' => "1",
							'added_by' => $this->session->userdata('adminid'),
							'action_date' => $date,
							'action_comments' => $this->input->post('faulty_reason'),
							);
						 $this->db->insert('asset_transaction',$asset_transaction_data);
				}	
		 echo json_encode(array('response' => true, 'message' =>'Faulty Done.','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;	
	 }
	}
}
/** component faulty do End */

/** component replace Start */
elseif ($para1 == 'component_replace')
{
		$this->page_data['repairs'] = explode(',', $_POST['asset']);
		$components = $this->page_data['repairs'];
		$data = array();
		foreach($components as $component)
		{
			$data = $this->db->get_where('installed_subitems',array('id' => $component))->result_array();
		}
		//    echo "<pre>"; print_r($data); exit;
		

		// echo "<pre>"; print_r($subasset); exit;

		$data2 = array();
		foreach($data as $row)
		{
				// if($row['transaction_type'] == "10")
				// {
				// 	echo "Selected Component already faulty."; exit;
				// }
				if($row['transaction_type'] == "4")
				{
					echo "Selected Component already in repairing mode."; exit;
				}
				// if($row['transaction_type'] == "5")
				// {
				// 	echo "Selected Component's repairing recently completed."; exit;
				// }
				if($row['transaction_type'] == "6")
				{
					echo "Retired Component cannot be replaced."; exit;
				}
				if($row['transaction_type'] == "15")
				{
					echo "Retired Component cannot be replaced."; exit;
				}
		}

		foreach($data as $record){
			$items = $this->db->get_where('items',array('id' => $record['item_id']))->result_array();
			$this->page_data['equipment_name'] = $items[0]['name'];
			$this->page_data['equipment_id'] = $items[0]['id']; 
		}

	 $data3 = array();
	 foreach($components as $component)
	 {
		 $installed_comp = $this->db->get_where('installed_subitems',array('id' => $component))->result_array();
		 $this->db->select('installed_subitems.subitem_id AS temp_id,sub_items.*');
		 $this->db->from('installed_subitems');
		 $this->db->join('sub_items','installed_subitems.subitem_id = sub_items.id');
		 $this->db->where('installed_subitems.id',$component);
		 $query=$this->db->get();
		 $data3= $query->result_array();
		 $this->page_data['data'] = $data3; 		
	 }
	//  echo "<pre>"; print_r($data3); exit;
	 
	 foreach($components as $component)
	 {
		 $installed_location = $this->db->get_where('installed_subitems',array('id' => $component))->result_array();
		 $locationNames = $this->db->get_where('locations',array('id' => $installed_location[0]['location']))->result_array();
		 $siteNames = $this->db->get_where('sites',array('id' => $locationNames[0]['site']))->result_array();			 
		 $this->page_data['sites'] = $siteNames;
		 $this->page_data['locations'] = $locationNames;		 
	 }
		$this->page_data['data1'] = $data;
		$this->page_data['tsps'] = $this->Inventory_model->get_tsps();

		foreach($data as $rec){
			$subasset = $this->db->get_where('sub_assets',array('subitem_id' => $rec['subitem_id']))->result_array();
		}

		foreach($subasset as $row){
			$startDate = $row['purchased_on'];
			$s_date = date("Y-m-d", strtotime($startDate));
			// echo $date; exit;
			if($row['warranty_type']=='1'){
			if($row['warranty_duration'] == '3 month'){
				$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +3 month");

				$e_date = date("Y-m-d",$date);
				$date1 = new DateTime($s_date);
				$date2 = new DateTime($e_date);
				$date3 = date("Y-m-d",time());
				$end_date = new DateTime($date3);
				
				if($interval2->days < $interval->days){
					// echo "warranty Remaining";
					$itemName = $this->db->get_where('items',array('id' => $row['item_id']))->result_array();
					$subitemName = $this->db->get_where('sub_items',array('id' => $row['subitem_id']))->result_array();
					if($row['equipment_warranty']==1){
						$this->page_data['equip_replace_warranty'] = "equip replace warranty <br>" ;						
						$this->page_data['replace_equipname'] = $itemName[0]['name']."'s".$subitemName[0]['name']." warranty" ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['equip_mfg_id'] = $row['manufacturer'];
						$this->page_data['modelNo'] = $row['product_model_no'];
                        $manufacturer = $this->db->get_where('manufacturers',array('id' => $row['manufacturer']))->result_array();
						$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
						$this->page_data['equip_supplier_id'] = $row['supplier'];
                        $supplier = $this->db->get_where('suppliers',array('id' => $row['supplier']))->result_array();
						$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
					if($row['equipment_warranty']==0){
						$this->page_data['comp_replace_warranty'] = "comp replace warranty <br>" ;						
						$this->page_data['replace_compname'] = $itemName[0]['name']."'s".$subitemName[0]['name']." warranty" ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['comp_mfg'] = $row['manufacturer'];
						$this->page_data['comp_supplier'] = $row['supplier'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
				}
				else{
					$this->page_data['replace_warranty_finished'] ="Replace Warranty Finished <br>" ;
				}
			}

			if($row['warranty_duration'] == '6 month'){
				$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +6 month");
				$e_date = date("Y-m-d",$date);
				$date1 = new DateTime($s_date);
				$date2 = new DateTime($e_date);
				$date3 = date("Y-m-d",time());
				$end_date = new DateTime($date3);
				
				$interval = $date1->diff($date2);
				$interval2 = $date1->diff($end_date);

				if($interval2->days < $interval->days){
					// echo "warranty Remaining";
					$itemName = $this->db->get_where('items',array('id' => $row['item_id']))->result_array();
					$subitemName = $this->db->get_where('sub_items',array('id' => $row['subitem_id']))->result_array();
					if($row['equipment_warranty']==1){
						$this->page_data['equip_replace_warranty'] = "equip replace warranty <br>" ;						
						$this->page_data['replace_equipname'] = $itemName[0]['name']."'s".$subitemName[0]['name']." warranty <br>" ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['equip_mfg_id'] = $row['manufacturer'];
                        $manufacturer = $this->db->get_where('manufacturers',array('id' => $row['manufacturer']))->result_array();
						$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
						$this->page_data['equip_supplier_id'] = $row['supplier'];
                        $supplier = $this->db->get_where('suppliers',array('id' => $row['supplier']))->result_array();
						$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
					if($row['equipment_warranty']==0){
						$this->page_data['comp_replace_warranty'] = "comp replace warranty <br>" ;						
						$this->page_data['replace_compname'] = $itemName[0]['name']."'s".$subitemName[0]['name']." warranty <br>" ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['comp_mfg'] = $row['manufacturer'];
						$this->page_data['comp_supplier'] = $row['supplier'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
				}
				else{
					$this->page_data['replace_warranty_finished'] ="Replace Warranty Finished <br>" ;
				}				
			}


			if($row['warranty_duration'] == '9 month'){
				$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +9 month");
				$e_date = date("Y-m-d",$date);
				$date1 = new DateTime($s_date);
				$date2 = new DateTime($e_date);
				$date3 = date("Y-m-d",time());
				$end_date = new DateTime($date3);
				
				$interval = $date1->diff($date2);
				$interval2 = $date1->diff($end_date);

				if($interval2->days < $interval->days){
					// echo "warranty Remaining";
					$itemName = $this->db->get_where('items',array('id' => $row['item_id']))->result_array();
					$subitemName = $this->db->get_where('sub_items',array('id' => $row['subitem_id']))->result_array();
					if($row['equipment_warranty']==1){
						$this->page_data['equip_replace_warranty'] = "equip replace warranty <br>" ;						
						$this->page_data['replace_equipname'] = $itemName[0]['name']."'s".$subitemName[0]['name']." warranty <br> " ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['equip_mfg_id'] = $row['manufacturer'];
                        $manufacturer = $this->db->get_where('manufacturers',array('id' => $row['manufacturer']))->result_array();
						$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
						$this->page_data['equip_supplier_id'] = $row['supplier'];
                        $supplier = $this->db->get_where('suppliers',array('id' => $row['supplier']))->result_array();
						$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
					if($row['equipment_warranty']==0){
						$this->page_data['comp_replace_warranty'] = "comp replace warranty <br>" ;						
						$this->page_data['replace_compname'] = $itemName[0]['name']."'s".$subitemName[0]['name']." warranty <br>" ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['comp_mfg'] = $row['manufacturer'];
						$this->page_data['comp_supplier'] = $row['supplier'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
				}
				else{
					$this->page_data['replace_warranty_finished'] ="Replace Warranty Finished <br>" ;
				}
			}


			if($row['warranty_duration'] == '12 month'){
				$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +1 year");
				$e_date = date("Y-m-d",$date);
				$date1 = new DateTime($s_date);
				$date2 = new DateTime($e_date);
				$date3 = date("Y-m-d",time());
				$end_date = new DateTime($date3);
				
				$interval = $date1->diff($date2);
				$interval2 = $date1->diff($end_date);

				if($interval2->days < $interval->days){
					// echo "warranty Remaining";
					$itemName = $this->db->get_where('items',array('id' => $row['item_id']))->result_array();
					$subitemName = $this->db->get_where('sub_items',array('id' => $row['subitem_id']))->result_array();
					if($row['equipment_warranty']==1){
						$this->page_data['equip_replace_warranty'] = "equip replace warranty <br>" ;						
						$this->page_data['replace_equipname'] = $itemName[0]['name']."'s".$subitemName[0]['name']." warranty <br> " ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['equip_mfg_id'] = $row['manufacturer'];
                        $manufacturer = $this->db->get_where('manufacturers',array('id' => $row['manufacturer']))->result_array();
						$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
						$this->page_data['equip_supplier_id'] = $row['supplier'];
                        $supplier = $this->db->get_where('suppliers',array('id' => $row['supplier']))->result_array();
						$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
					if($row['equipment_warranty']==0){
						$this->page_data['comp_replace_warranty'] = "comp replace warranty <br>" ;						
						$this->page_data['replace_compname'] = $itemName[0]['name']."'s".$subitemName[0]['name']." warranty <br> " ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['comp_mfg'] = $row['manufacturer'];
						$this->page_data['comp_supplier'] = $row['supplier'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
				}
				else{  
					$this->page_data['replace_warranty_finished'] ="Replace Warranty Finished <br>" ;
				}
			}


			if($row['warranty_duration'] == '24 month'){
				$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +24 month");
				$e_date = date("Y-m-d",$date);
				$date1 = new DateTime($s_date);
				$date2 = new DateTime($e_date);
				$date3 = date("Y-m-d",time());
				$end_date = new DateTime($date3);
				
				$interval = $date1->diff($date2);
				$interval2 = $date1->diff($end_date);

				if($interval2->days < $interval->days){
					// echo "warranty Remaining";
					$itemName = $this->db->get_where('items',array('id' => $row['item_id']))->result_array();
					$subitemName = $this->db->get_where('sub_items',array('id' => $row['subitem_id']))->result_array();
					if($row['equipment_warranty']==1){
						$this->page_data['equip_replace_warranty'] = "equip replace warranty <br>" ;						
						$this->page_data['replace_equipname'] = $itemName[0]['name']."'s".$subitemName[0]['name']." warranty <br> " ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['equip_mfg_id'] = $row['manufacturer'];
                        $manufacturer = $this->db->get_where('manufacturers',array('id' => $row['manufacturer']))->result_array();
						$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
						$this->page_data['equip_supplier_id'] = $row['supplier'];
                        $supplier = $this->db->get_where('suppliers',array('id' => $row['supplier']))->result_array();
						$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
					if($row['equipment_warranty']==0){
						$this->page_data['comp_replace_warranty'] = "comp replace warranty <br>" ;						
						$this->page_data['replace_compname'] = $itemName[0]['name']."'s".$subitemName[0]['name']." warranty <br>" ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['comp_mfg'] = $row['manufacturer'];
						$this->page_data['comp_supplier'] = $row['supplier'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
				}
				else{
					$this->page_data['replace_warranty_finished'] ="Replace Warranty Finished <br>" ;
				}
			}


			if($row['warranty_duration'] == '36 month'){
				$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +36 month");
				$e_date = date("Y-m-d",$date);
				$date1 = new DateTime($s_date);
				$date2 = new DateTime($e_date);
				$date3 = date("Y-m-d",time());
				$end_date = new DateTime($date3);
				
				$interval = $date1->diff($date2);
				$interval2 = $date1->diff($end_date);

				if($interval2->days < $interval->days){
					// echo "warranty Remaining";
					$itemName = $this->db->get_where('items',array('id' => $row['item_id']))->result_array();
					$subitemName = $this->db->get_where('sub_items',array('id' => $row['subitem_id']))->result_array();
					if($row['equipment_warranty']==1){
						$this->page_data['equip_replace_warranty'] = "equip replace warranty <br>" ;						
						$this->page_data['replace_equipname'] = $itemName[0]['name']."'s".$subitemName[0]['name']." warranty <br>" ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['equip_mfg_id'] = $row['manufacturer'];
                        $manufacturer = $this->db->get_where('manufacturers',array('id' => $row['manufacturer']))->result_array();
						$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
						$this->page_data['equip_supplier_id'] = $row['supplier'];
                        $supplier = $this->db->get_where('suppliers',array('id' => $row['supplier']))->result_array();
						$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
					if($row['equipment_warranty']==0){
						$this->page_data['comp_replace_warranty'] = "comp replace warranty <br>" ;						
						$this->page_data['replace_compname'] = $itemName[0]['name']."'s".$subitemName[0]['name']." warranty <br> " ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['comp_mfg'] = $row['manufacturer'];
						$this->page_data['comp_supplier'] = $row['supplier'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
				}
				else{
					$this->page_data['replace_warranty_finished'] ="Replace Warranty Finished <br>" ;
				}
			}


			if($row['warranty_duration'] == '48 month'){
				$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +48 month");
				$e_date = date("Y-m-d",$date);
				$date1 = new DateTime($s_date);
				$date2 = new DateTime($e_date);
				$date3 = date("Y-m-d",time());
				$end_date = new DateTime($date3);
				
				$interval = $date1->diff($date2);
				$interval2 = $date1->diff($end_date);

				if($interval2->days < $interval->days){
					// echo "warranty Remaining";
					$itemName = $this->db->get_where('items',array('id' => $row['item_id']))->result_array();
					$subitemName = $this->db->get_where('sub_items',array('id' => $row['subitem_id']))->result_array();
					if($row['equipment_warranty']==1){
						$this->page_data['equip_replace_warranty'] = "equip replace warranty <br>" ;						
						$this->page_data['replace_equipname'] = $itemName[0]['name']."'s".$subitemName[0]['name']." warranty <br>" ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['equip_mfg_id'] = $row['manufacturer'];
                        $manufacturer = $this->db->get_where('manufacturers',array('id' => $row['manufacturer']))->result_array();
						$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
						$this->page_data['equip_supplier_id'] = $row['supplier'];
                        $supplier = $this->db->get_where('suppliers',array('id' => $row['supplier']))->result_array();
						$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
					if($row['equipment_warranty']==0){
						$this->page_data['comp_replace_warranty'] = "comp replace warranty <br>" ;						
						$this->page_data['replace_compname'] = $itemName[0]['name']."'s".$subitemName[0]['name']." warranty <br>" ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['comp_mfg'] = $row['manufacturer'];
						$this->page_data['comp_supplier'] = $row['supplier'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
				}
				else{
					$this->page_data['replace_warranty_finished'] ="Replace Warranty Finished <br>" ;
				}
			}


			if($row['warranty_duration'] == '60 month'){
				$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +60 month");
				$e_date = date("Y-m-d",$date);
				$date1 = new DateTime($s_date);
				$date2 = new DateTime($e_date);
				$date3 = date("Y-m-d",time());
				$end_date = new DateTime($date3);
				
				$interval = $date1->diff($date2);
				$interval2 = $date1->diff($end_date);

				if($interval2->days < $interval->days){
					// echo "warranty Remaining";
					$itemName = $this->db->get_where('items',array('id' => $row['item_id']))->result_array();
					$subitemName = $this->db->get_where('sub_items',array('id' => $row['subitem_id']))->result_array();
					if($row['equipment_warranty']==1){
					
						$this->page_data['equip_replace_warranty'] = "equip replace warranty <br>" ;						
						$this->page_data['replace_equipname'] = $itemName[0]['name']."'s".$subitemName[0]['name']." warranty <br>" ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['equip_mfg_id'] = $row['manufacturer'];
                        $manufacturer = $this->db->get_where('manufacturers',array('id' => $row['manufacturer']))->result_array();
						$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
						$this->page_data['equip_supplier_id'] = $row['supplier'];
                        $supplier = $this->db->get_where('suppliers',array('id' => $row['supplier']))->result_array();
						$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
					if($row['equipment_warranty']==0){
						$this->page_data['comp_replace_warranty'] = "comp replace warranty <br>" ;						
						$this->page_data['replace_compname'] = $itemName[0]['name']."'s".$subitemName[0]['name']." warranty <br>" ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['comp_mfg'] = $row['manufacturer'];
						$this->page_data['comp_supplier'] = $row['supplier'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
				}
				else{
					$this->page_data['replace_warranty_finished'] ="Replace Warranty Finished <br>" ;
				}
			}

		}

		if($row['warranty_type']=='2'){
			if($row['warranty_duration'] == '3 month'){
				$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +3 month");

				$e_date = date("Y-m-d",$date);
				$date1 = new DateTime($s_date);
				$date2 = new DateTime($e_date);
				$date3 = date("Y-m-d",time());
				$end_date = new DateTime($date3);
				
				if($interval2->days < $interval->days){
					// echo "warranty Remaining";
					$itemName = $this->db->get_where('items',array('id' => $row['item_id']))->result_array();
					$subitemName = $this->db->get_where('sub_items',array('id' => $row['subitem_id']))->result_array();
					if($row['equipment_warranty']==1){
						$this->page_data['equip_repair_warranty'] = "Equip Repair Warranty <br>" ;						
						$this->page_data['repair_equipname'] = $itemName[0]['name']."'s".$subitemName[0]['name']." warranty <br>" ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['equip_mfg_id'] = $row['manufacturer'];
                        $manufacturer = $this->db->get_where('manufacturers',array('id' => $row['manufacturer']))->result_array();
						$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
						$this->page_data['equip_supplier_id'] = $row['supplier'];
                        $supplier = $this->db->get_where('suppliers',array('id' => $row['supplier']))->result_array();
						$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
					if($row['equipment_warranty']==0){
						$this->page_data['comp_repair_warranty'] = "Comp Repair Warranty <br>" ;						
						$this->page_data['repair_compname'] = $itemName."'s".$subitemName." warranty <br>" ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['comp_mfg'] = $row['manufacturer'];
						$this->page_data['comp_supplier'] = $row['supplier'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
				}
				else{
					$this->page_data['repair_warranty_finished'] ="Warranty Finished <br>" ;
				}
			}


			if($row['warranty_duration'] == '6 month'){
				$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +6 month");
				$e_date = date("Y-m-d",$date);
				$date1 = new DateTime($s_date);
				$date2 = new DateTime($e_date);
				$date3 = date("Y-m-d",time());
				$end_date = new DateTime($date3);
				
				$interval = $date1->diff($date2);
				$interval2 = $date1->diff($end_date);

				if($interval2->days < $interval->days){
					// echo "warranty Remaining";
					$itemName = $this->db->get_where('items',array('id' => $row['item_id']))->result_array();
					$subitemName = $this->db->get_where('sub_items',array('id' => $row['subitem_id']))->result_array();
					if($row['equipment_warranty']==1){
						$this->page_data['equip_repair_warranty'] = "Equip Repair Warranty <br> " ;						
						$this->page_data['repair_equipname'] = $itemName[0]['name']."'s".$subitemName[0]['name']." warranty <br>" ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['equip_mfg_id'] = $row['manufacturer'];
                        $manufacturer = $this->db->get_where('manufacturers',array('id' => $row['manufacturer']))->result_array();
						$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
						$this->page_data['equip_supplier_id'] = $row['supplier'];
                        $supplier = $this->db->get_where('suppliers',array('id' => $row['supplier']))->result_array();
						$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
					if($row['equipment_warranty']==0){
						$this->page_data['comp_repair_warranty'] = "Comp Repair Warranty <br>" ;						
						$this->page_data['repair_compname'] = $itemName."'s".$subitemName." warranty <br>" ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['comp_mfg'] = $row['manufacturer'];
						$this->page_data['comp_supplier'] = $row['supplier'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
				}
				else{
					$this->page_data['repair_warranty_finished'] ="Warranty Finished <br>" ;
				}
			}


			if($row['warranty_duration'] == '9 month'){
				$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +9 month");
				$e_date = date("Y-m-d",$date);
				$date1 = new DateTime($s_date);
				$date2 = new DateTime($e_date);
				$date3 = date("Y-m-d",time());
				$end_date = new DateTime($date3);
				
				$interval = $date1->diff($date2);
				$interval2 = $date1->diff($end_date);

				if($interval2->days < $interval->days){
					// echo "warranty Remaining";
					$itemName = $this->db->get_where('items',array('id' => $row['item_id']))->result_array();
					$subitemName = $this->db->get_where('sub_items',array('id' => $row['subitem_id']))->result_array();
					if($row['equipment_warranty']==1){
						$this->page_data['equip_repair_warranty'] = "Equip Repair Warranty <br>" ;						
						$this->page_data['repair_equipname'] = $itemName[0]['name']."'s".$subitemName[0]['name']." warranty <br>" ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['equip_mfg_id'] = $row['manufacturer'];
                        $manufacturer = $this->db->get_where('manufacturers',array('id' => $row['manufacturer']))->result_array();
						$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
						$this->page_data['equip_supplier_id'] = $row['supplier'];
                        $supplier = $this->db->get_where('suppliers',array('id' => $row['supplier']))->result_array();
						$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
					if($row['equipment_warranty']==0){
						$this->page_data['comp_repair_warranty'] = "Comp Repair Warranty <br>" ;						
						$this->page_data['repair_compname'] = $itemName."'s".$subitemName." warranty <br>" ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['comp_mfg'] = $row['manufacturer'];
						$this->page_data['comp_supplier'] = $row['supplier'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
				}
				else{
					$this->page_data['repair_warranty_finished'] ="Warranty Finished <br>" ;
				}
			}


			if($row['warranty_duration'] == '12 month'){
				$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +1 year");
				$e_date = date("Y-m-d",$date);
				$date1 = new DateTime($s_date);
				$date2 = new DateTime($e_date);
				$date3 = date("Y-m-d",time());
				$end_date = new DateTime($date3);
				
				$interval = $date1->diff($date2);
				$interval2 = $date1->diff($end_date);

				if($interval2->days < $interval->days){
					// echo "warranty Remaining";
					$itemName = $this->db->get_where('items',array('id' => $row['item_id']))->result_array();
					$subitemName = $this->db->get_where('sub_items',array('id' => $row['subitem_id']))->result_array();
					if($row['equipment_warranty']==1){
						$this->page_data['equip_repair_warranty'] = "Equip Repair Warranty <br>" ;						
						$this->page_data['repair_equipname'] = $itemName[0]['name']."'s".$subitemName[0]['name']." warranty <br> " ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['equip_mfg_id'] = $row['manufacturer'];
                        $manufacturer = $this->db->get_where('manufacturers',array('id' => $row['manufacturer']))->result_array();
						$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
						$this->page_data['equip_supplier_id'] = $row['supplier'];
                        $supplier = $this->db->get_where('suppliers',array('id' => $row['supplier']))->result_array();
						$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
					if($row['equipment_warranty']==0){
						$this->page_data['comp_repair_warranty'] = "Comp Repair Warranty <br>" ;						
						$this->page_data['repair_compname'] = $itemName."'s".$subitemName." warranty <br>" ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['comp_mfg'] = $row['manufacturer'];
						$this->page_data['comp_supplier'] = $row['supplier'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
				}
				else{
					$this->page_data['repair_warranty_finished'] ="Warranty Finished <br>" ;
				}
			}


			if($row['warranty_duration'] == '24 month'){
				$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +24 month");
				$e_date = date("Y-m-d",$date);
				$date1 = new DateTime($s_date);
				$date2 = new DateTime($e_date);
				$date3 = date("Y-m-d",time());
				$end_date = new DateTime($date3);
				
				$interval = $date1->diff($date2);
				$interval2 = $date1->diff($end_date);

				if($interval2->days < $interval->days){
					// echo "warranty Remaining";
					$itemName = $this->db->get_where('items',array('id' => $row['item_id']))->result_array();
					$subitemName = $this->db->get_where('sub_items',array('id' => $row['subitem_id']))->result_array();
					if($row['equipment_warranty']==1){
						$this->page_data['equip_repair_warranty'] = "Equip Repair Warranty <br>" ;						
						$this->page_data['repair_equipname'] = $itemName[0]['name']."'s".$subitemName[0]['name']." warranty <br>" ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['equip_mfg_id'] = $row['manufacturer'];
                        $manufacturer = $this->db->get_where('manufacturers',array('id' => $row['manufacturer']))->result_array();
						$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
						$this->page_data['equip_supplier_id'] = $row['supplier'];
                        $supplier = $this->db->get_where('suppliers',array('id' => $row['supplier']))->result_array();
						$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
					if($row['equipment_warranty']==0){
						$this->page_data['comp_repair_warranty'] = "Comp Repair Warranty <br>" ;						
						$this->page_data['repair_compname'] = $itemName."'s".$subitemName." warranty <br>" ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['comp_mfg'] = $row['manufacturer'];
						$this->page_data['comp_supplier'] = $row['supplier'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
				}
				else{
					$this->page_data['repair_warranty_finished'] ="Warranty Finished <br>" ;
				}
			}


			if($row['warranty_duration'] == '36 month'){
				$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +36 month");
				$e_date = date("Y-m-d",$date);
				$date1 = new DateTime($s_date);
				$date2 = new DateTime($e_date);
				$date3 = date("Y-m-d",time());
				$end_date = new DateTime($date3);
				
				$interval = $date1->diff($date2);
				$interval2 = $date1->diff($end_date);

				if($interval2->days < $interval->days){
					// echo "warranty Remaining";
					$itemName = $this->db->get_where('items',array('id' => $row['item_id']))->result_array();
					$subitemName = $this->db->get_where('sub_items',array('id' => $row['subitem_id']))->result_array();
					if($row['equipment_warranty']==1){
						$this->page_data['equip_repair_warranty'] = "Equip Repair Warranty <br>" ;						
						$this->page_data['repair_equipname'] = $itemName[0]['name']."'s".$subitemName[0]['name']." warranty <br>" ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['comp_mfg'] = $row['manufacturer'];
						$this->page_data['comp_supplier'] = $row['supplier'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
					if($row['equipment_warranty']==0){
						$this->page_data['comp_repair_warranty'] = "Comp Repair Warranty <br>" ;						
						$this->page_data['repair_compname'] = $itemName."'s".$subitemName." warranty <br>" ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['comp_mfg'] = $row['manufacturer'];
						$this->page_data['comp_supplier'] = $row['supplier'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
				}
				else{
					$this->page_data['repair_warranty_finished'] ="Warranty Finished <br>" ;
				}
			}


			if($row['warranty_duration'] == '48 month'){
				$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +48 month");
				$e_date = date("Y-m-d",$date);
				$date1 = new DateTime($s_date);
				$date2 = new DateTime($e_date);
				$date3 = date("Y-m-d",time());
				$end_date = new DateTime($date3);
				
				$interval = $date1->diff($date2);
				$interval2 = $date1->diff($end_date);

				if($interval2->days < $interval->days){
					// echo "warranty Remaining";
					$itemName = $this->db->get_where('items',array('id' => $row['item_id']))->result_array();
					$subitemName = $this->db->get_where('sub_items',array('id' => $row['subitem_id']))->result_array();
					if($row['equipment_warranty']==1){
						$this->page_data['equip_repair_warranty'] = "Equip Repair Warranty <br>" ;						
						$this->page_data['repair_equipname'] = $itemName[0]['name']."'s".$subitemName[0]['name']." warranty <br>" ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['equip_mfg_id'] = $row['manufacturer'];
                        $manufacturer = $this->db->get_where('manufacturers',array('id' => $row['manufacturer']))->result_array();
						$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
						$this->page_data['equip_supplier_id'] = $row['supplier'];
                        $supplier = $this->db->get_where('suppliers',array('id' => $row['supplier']))->result_array();
						$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
					if($row['equipment_warranty']==0){
						$this->page_data['comp_repair_warranty'] = "Comp Repair Warranty <br>" ;						
						$this->page_data['repair_compname'] = $itemName."'s".$subitemName." warranty <br>" ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['comp_mfg'] = $row['manufacturer'];
						$this->page_data['comp_supplier'] = $row['supplier'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
				}
				else{
					$this->page_data['repair_warranty_finished'] ="Warranty Finished <br>" ;
				}
			}


			if($row['warranty_duration'] == '60 month'){
				$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +60 month");
				$e_date = date("Y-m-d",$date);
				$date1 = new DateTime($s_date);
				$date2 = new DateTime($e_date);
				$date3 = date("Y-m-d",time());
				$end_date = new DateTime($date3);
				
				$interval = $date1->diff($date2);
				$interval2 = $date1->diff($end_date);

				if($interval2->days < $interval->days){
					// echo "warranty Remaining";
					$itemName = $this->db->get_where('items',array('id' => $row['item_id']))->result_array();
					$subitemName = $this->db->get_where('sub_items',array('id' => $row['subitem_id']))->result_array();
					if($row['equipment_warranty']==1){
						$this->page_data['equip_repair_warranty'] = "Equip Repair Warranty <br>" ;						
						$this->page_data['repair_equipname'] = $itemName[0]['name']."'s".$subitemName[0]['name']." warranty <br>" ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['equip_mfg_id'] = $row['manufacturer'];
                        $manufacturer = $this->db->get_where('manufacturers',array('id' => $row['manufacturer']))->result_array();
						$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
						$this->page_data['equip_supplier_id'] = $row['supplier'];
                        $supplier = $this->db->get_where('suppliers',array('id' => $row['supplier']))->result_array();
						$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
					if($row['equipment_warranty']==0){
						$this->page_data['comp_repair_warranty'] = "Comp Repair Warranty  <br>" ;						
						$this->page_data['repair_compname'] = $itemName."'s".$subitemName." warranty <br> " ;
						$this->page_data['comp_name'] = $subitemName[0]['name'];
						$this->page_data['comp_id'] = $row['subitem_id'];
						$this->page_data['modelNo'] = $row['product_model_no'];
						$this->page_data['comp_mfg'] = $row['manufacturer'];
						$this->page_data['comp_supplier'] = $row['supplier'];
						$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
						$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
						$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m." months, ".$interval2->d." days <br> "; 
						// shows the total amount of days (not divided into years, months and days like above)
						$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
					}
				}
				else{
					$this->page_data['repair_warranty_finished'] ="Warranty Finished <br>" ;
				}
			}
		}
	     if($row['warranty_type']=='0')
		{
			$this->page_data['noWarranty'] ="Have no warranty<br>" ;
		}

 

		} 
		/** foreach loop end */
		$this->load->view('back/inventory/component_replace',$this->page_data);
	
}
/** component replace End */

/** component replace do Start */
elseif ($para1 == 'component_replace_do')
 {
 $this->load->library('form_validation');
//  $this->form_validation->set_rules('omc_name','OMC Name','required|trim');
 $this->form_validation->set_rules('replace_reason','Replace Reason ','required|trim');
 	
 if($this->form_validation->run() == TRUE)
 {
	 if($this->session->userdata('adminid'))
	 {
			$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
			$component_id = $this->page_data['assets_ids'];		
			$counter = 0;	
			if($this->input->post('equip_warranty')){
				$subitems = $this->db->get_where('installed_subitems',array('id' => $component_id[0]))->result_array();
				
				foreach($subitems as $subasset){

					$date = date("Y-m-d H:i:s");

					$asset_data = array
					(
					'action_status' => "12",
					'user_type' => "1",
					'checkin_by' => $this->session->userdata('adminid'),
					'add_date' => time() ,
					);
					$this->db->where('id',$subasset['asset_id']);
					$this->db->update('assets',$asset_data);

					$subasset_data = array
					(
					'action_status' => "12",
					'equipment_warranty'=> '1',
					'product_model_no' => $this->input->post('model_no'),
					'manufacturer' => $this->input->post('mfg'),
					'supplier' => $this->input->post('supplier'),
					'user_type' => "1",
					'user' => $this->session->userdata('adminid'),
					'action_date' => time() ,
					);
					$this->db->where('id',$subasset['subitem_id']);
					$this->db->update('sub_assets',$subasset_data);

					$installing_data = array(
						'transaction_type' => "12",
						'user_type' => "1",
						'user_name' => $this->session->userdata('adminid'),
						'action_date' => $date,
						);
						$this->db->where('id',$subasset['installed_id']);
					    $this->db->update('installed_inventory',$installing_data);

					$installed_subitem_data = array(
						'transaction_type' => 12,
						'model_no' => $this->input->post('model_no'),
						'manufacturer' => $this->input->post('mfg'),
						'supplier' => $this->input->post('supplier'),
						'comments' => $this->input->post('replace_reason'),
						'action_by_user_type' => "1",
						'action_by_user' => $this->session->userdata('adminid'),
						'action_date' => $date,
						);
						$this->db->where('id',$subasset['id']);
						$this->db->update('installed_subitems',$installed_subitem_data);

						// $faulty_data = array(
						// 	'installed_id' => $subasset['installed_id'],
						// 	'subitem_id' => $subasset['subitem_id'],
						// 	'item_id' => $subasset['item_id'],
						// 	'is_sub_item' => 1,
						// 	'installed_subitem_id' => $subasset['id'],
						// 	'site' => $subasset['site'],
						// 	'location' => $subasset['location'],
						// 	'faulty_time_omc' => $this->input->post('omc_name'),
						// 	'faulty_date' => $this->input->post('faulty_date'),
						// 	'est_cost' => $this->input->post('estimated_cost'),
						// 	'comments' => $this->input->post('faulty_reason'),
						// 	);
							$this->db->where('installed_subitem_id', $subasset['id']);
							$this->db->delete('faulty_equipment_list');
											
						$asset_transaction_data = array(
							'installed_id' => $subasset['installed_id'],
							'item_id' => $subasset['item_id'],
							'subitem_id' => $subasset['subitem_id'],
							'is_sub_item' => 1,
							'installed_subitem_id' => $subasset['id'],
							'asset_id'=> $subasset['asset_id'],
							'transaction_type' => "12",
							'site' => $subasset['site'],
							'location' => $subasset['location'],
							'organisation_type' => "",
							'organisation' => "",
							'organisation_address' => "",
							'person' => "",
							'person_contact' => "",
							'faulty_time_omc' => "",
							'faulty_date' => "",
							'estimated_cost' => "",
							'user_type' => "1",
							'added_by' => $this->session->userdata('adminid'),
							'action_date' => $date,
							'action_comments' => $this->input->post('replace_reason'),
							);
						 $this->db->insert('asset_transaction',$asset_transaction_data);
				}	
			}

			else{
				$subitems = $this->db->get_where('installed_subitems',array('id' => $component_id[0]))->result_array();
				$companyType;
				$companyName;
				$companyAddress;
				$companyPersonType;
				$companyPerson;
				$personContact;
				foreach($subitems as $subasset){

					if($this->input->post('replacing_company')==1)
					{
						$companyType = 1;
						$companyName = $this->input->post('replacing_tsp');
						$companyAddress = $this->input->post('tsp_address');
						$companyPersonType = $this->input->post('tsp_person_type');
						$companyPerson = $this->input->post('tsp_person');
						$personContact = $this->input->post('tsp_person_contact');
					}
					if($this->input->post('replacing_company')==2)
					{
						$companyType = 2;
						$companyName = $this->input->post('outer_company_name');
						$companyAddress = $this->input->post('outer_company_address');
						$companyPersonType = 0;
						$companyPerson = $this->input->post('outsider_name');
						$personContact = $this->input->post('outsider_contact');						
					}

					$date = date("Y-m-d H:i:s");

					$asset_data = array
					(
					'action_status' => "12",
					'user_type' => "1",
					'checkin_by' => $this->session->userdata('adminid'),
					'add_date' => time() ,
					);
					$this->db->where('id',$subasset['asset_id']);
					$this->db->update('assets',$asset_data);

					$subasset_data = array
					(
					'action_status' => "12",
					'equipment_warranty'=> '1',
					'product_model_no' => $this->input->post('model_no'),
					'manufacturer' => $this->input->post('mfg'),
					'supplier' => $this->input->post('supplier'),
					'user_type' => "1",
					'user' => $this->session->userdata('adminid'),
					'action_date' => time() ,
					);
					$this->db->where('id',$subasset['subitem_id']);
					$this->db->update('sub_assets',$subasset_data);

					$installing_data = array(
						'transaction_type' => "12",
						'user_type' => "1",
						'user_name' => $this->session->userdata('adminid'),
						'action_date' => $date,
						);
						$this->db->where('id',$subasset['installed_id']);
					    $this->db->update('installed_inventory',$installing_data);

					$installed_subitem_data = array(
						'transaction_type' => 12,
						'model_no' => $this->input->post('model_no'),
						'manufacturer' => $this->input->post('mfg'),
						'supplier' => $this->input->post('supplier'),
						'action_by_user_type' => "1",
						'company_type'=>$companyType,
						'company_name'=>$companyName,
						'company_address'=>$companyAddress,
						'company_person_type'=>$companyPersonType,
						'person_name'=>$companyPerson,
						'cost'=>$this->input->post('replace_cost'),
						'person_contact'=>$personContact,
						'comments' => $this->input->post('replace_reason'),
						'action_by_user' => $this->session->userdata('adminid'),
						'action_date' => $date,
						);
						$this->db->where('id',$subasset['id']);
						$this->db->update('installed_subitems',$installed_subitem_data);

						// $faulty_data = array(
						// 	'installed_id' => $subasset['installed_id'],
						// 	'subitem_id' => $subasset['subitem_id'],
						// 	'item_id' => $subasset['item_id'],
						// 	'is_sub_item' => 1,
						// 	'installed_subitem_id' => $subasset['id'],
						// 	'site' => $subasset['site'],
						// 	'location' => $subasset['location'],
						// 	'faulty_time_omc' => $this->input->post('omc_name'),
						// 	'faulty_date' => $this->input->post('faulty_date'),
						// 	'est_cost' => $this->input->post('estimated_cost'),
						// 	'comments' => $this->input->post('faulty_reason'),
						// 	);
							$this->db->where('installed_subitem_id', $subasset['id']);
							$this->db->delete('faulty_equipment_list');
											
						$asset_transaction_data = array(
							'installed_id' => $subasset['installed_id'],
							'item_id' => $subasset['item_id'],
							'subitem_id' => $subasset['subitem_id'],
							'is_sub_item' => 1,
							'installed_subitem_id' => $subasset['id'],
							'asset_id'=> $subasset['asset_id'],
							'transaction_type' => "12",
							'site' => $subasset['site'],
							'location' => $subasset['location'],
							'organisation_type' => 2,
							'organisation' => $this->input->post('outer_company_name'),
							'organisation_address' => $this->input->post('outer_company_address'),
							'person' => $this->input->post('outsider_name'),
							'person_contact' => $this->input->post('outsider_contact'),
							'cost' => $this->input->post('replace_cost'),
							'user_type' => "1",
							'added_by' => $this->session->userdata('adminid'),
							'action_date' => $date,
							'action_comments' => $this->input->post('replace_reason'),
							);
						 $this->db->insert('asset_transaction',$asset_transaction_data);
				}	
			}
		 echo json_encode(array('response' => true, 'message' =>'Faulty Done.','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;	
	 }
	}
}
/** component replace do End */

	elseif ($para1 == 'start_repair')
	{
			$this->page_data['repairs'] = explode(',', $_POST['asset']);
			$repairs = $this->page_data['repairs'];
			$data = array();
			foreach($repairs as $repair)
			{
				$data[] = $this->db->get_where('installed_inventory',array('id' => $repair))->result_array();
			}
		 	// echo "<pre>"; print_r($data); exit;
			$data2 = array();
			foreach($data as $row)
			{
					// if($row[0]['transaction_type'] !== 1 && $row[0]['transaction_type'] !== 4 && $row[0]['transaction_type'] !== 5 && $row[0]['transaction_type'] !== 6)
					// {
					// 	echo "Brand New item cannot be repair."; exit;
					// }
					// if($row[0]['transaction_type'] == "1")
					// {
					// 	echo "Checked Out item cannot be repair."; exit;
					// }
					if($row[0]['transaction_type'] == "4")
					{
						echo "Selected item already in repairing mode."; exit;
					}
					if($row[0]['transaction_type'] == "5")
					{
						echo "Selected item's repairing recently completed."; exit;
					}
					if($row[0]['transaction_type'] == "6")
					{
						echo "Retire item cannot be repair."; exit;
					}
			}
			$data3 = array();
		 foreach($repairs as $repair)
		 {
			 $installing_names = $this->db->get_where('installed_inventory',array('id' => $repair))->result_array();
			 $this->db->select('installed_inventory.name AS temp_id,items.*');
			 $this->db->from('installed_inventory');
			 $this->db->join('items','installed_inventory.name = items.id');
			 $this->db->where('installed_inventory.id',$repair);
			 $query=$this->db->get();
			 $data3[]= $query->result_array();
			 $this->page_data['data'] = $data3; 		
		 }
		 
		 foreach($repairs as $repair)
		 {
			 $installed_location = $this->db->get_where('installed_inventory',array('id' => $repair,'transaction_type'=> 10))->result_array();
			 $locationNames = $this->db->get_where('locations',array('id' => $installed_location[0]['location']))->result_array();
			 $siteNames = $this->db->get_where('sites',array('id' => $locationNames[0]['site']))->result_array();			 
			 $this->page_data['sites'] = $siteNames;
			 $this->page_data['locations'] = $locationNames;	 		
		 }
			$this->page_data['data1'] = $data;
			$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
			$this->load->view('back/inventory/start_repair',$this->page_data);	
 }

 elseif ($para1 == 'start_repair_do')
 {
 $this->load->library('form_validation');
 $this->form_validation->set_rules('item_site','Item Site','required|trim');
 $this->form_validation->set_rules('item_location','Item Location','required|trim');
 $this->form_validation->set_rules('item_availability','Item Availability','required|trim');
 $this->form_validation->set_rules('repair_type','Repair Type','required|trim');
//  $this->form_validation->set_rules('repairing_company','Repairing Company','required|trim');
 $this->form_validation->set_rules('expected_completion','Expected Repair Completion Date','required|trim');
 $this->form_validation->set_rules('start_repair_reason','Reason For Repairing','required|trim');
 	
 if($this->form_validation->run() == TRUE)
 {
	 if($this->session->userdata('adminid'))
	 {  
		// echo "<pre>"; print_r($_POST); exit;
		//   $description = $this->db->get_where('items',array('id'=>$this->input->post('asset_name')))->result_array();
		// 	$return_date = $this->input->post('return_date');
			
		if($this->input->post('repair_type')==2)
		{	
			$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
			$install_ids = $this->page_data['assets_ids'];
			
			
			foreach ($install_ids as $id){
			$date = date("Y-m-d H:i:s");

			$install = $this->db->get_where('installed_inventory',array('id' => $id))->result_array();
			$ast_mfg = $this->db->get_where('assets',array('id' => $install[0]['asset_id']))->result_array();
			
			$installing_data = array(
				'transaction_type' => "4",
				'user_type' => "1",
				'user_name' => $this->session->userdata('adminid'),
				'action_date' => $date,
				);
				$this->db->where('id',$id);
		 $this->db->update('installed_inventory',$installing_data);

			$data = array(
			'asset_id' => $install[0]['asset_id'],
			'installed_id' => $id,
			'transaction_type' => 4,
			'site' => $this->input->post('item_site'),
			'location' => $this->input->post('item_location'),
			'repair_type' => $this->input->post('repair_type'),
			'available' => $this->input->post('item_availability'),
			'user_type' => "1",
			'added_by' => $this->session->userdata('adminid'),
			'action_date' => $date,
			'organisation_type' => 3,
			'organisation' => $ast_mfg[0]['manufacturer'],
			'organisation_address' => 'see manufacturer address',
			'repairing_person_type' => $this->input->post('tsp_person_type'),
			'person' => 'manufacturer focal person does not exist',
			'person_contact' => 'not available',
			'return_date' => $this->input->post('expected_completion'),
			'action_comments' => $this->input->post('start_repair_reason'),
			);
			 // echo "<pre>"; print_r($data); exit;
		$assets_data = array('action_status'=>'4','user_type' => "1",'checkin_by' => $this->session->userdata('adminid'),'site'=> $this->input->post('item_site'));
		 $this->db->where('id',$install[0]['asset_id']);
		 $this->db->update('assets',$assets_data);
		 $this->db->insert('asset_transaction',$data);

			/** Query to insert Action Noification Table */
			// $supervisors = $this->db->get('tpsupervisor')->result_array();
			// foreach($supervisors as $sp_id)
			// {
			// $data11 = array(
			// 	'for_user_id' => $sp_id['id'],
			// 	'for_user_type' => 1,
			// 	'user_id' => $this->session->userdata('adminid'),
			// 	'user_type' => 3,
			// 	'ref_id' 	=> $id,
			// 	'alert_type'  => 1,
			// 	'date' => date("Y-m-d H:i:s"),
			// 	'is_read' => 0,
			// 	'notification_msg' => 'An Asset"s Repairing Start added by Admin.'                
			// 	 );
			// 	$this->db->insert('notifications', $data11);
			// } 
			/** Query to insert Action Noification in Table */
		 }
	 echo json_encode(array('response' => true, 'message' =>'Repairing Starts.','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;
		}

		if($this->input->post('repair_type')==1)
		{
		    if($this->input->post('repairing_company')=="1")
			{	
				$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
				$install_ids = $this->page_data['assets_ids'];
				
				
				foreach ($install_ids as $id){
				$date = date("Y-m-d H:i:s");

				$install = $this->db->get_where('installed_inventory',array('id' => $id))->result_array();
				$installing_data = array(
					'transaction_type' => "4",
					'user_type' => "1",
					'user_name' => $this->session->userdata('adminid'),
					'action_date' => $date,
					);
					$this->db->where('id',$id);
			 $this->db->update('installed_inventory',$installing_data);

				$data = array(
				'asset_id' => $install[0]['asset_id'],
				'installed_id' => $id,
				'transaction_type' => "4",
				'site' => $this->input->post('item_site'),
				'location' => $this->input->post('item_location'),
				'repair_type' => $this->input->post('repair_type'),
				'available' => $this->input->post('item_availability'),
				'user_type' => "1",
				'added_by' => $this->session->userdata('adminid'),
				'action_date' => $date,
				'organisation_type' => 1,
				'organisation' => $this->input->post('repairing_tsp'),
				'organisation_address' => $this->input->post('tsp_address'),
				'repairing_person_type' => $this->input->post('tsp_person_type'),
				'person' => $this->input->post('tsp_person'),
				'person_contact' => $this->input->post('tsp_person_contact'),
				'return_date' => $this->input->post('expected_completion'),
				'action_comments' => $this->input->post('start_repair_reason'),
				);
			 	// echo "<pre>"; print_r($data); exit;
			$assets_data = array('action_status'=>'4','user_type' => "1",'checkin_by' => $this->session->userdata('adminid'),'site'=> $this->input->post('item_site'));
			 $this->db->where('id',$install[0]['asset_id']);
			 $this->db->update('assets',$assets_data);
			 $this->db->insert('asset_transaction',$data);

				/** Query to insert Action Noification Table */
				// $supervisors = $this->db->get('tpsupervisor')->result_array();
				// foreach($supervisors as $sp_id)
				// {
				// $data11 = array(
				// 	'for_user_id' => $sp_id['id'],
				// 	'for_user_type' => 1,
				// 	'user_id' => $this->session->userdata('adminid'),
				// 	'user_type' => 3,
				// 	'ref_id' 	=> $id,
				// 	'alert_type'  => 1,
				// 	'date' => date("Y-m-d H:i:s"),
				// 	'is_read' => 0,
				// 	'notification_msg' => 'An Asset"s Repairing Start added by Admin.'                
				// 	 );
				// 	$this->db->insert('notifications', $data11);
				// } 
				/** Query to insert Action Noification in Table */
			 }
		 echo json_encode(array('response' => true, 'message' =>'Repairing Starts.','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;
			}
			if($this->input->post('repairing_company')=="2")
			{
				$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
				$install_ids = $this->page_data['assets_ids'];
				foreach ($install_ids as $id){
				$date = date("Y-m-d H:i:s");

				$install = $this->db->get_where('installed_inventory',array('id' => $id))->result_array();
				$installing_data = array(
					'transaction_type' => "4",
					'user_type' => "1",
					'user_name' => $this->session->userdata('adminid'),
					'action_date' => $date,
					);
					$this->db->where('id',$id);
			 $this->db->update('installed_inventory',$installing_data);

				$data = array(
					'asset_id' => $install[0]['asset_id'],
					'installed_id' => $id,
					'transaction_type' => "4",
					'site' => $this->input->post('item_site'),
					'location' => $this->input->post('item_location'),
					'repair_type' => $this->input->post('repair_type'),
					'available' => $this->input->post('item_availability'),
					'user_type' => "1",
					'added_by' => $this->session->userdata('adminid'),
					'action_date' => $date,
					'organisation_type' => 2,
					'organisation' => $this->input->post('outer_company_name'),
					'organisation_address' => $this->input->post('outer_company_address'),
					'person' => $this->input->post('outsider_name'),
					'person_contact' => $this->input->post('outsider_contact'),
					'return_date' => $this->input->post('expected_completion'),
					'action_comments' => $this->input->post('start_repair_reason'),
					);
			 //	echo "<pre>"; print_r($data); exit;
			$assets_data = array('action_status'=>'4','user_type' => "1",'checkin_by' => $this->session->userdata('adminid'),'site'=> $this->input->post('item_site'));
			 $this->db->where('id',$install[0]['asset_id']);
			 $this->db->update('assets',$assets_data);
			 $this->db->insert('asset_transaction',$data);
				/** Query to insert Action Noification in Table */
				// $supervisors = $this->db->get('tpsupervisor')->result_array();
				// foreach($supervisors as $sp_id)
				// {
				// $data11 = array(
				// 	'for_user_id' => $sp_id['id'],
				// 	'for_user_type' => 1,
				// 	'user_id' => $this->session->userdata('adminid'),
				// 	'user_type' => 3,
				// 	'ref_id' 	=> $id,
				// 	'alert_type'  => 1,
				// 	'date' => date("Y-m-d H:i:s"),
				// 	'is_read' => 0,
				// 	'notification_msg' => 'An Asset"s Repairing Start added by Admin.'                
				// 	 );
				// 	$this->db->insert('notifications', $data11);
				// } 
				/** Query to insert Action Noification in Table */

			 }
		 echo json_encode(array('response' => true, 'message' =>'Repairing Starts.','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;
		  }
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
			$quantity = 0;

			foreach($end_repairs as $repair)
			{
				$quantity++;
				$data[] = $this->db->get_where('installed_inventory',array('id' => $repair))->result_array();
				$locations[] = $this->db->get_where('asset_transaction',array( 'asset_id'=> $repair , 'transaction_type' => "4" , 'site' => $this->session->userdata('site')))->result_array();	
			} 


			$data2 = array();
			foreach($data as $row)
			{
					if($row[0]['transaction_type'] == "0" )
					{
						echo "Brand New items cannot be repaired."; exit;
					}
					if($row[0]['transaction_type'] == "1" )
					{
						echo "Checked Out item Selected. You cannot reinstall checked out asset."; exit;
					}
					if($row[0]['transaction_type'] == "2" )
					{
						echo "Checked In item Selected. You cannot reinstall checked in asset."; exit;
					}
					if($row[0]['transaction_type'] == "3" )
					{
						echo "Already Installed Equipment can't be Re Installed!"; exit;
					}
					if($row[0]['transaction_type'] == "5" )
					{
						echo "Repaired item Selected.Only Repairing Mode items you can select."; exit;
					}
					if($row[0]['transaction_type'] == "6" )
					{
						echo "Retired item Selected."; exit;
					}
			}
			foreach($data as $repair)
			{
				$locationNames = $this->db->get_where('locations',array('id' => $repair[0]['location']))->result_array();
				$siteNames = $this->db->get_where('sites',array('id' => $repair[0]['site']))->result_array();			 
				$this->page_data['sites'] = $siteNames;
				$this->page_data['locations'] = $locationNames;			
			}
			  
		 $data3 = array();
		 foreach($end_repairs as $repair)
		 {
             $installing_names = $this->db->get_where('installed_inventory',array('id' => $repair))->result_array();
			 $this->db->select('installed_inventory.name AS temp_id,items.*');
			 $this->db->from('installed_inventory');
			 $this->db->join('items','installed_inventory.name = items.id');
			 $this->db->where('installed_inventory.id',$repair);
			 $query=$this->db->get();
			 $data3[]= $query->result_array();
			 $this->page_data['data'] = $data3; 			
		 }
			
			$this->page_data['data1'] = $data;
	
			// echo "<pre>"; print_r($this->page_data['selected_sites']); exit;		
			
			$this->page_data['quantity'] = $quantity;
			$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
			$this->load->view('back/inventory/end_repair',$this->page_data);	
 }



 elseif ($para1 == 'end_repair_do')
 {
	 
 $this->load->library('form_validation');
 $this->form_validation->set_rules('repair_completion','Repair Completed Date','required|trim');
 $this->form_validation->set_rules('end_repair_comments','Repairing Comments ','required|trim');
 $this->form_validation->set_rules('repair_price','Repair Cost Price ','required|trim');
 	
 if($this->form_validation->run() == TRUE)
 {
	 if($this->session->userdata('adminid'))
	 {
			$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
			$asset_ids = $this->page_data['assets_ids'];
			$unit_repair_cost = $this->input->post('repair_price')/$this->input->post('quantity');
				
			$counter = 0;
			foreach ($asset_ids as $id)
			{
				$repairing_start = $this->db->select('*')->order_by('id','desc')->get_where('asset_transaction',array('installed_id' => $id,'transaction_type'=> 4))->result_array();
			$date = date("Y-m-d H:i:s");

			$installing_data = array(
				'transaction_type' => "9",
				'user_type' => "1",
				'user_name' => $this->session->userdata('adminid'),
				'action_date' => $date,
				);
				$this->db->where('id',$id);
		 $this->db->update('installed_inventory',$installing_data);

			$data = array(
			'installed_id' => $id,
			'asset_id'=> $repairing_start[0]['asset_id'],
			'transaction_type' => "9",
			'site' => $repairing_start[0]['site'],
			'location' => $repairing_start[0]['location'],
			'unit_repairing_cost' => $unit_repair_cost,
			'organisation_type' => $repairing_start[0]['organisation_type'],
			'organisation' => $repairing_start[0]['organisation'],
			'organisation_address' => $repairing_start[0]['organisation_address'],
			'repairing_person_type' => $repairing_start[0]['repairing_person_type'],
			'person' => $repairing_start[0]['person'],
			'person_contact' => $repairing_start[0]['person_contact'],
			'user_type' => "1",
			'added_by' => $this->session->userdata('adminid'),
			'action_date' => $date,
			'return_date' => $this->input->post('repair_completion'),
			'action_comments' => $this->input->post('end_repair_comments'),
			);
			$counter++;
			// echo "<pre>"; print_r($data); exit;  
				  
			$assets_data = array('action_status'=>'9','site'=> $this->input->post('item_site'));
			$this->db->where('id',$repairing_start[0]['asset_id']);
			$this->db->update('assets',$assets_data);
			$this->db->insert('asset_transaction',$data);
			}
			
		 echo json_encode(array('response' => true, 'message' =>'Repairing Completed.','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;
			
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
				  $data[] = $this->db->get_where('installed_inventory',array('id' => $item))->result_array();
				}

			  $data2 = array();
			  foreach($data as $row)
			  {
					  if($row[0]['transaction_type'] == "0" )
					  {
						  echo "Brand New  Items cannot be Retire ."; exit;
						}
						if($row[0]['transaction_type'] == "1" )
					  {
						  echo "Checked Out Items cannot be Retire ."; exit;
						}
						if($row[0]['transaction_type'] == "4" )
					  {
						  echo "Repairing Items cannot be Retire ."; exit;
						}
						if($row[0]['transaction_type'] == "6" )
					  {
						  echo "Already Retired Items cannot be Retire ."; exit;
					  }
			  }
			  $data3 = array();
			  foreach($retiring_items as $item)
			  {
				  $installing_names = $this->db->get_where('installed_inventory',array('id' => $item))->result_array();
				  $this->db->select('installed_inventory.name AS temp_id,items.*');
				  $this->db->from('installed_inventory');
				  $this->db->join('items','installed_inventory.name = items.id');
				  $this->db->where('installed_inventory.id',$item);
				  $query=$this->db->get();
				  $data3[]= $query->result_array();
			
			  }
			  $this->page_data['data'] = $data3;

		    $this->page_data['data1'] = $data;
				$this->page_data['sites'] = $this->db->get_where('sites',array('id' => $data[0][0]['site']))->result_array();
							 
				// $this->page_data['locations'] = $this->Inventory_model->get_locations();
			
		$this->load->view('back/inventory/retire',$this->page_data);
	}



  elseif ($para1 == 'retire_do')
 {
 $this->load->library('form_validation');
 $this->form_validation->set_rules('retire_type','Retire Type','required|trim');
 $this->form_validation->set_rules('site_id','Site','required|trim');
 $this->form_validation->set_rules('retire_date','Retire Date','required|trim');
 $this->form_validation->set_rules('retire_reason','Retire Reason ','required|trim');
 	
 if($this->form_validation->run() == TRUE)
 {
	 if($this->session->userdata('adminid'))
	 {
				$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
				$install_ids = $this->page_data['assets_ids'];
			
				foreach ($install_ids as $id){
					$installed_inventory = $this->db->get_where('installed_inventory',array('id' => $id))->result_array();
				    
					$date = date("Y-m-d H:i:s");

					$installing_data = array(
						'transaction_type' => "6",
						'user_type' => "1",
						'user_name' => $this->session->userdata('adminid'),
						'action_date' => $date,
						);
						$this->db->where('id',$id);
				 $this->db->update('installed_inventory',$installing_data);


				$data = array(
					'asset_id' => $installed_inventory[0]['asset_id'],
				'installed_id' => $id,
				'transaction_type' => "6",
				'user_type' => "1",
				'added_by' => $this->session->userdata('adminid'),
				'action_date' => $date,
				'retire_type' => $this->input->post('retire_type'),
				'retire_type' => $installed_inventory[0]['asset_id'],
				'site' => $this->input->post('site_id'),
				'retire_date' => $this->input->post('retire_date'),
				'action_comments' => $this->input->post('retire_reason'),
				);
				
			//echo "<pre>"; print_r($data); exit;
			$assets_data = array('action_status'=>'6','user_type' => "1",'checkin_by' => $this->session->userdata('adminid'),'site'=> $this->input->post('site_id'));
			 $this->db->where('id',$installed_inventory[0]['asset_id']);
			 $this->db->update('assets',$assets_data);
			 $this->db->insert('asset_transaction',$data);
				/** Query to insert Action Noification in Table */
				$supervisors = $this->db->get('tpsupervisor')->result_array();
				foreach($supervisors as $sp_id)
				{
				$data11 = array(
					'for_user_id' => $sp_id['id'],
					'for_user_type' => 1,
					'user_id' => $this->session->userdata('adminid'),
					'user_type' => 3,
					'ref_id' 	=> $id,
					'alert_type'  => 1,
					'date' => date("Y-m-d H:i:s"),
					'is_read' => 0,
					'notification_msg' => 'An Asset retired by Admin.'                
					 );
					$this->db->insert('notifications', $data11);
				} 
				/** Query to insert Action Noification in Table */
			 }
		 echo json_encode(array('response' => true, 'message' =>'Retired.','is_redirect' => True,'redirect_url' => base_url().'inventory/first_page')); exit;
			
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
	}
	/** Assets area END */

	/** Asset or Item Type Changing with ajax Start */
	public function asset_type($para1 = '')
	{
				$items = $this->db->get_where('items',array('item_type' => $para1))->result_array();
				if($items)
				{
					$data = array( 'items'=>$items);	
				  echo json_encode($data); 
				}
				else
				{
					echo json_encode("No Item exist of This type.");
				}
	}
	/** Asset or Item Type Changing with ajax End */


	/** Filters Area Start */

		/** Item Type Filter Start */
		public function filter_by_item_type()
		{
			
		}
		/** Item Type Filter End */

		/** Site Filter Start */

		/** Site Filter End */


	/** Filters Area END */

    public function specific_asset($para1 = '', $para2 = '' )
	{	
		if($para1 == 'list')
		{
			$this->page_data['assets'] = $this->db->get_where('assets',array('id' => $para2))->result_array();	
			$this->load->view('back/inventory/display_assets', $this->page_data);
		}
		else
		{
			$this->page_data['page'] = 'specific_asset';
			$this->page_data['asset_id'] = $para1;
			$this->load->view('back/includes/header', $this->page_data);
			$this->load->view('back/inventory/specific_asset', $this->page_data);
			$this->load->view('back/includes/footer', $this->page_data);			
		}
	}
	/** Site related Locations START */
	public function site_related_locations($para1='')
	{
        $locations = $this->db->get_where('locations',array('site' => $para1))->result_array();
		//echo "<pre>"; print_r($locations); exit;
		// $div = '';
		// $div .= '<select name="location[]" onchange="(this.value,this)" class="demo-cs-multiselect form-control" multiple="multiple" data-placeholder="Choose Location" tabindex="-1" data-hide-disabled="true" id="service_category">';
		// $div .='<option value="">Choose location</option>';
		// if($locations){
		// 	foreach($locations as $row){
		// 		$div .= '<option value="'.$row["id"].'">'.$row["location"].'</option>';
		// 	}
		// }
		// $div .= '</select>'; 		
		echo json_encode($locations); 
	}/** Site related Locations END */


	public function asset_history($para1 = '' , $para2 = '', $para3 =''){
		$this->page_data['page'] = 'selected_assets';
		if(!$this->session->userdata('adminid')){
		return redirect('admin/login');
		}
		if($para1 == 'list')
		{
			$this->page_data['asset_transactions'] = $this->db->select('*')->where('asset_id', $para2)->order_by('id','desc')->get('asset_transaction')->result_array();
			// $this->page_data['selected_assets'] = $this->db->get_where('assets',array('id' => $para2))->result_array();		
			$this->load->view('back/inventory/asset_history',$this->page_data);	
		}
		
	}

	public function filterby_item_type($para1 = ''){
		// echo $para1; exit;
		$this->page_data['assets'] = $this->db->get_where('assets',array('item_type'=>$para1))->result_array();
		$this->page_data['sites'] = $this->Inventory_model->getsites();
		$this->page_data['items'] = $this->Inventory_model->get_Items();
		$this->page_data['asset_transactions'] = $this->Inventory_model->get_asset_transactions();
		$this->load->view('back/inventory/display_assets',$this->page_data);
		
	}

	public function filterby_site($para1 = ''){
		// echo $para1; exit;
		$this->page_data['assets'] = $this->db->get_where('assets',array('site'=>$para1))->result_array();
		$this->page_data['sites'] = $this->Inventory_model->getsites();
		$this->page_data['items'] = $this->Inventory_model->get_Items();
		$this->page_data['asset_transactions'] = $this->Inventory_model->get_asset_transactions();
		$this->load->view('back/inventory/display_assets',$this->page_data);
	}

	public function installed_filterby_site($para1 = ''){
		// echo $para1; exit;
		$this->page_data['installs'] = $this->db->get_where('installed_inventory',array('site'=>$para1))->result_array();
		$this->page_data['sites'] = $this->Inventory_model->getsites();
		$this->page_data['items'] = $this->Inventory_model->get_Items();
		$this->page_data['asset_transactions'] = $this->Inventory_model->get_asset_transactions();
		$this->load->view('back/inventory/display_installed', $this->page_data);	
	}
}
?>