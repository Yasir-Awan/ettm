<?php
defined('BASEPATH') or exit('NO DIRECT SCRIPT ALLOWED');
class Ups_data_acquisition extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // if (!$this->session->userdata('admin_id')) {
        //     redirect(base_url() . 'admin/login');
        // }
        // $this->page_data = array();
        // $this->load->model("General");
        // $this->load->model('Tollplaza_model');
        // $this->load->model('Inventory_model');
        // $this->page_data['toolplaza'] = $this->db->get_where('toolplaza', array('id' => $this->session->userdata('toolplaza')))->result_array();
    }

    public function index()
    {
        $ups_ip = $this->db->get_where('ups_ftp_credentials', array('status' => 1))->result_array();
        // echo "<pre>"; print_r($ups_ip); exit;
        $ins_data = array();
        foreach ($ups_ip as $row) {
            $fileDateTimeStamp = '';
            $systemId = $row['id'];
            $site = $row['site'];
            $db_start_date = $this->db->select('*')->where('system_id', $systemId)->order_by('date', 'asc')->limit(1)->get('ups_data')->result_array();
            $db_end_date = $this->db->select('*')->where('system_id', $systemId)->order_by('date', 'desc')->limit(1)->get('ups_data')->result_array();
            // echo $db_start_date[0]['date'];
            // echo $db_end_date[0]['date'];
            $ftp_server = $row['ip'];
            // define some variables
            
            $local_file = 'D:/Xampp/htdocs/nha/assets/UPS/local.txt';
            $server_file = 'ftp://' . $row['ip'] . '/data.txt';
            // set up basic connection
            $ftp = ftp_connect($ftp_server);
            // login with username and password
            $login_result = ftp_login($ftp, 'apc', 'apc');
            // try to download $server_file and save to $local_file
            if (ftp_get($ftp, $local_file, $server_file, FTP_BINARY)) {
                echo "Successfully written to $local_file <br>";

                $file_data = file_get_contents('D:/Xampp/htdocs/nha/assets/UPS/local.txt');
                $data_exp = array_values(array_filter(explode(PHP_EOL, $file_data)));

                $result = array_map(function ($val) {
                    return $parts = preg_split('/\s+/', $val);
                }, $data_exp);

                if ($systemId == 1) {
                    $upsName = $result[3][0] . " " . $result[3][1] . " " . $result[3][2] . " " . $result[3][3] . " " . $result[3][4];
                    $dateTime_of_file =  explode('/', $result[5][0]);
                    $fileDateTimeStamp = $dateTime_of_file[2] . '-' . $dateTime_of_file[0] . '-' . $dateTime_of_file[1] . " " . $result[5][1];
                    unset($result[0]);
                    unset($result[1]);
                    unset($result[2]);
                    unset($result[3]);
                    unset($result[4]);
                } else {
                    $upsName = $result[1][0] . " " . $result[1][1] . " " . $result[1][2] . " " . $result[1][3] . " " . $result[1][4];
                    $dateTime_of_file =  explode('/', $result[6][0]);
                    $fileDateTimeStamp = $dateTime_of_file[2] . '-' . $dateTime_of_file[0] . '-' . $dateTime_of_file[1] . " " . $result[6][1];
                    unset($result[0]);
                    unset($result[1]);
                    unset($result[2]);
                    unset($result[3]);
                    unset($result[4]);
                    unset($result[5]);
                }

                $contents = array_values($result);
                $finl = array_reverse($contents);

                if (empty($db_end_date[0]['date'])) {
                    $counter = 0;
                    foreach ($finl as $key => $value) {
                        $dates_param =  explode('/', $value[0]);
                        $date_format = $dates_param[2] . '-' . $dates_param[0] . '-' . $dates_param[1] . " " . $value[1];
                        $ins_data[$counter]['system_id'] = $systemId;
                        $ins_data[$counter]['site'] = $site;
                        $ins_data[$counter]['ups_name'] = $upsName;
                        $ins_data[$counter]['date'] = $date_format;
                        $ins_data[$counter]['Vmin1'] = $value[2];
                        $ins_data[$counter]['Vmin2'] = $value[3];
                        $ins_data[$counter]['Vmin3'] = $value[4];
                        $ins_data[$counter]['Vmax1'] = $value[5];
                        $ins_data[$counter]['Vmax2'] = $value[6];
                        $ins_data[$counter]['Vmax3'] = $value[7];
                        $ins_data[$counter]['Vbp1'] = $value[8];
                        $ins_data[$counter]['Vbp2'] = $value[9];
                        $ins_data[$counter]['Vbp3'] = $value[10];
                        $ins_data[$counter]['Iin1'] = $value[11];
                        $ins_data[$counter]['Iin2'] = $value[12];
                        $ins_data[$counter]['Iin3'] = $value[13];
                        $ins_data[$counter]['Vout1'] = $value[14];
                        $ins_data[$counter]['Vout2'] = $value[15];
                        $ins_data[$counter]['Vout3'] = $value[16];
                        $ins_data[$counter]['Iout1'] = $value[17];
                        $ins_data[$counter]['Iout2'] = $value[18];
                        $ins_data[$counter]['Iout3'] = $value[19];
                        $ins_data[$counter]['Wout1'] = $value[20];
                        $ins_data[$counter]['Wout2'] = $value[21];
                        $ins_data[$counter]['Wout3'] = $value[22];
                        $ins_data[$counter]['KVAout1'] = $value[23];
                        $ins_data[$counter]['KVAout2'] = $value[24];
                        $ins_data[$counter]['KVAout3'] = $value[25];
                        $ins_data[$counter]['frequency'] = $value[26];
                        $ins_data[$counter]['capacity'] = $value[27];
                        $ins_data[$counter]['Vbat'] = $value[28];
                        $ins_data[$counter]['Ibat'] = $value[29];
                        $ins_data[$counter]['ups_temperature'] = $value[30];
                        $counter++;
                    }
                }
                if (!empty($db_end_date[0]['date'])) {
                    $counter = 0;
                    $new_contents = array();
                    if ($fileDateTimeStamp > $db_end_date[0]['date']) {
                        foreach ($contents as $key => $value) {
                            $dates_param =  explode('/', $value[0]);
                            $date_format = $dates_param[2] . '-' . $dates_param[0] . '-' . $dates_param[1] . " " . $value[1];
                            if ($db_end_date[0]['date'] < $date_format) {
                                $new_contents[] = $value;
                            }
                            if ($db_end_date[0]['date'] >= $date_format) {
                                break;
                            }
                        }
                    }
                    $finl = array_reverse($new_contents);
                    foreach ($finl as $key => $value) {
                        $dates_param =  explode('/', $value[0]);
                        $date_format = $dates_param[2] . '-' . $dates_param[0] . '-' . $dates_param[1] . " " . $value[1];
                        $ins_data[$counter]['system_id'] = $systemId;
                        $ins_data[$counter]['site'] = $site;
                        $ins_data[$counter]['ups_name'] = $upsName;
                        $ins_data[$counter]['date'] = $date_format;
                        $ins_data[$counter]['Vmin1'] = $value[2];
                        $ins_data[$counter]['Vmin2'] = $value[3];
                        $ins_data[$counter]['Vmin3'] = $value[4];
                        $ins_data[$counter]['Vmax1'] = $value[5];
                        $ins_data[$counter]['Vmax2'] = $value[6];
                        $ins_data[$counter]['Vmax3'] = $value[7];
                        $ins_data[$counter]['Vbp1'] = $value[8];
                        $ins_data[$counter]['Vbp2'] = $value[9];
                        $ins_data[$counter]['Vbp3'] = $value[10];
                        $ins_data[$counter]['Iin1'] = $value[11];
                        $ins_data[$counter]['Iin2'] = $value[12];
                        $ins_data[$counter]['Iin3'] = $value[13];
                        $ins_data[$counter]['Vout1'] = $value[14];
                        $ins_data[$counter]['Vout2'] = $value[15];
                        $ins_data[$counter]['Vout3'] = $value[16];
                        $ins_data[$counter]['Iout1'] = $value[17];
                        $ins_data[$counter]['Iout2'] = $value[18];
                        $ins_data[$counter]['Iout3'] = $value[19];
                        $ins_data[$counter]['Wout1'] = $value[20];
                        $ins_data[$counter]['Wout2'] = $value[21];
                        $ins_data[$counter]['Wout3'] = $value[22];
                        $ins_data[$counter]['KVAout1'] = $value[23];
                        $ins_data[$counter]['KVAout2'] = $value[24];
                        $ins_data[$counter]['KVAout3'] = $value[25];
                        $ins_data[$counter]['frequency'] = $value[26];
                        $ins_data[$counter]['capacity'] = $value[27];
                        $ins_data[$counter]['Vbat'] = $value[28];
                        $ins_data[$counter]['Ibat'] = $value[29];
                        $ins_data[$counter]['ups_temperature'] = $value[30];
                        $counter++;
                    }
                    echo "data already exists";
                }

                if ($ins_data) {
                    $this->db->insert_batch('ups_data', $ins_data);
                    unset($ins_data);
                    file_put_contents("D:/Xampp/htdocs/nha/assets/UPS/local.txt", "");
                }
                // else {
                //     $this->db->where('id', $systemId);
                //     $this->db->update('weighstation', array('last_updated' => time(), 'con_status' => 1));
                // }
            } else {
                echo "There was a network problem\n";
            }
            // close the connection
            ftp_close($ftp);
        }
        ///end of foreach loop 
    }
}//class End
