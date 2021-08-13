<?php
class features extends CI_MODEL{
    function __construct(){
		parent::__construct();		
	}
	public function options(){
		$data = $this->db->select('*')->from('dsr_options')->where('status', 1)->get()->result_array();
		return $data;
	}
	public function options_selected($id){
		$data = $this->db->get_where('dsr_m2m_features_options', array('feature_id' => $id ))->result_array();
		return $data;
	}
	public function generator_log_options_selected($id){
		$data = $this->db->get_where('dsr_m2m_generator_log_features_options', array('feature_id' => $id ))->result_array();
		return $data;
	}
}