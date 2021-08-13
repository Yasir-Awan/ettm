<?php 
defined('BASEPATH') OR EXIT('NO DIRECT SCRIPT ALLOWED');

class Tollink_weigh extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->page_data = array();
	}

   
	public function index()

	{
                // $server = "182.180.165.26";
                // $username = "5000c";
                // $password = "5000c";
                // $database = "cwManager";
                // /////
                // try {
                //            $conn = new PDO( "sqlsrv:Server=$server;Database=$database;", $username, $password);
                //            $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
                //            $row_id = $row['file_index'];
                //            $tsql = "SELECT TOP 100 * FROM dbo.VehicleWeights";
                //            $getdata = $conn->query($tsql);
                //         } catch( PDOException $e ) {
                //            die( "Error connecting to SQL Server. ".$e->getMessage() );
                //             // $this->db->where('id',$row['id']);
                //             // $this->db->update('weighstation',array('con_status' => 0,'last_updated' => time()));
                //         }
                //         while ($value = $getdata->fetch(PDO::FETCH_ASSOC)) {
                //           echo "<pre>";
                //           print_r($value); exit;
                //         }

            
                // exec("ping -n 3 $server", $output, $status);
                // echo "<pre>";
                // print_r($output);
                // echo "<pre>";
                // print_r($status); exit;
        $weigh = $this->db->get_where('weighstation',array('status' => 1,'software_type' => 3))->result_array();
        
        if($weigh){
            $sql = "Select weigh_limit.id, cat_id,category_code,weigh_limit,name,axle,tollLink_code From weigh_limit Join weigh_category On weigh_limit.category_code = weigh_category.code";
            $res = $this->db->query($sql)->result_array();
            $weighlimit_array = array();
            $cc = 0;

            foreach($res as $row3){
                   $weighlimit_array[$cc]['axle'] = $row3['axle'];
                   $weighlimit_array[$cc]['weigh_limit'] = $row3['weigh_limit'];
                   $weighlimit_array[$cc]['code'] = $row3['category_code'];
                   $weighlimit_array[$cc]['tollLink_code'] = $row3['tollLink_code'];
                   $cc++;
                   
            }
            // echo "<pre>";
            // print_r($weighlimit_array); exit;
            foreach ($weigh as $row) {

                $server = $row['address'];
                $database = $row['db_name'];
                $username = $row['username'];
                $password = $row['password'];
                $ins_data = array();
                exec("ping -n 3 $server", $output, $status);
               // echo $status; exit;
                if($status == 0){
                    if($row['file_index']){
                        try {
                           $conn = new PDO( "sqlsrv:Server=$server;Database=$database;", $username, $password);
                           $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
                           $row_id = $row['file_index'];
                           $tsql = "SELECT TOP 100 * FROM dbo.VehicleWeights WHERE Id > $row_id";
                          // $tsql = "SELECT TOP 100 * FROM dbo.VehicleWeights WHERE Id = '9090'";
                           $getdata = $conn->query($tsql);
                           $counter = 0;
                            while ($value = $getdata->fetch(PDO::FETCH_ASSOC)) {
                               
                               $ins_data[$counter]['weigh_id'] = $row['id']; 
                               $ins_data[$counter]['date'] = explode(' ',trim($value['WeighDate']))[0];
                               $ins_data[$counter]['time'] = $value['WeighTime'];
                               $ins_data[$counter]['ticket_no'] = $value['Transaction_no'];
                               $ins_data[$counter]['type'] = $value['Axles'] ? $value['Axles']: $value['Axles_Seen']; 
                               $ins_data[$counter]['tollLink_code'] = $value['Vehicle_Type']; 
                               $ins_data[$counter]['vehicle_no'] = $value['Vehicle_ID'];
                               $weight = $value['TotalWeight'] / 1000;
                               $ins_data[$counter]['weight'] = $weight;
                               $ins_data[$counter]['ticket_no'] = $value['Transaction_no'];
                               $ins_data[$counter]['tollLink_systemID'] = $value['Id'];
                               $update_file =  $value['Id'];             
                               $keyyy = array_search(trim($value['Vehicle_Type']) , array_column($weighlimit_array, 'tollLink_code'));
                               if(is_numeric($keyyy)){
                                  $weigh_limit = $weighlimit_array[$keyyy]['weigh_limit'];
                                  $ins_data[$counter]['vehicle_code']      = $weighlimit_array[$keyyy]['code'];
                                                 
                                  if($weight > $weigh_limit ){
                                        $diff = $weight - $weigh_limit;
                                        $ins_data[$counter]['exces_weight']      = $diff;
                                        $ins_data[$counter]['percent_overload']  = round(($diff / $weigh_limit) * 100,2); 
                                        $ins_data[$counter]['fine']              = 0;
                                        $ins_data[$counter]['status']            = 2;
                                        
                                  }else{

                                        $ins_data[$counter]['exces_weight']      = 0;
                                        $ins_data[$counter]['percent_overload']  = 0;
                                        $ins_data[$counter]['fine']              = 0;
                                        $ins_data[$counter]['status']            = 1;
                                  }
                               }else{
                                $keyyy = array_search($value['Axles'] , array_column($weighlimit_array, 'axle'));
                                  if(is_numeric($keyyy)){
                                      $ins_data[$counter]['vehicle_code']      = $weighlimit_array[$keyyy]['code'];
                                                 
                                      $weigh_limit = $weighlimit_array[$keyyy]['weigh_limit'];
                                      if($weight > $weigh_limit ){
                                            $diff = $weight - $weigh_limit;
                                            $ins_data[$counter]['exces_weight']      = $diff;
                                            $ins_data[$counter]['percent_overload']  = round(($diff / $weigh_limit) * 100,2); 
                                            $ins_data[$counter]['fine']              = 0;
                                            $ins_data[$counter]['status']            = 2;
                                      }else{
                                        
                                            $ins_data[$counter]['exces_weight']      = 0;
                                            $ins_data[$counter]['percent_overload']  = 0;
                                            $ins_data[$counter]['fine']              = 0;
                                            $ins_data[$counter]['status']            = 1;
                                      }
                                  }else{
                                         $ins_data[$counter]['vehicle_code']      = '';
                                        $ins_data[$counter]['exces_weight']      = '';
                                        $ins_data[$counter]['percent_overload']  = '';
                                        $ins_data[$counter]['fine']              = '';
                                        $ins_data[$counter]['status']            = '';
                                  }
                               }
                               $counter++;
                              
                              
                            }
                        } catch( PDOException $e ) {
                           //die( "Error connecting to SQL Server. ".$e->getMessage() );
                            $this->db->where('id',$row['id']);
                            $this->db->update('weighstation',array('con_status' => 0,'last_updated' => time()));
                        }
                    }else{
                       
                        try {
                           $conn = new PDO( "sqlsrv:Server=$server;Database=$database;", $username, $password);
                           $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
                           
                           $tsql = "SELECT TOP 100 * FROM dbo.VehicleWeights WHERE WeighDate > '2020-03-01'";
                           $getdata = $conn->query($tsql);
                           $counter = 0;
                            while ($value = $getdata->fetch(PDO::FETCH_ASSOC)) {
                               
                                $ins_data[$counter]['weigh_id'] = $row['id']; 
                               $ins_data[$counter]['date'] = explode(' ',trim($value['WeighDate']))[0];
                               $ins_data[$counter]['time'] = $value['WeighTime'];
                               $ins_data[$counter]['ticket_no'] = $value['Transaction_no'];
                               $ins_data[$counter]['type'] = $value['Axles'] ? $value['Axles']: $value['Axles_Seen']; 
                               $ins_data[$counter]['tollLink_code'] = $value['Vehicle_Type']; 
                               $ins_data[$counter]['vehicle_no'] = $value['Vehicle_ID'];
                               $weight = $value['TotalWeight'] / 1000;
                               $ins_data[$counter]['weight'] = $weight;
                               $ins_data[$counter]['ticket_no'] = $value['Transaction_no'];
                               $ins_data[$counter]['tollLink_systemID'] = $value['Id'];
                               $update_file =  $value['Id'];             
                               $keyyy = array_search(trim($value['Vehicle_Type']) , array_column($weighlimit_array, 'tollLink_code'));
                               if(is_numeric($keyyy)){
                                  $weigh_limit = $weighlimit_array[$keyyy]['weigh_limit'];
                                  $ins_data[$counter]['vehicle_code']      = $weighlimit_array[$keyyy]['code'];
                                                 
                                  if($weight > $weigh_limit ){
                                        $diff = $weight - $weigh_limit;
                                        $ins_data[$counter]['exces_weight']      = $diff;
                                        $ins_data[$counter]['percent_overload']  = round(($diff / $weigh_limit) * 100,2); 
                                        $ins_data[$counter]['fine']              = 0;
                                        $ins_data[$counter]['status']            = 2;
                                        
                                  }else{

                                        $ins_data[$counter]['exces_weight']      = 0;
                                        $ins_data[$counter]['percent_overload']  = 0;
                                        $ins_data[$counter]['fine']              = 0;
                                        $ins_data[$counter]['status']            = 1;
                                  }
                               }else{
                                $keyyy = array_search($value['Axles'] , array_column($weighlimit_array, 'axle'));
                                  if(is_numeric($keyyy)){
      
                                      $ins_data[$counter]['vehicle_code']      = $weighlimit_array[$keyyy]['code'];
                                                 
                                      $weigh_limit = $weighlimit_array[$keyyy]['weigh_limit'];
                                      if($weight > $weigh_limit ){
                                            $diff = $weight - $weigh_limit;
                                            $ins_data[$counter]['exces_weight']      = $diff;
                                            $ins_data[$counter]['percent_overload']  = round(($diff / $weigh_limit) * 100,2); 
                                            $ins_data[$counter]['fine']              = 0;
                                            $ins_data[$counter]['status']            = 2;
                                      }else{
                                        
                                            $ins_data[$counter]['exces_weight']      = 0;
                                            $ins_data[$counter]['percent_overload']  = 0;
                                            $ins_data[$counter]['fine']              = 0;
                                            $ins_data[$counter]['status']            = 1;
                                      }
                                  }else{
                                        $ins_data[$counter]['vehicle_code']      = '';
                                       
                                        $ins_data[$counter]['exces_weight']      = '';
                                        $ins_data[$counter]['percent_overload']  = '';
                                        $ins_data[$counter]['fine']              = '';
                                        $ins_data[$counter]['status']            = '';
                                  }
                               }
                               $counter++;
                            }
                        } catch( PDOException $e ) {
                           die( "Error connecting to SQL Server. ".$e->getMessage() );
                            $this->db->where('id',$row['id']);
                            $this->db->update('weighstation',array('con_status' => 0,'last_updated' => time()));
                         }
                    }
                //    echo "<pre>";
                //    print_r($ins_data); exit;
                   ////////////////////////////
                    ///////////////////////////////
                    //////////////////////////////////
                    if($ins_data){
                        $this->db->insert_batch('weighstation_data', $ins_data);  
                        $this->db->where('id', $row['id']);
                        $this->db->update('weighstation',array('file_index' => $update_file, 'last_updated' => time(),'con_status' => 1));  
                
                    }else{
                        $this->db->where('id', $row['id']);
                        $this->db->update('weighstation',array('last_updated' => time(),'con_status' => 1));  
                
                    }
                  }else{
                        $this->db->where('id',$row['id']);
                        $this->db->update('weighstation',array('con_status' => 0,'last_updated' => time()));
                
                } ////end of if connection established
                
               
            }///end of foreach loop over toll plaza
        }////end of if toll plaza is not empty
        
        
      
        
	}

}

?>