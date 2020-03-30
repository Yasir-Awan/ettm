<?php 
defined('BASEPATH') OR EXIT('NO DIRECT SCRIPT ALLOWED');

class Tollplaza_crons extends CI_Controller{
  public function __construct(){
    parent::__construct();
    $this->load->helper('url');
    $this->page_data = array();
  }

   
  public function index()

  {
 //   echo date('y-m-d h:i:s A'); exit;
# Connection
$server = "172.19.14.2";
$username = "informix";
$password = "informix";
$database = "sgj";

// $SqlServer = "172.19.14.2";
// $DbConnInfo = array( "Database"=>"sgj", "UID"=>"informix", "PWD"=>"informix");
// $SqlServerCon = sqlsrv_connect( $SqlServer, $DbConnInfo);
// if( $SqlServerCon ) {echo "Connection established";}
// else
// {echo "Connection could not be established.<br />";
// die( print_r( sqlsrv_errors(), true));}



try {
   $conn = new PDO( "sqlsrv:Server=$server;Database=$database;", NULL, NULL);
   $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
} catch( PDOException $e ) {
   die( "Error connecting to SQL Server. ".$e->getMessage() );
}

# End
$conn = null;
    echo "<pre>";
    print_r(get_loaded_extensions()); exit;
        $data = file_get_contents($value);
        $lanes = $this->db->get_where('tollplaza_lanes',array('status' => 1))->result_array();
         
        if($lanes){
           
            
            foreach ($lanes as $row) {
                $current_folder = str_replace('-','',date('Y-m-d'));
                //echo str_replace('-','',$current_folder); exit;
                $tollplaza = $this->db->get_where('toolplaza',array('id' => $row['toll_plaza']))->result_array();
                $ins_data = array();
                //$connect = ftp_connect('172.19.14.101');  //connect to server

                //$login = ftp_login($connect, 'nha-ops2-pc12', 'nha123'); 
                $files = scandir("\\\\".$row['ipaddress']);
               
                $files = array_values(array_diff($files, array('.', '..')));
                $src_cnt = count($files);

                 if(!is_dir('D:/'.$tollplaza[0]["name"].'/'.$row["name"].'/'.$current_folder)) {
                     @mkdir('D:/'.$tollplaza[0]["name"].'/'.$row["name"].'/'.$current_folder, 0777, true);
   
                  } 
                 $fileList = glob('D:/'.$tollplaza[0]["name"].'/'.$row["name"].'/'.$current_folder.'/*');
                  // echo "<pre>";
                  // print_r($fileList); exit;
                 $checkarray = array();
                  foreach($fileList as $rss){
                    $checkarray[] = str_replace('D:/'.$tollplaza[0]["name"].'/'.$row["name"].'/'.$current_folder.'/', '', $rss);
                  }
                  $dest_cnt = count($checkarray);
                  $difference = $src_cnt - $dest_cnt;

                  if($src_cnt > 10 && $dest_cnt > 6){
                     $files = array_values(array_slice($files, $src_cnt - ($difference + 2)));
                     $checkarray = array_values(array_slice($checkarray, $dest_cnt - 2));  
                  }
                  // echo "<pre>";
                  // print_r($files);
                  // echo "<pre>";
                  // print_r($checkarray); exit;

                  // if($fileList){
                  //   $flee =  explode('/', array_pop($fileList));
                  //   $file_arr = explode('_',array_pop($flee));
                  //   $file_no  = $file_arr[0];

                  // }else{
                  //   $file_no  = 0;
                  // }
                  
                  //$file_countr = $file_no;
                  if($files){
                    foreach($files as $row1){
                      if(date("Y-m-d", filemtime("\\\\".$row['ipaddress']."\\".$row1)) == date("Y-m-d")){
                       
                        if(in_array($row1, $checkarray)){
                           $filee = explode('_', $row1);
                           if($filee[1] == 'TSaveBatchDBMessage.txt'){
                              $key_serch = array_search($row1, $checkarray);
                              //echo filesize("\\\\".$row['ipaddress']."\\".$row1) .'=='. filesize('D:/'.$tollplaza[0]["name"].'/'.$row["name"].'/'.$current_folder.'/'.$checkarray[$key_serch])."<br>";
                              if(filesize("\\\\".$row['ipaddress']."\\".$row1) > filesize('D:/'.$tollplaza[0]["name"].'/'.$row["name"].'/'.$current_folder.'/'.$checkarray[$key_serch])){
                                  copy("\\\\".$row["ipaddress"]."\\".$row1, 'D:/'.$tollplaza[0]["name"].'/'.$row["name"].'/'.$current_folder.'/'.$row1);
                              }
                           }
                           
                           // $new = explode('_',$row1)[1];
                            //$new_file_name = $file_countr."_".$new;
                            //rename
                            //copy("\\\\".$row["ipaddress"]."\\".$row1, 'E:/'.$tollplaza[0]["name"].'/'.$row["name"].'/'.$current_folder.'/'.$new_file_name);
                           //copy("\\\\".$row["ipaddress"]."\\".$row1, 'D:/'.$tollplaza[0]["name"].'/'.$row["name"].'/'.$current_folder.'/'.$row1);
                        
                            //$file_countr++;

                        }else{
                          copy("\\\\".$row["ipaddress"]."\\".$row1, 'D:/'.$tollplaza[0]["name"].'/'.$row["name"].'/'.$current_folder.'/'.$row1);
                         
                        }
                         
                        
                      }
                    } 
                  } 
                    

                // for($i = 0; $i<= 20; $i++){
                //     echo time()."<br/>";
                // }
            }///end of foreach loop over toll plaza
        }////end of if toll plaza is not empty
        
        
      
        
  }

