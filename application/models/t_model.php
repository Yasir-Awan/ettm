<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class t_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		//$this->load->library('form_validation');
		//$this->load->helper('form');
	}
		//The Database Table
		public $table_name = 'toolplaza';
	
		//Primary Key Field
		public $primary_key = 'id';

		//Filter for Primary Key
		public $primaryFilter = 'intval';


		//Order by Field, Default Order for this model
		public $order_by = '';
	
}