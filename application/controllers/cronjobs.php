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
        $allowed = $this->db->get('weigh_limit')->result_array();
        foreach($allowed as $key => $val){
            $check_cat[$key] = $val['category_code']; 
        }

        $getfile =  str_replace('-', '',date('d-m-Y'));
        $weigh = $this->db->get_where('weighstation',array('status' => 1))->result_array();
        
        if($weigh){
            foreach ($weigh as $row) {
                $ins_data = array();
                $id = $row['id'];
                $date = date('Y-m-d');
                $query = $this->db->query("SELECT COUNT(id) as count_id
                               FROM weighstation_data
                               WHERE weigh_id = '$id' AND date = '$date'");
                $c = $query->row()->count_id;
                //echo $this->db->last_query(); exit;
               // $dir = "ftp://209.150.153.162/data/";
                if($row['type'] == 1){
                    $dir = "\\\\".$row['address']."\\daw300nt\\data\\";  
                }elseif($row['type'] == 2){
                    $dir = "ftp://".$row['address']."/";
                }
                if($row['type'] == 2){
                  $conn_id = ftp_connect($row['address']);
  
                }elseif($row['type'] == 1){
                    //$fp = @fsockopen($row['address'], 80, $errno, $errstr,5);
                }

               
               
                if ($row['type'] == 2 && !$conn_id) {
                    $log = array();
                    $log['message'] = "Couldn't connect to <b>".$row['name']."</b> weighstation";
                    $log['date'] = time();
                    $log['status'] = 0;
                    $this->db->insert('logs',$log);
                    //echo "ERRO: $errno - $errstr<br />\n"; exit;
                } else {
                    $file = $dir.$getfile.".dat";
                    $file1 = $dir.$getfile.".inf";
              
                if(file_exists($file)){
                    $data = file_get_contents($file);
                    if(file_exists($file1)){
                        $data1 = file_get_contents($file1);
                    }
                    $data_exp = explode(PHP_EOL , $data);
                    $data_exp = array_values(array_filter($data_exp));
                    
                    //$sku = array_slice($data_exp, ($c)) ;
                    $sku = $data_exp;
                    $array = array();
                    foreach ($sku as $value) {
                        $array[] = explode(';', $value);
                    }
                  
                    $data_final = $array;
                    if(file_exists($file1)){
                        $data1 = array_filter(explode(PHP_EOL , $data1));
                    
                    

                        $data1_final = array();
                        foreach($data1 as $key11 => $val11){
                            $data1_final[$key11] = explode(';', $val11);
                       }
                    }
                    // echo "<pre>";
                    // print_r($data11); exit;
                    // $data1_exp = explode(';', $data1);
                    
                    // $data1_final = array_chunk($data1_exp, 8);
                    // echo "<pre>";
                    // print_r($data_final);
                    // echo "<pre>";
                    // print_r($data1_final); exit;
                    if(!empty($data_final)){
                        // echo "<pre>";
                        // print_r($data_final); exit;
                        foreach ($data_final as $key => $rowval) {
                            $cat_code = trim($rowval[7]);
                            $index =  array_search($cat_code, array_column($allowed, 'category_code'));
                            if(in_array($cat_code, $check_cat)){
                                $ins_data[$key]['weigh_id'] = $row['id'];
                                $d = explode('/', $rowval[0]);
                                $datwe = $d[2].'-'.$d[0].'-'.$d[1];
                                $ins_data[$key]['date'] = $datwe;
                                $ins_data[$key]['time'] = $rowval[1];
                                $ins_data[$key]['ticket_no'] = $rowval[4];
                                $ins_data[$key]['vehicle_no'] = $rowval[5];
                                $type = mb_substr(trim($rowval[7]), 0, 1);
                                
                                //echo $cat_code; exit;
                                $ins_data[$key]['type'] = $type;
                                // foreach ($allowed as $allow) {
                                //     if($type == $allow['category_code']){
                                //         $weight_lmit = $allow['weigh_limit'];
                                //     }
                                // }
                                //$arr = array ('first' => 'a', 'second' => 'b', );
                                //$key = array_search ('a', $arr);
                                //print_r(array_column($userdb, 'uid')); 
                                
                                $index =  array_search($cat_code, array_column($allowed, 'category_code'));
                                $weight_lmit = $allowed[$index]['weigh_limit'];
                                
                                // echo '<pre>';
                                // print_r($allowed[$index]);
                                // echo $weight_lmit; exit;
                                $weight = 0;
                                for ($i = 11; $i < 11 + $type ; $i++) {
                                    $weight += $rowval[$i];
                                }

                                $ins_data[$key]['weight'] = $weight;
                                $ins_data[$key]['vehicle_code'] = $cat_code;
                                if($weight_lmit < $weight){
                                    $diff = $weight - $weight_lmit;
                                    $ins_data[$key]['exces_weight'] = $diff;
                                    //$percent =  
                                    $ins_data[$key]['percent_overload'] = round(($diff / $weight_lmit) * 100,2); 
                                    $ins_data[$key]['status'] = 2;
                                }else{
                                    $ins_data[$key]['exces_weight'] = 0; 
                                    $ins_data[$key]['percent_overload'] = 0;
                                    $ins_data[$key]['status'] = 1;
                                }
                                
                                //$row['id'];
                                //$key = false;
                                $search = $rowval[4];
                                $ins_data[$key]['haulier'] = '';
                                $ins_data[$key]['fine'] = '';
                                if(file_exists($file1)){
                                    foreach($data1_final as $val){
                                    //echo "@".trim($val[2])."==".trim($search).".<br>";
                                        if(trim($val[2]) == trim($search)){
                                            
                                            $ins_data[$key]['haulier'] = trim(preg_replace('/[0-9.]+/', '', $val[6]));
                                            $ins_data[$key]['fine'] = trim($val[7]);
                                        }

                                    }
                                }

                            }

                        }
                       
                    }
                }else{
                    $log = array();
                    $log['message'] = "Unable to get data of <b>".$row['name']."</b> weighstation";
                    $log['date'] = time();
                    $log['status'] = 0;
                    $this->db->insert('logs',$log);
                }
                }
                
                
               
               if($ins_data){
                    $ins_data = array_values(array_slice($ins_data, $c));
                    if($ins_data){
                       $this->db->insert_batch('weighstation_data', $ins_data);  
                        $this->db->where('id', $row['id']);
                        $this->db->update('weighstation', array('last_updated' => time()));
                    }
                 
                } 
            }
            
            

        } 
	}

}

?>