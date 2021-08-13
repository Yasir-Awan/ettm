<?php 
defined('BASEPATH') OR EXIT('NO DIRECT SCRIPT ALLOWED');

class Summarize_weigh extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->page_data = array();
	}

   
	 function index(){

    $sql_categories = "SELECT GROUP_CONCAT(code) as code FROM weigh_category GROUP BY axle";
        
    $result_category = $this->db->query($sql_categories)->result_array();
    // echo "<pre>";
    // print_r($result_category); exit;
    $sql = "SELECT count(weighstation_data.ticket_no) as total_records, weighstation.id as weighstation,weighstation.name as weighstation_name, DATE_FORMAT(`date`,'%j') as `date`, date as `dateee`,
    sum(case when weighstation_data.status = 2 then 1 else 0 end) overloaded,
    sum(case when weighstation_data.status = 2 then fine else 0 end) fined,
    sum(case when weighstation_data.status = 2 AND fine = 0 then 1 else 0 end) without_fine,
    sum(case when weighstation_data.status = 2 AND vehicle_code IN (".$result_category[0]['code'] .") then 1 else 0 end) 2ax_overloaded,
    sum(case when weighstation_data.status = 2 AND vehicle_code IN (".$result_category[1]['code'] .") then 1 else 0 end) 3ax_overloaded,
    sum(case when weighstation_data.status = 2 AND vehicle_code IN (".$result_category[2]['code'] .") then 1 else 0 end) 4ax_overloaded,
    sum(case when weighstation_data.status = 2 AND vehicle_code IN (".$result_category[3]['code'] .") then 1 else 0 end) 5ax_overloaded,
    sum(case when weighstation_data.status = 2 AND vehicle_code IN (".$result_category[4]['code'] .") then 1 else 0 end) 6ax_overloaded,
    
    sum(case when weighstation_data.status = 2 then 1 else 0 end) total_vehicles_overloaded,
    sum(case when weighstation_data.status = 1 AND vehicle_code IN (".$result_category[0]['code'] .") then 1 else 0 end) 2ax_inload,
    sum(case when weighstation_data.status = 1 AND vehicle_code IN (".$result_category[1]['code'] .") then 1 else 0 end) 3ax_inload,
    sum(case when weighstation_data.status = 1 AND vehicle_code IN (".$result_category[2]['code'] .") then 1 else 0 end) 4ax_inload,
    sum(case when weighstation_data.status = 1 AND vehicle_code IN (".$result_category[3]['code'] .") then 1 else 0 end) 5ax_inload,
    sum(case when weighstation_data.status = 1 AND vehicle_code IN (".$result_category[4]['code'] .") then 1 else 0 end) 6ax_inload,
    
    sum(case when weighstation_data.status = 1 then 1 else 0 end) total_vehicles_inload

    FROM `weighstation`
    INNER JOIN weighstation_data ON weighstation.id = weighstation_data.weigh_id
    WHERE `date` < '".date('Y-m-01')."'
    GROUP BY YEAR(`date`), MONTH(`date`), DAY(`date`), weigh_id";
    $data = $this->db->query($sql)->result_array(); 
    // echo "<pre>";
    // print_r($data); exit;
    $insert_data = array();
    foreach($data as $row){
      $dir = "D:/weighstations/".$row['weighstation']."";
      if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
      }
      $datstation = $this->db->get_where('weighstation_data',array('weigh_id' => $row['weighstation'],'date' => $row['dateee']))->result_array();
      file_put_contents($dir."/".date('Y-m-d',strtotime($row['dateee'])).".txt", json_encode($datstation));
      $insert_data['weigh_id'] = $row['weighstation'];
      $insert_data['date'] = $row['dateee'];
      $insert_data['total_vehicles'] = $row['total_records'];
      $insert_data['overloaded'] = $row['overloaded'];
      $insert_data['fined'] = $row['fined'];
      $insert_data['without_fine'] = $row['without_fine'];
      $insert_data['in_limit_detail'] = json_encode(array('2ax' => $row['2ax_inload'],'3ax' => $row['3ax_inload'],'4ax' => $row['4ax_inload'],'5ax' => $row['5ax_inload'],'6ax' => $row['6ax_inload'],'total' => $row['total_vehicles_inload']));
      $insert_data['overloaded_detail'] = json_encode(array('2ax' => $row['2ax_overloaded'],'3ax' => $row['3ax_overloaded'],'4ax' => $row['4ax_overloaded'],'5ax' => $row['5ax_overloaded'],'6ax' => $row['6ax_overloaded'],'total' => $row['total_vehicles_overloaded']));;
      $this->db->insert('weighstation_sum',$insert_data);
      $this->db->where('weigh_id',$row['weighstation']);
      $this->db->where('date',$row['dateee']);
      $this->db->delete('weighstation_data');
    }

  
 }

}

?>