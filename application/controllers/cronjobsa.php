<?php 
defined('BASEPATH') OR EXIT('NO DIRECT SCRIPT ALLOWED');

class Cronjobs extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->page_data = array();
	}

	public function index()
	{
        $getfile =  str_replace('-', '',date('d-m-Y'));
        $weigh = $this->db->get_where('weighstation',array('status' => 1))->result_array();
        $ins_data = array();
        if($weigh){
            foreach ($weigh as $row) {
                $id = $row['id'];
                $date = date('Y-m-d');
                $query = $this->db->query("SELECT COUNT(id) as count_id
                               FROM weighstation_data
                               WHERE weigh_id = '$id' AND date = '$date'");
                $c = $query->row()->count_id;
                //echo $this->db->last_query(); exit;
                $dir = "\\\\".$row['ipaddress']."\\daw300nt\\data\\";
                $file = $dir.$getfile.".dat";
                $file1 = $dir.$getfile.".inf";
                $data = file_get_contents($file);
                $data1 = file_get_contents($file1);
                $data_exp = explode(PHP_EOL , $data);
                //echo "<pre>";
                //print_r($data_exp); exit;
                $sku = array_slice(array_values(array_filter($data_exp)), $c) ;
                $array = '';
                foreach ($sku as $value) {
                    $array[] = explode(';', $value);
                }
                //unset($array[0]);
                $data_final = $array;
                //echo "<pre>";
                //print_r($data_final); exit;
                $data1_exp = explode(',', $data1);
                
                $data1_final = array_chunk($data1_exp, 13);
                if(!empty($data_final)){
                    foreach ($data_final as $key => $rowval) {
                        $ins_data[$key]['weigh_id'] = $row['id'];
                        $ins_data[$key]['date'] = date('Y-m-d');
                        $ins_data[$key]['time'] = $rowval[3];
                        $ins_data[$key]['ticket_no'] = $rowval[1];
                        $ins_data[$key]['vehicle_no'] = $rowval[2];
                        $type = mb_substr(trim($rowval[5]), 0, 1);
                        $ins_data[$key]['type'] = $type;
                        $weight = 0;
                        for ($i = 8; $i < 8 + $type ; $i++) {
                            $weight += $rowval[$i];
                        }
                        $ins_data[$key]['weight'] = $weight;
                        $ins_data[$key]['exces_weight'] = $rowval[7];
                        $ins_data[$key]['percent_overload'] = 0;//$row['id'];
                        //$key = false;
                        $search = $rowval[1];
                        $ins_data[$key]['haulier'] = '';
                        $ins_data[$key]['fine'] = '';
                        foreach($data1_final as $val){

                        if(@$val[1] == $search){
                            $ins_data[$key]['haulier'] = trim(preg_replace('/[0-9.]+/', '', $val[4]));
                            $ins_data[$key]['fine'] = $val[11];;
                        }

                        }



                    }
                }
               
                
            }
            if($ins_data){
              $this->db->insert_batch('weighstation_data', $ins_data);  
            }
            

        } 
	}

	



}

?>