    public function read_files(){
        $transaction = array();
        $incidents = array();
        $cntr = 0;
        $incntr = 0;
        $current_folder = str_replace('-','',date('Y-m-d'));
                
        $lanes = $this->db->get_where('tollplaza_lanes',array('status' => 1))->result_array();
        foreach($lanes as $row){
            
            $tollplaza = $this->db->get_where('toolplaza',array('id' => $row['toll_plaza']))->result_array();
            $fileList = '';
            if(is_dir('D:/'.$tollplaza[0]["name"].'/'.$row["name"].'/'.$current_folder)) {
                   //$files_scan = scandir('E:/'.$tollplaza[0]["name"].'/'.$row["name"], 0777, true);
                    $fileList = glob('D:/'.$tollplaza[0]["name"].'/'.$row["name"].'/'.$current_folder.'/*');
            }
            $this->db->select('tx_seq_nr,dt_concluded');
            $this->db->where('date',date('Y-m-d'));
            $this->db->where('tollplaza_id',$row['toll_plaza']);
            $this->db->where('lane_id',$row['id']);
            $previous_record = $this->db->get('transactions')->result_array();
            //echo "<pre>";
            //print_r($previous_record); exit;
           
            //$previous_record = array_column($previous_record,"tx_seq_nr");
            $chk = @$this->db->get_where('tollplaza_lanes',array('id' =>$row['id'],'updated_date' => date('Y-m-d')))->row()->no_files; //check if already files read for this date
            //echo "<pre>";
            //print_r($chk);
            //exit;
            

            $filecount = count($fileList);

            if($chk){

              $fileList = array_values(array_slice($fileList, ($chk - 1)));
               // echo "<pre>";
               // print_r($fileList); exit;
            }
            if($fileList){///////check if any new file for read
                foreach($fileList as $key => $value){
                
                    $fle = explode('/', $value);
                    $file_name = trim(explode('_',explode('.',array_pop($fle))[0])[1]); 
                    $data = file_get_contents($value);

                    $skuList = explode(PHP_EOL, $data);
                    $filtered = array_values(array_filter($skuList));
                    //echo $file."<br>";
                    //echo "<pre>";
                    //print_r($filtered); 
                    //if($file_name == 'TSaveBatchDBMessage' && $filtered[0] =='RecordCount=100'){ ////check for batch file
                    if($file_name == 'TSaveBatchDBMessage'){ 
                        unset($filtered[0]); // remove item at index 0
                        $final = array_values($filtered);
                        $c = array_intersect($final, array("End of Record"));
                        $r = array();
                        $i = 0;
                        foreach($c as $k => $v) {
                            $l   = ++$k - $i;
                            $r[] = array_slice($final, $i, $l);
                            $i   = $k;
                        }

                        foreach($r as $key1 => $value1){

                            if($value1[0] == 'TSaveTransactionMessage'){
                              $fnd_key = '';
                              
                              if(array_search(explode('=', $value1[5])[1], array_column($previous_record, 'tx_seq_nr'))  === false){
                               // echo array_search(explode('=', $value1[5])[1], array_column($previous_record, 'tx_seq_nr'))."<br>";
                               // echo explode('=', $value1[5])[1];
                               // echo "false statement<br>";
                               // echo "<pre>";
                               // print_r($previous_record);
                                $datetime = explode('=', $value1[4])[1];
                                $date_data = array();
                                $time_data = array();
                                $date_data['year'] = substr($datetime, 0, 4);
                                $date_data['month'] = substr($datetime, 4, 2);
                                $date_data['day'] = substr($datetime, 6, 2);
                                $time_data['hours'] = substr($datetime, 8, 2);
                                $time_data['minutes'] = substr($datetime, 10, 2);
                                $time_data['seconds'] = substr($datetime, 12, 2);
                                $transaction[$cntr]['tollplaza_id']      = $row['toll_plaza'];
                                $transaction[$cntr]['lane_id']           = $row['id'];
                                $transaction[$cntr]['date']              = implode('-', $date_data);
                                $transaction[$cntr]['time']              = implode(':', $time_data);
                                $transaction[$cntr]['send_mode']         = explode('=', $value1[1])[1];
                                $transaction[$cntr]['pl_id']             = explode('=', $value1[2])[1];
                                $transaction[$cntr]['ln_id']             = explode('=', $value1[3])[1];
                                $transaction[$cntr]['dt_concluded']      = explode('=', $value1[4])[1];
                                $transaction[$cntr]['tx_seq_nr']         = explode('=', $value1[5])[1];
                                $transaction[$cntr]['ts_seq_nr']         = explode('=', $value1[6])[1];
                                $transaction[$cntr]['us_id']             = explode('=', $value1[7])[1];
                                $transaction[$cntr]['ent_plz_id']        = explode('=', $value1[8])[1];
                                $transaction[$cntr]['ent_lane_id']       = explode('=', $value1[9])[1];
                                $transaction[$cntr]['dt_started']        = explode('=', $value1[10])[1];
                                $transaction[$cntr]['next_inc']          = explode('=', $value1[11])[1];
                                $transaction[$cntr]['prev_inc']          = explode('=', $value1[12])[1];
                                $transaction[$cntr]['ft_id']             = explode('=', $value1[13])[1];
                                //$transaction[$cntr]['pg_group']          = explode('=', $value1[14])[1];
                                //$transaction[$cntr]['cg_group']          = explode('=', $value1[15])[1];
                                $transaction[$cntr]['vg_group']          = explode('=', $value1[16])[1];
                                $transaction[$cntr]['mvc']               = explode('=', $value1[17])[1];
                                $transaction[$cntr]['avc']               = explode('=', $value1[18])[1];
                                $transaction[$cntr]['svc']               = explode('=', $value1[19])[1];
                                $transaction[$cntr]['loc_curr']          = explode('=', $value1[20])[1];
                                $transaction[$cntr]['loc_value']         = explode('=', $value1[21])[1];
                                $transaction[$cntr]['ten_curr']          = explode('=', $value1[22])[1];
                                $transaction[$cntr]['ten_value']         = explode('=', $value1[23])[1];
                                //$transaction[$cntr]['loc_change']        = explode('=', $value1[24])[1];
                                //$transaction[$cntr]['variance']          = explode('=', $value1[25])[1];
                                //$transaction[$cntr]['er_id']             = explode('=', $value1[26])[1];
                                $transaction[$cntr]['pm_id']             = explode('=', $value1[27])[1];
                                //$transaction[$cntr]['card_nr']           = explode('=', $value1[28])[1];
                                //$transaction[$cntr]['ca_id']             = explode('=', $value1[29])[1];
                                //$transaction[$cntr]['ct_id']             = explode('=', $value1[30])[1];
                                //$transaction[$cntr]['conc_nr']           = explode('=', $value1[31])[1];
                                $transaction[$cntr]['lm_id']             = explode('=', $value1[32])[1];
                                //$transaction[$cntr]['as_id']             = explode('=', $value1[33])[1];
                                $transaction[$cntr]['reg_nr']            = explode('=', $value1[34])[1];
                                $transaction[$cntr]['vouch_nr']          = explode('=', $value1[35])[1];
                                //$transaction[$cntr]['ac_nr']             = explode('=', $value1[36])[1];
                                $transaction[$cntr]['rec_nr']            = explode('=', $value1[37])[1];
                                //$transaction[$cntr]['tick_nr']           = explode('=', $value1[38])[1];
                               // $transaction[$cntr]['bp_id']             = explode('=', $value1[39])[1];
                                //$transaction[$cntr]['fg_id']             = explode('=', $value1[40])[1];
                                //$transaction[$cntr]['dg_id']             = explode('=', $value1[41])[1];
                                //$transaction[$cntr]['rd_id']             = explode('=', $value1[42])[1];
                                //$transaction[$cntr]['rep_indic']         = explode('=', $value1[43])[1];
                                //$transaction[$cntr]['maint_indic']       = explode('=', $value1[44])[1];
                                //$transaction[$cntr]['req_indic']         = explode('=', $value1[45])[1];
                                //$transaction[$cntr]['iv_prt_indic']      = explode('=', $value1[46])[1];
                                $transaction[$cntr]['ts_dt_started']     = explode('=', $value1[47])[1];
                                // $transaction[$cntr]['iv_nr']             = explode('=', $value1[48])[1];
                                // $transaction[$cntr]['td_id']             = explode('=', $value1[49])[1];
                                // $transaction[$cntr]['avc_seq_nr']        = explode('=', $value1[50])[1];
                                // $transaction[$cntr]['card_bank']         = explode('=', $value1[51])[1];
                                // $transaction[$cntr]['card_ac_nr']        = explode('=', $value1[52])[1];
                                // $transaction[$cntr]['tg_mfg_id']         = explode('=', $value1[53])[1];
                                // $transaction[$cntr]['tg_post_bal']       = explode('=', $value1[54])[1];
                                // $transaction[$cntr]['tg_reader']         = explode('=', $value1[55])[1];
                                // $transaction[$cntr]['tg_us_cat']         = explode('=', $value1[56])[1];
                                // $transaction[$cntr]['tg_card_type']      = explode('=', $value1[57])[1];
                                // $transaction[$cntr]['tg_serv_prov_id']   = explode('=', $value1[58])[1];
                                // $transaction[$cntr]['tg_issuer']         = explode('=', $value1[59])[1];
                                // $transaction[$cntr]['tg_tx_seq_nr']      = explode('=', $value1[60])[1];
                                //array_push($previous_record, array('tx_seq_nr' => explode('=', $value1[5])[1],'dt_concluded' => explode('=', $value1[4])[1]));
                                $previous_record[] = array('tx_seq_nr' => explode('=', $value1[5])[1],'dt_concluded' => explode('=', $value1[4])[1]);
                                    
                                $cntr++;
                              }else{
                                $fnd_key = array_search(explode('=', $value1[5])[1], array_column($previous_record, 'tx_seq_nr'));
                                if($previous_record[$fnd_key]['dt_concluded'] != explode('=', $value1[4])[1]){
                                   // echo "else check<br>";
                                    $datetime = explode('=', $value1[4])[1];
                                    $date_data = array();
                                    $time_data = array();
                                    $date_data['year'] = substr($datetime, 0, 4);
                                    $date_data['month'] = substr($datetime, 4, 2);
                                    $date_data['day'] = substr($datetime, 6, 2);
                                    $time_data['hours'] = substr($datetime, 8, 2);
                                    $time_data['minutes'] = substr($datetime, 10, 2);
                                    $time_data['seconds'] = substr($datetime, 12, 2);
                                    $transaction[$cntr]['tollplaza_id']      = $row['toll_plaza'];
                                    $transaction[$cntr]['lane_id']           = $row['id'];
                                    $transaction[$cntr]['date']              = implode('-', $date_data);
                                    $transaction[$cntr]['time']              = implode(':', $time_data);
                                    $transaction[$cntr]['send_mode']         = explode('=', $value1[1])[1];
                                    $transaction[$cntr]['pl_id']             = explode('=', $value1[2])[1];
                                    $transaction[$cntr]['ln_id']             = explode('=', $value1[3])[1];
                                    $transaction[$cntr]['dt_concluded']      = explode('=', $value1[4])[1];
                                    $transaction[$cntr]['tx_seq_nr']         = explode('=', $value1[5])[1];
                                    $transaction[$cntr]['ts_seq_nr']         = explode('=', $value1[6])[1];
                                    $transaction[$cntr]['us_id']             = explode('=', $value1[7])[1];
                                    $transaction[$cntr]['ent_plz_id']        = explode('=', $value1[8])[1];
                                    $transaction[$cntr]['ent_lane_id']       = explode('=', $value1[9])[1];
                                    $transaction[$cntr]['dt_started']        = explode('=', $value1[10])[1];
                                    $transaction[$cntr]['next_inc']          = explode('=', $value1[11])[1];
                                    $transaction[$cntr]['prev_inc']          = explode('=', $value1[12])[1];
                                    $transaction[$cntr]['ft_id']             = explode('=', $value1[13])[1];
                                    //$transaction[$cntr]['pg_group']          = explode('=', $value1[14])[1];
                                    //$transaction[$cntr]['cg_group']          = explode('=', $value1[15])[1];
                                    $transaction[$cntr]['vg_group']          = explode('=', $value1[16])[1];
                                    $transaction[$cntr]['mvc']               = explode('=', $value1[17])[1];
                                    $transaction[$cntr]['avc']               = explode('=', $value1[18])[1];
                                    $transaction[$cntr]['svc']               = explode('=', $value1[19])[1];
                                    $transaction[$cntr]['loc_curr']          = explode('=', $value1[20])[1];
                                    $transaction[$cntr]['loc_value']         = explode('=', $value1[21])[1];
                                    $transaction[$cntr]['ten_curr']          = explode('=', $value1[22])[1];
                                    $transaction[$cntr]['ten_value']         = explode('=', $value1[23])[1];
                                    //$transaction[$cntr]['loc_change']        = explode('=', $value1[24])[1];
                                    //$transaction[$cntr]['variance']          = explode('=', $value1[25])[1];
                                    //$transaction[$cntr]['er_id']             = explode('=', $value1[26])[1];
                                    $transaction[$cntr]['pm_id']             = explode('=', $value1[27])[1];
                                    //$transaction[$cntr]['card_nr']           = explode('=', $value1[28])[1];
                                    //$transaction[$cntr]['ca_id']             = explode('=', $value1[29])[1];
                                    //$transaction[$cntr]['ct_id']             = explode('=', $value1[30])[1];
                                    //$transaction[$cntr]['conc_nr']           = explode('=', $value1[31])[1];
                                    $transaction[$cntr]['lm_id']             = explode('=', $value1[32])[1];
                                    //$transaction[$cntr]['as_id']             = explode('=', $value1[33])[1];
                                    $transaction[$cntr]['reg_nr']            = explode('=', $value1[34])[1];
                                    $transaction[$cntr]['vouch_nr']          = explode('=', $value1[35])[1];
                                    //$transaction[$cntr]['ac_nr']             = explode('=', $value1[36])[1];
                                    $transaction[$cntr]['rec_nr']            = explode('=', $value1[37])[1];
                                    //$transaction[$cntr]['tick_nr']           = explode('=', $value1[38])[1];
                                   // $transaction[$cntr]['bp_id']             = explode('=', $value1[39])[1];
                                    //$transaction[$cntr]['fg_id']             = explode('=', $value1[40])[1];
                                    //$transaction[$cntr]['dg_id']             = explode('=', $value1[41])[1];
                                    //$transaction[$cntr]['rd_id']             = explode('=', $value1[42])[1];
                                    //$transaction[$cntr]['rep_indic']         = explode('=', $value1[43])[1];
                                    //$transaction[$cntr]['maint_indic']       = explode('=', $value1[44])[1];
                                    //$transaction[$cntr]['req_indic']         = explode('=', $value1[45])[1];
                                    //$transaction[$cntr]['iv_prt_indic']      = explode('=', $value1[46])[1];
                                    $transaction[$cntr]['ts_dt_started']     = explode('=', $value1[47])[1];
                                    // $transaction[$cntr]['iv_nr']             = explode('=', $value1[48])[1];
                                    // $transaction[$cntr]['td_id']             = explode('=', $value1[49])[1];
                                    // $transaction[$cntr]['avc_seq_nr']        = explode('=', $value1[50])[1];
                                    // $transaction[$cntr]['card_bank']         = explode('=', $value1[51])[1];
                                    // $transaction[$cntr]['card_ac_nr']        = explode('=', $value1[52])[1];
                                    // $transaction[$cntr]['tg_mfg_id']         = explode('=', $value1[53])[1];
                                    // $transaction[$cntr]['tg_post_bal']       = explode('=', $value1[54])[1];
                                    // $transaction[$cntr]['tg_reader']         = explode('=', $value1[55])[1];
                                    // $transaction[$cntr]['tg_us_cat']         = explode('=', $value1[56])[1];
                                    // $transaction[$cntr]['tg_card_type']      = explode('=', $value1[57])[1];
                                    // $transaction[$cntr]['tg_serv_prov_id']   = explode('=', $value1[58])[1];
                                    // $transaction[$cntr]['tg_issuer']         = explode('=', $value1[59])[1];
                                    // $transaction[$cntr]['tg_tx_seq_nr']      = explode('=', $value1[60])[1];
                                  //  array_push($previous_record, array('tx_seq_nr' => explode('=', $value1[5])[1],'dt_concluded' => explode('=', $value1[4])[1]));
                                    $previous_record[] = array('tx_seq_nr' => explode('=', $value1[5])[1],'dt_concluded' => explode('=', $value1[4])[1]);
                                    
                                    $cntr++;
                                }

                              }
                            }else{
                               // $incidents[$incntr]['lane_id']           = $row['id'];
                               // $incidents[$incntr]['send_mode']         =  explode('=', $value1[1])[1];
                               // $incidents[$incntr]['pl_id']             =  explode('=', $value1[2])[1];
                               // $incidents[$incntr]['ln_id']             =  explode('=', $value1[3])[1];
                               // $incidents[$incntr]['dt_generated']      =  explode('=', $value1[4])[1];
                               // $incidents[$incntr]['in_seq_nr']         =  explode('=', $value1[5])[1];
                               // $incidents[$incntr]['ir_type']           =  explode('=', $value1[6])[1];
                               // $incidents[$incntr]['ir_subtype']        =  explode('=', $value1[7])[1];
                               // $incidents[$incntr]['tx_seq_nr']         =  explode('=', $value1[8])[1];
                               // $incidents[$incntr]['ts_seq_nr']         =  explode('=', $value1[9])[1];
                               // $incidents[$incntr]['us_id']             =  explode('=', $value1[10])[1];
                               // $incidents[$incntr]['ft_id']             =  explode('=', @$value1[11])[1];
                               // $incidents[$incntr]['pg_group']          =  explode('=', @$value1[12])[1];
                               // $incidents[$incntr]['cg_group']          =  explode('=', @$value1[13])[1];
                               // $incidents[$incntr]['vg_group']          =  explode('=', @$value1[14])[1];
                               // $incidents[$incntr]['mvc']               =  explode('=', @$value1[15])[1];
                               // $incidents[$incntr]['avc']               =  explode('=', @$value1[16])[1];
                               // $incidents[$incntr]['svc']               =  explode('=', @$value1[17])[1];
                               // $incidents[$incntr]['er_id']             =  explode('=', @$value1[18])[1];
                               // $incidents[$incntr]['pm_id']             =  explode('=', @$value1[19])[1];
                               // $incidents[$incntr]['card_nr']           =  explode('=', @$value1[20])[1];
                               // $incidents[$incntr]['ca_id']             =  explode('=', @$value1[21])[1];
                               // $incidents[$incntr]['ct_id']             =  explode('=', @$value1[22])[1];
                               // $incidents[$incntr]['tx_indic']          =  explode('=', @$value1[23])[1];
                               // $incidents[$incntr]['lm_id']             =  explode('=', @$value1[24])[1];
                               // $incidents[$incntr]['as_id']             =  explode('=', @$value1[25])[1];
                               // $incidents[$incntr]['rep_indic']         =  explode('=', @$value1[26])[1];
                               // $incidents[$incntr]['rd_id']             =  explode('=', @$value1[27])[1];
                               // $incidents[$incntr]['maint_indic']       =  explode('=', @$value1[28])[1];
                               // $incidents[$incntr]['req_indic']         =  explode('=', @$value1[29])[1];
                               // $incidents[$incntr]['ts_dt_started']     =  explode('=', @$value1[30])[1];
                               // $incidents[$incntr]['in_amt']            =  explode('=', @$value1[31])[1];
                               // $incidents[$incntr]['tg_bl_id']          =  explode('=', @$value1[32])[1];
                               // $incidents[$incntr]['tg_mfg_id']         =  explode('=', @$value1[33])[1];
                               // $incidents[$incntr]['tg_card_type']      =  explode('=', @$value1[34])[1];
                               // $incidents[$incntr]['tg_reader']         =  @explode('=', @$value1[35])[1];
                               // $incidents[$incntr]['tg_tx_seq_nr']      =  explode('=', @$value1[36])[1];
                               // $incntr++;
                               
                            }
                        }

                    }////end of check batch file
                    else{
                       
                        
                        if($file_name == 'TSaveTransactionMessage'){
                            $fnd_key = '';
                            if(array_search(explode('=', $filtered[4])[1], array_column($previous_record, 'tx_seq_nr')) === false){
                                //echo array_search(explode('=', $filtered[4])[1], array_column($previous_record, 'tx_seq_nr'))."<br>";
                               // echo "false statement second.<br>";
                                $datetime = explode('=', $filtered[3])[1];
                                
                                $date_data = array();
                                $time_data = array();
                                $date_data['year'] = substr($datetime, 0, 4);
                                $date_data['month'] = substr($datetime, 4, 2);
                                $date_data['day'] = substr($datetime, 6, 2);
                                $time_data['hours'] = substr($datetime, 8, 2);
                                $time_data['minutes'] = substr($datetime, 10, 2);
                                $time_data['seconds'] = substr($datetime, 12, 2);
                               

                             //   20191108113040006600
                              
                                $transaction[$cntr]['tollplaza_id']      = $row['toll_plaza'];
                                $transaction[$cntr]['lane_id']           = $row['id'];
                                $transaction[$cntr]['send_mode']         = explode('=', $filtered[0])[1];
                                $transaction[$cntr]['date']              = implode('-', $date_data);
                                $transaction[$cntr]['time']              = implode(':', $time_data);
                                $transaction[$cntr]['pl_id']             = explode('=', $filtered[1])[1];
                                $transaction[$cntr]['ln_id']             = explode('=', $filtered[2])[1];
                                $transaction[$cntr]['dt_concluded']      = explode('=', $filtered[3])[1];
                                $transaction[$cntr]['tx_seq_nr']         = explode('=', $filtered[4])[1];
                                $transaction[$cntr]['ts_seq_nr']         = explode('=', $filtered[5])[1];
                                $transaction[$cntr]['us_id']             = explode('=', $filtered[6])[1];
                                $transaction[$cntr]['ent_plz_id']        = explode('=', $filtered[7])[1];
                                $transaction[$cntr]['ent_lane_id']       = explode('=', $filtered[8])[1];
                                $transaction[$cntr]['dt_started']        = explode('=', $filtered[9])[1];
                                $transaction[$cntr]['next_inc']          = explode('=', $filtered[10])[1];
                                $transaction[$cntr]['prev_inc']          = explode('=', $filtered[11])[1];
                                $transaction[$cntr]['ft_id']             = explode('=', $filtered[12])[1];
                                // $transaction[$cntr]['pg_group']          = explode('=', $filtered[13])[1];
                                // $transaction[$cntr]['cg_group']          = explode('=', $filtered[14])[1];
                                $transaction[$cntr]['vg_group']          = explode('=', $filtered[15])[1];
                                $transaction[$cntr]['mvc']               = explode('=', $filtered[16])[1];
                                $transaction[$cntr]['avc']               = explode('=', $filtered[17])[1];
                                $transaction[$cntr]['svc']               = explode('=', $filtered[18])[1];
                                $transaction[$cntr]['loc_curr']          = explode('=', $filtered[19])[1];
                                $transaction[$cntr]['loc_value']         = explode('=', $filtered[20])[1];
                                $transaction[$cntr]['ten_curr']          = explode('=', $filtered[21])[1];
                                $transaction[$cntr]['ten_value']         = explode('=', $filtered[22])[1];
                                //$transaction[$cntr]['loc_change']        = explode('=', $filtered[23])[1];
                                //$transaction[$cntr]['variance']          = explode('=', $filtered[24])[1];
                                //$transaction[$cntr]['er_id']             = explode('=', $filtered[25])[1];
                                 $transaction[$cntr]['pm_id']             = explode('=', $filtered[26])[1];
                                // $transaction[$cntr]['card_nr']           = explode('=', $filtered[27])[1];
                                // $transaction[$cntr]['ca_id']             = explode('=', $filtered[28])[1];
                                // $transaction[$cntr]['ct_id']             = explode('=', $filtered[29])[1];
                                // $transaction[$cntr]['conc_nr']           = explode('=', $filtered[30])[1];
                                $transaction[$cntr]['lm_id']             = explode('=', $filtered[31])[1];
                                //$transaction[$cntr]['as_id']             = explode('=', $filtered[32])[1];
                                $transaction[$cntr]['reg_nr']            = explode('=', $filtered[33])[1];
                                $transaction[$cntr]['vouch_nr']          = explode('=', $filtered[34])[1];
                                //$transaction[$cntr]['ac_nr']             = explode('=', $filtered[35])[1];
                                $transaction[$cntr]['rec_nr']            = explode('=', $filtered[36])[1];
                                // $transaction[$cntr]['tick_nr']           = explode('=', $filtered[37])[1];
                                // $transaction[$cntr]['bp_id']             = explode('=', $filtered[38])[1];
                                // $transaction[$cntr]['fg_id']             = explode('=', $filtered[39])[1];
                                // $transaction[$cntr]['dg_id']             = explode('=', $filtered[40])[1];
                                // $transaction[$cntr]['rd_id']             = explode('=', $filtered[41])[1];
                                // $transaction[$cntr]['rep_indic']         = explode('=', $filtered[42])[1];
                                // $transaction[$cntr]['maint_indic']       = explode('=', $filtered[43])[1];
                                // $transaction[$cntr]['req_indic']         = explode('=', $filtered[44])[1];
                                // $transaction[$cntr]['iv_prt_indic']      = explode('=', $filtered[45])[1];
                                $transaction[$cntr]['ts_dt_started']     = explode('=', $filtered[46])[1];
                                // $transaction[$cntr]['iv_nr']             = explode('=', $filtered[47])[1];
                                // $transaction[$cntr]['td_id']             = explode('=', $filtered[48])[1];
                                // $transaction[$cntr]['avc_seq_nr']        = explode('=', $filtered[49])[1];
                                // $transaction[$cntr]['card_bank']         = explode('=', $filtered[50])[1];
                                // $transaction[$cntr]['card_ac_nr']        = explode('=', $filtered[51])[1];
                                // $transaction[$cntr]['tg_mfg_id']         = explode('=', $filtered[52])[1];
                                // $transaction[$cntr]['tg_post_bal']       = explode('=', $filtered[53])[1];
                                // $transaction[$cntr]['tg_reader']         = explode('=', $filtered[54])[1];
                                // $transaction[$cntr]['tg_us_cat']         = explode('=', $filtered[55])[1];
                                // $transaction[$cntr]['tg_card_type']      = explode('=', $filtered[56])[1];
                                // $transaction[$cntr]['tg_serv_prov_id']   = explode('=', $filtered[57])[1];
                                // $transaction[$cntr]['tg_issuer']         = explode('=', $filtered[58])[1];
                                // $transaction[$cntr]['tg_tx_seq_nr']      = explode('=', $filtered[59])[1];
                                //array_push($previous_record,array('tx_seq_nr' => explode('=', $filtered[4])[1],'dt_concluded' => explode('=', $filtered[3])[1]));
                                $previous_record[] = array('tx_seq_nr' => explode('=', $filtered[4])[1],'dt_concluded' => explode('=', $filtered[3])[1]);
                                    
                                $cntr++;
                            }else{
                                 $fnd_key = array_search(explode('=', $filtered[4])[1], array_column($previous_record, 'tx_seq_nr'));
                                 if($previous_record[$fnd_key]['dt_concluded'] != explode('=', $filtered[3])[1]){
                                    echo "else check second <br>";
                                    $transaction[$cntr]['tollplaza_id']      = $row['toll_plaza'];
                                    $transaction[$cntr]['lane_id']           = $row['id'];
                                    $transaction[$cntr]['send_mode']         = explode('=', $filtered[0])[1];
                                    $transaction[$cntr]['date']              = implode('-', $date_data);
                                    $transaction[$cntr]['time']              = implode(':', $time_data);
                                    $transaction[$cntr]['pl_id']             = explode('=', $filtered[1])[1];
                                    $transaction[$cntr]['ln_id']             = explode('=', $filtered[2])[1];
                                    $transaction[$cntr]['dt_concluded']      = explode('=', $filtered[3])[1];
                                    $transaction[$cntr]['tx_seq_nr']         = explode('=', $filtered[4])[1];
                                    $transaction[$cntr]['ts_seq_nr']         = explode('=', $filtered[5])[1];
                                    $transaction[$cntr]['us_id']             = explode('=', $filtered[6])[1];
                                    $transaction[$cntr]['ent_plz_id']        = explode('=', $filtered[7])[1];
                                    $transaction[$cntr]['ent_lane_id']       = explode('=', $filtered[8])[1];
                                    $transaction[$cntr]['dt_started']        = explode('=', $filtered[9])[1];
                                    $transaction[$cntr]['next_inc']          = explode('=', $filtered[10])[1];
                                    $transaction[$cntr]['prev_inc']          = explode('=', $filtered[11])[1];
                                    $transaction[$cntr]['ft_id']             = explode('=', $filtered[12])[1];
                                    // $transaction[$cntr]['pg_group']          = explode('=', $filtered[13])[1];
                                    // $transaction[$cntr]['cg_group']          = explode('=', $filtered[14])[1];
                                    $transaction[$cntr]['vg_group']          = explode('=', $filtered[15])[1];
                                    $transaction[$cntr]['mvc']               = explode('=', $filtered[16])[1];
                                    $transaction[$cntr]['avc']               = explode('=', $filtered[17])[1];
                                    $transaction[$cntr]['svc']               = explode('=', $filtered[18])[1];
                                    $transaction[$cntr]['loc_curr']          = explode('=', $filtered[19])[1];
                                    $transaction[$cntr]['loc_value']         = explode('=', $filtered[20])[1];
                                    $transaction[$cntr]['ten_curr']          = explode('=', $filtered[21])[1];
                                    $transaction[$cntr]['ten_value']         = explode('=', $filtered[22])[1];
                                    //$transaction[$cntr]['loc_change']        = explode('=', $filtered[23])[1];
                                    //$transaction[$cntr]['variance']          = explode('=', $filtered[24])[1];
                                    //$transaction[$cntr]['er_id']             = explode('=', $filtered[25])[1];
                                     $transaction[$cntr]['pm_id']             = explode('=', $filtered[26])[1];
                                    // $transaction[$cntr]['card_nr']           = explode('=', $filtered[27])[1];
                                    // $transaction[$cntr]['ca_id']             = explode('=', $filtered[28])[1];
                                    // $transaction[$cntr]['ct_id']             = explode('=', $filtered[29])[1];
                                    // $transaction[$cntr]['conc_nr']           = explode('=', $filtered[30])[1];
                                    $transaction[$cntr]['lm_id']             = explode('=', $filtered[31])[1];
                                    //$transaction[$cntr]['as_id']             = explode('=', $filtered[32])[1];
                                    $transaction[$cntr]['reg_nr']            = explode('=', $filtered[33])[1];
                                    $transaction[$cntr]['vouch_nr']          = explode('=', $filtered[34])[1];
                                    //$transaction[$cntr]['ac_nr']             = explode('=', $filtered[35])[1];
                                    $transaction[$cntr]['rec_nr']            = explode('=', $filtered[36])[1];
                                    // $transaction[$cntr]['tick_nr']           = explode('=', $filtered[37])[1];
                                    // $transaction[$cntr]['bp_id']             = explode('=', $filtered[38])[1];
                                    // $transaction[$cntr]['fg_id']             = explode('=', $filtered[39])[1];
                                    // $transaction[$cntr]['dg_id']             = explode('=', $filtered[40])[1];
                                    // $transaction[$cntr]['rd_id']             = explode('=', $filtered[41])[1];
                                    // $transaction[$cntr]['rep_indic']         = explode('=', $filtered[42])[1];
                                    // $transaction[$cntr]['maint_indic']       = explode('=', $filtered[43])[1];
                                    // $transaction[$cntr]['req_indic']         = explode('=', $filtered[44])[1];
                                    // $transaction[$cntr]['iv_prt_indic']      = explode('=', $filtered[45])[1];
                                    $transaction[$cntr]['ts_dt_started']     = explode('=', $filtered[46])[1];
                                    // $transaction[$cntr]['iv_nr']             = explode('=', $filtered[47])[1];
                                    // $transaction[$cntr]['td_id']             = explode('=', $filtered[48])[1];
                                    // $transaction[$cntr]['avc_seq_nr']        = explode('=', $filtered[49])[1];
                                    // $transaction[$cntr]['card_bank']         = explode('=', $filtered[50])[1];
                                    // $transaction[$cntr]['card_ac_nr']        = explode('=', $filtered[51])[1];
                                    // $transaction[$cntr]['tg_mfg_id']         = explode('=', $filtered[52])[1];
                                    // $transaction[$cntr]['tg_post_bal']       = explode('=', $filtered[53])[1];
                                    // $transaction[$cntr]['tg_reader']         = explode('=', $filtered[54])[1];
                                    // $transaction[$cntr]['tg_us_cat']         = explode('=', $filtered[55])[1];
                                    // $transaction[$cntr]['tg_card_type']      = explode('=', $filtered[56])[1];
                                    // $transaction[$cntr]['tg_serv_prov_id']   = explode('=', $filtered[57])[1];
                                    // $transaction[$cntr]['tg_issuer']         = explode('=', $filtered[58])[1];
                                    // $transaction[$cntr]['tg_tx_seq_nr']      = explode('=', $filtered[59])[1];
                                    //array_push($previous_record, array('tx_seq_nr' => explode('=', $filtered[4])[1],'dt_concluded' => explode('=', $filtered[3])[1]));
                                    $previous_record[] = array('tx_seq_nr' => explode('=', $filtered[4])[1],'dt_concluded' => explode('=', $filtered[3])[1]);
                                    $cntr++;
                                }
                            }
                        }elseif ($file_name == 'TSaveIncidentMessage') {
                               // $incidents[$incntr]['lane_id']           = $row['id'];
                               // $incidents[$incntr]['send_mode']         =  explode('=', $filtered[0])[1];
                               // $incidents[$incntr]['pl_id']             =  explode('=', $filtered[1])[1];
                               // $incidents[$incntr]['ln_id']             =  explode('=', $filtered[2])[1];
                               // $incidents[$incntr]['dt_generated']      =  explode('=', $filtered[3])[1];
                               // $incidents[$incntr]['in_seq_nr']         =  explode('=', $filtered[4])[1];
                               // $incidents[$incntr]['ir_type']           =  explode('=', $filtered[5])[1];
                               // $incidents[$incntr]['ir_subtype'] =  explode('=', $filtered[6])[1];
                               // $incidents[$incntr]['tx_seq_nr'] =  explode('=', $filtered[7])[1];
                               // $incidents[$incntr]['ts_seq_nr'] =  explode('=', $filtered[8])[1];
                               // $incidents[$incntr]['us_id'] =  explode('=', $filtered[9])[1];
                               // $incidents[$incntr]['ft_id'] =  explode('=', $filtered[10])[1];
                               // $incidents[$incntr]['pg_group'] =  explode('=', $filtered[11])[1];
                               // $incidents[$incntr]['cg_group'] =  explode('=', $filtered[12])[1];
                               // $incidents[$incntr]['vg_group'] =  explode('=', $filtered[13])[1];
                               // $incidents[$incntr]['mvc'] =  explode('=', $filtered[14])[1];
                               // $incidents[$incntr]['avc'] =  explode('=', $filtered[15])[1];
                               // $incidents[$incntr]['svc'] =  explode('=', $filtered[16])[1];
                               // $incidents[$incntr]['er_id'] =  explode('=', $filtered[17])[1];
                               // $incidents[$incntr]['pm_id'] =  explode('=', $filtered[18])[1];
                               // $incidents[$incntr]['card_nr'] =  explode('=', $filtered[19])[1];
                               // $incidents[$incntr]['ca_id'] =  explode('=', $filtered[20])[1];
                               // $incidents[$incntr]['ct_id'] =  explode('=', $filtered[21])[1];
                               // $incidents[$incntr]['tx_indic'] =  explode('=', $filtered[22])[1];
                               // $incidents[$incntr]['lm_id'] =  explode('=', $filtered[23])[1];
                               // $incidents[$incntr]['as_id'] =  explode('=', $filtered[24])[1];
                               // $incidents[$incntr]['rep_indic'] =  explode('=', $filtered[25])[1];
                               // $incidents[$incntr]['rd_id'] =  explode('=', $filtered[26])[1];
                               // $incidents[$incntr]['maint_indic'] =  explode('=', $filtered[27])[1];
                               // $incidents[$incntr]['req_indic'] =  explode('=', $filtered[28])[1];
                               // $incidents[$incntr]['ts_dt_started'] =  explode('=', $filtered[29])[1];
                               // $incidents[$incntr]['in_amt'] =  explode('=', $filtered[30])[1];
                               // $incidents[$incntr]['tg_bl_id'] =  explode('=', $filtered[31])[1];
                               // $incidents[$incntr]['tg_mfg_id'] =  explode('=', $filtered[32])[1];
                               // $incidents[$incntr]['tg_card_type'] =  explode('=', $filtered[33])[1];
                               // $incidents[$incntr]['tg_reader'] =  explode('=', $filtered[34])[1];
                               // $incidents[$incntr]['tg_tx_seq_nr'] =  explode('=', $filtered[35])[1];
                               // $incntr++;
                        }
                    }
                }///////end of foreach for each lane folder files////
                // echo "<pre>";
                // print_r($previous_record);

                $this->db->where('id', $row['id']);
                $this->db->update('tollplaza_lanes',array('updated_date' => end($transaction)['date'],'no_files' => $filecount));
               
              }/////end of check new files for read
            
        }////end of foreach for lanes
        if($transaction){
         
            // echo "<pre>";
            // print_r($transaction); exit;
            $this->db->insert_batch('transactions', $transaction);
            //$this->db->insert_batch('incidents', $incidents);
            echo "Data added successfully";
        }else{
          echo "No new record found";
        }
        
           
    }

