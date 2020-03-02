<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class tcd_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		//$this->load->library('form_validation');
		//$this->load->helper('form');
		date_default_timezone_set('Asia/Karachi');
	}
	public $table = 'tcd';
	
	public function get_table($table){
		$select = '*';  $column = 'id'; $para = 'DESC';
		$data = $this->database_model->get_select__orderby($select, $table, $column, $para);
		
		return $data;
	}
	public function toolplaza_table($page,$table){
		if($page == 'R'){
			$tcd = $this->get_table($table)->result_array();
			$i = 0;
			$toolplaza = array();
			foreach($tcd as $row){
				$table = 'toolplaza'; $where = array('id' =>$row['toolplaza_id']);
				$toolplaza[$i] = $this->database_model->get_where($table, $where)->row()->name;
				$i++;
			}
		}
		elseif($page == 'C'){
			$toolplaza = $this->db->get('toolplaza')->row()->name;
		}
		return $toolplaza;
	}
	public function check_table($table, $where){
		return $this->db->get_where($table, $where);
	}
	public function postload($table, $where){
		$postload = $tcd = $this->database_model->get_where($table, $where)->result_array();
		$tool = $postload[0]['toolplaza_id']; $date = $postload[0]['datecreated'];
		$toll = 'toolplaza'; $where = array('id' => $tool);
		$postload[0]['plaza_name'] = $this->database_model->get_where($toll, $where)->row()->name;
		$terrif = $this->calculation_model->terrif_value($tool, $date)->result_array();
		$tarrif[0][0]['class_1_value'] = $terrif[0]['class_1_value'];
		$tarrif[0][0]['class_2_value'] = $terrif[0]['class_2_value'];
		$tarrif[0][0]['class_3_value'] = $terrif[0]['class_4_value'];
		$tarrif[0][0]['class_4_value'] = $terrif[0]['class_3_value'];
		$tarrif[0][0]['class_5_value'] = $terrif[0]['class_7_value'];
		$postload[0]['terrif'] = $tarrif;
		
		$postload[0]['calculation'] = $this->calculation_model->revenue_tcd($tcd[0], $tarrif[0]);
		/*?><pre> <?php echo print_r(array($tarrif));exit;*/
		return $postload[0];
	}
	public function _list($tool){
		$this->db->order_by('id','DESC');
		if($tool){
			$this->db->where('toolplaza_id', $tool);
		}
		$tcd = $this->db->get('tcd')->result_array();
		
		return $tcd; 
	}
	
}
		