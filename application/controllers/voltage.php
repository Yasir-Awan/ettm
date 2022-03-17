<?php
defined('BASEPATH') or exit('NO DIRECT SCRIPT ALLOWED');

class Voltage extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->page_data = array();
    }

    public function index()
    {
        $weigh = $this->db->get_where('weighstation', array('status' => 1, 'software_type' => 4))->result_array();
        // echo '<pre>';
        // print_r($weigh); exit;
        if ($weigh) {
            foreach ($weigh as $row) {
                // $ins_data = array();
                // $dir = 'ftp://'.$row['address'].'/';
                // $dir_cmplt = 'ftp://'.$row['address'].'/WSCP/WP_Reports/';

                // $conn_id = ftp_connect($row['address']);

                // if($conn_id){
                //    if(file_exists($dir_cmplt.''.$file)){
                // echo $dir.''.$file; exit;
                $counter = 0;

                $file_data = file_get_contents('DataLog');
                $data_exp = array_values(array_filter(explode(PHP_EOL, $file_data)));

                $result = array_map(function ($val) {
                    return $parts = preg_split('/\s+/', $val);
                }, $data_exp);

                unset($result[0]);
                $finl = array_values($result);
                // echo "<pre>";
                // print_r($finl); exit;
                foreach ($finl as $key => $value) {
                    $ins_data[$counter]['weigh_id '] = $row['id'];
                    $dates_param =  explode('/', $value[0]);
                    $date_format = $dates_param[2] . '-' . $dates_param[0] . '-' . $dates_param[1] . " " . $value[1];
                    $ins_data[$counter]['date '] = $date_format;
                    $ins_data[$counter]['line_voltage'] = $value[4];
                    $ins_data[$counter]['output_voltage'] = $value[5];
                    $ins_data[$counter]['output_frequency'] = $value[6];
                    $ins_data[$counter]['battery_voltage'] = $value[7];
                    $ins_data[$counter]['ups_load'] = $value[8];
                    $ins_data[$counter]['ups_temprature'] = $value[9];
                    $ins_data[$counter]['input_frequency'] = $value[14];
                    $ins_data[$counter]['battery_capacity'] = $value[15];
                    $counter++;
                }
                echo "<pre>";
                print_r($ins_data);
                exit;

                //} ///end of first file exist 

                // echo "<pre>";
                // print_r($ins_data); exit;

                if ($ins_data) {
                    $this->db->insert_batch('voltage', $ins_data);
                } else {
                    $this->db->where('id', $row['id']);
                    $this->db->update('weighstation', array('last_updated' => time(), 'con_status' => 1));
                }
                // }else{
                //         $this->db->where('id',$row['id']);
                //         $this->db->update('weighstation',array('con_status' => 0,'last_updated' => time()));
                // } ////end of if connection established
            } ///end of foreach loop over toll plaza
        } ////end of if weigh station is not empty
    }
}