 function get_data(){
      
      // echo date('Y-m-d h:m:i A',strtotime($exact)); exit;
      $tollplaza = $this->db->get_where('tollplaza_live',array('status' => 1))->result_array();
      $cntr = 0;
      $transaction = array();
      foreach ($tollplaza as $row) {
        if($row['server_type'] == 1){
          
            ////////////////////////////////   Check If there any already some records of that tollplaza  ///////////////////////////     
            $chk_record_sql = "Select count(vicinity_id) as record FROM transactions WHERE tollplaza_id = ".$row['tollplaza_id'];
            $check_record = $this->db->query($chk_record_sql)->result();
            
            $lanes = $this->db->get_where('tollplaza_lanes',array('toll_plaza' => $row['tollplaza_id'],'status' => 1))->result_array();
            $tp_lanes = array();           
            foreach($lanes as $l){
              $ip = trim($l['ipaddress']);
              $exploded = explode('.', $ip);
              $tp_lanes[$l['id']] = end($exploded);
            }

            $conn = oci_connect($row['username'], $row['password'], $row['server_ip'].'/'.$row['services']);
            if($conn){
                if($check_record[0]->record > 0){
                    $sqlgroup = "SELECT vicinity_id,MAX(date) as max_date FROM transactions WHERE tollplaza_id = ".$row['tollplaza_id']." GROUP BY vicinity_id";
                    $datagroup = $this->db->query($sqlgroup)->result_array();  
                    
                    foreach($datagroup as $dg){
                      $stid = oci_parse($conn, "SELECT * FROM TRANSACTIONS  WHERE VICINITY_ID = '".$dg['vicinity_id']."' AND  CONCLUDED_DATE > '".date('d-M-y h:i:s A',strtotime($dg['max_date']))."'");
                      oci_execute($stid);
                      $data = array();
                      while (($row_oc = oci_fetch_array($stid, OCI_BOTH)) != false) {
                        $data[] = $row_oc;
                      }
                      if (!empty($data)){
                         foreach($data as $key => $value){
                            $str = explode(' ',trim($value['CONCLUDED_DATE']));
                            $str_exp = explode('.',$str[1]);
                            array_pop($str_exp); 
                            $time = implode(':', $str_exp);
                            $date_time = implode(' ', array($time, $str[2]));
                            $exact = implode(' ', array($str[0],$date_time));
                            $transaction[$cntr]['tollplaza_id']      = $row['tollplaza_id'];
                            $transaction[$cntr]['lane_id']           = array_search($value['VICINITY_ID'], $tp_lanes);
                            $transaction[$cntr]['vicinity_id']       = $value['VICINITY_ID'];
                            $transaction[$cntr]['date']              = date('Y-m-d H:i:s',strtotime($exact));
                            $transaction[$cntr]['user_id']           = $value['USER_ID'];
                            $transaction[$cntr]['transaction_id']    = $value['TRANSACTION_ID'];
                            $transaction[$cntr]['timeslice_id']      = $value['TIMESLICE_ID'];;
                            $transaction[$cntr]['ts_started_date']   = $value['TS_STARTED_DATE'];
                            $transaction[$cntr]['mvc']               = $value['MVC'];
                            $transaction[$cntr]['avc']               = $value['AVC'];
                            $transaction[$cntr]['svc']               = $value['SVC'];
                            $transaction[$cntr]['payment_code']      = $value['PAYMENT_CODE'];
                            $transaction[$cntr]['fare_table']        = $value['FT_ID'];
                            $transaction[$cntr]['concluded_date']    = $value['CONCLUDED_DATE'];
                            $transaction[$cntr]['period_group']      = $value['PERIOD_GROUP_ID'];
                            $transaction[$cntr]['loc_value']         = $value['LOCAL_VALUE'];
                            $transaction[$cntr]['ten_value']         = $value['TEN_VALUE'];
                            $transaction[$cntr]['avc_status']        = $value['AVC_STATUS'];
                            $transaction[$cntr]['avc_seq_number']    = $value['AVC_SEQ_NUMBER'];
                            $transaction[$cntr]['avc_dt_concluded']  = $value['AVC_DT_CONCLUDED'];
                            $transaction[$cntr]['dt_started']        = $value['START_DATE'];
                            $cntr++;
                            
                          }
                      }
                    }
                }else{
                    $current_date = date('d-M-y');
                    $stid = oci_parse($conn, "SELECT * FROM TRANSACTIONS  WHERE CONCLUDED_DATE >= '".$current_date."'");
                    oci_execute($stid);
                    $data = array();
                    while (($row_oc = oci_fetch_array($stid, OCI_BOTH)) != false) {
                      $data[] = $row_oc;
                    }
                    // echo "<pre>";
                    // print_r($data); exit;
                    if (!empty($data)){
                      foreach($data as $key => $value){
                        $str = explode(' ',trim($value['CONCLUDED_DATE']));
                        $str_exp = explode('.',$str[1]);
                        array_pop($str_exp); 
                        $time = implode(':', $str_exp);
                        $date_time = implode(' ', array($time, $str[2]));
                        $exact = implode(' ', array($str[0],$date_time));
                        $transaction[$cntr]['tollplaza_id']      = $row['tollplaza_id'];
                        $transaction[$cntr]['lane_id']           = array_search($value['VICINITY_ID'], $tp_lanes);
                        $transaction[$cntr]['vicinity_id']       = $value['VICINITY_ID'];
                        $transaction[$cntr]['date']              = date('Y-m-d H:i:s',strtotime($exact));
                        $transaction[$cntr]['user_id']           = $value['USER_ID'];
                        $transaction[$cntr]['transaction_id']    = $value['TRANSACTION_ID'];
                        $transaction[$cntr]['timeslice_id']      = $value['TIMESLICE_ID'];;
                        $transaction[$cntr]['ts_started_date']   = $value['TS_STARTED_DATE'];
                        $transaction[$cntr]['mvc']               = $value['MVC'];
                        $transaction[$cntr]['avc']               = $value['AVC'];
                        $transaction[$cntr]['svc']               = $value['SVC'];
                        $transaction[$cntr]['payment_code']      = $value['PAYMENT_CODE'];
                        $transaction[$cntr]['fare_table']        = $value['FT_ID'];
                        $transaction[$cntr]['concluded_date']    = $value['CONCLUDED_DATE'];
                        $transaction[$cntr]['period_group']      = $value['PERIOD_GROUP_ID'];
                        $transaction[$cntr]['loc_value']         = $value['LOCAL_VALUE'];
                        $transaction[$cntr]['ten_value']         = $value['TEN_VALUE'];
                        $transaction[$cntr]['avc_status']        = $value['AVC_STATUS'];
                        $transaction[$cntr]['avc_seq_number']    = $value['AVC_SEQ_NUMBER'];
                        $transaction[$cntr]['avc_dt_concluded']  = $value['AVC_DT_CONCLUDED'];
                        $transaction[$cntr]['dt_started']        = $value['START_DATE'];
                        $cntr++;
                        
                      }
                    }
                }
                
                    
               
            }
            else{
                echo 'no';
            }
        }
      }

      if(!empty($transaction)){
          $this->db->insert_batch('transactions', $transaction); 
          echo "Added Successfully"; exit; 
                
      }
       
        
 }
 function groupdata(){

  $active_weigh = $this->db->get_where('weighstation',array('status' => 1))->result_array();
  // echo "<pre>";
  // print_r($active_weigh); exit;
  //foreach ($active_weigh as $key => $value) {
    //echo $first_day_this_month = date('Y-m-01'); // hard-coded '01' for first day
    $sql = "SELECT count(weighstation_data.id) as total_records, weighstation.id as weighstration, DATE_FORMAT(`date`,'%j') as `date`, DATE_FORMAT(`date`,'%d-%m-%Y') as `dateee` FROM `weighstation`

    INNER JOIN weighstation_data ON weighstation.id = weighstation_data.weigh_id
    WHERE `date` < '".date('Y-m-01')."'
    GROUP BY YEAR(`date`), MONTH(`date`), DAY(`date`), weigh_id";
    // $sql = $sql = "SELECT count(weighstation_data.id) as total_records FROM `weighstation_data`

    // WHERE `date` < '".date('Y-m-01')."'";
    $data = $this->db->query($sql)->result_array(); 
    //echo $this->db->last_query(); exit;
    $sum = 0;
    foreach($data as $key => $value){
      $sum+= $value['total_records'];
    }
    // $q = "SELECT MAX(id) FROM weighstation_data";
    // print_r( $this->db->query($q)->result_array());
    echo "<br>";
    echo $sum."<br>";
    echo "<pre>";
    print_r($data); exit;
  //}
  //$sql11 = "EMA.COLUMNS WHERE TABLE_SCHEMA='nha' AND TABLE_NAME='weighstation_data'";
   //$res = $this->db->query($sql11)->result();
    // echo "<pre>";
    // print_r($res); exit;
  $s = "SET SESSION group_concat_max_len = 10000000";
  $this->db->query($s);
   $sql = "SELECT
    GROUP_CONCAT(id) as ids,
    COUNT(id),
    DATE_FORMAT(date, '%M %Y') AS MONTH
FROM
    weighstation_data
GROUP BY
    DATE_FORMAT(date, '%M %Y')
    ORDER BY
        date DESC";

    $result = $this->db->query($sql)->result_array();
    $tp = array();

    foreach($result as $row){
      $sql1 = "SELECT
    GROUP_CONCAT(id) as idss,
    COUNT(id),
    weigh_id,
    DATE_FORMAT(date, '%M %Y') AS MONTH
FROM
    weighstation_data
WHERE id IN (".$row['ids'].")
GROUP BY
    weigh_id";
    $res = $this->db->query($sql1)->result_array();
    echo "<pre>";
    print_r($res); 
      

    }
 }

}

?>