<?php 
defined('BASEPATH') OR EXIT('NO DIRECT SCRIPT ALLOWED');

class Other_crons extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->page_data = array();
	}

   
	public function index()

	{
        $weigh = $this->db->get_where('weighstation',array('status' => 1,'software_type' => 2))->result_array();
        
        if($weigh){
            $sql = "Select weigh_limit.id, cat_id,category_code,weigh_limit,name,axle From weigh_limit Join weigh_category On weigh_limit.category_code = weigh_category.code";
            $res = $this->db->query($sql)->result_array();
            $weighlimit_array = array();
            $cc = 0;

            foreach($res as $row3){
                   $weighlimit_array[$cc]['axle'] = $row3['axle'];
                   $weighlimit_array[$cc]['weigh_limit'] = $row3['weigh_limit'];
                   $weighlimit_array[$cc]['code'] = $row3['category_code'];
                   
                   $cc++;
                   
            }

            
            foreach ($weigh as $row) {
                echo "HAI<br>";
                $ins_data = array();
                $dir = 'ftp://'.$row['address'].'/';
                $conn_id = ftp_connect($row['address']);
                if($conn_id){
                   if($row['file_index']){

                        $file = 'V'.$row['file_index'].'.dat';
                        
                   }else{
                        $files = scandir($dir);

                        $filtered = array_values(array_filter($files, function($car) {
                            return $car[0] == 'V';
                        }));
                        if($filtered){
                           $file = $filtered[0]; 
                        }
                   } 
                   //echo $dir.''.$file; exit;
                   if(file_exists($dir.''.$file)){

                        $counter = 0;
                        for($i = 0; $i< 2; $i++){
                            $file_indexed = preg_replace("/[^0-9]/", "", $file );
                            $new_file = $file_indexed + $i;
                            $fileTs = $dir.'V'.$new_file.'.dat';
                            if(file_exists($fileTs)){
                                $update_file = $new_file;
                                $orgin_file = $new_file;
                                $file_data = file_get_contents($dir.'V'.$new_file.'.dat');
                                $data_exp = array_values(array_filter(explode(PHP_EOL , $file_data)));
                                $result = array_map(function($val) {
                                    return explode(',', $val);
                                }, $data_exp);
                                $ticket_no = 0;
                                ////////To check if all data is of same date or different dates/////
                                
                                $date = date("Y-m-d", filemtime($dir.'V'.$new_file.'.dat'));
                                // echo $date."<br>";
                                // echo $new_file; exit;
                                $id = $row['id'];
                                $c = '';
                                if($row['file_index']){
                                    $query = $this->db->query("SELECT COUNT(id) as count_id
                                    FROM weighstation_data
                                    WHERE weigh_id = '$id' AND date = '$date'");
                                    $c = $query->row()->count_id;
                                }
                                 echo "<pre>";
                                 print_r($result); exit;
                                foreach ($result as $key => $value) {

                                    
                                    if($ticket_no < $value[2] && $value[35] != 0){
                                         $ins_data[$counter]['weigh_id']          = $row['id'];
                                         $ins_data[$counter]['date']              = $date;
                                         $ins_data[$counter]['time']              = $value[1];
                                         $ins_data[$counter]['ticket_no']         = $value[2];
                                         $ins_data[$counter]['vehicle_no']        = $value[3];
                                         $ins_data[$counter]['haulier']           = '';
                                         $weight_ton = $value[34] / 1000;
                                         
                                         $weight_limit = $value[35] / 1000;
                                         $keyyy = array_search($weight_limit, array_column($weighlimit_array, 'weigh_limit'));
                                         //$ins_data[$counter]['weight_limit']           = $weight_limit;
                                         
                                         $ins_data[$counter]['type']              = $weighlimit_array[$keyyy]['axle'];
                                         $ins_data[$counter]['vehicle_code']      = $weighlimit_array[$keyyy]['code'];
                                         $ins_data[$counter]['weight']            = $weight_ton;
                                         if($value[34] > $value[35]){
                                            $diff = $weight_ton - $weight_limit;
                                            $ins_data[$counter]['exces_weight']      = $diff;
                                            $ins_data[$counter]['percent_overload']  = round(($diff / $weight_limit) * 100,2); 
                                            $ins_data[$counter]['fine']              = 0;
                                            $ins_data[$counter]['status']            = 2;
                                         }else{
                                            $ins_data[$counter]['exces_weight']      = 0;
                                            $ins_data[$counter]['percent_overload']  = 0;
                                            $ins_data[$counter]['fine']              = 0;
                                            $ins_data[$counter]['status']            = 1;
                                         }
                                         if($counter == 0){

                                         }
                                        $counter ++;
                                    }
                                }
                               
                                 

                            }///end of second file exist
                            
                            if($row['file_index'] && $i == 0){
                                if($ins_data){
                                    
                                    $ins_data = array_values(array_slice($ins_data, $c));
                                      
                                }
                            }  
                        } ////end of for loop

                   } ///end of first file exist 
                    if($ins_data){
                        $this->db->insert_batch('weighstation_data', $ins_data);  
                    }
                    $this->db->where('id', $row['id']);
                    $this->db->update('weighstation',array('file_index' => $update_file, 'last_updated' => time(),'con_status' => 1));  
                }else{
                        $this->db->where('id',$row['id']);
                        $this->db->update('weighstation',array('con_status' => 0,'last_updated' => time()));
                
                } ////end of if connection established
                
               
            }///end of foreach loop over toll plaza
        }////end of if toll plaza is not empty
        
        
      
        
	}

}

?>