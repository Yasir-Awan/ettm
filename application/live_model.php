<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class live_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		//$this->load->library('form_validation');
		//$this->load->helper('form');
		date_default_timezone_set('Asia/Karachi');
	}
	public function total($date){
		$total = $this->db->query('CALL live_total_date(\''.$date.'\')');
		$this->db->next_result();
		return $total;
	}	
}