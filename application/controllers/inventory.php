<?php
defined('BASEPATH') or exit('NO DIRECT SCRIPT ALLOWED');
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
		// echo phpinfo(); exit;
		$this->page_data['page'] = 'inventory';
		$this->load->model('Inventory_model');
		if ($this->session->userdata('adminid')) {
			$this->page_data['sites'] = $this->Inventory_model->getsites();
			$this->page_data['items'] = $this->Inventory_model->get_Items();
			$this->load->view('back/includes/header', $this->page_data);
			$this->load->view('back/inventory/first_page', $this->page_data);
			$this->load->view('back/includes/footer', $this->page_data);
		}
	}
	/** First Page END */

	/** Tabs START */
	public function tabs($para1 = '')
	{
		if (!$this->session->userdata('adminid')) {
			return redirect('admin/login');
		}

		if ($para1 == 'items') {
			$this->page_data['items'] = $this->Inventory_model->get_Items();
			$this->load->view('back/inventory/display_items', $this->page_data);
		} elseif ($para1 == 'assets') {
			return redirect('inventory/assets/list/');
		} elseif ($para1 == 'installed') {
			return redirect('inventory/installed_inventory/list/');
		} elseif ($para1 == 'sites') {
			return redirect('inventory/sites/list/');
		} elseif ($para1 == 'suppliers') {
			return redirect('inventory/suppliers/list/');
		} elseif ($para1 == 'support_providers') {
			return redirect('inventory/tsp/list/');
		} elseif ($para1 == 'manufacturers') {
			return redirect('inventory/manufacturers/list/');
		} elseif ($para1 == 'subitems') {
			return redirect('inventory/subitems/list/');
		} elseif ($para1 == 'installed_subitems') {
			return redirect('inventory/installed_sub_inventory/list/');
		}
	}
	/** Tabs END */

	/** items area START */
	public function items($para1 = '', $para2 = '', $para3 = '')
	{
		if (!$this->session->userdata('adminid')) {

			return redirect('admin/login');
		}
		if ($para1 == 'reload') {
			return redirect('inventory/tabs/items/');
		}
		if ($para1 == 'list') {
			$this->page_data['items'] = $this->Inventory_model->get_Items();
			$this->load->view('back/inventory/display_items', $this->page_data);
		} elseif ($para1 == 'delete') {

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
			echo json_encode(array('response' => true, 'message' => 'Deleted successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page/'));
			exit;
		} elseif ($para1 == 'item_publish_set') {
			$article = $para2;
			if ($para3 == 'true') {
				$data['status'] = '1';
			} else {
				$data['status'] = '0';
			}
			$this->db->where('id', $article);
			$this->db->update('items', $data);
			echo $para3;
		} else {
			$this->page_data['page'] = 'Items';
			$this->load->view('back/inventory/first_page', $this->page_data);
		}
	}

	public function add_item()
	{
		if (!$this->session->userdata('adminid')) {
			return redirect('admin/login');
		}
		$this->load->view('back/inventory/add_items');
	}

	public function add_item_do()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('item_name', ' ITEM Name', 'required|trim');
		$this->form_validation->set_rules('item_type', ' ITEM Type', 'required|trim');
		$this->form_validation->set_rules('subitems', ' Have Sub Items', 'required|trim');
		$this->form_validation->set_rules('item_[description]', ' ITEM Description', 'required|trim');
		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'item_type' => $this->input->post('item_type'),
				'name' => $this->input->post('item_name'),
				'have_sub_items' => $this->input->post('subitems'),
				'description' => $this->input->post('item_[description]'),
				'date'		  => time(),
				'user_type'		  => 1,
				'user'		  => $this->session->userdata('adminid'),
			);
			$this->db->insert('items', $data);
			echo json_encode(array('response' => true, 'message' => 'Item Added Successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
			exit;
		} else {
			echo json_encode(array('response' => TRUE, 'message' => validation_errors()));
			exit;
		}
	}

	public function items_edit($para1 = '')
	{
		if (!$para1) {
			echo '<div class="alert alert-dismissible alert-danger">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>OOPS!</strong> Invalid Request
				</div>';
			exit;
		}
		$this->page_data['item'] = $this->db->get_where('items', array('id' => $para1))->result_array();
		$this->load->view('back/inventory/edit_items', $this->page_data);
	}

	public function edit_item_do($item_id = '')
	{
		if (!$item_id) {
			echo json_encode(array('response' => TRUE, 'message' => 'Invalid Request'));
			exit;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('item-name', ' ITEM Name', 'required|trim');
		$this->form_validation->set_rules('item_type', ' ITEM Type', 'required|trim');
		$this->form_validation->set_rules('subitems', ' Have Sub Items', 'required|trim');
		$this->form_validation->set_rules('item-[description]', ' ITEM Description', 'required|trim');
		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'item_type' => $this->input->post('item_type'),
				'name' => $this->input->post('item-name'),
				'have_sub_items' => $this->input->post('subitems'),
				'description' => $this->input->post('item-[description]'),
				'date'		  => time(),
				'user_type'		  => 1,
				'user'		  => $this->session->userdata('adminid'),
			);
			$this->db->where('id', $item_id);
			$this->db->update('items', $data);
			echo json_encode(array('response' => true, 'message' => 'Item updated successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page/'));
			exit;
		} else {
			echo json_encode(array('response' => TRUE, 'message' => validation_errors()));
			exit;
		}
	}
	/**  items area END */

	/** Subitems area START */
	public function subitems($para1 = '', $para2 = '', $para3 = '')
	{
		if (!$this->session->userdata('adminid')) {
			return redirect('admin/login');
		}
		if ($para1 == 'reload') {
			return redirect('inventory/tabs/subitems/');
		}
		if ($para1 == 'list') {
			$this->page_data['subitems'] = $this->db->order_by('id', 'desc')->get('sub_items')->result_array();
			$this->load->view('back/inventory/display_subitems', $this->page_data);
		} elseif ($para1 == 'delete') {

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
			echo json_encode(array('response' => true, 'message' => 'Deleted successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page/'));
			exit;
		} elseif ($para1 == 'item_publish_set') {
			$article = $para2;
			if ($para3 == 'true') {
				$data['status'] = '1';
			} else {
				$data['status'] = '0';
			}
			$this->db->where('id', $article);
			$this->db->update('sub_items', $data);

			echo $para3;
		} else {
			$this->page_data['page'] = 'Subitems';
			$this->load->view('back/inventory/first_page', $this->page_data);
		}
	}

	public function add_subitem()
	{
		if (!$this->session->userdata('adminid')) {
			return redirect('admin/login');
		}
		$items = $this->db->get_where('items', array('have_sub_items' => 1))->result_array();
		$this->page_data['item_category'] = $items;
		$this->load->view('back/inventory/add_subitems', $this->page_data);
	}

	public function add_subitem_do()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('item_name', ' ITEM Name', 'required|trim');
		$this->form_validation->set_rules('subitem_name', ' SubItem Name', 'required|trim');
		$this->form_validation->set_rules('item_category', ' ITEM Category', 'required|trim');
		$this->form_validation->set_rules('item_[description]', ' ITEM Description', 'required|trim');
		if ($this->form_validation->run() == TRUE) {
			$asset = $this->db->get_where('assets', array('name' => $this->input->post('item_name')))->result_array();
			if (empty($asset)) {
				if ($this->input->post('quantity') > 1) {
					$quantity = $this->input->post('quantity');
					for ($i = 0; $i < $quantity; $i++) {
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
						$this->db->insert('sub_items', $data);
					}
				} else {
					$data = array(
						'item_type' => $this->input->post('item_category'),
						'item_id' => $this->input->post('item_name'),
						'name' => $this->input->post('subitem_name'),
						'description' => $this->input->post('item_[description]'),
						'action_date'		  => date("Y-m-d H:i:s"),
						'action_by_user_type'		  => 1,
						'action_by_user'		  => $this->session->userdata('adminid')
					);
					$this->db->insert('sub_items', $data);
				}
				echo json_encode(array('response' => true, 'message' => 'Sub Item Added Successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
				exit;
			}
			if (!empty($asset)) {
				if ($asset[0]['action_status'] == 0) {
					if ($this->input->post('quantity') > 1) {
						$quantity = $this->input->post('quantity');
						for ($i = 0; $i < $quantity; $i++) {
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
							$this->db->insert('sub_items', $data);
							$ref_id = $this->db->insert_id('');
							$subAssetsData = array(
								'subitem_id' => $ref_id,
								'equipment_warranty' => 1,
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
							$this->db->insert('sub_assets', $subAssetsData);
						}
					} else {
						$data = array(
							'item_type' => $this->input->post('item_category'),
							'item_id' => $this->input->post('item_name'),
							'name' => $this->input->post('subitem_name'),
							'description' => $this->input->post('item_[description]'),
							'action_date'		  => date("Y-m-d H:i:s"),
							'action_by_user_type'		  => 1,
							'action_by_user'		  => $this->session->userdata('adminid')
						);
						$this->db->insert('sub_items', $data);
						$ref_id = $this->db->insert_id('');

						$subAssetsData = array(
							'subitem_id' => $ref_id,
							'equipment_warranty' => 1,
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
						$this->db->insert('sub_assets', $subAssetsData);
					}
				}
				if ($asset[0]['action_status'] != 0) {
					if ($this->input->post('quantity') > 1) {
						$quantity = $this->input->post('quantity');
						for ($i = 0; $i < $quantity; $i++) {
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
							$this->db->insert('sub_items', $data);
							$subitem_id = $this->db->insert_id();

							$subAssetsData = array(
								'subitem_id' => $subitem_id,
								'equipment_warranty' => 0,
								'action_status' => 3,
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
							$this->db->insert('sub_assets', $subAssetsData);
							$subAssetId = $this->db->insert_id();
							$installed = $this->db->get_where('installed_inventory', array('asset_id' => $asset[0]['id']))->result_array();
							foreach ($installed as $install) {
								$sub_installed_data = array(
									'item_id' => $this->input->post('item_name'),
									'subasset_id' => $subAssetId,
									'subitem_id' => $subitem_id,
									'asset_id' => $asset[0]['id'],
									'installed_id' => $install['id'],
									'serial_no' => $this->input->post('comp_serial'),
									'model_no' => $this->input->post('comp_model'),
									'manufacturer' => $this->input->post('manufacturer'),
									'supplier' => $this->input->post('supplier'),
									'cost' => $this->input->post('subasset_price'),
									'purchased_on' => $this->input->post('cmp_purchase_date'),
									'warranty_type' => $this->input->post('warranty_type'),
									'warranty_duration' => $this->input->post('warranty_duration'),
									'site' => $install['site'],
									'location' => $install['location'],
									'comments' => $this->input->post('item_[description]'),
									'transaction_type' => 3,
									'action_date' => date("Y-m-d H:i:s"),
									'action_by_user_type' => 1,
									'action_by_user' => $this->session->userdata('adminid')
								);
								$this->db->insert('installed_subitems', $sub_installed_data);
								$subInstallId = $this->db->insert_id();

								$asset_transaction_data = array(
									'asset_id' => $asset[0]['id'],
									'installed_id' => $install['id'],
									'item_id' => $install['name'],
									'subitem_id' => $subitem_id,
									'is_sub_item' => 1,
									'serial_no' => $this->input->post('comp_serial'),
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
								$this->db->insert('asset_transaction', $asset_transaction_data);
							}
						}
					} else {
						$data = array(
							'item_type' => $this->input->post('item_category'),
							'item_id' => $this->input->post('item_name'),
							'name' => $this->input->post('subitem_name'),
							'description' => $this->input->post('item_[description]'),
							'action_date' => date("Y-m-d H:i:s"),
							'action_by_user_type' => 1,
							'action_by_user' => $this->session->userdata('adminid')
						);
						$this->db->insert('sub_items', $data);
						$subitem_id = $this->db->insert_id();

						$subAssetsData = array(
							'subitem_id' => $subitem_id,
							'equipment_warranty' => 0,
							'action_status' => 3,
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
						$this->db->insert('sub_assets', $subAssetsData);
						$subAssetId = $this->db->insert_id();

						$installed = $this->db->get_where('installed_inventory', array('asset_id' => $asset[0]['id']))->result_array();
						foreach ($installed as $install) {
							$sub_installed_data = array(
								'item_id' => $this->input->post('item_name'),
								'subasset_id' => $subAssetId,
								'subitem_id' => $subitem_id,
								'asset_id' => $asset[0]['id'],
								'installed_id' => $install['id'],
								'serial_no' => $this->input->post('comp_serial'),
								'model_no' => $this->input->post('comp_model'),
								'manufacturer' => $this->input->post('manufacturer'),
								'supplier' => $this->input->post('supplier'),
								'cost' => $this->input->post('subasset_price'),
								'purchased_on' => $this->input->post('cmp_purchase_date'),
								'warranty_type' => $this->input->post('warranty_type'),
								'warranty_duration' => $this->input->post('warranty_duration'),
								'site' => $install['site'],
								'location' => $install['location'],
								'comments' => $this->input->post('item_[description]'),
								'transaction_type' => 3,
								'action_date' => date("Y-m-d H:i:s"),
								'action_by_user_type' => 1,
								'action_by_user' => $this->session->userdata('adminid')
							);
							$this->db->insert('installed_subitems', $sub_installed_data);
							$subInstallId = $this->db->insert_id();

							$asset_transaction_data = array(
								'asset_id' => $asset[0]['id'],
								'installed_id' => $install['id'],
								'item_id' => $install['name'],
								'subitem_id' => $subitem_id,
								'is_sub_item' => 1,
								'serial_no' => $this->input->post('comp_serial'),
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
							$this->db->insert('asset_transaction', $asset_transaction_data);
						}
					}
				}
				echo json_encode(array('response' => true, 'message' => 'Sub Item Added Successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
				exit;
			}
		} else {
			echo json_encode(array('response' => TRUE, 'message' => validation_errors()));
			exit;
		}
	}

	public function subitems_edit($para1 = '')
	{
		if (!$para1) {
			echo '<div class="alert alert-dismissible alert-danger">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>OOPS!</strong> Invalid Request
				</div>';
			exit;
		}
		$this->page_data['subitems'] = $this->db->get_where('sub_items', array('id' => $para1))->result_array();
		$this->load->view('back/inventory/edit_subitems', $this->page_data);
	}

	public function edit_subitem_do($subitem_id = '')
	{
		if (!$subitem_id) {
			echo json_encode(array('response' => TRUE, 'message' => 'Invalid Request'));
			exit;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('subitem_name', ' SubItem Name', 'required|trim');
		$this->form_validation->set_rules('item_category', ' ITEM Category', 'required|trim');
		$this->form_validation->set_rules('subitem_[description]', ' ITEM Description', 'required|trim');
		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'item_type' => $this->input->post('item_category'),
				'item_id' => $this->input->post('item_name'),
				'name' => $this->input->post('subitem_name'),
				'description' => $this->input->post('subitem_[description]'),
				'action_date' => time(),
				'action_by_user_type' => 1,
				'action_by_user' => $this->session->userdata('adminid')
			);
			$this->db->where('id', $subitem_id);
			$this->db->update('sub_items', $data);
			echo json_encode(array('response' => true, 'message' => 'Sub Item updated successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page/'));
			exit;
		} else {
			echo json_encode(array('response' => TRUE, 'message' => validation_errors()));
			exit;
		}
	}

	public function items_have_subitems($para1 = '')
	{
		$items = $this->db->get_where('items', array('item_type' => $para1, 'have_sub_items' => 1))->result_array();
		if ($items) {
			$data = array('items' => $items);
			echo json_encode($data);
		} else {
			echo json_encode("No Item exist of This type.");
		}
	}

	public function item_installed_or_not($para1 = '')
	{
		$items = $this->db->get_where('assets', array('name' => $para1, 'have_sub_assets' => 1))->result_array();
		if (isset($items)) {
			foreach ($items as $row) {
				if ($row['action_status'] != 0) {
					$data = 1;
					echo json_encode($data);
				}
				if ($row['action_status'] == 0) {
					$data = 0;
					echo json_encode($data);
				}
			}
		} else {
			$data = 0;
			echo json_encode($data);
		}
	}
	/** Subitems area END */

	/** Site area START */
	public function sites($para1 = '', $para2 = '', $para3 = '')
	{
		if (!$this->session->userdata('adminid')) {
			return redirect('admin/login');
		}
		if ($para1 == 'list') {
			$this->page_data['sites'] = $this->Inventory_model->getsites();
			$this->load->view('back/inventory/display_sites', $this->page_data);
		} elseif ($para1 == 'delete') {
			$this->db->where('site', $para2);
			$this->db->delete('locations');
			$this->db->where('site', $para2);
			$this->db->delete('installed_inventory');
			$this->db->where('site', $para2);
			$this->db->delete('installed_subitems');
			$this->db->where('site', $para2);
			$this->db->delete('assets');
			$this->db->where('site', $para2);
			$this->db->delete('sub_assets');
			$this->db->where('site', $para2);
			$this->db->delete('asset_transaction');
			$this->db->where('id', $para2);
			$this->db->delete('sites');
			echo json_encode(array('response' => true, 'message' => 'Deleted successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page/'));
			exit;
		} elseif ($para1 == 'site_publish_set') {
			$article = $para2;
			if ($para3 == 'true') {
				$data['status'] = '1';
			} else {
				$data['status'] = '0';
			}
			$this->db->where('id', $article);
			$this->db->update('sites', $data);

			echo $para3;
		} else {
			$this->page_data['page'] = 'sites';
			$this->load->view('back/inventory/first_page', $this->page_data);
		}
	}

	public function site_edit($para1 = '')
	{
		if (!$para1) {
			echo '<div class="alert alert-dismissible alert-danger">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>OOPS!</strong> Invalid Request
				</div>';
			exit;
		}
		$this->page_data['site'] = $this->db->get_where('sites', array('id' => $para1))->result_array();
		$this->load->view('back/inventory/edit_sites', $this->page_data);
	}

	public function edit_site_do($site_id = '')
	{
		if (!$site_id) {
			echo json_encode(array('response' => TRUE, 'message' => 'Invalid Request'));
			exit;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('site_name', ' Site Name', 'required|trim');

		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'name' => $this->input->post('site_name')
			);
			$this->db->where('id', $site_id);
			$this->db->update('sites', $data);
			// $site_id = $this->db->insert_id();

			$locationNames = $this->input->post('site_location_name');
			$locationIds = $this->input->post('site_location_id');
			$counter = 0;

			foreach ($locationIds as $id) {
				$dataForLocations = array(
					'location' => $locationNames[$counter],
				);
				$counter++;
				$this->db->where('id', $id);
				$this->db->update('locations', $dataForLocations);
			}
			echo json_encode(array('response' => true, 'message' => 'Site Updated Successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
			exit;
		} else {
			echo json_encode(array('response' => TRUE, 'message' => validation_errors()));
			exit;
		}
	}

	public function add_site()
	{
		if (!$this->session->userdata('adminid')) {
			return redirect('admin/login');
		}
		$this->load->view('back/inventory/add_sites');
	}

	public function add_site_do()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('site_name', ' Site Name', 'required|trim');
		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'name' => $this->input->post('site_name'),
				'site_type' => $this->input->post('site_type'),
				'route' => $this->input->post('route')
			);
			$this->db->insert('sites', $data);
			$site_id = $this->db->insert_id();
			$general = $this->input->post('general[]');
			if (isset($general)) {
				foreach ($general as $gnrl) {
					$gdata = array(
						'site' => $site_id,
						'location_type' => 1,
						'location' => $gnrl,
					);
					$this->db->insert('locations', $gdata);
				}
			}
			$north = $this->input->post('north[]');
			if (isset($north)) {
				foreach ($north as $nrth) {
					$ndata = array(
						'site' => $site_id,
						'location_type' => 2,
						'location' => $nrth,
					);
					$this->db->insert('locations', $ndata);
				}
			}
			$northBooths = $this->input->post('northBooths[]');
			if (isset($northBooths)) {
				foreach ($northBooths as $nb) {
					$nBData = array(
						'site' => $site_id,
						'location_type' => 2,
						'inside_booth' => 1,
						'location' => $nb,
					);
					$this->db->insert('locations', $nBData);
				}
			}
			$south = $this->input->post('south[]');
			if (isset($south)) {
				foreach ($south as $sth) {
					$sdata = array(
						'site' => $site_id,
						'location_type' => 3,
						'location' => $sth,
					);
					$this->db->insert('locations', $sdata);
				}
			}
			$southBooths = $this->input->post('southBooths[]');
			if (isset($southBooths)) {
				foreach ($southBooths as $sthBth) {
					$sBData = array(
						'site' => $site_id,
						'location_type' => 3,
						'inside_booth' => 1,
						'location' => $sthBth,
					);
					$this->db->insert('locations', $sBData);
				}
			}
			echo json_encode(array('response' => true, 'message' => 'Site Added Successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
			exit;
		} else {
			echo json_encode(array('response' => TRUE, 'message' => validation_errors()));
			exit;
		}
	}
	/** Site area END*/
	/** Suppliers area START */
	public function suppliers($para1 = '', $para2 = '', $para3 = '')
	{
		if (!$this->session->userdata('adminid')) {
			return redirect('admin/login');
		}
		if ($para1 == 'list') {
			$this->page_data['suppliers'] = $this->Inventory_model->get_suppliers();
			$this->load->view('back/inventory/display_suppliers', $this->page_data);
		} elseif ($para1 == 'delete') {
			$this->db->where('id', $para2);
			$this->db->delete('suppliers');
			echo json_encode(array('response' => true, 'message' => 'Deleted successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page/'));
			exit;
		} elseif ($para1 == 'supplier_publish_set') {
			$article = $para2;
			if ($para3 == 'true') {
				$data['status'] = '1';
			} else {
				$data['status'] = '0';
			}
			$this->db->where('id', $article);
			$this->db->update('suppliers', $data);
			echo $para3;
		} else {
			$this->page_data['page'] = 'suppliers';
			$this->load->view('back/inventory/first_page', $this->page_data);
		}
	}
	public function add_supplier()
	{
		if (!$this->session->userdata('adminid')) {
			return redirect('admin/login');
		}
		$this->load->view('back/inventory/add_suppliers');
	}

	public function add_supplier_do()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('supplier_name', ' Supplier Name', 'required|trim');
		$this->form_validation->set_rules('focal_name', ' Focal Person Name', 'required|trim');
		$this->form_validation->set_rules('contact', ' Focal Person Contact', 'required|trim');
		$this->form_validation->set_rules('address_[description]', ' Supplier"s" Address', 'required|trim');
		$this->form_validation->set_rules('supplier_[description]', ' Supplier"s" Description', 'required|trim');
		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'name' => $this->input->post('supplier_name'),
				'description' => $this->input->post('supplier_[description]'),
				'focal_person' => $this->input->post('focal_name'),
				'contact' => $this->input->post('contact'),
				'address' => $this->input->post('address_[description]')
			);
			$this->db->insert('suppliers', $data);
			echo json_encode(array('response' => true, 'message' => 'Supplier Added Successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
			exit;
		} else {
			echo json_encode(array('response' => TRUE, 'message' => validation_errors()));
			exit;
		}
	}

	public function supplier_edit($para1 = '')
	{
		if (!$para1) {
			echo '<div class="alert alert-dismissible alert-danger">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>OOPS!</strong> Invalid Request
				</div>';
			exit;
		}
		$this->page_data['supplier'] = $this->db->get_where('suppliers', array('id' => $para1))->result_array();
		$this->load->view('back/inventory/edit_supplier', $this->page_data);
	}

	public function edit_supplier_do($supplier_id = '')
	{
		if (!$supplier_id) {
			echo json_encode(array('response' => TRUE, 'message' => 'Invalid Request'));
			exit;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('supplier_name', ' Supplier Name', 'required|trim');
		$this->form_validation->set_rules('focal_name', ' Focal Person Name', 'required|trim');
		$this->form_validation->set_rules('contact', ' Focal Person Contact', 'required|trim');
		$this->form_validation->set_rules('address_[description]', ' Supplier"s" Address', 'required|trim');
		$this->form_validation->set_rules('supplier_[description]', ' Supplier"s" Description', 'required|trim');

		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'name' => $this->input->post('supplier_name'),
				'description' => $this->input->post('supplier_[description]'),
				'focal_person' => $this->input->post('focal_name'),
				'contact' => $this->input->post('contact'),
				'address' => $this->input->post('address_[description]')
			);
			$this->db->where('id', $supplier_id);
			$this->db->update('suppliers', $data);
			echo json_encode(array('response' => true, 'message' => 'Supplier updated successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page/'));
			exit;
		} else {
			echo json_encode(array('response' => TRUE, 'message' => validation_errors()));
			exit;
		}
	}
	/** Suppliers area END */

	/** T.S.P area START */
	public function tsp($para1 = '', $para2 = '', $para3 = '')
	{
		if (!$this->session->userdata('adminid')) {
			return redirect('admin/login');
		}
		if ($para1 == 'list') {
			$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
			$this->load->view('back/inventory/display_tsps', $this->page_data);
		} elseif ($para1 == 'delete') {
			$this->db->where('id', $para2);
			$this->db->delete('tsp');
			echo json_encode(array('response' => true, 'message' => 'Deleted successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page/'));
			exit;
		} elseif ($para1 == 'tsp_publish_set') {
			$article = $para2;
			if ($para3 == 'true') {
				$data['status'] = '1';
			} else {
				$data['status'] = '0';
			}
			$this->db->where('id', $article);
			$this->db->update('t_s_p', $data);
			echo $para3;
		} else {
			$this->page_data['page'] = 'tsp';
			$this->load->view('back/inventory/first_page', $this->page_data);
		}
	}
	public function add_tsps()
	{
		if (!$this->session->userdata('adminid')) {
			return redirect('admin/login');
		}
		$this->load->view('back/inventory/add_tsps');
	}

	public function add_tsps_do()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', ' TSP Name', 'required|trim');
		$this->form_validation->set_rules('contract_name', ' Contract Name', 'required|trim');
		$this->form_validation->set_rules('employee_name', ' Employee Name', 'required|trim');
		$this->form_validation->set_rules('employee_contact', ' Emplyee Contact', 'required|trim');
		$this->form_validation->set_rules('tsp_address', ' TSP Address', 'required|trim');
		$this->form_validation->set_rules('employee_designation', ' Employee Designation', 'trim');
		$this->form_validation->set_rules('commencement_date', ' Contract Commencement Date', 'trim');
		$this->form_validation->set_rules('expiry_date', ' Contract Expiry Date', 'trim');
		if ($this->form_validation->run() == TRUE) {
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
			$this->db->insert('tsp', $data);
			echo json_encode(array('response' => true, 'message' => 'TSP Added Successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
			exit;
		} else {
			echo json_encode(array('response' => TRUE, 'message' => validation_errors()));
			exit;
		}
	}

	public function tsp_edit($para1 = '')
	{
		if (!$para1) {
			echo '<div class="alert alert-dismissible alert-danger">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  			<strong>OOPS!</strong> Invalid Request
				</div>';
			exit;
		}
		$this->page_data['tsp'] = $this->db->get_where('tsp', array('id' => $para1))->result_array();
		$this->load->view('back/inventory/edit_tsp', $this->page_data);
	}

	public function edit_tsp_do($tsp_id = '')
	{
		if (!$tsp_id) {
			echo json_encode(array('response' => TRUE, 'message' => 'Invalid Request'));
			exit;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', ' TSP Name', 'required|trim');
		$this->form_validation->set_rules('contract_name', ' Contract Name', 'required|trim');
		$this->form_validation->set_rules('employee_name', ' Employee Name', 'required|trim');
		$this->form_validation->set_rules('employee_contact', ' Emplyee Contact', 'required|trim');
		$this->form_validation->set_rules('tsp_address', ' TSP Address', 'required|trim');
		$this->form_validation->set_rules('employee_designation', ' Employee Designation', 'trim');
		$this->form_validation->set_rules('commencement_date', ' Contract Commencement Date', 'trim');
		$this->form_validation->set_rules('expiry_date', ' Contract Expiry Date', 'trim');

		if ($this->form_validation->run() == TRUE) {
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
			$this->db->where('id', $tsp_id);
			$this->db->update('tsp', $data);
			echo json_encode(array('response' => true, 'message' => 'Supplier updated successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page/'));
			exit;
		} else {
			echo json_encode(array('response' => TRUE, 'message' => validation_errors()));
			exit;
		}
	}
	/** T.S.P area END */

	/** Manufacturer area START */
	public function manufacturers($para1 = '', $para2 = '', $para3 = '')
	{
		if (!$this->session->userdata('adminid')) {
			return redirect('admin/login');
		}
		if ($para1 == 'list') {
			$this->page_data['manufacturers'] = $this->Inventory_model->get_manufacturers();
			$this->load->view('back/inventory/display_manufacturers', $this->page_data);
		} elseif ($para1 == 'delete') {
			$this->db->where('id', $para2);
			$this->db->delete('manufacturers');
			echo json_encode(array('response' => true, 'message' => 'Deleted successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page/'));
			exit;
		} elseif ($para1 == 'manufacturers_publish_set') {
			$article = $para2;
			if ($para3 == 'true') {
				$data['status'] = '1';
			} else {
				$data['status'] = '0';
			}
			$this->db->where('id', $article);
			$this->db->update('manufacturers', $data);
			echo $para3;
		} else {
			$this->page_data['page'] = 'manufacturer';
			$this->load->view('back/inventory/first_page', $this->page_data);
		}
	}
	public function add_manufacturer()
	{
		if (!$this->session->userdata('adminid')) {
			return redirect('admin/login');
		}
		$this->load->view('back/inventory/add_manufacturer');
	}


	public function add_manufacturer_do()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('manufacturer_name', ' Manufacturer Name', 'required|trim');
		$this->form_validation->set_rules('manufacturer_[description]', ' Manufacturer Description', 'required|trim');
		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'name' => $this->input->post('manufacturer_name'),
				'description' => $this->input->post('manufacturer_[description]')
			);
			$this->db->insert('manufacturers', $data);
			echo json_encode(array('response' => true, 'message' => 'Manufacturer Added Successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
			exit;
		} else {
			echo json_encode(array('response' => TRUE, 'message' => validation_errors()));
			exit;
		}
	}

	public function manufacturer_edit($para1 = '')
	{
		if (!$para1) {
			echo '<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>OOPS!</strong> Invalid Request
				</div>';
			exit;
		}
		$this->page_data['manufacturer'] = $this->db->get_where('manufacturers', array('id' => $para1))->result_array();
		$this->load->view('back/inventory/edit_manufacturer', $this->page_data);
	}

	public function edit_manufacturer_do($manufacturer_id = '')
	{
		if (!$manufacturer_id) {
			echo json_encode(array('response' => TRUE, 'message' => 'Invalid Request'));
			exit;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('manufacturer_name', ' Manufacturer Name', 'required|trim');
		$this->form_validation->set_rules('manufacturer_[description]', ' Manufacturer Description', 'required|trim');

		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'name' => $this->input->post('manufacturer_name'),
				'description' => $this->input->post('manufacturer_[description]')
			);
			$this->db->where('id', $manufacturer_id);
			$this->db->update('manufacturers', $data);
			echo json_encode(array('response' => true, 'message' => 'Manufacturer updated successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page/'));
			exit;
		} else {
			echo json_encode(array('response' => TRUE, 'message' => validation_errors()));
			exit;
		}
	}
	/** Manufacturer area END */


	/** Installed Subitems Area Start */
	public function installed_sub_inventory($para1 = '', $para2 = '', $para3 = '')
	{
		if (!$this->session->userdata('adminid')) {
			return redirect('admin/login');
		}
		if ($para1 == 'list') {
			$this->page_data['installs'] = $this->Inventory_model->get_installed_subitems();
			$this->page_data['sites'] = $this->Inventory_model->getsites();
			$this->page_data['items'] = $this->Inventory_model->get_Items();
			$this->page_data['asset_transactions'] = $this->Inventory_model->get_asset_transactions();
			$this->load->view('back/inventory/display_installed_subitems', $this->page_data);
		} elseif ($para1 == 'delete') {
			$this->db->where('alert_type', 1);
			$this->db->where('ref_id', $para2);
			$this->db->delete('notifications');
			$this->db->where('asset_id', $para2);
			$this->db->delete('asset_transaction');
			$this->db->where('id', $para2);
			$this->db->delete('assets');
			echo json_encode(array('response' => true, 'message' => 'Deleted successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page/'));
			exit;
		} elseif ($para1 == 'assets_publish_set') {
			$article = $para2;
			if ($para3 == 'true') {
				$data['status'] = '1';
			} else {
				$data['status'] = '0';
			}
			$this->db->where('id', $article);
			$this->db->update('assets', $data);

			echo $para3;
		} else {
			$this->page_data['page'] = 'assets';
			$this->load->view('back/inventory/first_page', $this->page_data);
		}
	}

	public function selected_sub_install($para1 = '', $para2 = '', $para3 = '')
	{
		$this->page_data['page'] = 'selected_installed';
		if (!$this->session->userdata('adminid')) {
			return redirect('admin/login');
		}
		if ($para1 == 'list') {
			$this->page_data['selected_installed'] = $this->db->select('*')->where('id', $para2)->order_by('id', 'desc')->limit(1)->get('installed_inventory')->result_array();
			$this->page_data['selected_installed_transaction'] = $this->db->select('*')->where('installed_id', $para2)->order_by('id', 'desc')->limit(1)->get('asset_transaction')->result_array();

			$this->page_data['selected_assets'] = $this->db->get_where('assets', array('id' => $this->page_data['selected_installed'][0]['asset_id']))->result_array();
			$this->page_data['install_transactions'] = $this->db->select('*')->where('installed_id', $para2)->order_by('id', 'desc')->get('asset_transaction')->result_array();
			$this->load->view('back/inventory/display_selected_installs', $this->page_data);
		}
	}
	/** Installed Subitems Area End */

	/** Installed Area Start */
	public function installed_inventory($para1 = '', $para2 = '', $para3 = '')
	{
		if (!$this->session->userdata('adminid')) {
			return redirect('admin/login');
		}
		if ($para1 == 'list') {
			$this->page_data['installs'] = $this->Inventory_model->get_installed();
			$sites = $this->Inventory_model->getsites();
			$items = $this->Inventory_model->get_Items();
			$locations = $this->Inventory_model->get_locations();
			$siteNames = array();
			$itemNames = array();
			$locationNames = array();
			foreach ($this->page_data['installs'] as $install) {
				foreach ($sites as $names) {
					if ($names['id'] == $install['site']) {
						$siteNames[] = $names['name'];
						break;
					}
				}
				foreach ($items as $item) {
					if ($item['id'] == $install['name']) {
						$itemNames[] = $item['name'];
						break;
					}
				}
				foreach ($locations as $location) {
					if ($location['id'] == $install['location']) {
						$locationNames[] = $location['location'];
						break;
					}
				}
				if ($install['have_sub_items'] == 1) {
					if ($install['transaction_type'] == 11) {
						$faulty_comp = $this->db->get_where('sub_items', array('id' => $install['subitem_id']))->result_array();
						$this->page_data['faulty_comp_name'] = $faulty_comp[0]['name'];
						$this->page_data['faulty_component'] = $faulty_comp;
					}
					if ($install['transaction_type'] == 12) {
						$compName = $this->db->get_where('sub_items', array('id' => $install[0]['subitem_id'],))->result_array();
						$this->page_data['faulty_comp_name'] = $compName[0]['name'];
						$this->page_data['faulty_component'] = $compName;
					}
					if ($install['transaction_type'] == 13) {
						$faulty_comp = $this->db->get_where('sub_items', array('id' => $install['subitem_id']))->result_array();
						$this->page_data['faulty_comp_name'] = $faulty_comp[0]['name'];
						$this->page_data['faulty_component'] = $faulty_comp;
					}
					if ($install['transaction_type'] == 14) {
						$faulty_comp = $this->db->get_where('sub_items', array('id' => $install['subitem_id']))->result_array();
						$this->page_data['faulty_comp_name'] = $faulty_comp[0]['name'];
						$this->page_data['faulty_component'] = $faulty_comp;
					}
					if ($install['transaction_type'] == 15) {
						$faulty_comp = $this->db->get_where('sub_items', array('id' => $install['subitem_id']))->result_array();
						$this->page_data['faulty_comp_name'] = $faulty_comp[0]['name'];
						$this->page_data['faulty_component'] = $faulty_comp;
					}
				}
			}
			$this->page_data['sites'] = $sites;
			$this->page_data['items'] = $items;
			$this->page_data['siteNames'] = $siteNames;
			$this->page_data['itemNames'] = $itemNames;
			$this->page_data['locationNames'] = $locationNames;
			$this->page_data['asset_transactions'] = $this->Inventory_model->get_asset_transactions();
			$this->load->view('back/inventory/display_installed', $this->page_data);
		} elseif ($para1 == 'delete') {
			$this->db->where('alert_type', 1);
			$this->db->where('ref_id', $para2);
			$this->db->delete('notifications');
			$this->db->where('identification_no', $para2);
			$this->db->delete('asset_transaction');
			$installed_subitems = $this->db->select('*')->where('identification_no', $para2)->get('installed_subitems')->result_array();
			$this->db->where('installed_id', $installed_subitems[0]['installed_id']);
			$this->db->delete('installed_subitems');
			$this->db->where('identification_no', $para2);
			$this->db->delete('faulty_equipment_list');
			$this->db->where('identification_no', $para2);
			$this->db->delete('installed_inventory');
			echo json_encode(array('response' => true, 'message' => 'Deleted successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page/'));
			exit;
		} elseif ($para1 == 'assets_publish_set') {
			$article = $para2;
			if ($para3 == 'true') {
				$data['status'] = '1';
			} else {
				$data['status'] = '0';
			}
			$this->db->where('id', $article);
			$this->db->update('assets', $data);

			echo $para3;
		} else {
			$this->page_data['page'] = 'assets';
			$this->load->view('back/inventory/first_page', $this->page_data);
		}
	}

	public function selected_install($para1 = '', $para2 = '', $para3 = '')
	{
		$this->page_data['page'] = 'selected_installed';
		if (!$this->session->userdata('adminid')) {
			return redirect('admin/login');
		}
		if ($para1 == 'list') {
			$this->page_data['selected_installed'] = $this->db->select('*')->where('id', $para2)->order_by('id', 'desc')->limit(1)->get('installed_inventory')->result_array();
			$this->page_data['selected_installed_transaction'] = $this->db->select('*')->where('installed_id', $para2)->order_by('id', 'desc')->limit(1)->get('asset_transaction')->result_array();
			$this->page_data['selected_assets'] = $this->db->get_where('assets', array('id' => $this->page_data['selected_installed'][0]['asset_id']))->result_array();
			$this->page_data['installed_components'] = $this->db->get_where('installed_subitems', array('installed_id' => $this->page_data['selected_installed'][0]['id']))->result_array();
			$installed_transactions = $this->db->select('*')->where('installed_id', $para2)->order_by('id', 'desc')->get('asset_transaction')->result_array();
			$this->page_data['install_transactions'] = $installed_transactions;
			$this->load->view('back/inventory/display_selected_installs', $this->page_data);
		}
		if ($para1 == 'listfromdashboard') {
			$this->page_data['selected_installed'] = $this->db->select('*')->where('identification_no', $para2)->order_by('id', 'desc')->limit(1)->get('installed_inventory')->result_array();
			$this->page_data['selected_installed_transaction'] = $this->db->select('*')->where('identification_no', $para2)->order_by('id', 'desc')->limit(1)->get('asset_transaction')->result_array();
			$this->page_data['selected_assets'] = $this->db->get_where('assets', array('id' => $this->page_data['selected_installed'][0]['asset_id']))->result_array();
			$this->page_data['installed_components'] = $this->db->get_where('installed_subitems', array('installed_id' => $this->page_data['selected_installed'][0]['id']))->result_array();
			$installed_transactions = $this->db->select('*')->where('identification_no', $para2)->order_by('id', 'desc')->get('asset_transaction')->result_array();
			$this->page_data['install_transactions'] = $installed_transactions;
			$this->load->view('back/inventory/display_selected_installs', $this->page_data);
		}
	}
	/** Installed Area End */

	/** Assets area START */
	public function assets($para1 = '', $para2 = '', $para3 = '')
	{
		if (!$this->session->userdata('adminid')) {
			return redirect('admin/login');
		}
		if ($para1 == 'list') {
			$this->page_data['assets'] = $this->Inventory_model->get_assets();
			foreach ($this->page_data['assets'] as $asset) {
				if ($asset['action_status'] == 11) {
					$installed_comp = $this->db->get_where('installed_subitems', array('asset_id' => $asset['id'], 'transaction_type' => 11))->result_array();
					$faulty_comp = $this->db->get_where('sub_items', array('id' => $installed_comp[0]['subitem_id']))->result_array();
					$this->page_data['faulty_comp_name'] = $faulty_comp[0]['name'];
				}
				if ($asset['action_status'] == 12) {
					$installed_comp = $this->db->get_where('installed_subitems', array('asset_id' => $asset['id'], 'transaction_type' => 12))->result_array();
					$faulty_comp = $this->db->get_where('sub_items', array('id' => $installed_comp[0]['subitem_id']))->result_array();
					$this->page_data['faulty_comp_name'] = $faulty_comp[0]['name'];
				}
				if ($asset['action_status'] == 13) {
					$installed_comp = $this->db->get_where('installed_subitems', array('asset_id' => $asset['id'], 'transaction_type' => 13))->result_array();
					$faulty_comp = $this->db->get_where('sub_items', array('id' => $installed_comp[0]['subitem_id']))->result_array();
					$this->page_data['faulty_comp_name'] = $faulty_comp[0]['name'];
				}
				if ($asset['action_status'] == 14) {
					$installed_comp = $this->db->get_where('installed_subitems', array('asset_id' => $asset['id'], 'transaction_type' => 14))->result_array();
					$faulty_comp = $this->db->get_where('sub_items', array('id' => $installed_comp[0]['subitem_id']))->result_array();
					$this->page_data['faulty_comp_name'] = $faulty_comp[0]['name'];
				}
				if ($asset['action_status'] == 15) {
					$installed_comp = $this->db->get_where('installed_subitems', array('asset_id' => $asset['id'], 'transaction_type' => 15))->result_array();
					$faulty_comp = $this->db->get_where('sub_items', array('id' => $installed_comp[0]['subitem_id']))->result_array();
					$this->page_data['faulty_comp_name'] = $faulty_comp[0]['name'];
				}
			}
			$this->page_data['sites'] = $this->Inventory_model->getsites();
			$this->page_data['items'] = $this->Inventory_model->get_Items();
			$this->page_data['asset_transactions'] = $this->Inventory_model->get_asset_transactions();
			$this->load->view('back/inventory/display_assets', $this->page_data);
		} elseif ($para1 == 'delete') {
			$asset = $this->db->get_where('assets', array('id' => $para2))->result_array();
			$deletingAssets = $this->db->get_where('assets', array('set_no' => $asset[0]['set_no']))->result_array();
			foreach ($deletingAssets as $row) {
				$this->db->where('alert_type', 1);
				$this->db->where('ref_id', $row['id']);
				$this->db->delete('notifications');
				$this->db->where('asset_id', $row['id']);
				$this->db->delete('asset_transaction');
				$this->db->where('asset_id', $row['id']);
				$this->db->delete('installed_subitems');
				$this->db->where('asset_id', $row['id']);
				$this->db->delete('sub_assets');
				$this->db->where('asset_id', $row['id']);
				$this->db->delete('faulty_equipment_list');
				$this->db->where('asset_id', $row['id']);
				$this->db->delete('installed_inventory');
				$this->db->where('id', $row['id']);
				$this->db->delete('assets');
			}
			echo json_encode(array('response' => true, 'message' => 'Deleted successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page/'));
			exit;
		} elseif ($para1 == 'assets_publish_set') {
			$article = $para2;
			if ($para3 == 'true') {
				$data['status'] = '1';
			} else {
				$data['status'] = '0';
			}
			$this->db->where('id', $article);
			$this->db->update('assets', $data);
			echo $para3;
		} else {
			$this->page_data['page'] = 'assets';
			$this->load->view('back/inventory/first_page', $this->page_data);
		}
	}

	public function expand($para1 = '', $para2 = '', $para3 = '')
	{
		// echo $para1; exit;
		// $this->page_data['page'] = 'expand';
		if (!$this->session->userdata('adminid')) {
			return redirect('admin/login');
		}
		$sites = array();
		$siteNames = array();
		$actionStatus = array();
		$expanded_data = array();
		$expanded_data['expanded_data'] = $this->Inventory_model->getExpandedAsset($para1);
		//  echo "<pre>"; print_r($expanded_data); exit; 
		foreach ($expanded_data['expanded_data'] as $expanded) {
			$sites[] = $this->db->get_where('sites', array('id' => $expanded['site']))->result_array();
			if ($expanded['action_status'] == "0") {
				$actionStatus[] = "Brand New";
			} elseif ($expanded['action_status'] == "1") {
				$actionStatus[] = "Checked Out";
			} elseif ($expanded['action_status'] == "2") {
				$actionStatus[] = "Checked In";
			} elseif ($expanded['action_status'] == "3") {
				$actionStatus[] = "Installed";
			} elseif ($expanded['action_status'] == "4") {
				$actionStatus[] = "Repairing Mode";
			} elseif ($expanded['action_status'] == "5") {
				$actionStatus[] = "Repaired";
			} elseif ($expanded['action_status'] == "6") {
				$actionStatus[] = "Retired";
			} elseif ($expanded['action_status'] == "9") {
				$actionStatus[] = "Re Installed";
			} elseif ($expanded['action_status'] == "10") {
				$actionStatus[] = "Whole Equipment Faulty";
			} elseif ($expanded['action_status'] == "11") {
				$installed_comp = $this->db->get_where('installed_subitems', array('asset_id' => $expanded['id'], 'transaction_type' => 11))->result_array();
				$faulty_comp = $this->db->get_where('sub_items', array('id' => $installed_comp[0]['subitem_id']))->result_array();
				$actionStatus[] = $faulty_comp[0]['name'] . " Faulty";
			} elseif ($expanded['action_status'] == "12") {
				$installed_comp = $this->db->get_where('installed_subitems', array('asset_id' => $expanded['id'], 'transaction_type' => 12))->result_array();
				$faulty_comp = $this->db->get_where('sub_items', array('id' => $installed_comp[0]['subitem_id']))->result_array();
				$actionStatus[] = $faulty_comp[0]['name'] . " Replaced";
			} elseif ($expanded['action_status'] == "13") {
				$installed_comp = $this->db->get_where('installed_subitems', array('asset_id' => $expanded['id'], 'transaction_type' => 13))->result_array();
				$faulty_comp = $this->db->get_where('sub_items', array('id' => $installed_comp[0]['subitem_id']))->result_array();
				$this->page_data['faulty_comp_name'] = $faulty_comp[0]['name'];
				$actionStatus[] = $faulty_comp[0]['name'] . " Repairing Mode";
			} elseif ($expanded['action_status'] == "14") {
				$installed_comp = $this->db->get_where('installed_subitems', array('asset_id' => $expanded['id'], 'transaction_type' => 14))->result_array();
				$faulty_comp = $this->db->get_where('sub_items', array('id' => $installed_comp[0]['subitem_id']))->result_array();
				$actionStatus[] = $faulty_comp[0]['name'] . " Reinstalled";
			} elseif ($expanded['action_status'] == "15") {
				$installed_comp = $this->db->get_where('installed_subitems', array('asset_id' => $expanded['id'], 'transaction_type' => 15))->result_array();
				$faulty_comp = $this->db->get_where('sub_items', array('id' => $installed_comp[0]['subitem_id']))->result_array();
				$actionStatus[] = $faulty_comp[0]['name'] . " Retired";
			}
		}

		foreach ($sites as $plaza) {
			$siteNames[] = $plaza[0]['name'];
		}
		$expanded_data['action_status'] = $actionStatus;
		$expanded_data['sites'] = $siteNames;
		$dat = $this->db->get_where('items', array('id' => $expanded_data['expanded_data'][0]['name']))->result_array();
		$expanded_data['naam'] = $dat[0]['name'];
		$this->page_data['expanded_data'] = $expanded_data;
		//  echo "<pre>"; print_r($expanded_data); exit;
		$this->load->view('back/inventory/expanded_asset', $this->page_data);
		//  echo json_encode($expanded_data);
	}

	public function selected_asset($para1 = '', $para2 = '', $para3 = '')
	{
		$this->page_data['page'] = 'selected_assets';
		if (!$this->session->userdata('adminid')) {
			return redirect('admin/login');
		}
		if ($para1 == 'list') {
			$this->page_data['transactions'] = $this->db->select('*')->where('asset_id', $para2)->order_by('id', 'desc')->limit(2)->get('asset_transaction')->result_array();
			$this->page_data['selected_asset_transaction'] = $this->db->select('*')->where('asset_id', $para2)->order_by('id', 'desc')->limit(1)->get('asset_transaction')->result_array();
			$this->page_data['selected_assets'] = $this->db->get_where('assets', array('id' => $para2))->result_array();
			$this->load->view('back/inventory/display_selected_assets', $this->page_data);
		}
	}

	public function add_asset_components($para1 = '', $para2 = '', $para3 = '')
	{
		if (!$this->session->userdata('adminid')) {
			return redirect('admin/login');
		}
		$comps = $this->Inventory_model->item_has_subitems_or_not($para1);
		$total_comps = 0;
		foreach ($comps as $cmp) {
			$total_comps++;
		}
		$this->page_data['comps'] = $comps;
		$this->page_data['total_comps'] = $total_comps;
		$this->page_data['quantity'] = $para2;
		$this->load->view('back/inventory/add_asset_components', $this->page_data);
	}

	public function add_asset()
	{
		if (!$this->session->userdata('adminid')) {
			return redirect('admin/login');
		}
		$this->page_data['sites'] = $this->Inventory_model->getsites();
		$this->page_data['suppliers'] = $this->Inventory_model->get_suppliers();
		$this->page_data['items'] = $this->Inventory_model->get_Items();
		$this->page_data['manufacturers'] = $this->Inventory_model->get_manufacturers();
		$this->load->view('back/inventory/add_asset', $this->page_data);
	}

	public function SitesByType($para1 = '')
	{
		$sites = $this->Inventory_model->GetSitesByType($para1);
		echo json_encode($sites);
	}

	public function add_asset_do()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('item_type', 'Item Type', 'required|trim');
		$this->form_validation->set_rules('asset_name', ' Asset Name', 'required|trim');
		$this->form_validation->set_rules('product_model_no', ' Product Model Number', 'required|trim');
		$this->form_validation->set_rules('supplier_id', ' Supplier Name', 'required|trim');
		$this->form_validation->set_rules('equip_manufacturer', ' Manufacturer', 'required|trim');
		$this->form_validation->set_rules('asset_price', ' Product Price', 'required|trim');
		$this->form_validation->set_rules('site_id', ' Site', 'required|trim');
		$this->form_validation->set_rules('quantity', ' Quantity', 'required|trim');
		$this->form_validation->set_rules('purchase_date', ' Purchase Date', 'required|trim');
		$this->form_validation->set_rules('warranty_type', ' Warranty type', 'required|trim');
		if ($this->form_validation->run() == TRUE) {
			if ($this->session->userdata('adminid')) {
				$eSerialCounter = 0;
				$oldTabNumber = 1;
				$route = '';
				if ($this->session->userdata('role') == 3) {
					$route = 3;
				}
				if ($this->session->userdata('role') == 4) {
					$route = 4;
				}
				if ($this->session->userdata('role') == 1 || $this->session->userdata('role') == 2) {
					$route = 1;
				}
				$quantity = $this->input->post('quantity');
				$cost = $this->input->post('asset_price');
				$unit_cost = $cost / $quantity;
				$description = $this->db->get_where('items', array('id' => $this->input->post('asset_name')))->result_array();
				$data = array();
				$ref_id = array();
				if (!empty($this->input->post('equip_serial_no'))) {
					for ($qty = 0; $qty < $this->input->post('quantity'); $qty++) {
						$equipSerial = $this->input->post('equip_serial_no');
						$this->db->select_max('set_no');
						$query = $this->db->get('assets');  // Produces: SELECT MAX(set_no) as age FROM assets
						$setNO = $query->row()->set_no;
						if ($setNO == 0) {
							$setNO = 1;
						}

						$data = array(
							'item_type' => $this->input->post('item_type'),
							'name' => $this->input->post('asset_name'),
							'set_no' => $setNO + 1,
							'product_model_no' => $this->input->post('product_model_no'),
							'identification_no' => $this->Inventory_model->generate_id(),
							'serial_no' => $equipSerial[$eSerialCounter],
							'manufacturer' => $this->input->post('equip_manufacturer'),
							'mfg_date' => $this->input->post('mfg_date'),
							'cost_price' => $unit_cost,
							'supplier' => $this->input->post('supplier_id'),
							'route' => $route,
							'site' => $this->input->post('site_id'),
							'purchased_on' => $this->input->post('purchase_date'),
							'po_no' => $this->input->post('po_no'),
							'warranty_type' => $this->input->post('warranty_type'),
							'warranty_duration' => $this->input->post('warranty_duration'),
							'have_sub_assets' => 0,
							'asset_comment' => $this->input->post('asset_comment'),
							'user_type' => '1',
							'checkin_by' => $this->session->userdata('adminid'),
							'add_date' => time()
						);
						$this->db->insert('assets', $data);
						$ref_id[] = $this->db->insert_id();
						$eSerialCounter++;
					}
				}
				if (!empty($this->input->post('additional_data'))) {
					$this->db->select_max('set_no');
					$query = $this->db->get('assets');  // Produces: SELECT MAX(set_no) as age FROM assets
					$setNO = $query->row()->set_no;
					$setNO = $setNO + 1;
					$array = json_decode($this->input->post('additional_data'), true);
					foreach ($array as $arr) {
						if ($oldTabNumber == $arr['tabNumber']) {
							if ($setNO == 0) {
								$setNO = 1;
							}
							$data = array(
								'item_type' => $this->input->post('item_type'),
								'name' => $this->input->post('asset_name'),
								'set_no' => $setNO,
								'product_model_no' => $this->input->post('product_model_no'),
								'identification_no' => $this->Inventory_model->generate_id(),
								'serial_no' => $arr['equipmentSerial'],
								'manufacturer' => $this->input->post('equip_manufacturer'),
								'mfg_date' => $this->input->post('mfg_date'),
								'cost_price' => $unit_cost,
								'comp_cost' => $arr['componentCost'],
								'comp_manufacturer' => $arr['componentManufacturer'],
								'comp_mfg_date' => $arr['componentMfg'],
								'comp_model_no' => $arr['componentModel'],
								'comp_id' => $arr['componentId'],
								'comp_serial' => $arr['componentSerial'],
								'supplier' => $this->input->post('supplier_id'),
								'equip_or_comp' => 1,
								'route' => $route,
								'site' => $this->input->post('site_id'),
								'purchased_on' => $this->input->post('purchase_date'),
								'po_no' => $this->input->post('po_no'),
								'comp_warranty_type' => $arr['componentWT'],
								'comp_warranty_duration' => $arr['componentWD'],
								'warranty_type' => $this->input->post('warranty_type'),
								'warranty_duration' => $this->input->post('warranty_duration'),
								'user_type' => '1',
								'have_sub_assets' => 1,
								'asset_comment' => $this->input->post('asset_comment'),
								'checkin_by' => $this->session->userdata('adminid'),
								'add_date' => time()
							);
							$this->db->insert('assets', $data);
							$ref_id[] = $this->db->insert_id();
						}
						if ($oldTabNumber != $arr['tabNumber']) {
							$this->db->select_max('set_no');
							$query = $this->db->get('assets'); // Produces: SELECT MAX(set_no) as age FROM assets
							$setNO = $query->row()->set_no;
							$setNO = $setNO + 1;
							if ($setNO == 0) {
								$setNO = 1;
							}
							$data = array(
								'item_type' => $this->input->post('item_type'),
								'name' => $this->input->post('asset_name'),
								'set_no' => $setNO,
								'product_model_no' => $this->input->post('product_model_no'),
								'identification_no' => $this->Inventory_model->generate_id(),
								'serial_no' => $arr['equipmentSerial'],
								'manufacturer' => $this->input->post('equip_manufacturer'),
								'mfg_date' => $this->input->post('mfg_date'),
								'cost_price' => $unit_cost,
								'comp_cost' => $arr['componentCost'],
								'comp_manufacturer' => $arr['componentManufacturer'],
								'comp_mfg_date' => $arr['componentMfg'],
								'comp_model_no' => $arr['componentModel'],
								'comp_id' => $arr['componentId'],
								'comp_serial' => $arr['componentSerial'],
								'supplier' => $this->input->post('supplier_id'),
								'equip_or_comp' => 1,
								'route' => $route,
								'site' => $this->input->post('site_id'),
								'purchased_on' => $this->input->post('purchase_date'),
								'po_no' => $this->input->post('po_no'),
								'comp_warranty_type' => $arr['componentWT'],
								'comp_warranty_duration' => $arr['componentWD'],
								'warranty_type' => $this->input->post('warranty_type'),
								'warranty_duration' => $this->input->post('warranty_duration'),
								'have_sub_assets' => 1,
								'asset_comment' => $this->input->post('asset_comment'),
								'user_type' => '1',
								'checkin_by' => $this->session->userdata('adminid'),
								'add_date' => time()
							);
							$this->db->insert('assets', $data);
							$ref_id[] = $this->db->insert_id();
						}
						$oldTabNumber = $arr['tabNumber'];
					}
				}
				foreach ($ref_id as $id) {
					$supervisor = $this->db->get('tpsupervisor')->result_array();
					$counter = 0;
					foreach ($supervisor as $sp_id) {
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
				if ($this->input->post('quantity') > 1) {
					echo json_encode(array('response' => true, 'message' => 'Asset Stock Created Successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
					exit;
				}
				if ($this->input->post('quantity') == 1) {
					echo json_encode(array('response' => true, 'message' => 'Asset Created Successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
					exit;
				}
			}
		} else {
			echo json_encode(array('response' => TRUE, 'message' => validation_errors()));
			exit;
		}
	}

	public function asset_edit($para1 = '')
	{
		if (!$para1) {
			echo '<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>OOPS!</strong> Invalid Request</div>';
			exit;
		}
		$this->page_data['asset'] = $this->db->get_where('assets', array('id' => $para1))->result_array();
		$this->page_data['sites'] = $this->Inventory_model->getsites();
		$this->page_data['suppliers'] = $this->Inventory_model->get_suppliers();
		$this->page_data['items'] = $this->Inventory_model->get_Items();
		$this->page_data['manufacturers'] = $this->Inventory_model->get_manufacturers();
		$this->load->view('back/inventory/edit_asset', $this->page_data);
	}

	public function edit_asset_do($asset_id = '')
	{
		if (!$asset_id) {
			echo json_encode(array('response' => TRUE, 'message' => 'Invalid Request'));
			exit;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('item_type', 'Item Type', 'required|trim');
		$this->form_validation->set_rules('asset_name', ' Asset Name', 'required|trim');
		$this->form_validation->set_rules('product_model_no', ' Product Model Number', 'required|trim');
		$this->form_validation->set_rules('supplier_id', ' Supplier Name', 'required|trim');
		$this->form_validation->set_rules('manufacturer_id', ' Manufacturer Name', 'required|trim');
		$this->form_validation->set_rules('asset_price', ' Product Price', 'required|trim');
		$this->form_validation->set_rules('site_id', ' Site Name', 'required|trim');
		$this->form_validation->set_rules('purchase_on', ' Purchase Date', 'required|trim');
		$this->form_validation->set_rules('warranty_type', 'Warranty Type', 'required|trim');
		$this->form_validation->set_rules('warranty_duration', 'Warranty Duration', 'required|trim');
		if ($this->form_validation->run() == TRUE) {
			if ($this->session->userdata('adminid')) {
				$description = $this->db->get_where('items', array('id' => $this->input->post('asset_name')))->result_array();
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
				$this->db->where('id', $asset_id);
				$this->db->update('assets', $data);
				echo json_encode(array('response' => true, 'message' => 'Asset Created Successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
				exit;
			} elseif ($this->session->userdata('supervisor_id')) {
				$description = $this->db->get_where('items', array('description' => $this->input->post('asset_name')))->result_array();
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
				$this->db->where('id', $asset_id);
				$this->db->update('assets', $data);
				echo json_encode(array('response' => true, 'message' => 'Asset Created Successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
				exit;
			} elseif ($this->session->userdata('member_id')) {
				$description = $this->db->get_where('items', array('description' => $this->input->post('asset_name')))->result_array();
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
				$this->db->where('id', $asset_id);
				$this->db->update('assets', $data);
				echo json_encode(array('response' => true, 'message' => 'Asset Updated Successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
				exit;
			}
		} else {
			echo json_encode(array('response' => TRUE, 'message' => validation_errors()));
			exit;
		}
	}


	/** Asset Area End */

	/** action area start */

	public function action_on_asset($para1 = '', $para2 = '', $para3 = '')
	{
		if (!$this->session->userdata('adminid')) {
			return redirect('admin/login');
		}
		if ($para1 == 'checkin') {
			$this->page_data['checkins'] = explode(',', $_POST['asset']);
			$checkins = $this->page_data['checkins'];
			$data = array();
			foreach ($checkins as $checkin) {
				$data[] = $this->db->get_where('assets', array('id' => $checkin))->result_array();
			}
			$data2 = array();
			foreach ($data as $row) {
				if ($row[0]['action_status'] == '0') {
					echo "Brand New items cannot be Checked In.";
					exit;
				}
				if ($row[0]['action_status'] == '2') {
					echo "Some Selected items Already Checked in.";
					exit;
				}
				if ($row[0]['action_status'] == '3') {
					echo "Some Selected items Already Installed. You cannot Checkin them.";
					exit;
				}
				if ($row[0]['action_status'] == '4') {
					echo "Some Selected items are in repairing mode. You cannot Checkin them.";
					exit;
				}
				if ($row[0]['action_status'] == '5') {
					echo "Some Selected items are Repaired. You cannot Checkin them But you can Install them.";
					exit;
				}
				if ($row[0]['action_status'] == '6') {
					echo "Some Selected items are Retired. You cannot Checkin them.";
					exit;
				}
			}
			$data3 = array();
			foreach ($checkins as $checkin) {
				$checkin_names = $this->db->get_where('assets', array('id' => $checkin))->result_array();
				$this->db->select('assets.name AS temp_id,items.*');
				$this->db->from('assets');
				$this->db->join('items', 'assets.name = items.id');
				$this->db->where('assets.id', $checkin);
				$query = $this->db->get();
				$data3[] = $query->result_array();
				$this->page_data['data'] = $data3;
			}
			$this->page_data['data1'] = $data;
			$this->page_data['sites'] = $this->Inventory_model->getsites();
			$this->load->view('back/inventory/checkin', $this->page_data);
		} elseif ($para1 == 'checkin_do') {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('site_id', 'Site Name', 'required|trim');
			$this->form_validation->set_rules('checkin_comments', 'Comment for Checkin', 'required|trim');

			if ($this->form_validation->run() == TRUE) {
				if ($this->session->userdata('adminid')) {
					$description = $this->db->get_where('items', array('id' => $this->input->post('asset_name')))->result_array();
					$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
					$asset_ids = $this->page_data['assets_ids'];
					foreach ($asset_ids as $id) {
						$date = date("Y-m-d H:i:s");
						$data = array(
							'asset_id' => $id,
							'transaction_type' => "2",
							'site' => $this->input->post('site_id'),
							'action_date' => $date,
							'action_comments' => $this->input->post('checkin_comments'),
							'user_type' => "1",
							'added_by' => $this->session->userdata('adminid'),
						);
						$assets_data = array('checkout_to' => "", 'action_status' => '2', 'checkout_user_type' => "0", 'site' => $this->input->post('site_id'));
						$this->db->where('id', $id);
						$this->db->update('assets', $assets_data);
						$this->db->insert('asset_transaction', $data);
					}
					echo json_encode(array('response' => true, 'message' => 'Asset Checked In Successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
					exit;
				}
			}
		} elseif ($para1 == 'checkout') {
			$this->page_data['checkouts'] = explode(',', $_POST['asset']);

			$this->page_data['sites'] = $this->Inventory_model->getsites();
			$checkouts = $this->page_data['checkouts'];

			$data = array();
			foreach ($checkouts as $checkout) {
				$data[] = $this->db->get_where('assets', array('id' => $checkout))->result_array();
			}
			$data2 = array();
			foreach ($data as $row) {
				if ($row[0]['action_status'] == "1") {
					echo "Some Selected items already Checked out. Therefore you cannot Check out them again.";
					exit;
				}
				if ($row[0]['action_status'] == "4") {
					echo "Some Selected items in Repair Mode. Therefore you cannot Check Out them.";
					exit;
				}
				if ($row[0]['action_status'] == "5") {
					echo "Some Selected items are repaired. Therefore you cannot Check Out them but you can install them.";
					exit;
				}
				if ($row[0]['action_status'] == "6") {
					echo "Some Selected items are retired. Therefore you cannot perform any action on them.";
					exit;
				}
			}
			$data3 = array();
			foreach ($checkouts as $checkout) {
				$checkout_names = $this->db->get_where('assets', array('id' => $checkout))->result_array();
				$this->db->select('assets.name AS temp_id,items.*');
				$this->db->from('assets');
				$this->db->join('items', 'assets.name = items.id');
				$this->db->where('assets.id', $checkout);
				$query = $this->db->get();
				$data3[] = $query->result_array();
				$this->page_data['data'] = $data3;
			}
			$this->load->view('back/inventory/checkout', $this->page_data);
		} elseif ($para1 == 'checkout_do') {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('return_date', ' Return Date', 'trim');
			$this->form_validation->set_rules('issue_permanent', ' Return Infinite', 'trim');
			$this->form_validation->set_rules('user_role', 'User Role', 'required|trim');
			$this->form_validation->set_rules('person_contact', 'Person Contact No', 'required|trim');
			$this->form_validation->set_rules('role', ' Checkout To Name', 'required|trim');
			$this->form_validation->set_rules('checkout_site', ' Checkout Site Name', 'required|trim');
			$this->form_validation->set_rules('checkout_reason', 'Checkout Reason', 'required|trim');
			if ($this->form_validation->run() == TRUE) {
				if ($this->session->userdata('adminid')) {
					$description = $this->db->get_where('items', array('id' => $this->input->post('asset_name')))->result_array();
					$return_date = $this->input->post('return_date');
					$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
					$asset_ids = $this->page_data['assets_ids'];
					foreach ($asset_ids as $id) {
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
						$assets_data = array(
							'site' => $this->input->post('checkout_site'),
							'checkout_to' => $this->input->post('role'),
							'checkout_user_type' => $this->input->post('user_role'),
							'action_status' => '1'
						);

						$this->db->where('id', $id);
						$this->db->update('assets', $assets_data);
						$this->db->insert('asset_transaction', $data);
						/** Query to insert Action Noification in Table */
						$supervisors = $this->db->get('tpsupervisor')->result_array();
						foreach ($supervisors as $sp_id) {
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
					echo json_encode(array('response' => true, 'message' => 'Asset Checkedout Successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
					exit;
				}
			}
		} elseif ($para1 == 'install') {
			$this->page_data['installs'] = explode(',', $_POST['asset']);
			$installs = $this->page_data['installs'];
			$alreadyGivenSerialNo = array();
			foreach ($installs as $install) {
				$data = $this->db->get_where('assets', array('id' => $install))->result_array();
			}
			$alreadyGivenSerialNo = $this->db->get_where('assets', array('set_no' => $data[0]['set_no']))->result_array();
			$this->page_data['alreadyGivenSerialNo'] = $alreadyGivenSerialNo;
			$components = array();
			$data2 = array();
			foreach ($alreadyGivenSerialNo as $row) {
				if ($row['have_sub_assets'] == 1) {
					$data2[] = $this->db->get_where('sub_items', array('id' => $row['comp_id']))->result_array();
				}
				if ($row['action_status'] == "2") {
					echo "Checked In Items selected You must Check Out them first.";
					exit;
				}
				if ($row['action_status'] == "4") {
					echo "Repairing Mode Items selected You cannot install them.";
					exit;
				}
				if ($row['action_status'] == "6") {
					echo "Retired Items Selected. You cannot Install them.";
					exit;
				}
				$items = $this->Inventory_model->getItemsBySetNo($para1 = $row['set_no']);
			}
			$this->page_data['data2'] = $data2;

			$data3 = array();
			foreach ($installs as $install) {
				$installing_names = $this->db->get_where('assets', array('id' => $install))->result_array();
				$this->db->select('assets.name AS temp_id,items.*');
				$this->db->from('assets');
				$this->db->join('items', 'assets.name = items.id');
				$this->db->where('assets.id', $install);
				$query = $this->db->get();
				$data3[] = $query->result_array();
				$this->page_data['data'] = $data3;
			}
			$this->page_data['data1'] = $data;
			$this->page_data['sites'] = $this->db->get_where('sites', array('id' => $data[0]['site']))->result_array();
			$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
			$this->load->view('back/inventory/install', $this->page_data);
		} elseif ($para1 == 'install_do') {
			$locations = $this->input->post('location');
			if (empty($locations)) {
				echo json_encode(array('respose' => FALSE, 'message' => 'Please choose location'));
				exit;
			}
			$loc_Counter = 0;
			foreach ($locations as $location) {
				$loc_Counter++;
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('site_id', 'Site Name', 'required|trim');
			$this->form_validation->set_rules('repairing_company', 'Repairing Company', 'required|trim');
			$this->form_validation->set_rules('install_comments', 'Installing Comments', 'required|trim');
			if ($this->form_validation->run() == TRUE) {
				if ($this->session->userdata('adminid')) {
					if ($loc_Counter > 1) {
						echo "you cannot Install one Asset in diffrent locations at same time.";
					}
					//end of locations greater than 1
					if ($loc_Counter = 1) {
						$comp_serial = $this->input->post('comp_serial');
						$comp_model = $this->input->post('comp_model');

						if ($this->input->post('repairing_company') == "1") {
							$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
							$asset_ids = $this->page_data['assets_ids'];

							foreach ($asset_ids as $id) {
								$asset = $this->db->get_where('assets', array('id' => $id))->result_array();
								$date = date("Y-m-d H:i:s");

								$installing_data = array(
									'asset_id' => $id,
									'item_type' => $asset[0]['item_type'],
									'name' => $asset[0]['name'],
									'have_sub_items' => $asset[0]['have_sub_assets'],
									'transaction_type' => "3",
									'identification_no' => $asset[0]['identification_no'],
									'serial_no' => $this->input->post('equip_serial'),
									'route' => $asset[0]['route'],
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
								$this->db->insert('installed_inventory', $installing_data);
								$install_id = $this->db->insert_id('');

								if ($asset[0]['have_sub_assets'] == 1) {

									$assetComponents = $this->db->get_where('assets', array('set_no' => $asset[0]['set_no']))->result_array();
									$installing_cost = "Equipment Installing Cost" . $this->input->post('cost');
									$counter = 0;
									foreach ($assetComponents as $subasset) {
										$assets_data = array(
											'checkout_to' => "",
											'have_sub_assets' => $subasset['have_sub_assets'],
											'serial_no' => $comp_serial[$counter],
											'action_status' => '3',
											'checkout_user_type' => "",
											'site' => $this->input->post('site_id'),
											'add_date' => time(),
										);
										$this->db->where('id', $id);
										$this->db->update('assets', $assets_data);

										$installing_subitem_data = array(
											'asset_id' => $subasset['id'],
											'installed_id' => $install_id,
											'item_id' => $subasset['name'],
											'subitem_id' => $subasset['comp_id'],
											'serial_no' => $comp_serial[$counter],
											'identification_no' => $subasset['identification_no'],
											'model_no' => $comp_model[$counter],
											'transaction_type' => "3",
											'route' => $subasset['route'],
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

										$this->db->insert('installed_subitems', $installing_subitem_data);
										$sub_install_id = $this->db->insert_id('');

										$equipPurchaseCost = "Equipment Purchase CosT" . $asset[0]['cost_price'];
										$subAssetsData = array(
											'asset_id' => $subasset['id'],
											'installed_id' => $install_id,
											'item_id' => $subasset['name'],
											'subitem_id' => $subasset['comp_id'],
											'equipment_warranty' => $subasset['warranty_type'],
											'product_model_no' => $comp_model[$counter],
											'cost_price' => $equipPurchaseCost,
											'supplier' => $subasset['supplier'],
											'manufacturer' => $subasset['manufacturer'],
											'site' => $this->input->post('site_id'),
											'purchased_on' => $subasset['purchased_on'],
											'warranty_type' => $subasset['warranty_type'],
											'warranty_duration' => $subasset['warranty_duration'],
											'user_type' => '1',
											'user' => $this->session->userdata('adminid'),
											'action_date' => date("Y-m-d H:i:s")
										);
										$this->db->insert('sub_assets', $subAssetsData);
										$asset_transaction_data = array(
											'asset_id' => $subasset['id'],
											'installed_id' => $install_id,
											'item_id' => $subasset['name'],
											'subitem_id' => $subasset['comp_id'],
											'is_sub_item' => 1,
											'installed_subitem_id' => $sub_install_id,
											'serial_no' => $comp_serial[$counter],
											'identification_no' => $subasset['identification_no'],
											'transaction_type' => "3",
											'route' => $subasset['route'],
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

										$this->db->insert('asset_transaction', $asset_transaction_data);
										$counter++;
									}
								}

								if ($asset[0]['have_sub_assets'] == 0) {
									$assets_data = array(
										'checkout_to' => "",
										'have_sub_assets' => $asset[0]['have_sub_assets'],
										'serial_no' => $this->input->post('equip_serial'),
										'action_status' => '3',
										'checkout_user_type' => "",
										'site' => $this->input->post('site_id'),
										'add_date' => time(),
									);
									$this->db->where('id', $id);
									$this->db->update('assets', $assets_data);

									$data = array(
										'asset_id' => $asset_ids[0],
										'installed_id' => $install_id,
										'item_id' => $asset[0]['name'],
										'have_sub_items' => $asset[0]['have_sub_assets'],
										'serial_no' => $this->input->post('equip_serial'),
										'identification_no' => $asset[0]['identification_no'],
										'transaction_type' => "3",
										'route' => $asset[0]['route'],
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
									$this->db->insert('asset_transaction', $data);
								}
							}
							echo json_encode(array('response' => true, 'message' => 'Installation Successfull.', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
							exit;
						}
						if ($this->input->post('repairing_company') == "2") {
							$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
							$asset_ids = $this->page_data['assets_ids'];
							foreach ($asset_ids as $id) {

								$asset = $this->db->get_where('assets', array('id' => $id))->result_array();
								$date = date("Y-m-d H:i:s");

								$installing_data = array(
									'asset_id' => $id,
									'item_type' => $asset[0]['item_type'],
									'name' => $asset[0]['name'],
									'have_sub_items' => $asset[0]['have_sub_assets'],
									'transaction_type' => "3",
									'identification_no' => $asset[0]['identification_no'],
									'serial_no' => $this->input->post('equip_serial'),
									'route' => $asset[0]['route'],
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
								$this->db->insert('installed_inventory', $installing_data);
								$install_id = $this->db->insert_id('');

								if ($asset[0]['have_sub_assets'] == 1) {
									$assetComponents = $this->db->get_where('assets', array('set_no' => $asset[0]['set_no']))->result_array();

									$installing_cost = "Equipment Installing Cost" . $this->input->post('cost');
									$counter = 0;
									foreach ($assetComponents as $subasset) {

										$installing_subitem_data = array(
											'asset_id' => $subasset['id'],
											'installed_id' => $install_id,
											'item_id' => $subasset['name'],
											'subitem_id' => $subasset['comp_id'],
											'serial_no' => $comp_serial[$counter],
											'identification_no' => $subasset['identification_no'],
											'model_no' => $comp_model[$counter],
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
										$this->db->insert('installed_subitems', $installing_subitem_data);
										$sub_install_id = $this->db->insert_id('');

										$asset_transaction_data = array(
											'asset_id' => $subasset['id'],
											'installed_id' => $install_id,
											'item_id' => $subasset['name'],
											'subitem_id' => $subasset['comp_id'],
											'is_sub_item' => 1,
											'installed_subitem_id' => $sub_install_id,
											'serial_no' => $comp_serial[$counter],
											'identification_no' => $subasset['identification_no'],
											'transaction_type' => "3",
											'site' => $this->input->post('site_id'),
											'location' => $locations[0],
											'user_type' => "1",
											'added_by' => $this->session->userdata('adminid'),
											'action_date' => $date,
											'organisation_type' => 2,
											'organisation' => $this->input->post('outer_company_name'),
											'organisation_address' => $this->input->post('outer_company_address'),
											'repairing_person_type' => 0,
											'person' => $this->input->post('outsider_name'),
											'person_contact' => $this->input->post('outsider_contact'),
											'cost' => $installing_cost,
											'action_comments' => $this->input->post('install_comments'),
										);
										$this->db->insert('asset_transaction', $asset_transaction_data);

										$equipPurchaseCost = "Equipment Purchase Cost" . $asset[0]['cost_price'];
										$subAssetsData = array(
											'asset_id' => $subasset['id'],
											'installed_id' => $install_id,
											'item_id' => $subasset['name'],
											'subitem_id' => $subasset['comp_id'],
											'equipment_warranty' => 1,
											'product_model_no' => $comp_model[$counter],
											'cost_price' => $equipPurchaseCost,
											'supplier' => $subasset['supplier'],
											'manufacturer' => $subasset['manufacturer'],
											'site' => $this->input->post('site_id'),
											'purchased_on' => $subasset['purchased_on'],
											'warranty_type' => $subasset['warranty_type'],
											'warranty_duration' => $subasset['warranty_duration'],
											'user_type' => '1',
											'user' => $this->session->userdata('adminid'),
											'action_date' => date("Y-m-d H:i:s")
										);
										$this->db->insert('sub_assets', $subAssetsData);
										$assets_data = array(
											'checkout_to' => "",
											'have_sub_assets' => $subasset['have_sub_assets'],
											'action_status' => '3',
											'serial_no' => $comp_serial[$counter],
											'checkout_user_type' => "",
											'site' => $this->input->post('site_id'),
											'add_date' => time(),
										);
										$this->db->where('id', $subasset['id']);
										$this->db->update('assets', $assets_data);
										$counter++;
									}
								}
								if ($asset[0]['have_sub_assets'] == 0) {
									$assets_data = array(
										'checkout_to' => "",
										'have_sub_assets' => $asset[0]['have_sub_assets'],
										'action_status' => '3',
										'serial_no' => $this->input->post('equip_serial'),
										'checkout_user_type' => "",
										'site' => $this->input->post('site_id'),
										'add_date' => time(),
									);
									$this->db->where('id', $id);
									$this->db->update('assets', $assets_data);

									$data = array(
										'asset_id' => $id,
										'installed_id' => $install_id,
										'item_id' => $asset[0]['name'],
										'have_sub_items' => $asset[0]['have_sub_assets'],
										'transaction_type' => "3",
										'route' => $asset[0]['route'],
										'site' => $this->input->post('site_id'),
										'serial_no' => $this->input->post('equip_serial'),
										'identification_no' => $asset[0]['identification_no'],
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
									$this->db->insert('asset_transaction', $data);
								}
							}
							echo json_encode(array('response' => true, 'message' => 'Installation Successfull.', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
							exit;
						}
					}
				}
			}
		} elseif ($para1 == 'faulty') {
			$this->page_data['repairs'] = explode(',', $_POST['asset']);
			$repairs = $this->page_data['repairs'];
			$data = array();
			foreach ($repairs as $repair) {
				$data[] = $this->db->get_where('installed_inventory', array('id' => $repair))->result_array();
			}
			$data2 = array();
			foreach ($data as $row) {
				if ($row[0]['transaction_type'] == "10") {
					echo "Selected item already faulty.";
					exit;
				}
				if ($row[0]['transaction_type'] == "4") {
					echo "Selected item already in repairing mode.";
					exit;
				}
				if ($row[0]['transaction_type'] == "5") {
					echo "Selected item's repairing recently completed.";
					exit;
				}
				if ($row[0]['transaction_type'] == "6") {
					echo "Retire item cannot be repair.";
					exit;
				}
			}
			$data3 = array();
			foreach ($repairs as $repair) {
				$installing_names = $this->db->get_where('installed_inventory', array('id' => $repair))->result_array();
				$this->db->select('installed_inventory.name AS temp_id,items.*');
				$this->db->from('installed_inventory');
				$this->db->join('items', 'installed_inventory.name = items.id');
				$this->db->where('installed_inventory.id', $repair);
				$query = $this->db->get();
				$data3[] = $query->result_array();
				$this->page_data['data'] = $data3;
			}

			foreach ($repairs as $repair) {
				$installed_location = $this->db->get_where('installed_inventory', array('id' => $repair))->result_array();
				$locationNames = $this->db->get_where('locations', array('id' => $installed_location[0]['location']))->result_array();
				$siteNames = $this->db->get_where('sites', array('id' => $locationNames[0]['site']))->result_array();
				$this->page_data['sites'] = $siteNames;
				$this->page_data['locations'] = $locationNames;
			}
			$this->page_data['data1'] = $data;
			$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
			$this->load->view('back/inventory/faulty', $this->page_data);
		} elseif ($para1 == 'faulty_do') {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('omc_name', 'OMC Name', 'required|trim');
			$this->form_validation->set_rules('faulty_date', 'Faulty Date ', 'required|trim');

			if ($this->form_validation->run() == TRUE) {
				if ($this->session->userdata('adminid')) {
					$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
					$install_ids = $this->page_data['assets_ids'];

					$counter = 0;
					foreach ($install_ids as $id) {
						$repairing_start = $this->db->get_where('installed_inventory', array('id' => $id))->result_array();
						$date = date("Y-m-d H:i:s");

						$asset_data = array(
							'action_status' => "10",
							'user_type' => "1",
							'checkin_by' => $this->session->userdata('adminid'),
							'add_date' => time(),
						);
						$this->db->where('id', $repairing_start[0]['asset_id']);
						$this->db->update('assets', $asset_data);

						if ($repairing_start[0]['have_sub_items'] == 1) {
							$subitems = $this->db->get_where('installed_subitems', array('installed_id' => $repairing_start[0]['id']))->result_array();
							$overAllEstCost = "Overall Estimate Cost of Equipment," . $this->input->post('estimated_cost');
							foreach ($subitems as $subasset) {
								$installing_data = array(
									'transaction_type' => "10",
									'subitem_id' => $subasset['subitem_id'],
									'company_type' => '',
									'company_name' => '',
									'company_address' => '',
									'company_person_type' => '',
									'person_name' => '',
									'person_contact' => '',
									'faulty_time_omc' => $this->input->post('omc_name'),
									'faulty_date' => $this->input->post('faulty_date'),
									'est_cost' => $this->input->post('estimated_cost'),
									'user_type' => "1",
									'user_name' => $this->session->userdata('adminid'),
									'action_date' => $date,
								);
								$this->db->where('id', $id);
								$this->db->update('installed_inventory', $installing_data);

								$installing_subitem_data = array(
									'transaction_type' => 10,
									'company_type' => '',
									'company_name' => '',
									'company_address' => '',
									'company_person_type' => '',
									'person_name' => '',
									'person_contact' => '',
									'faulty_time_omc' => $this->input->post('omc_name'),
									'faulty_date' => $this->input->post('faulty_date'),
									'est_cost' => $overAllEstCost,
									'comments' => $this->input->post('faulty_reason'),
									'action_by_user_type' => "1",
									'action_by_user' => $this->session->userdata('adminid'),
									'action_date' => $date,
								);
								$this->db->where('id', $subasset['id']);
								$this->db->update('installed_subitems', $installing_subitem_data);

								$faulty_data = array(
									'asset_id' => $subasset['asset_id'],
									'installed_id' => $id,
									'subitem_id' => $subasset['subitem_id'],
									'serial_no' => $subasset['serial_no'],
									'identification_no' => $subasset['identification_no'],
									'item_id' => $subasset['item_id'],
									'is_sub_item' => 1,
									'installed_subitem_id' => $subasset['id'],
									'route' => $subasset['route'],
									'site' => $subasset['site'],
									'location' => $subasset['location'],
									'faulty_time_omc' => $this->input->post('omc_name'),
									'faulty_date' => $this->input->post('faulty_date'),
									'est_cost' => $overAllEstCost,
									'comments' => $this->input->post('faulty_reason'),
								);
								$this->db->insert('faulty_equipment_list', $faulty_data);

								$asset_transaction_data = array(
									'installed_id' => $id,
									'item_id' => $subasset['item_id'],
									'subitem_id' => $subasset['subitem_id'],
									'serial_no' => $subasset['serial_no'],
									'identification_no' => $subasset['identification_no'],
									'is_sub_item' => 1,
									'installed_subitem_id' => $subasset['id'],
									'asset_id' => $subasset['asset_id'],
									'transaction_type' => "10",
									'route' => $subasset['route'],
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
								$this->db->insert('asset_transaction', $asset_transaction_data);
							}
						}
						if ($repairing_start[0]['have_sub_items'] == 0) {

							$installing_data = array(
								'transaction_type' => "10",
								'company_type' => '',
								'company_name' => '',
								'company_address' => '',
								'company_person_type' => '',
								'person_name' => '',
								'person_contact' => '',
								'faulty_time_omc' => $this->input->post('omc_name'),
								'faulty_date' => $this->input->post('faulty_date'),
								'est_cost' => $this->input->post('estimated_cost'),
								'user_type' => "1",
								'user_name' => $this->session->userdata('adminid'),
								'action_date' => $date,
							);
							$this->db->where('id', $id);
							$this->db->update('installed_inventory', $installing_data);

							$faulty_data = array(
								'asset_id' => $repairing_start[0]['asset_id'],
								'installed_id' => $id,
								'item_id' => $repairing_start[0]['name'],
								'serial_no' => $repairing_start[0]['serial_no'],
								'identification_no' => $repairing_start[0]['identification_no'],
								'is_sub_item' => $repairing_start[0]['have_sub_items'],
								'route' => $repairing_start[0]['route'],
								'site' => $repairing_start[0]['site'],
								'location' => $repairing_start[0]['location'],
								'faulty_time_omc' => $this->input->post('omc_name'),
								'faulty_date' => $this->input->post('faulty_date'),
								'est_cost' => $this->input->post('estimated_cost'),
								'comments' => $this->input->post('faulty_reason'),
							);

							$this->db->insert('faulty_equipment_list', $faulty_data);
							$qur = $this->db->last_query();

							$data = array(
								'installed_id' => $id,
								'item_id' => $repairing_start[0]['name'],
								'serial_no' => $repairing_start[0]['serial_no'],
								'identification_no' => $repairing_start[0]['identification_no'],
								'asset_id' => $repairing_start[0]['asset_id'],
								'have_sub_items' => $repairing_start[0]['have_sub_items'],
								'transaction_type' => "10",
								'route' => $repairing_start[0]['route'],
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
							$this->db->insert('asset_transaction', $data);
						}
					}
					echo json_encode(array('response' => true, 'message' => 'Faulty Done.', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
					exit;
				}
			}
		}
		/** Component Faulty Start */
		elseif ($para1 == 'component_faulty') {
			$this->page_data['repairs'] = explode(',', $_POST['asset']);
			$components = $this->page_data['repairs'];
			$data = array();
			foreach ($components as $component) {
				$data = $this->db->get_where('installed_subitems', array('id' => $component))->result_array();
			}
			$data2 = array();
			foreach ($data as $row) {
				if ($row['transaction_type'] == "10") {
					echo "Selected Component already faulty.";
					exit;
				}
				if ($row['transaction_type'] == "11") {
					echo "Selected Component already faulty.";
					exit;
				}
				if ($row['transaction_type'] == "4") {
					echo "Selected Component already in repairing mode.";
					exit;
				}
				if ($row['transaction_type'] == "13") {
					echo "Repairing Mode Component cannot be Faulty.";
					exit;
				}
				if ($row['transaction_type'] == "15") {
					echo "Retired Component cannot be repair.";
					exit;
				}
			}

			foreach ($data as $record) {
				$items = $this->db->get_where('items', array('id' => $record['item_id']))->result_array();
				$this->page_data['equipment_name'] = $items[0]['name'];
				$this->page_data['equipment_id'] = $items[0]['id'];
			}

			$data3 = array();
			foreach ($components as $component) {
				$installed_comp = $this->db->get_where('installed_subitems', array('id' => $component))->result_array();
				$this->db->select('installed_subitems.subitem_id AS temp_id,sub_items.*');
				$this->db->from('installed_subitems');
				$this->db->join('sub_items', 'installed_subitems.subitem_id = sub_items.id');
				$this->db->where('installed_subitems.id', $component);
				$query = $this->db->get();
				$data3 = $query->result_array();
				$this->page_data['data'] = $data3;
			}
			//  echo "<pre>"; print_r($data3); exit;

			foreach ($components as $component) {
				$installed_location = $this->db->get_where('installed_subitems', array('id' => $component))->result_array();
				$locationNames = $this->db->get_where('locations', array('id' => $installed_location[0]['location']))->result_array();
				$siteNames = $this->db->get_where('sites', array('id' => $locationNames[0]['site']))->result_array();
				$this->page_data['sites'] = $siteNames;
				$this->page_data['locations'] = $locationNames;
			}

			$this->page_data['data1'] = $data;
			$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
			$this->load->view('back/inventory/component_faulty', $this->page_data);
		}
		/** component faulty End */

		/** component faulty do Start */
		elseif ($para1 == 'component_faulty_do') {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('omc_name', 'OMC Name', 'required|trim');
			$this->form_validation->set_rules('faulty_date', 'Faulty Date ', 'required|trim');

			if ($this->form_validation->run() == TRUE) {
				if ($this->session->userdata('adminid')) {
					$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
					$component_id = $this->page_data['assets_ids'];
					$counter = 0;
					$subitems = $this->db->get_where('installed_subitems', array('id' => $component_id[0]))->result_array();

					foreach ($subitems as $subasset) {

						$date = date("Y-m-d H:i:s");

						$asset_data = array(
							'action_status' => "11",
							'user_type' => "1",
							'checkin_by' => $this->session->userdata('adminid'),
							'add_date' => time(),
						);
						$this->db->where('id', $subasset['asset_id']);
						$this->db->update('assets', $asset_data);

						$installing_data = array(
							'transaction_type' => "11",
							'subitem_id' => $subasset['subitem_id'],
							'company_type' => '',
							'company_name' => '',
							'company_address' => '',
							'company_person_type' => '',
							'person_name' => '',
							'person_contact' => '',
							'faulty_time_omc' => $this->input->post('omc_name'),
							'faulty_date' => $this->input->post('faulty_date'),
							'est_cost' => $this->input->post('estimated_cost'),
							'user_type' => "1",
							'user_name' => $this->session->userdata('adminid'),
							'action_date' => $date,
						);
						$this->db->where('id', $subasset['installed_id']);
						$this->db->update('installed_inventory', $installing_data);

						$faulty_subitem_data = array(
							'transaction_type' => 11,
							'company_type' => '',
							'company_name' => '',
							'company_address' => '',
							'company_person_type' => '',
							'person_name' => '',
							'person_contact' => '',
							'faulty_time_omc' => $this->input->post('omc_name'),
							'faulty_date' => $this->input->post('faulty_date'),
							'est_cost' => $this->input->post('estimated_cost'),
							'comments' => $this->input->post('faulty_reason'),
							'action_by_user_type' => "1",
							'action_by_user' => $this->session->userdata('adminid'),
							'action_date' => $date,
						);
						$this->db->where('id', $subasset['id']);
						$this->db->update('installed_subitems', $faulty_subitem_data);

						$faulty_data = array(
							'asset_id' => $subasset['asset_id'],
							'installed_id' => $subasset['installed_id'],
							'subitem_id' => $subasset['subitem_id'],
							'serial_no' => $subasset['serial_no'],
							'identification_no' => $subasset['identification_no'],
							'item_id' => $subasset['item_id'],
							'is_sub_item' => 1,
							'installed_subitem_id' => $subasset['id'],
							'route' => $subasset['route'],
							'site' => $subasset['site'],
							'location' => $subasset['location'],
							'faulty_time_omc' => $this->input->post('omc_name'),
							'faulty_date' => $this->input->post('faulty_date'),
							'est_cost' => $this->input->post('estimated_cost'),
							'comments' => $this->input->post('faulty_reason'),
						);
						$this->db->insert('faulty_equipment_list', $faulty_data);

						$asset_transaction_data = array(
							'installed_id' => $subasset['installed_id'],
							'item_id' => $subasset['item_id'],
							'subitem_id' => $subasset['subitem_id'],
							'serial_no' => $subasset['serial_no'],
							'identification_no' => $subasset['identification_no'],
							'is_sub_item' => 1,
							'installed_subitem_id' => $subasset['id'],
							'asset_id' => $subasset['asset_id'],
							'transaction_type' => "11",
							'route' => $subasset['route'],
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
						$this->db->insert('asset_transaction', $asset_transaction_data);
					}
					echo json_encode(array('response' => true, 'message' => 'Faulty Done.', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
					exit;
				}
			}
		}
		/** component faulty do End */

		/** component replace Start */
		elseif ($para1 == 'component_replace') {
			$this->page_data['repairs'] = explode(',', $_POST['asset']);
			$components = $this->page_data['repairs'];
			$data = array();
			foreach ($components as $component) {
				$data = $this->db->get_where('installed_subitems', array('id' => $component))->result_array();
			}
			$data2 = array();
			foreach ($data as $row) {
				if ($row['transaction_type'] == "4") {
					echo "Selected Component already in repairing mode.";
					exit;
				}
				if ($row['transaction_type'] == "6") {
					echo "Retired Component cannot be replaced.";
					exit;
				}
				if ($row['transaction_type'] == "15") {
					echo "Retired Component cannot be replaced.";
					exit;
				}
			}
			foreach ($data as $record) {
				$items = $this->db->get_where('items', array('id' => $record['item_id']))->result_array();
				$this->page_data['equipment_name'] = $items[0]['name'];
				$this->page_data['equipment_id'] = $items[0]['id'];
			}

			$data3 = array();
			foreach ($components as $component) {
				$installed_comp = $this->db->get_where('installed_subitems', array('id' => $component))->result_array();
				$this->db->select('installed_subitems.subitem_id AS temp_id,sub_items.*');
				$this->db->from('installed_subitems');
				$this->db->join('sub_items', 'installed_subitems.subitem_id = sub_items.id');
				$this->db->where('installed_subitems.id', $component);
				$query = $this->db->get();
				$data3 = $query->result_array();
				$this->page_data['data'] = $data3;
			}

			foreach ($components as $component) {
				$installed_location = $this->db->get_where('installed_subitems', array('id' => $component))->result_array();
				$locationNames = $this->db->get_where('locations', array('id' => $installed_location[0]['location']))->result_array();
				$siteNames = $this->db->get_where('sites', array('id' => $locationNames[0]['site']))->result_array();
				$this->page_data['sites'] = $siteNames;
				$this->page_data['locations'] = $locationNames;
			}
			$this->page_data['data1'] = $data;
			$this->page_data['tsps'] = $this->Inventory_model->get_tsps();

			foreach ($data as $rec) {
				$subasset = $this->db->get_where('assets', array('id' => $rec['asset_id']))->result_array();
			}

			foreach ($subasset as $row) {
				$startDate = $row['purchased_on'];
				$s_date = date("Y-m-d", strtotime($startDate));
				if ($row['warranty_type'] == '1') {
					if ($row['warranty_duration'] == '3 month') {
						$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +3 month");

						$e_date = date("Y-m-d", $date);
						$date1 = new DateTime($s_date);
						$date2 = new DateTime($e_date);
						$date3 = date("Y-m-d", time());
						$end_date = new DateTime($date3);

						$interval = $date1->diff($date2);
						$interval2 = $date1->diff($end_date);

						if ($interval2->days < $interval->days) {
							$itemName = $this->db->get_where('items', array('id' => $row['name']))->result_array();
							$subitemName = $this->db->get_where('sub_items', array('id' => $row['comp_id']))->result_array();
							if ($row['equip_or_comp'] == 0) {
								$this->page_data['equip_replace_warranty'] = "equip replace warranty <br>";
								$this->page_data['replace_equipname'] = $itemName[0]['name'] . "'s" . $subitemName[0]['name'] . " warranty";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['name'];
								$this->page_data['equip_mfg_id'] = $row['manufacturer'];
								$this->page_data['modelNo'] = $row['product_model_no'];
								$manufacturer = $this->db->get_where('manufacturers', array('id' => $row['manufacturer']))->result_array();
								$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
								$this->page_data['equip_supplier_id'] = $row['supplier'];
								$supplier = $this->db->get_where('suppliers', array('id' => $row['supplier']))->result_array();
								$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
							if ($row['equip_or_comp'] == 1) {
								$this->page_data['comp_replace_warranty'] = "comp replace warranty <br>";
								$this->page_data['replace_compname'] = $itemName[0]['name'] . "'s" . $subitemName[0]['name'] . " warranty";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['comp_id'];
								$this->page_data['modelNo'] = $row['comp_model_no'];
								$this->page_data['comp_mfg'] = $row['comp_manufacturer'];
								$this->page_data['comp_supplier'] = $row['supplier'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
						} else {
							$this->page_data['replace_warranty_finished'] = "Replace Warranty Finished <br>";
						}
					}

					if ($row['warranty_duration'] == '6 month') {
						$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +6 month");
						$e_date = date("Y-m-d", $date);
						$date1 = new DateTime($s_date);
						$date2 = new DateTime($e_date);
						$date3 = date("Y-m-d", time());
						$end_date = new DateTime($date3);

						$interval = $date1->diff($date2);
						$interval2 = $date1->diff($end_date);

						if ($interval2->days < $interval->days) {
							$itemName = $this->db->get_where('items', array('id' => $row['name']))->result_array();
							$subitemName = $this->db->get_where('sub_items', array('id' => $row['comp_id']))->result_array();
							if ($row['equip_or_comp'] == 0) {
								$this->page_data['equip_replace_warranty'] = "equip replace warranty <br>";
								$this->page_data['replace_equipname'] = $itemName[0]['name'] . "'s" . $subitemName[0]['name'] . " warranty <br>";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['name'];
								$this->page_data['modelNo'] = $row['product_model_no'];
								$this->page_data['equip_mfg_id'] = $row['manufacturer'];
								$manufacturer = $this->db->get_where('manufacturers', array('id' => $row['manufacturer']))->result_array();
								$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
								$this->page_data['equip_supplier_id'] = $row['supplier'];
								$supplier = $this->db->get_where('suppliers', array('id' => $row['supplier']))->result_array();
								$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
							if ($row['equip_or_comp'] == 1) {
								$this->page_data['comp_replace_warranty'] = "comp replace warranty <br>";
								$this->page_data['replace_compname'] = $itemName[0]['name'] . "'s" . $subitemName[0]['name'] . " warranty <br>";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['comp_id'];
								$this->page_data['modelNo'] = $row['comp_model_no'];
								$this->page_data['comp_mfg'] = $row['comp_manufacturer'];
								$this->page_data['comp_supplier'] = $row['supplier'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
						} else {
							$this->page_data['replace_warranty_finished'] = "Replace Warranty Finished <br>";
						}
					}

					if ($row['warranty_duration'] == '9 month') {
						$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +9 month");
						$e_date = date("Y-m-d", $date);
						$date1 = new DateTime($s_date);
						$date2 = new DateTime($e_date);
						$date3 = date("Y-m-d", time());
						$end_date = new DateTime($date3);

						$interval = $date1->diff($date2);
						$interval2 = $date1->diff($end_date);

						if ($interval2->days < $interval->days) {
							$itemName = $this->db->get_where('items', array('id' => $row['name']))->result_array();
							$subitemName = $this->db->get_where('sub_items', array('id' => $row['comp_id']))->result_array();
							if ($row['equip_or_comp'] == 0) {
								$this->page_data['equip_replace_warranty'] = "equip replace warranty <br>";
								$this->page_data['replace_equipname'] = $itemName[0]['name'] . "'s" . $subitemName[0]['name'] . " warranty <br> ";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['name'];
								$this->page_data['modelNo'] = $row['product_model_no'];
								$this->page_data['equip_mfg_id'] = $row['manufacturer'];
								$manufacturer = $this->db->get_where('manufacturers', array('id' => $row['manufacturer']))->result_array();
								$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
								$this->page_data['equip_supplier_id'] = $row['supplier'];
								$supplier = $this->db->get_where('suppliers', array('id' => $row['supplier']))->result_array();
								$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
							if ($row['equip_or_comp'] == 1) {
								$this->page_data['comp_replace_warranty'] = "comp replace warranty <br>";
								$this->page_data['replace_compname'] = $itemName[0]['name'] . "'s" . $subitemName[0]['name'] . " warranty <br>";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['comp_id'];
								$this->page_data['modelNo'] = $row['comp_model_no'];
								$this->page_data['comp_mfg'] = $row['comp_manufacturer'];
								$this->page_data['comp_supplier'] = $row['supplier'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
						} else {
							$this->page_data['replace_warranty_finished'] = "Replace Warranty Finished <br>";
						}
					}

					if ($row['warranty_duration'] == '12 month') {
						$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +1 year");
						$e_date = date("Y-m-d", $date);
						$date1 = new DateTime($s_date);
						$date2 = new DateTime($e_date);
						$date3 = date("Y-m-d", time());
						$end_date = new DateTime($date3);

						$interval = $date1->diff($date2);
						$interval2 = $date1->diff($end_date);

						if ($interval2->days < $interval->days) {
							$itemName = $this->db->get_where('items', array('id' => $row['name']))->result_array();
							$subitemName = $this->db->get_where('sub_items', array('id' => $row['comp_id']))->result_array();
							if ($row['equip_or_comp'] == 0) {
								$this->page_data['equip_replace_warranty'] = "equip replace warranty <br>";
								$this->page_data['replace_equipname'] = $itemName[0]['name'] . "'s" . $subitemName[0]['name'] . " warranty <br> ";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['name'];
								$this->page_data['modelNo'] = $row['product_model_no'];
								$this->page_data['equip_mfg_id'] = $row['manufacturer'];
								$manufacturer = $this->db->get_where('manufacturers', array('id' => $row['manufacturer']))->result_array();
								$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
								$this->page_data['equip_supplier_id'] = $row['supplier'];
								$supplier = $this->db->get_where('suppliers', array('id' => $row['supplier']))->result_array();
								$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
							if ($row['equip_or_comp'] == 1) {
								$this->page_data['comp_replace_warranty'] = "comp replace warranty <br>";
								$this->page_data['replace_compname'] = $itemName[0]['name'] . "'s" . $subitemName[0]['name'] . " warranty <br> ";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['comp_id'];
								$this->page_data['modelNo'] = $row['comp_model_no'];
								$this->page_data['comp_mfg'] = $row['comp_manufacturer'];
								$this->page_data['comp_supplier'] = $row['supplier'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
						} else {
							$this->page_data['replace_warranty_finished'] = "Replace Warranty Finished <br>";
						}
					}

					if ($row['warranty_duration'] == '24 month') {
						$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +24 month");
						$e_date = date("Y-m-d", $date);
						$date1 = new DateTime($s_date);
						$date2 = new DateTime($e_date);
						$date3 = date("Y-m-d", time());
						$end_date = new DateTime($date3);

						$interval = $date1->diff($date2);
						$interval2 = $date1->diff($end_date);

						if ($interval2->days < $interval->days) {
							$itemName = $this->db->get_where('items', array('id' => $row['name']))->result_array();
							$subitemName = $this->db->get_where('sub_items', array('id' => $row['comp_id']))->result_array();
							if ($row['equip_or_comp'] == 0) {
								$this->page_data['equip_replace_warranty'] = "equip replace warranty <br>";
								$this->page_data['replace_equipname'] = $itemName[0]['name'] . "'s" . $subitemName[0]['name'] . " warranty <br> ";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['name'];
								$this->page_data['modelNo'] = $row['product_model_no'];
								$this->page_data['equip_mfg_id'] = $row['manufacturer'];
								$manufacturer = $this->db->get_where('manufacturers', array('id' => $row['manufacturer']))->result_array();
								$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
								$this->page_data['equip_supplier_id'] = $row['supplier'];
								$supplier = $this->db->get_where('suppliers', array('id' => $row['supplier']))->result_array();
								$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
							if ($row['equip_or_comp'] == 1) {
								$this->page_data['comp_replace_warranty'] = "comp replace warranty <br>";
								$this->page_data['replace_compname'] = $itemName[0]['name'] . "'s" . $subitemName[0]['name'] . " warranty <br>";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['comp_id'];
								$this->page_data['modelNo'] = $row['comp_model_no'];
								$this->page_data['comp_mfg'] = $row['comp_manufacturer'];
								$this->page_data['comp_supplier'] = $row['supplier'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
						} else {
							$this->page_data['replace_warranty_finished'] = "Replace Warranty Finished <br>";
						}
					}

					if ($row['warranty_duration'] == '36 month') {
						$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +36 month");
						$e_date = date("Y-m-d", $date);
						$date1 = new DateTime($s_date);
						$date2 = new DateTime($e_date);
						$date3 = date("Y-m-d", time());
						$end_date = new DateTime($date3);

						$interval = $date1->diff($date2);
						$interval2 = $date1->diff($end_date);

						if ($interval2->days < $interval->days) {
							$itemName = $this->db->get_where('items', array('id' => $row['name']))->result_array();
							$subitemName = $this->db->get_where('sub_items', array('id' => $row['comp_id']))->result_array();
							if ($row['equip_or_comp'] == 0) {
								$this->page_data['equip_replace_warranty'] = "equip replace warranty <br>";
								$this->page_data['replace_equipname'] = $itemName[0]['name'] . "'s" . $subitemName[0]['name'] . " warranty <br>";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['name'];
								$this->page_data['modelNo'] = $row['product_model_no'];
								$this->page_data['equip_mfg_id'] = $row['manufacturer'];
								$manufacturer = $this->db->get_where('manufacturers', array('id' => $row['manufacturer']))->result_array();
								$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
								$this->page_data['equip_supplier_id'] = $row['supplier'];
								$supplier = $this->db->get_where('suppliers', array('id' => $row['supplier']))->result_array();
								$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
							if ($row['equip_or_comp'] == 1) {
								$this->page_data['comp_replace_warranty'] = "comp replace warranty <br>";
								$this->page_data['replace_compname'] = $itemName[0]['name'] . "'s" . $subitemName[0]['name'] . " warranty <br> ";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['comp_id'];
								$this->page_data['modelNo'] = $row['comp_model_no'];
								$this->page_data['comp_mfg'] = $row['comp_manufacturer'];
								$this->page_data['comp_supplier'] = $row['supplier'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
						} else {
							$this->page_data['replace_warranty_finished'] = "Replace Warranty Finished <br>";
						}
					}

					if ($row['warranty_duration'] == '48 month') {
						$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +48 month");
						$e_date = date("Y-m-d", $date);
						$date1 = new DateTime($s_date);
						$date2 = new DateTime($e_date);
						$date3 = date("Y-m-d", time());
						$end_date = new DateTime($date3);

						$interval = $date1->diff($date2);
						$interval2 = $date1->diff($end_date);

						if ($interval2->days < $interval->days) {
							$itemName = $this->db->get_where('items', array('id' => $row['name']))->result_array();
							$subitemName = $this->db->get_where('sub_items', array('id' => $row['comp_id']))->result_array();
							if ($row['equip_or_comp'] == 0) {
								$this->page_data['equip_replace_warranty'] = "equip replace warranty <br>";
								$this->page_data['replace_equipname'] = $itemName[0]['name'] . "'s" . $subitemName[0]['name'] . " warranty <br>";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['name'];
								$this->page_data['modelNo'] = $row['product_model_no'];
								$this->page_data['equip_mfg_id'] = $row['manufacturer'];
								$manufacturer = $this->db->get_where('manufacturers', array('id' => $row['manufacturer']))->result_array();
								$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
								$this->page_data['equip_supplier_id'] = $row['supplier'];
								$supplier = $this->db->get_where('suppliers', array('id' => $row['supplier']))->result_array();
								$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
							if ($row['equip_or_comp'] == 1) {
								$this->page_data['comp_replace_warranty'] = "comp replace warranty <br>";
								$this->page_data['replace_compname'] = $itemName[0]['name'] . "'s" . $subitemName[0]['name'] . " warranty <br>";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['comp_id'];
								$this->page_data['modelNo'] = $row['comp_model_no'];
								$this->page_data['comp_mfg'] = $row['comp_manufacturer'];
								$this->page_data['comp_supplier'] = $row['supplier'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
						} else {
							$this->page_data['replace_warranty_finished'] = "Replace Warranty Finished <br>";
						}
					}

					if ($row['warranty_duration'] == '60 month') {
						$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +60 month");
						$e_date = date("Y-m-d", $date);
						$date1 = new DateTime($s_date);
						$date2 = new DateTime($e_date);
						$date3 = date("Y-m-d", time());
						$end_date = new DateTime($date3);

						$interval = $date1->diff($date2);
						$interval2 = $date1->diff($end_date);

						if ($interval2->days < $interval->days) {
							$itemName = $this->db->get_where('items', array('id' => $row['name']))->result_array();
							$subitemName = $this->db->get_where('sub_items', array('id' => $row['comp_id']))->result_array();
							if ($row['equip_or_comp'] == 0) {

								$this->page_data['equip_replace_warranty'] = "equip replace warranty <br>";
								$this->page_data['replace_equipname'] = $itemName[0]['name'] . "'s" . $subitemName[0]['name'] . " warranty <br>";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['name'];
								$this->page_data['modelNo'] = $row['product_model_no'];
								$this->page_data['equip_mfg_id'] = $row['manufacturer'];
								$manufacturer = $this->db->get_where('manufacturers', array('id' => $row['manufacturer']))->result_array();
								$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
								$this->page_data['equip_supplier_id'] = $row['supplier'];
								$supplier = $this->db->get_where('suppliers', array('id' => $row['supplier']))->result_array();
								$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
							if ($row['equip_or_comp'] == 1) {
								$this->page_data['comp_replace_warranty'] = "comp replace warranty <br>";
								$this->page_data['replace_compname'] = $itemName[0]['name'] . "'s" . $subitemName[0]['name'] . " warranty <br>";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['comp_id'];
								$this->page_data['modelNo'] = $row['comp_model_no'];
								$this->page_data['comp_mfg'] = $row['comp_manufacturer'];
								$this->page_data['comp_supplier'] = $row['supplier'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
						} else {
							$this->page_data['replace_warranty_finished'] = "Replace Warranty Finished <br>";
						}
					}
				}

				if ($row['warranty_type'] == '2') {
					if ($row['warranty_duration'] == '3 month') {
						$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +3 month");

						$e_date = date("Y-m-d", $date);
						$date1 = new DateTime($s_date);
						$date2 = new DateTime($e_date);
						$date3 = date("Y-m-d", time());
						$end_date = new DateTime($date3);

						if ($interval2->days < $interval->days) {
							$itemName = $this->db->get_where('items', array('id' => $row['name']))->result_array();
							$subitemName = $this->db->get_where('sub_items', array('id' => $row['comp_id']))->result_array();
							if ($row['equip_or_comp'] == 0) {
								$this->page_data['equip_repair_warranty'] = "Equip Repair Warranty <br>";
								$this->page_data['repair_equipname'] = $itemName[0]['name'] . "'s" . $subitemName[0]['name'] . " warranty <br>";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['name'];
								$this->page_data['modelNo'] = $row['product_model_no'];
								$this->page_data['equip_mfg_id'] = $row['manufacturer'];
								$manufacturer = $this->db->get_where('manufacturers', array('id' => $row['manufacturer']))->result_array();
								$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
								$this->page_data['equip_supplier_id'] = $row['supplier'];
								$supplier = $this->db->get_where('suppliers', array('id' => $row['supplier']))->result_array();
								$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
							if ($row['equip_or_comp'] == 1) {
								$this->page_data['comp_repair_warranty'] = "Comp Repair Warranty <br>";
								$this->page_data['repair_compname'] = $itemName . "'s" . $subitemName . " warranty <br>";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['comp_id'];
								$this->page_data['modelNo'] = $row['comp_model_no'];
								$this->page_data['comp_mfg'] = $row['comp_manufacturer'];
								$this->page_data['comp_supplier'] = $row['supplier'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
						} else {
							$this->page_data['repair_warranty_finished'] = "Warranty Finished <br>";
						}
					}

					if ($row['warranty_duration'] == '6 month') {
						$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +6 month");
						$e_date = date("Y-m-d", $date);
						$date1 = new DateTime($s_date);
						$date2 = new DateTime($e_date);
						$date3 = date("Y-m-d", time());
						$end_date = new DateTime($date3);

						$interval = $date1->diff($date2);
						$interval2 = $date1->diff($end_date);

						if ($interval2->days < $interval->days) {
							$itemName = $this->db->get_where('items', array('id' => $row['name']))->result_array();
							$subitemName = $this->db->get_where('sub_items', array('id' => $row['comp_id']))->result_array();
							if ($row['equip_or_comp'] == 0) {
								$this->page_data['equip_repair_warranty'] = "Equip Repair Warranty <br> ";
								$this->page_data['repair_equipname'] = $itemName[0]['name'] . "'s" . $subitemName[0]['name'] . " warranty <br>";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['name'];
								$this->page_data['modelNo'] = $row['product_model_no'];
								$this->page_data['equip_mfg_id'] = $row['manufacturer'];
								$manufacturer = $this->db->get_where('manufacturers', array('id' => $row['manufacturer']))->result_array();
								$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
								$this->page_data['equip_supplier_id'] = $row['supplier'];
								$supplier = $this->db->get_where('suppliers', array('id' => $row['supplier']))->result_array();
								$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
							if ($row['equip_or_comp'] == 1) {
								$this->page_data['comp_repair_warranty'] = "Comp Repair Warranty <br>";
								$this->page_data['repair_compname'] = $itemName . "'s" . $subitemName . " warranty <br>";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['comp_id'];
								$this->page_data['modelNo'] = $row['comp_model_no'];
								$this->page_data['comp_mfg'] = $row['comp_manufacturer'];
								$this->page_data['comp_supplier'] = $row['supplier'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
						} else {
							$this->page_data['repair_warranty_finished'] = "Warranty Finished <br>";
						}
					}


					if ($row['warranty_duration'] == '9 month') {
						$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +9 month");
						$e_date = date("Y-m-d", $date);
						$date1 = new DateTime($s_date);
						$date2 = new DateTime($e_date);
						$date3 = date("Y-m-d", time());
						$end_date = new DateTime($date3);

						$interval = $date1->diff($date2);
						$interval2 = $date1->diff($end_date);

						if ($interval2->days < $interval->days) {
							$itemName = $this->db->get_where('items', array('id' => $row['name']))->result_array();
							$subitemName = $this->db->get_where('sub_items', array('id' => $row['comp_id']))->result_array();
							if ($row['equip_or_comp'] == 0) {
								$this->page_data['equip_repair_warranty'] = "Equip Repair Warranty <br>";
								$this->page_data['repair_equipname'] = $itemName[0]['name'] . "'s" . $subitemName[0]['name'] . " warranty <br>";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['name'];
								$this->page_data['modelNo'] = $row['product_model_no'];
								$this->page_data['equip_mfg_id'] = $row['manufacturer'];
								$manufacturer = $this->db->get_where('manufacturers', array('id' => $row['manufacturer']))->result_array();
								$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
								$this->page_data['equip_supplier_id'] = $row['supplier'];
								$supplier = $this->db->get_where('suppliers', array('id' => $row['supplier']))->result_array();
								$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
							if ($row['equip_or_comp'] == 1) {
								$this->page_data['comp_repair_warranty'] = "Comp Repair Warranty <br>";
								$this->page_data['repair_compname'] = $itemName . "'s" . $subitemName . " warranty <br>";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['comp_id'];
								$this->page_data['modelNo'] = $row['comp_model_no'];
								$this->page_data['comp_mfg'] = $row['comp_manufacturer'];
								$this->page_data['comp_supplier'] = $row['supplier'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
						} else {
							$this->page_data['repair_warranty_finished'] = "Warranty Finished <br>";
						}
					}

					if ($row['warranty_duration'] == '12 month') {
						$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +1 year");
						$e_date = date("Y-m-d", $date);
						$date1 = new DateTime($s_date);
						$date2 = new DateTime($e_date);
						$date3 = date("Y-m-d", time());
						$end_date = new DateTime($date3);

						$interval = $date1->diff($date2);
						$interval2 = $date1->diff($end_date);

						if ($interval2->days < $interval->days) {
							$itemName = $this->db->get_where('items', array('id' => $row['name']))->result_array();
							$subitemName = $this->db->get_where('sub_items', array('id' => $row['comp_id']))->result_array();
							if ($row['equip_or_comp'] == 0) {
								$this->page_data['equip_repair_warranty'] = "Equip Repair Warranty <br>";
								$this->page_data['repair_equipname'] = $itemName[0]['name'] . "'s" . $subitemName[0]['name'] . " warranty <br> ";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['name'];
								$this->page_data['modelNo'] = $row['product_model_no'];
								$this->page_data['equip_mfg_id'] = $row['manufacturer'];
								$manufacturer = $this->db->get_where('manufacturers', array('id' => $row['manufacturer']))->result_array();
								$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
								$this->page_data['equip_supplier_id'] = $row['supplier'];
								$supplier = $this->db->get_where('suppliers', array('id' => $row['supplier']))->result_array();
								$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
							if ($row['equip_or_comp'] == 1) {
								$this->page_data['comp_repair_warranty'] = "Comp Repair Warranty <br>";
								$this->page_data['repair_compname'] = $itemName . "'s" . $subitemName . " warranty <br>";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['comp_id'];
								$this->page_data['modelNo'] = $row['comp_model_no'];
								$this->page_data['comp_mfg'] = $row['comp_manufacturer'];
								$this->page_data['comp_supplier'] = $row['supplier'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
						} else {
							$this->page_data['repair_warranty_finished'] = "Warranty Finished <br>";
						}
					}

					if ($row['warranty_duration'] == '24 month') {
						$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +24 month");
						$e_date = date("Y-m-d", $date);
						$date1 = new DateTime($s_date);
						$date2 = new DateTime($e_date);
						$date3 = date("Y-m-d", time());
						$end_date = new DateTime($date3);

						$interval = $date1->diff($date2);
						$interval2 = $date1->diff($end_date);

						if ($interval2->days < $interval->days) {
							$itemName = $this->db->get_where('items', array('id' => $row['name']))->result_array();
							$subitemName = $this->db->get_where('sub_items', array('id' => $row['comp_id']))->result_array();
							if ($row['equip_or_comp'] == 0) {
								$this->page_data['equip_repair_warranty'] = "Equip Repair Warranty <br>";
								$this->page_data['repair_equipname'] = $itemName[0]['name'] . "'s" . $subitemName[0]['name'] . " warranty <br>";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['name'];
								$this->page_data['modelNo'] = $row['product_model_no'];
								$this->page_data['equip_mfg_id'] = $row['manufacturer'];
								$manufacturer = $this->db->get_where('manufacturers', array('id' => $row['manufacturer']))->result_array();
								$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
								$this->page_data['equip_supplier_id'] = $row['supplier'];
								$supplier = $this->db->get_where('suppliers', array('id' => $row['supplier']))->result_array();
								$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
							if ($row['equip_or_comp'] == 1) {
								$this->page_data['comp_repair_warranty'] = "Comp Repair Warranty <br>";
								$this->page_data['repair_compname'] = $itemName . "'s" . $subitemName . " warranty <br>";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['comp_id'];
								$this->page_data['modelNo'] = $row['comp_model_no'];
								$this->page_data['comp_mfg'] = $row['comp_manufacturer'];
								$this->page_data['comp_supplier'] = $row['supplier'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
						} else {
							$this->page_data['repair_warranty_finished'] = "Warranty Finished <br>";
						}
					}

					if ($row['warranty_duration'] == '36 month') {
						$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +36 month");
						$e_date = date("Y-m-d", $date);
						$date1 = new DateTime($s_date);
						$date2 = new DateTime($e_date);
						$date3 = date("Y-m-d", time());
						$end_date = new DateTime($date3);

						$interval = $date1->diff($date2);
						$interval2 = $date1->diff($end_date);

						if ($interval2->days < $interval->days) {
							$itemName = $this->db->get_where('items', array('id' => $row['name']))->result_array();
							$subitemName = $this->db->get_where('sub_items', array('id' => $row['comp_id']))->result_array();
							if ($row['equip_or_comp'] == 0) {
								$this->page_data['equip_repair_warranty'] = "Equip Repair Warranty <br>";
								$this->page_data['repair_equipname'] = $itemName[0]['name'] . "'s" . $subitemName[0]['name'] . " warranty <br>";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['name'];
								$this->page_data['modelNo'] = $row['product_model_no'];
								$this->page_data['comp_mfg'] = $row['manufacturer'];
								$this->page_data['comp_supplier'] = $row['supplier'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
							if ($row['equip_or_comp'] == 1) {
								$this->page_data['comp_repair_warranty'] = "Comp Repair Warranty <br>";
								$this->page_data['repair_compname'] = $itemName . "'s" . $subitemName . " warranty <br>";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['comp_id'];
								$this->page_data['modelNo'] = $row['comp_model_no'];
								$this->page_data['comp_mfg'] = $row['comp_manufacturer'];
								$this->page_data['comp_supplier'] = $row['supplier'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
						} else {
							$this->page_data['repair_warranty_finished'] = "Warranty Finished <br>";
						}
					}


					if ($row['warranty_duration'] == '48 month') {
						$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +48 month");
						$e_date = date("Y-m-d", $date);
						$date1 = new DateTime($s_date);
						$date2 = new DateTime($e_date);
						$date3 = date("Y-m-d", time());
						$end_date = new DateTime($date3);

						$interval = $date1->diff($date2);
						$interval2 = $date1->diff($end_date);

						if ($interval2->days < $interval->days) {
							$itemName = $this->db->get_where('items', array('id' => $row['name']))->result_array();
							$subitemName = $this->db->get_where('sub_items', array('id' => $row['comp_id']))->result_array();
							if ($row['equip_or_comp'] == 1) {
								$this->page_data['equip_repair_warranty'] = "Equip Repair Warranty <br>";
								$this->page_data['repair_equipname'] = $itemName[0]['name'] . "'s" . $subitemName[0]['name'] . " warranty <br>";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['name'];
								$this->page_data['modelNo'] = $row['product_model_no'];
								$this->page_data['equip_mfg_id'] = $row['manufacturer'];
								$manufacturer = $this->db->get_where('manufacturers', array('id' => $row['manufacturer']))->result_array();
								$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
								$this->page_data['equip_supplier_id'] = $row['supplier'];
								$supplier = $this->db->get_where('suppliers', array('id' => $row['supplier']))->result_array();
								$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
							if ($row['equip_or_comp'] == 1) {
								$this->page_data['comp_repair_warranty'] = "Comp Repair Warranty <br>";
								$this->page_data['repair_compname'] = $itemName . "'s" . $subitemName . " warranty <br>";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['comp_id'];
								$this->page_data['modelNo'] = $row['comp_model_no'];
								$this->page_data['comp_mfg'] = $row['comp_manufacturer'];
								$this->page_data['comp_supplier'] = $row['supplier'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
						} else {
							$this->page_data['repair_warranty_finished'] = "Warranty Finished <br>";
						}
					}


					if ($row['warranty_duration'] == '60 month') {
						$date = strtotime(date("Y-m-d", strtotime($s_date)) . " +60 month");
						$e_date = date("Y-m-d", $date);
						$date1 = new DateTime($s_date);
						$date2 = new DateTime($e_date);
						$date3 = date("Y-m-d", time());
						$end_date = new DateTime($date3);

						$interval = $date1->diff($date2);
						$interval2 = $date1->diff($end_date);

						if ($interval2->days < $interval->days) {
							$itemName = $this->db->get_where('items', array('id' => $row['name']))->result_array();
							$subitemName = $this->db->get_where('sub_items', array('id' => $row['comp_id']))->result_array();
							if ($row['equip_or_comp'] == 0) {
								$this->page_data['equip_repair_warranty'] = "Equip Repair Warranty <br>";
								$this->page_data['repair_equipname'] = $itemName[0]['name'] . "'s" . $subitemName[0]['name'] . " warranty <br>";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['name'];
								$this->page_data['modelNo'] = $row['product_model_no'];
								$this->page_data['equip_mfg_id'] = $row['manufacturer'];
								$manufacturer = $this->db->get_where('manufacturers', array('id' => $row['manufacturer']))->result_array();
								$this->page_data['equip_mfg_name'] = $manufacturer[0]['name'];
								$this->page_data['equip_supplier_id'] = $row['supplier'];
								$supplier = $this->db->get_where('suppliers', array('id' => $row['supplier']))->result_array();
								$this->page_data['equip_supplier_name'] = $supplier[0]['name'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
							if ($row['equip_or_comp'] == 1) {
								$this->page_data['comp_repair_warranty'] = "Comp Repair Warranty  <br>";
								$this->page_data['repair_compname'] = $itemName . "'s" . $subitemName . " warranty <br> ";
								$this->page_data['comp_name'] = $subitemName[0]['name'];
								$this->page_data['comp_id'] = $row['comp_id'];
								$this->page_data['modelNo'] = $row['comp_model_no'];
								$this->page_data['comp_mfg'] = $row['comp_manufacturer'];
								$this->page_data['comp_supplier'] = $row['supplier'];
								$this->page_data['warranty_ymd'] = "warranty " . $interval->y . " years, " . $interval->m . " months, " . $interval->d . " days <br>";
								$this->page_data['warranty_days'] = "warranty " . $interval->days . " days <br>";
								$this->page_data['working_ymd'] =  "working " . $interval2->y . " years, " . $interval2->m . " months, " . $interval2->d . " days <br> ";
								// shows the total amount of days (not divided into years, months and days like above)
								$this->page_data['working_days'] =  "working " . $interval2->days . " days <br>";
							}
						} else {
							$this->page_data['repair_warranty_finished'] = "Warranty Finished <br>";
						}
					}
				}
				if ($row['warranty_type'] == '0') {
					$this->page_data['noWarranty'] = "Have no warranty<br>";
				}
			}
			/** foreach loop end */
			$this->load->view('back/inventory/component_replace', $this->page_data);
		}
		/** component replace End */

		/** component replace do Start */
		elseif ($para1 == 'component_replace_do') {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('replace_reason', 'Replace Reason ', 'required|trim');

			if ($this->form_validation->run() == TRUE) {
				if ($this->session->userdata('adminid')) {
					$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
					$component_id = $this->page_data['assets_ids'];
					$counter = 0;
					if ($this->input->post('equip_warranty')) {
						$subitems = $this->db->get_where('installed_subitems', array('id' => $component_id[0]))->result_array();

						foreach ($subitems as $subasset) {

							$date = date("Y-m-d H:i:s");

							$asset_data = array(
								'action_status' => "12",
								'user_type' => "1",
								'checkin_by' => $this->session->userdata('adminid'),
								'add_date' => time(),
							);
							$this->db->where('id', $subasset['asset_id']);
							$this->db->update('assets', $asset_data);

							// $subasset_data = array
							// (
							// 'action_status' => "12",
							// 'equipment_warranty'=> '1',
							// 'product_model_no' => $this->input->post('model_no'),
							// 'manufacturer' => $this->input->post('mfg'),
							// 'supplier' => $this->input->post('supplier'),
							// 'user_type' => "1",
							// 'user' => $this->session->userdata('adminid'),
							// 'action_date' => time() ,
							// );
							// $this->db->where('id',$subasset['subitem_id']);
							// $this->db->update('sub_assets',$subasset_data);

							$installing_data = array(
								'transaction_type' => "12",
								'user_type' => "1",
								'user_name' => $this->session->userdata('adminid'),
								'action_date' => $date,
							);
							$this->db->where('id', $subasset['installed_id']);
							$this->db->update('installed_inventory', $installing_data);


							$installed_subitem_data = array(
								'transaction_type' => 12,
								'model_no' => $this->input->post('model_no'),
								'serial_no' => $this->input->post('serial_no'),
								'manufacturer' => $this->input->post('mfg'),
								'supplier' => $this->input->post('supplier'),
								'comments' => $this->input->post('replace_reason'),
								'action_by_user_type' => "1",
								'action_by_user' => $this->session->userdata('adminid'),
								'action_date' => $date,
							);
							$this->db->where('id', $subasset['id']);
							$this->db->update('installed_subitems', $installed_subitem_data);

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
								'serial_no' => $this->input->post('serial_no'),
								'identification_no' => $subasset['identification_no'],
								'is_sub_item' => 1,
								'installed_subitem_id' => $subasset['id'],
								'asset_id' => $subasset['asset_id'],
								'transaction_type' => "12",
								'route' => $subasset['route'],
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
							$this->db->insert('asset_transaction', $asset_transaction_data);
						}
					}
					if ($this->input->post('comp_warranty')) {
						$subitems = $this->db->get_where('installed_subitems', array('id' => $component_id[0]))->result_array();

						foreach ($subitems as $subasset) {

							$date = date("Y-m-d H:i:s");

							$asset_data = array(
								'action_status' => "12",
								'user_type' => "1",
								'checkin_by' => $this->session->userdata('adminid'),
								'add_date' => time(),
							);
							$this->db->where('id', $subasset['asset_id']);
							$this->db->update('assets', $asset_data);

							// $subasset_data = array
							// (
							// 'action_status' => "12",
							// 'equipment_warranty'=> '1',
							// 'product_model_no' => $this->input->post('model_no'),
							// 'manufacturer' => $this->input->post('mfg'),
							// 'supplier' => $this->input->post('supplier'),
							// 'user_type' => "1",
							// 'user' => $this->session->userdata('adminid'),
							// 'action_date' => time() ,
							// );
							// $this->db->where('id',$subasset['subitem_id']);
							// $this->db->update('sub_assets',$subasset_data);

							$installing_data = array(
								'transaction_type' => "12",
								'user_type' => "1",
								'user_name' => $this->session->userdata('adminid'),
								'action_date' => $date,
							);
							$this->db->where('id', $subasset['installed_id']);
							$this->db->update('installed_inventory', $installing_data);

							$installed_subitem_data = array(
								'transaction_type' => 12,
								'model_no' => $this->input->post('model_no'),
								'serial_no' => $this->input->post('serial_no'),
								'manufacturer' => $this->input->post('mfg'),
								'supplier' => $this->input->post('supplier'),
								'comments' => $this->input->post('replace_reason'),
								'action_by_user_type' => "1",
								'action_by_user' => $this->session->userdata('adminid'),
								'action_date' => $date,
							);
							$this->db->where('id', $subasset['id']);
							$this->db->update('installed_subitems', $installed_subitem_data);

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
								'serial_no' => $this->input->post('serial_no'),
								'identification_no' => $subasset['identification_no'],
								'is_sub_item' => 1,
								'installed_subitem_id' => $subasset['id'],
								'asset_id' => $subasset['asset_id'],
								'transaction_type' => "12",
								'route' => $subasset['route'],
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
							$this->db->insert('asset_transaction', $asset_transaction_data);
						}
					} else {
						$subitems = $this->db->get_where('installed_subitems', array('id' => $component_id[0]))->result_array();
						$companyType = '';
						$companyName = '';
						$companyAddress = '';
						$companyPersonType = '';
						$companyPerson = '';
						$personContact = '';
						foreach ($subitems as $subasset) {

							if ($this->input->post('replacing_company') == 1) {
								$companyType = 1;
								$companyName = $this->input->post('replacing_tsp');
								$companyAddress = $this->input->post('tsp_address');
								$companyPersonType = $this->input->post('tsp_person_type');
								$companyPerson = $this->input->post('tsp_person');
								$personContact = $this->input->post('tsp_person_contact');
							}
							if ($this->input->post('replacing_company') == 2) {
								$companyType = 2;
								$companyName = $this->input->post('outer_company_name');
								$companyAddress = $this->input->post('outer_company_address');
								$companyPersonType = 0;
								$companyPerson = $this->input->post('outsider_name');
								$personContact = $this->input->post('outsider_contact');
							}

							$date = date("Y-m-d H:i:s");

							$asset_data = array(
								'action_status' => "12",
								'user_type' => "1",
								'checkin_by' => $this->session->userdata('adminid'),
								'add_date' => time(),
							);
							$this->db->where('id', $subasset['asset_id']);
							$this->db->update('assets', $asset_data);

							$installing_data = array(
								'transaction_type' => "12",
								'user_type' => "1",
								'user_name' => $this->session->userdata('adminid'),
								'action_date' => $date,
							);
							$this->db->where('id', $subasset['installed_id']);
							$this->db->update('installed_inventory', $installing_data);

							$installed_subitem_data = array(
								'transaction_type' => 12,
								'serial_no' => $this->input->post('serial_no'),
								'model_no' => $this->input->post('model_no'),
								'manufacturer' => $this->input->post('mfg'),
								'supplier' => $this->input->post('supplier'),
								'action_by_user_type' => "1",
								'company_type' => $companyType,
								'company_name' => $companyName,
								'company_address' => $companyAddress,
								'company_person_type' => $companyPersonType,
								'person_name' => $companyPerson,
								'cost' => $this->input->post('replace_cost'),
								'person_contact' => $personContact,
								'comments' => $this->input->post('replace_reason'),
								'action_by_user' => $this->session->userdata('adminid'),
								'action_date' => $date,
							);
							$this->db->where('id', $subasset['id']);
							$this->db->update('installed_subitems', $installed_subitem_data);

							$this->db->where('installed_subitem_id', $subasset['id']);
							$this->db->delete('faulty_equipment_list');

							$asset_transaction_data = array(
								'installed_id' => $subasset['installed_id'],
								'item_id' => $subasset['item_id'],
								'subitem_id' => $subasset['subitem_id'],
								'serial_no' => $this->input->post('serial_no'),
								'identification_no' => $subasset['identification_no'],
								'is_sub_item' => 1,
								'installed_subitem_id' => $subasset['id'],
								'asset_id' => $subasset['asset_id'],
								'transaction_type' => "12",
								'route' => $subasset['route'],
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
							$this->db->insert('asset_transaction', $asset_transaction_data);
						}
					}
					echo json_encode(array('response' => true, 'message' => 'Faulty Done.', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
					exit;
				}
			}
		}
		/** component replace do End */

		/** component Repair Start */
		elseif ($para1 == 'component_repair') {
			$this->page_data['repairs'] = explode(',', $_POST['asset']);
			$repairs = $this->page_data['repairs'];
			$data = array();
			foreach ($repairs as $repair) {
				$data[] = $this->db->get_where('installed_subitems', array('id' => $repair))->result_array();
			}
			$data2 = array();
			foreach ($data as $row) {
				if ($row[0]['transaction_type'] == "13") {
					echo "Selected comp already in repairing mode.";
					exit;
				}
				if ($row[0]['transaction_type'] == "4") {
					echo "Selected item already in repairing mode.";
					exit;
				}
				if ($row[0]['transaction_type'] == "5") {
					echo "Selected item's repairing recently completed.";
					exit;
				}
				if ($row[0]['transaction_type'] == "6") {
					echo "Retire item cannot be repair.";
					exit;
				}
			}
			$data3 = array();
			foreach ($repairs as $repair) {
				$installing_names = $this->db->get_where('installed_subitems', array('id' => $repair))->result_array();
				$this->db->select('installed_subitems.subitem_id AS temp_id,sub_items.*');
				$this->db->from('installed_subitems');
				$this->db->join('sub_items', 'installed_subitems.subitem_id = sub_items.id');
				$this->db->where('installed_subitems.id', $repair);
				$query = $this->db->get();
				$data3[] = $query->result_array();
				$this->page_data['data'] = $data3;
			}

			foreach ($repairs as $repair) {
				$installed_location = $this->db->get_where('installed_subitems', array('id' => $repair))->result_array();
				$locationNames = $this->db->get_where('locations', array('id' => $installed_location[0]['location']))->result_array();
				$siteNames = $this->db->get_where('sites', array('id' => $locationNames[0]['site']))->result_array();
				$this->page_data['sites'] = $siteNames;
				$this->page_data['locations'] = $locationNames;
			}
			$this->page_data['data1'] = $data;
			$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
			$this->load->view('back/inventory/repair_component', $this->page_data);
		} elseif ($para1 == 'component_repair_do') {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('item_site', 'Item Site', 'required|trim');
			$this->form_validation->set_rules('item_location', 'Item Location', 'required|trim');
			$this->form_validation->set_rules('item_availability', 'Item Availability', 'required|trim');
			$this->form_validation->set_rules('repair_type', 'Repair Type', 'required|trim');
			$this->form_validation->set_rules('expected_completion', 'Expected Repair Completion Date', 'required|trim');
			$this->form_validation->set_rules('start_repair_reason', 'Reason For Repairing', 'required|trim');

			if ($this->form_validation->run() == TRUE) {
				if ($this->session->userdata('adminid')) {

					if ($this->input->post('repair_type') == 2) {
						$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
						$install_ids = $this->page_data['assets_ids'];

						foreach ($install_ids as $id) {
							$date = date("Y-m-d H:i:s");

							$install = $this->db->get_where('installed_subitems', array('id' => $id))->result_array();
							$ast_mfg = $this->db->get_where('assets', array('id' => $install[0]['asset_id']))->result_array();

							$assets_data = array('action_status' => '13', 'user_type' => "1", 'checkin_by' => $this->session->userdata('adminid'), 'site' => $this->input->post('item_site'));
							$this->db->where('id', $install[0]['asset_id']);
							$this->db->update('assets', $assets_data);

							$installing_data = array(
								'transaction_type' => "13",
								'user_type' => "1",
								'user_name' => $this->session->userdata('adminid'),
								'action_date' => $date,
							);
							$this->db->where('id', $install[0]['installed_id']);
							$this->db->update('installed_inventory', $installing_data);

							if ($install) {
								$subitems = $this->db->get_where('installed_subitems', array('id' => $install[0]['id']))->result_array();
								foreach ($subitems as $subasset) {

									$installing_subitem_data = array(
										'transaction_type' => 13,
										'company_type' => '3',
										'company_name' => $ast_mfg[0]['manufacturer'],
										'company_address' => 'see manufacturer address',
										'company_person_type' => $this->input->post('tsp_person_type'),
										'person_name' => 'manufacturer focal person does not exist',
										'person_contact' => 'not available',
										'faulty_time_omc' => '',
										'faulty_date' => '',
										'est_cost' => '',
										'comments' => $this->input->post('start_repair_reason'),
										'action_by_user_type' => "1",
										'action_by_user' => $this->session->userdata('adminid'),
										'action_date' => $date,
									);
									$this->db->where('id', $subasset['id']);
									$this->db->update('installed_subitems', $installing_subitem_data);

									$data = array(
										'asset_id' => $subasset['asset_id'],
										'installed_id' => $subasset['installed_id'],
										'installed_subitem_id' => $subasset['id'],
										'item_id' => $subasset['item_id'],
										'subitem_id' => $subasset['subitem_id'],
										'serial_no' => $subasset['serial_no'],
										'identification_no' => $subasset['identification_no'],
										'is_sub_item' => 1,
										'transaction_type' => 13,
										'route' => $subasset['route'],
										'site' => $this->input->post('item_site'),
										'location' => $this->input->post('item_location'),
										'repair_type' => $this->input->post('repair_type'),
										'available' => $this->input->post('item_availability'),
										'user_type' => "1",
										'added_by' => $this->session->userdata('adminid'),
										'action_date' => $date,
										'organisation_type' => 3,
										'organisation' => $ast_mfg[0]['comp_manufacturer'],
										'organisation_address' => 'see manufacturer address',
										'repairing_person_type' => $this->input->post('tsp_person_type'),
										'person' => 'manufacturer focal person does not exist',
										'person_contact' => 'not available',
										'return_date' => $this->input->post('expected_completion'),
										'action_comments' => $this->input->post('start_repair_reason'),
									);
									$this->db->insert('asset_transaction', $data);
								}
							}
							//  if($install[0]['have_sub_items']==0){

							// 			$data = array(
							// 				'asset_id' => $install[0]['asset_id'],
							// 				'installed_id' => $id,
							// 				'item_id' => $install[0]['name'],
							// 				'serial_no'=>$install[0]['serial_no'],
							// 				'identification_no'=>$install[0]['identification_no'],
							// 				'is_sub_item'=>0,
							// 				'have_sub_items'=>1,
							// 				'transaction_type' => 4,
							// 				'site' => $this->input->post('item_site'),
							// 				'location' => $this->input->post('item_location'),
							// 				'repair_type' => $this->input->post('repair_type'),
							// 				'available' => $this->input->post('item_availability'),
							// 				'user_type' => "1",
							// 				'added_by' => $this->session->userdata('adminid'),
							// 				'action_date' => $date,
							// 				'organisation_type' => 3,
							// 				'organisation' => $ast_mfg[0]['manufacturer'],
							// 				'organisation_address' => 'see manufacturer address',
							// 				'repairing_person_type' => $this->input->post('tsp_person_type'),
							// 				'person' => 'manufacturer focal person does not exist',
							// 				'person_contact' => 'not available',
							// 				'return_date' => $this->input->post('expected_completion'),
							// 				'action_comments' => $this->input->post('start_repair_reason'),
							// 				);
							// 				$this->db->insert('asset_transaction',$data);
							// }

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
							// $counter++;
						}
						echo json_encode(array('response' => true, 'message' => 'Repairing Starts.', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
						exit;
					}

					if ($this->input->post('repair_type') == 1) {
						if ($this->input->post('repairing_company') == "1") {
							$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
							$install_ids = $this->page_data['assets_ids'];

							foreach ($install_ids as $id) {
								$date = date("Y-m-d H:i:s");

								$install = $this->db->get_where('installed_subitems', array('id' => $id))->result_array();

								$assets_data = array('action_status' => '13', 'user_type' => "1", 'checkin_by' => $this->session->userdata('adminid'), 'site' => $this->input->post('item_site'));
								$this->db->where('id', $install[0]['asset_id']);
								$this->db->update('assets', $assets_data);

								$installing_data = array(
									'transaction_type' => "13",
									'user_type' => "1",
									'user_name' => $this->session->userdata('adminid'),
									'action_date' => $date,
								);
								$this->db->where('id', $install[0]['installed_id']);
								$this->db->update('installed_inventory', $installing_data);

								if ($install) {
									$subitems = $this->db->get_where('installed_subitems', array('id' => $install[0]['id']))->result_array();
									foreach ($subitems as $subasset) {

										// $subAsset_data = array
										// (
										// 'action_status' => "4",
										// 'user_type' => "1",
										// 'user' => $this->session->userdata('adminid'),
										// 'action_date' => $date ,
										// );
										// $this->db->where('installed_id',$id);
										// $this->db->update('sub_assets',$subAsset_data);

										$installing_subitem_data = array(
											'transaction_type' => 13,
											'company_type' => '1',
											'company_name' => $this->input->post('repairing_tsp'),
											'company_address' => $this->input->post('tsp_address'),
											'company_person_type' => $this->input->post('tsp_person_type'),
											'person_name' => $this->input->post('tsp_person'),
											'person_contact' => $this->input->post('tsp_person_contact'),
											'faulty_time_omc' => '',
											'faulty_date' => '',
											'est_cost' => '',
											'comments' => $this->input->post('start_repair_reason'),
											'action_by_user_type' => "1",
											'action_by_user' => $this->session->userdata('adminid'),
											'action_date' => $date,
										);
										$this->db->where('id', $subasset['id']);
										$this->db->update('installed_subitems', $installing_subitem_data);

										$data = array(
											'asset_id' => $install[0]['asset_id'],
											'installed_id' => $subasset['installed_id'],
											'installed_subitem_id' => $subasset['id'],
											'item_id' => $subasset['item_id'],
											'subitem_id' => $subasset['subitem_id'],
											'serial_no' => $subasset['serial_no'],
											'identification_no' => $subasset['identification_no'],
											'is_sub_item' => 1,
											'transaction_type' => "13",
											'route' => $subasset['route'],
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
										$this->db->insert('asset_transaction', $data);
									}
								}
								//  if($install[0]['have_sub_items']==0){

								// 			$data = array(
								// 				'asset_id' => $install[0]['asset_id'],
								// 				'installed_id' => $id,
								// 				'item_id' => $install[0]['name'],
								// 				'serial_no'=>$install[0]['serial_no'],
								// 				'identification_no'=>$install[0]['identification_no'],
								// 				'is_sub_item'=>0,
								// 				'have_sub_items'=>1,
								// 				'transaction_type' => "4",
								// 				'site' => $this->input->post('item_site'),
								// 				'location' => $this->input->post('item_location'),
								// 				'repair_type' => $this->input->post('repair_type'),
								// 				'available' => $this->input->post('item_availability'),
								// 				'user_type' => "1",
								// 				'added_by' => $this->session->userdata('adminid'),
								// 				'action_date' => $date,
								// 				'organisation_type' => 1,
								// 				'organisation' => $this->input->post('repairing_tsp'),
								// 				'organisation_address' => $this->input->post('tsp_address'),
								// 				'repairing_person_type' => $this->input->post('tsp_person_type'),
								// 				'person' => $this->input->post('tsp_person'),
								// 				'person_contact' => $this->input->post('tsp_person_contact'),
								// 				'return_date' => $this->input->post('expected_completion'),
								// 				'action_comments' => $this->input->post('start_repair_reason'),
								// 				);
								// 			 $this->db->insert('asset_transaction',$data);
								// }


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
							echo json_encode(array('response' => true, 'message' => 'Repairing Starts.', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
							exit;
						}
						if ($this->input->post('repairing_company') == "2") {
							$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
							$install_ids = $this->page_data['assets_ids'];
							foreach ($install_ids as $id) {
								$date = date("Y-m-d H:i:s");

								$install = $this->db->get_where('installed_subitems', array('id' => $id))->result_array();

								$assets_data = array('action_status' => '13', 'user_type' => "1", 'checkin_by' => $this->session->userdata('adminid'), 'site' => $this->input->post('item_site'));
								$this->db->where('id', $install[0]['asset_id']);
								$this->db->update('assets', $assets_data);

								$installing_data = array(
									'transaction_type' => "13",
									'user_type' => "1",
									'user_name' => $this->session->userdata('adminid'),
									'action_date' => $date,
								);
								$this->db->where('id', $install[0]['installed_id']);
								$this->db->update('installed_inventory', $installing_data);

								if ($install) {
									$subitems = $this->db->get_where('installed_subitems', array('id' => $install[0]['id']))->result_array();
									foreach ($subitems as $subasset) {

										// $subAsset_data = array
										// (
										// 'action_status' => "4",
										// 'user_type' => "1",
										// 'user' => $this->session->userdata('adminid'),
										// 'action_date' => $date ,
										// );
										// $this->db->where('installed_id',$id);
										// $this->db->update('sub_assets',$subAsset_data);

										$installing_subitem_data = array(
											'transaction_type' => 13,
											'company_type' => '2',
											'company_name' => $this->input->post('outer_company_name'),
											'company_address' => $this->input->post('outer_company_address'),
											'person_name' => $this->input->post('outsider_name'),
											'person_contact' => $this->input->post('outsider_contact'),
											'faulty_time_omc' => '',
											'faulty_date' => '',
											'est_cost' => '',
											'comments' => $this->input->post('start_repair_reason'),
											'action_by_user_type' => "1",
											'action_by_user' => $this->session->userdata('adminid'),
											'action_date' => $date,
										);
										$this->db->where('id', $subasset['id']);
										$this->db->update('installed_subitems', $installing_subitem_data);

										$data = array(
											'asset_id' => $install[0]['asset_id'],
											'installed_id' => $subasset['install_id'],
											'installed_subitem_id' => $subasset['id'],
											'item_id' => $subasset['item_id'],
											'subitem_id' => $subasset['subitem_id'],
											'serial_no' => $subasset['serial_no'],
											'identification_no' => $subasset['identification_no'],
											'is_sub_item' => 1,
											'transaction_type' => "13",
											'route' => $subasset['route'],
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
										$this->db->insert('asset_transaction', $data);
									}
								}
								//  if($install[0]['have_sub_items']==0){
								// 	$data = array(
								// 		'asset_id' => $install[0]['asset_id'],
								// 		'installed_id' => $id,
								// 		'item_id' => $install[0]['name'],
								// 		'serial_no'=>$install[0]['serial_no'],
								// 		'identification_no'=>$install[0]['identification_no'],
								// 		'is_sub_item'=>0,
								// 		'have_sub_items'=>1,
								// 		'transaction_type' => "4",
								// 		'site' => $this->input->post('item_site'),
								// 		'location' => $this->input->post('item_location'),
								// 		'repair_type' => $this->input->post('repair_type'),
								// 		'available' => $this->input->post('item_availability'),
								// 		'user_type' => "1",
								// 		'added_by' => $this->session->userdata('adminid'),
								// 		'action_date' => $date,
								// 		'organisation_type' => 2,
								// 		'organisation' => $this->input->post('outer_company_name'),
								// 		'organisation_address' => $this->input->post('outer_company_address'),
								// 		'person' => $this->input->post('outsider_name'),
								// 		'person_contact' => $this->input->post('outsider_contact'),
								// 		'return_date' => $this->input->post('expected_completion'),
								// 		'action_comments' => $this->input->post('start_repair_reason'),
								// 		);
								// 	$this->db->insert('asset_transaction',$data);
								// }

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
							echo json_encode(array('response' => true, 'message' => 'Repairing Starts.', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
							exit;
						}
					}
				}
			}
		}
		/** component Repair End */

		elseif ($para1 == 'start_repair') {
			$this->page_data['repairs'] = explode(',', $_POST['asset']);
			$repairs = $this->page_data['repairs'];
			$data = array();
			foreach ($repairs as $repair) {
				$data[] = $this->db->get_where('installed_inventory', array('id' => $repair))->result_array();
			}
			$data2 = array();
			foreach ($data as $row) {
				if ($row[0]['transaction_type'] == "4") {
					echo "Selected item already in repairing mode.";
					exit;
				}
				if ($row[0]['transaction_type'] == "5") {
					echo "Selected item's repairing recently completed.";
					exit;
				}
				if ($row[0]['transaction_type'] == "6") {
					echo "Retire item cannot be repair.";
					exit;
				}
			}
			$data3 = array();
			foreach ($repairs as $repair) {
				$installing_names = $this->db->get_where('installed_inventory', array('id' => $repair))->result_array();
				$this->db->select('installed_inventory.name AS temp_id,items.*');
				$this->db->from('installed_inventory');
				$this->db->join('items', 'installed_inventory.name = items.id');
				$this->db->where('installed_inventory.id', $repair);
				$query = $this->db->get();
				$data3[] = $query->result_array();
				$this->page_data['data'] = $data3;
			}

			foreach ($repairs as $repair) {
				$installed_location = $this->db->get_where('installed_inventory', array('id' => $repair))->result_array();
				$locationNames = $this->db->get_where('locations', array('id' => $installed_location[0]['location']))->result_array();
				$siteNames = $this->db->get_where('sites', array('id' => $locationNames[0]['site']))->result_array();
				$this->page_data['sites'] = $siteNames;
				$this->page_data['locations'] = $locationNames;
			}
			$this->page_data['data1'] = $data;
			$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
			$this->load->view('back/inventory/start_repair', $this->page_data);
		} elseif ($para1 == 'start_repair_do') {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('item_site', 'Item Site', 'required|trim');
			$this->form_validation->set_rules('item_location', 'Item Location', 'required|trim');
			$this->form_validation->set_rules('item_availability', 'Item Availability', 'required|trim');
			$this->form_validation->set_rules('repair_type', 'Repair Type', 'required|trim');
			$this->form_validation->set_rules('expected_completion', 'Expected Repair Completion Date', 'required|trim');
			$this->form_validation->set_rules('start_repair_reason', 'Reason For Repairing', 'required|trim');

			if ($this->form_validation->run() == TRUE) {
				if ($this->session->userdata('adminid')) {

					if ($this->input->post('repair_type') == 2) {
						$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
						$install_ids = $this->page_data['assets_ids'];

						foreach ($install_ids as $id) {
							$date = date("Y-m-d H:i:s");

							$install = $this->db->get_where('installed_inventory', array('id' => $id))->result_array();
							$ast_mfg = $this->db->get_where('assets', array('id' => $install[0]['asset_id']))->result_array();

							$assets_data = array('action_status' => '4', 'user_type' => "1", 'checkin_by' => $this->session->userdata('adminid'), 'site' => $this->input->post('item_site'));
							$this->db->where('id', $install[0]['asset_id']);
							$this->db->update('assets', $assets_data);

							$installing_data = array(
								'transaction_type' => "4",
								'user_type' => "1",
								'user_name' => $this->session->userdata('adminid'),
								'action_date' => $date,
							);
							$this->db->where('id', $id);
							$this->db->update('installed_inventory', $installing_data);

							if ($install[0]['have_sub_items'] == 1) {
								$subitems = $this->db->get_where('installed_subitems', array('installed_id' => $install[0]['id']))->result_array();
								foreach ($subitems as $subasset) {

									$installing_subitem_data = array(
										'transaction_type' => 4,
										'company_type' => '3',
										'company_name' => $ast_mfg[0]['manufacturer'],
										'company_address' => 'see manufacturer address',
										'company_person_type' => $this->input->post('tsp_person_type'),
										'person_name' => 'manufacturer focal person does not exist',
										'person_contact' => 'not available',
										'faulty_time_omc' => '',
										'faulty_date' => '',
										'est_cost' => '',
										'comments' => $this->input->post('start_repair_reason'),
										'action_by_user_type' => "1",
										'action_by_user' => $this->session->userdata('adminid'),
										'action_date' => $date,
									);
									$this->db->where('id', $subasset['id']);
									$this->db->update('installed_subitems', $installing_subitem_data);

									$data = array(
										'asset_id' => $install[0]['asset_id'],
										'installed_id' => $id,
										'installed_subitem_id' => $subasset['id'],
										'item_id' => $subasset['item_id'],
										'subitem_id' => $subasset['subitem_id'],
										'serial_no' => $subasset['serial_no'],
										'identification_no' => $subasset['identification_no'],
										'is_sub_item' => 1,
										'transaction_type' => 4,
										'route' => $subasset['route'],
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
									$this->db->insert('asset_transaction', $data);
								}
							}
							if ($install[0]['have_sub_items'] == 0) {

								$data = array(
									'asset_id' => $install[0]['asset_id'],
									'installed_id' => $id,
									'item_id' => $install[0]['name'],
									'serial_no' => $install[0]['serial_no'],
									'identification_no' => $install[0]['identification_no'],
									'is_sub_item' => 0,
									'have_sub_items' => 0,
									'transaction_type' => 4,
									'route' => $install[0]['route'],
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
								$this->db->insert('asset_transaction', $data);
							}

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
							// $counter++;
						}
						echo json_encode(array('response' => true, 'message' => 'Repairing Starts.', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
						exit;
					}

					if ($this->input->post('repair_type') == 1) {
						if ($this->input->post('repairing_company') == "1") {
							$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
							$install_ids = $this->page_data['assets_ids'];

							foreach ($install_ids as $id) {
								$date = date("Y-m-d H:i:s");

								$install = $this->db->get_where('installed_inventory', array('id' => $id))->result_array();

								$assets_data = array('action_status' => '4', 'user_type' => "1", 'checkin_by' => $this->session->userdata('adminid'), 'site' => $this->input->post('item_site'));
								$this->db->where('id', $install[0]['asset_id']);
								$this->db->update('assets', $assets_data);

								$installing_data = array(
									'transaction_type' => "4",
									'user_type' => "1",
									'user_name' => $this->session->userdata('adminid'),
									'action_date' => $date,
								);
								$this->db->where('id', $id);
								$this->db->update('installed_inventory', $installing_data);

								if ($install[0]['have_sub_items'] == 1) {
									$subitems = $this->db->get_where('installed_subitems', array('installed_id' => $install[0]['id']))->result_array();
									foreach ($subitems as $subasset) {

										$installing_subitem_data = array(
											'transaction_type' => 4,
											'company_type' => '1',
											'company_name' => $this->input->post('repairing_tsp'),
											'company_address' => $this->input->post('tsp_address'),
											'company_person_type' => $this->input->post('tsp_person_type'),
											'person_name' => $this->input->post('tsp_person'),
											'person_contact' => $this->input->post('tsp_person_contact'),
											'faulty_time_omc' => '',
											'faulty_date' => '',
											'est_cost' => '',
											'comments' => $this->input->post('start_repair_reason'),
											'action_by_user_type' => "1",
											'action_by_user' => $this->session->userdata('adminid'),
											'action_date' => $date,
										);
										$this->db->where('id', $subasset['id']);
										$this->db->update('installed_subitems', $installing_subitem_data);

										$data = array(
											'asset_id' => $install[0]['asset_id'],
											'installed_id' => $id,
											'installed_subitem_id' => $subasset['id'],
											'item_id' => $subasset['item_id'],
											'subitem_id' => $subasset['subitem_id'],
											'serial_no' => $subasset['serial_no'],
											'identification_no' => $subasset['identification_no'],
											'is_sub_item' => 1,
											'transaction_type' => "4",
											'route' => $subasset['route'],
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
										$this->db->insert('asset_transaction', $data);
									}
								}
								if ($install[0]['have_sub_items'] == 0) {
									$data = array(
										'asset_id' => $install[0]['asset_id'],
										'installed_id' => $id,
										'item_id' => $install[0]['name'],
										'serial_no' => $install[0]['serial_no'],
										'identification_no' => $install[0]['identification_no'],
										'is_sub_item' => 0,
										'have_sub_items' => 0,
										'transaction_type' => "4",
										'route' => $install[0]['route'],
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
									$this->db->insert('asset_transaction', $data);
								}

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
							echo json_encode(array('response' => true, 'message' => 'Repairing Starts.', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
							exit;
						}
						if ($this->input->post('repairing_company') == "2") {
							$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
							$install_ids = $this->page_data['assets_ids'];
							foreach ($install_ids as $id) {
								$date = date("Y-m-d H:i:s");

								$install = $this->db->get_where('installed_inventory', array('id' => $id))->result_array();

								$assets_data = array('action_status' => '4', 'user_type' => "1", 'checkin_by' => $this->session->userdata('adminid'), 'site' => $this->input->post('item_site'));
								$this->db->where('id', $install[0]['asset_id']);
								$this->db->update('assets', $assets_data);

								$installing_data = array(
									'transaction_type' => "4",
									'user_type' => "1",
									'user_name' => $this->session->userdata('adminid'),
									'action_date' => $date,
								);
								$this->db->where('id', $id);
								$this->db->update('installed_inventory', $installing_data);

								if ($install[0]['have_sub_items'] == 1) {
									$subitems = $this->db->get_where('installed_subitems', array('installed_id' => $install[0]['id']))->result_array();
									foreach ($subitems as $subasset) {

										$installing_subitem_data = array(
											'transaction_type' => 4,
											'company_type' => '2',
											'company_name' => $this->input->post('outer_company_name'),
											'company_address' => $this->input->post('outer_company_address'),
											'person_name' => $this->input->post('outsider_name'),
											'person_contact' => $this->input->post('outsider_contact'),
											'faulty_time_omc' => '',
											'faulty_date' => '',
											'est_cost' => '',
											'comments' => $this->input->post('start_repair_reason'),
											'action_by_user_type' => "1",
											'action_by_user' => $this->session->userdata('adminid'),
											'action_date' => $date,
										);
										$this->db->where('id', $subasset['id']);
										$this->db->update('installed_subitems', $installing_subitem_data);

										$data = array(
											'asset_id' => $install[0]['asset_id'],
											'installed_id' => $id,
											'installed_subitem_id' => $subasset['id'],
											'item_id' => $subasset['item_id'],
											'subitem_id' => $subasset['subitem_id'],
											'serial_no' => $subasset['serial_no'],
											'identification_no' => $subasset['identification_no'],
											'is_sub_item' => 1,
											'transaction_type' => "4",
											'route' => $subasset['route'],
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
										$this->db->insert('asset_transaction', $data);
									}
								}
								if ($install[0]['have_sub_items'] == 0) {
									$data = array(
										'asset_id' => $install[0]['asset_id'],
										'installed_id' => $id,
										'item_id' => $install[0]['name'],
										'serial_no' => $install[0]['serial_no'],
										'identification_no' => $install[0]['identification_no'],
										'is_sub_item' => 0,
										'have_sub_items' => 0,
										'transaction_type' => "4",
										'route' => $install[0]['route'],
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
									$this->db->insert('asset_transaction', $data);
								}

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
							echo json_encode(array('response' => true, 'message' => 'Repairing Starts.', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
							exit;
						}
					}
				}
			}
		} elseif ($para1 == 'end_repair') {
			$this->page_data['end_repairs'] = explode(',', $_POST['asset']);
			$end_repairs = $this->page_data['end_repairs'];
			$data = array();
			$asset_transaction = array();
			$quantity = 0;

			foreach ($end_repairs as $repair) {
				$quantity++;
				$data[] = $this->db->get_where('installed_inventory', array('id' => $repair))->result_array();
				$locations[] = $this->db->get_where('asset_transaction', array('installed_id' => $repair, 'transaction_type' => "4", 'site' => $this->session->userdata('site')))->result_array();
			}

			$data2 = array();
			foreach ($data as $row) {
				if ($row[0]['transaction_type'] == "0") {
					echo "Brand New items cannot be repaired.";
					exit;
				}
				if ($row[0]['transaction_type'] == "1") {
					echo "Checked Out item Selected. You cannot reinstall checked out asset.";
					exit;
				}
				if ($row[0]['transaction_type'] == "2") {
					echo "Checked In item Selected. You cannot reinstall checked in asset.";
					exit;
				}
				if ($row[0]['transaction_type'] == "3") {
					echo "Already Installed Equipment can't be Re Installed!";
					exit;
				}
				if ($row[0]['transaction_type'] == "5") {
					echo "Repaired item Selected.Only Repairing Mode items you can select.";
					exit;
				}
				if ($row[0]['transaction_type'] == "6") {
					echo "Retired item Selected.";
					exit;
				}
			}
			foreach ($data as $repair) {
				$locationNames = $this->db->get_where('locations', array('id' => $repair[0]['location']))->result_array();
				$siteNames = $this->db->get_where('sites', array('id' => $repair[0]['site']))->result_array();
				$this->page_data['sites'] = $siteNames;
				$this->page_data['locations'] = $locationNames;
			}

			$data3 = array();
			foreach ($end_repairs as $repair) {
				$installing_names = $this->db->get_where('installed_inventory', array('id' => $repair))->result_array();
				$this->db->select('installed_inventory.name AS temp_id,items.*');
				$this->db->from('installed_inventory');
				$this->db->join('items', 'installed_inventory.name = items.id');
				$this->db->where('installed_inventory.id', $repair);
				$query = $this->db->get();
				$data3[] = $query->result_array();
				$this->page_data['data'] = $data3;
			}

			$this->page_data['data1'] = $data;

			$this->page_data['quantity'] = $quantity;
			$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
			$this->load->view('back/inventory/end_repair', $this->page_data);
		} elseif ($para1 == 'end_repair_do') {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('repair_completion', 'Repair Completed Date', 'required|trim');
			$this->form_validation->set_rules('end_repair_comments', 'Repairing Comments ', 'required|trim');
			$this->form_validation->set_rules('repair_price', 'Repair Cost Price ', 'required|trim');

			if ($this->form_validation->run() == TRUE) {
				if ($this->session->userdata('adminid')) {
					$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
					$asset_ids = $this->page_data['assets_ids'];
					$unit_repair_cost = $this->input->post('repair_price') / $this->input->post('quantity');

					$counter = 0;
					foreach ($asset_ids as $id) {
						$repairing_start = $this->db->select('*')->order_by('id', 'desc')->limit(1)->get_where('asset_transaction', array('installed_id' => $id, 'transaction_type' => 4))->result_array();
						$date = date("Y-m-d H:i:s");

						$installing_data = array(
							'transaction_type' => "9",
							'user_type' => "1",
							'user_name' => $this->session->userdata('adminid'),
							'action_date' => $date,
						);
						$this->db->where('id', $id);
						$this->db->update('installed_inventory', $installing_data);
						if ($repairing_start[0]['is_sub_item'] == 1) {
							$subitems = $this->db->get_where('installed_subitems', array('installed_id' => $repairing_start[0]['installed_id']))->result_array();
							foreach ($subitems as $subasset) {
								$installing_subitem_data = array(
									'transaction_type' => 9,
									'company_type' => '2',
									'company_name' => $this->input->post('outer_company_name'),
									'company_address' => $this->input->post('outer_company_address'),
									'person_name' => $this->input->post('outsider_name'),
									'person_contact' => $this->input->post('outsider_contact'),
									'faulty_time_omc' => '',
									'faulty_date' => '',
									'est_cost' => '',
									'comments' => $this->input->post('start_repair_reason'),
									'action_by_user_type' => "1",
									'action_by_user' => $this->session->userdata('adminid'),
									'action_date' => $date,
								);
								$this->db->where('id', $subasset['id']);
								$this->db->update('installed_subitems', $installing_subitem_data);

								$this->db->where('identification_no', $subasset['identification_no']);
								$this->db->delete('faulty_equipment_list');

								$data = array(
									'asset_id' => $subasset['asset_id'],
									'installed_id' => $subasset['installed_id'],
									'installed_subitem_id' => $subasset['id'],
									'item_id' => $subasset['item_id'],
									'subitem_id' => $subasset['subitem_id'],
									'serial_no' => $subasset['serial_no'],
									'identification_no' => $subasset['identification_no'],
									'unit_repairing_cost' => $this->input->post('repair_price'),
									'is_sub_item' => 1,
									'transaction_type' => "14",
									'route' => $subasset['route'],
									'site' => $subasset['site'],
									'location' => $subasset['location'],
									'user_type' => "1",
									'added_by' => $this->session->userdata('adminid'),
									'action_date' => $date,
									'return_date' => $this->input->post('repair_completion'),
									'action_comments' => $this->input->post('end_repair_comments'),
								);
								$this->db->insert('asset_transaction', $data);
							}
						}
						if ($repairing_start[0]['is_sub_item'] == 0) {

							$this->db->where('identification_no', $repairing_start[0]['identification_no']);
							$this->db->delete('faulty_equipment_list');

							$data = array(
								'asset_id' => $repairing_start[0]['asset_id'],
								'installed_id' => $id,
								'installed_subitem_id' => $subasset['id'],
								'item_id' => $subasset['item_id'],
								'subitem_id' => $subasset['subitem_id'],
								'serial_no' => $subasset['serial_no'],
								'identification_no' => $subasset['identification_no'],
								'unit_repairing_cost' => $this->input->post('repair_price'),
								'is_sub_item' => 0,
								'transaction_type' => "14",
								'route' => $subasset['route'],
								'site' => $subasset['site'],
								'location' => $subasset['location'],
								'user_type' => "1",
								'added_by' => $this->session->userdata('adminid'),
								'action_date' => $date,
								'return_date' => $this->input->post('repair_completion'),
								'action_comments' => $this->input->post('end_repair_comments'),
							);
						}
						$counter++;
						$assets_data = array('action_status' => '9', 'site' => $this->input->post('item_site'));
						$this->db->where('id', $repairing_start[0]['asset_id']);
						$this->db->update('assets', $assets_data);
						$this->db->insert('asset_transaction', $data);
					}
					echo json_encode(array('response' => true, 'message' => 'Repairing Completed.', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
					exit;
				}
			}
		} elseif ($para1 == 'component_end_repair') {
			$this->page_data['repairs'] = explode(',', $_POST['asset']);
			$repairs = $this->page_data['repairs'];
			$data = array();
			foreach ($repairs as $repair) {
				$data[] = $this->db->get_where('installed_subitems', array('id' => $repair))->result_array();
			}
			$data2 = array();
			foreach ($data as $row) {
				if ($row[0]['transaction_type'] == "14") {
					echo "Selected comp already reinstalled";
					exit;
				}
				if ($row[0]['transaction_type'] == "4") {
					echo "Selected item already in repairing mode.";
					exit;
				}
				if ($row[0]['transaction_type'] == "5") {
					echo "Selected item's repairing recently completed.";
					exit;
				}
				if ($row[0]['transaction_type'] == "6") {
					echo "Retire item cannot be repair.";
					exit;
				}
			}
			$data3 = array();
			foreach ($repairs as $repair) {
				$installing_names = $this->db->get_where('installed_subitems', array('id' => $repair))->result_array();
				$this->db->select('installed_subitems.subitem_id AS temp_id,sub_items.*');
				$this->db->from('installed_subitems');
				$this->db->join('sub_items', 'installed_subitems.subitem_id = sub_items.id');
				$this->db->where('installed_subitems.id', $repair);
				$query = $this->db->get();
				$data3[] = $query->result_array();
				$this->page_data['data'] = $data3;
			}

			foreach ($repairs as $repair) {
				$installed_location = $this->db->get_where('installed_subitems', array('id' => $repair))->result_array();
				$locationNames = $this->db->get_where('locations', array('id' => $installed_location[0]['location']))->result_array();
				$siteNames = $this->db->get_where('sites', array('id' => $locationNames[0]['site']))->result_array();
				$this->page_data['sites'] = $siteNames;
				$this->page_data['locations'] = $locationNames;
			}
			$this->page_data['data1'] = $data;
			$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
			$this->load->view('back/inventory/reinstall_component', $this->page_data);
		} elseif ($para1 == 'component_reinstall_do') {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('repair_price', 'Repair Price', 'required|trim');
			$this->form_validation->set_rules('repair_completion', 'Repair Completion Date', 'required|trim');
			$this->form_validation->set_rules('end_repair_comments', 'Reason For Repairing', 'required|trim');

			if ($this->form_validation->run() == TRUE) {
				if ($this->session->userdata('adminid')) {
					$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
					$install_ids = $this->page_data['assets_ids'];
					foreach ($install_ids as $id) {
						$date = date("Y-m-d H:i:s");

						$install = $this->db->get_where('installed_subitems', array('id' => $id))->result_array();
						$ast_mfg = $this->db->get_where('assets', array('id' => $install[0]['asset_id']))->result_array();
						$assets_data = array('action_status' => '14', 'user_type' => "1", 'checkin_by' => $this->session->userdata('adminid'), 'site' => $install[0]['site']);
						$this->db->where('id', $install[0]['asset_id']);
						$this->db->update('assets', $assets_data);

						$installing_data = array(
							'transaction_type' => "14",
							'user_type' => "1",
							'user_name' => $this->session->userdata('adminid'),
							'action_date' => $date,
						);
						$this->db->where('id', $install[0]['installed_id']);
						$this->db->update('installed_inventory', $installing_data);

						$subitems = $this->db->get_where('installed_subitems', array('id' => $install[0]['id']))->result_array();
						foreach ($subitems as $subasset) {
							$installing_subitem_data = array(
								'transaction_type' => 14,
								'company_type' => '',
								'company_name' => '',
								'company_address' => '',
								'person_name' => '',
								'person_contact' => '',
								'faulty_time_omc' => '',
								'faulty_date' => '',
								'est_cost' => '',
								'comments' => $this->input->post('end_repair_comments'),
								'action_by_user_type' => "1",
								'action_by_user' => $this->session->userdata('adminid'),
								'action_date' => $date,
							);
							$this->db->where('id', $subasset['id']);
							$this->db->update('installed_subitems', $installing_subitem_data);

							$this->db->where('identification_no', $subasset['identification_no']);
							$this->db->delete('faulty_equipment_list');

							$data = array(
								'asset_id' => $install[0]['asset_id'],
								'installed_id' => $id,
								'installed_subitem_id' => $subasset['id'],
								'item_id' => $subasset['item_id'],
								'subitem_id' => $subasset['subitem_id'],
								'serial_no' => $subasset['serial_no'],
								'identification_no' => $subasset['identification_no'],
								'unit_repairing_cost' => $this->input->post('repair_price'),
								'is_sub_item' => 1,
								'transaction_type' => "14",
								'route' => $subasset['route'],
								'site' => $subasset['site'],
								'location' => $subasset['location'],
								'user_type' => "1",
								'added_by' => $this->session->userdata('adminid'),
								'action_date' => $date,
								'return_date' => $this->input->post('repair_completion'),
								'action_comments' => $this->input->post('end_repair_comments'),
							);
							$this->db->insert('asset_transaction', $data);
						}
					}
					echo json_encode(array('response' => true, 'message' => 'comp Reinstalled .', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
					exit;
				}
			}
		} elseif ($para1 == 'retire') {
			$this->page_data['retiring_assets'] = explode(',', $_POST['asset']);
			$retiring_items = $this->page_data['retiring_assets'];

			$data = array();
			foreach ($retiring_items as $item) {
				$data[] = $this->db->get_where('installed_inventory', array('id' => $item))->result_array();
			}

			$data2 = array();
			foreach ($data as $row) {
				if ($row[0]['transaction_type'] == "0") {
					echo "Brand New  Items cannot be Retire .";
					exit;
				}
				if ($row[0]['transaction_type'] == "1") {
					echo "Checked Out Items cannot be Retire .";
					exit;
				}
				if ($row[0]['transaction_type'] == "4") {
					echo "Repairing Items cannot be Retire .";
					exit;
				}
				if ($row[0]['transaction_type'] == "6") {
					echo "Already Retired Items cannot be Retire .";
					exit;
				}
			}
			$data3 = array();
			foreach ($retiring_items as $item) {
				$installing_names = $this->db->get_where('installed_inventory', array('id' => $item))->result_array();
				$this->db->select('installed_inventory.name AS temp_id,items.*');
				$this->db->from('installed_inventory');
				$this->db->join('items', 'installed_inventory.name = items.id');
				$this->db->where('installed_inventory.id', $item);
				$query = $this->db->get();
				$data3[] = $query->result_array();
			}
			$this->page_data['data'] = $data3;

			$this->page_data['data1'] = $data;
			$this->page_data['sites'] = $this->db->get_where('sites', array('id' => $data[0][0]['site']))->result_array();

			$this->load->view('back/inventory/retire', $this->page_data);
		} elseif ($para1 == 'retire_do') {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('retire_type', 'Retire Type', 'required|trim');
			$this->form_validation->set_rules('site_id', 'Site', 'required|trim');
			$this->form_validation->set_rules('retire_date', 'Retire Date', 'required|trim');
			$this->form_validation->set_rules('retire_reason', 'Retire Reason ', 'required|trim');

			if ($this->form_validation->run() == TRUE) {
				if ($this->session->userdata('adminid')) {
					$this->page_data['assets_ids'] = explode(',', $_POST['asset_id']);
					$install_ids = $this->page_data['assets_ids'];

					foreach ($install_ids as $id) {
						$installed_inventory = $this->db->get_where('installed_inventory', array('id' => $id))->result_array();

						$date = date("Y-m-d H:i:s");
						$installing_data = array(
							'transaction_type' => "6",
							'user_type' => "1",
							'user_name' => $this->session->userdata('adminid'),
							'action_date' => $date,
						);
						$this->db->where('id', $id);
						$this->db->update('installed_inventory', $installing_data);

						$assets_data = array('action_status' => '6', 'user_type' => "1", 'checkin_by' => $this->session->userdata('adminid'), 'site' => $this->input->post('site_id'));
						$this->db->where('id', $installed_inventory[0]['asset_id']);
						$this->db->update('assets', $assets_data);

						if ($installed_inventory[0]['have_sub_items'] == 1) {
							$subitems = $this->db->get_where('installed_subitems', array('installed_id' => $installed_inventory[0]['id']))->result_array();
							foreach ($subitems as $subasset) {
								$installing_subitem_data = array(
									'transaction_type' => 6,
									'user_type' => "1",
									'user_name' => $this->session->userdata('adminid'),
									'action_date' => $date,
								);
								$this->db->where('id', $subasset['id']);
								$this->db->update('installed_subitems', $installing_subitem_data);

								$this->db->where('identification_no', $subasset['identification_no']);
								$this->db->delete('faulty_equipment_list');

								$data = array(
									'asset_id' => $installed_inventory[0]['asset_id'],
									'installed_id' => $id,
									'installed_subitem_id' => $subasset['id'],
									'item_id' => $subasset['item_id'],
									'subitem_id' => $subasset['subitem_id'],
									'serial_no' => $subasset['serial_no'],
									'identification_no' => $subasset['identification_no'],
									'is_sub_item' => 1,
									'transaction_type' => "6",
									'action_date' => $date,
									'retire_type' => $this->input->post('retire_type'),
									'route' => $subasset['route'],
									'site' => $this->input->post('site_id'),
									'retire_date' => $this->input->post('retire_date'),
									'action_comments' => $this->input->post('retire_reason')
								);
								$this->db->insert('asset_transaction', $data);
							}
						}
						if ($installed_inventory[0]['have_sub_items'] == 0) {

							$this->db->where('identification_no', $installed_inventory[0]['identification_no']);
							$this->db->delete('faulty_equipment_list');

							$data = array(
								'installed_id' => $id,
								'asset_id' => $installed_inventory[0]['asset_id'],
								'item_id' => $installed_inventory[0]['name'],
								'serial_no' => $installed_inventory[0]['serial_no'],
								'identification_no' => $installed_inventory[0]['identification_no'],
								'transaction_type' => "6",
								'retire_type' => $this->input->post('retire_type'),
								'route' => $installed_inventory[0]['route'],
								'site' => $this->input->post('site_id'),
								'retire_date' => $this->input->post('retire_date'),
								'user_type' => "1",
								'added_by' => $this->session->userdata('adminid'),
								'action_date' => $date,
								'action_comments' => $this->input->post('retire_reason')
							);
							$this->db->insert('asset_transaction', $data);
						}
					}
					echo json_encode(array('response' => true, 'message' => 'Retired.', 'is_redirect' => True, 'redirect_url' => base_url() . 'inventory/first_page'));
					exit;
				}
			}
		} elseif ($para1 == 'change_role') {
			if ($para2 == 1) {
				$admins = $this->db->get('admin')->result_array();
				echo json_encode($admins);
			} elseif ($para2 == 2) {
				$members = $this->db->get('member')->result_array();
				echo json_encode($members);
			} elseif ($para2 == 3) {
				$supervisors = $this->db->get('tpsupervisor')->result_array();
				echo json_encode($supervisors);
			} else {
				echo "please Select the User Role";
			}
		} elseif ($para1 == 'repairing_tsp') {
			$tsp = $this->db->get_where('tsp', array('id' => $para2))->result_array();
			$tsp[0]['address'];
			if ($para3 == "1") {
				$person_names = $this->db->get_where('admin', array('tsp' => $para2))->result_array();
				if ($person_names) {
					$data = array('person_names' => $person_names, 'address' => $tsp[0]['address']);
					echo json_encode($data);
				} else {
					echo json_encode("No Person exist of This TSP.");
				}
			}
			if ($para3 == "2") {
				$person_names = $this->db->get_where('member', array('tsp' => $para2))->result_array();
				if ($person_names) {
					$data = array('person_names' => $person_names, 'address' => $tsp[0]['address']);
					echo json_encode($data);
				} else {
					echo json_encode("No Person exist of This TSP.");
				}
			}
			if ($para3 == "3") {
				$person_names = $this->db->get_where('tpsupervisor', array('tsp' => $para2))->result_array();
				if ($person_names) {
					$data = array('person_names' => $person_names, 'address' => $tsp[0]['address']);
					echo json_encode($data);
				} else {
					echo json_encode("No Person exist of This TSP.");
				}
			}
		} elseif ($para1 == 'person_contact') {
			if ($para2 == "1") {
				$person_contact = $this->db->get_where('admin', array('id' => $para3))->result_array();
				if ($person_contact) {
					$data = array('contact' => $person_contact[0]['contact']);
					echo json_encode($data);
				} else {
					echo json_encode("No Contact exist of This User.");
				}
			}
			if ($para2 == "2") {
				$person_contact = $this->db->get_where('member', array('id' => $para3))->result_array();
				if ($person_contact) {
					$data = array('contact' => $person_contact[0]['contact']);
					echo json_encode($data);
				} else {
					echo json_encode("No contact exist of This Person.");
				}
			}
			if ($para2 == "3") {
				$person_contact = $this->db->get_where('tpsupervisor', array('id' => $para3))->result_array();
				if ($person_contact) {
					$data = array('contact' => $person_contact[0]['contact']);
					echo json_encode($data);
				} else {
					echo json_encode("No contact exist of This person.");
				}
			}
		} elseif ($para1 == 'extend_checkout') {
			$this->load->view('back/inventory/extend_checkout');
		} elseif ($para1 == 'assets_publish_set') {
			$article = $para2;
			if ($para3 == 'true') {
				$data['status'] = '1';
			} else {
				$data['status'] = '0';
			}
			$this->db->where('id', $article);
			$this->db->update('assets', $data);
			echo $para3;
		} else {
			$this->page_data['page'] = 'assets';
			$this->load->view('back/inventory/first_page', $this->page_data);
		}
	}
	/** Assets area END */

	/** Asset or Item Type Changing with ajax Start */
	public function asset_type($para1 = '')
	{
		$items = $this->db->get_where('items', array('item_type' => $para1))->result_array();
		if ($items) {
			$data = array('items' => $items);
			echo json_encode($data);
		} else {
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

	public function specific_asset($para1 = '', $para2 = '')
	{
		if ($para1 == 'list') {
			$this->page_data['assets'] = $this->db->get_where('assets', array('id' => $para2))->result_array();
			$this->load->view('back/inventory/display_assets', $this->page_data);
		} else {
			$this->page_data['page'] = 'specific_asset';
			$this->page_data['asset_id'] = $para1;
			$this->load->view('back/includes/header', $this->page_data);
			$this->load->view('back/inventory/specific_asset', $this->page_data);
			$this->load->view('back/includes/footer', $this->page_data);
		}
	}
	/** Site related Locations START */
	public function site_related_locations($para1 = '')
	{
		$locations = $this->db->get_where('locations', array('site' => $para1))->result_array();
		echo json_encode($locations);
	}
	/** Site related Locations END */


	public function asset_history($para1 = '', $para2 = '', $para3 = '')
	{
		$this->page_data['page'] = 'selected_assets';
		if (!$this->session->userdata('adminid')) {
			return redirect('admin/login');
		}
		if ($para1 == 'list') {
			$this->page_data['asset_transactions'] = $this->db->select('*')->where('asset_id', $para2)->order_by('id', 'desc')->get('asset_transaction')->result_array();
			$this->load->view('back/inventory/asset_history', $this->page_data);
		}
	}

	public function filterby_item_type($para1 = '')
	{
		$this->page_data['assets'] = $this->db->get_where('assets', array('item_type' => $para1))->result_array();
		$this->page_data['sites'] = $this->Inventory_model->getsites();
		$this->page_data['items'] = $this->Inventory_model->get_Items();
		$this->page_data['asset_transactions'] = $this->Inventory_model->get_asset_transactions();
		$this->load->view('back/inventory/display_assets', $this->page_data);
	}

	public function filterby_site($para1 = '')
	{
		$this->page_data['assets'] = $this->db->get_where('assets', array('site' => $para1))->result_array();
		$this->page_data['sites'] = $this->Inventory_model->getsites();
		$this->page_data['items'] = $this->Inventory_model->get_Items();
		$this->page_data['asset_transactions'] = $this->Inventory_model->get_asset_transactions();
		$this->load->view('back/inventory/display_assets', $this->page_data);
	}

	public function installed_filterby_site($para1 = '')
	{
		$this->page_data['installs'] = $this->db->get_where('installed_inventory', array('site' => $para1))->result_array();
		$this->page_data['sites'] = $this->Inventory_model->getsites();
		$this->page_data['items'] = $this->Inventory_model->get_Items();
		$this->page_data['asset_transactions'] = $this->Inventory_model->get_asset_transactions();
		$this->load->view('back/inventory/display_installed', $this->page_data);
	}

	public function equip_has_comp_or_not($para1 = '')
	{
		$comps = $this->Inventory_model->item_has_subitems_or_not($para1);
		if (isset($comps)) {
			$data = $comps;
			echo json_encode($data);
		}
	}
	/** pagination Start */
	function pagination_data($para1 = '')
	{
		$table = $para1;
		$columns = array(
			0 => 'id',
			1 => 'name',
			2 => 'serial_no',
			3 => 'identification_no',
			4 => 'transaction_type',
			5 => 'site',
			6 => 'location'
		);

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = @$columns[$this->input->post('order')[0]['column']];
		$dir = @$this->input->post('order')[0]['dir'];

		$totalData = $this->Inventory_model->count_inventory($table);

		$totalFiltered = $totalData;

		if (empty($this->input->post('search')['value'])) {
			$inventory_rows = $this->Inventory_model->allposts($limit, $start, $order, $dir, $table);
		} else {
			$search = $this->input->post('search')['value'];
			$inventory_rows =  $this->Inventory_model->allposts_search($limit, $start, $search, $order, $dir, $table);

			$totalFiltered = $this->Inventory_model->count_inventory_search($search, $table);
		}
		// echo "<pre>";
		// print_r($inventory_rows);
		// exit;
		$records = array();
		$counter = 0;
		$cnt = 0;
		// $sr_no = $cnt+$sr_no
		foreach ($inventory_rows as $row) {
			$itemName = $this->db->get_where('items', array('id' => $row->name))->result_array();
			$siteName = $this->db->get_where('sites', array('id' => $row->site))->result_array();
			$locationName = $this->db->get_where('locations', array('id' => $row->location))->result_array();
			$start++;
			$records[$counter]['counter'] = '<input type="checkbox" onchange="console.log(this.getAttribute(value))" name="selection" id="ischecked" class="selection" value=' . $row->id . '> <span style="color: green;font-size:25px;" >' .  $start . '</span>';
			$records[$counter]['serial'] = $row->serial_no;
			$records[$counter]['identification_no'] = $row->identification_no;
			$records[$counter]['name'] = '<a href="#" onclick="show_asset(\'' . base_url() . 'inventory/selected_install/list/' . $row->id . '/\',\'display_selected_install\');"
			data-toggle="modal" data-target="#inventoryModal">' . $itemName[0]['name'] . '</a>';
			if ($row->transaction_type == '3') {
				$records[$counter]['transaction_type'] = '<span class="text-success" > Installed</span>';
			}
			if ($row->transaction_type == '4') {
				$records[$counter]['transaction_type'] = '<span class="text-success" > Faulty</span>';
			}
			if ($row->transaction_type == '5') {
				$records[$counter]['transaction_type'] = '<span class="text-success" > Repaired</span>';
			}
			if ($row->transaction_type == '6') {
				$records[$counter]['transaction_type'] = '<span class="text-success" > Retired</span>';
			}
			if ($row->transaction_type == '9') {
				$records[$counter]['transaction_type'] = '<span class="text-success" > Re Installed</span>';
			}
			if ($row->transaction_type == '10') {
				$records[$counter]['transaction_type'] = '<span class="text-success" > Faulty</span>';
			}
			if ($row->transaction_type == '11') {
				$records[$counter]['transaction_type'] = '<span class="text-success" > Component Faulty</span>';
			}
			if ($row->transaction_type == '12') {
				$records[$counter]['transaction_type'] = '<span class="text-success" > Component Replace</span>';
			}
			if ($row->transaction_type == '13') {
				$records[$counter]['transaction_type'] = '<span class="text-success" > Component Repair</span>';
			}
			if ($row->transaction_type == '14') {
				$records[$counter]['transaction_type'] = '<span class="text-success" > Component Reinstall</span>';
			}
			if ($row->transaction_type == '15') {
				$records[$counter]['transaction_type'] = '<span class="text-success" > Component Retire</span>';
			}
			$records[$counter]['site'] = '<span class="text-info" style="font-weight: 600;">' . $siteName[0]['name'] . '</span>';
			$records[$counter]['location'] = '<span class="text-info" style="font-weight: 600;">' . $locationName[0]['location'] . '</span>';
			$counter++;
		}
		// echo "<pre>";
		// print_r($records); exit;
		$json_data = array(
			"draw"            => intval($this->input->post('draw')),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $records
		);
		echo json_encode($json_data);
	}

	function assets_pagination($para1 = '')
	{
		$table = $para1;
		$columns = array(
			0 => 'id',
			1 => 'name',
			2 => 'action_status',
			3 => 'site',
		);

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = @$columns[$this->input->post('order')[0]['column']];
		$dir = @$this->input->post('order')[0]['dir'];

		$totalData = $this->Inventory_model->count_assets($table);

		$totalFiltered = $totalData;

		if (empty($this->input->post('search')['value'])) {
			$asset_rows = $this->Inventory_model->asset_allposts($limit, $start, $order, $dir, $table);
		} else {
			$search = $this->input->post('search')['value'];
			$asset_rows =  $this->Inventory_model->asset_allposts_search($limit, $start, $search, $order, $dir, $table);

			$totalFiltered = $this->Inventory_model->count_assets_search($search, $order, $table);
		}
		$records = array();
		$counter = 0;
		// $start = 0;
		$id = 1;
		// $sr_no = $cnt+$sr_no
		foreach ($asset_rows as $row) {
			$items = $this->db->get_where('assets', array('name' => $row->name))->result_array();
			$itemName = $this->db->get_where('items', array('id' => $row->name))->result_array();
			$siteName = $this->db->get_where('sites', array('id' => $row->site))->result_array();
			$start++;
			if (count($items) > 1) {
				$records[$counter]['counter'] = '<i class="far fa-caret-square-down" data-toggle="collapse" data-parent="tbody<?php echo $counter ?>" data-target="#collapseme" style="cursor:pointer;" onclick="expandCollapse(this,\'expanded_asset\');">
                        <input type="hidden" data-asdf=asdf' . $id . '  id=' . $id . ' value=' . $row->name . '></input>
                    </i>
			<input type="checkbox" onchange="console.log(this.getAttribute(value))" name="selection" id="ischecked" class="selection" value=' . $row->id . '> <span style="color: green;font-size:25px;" >' .  $start . '</span>';
			}
			if (count($items) == 1) {
				$records[$counter]['counter'] = '<input type="checkbox" onchange="console.log(this.getAttribute(value))" name="selection" id="ischecked" class="selection" value=' . $row->id . '> <span style="color: green;font-size:25px;" >' .  $start . '</span>';
			}
			$records[$counter]['name'] = '<a href="#" onclick="show_asset(\'' . base_url() . 'inventory/selected_asset/list/' . $row->id . '/\',\'display_selected_asset\');">' . $itemName[0]['name'] . '</a>';
			if ($row->action_status == '0') {
				$records[$counter]['action_status'] = '<span class="text-success" > Brand New</span>';
			}
			if ($row->action_status == '3') {
				$records[$counter]['action_status'] = '<span class="text-success" > Installed</span>';
			}
			if ($row->action_status == '4') {
				$records[$counter]['action_status'] = '<span class="text-success" > Faulty</span>';
			}
			if ($row->action_status == '5') {
				$records[$counter]['action_status'] = '<span class="text-success" > Repaired</span>';
			}
			if ($row->action_status == '6') {
				$records[$counter]['action_status'] = '<span class="text-success" > Retired</span>';
			}
			if ($row->action_status == '9') {
				$records[$counter]['action_status'] = '<span class="text-success" > Re Installed</span>';
			}
			if ($row->action_status == '10') {
				$records[$counter]['action_status'] = '<span class="text-success" > Faulty</span>';
			}
			if ($row->action_status == '11') {
				$records[$counter]['action_status'] = '<span class="text-success" > Component Faulty</span>';
			}
			if ($row->action_status == '12') {
				$records[$counter]['action_status'] = '<span class="text-success" > Component Replace</span>';
			}
			if ($row->action_status == '13') {
				$records[$counter]['action_status'] = '<span class="text-success" > Component Repair</span>';
			}
			if ($row->action_status == '14') {
				$records[$counter]['action_status'] = '<span class="text-success" > Component Reinstall</span>';
			}
			if ($row->action_status == '15') {
				$records[$counter]['action_status'] = '<span class="text-success" > Component Retire</span>';
			}
			$records[$counter]['site'] = '<span class="text-info" style="font-weight: 600;">' . $siteName[0]['name'] . '</span>';
			$counter++;
			$id++;
		}
		// echo "<pre>";
		// print_r($records); exit;
		$json_data = array(
			"draw"            => intval($this->input->post('draw')),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $records
		);
		echo json_encode($json_data);
	}
	/** pagination End */
}
