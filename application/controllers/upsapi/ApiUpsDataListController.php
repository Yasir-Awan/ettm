<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class ApiUpsDataListController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ups_dashboard_model');
    }
    // public function index_get($site)
    // {
    //     $headers = apache_request_headers();
    //     $head = explode(" ", $headers['Authorization']);

    //     $token = $head[1];
    //     if ($token == $this->session->userdata('access_token')) {
    //         if ($site) {
    //             $inventory = new ApiSiteRelatedInventoryModel;
    //             $site_inventory = $inventory->get_SiteInventory($site);

    //             if (!empty($site_inventory)) {
    //                 $this->response($site_inventory, 200);
    //             } else {
    //                 $this->response(['status' => FALSE, 'message' => 'Inventory Not Found.'], REST_Controller::HTTP_NOT_FOUND);
    //             }
    //         }
    //     } else {
    //         $this->response('Unauthorized Access', 401);
    //     }
    //     // echo "<pre>";
    //     // print_r($site_inventory);
    //     // exit;
    // }

    public function index_get()
    {
        // $name = 'yasir';

        // if (!$this->session->userdata('adminid')) {
        //     return redirect('admin/login');
        // }
        // if ($this->session->userdata('adminid') == 22) {
        //     return redirect('NHMP_dashboard/index');
        // }


        $data = $this->Ups_dashboard_model->chartdata();

        $incrementedDateStamp = strtotime(date("Y-m-d", strtotime($data['end_date'])) . "+ 1 days");
        $incrementedDay = date("Y-m-d", $incrementedDateStamp);
        $ups_data = $this->db->select('*')->where('system_id', $data['system_id'])->where('date>=', $data['start_date'])->where('date <', $incrementedDay)->get('ups_data')->result_array();

        $this->page_data['tollplaza'] = $this->db->get_where('ups_ftp_credentials', array('status' => 1))->result_array();
        $ups_view_data = array();
        $s_date = date("Y-m-d", strtotime($ups_data[0]['date']));
        $date = strtotime(date("Y-m-d", strtotime($s_date)));
        $e_date = date("Y-m-d", $date);
        $data1 = explode('-', $e_date);

        $vMin = 0;
        $vMax = 0;
        $vBp1 = 0;
        $Iin1 = 0;
        $Vout1 = 0;
        $Iout1 = 0;
        $Wout1 = 0;
        $KVAout1 = 0;
        $frequency = 0;
        $Ibat = 0;
        $Vbat = 0;
        $capacity = 0;
        $temp = 0;

        $counter = 0;
        $index = 0;
        $missingHourIndex = 0;

        $hoursCount = 0;
        $missingHours = array();
        $missingHourTimings = array();
        $missingTimingsIndex = 0;

        // Extracting First Record Date & Time Start
        $p_date = date("Y-m-d H:i:s", strtotime($ups_data[0]['date']));
        $preDate = strtotime(date("Y-m-d", strtotime($p_date)));
        $preTime = strtotime(date("H:i:s", strtotime($p_date)));
        $prevDate = date("Y-m-d", $preDate);
        $prevTime = date("H:i:s", $preTime);
        $prevDateArr = explode('-', $prevDate);
        $prevTimeArr = explode(':', $prevTime);
        // Extracting First Record Date & Time End

        $total_records = count($ups_data);
        $last_index = $total_records - 1;
        $l_date = date("Y-m-d", strtotime($ups_data[$last_index]['date']));
        $fomattedLastDate = strtotime(date("Y-m-d", strtotime($l_date)));
        $lastDay = date("Y-m-d", $fomattedLastDate);
        $explodedLastDay = explode('-', $lastDay);

        foreach ($ups_data as $key => $val) {
            // Extracting Running Record Date & Time Start
            $r_date = date("Y-m-d H:i:s", strtotime($val['date']));
            $fomattedDate = strtotime(date("Y-m-d", strtotime($r_date)));
            $fomattedTime = strtotime(date("H:i:s", strtotime($r_date)));
            $fomattedDateTime = strtotime(date("Y-m-d H:i:s", strtotime($r_date)));
            $currentDate = date("Y-m-d", $fomattedDate);
            $rTime = date("H:i:s", $fomattedTime);
            $rDateTime = date("Y-m-d H:i:s", $fomattedDateTime);
            $runningDate = explode('-', $currentDate);
            $runningTime = explode(':', $rTime);
            $runningDateTime = explode(':', $rDateTime);
            // Extracting Running Record Date & Time End

            if ($key < $last_index) {
                $n_date = date("Y-m-d", strtotime($ups_data[$key + 1]['date']));
                $fomattedNDate = strtotime(date("Y-m-d", strtotime($n_date)));
                $postDate = date("Y-m-d", $fomattedNDate);

                $nextDate = explode('-', $postDate);
                if ($nextDate[2] == $runningDate[2]) {
                    // check to calculate missing hours Start
                    if ($key > 0) {
                        $bg_date = date("Y-m-d H:i:s", strtotime($ups_data[$key - 1]['date']));
                        $fomattedBgDate = strtotime(date("Y-m-d", strtotime($bg_date)));
                        $fomattedBgTime = strtotime(date("H:i:s", strtotime($bg_date)));
                        $fomattedBgDateTime = strtotime(date("Y-m-d H:i:s", strtotime($bg_date)));
                        $bgDate = date("Y-m-d", $fomattedBgDate);
                        $bgTime = date("H:i:s", $fomattedBgTime);
                        $bgDateTime = date("Y-m-d H:i:s", $fomattedBgDateTime);
                        $explodedBgDate = explode('-', $bgDate);
                        $explodedBgTime = explode(':', $bgTime);
                        $explodedBgDateTime = explode(':', $bgDateTime);
                        $date1 = new DateTime($rDateTime);
                        $date2 = new DateTime($bgDateTime);
                        $interval = $date1->diff($date2);

                        if ($interval->h > 1) {
                            $hoursCount = $hoursCount + $interval->h;
                            $missingHours[$missingHourIndex] = $bgTime . " to " . $rTime;
                            $missingHourIndex++;
                        }
                        if ($interval->h <= 1) {
                            $missingHours[$missingHourIndex] =   "00:00:00 to 00:00:00";
                        }
                    }
                    // check to calculate missing hours End
                    $vMin = $vMin + $val['Vmin1'];
                    $vMax = $vMax + $val['Vmax1'];
                    $vBp1 = $vBp1 + $val['Vbp1'];
                    $Iin1 = $Iin1 + $val['Iin1'];
                    $Vout1 = $Vout1 + $val['Vout1'];
                    $Iout1 = $Iout1 + $val['Iout1'];
                    $Wout1 = $Wout1 + $val['Wout1'];
                    $KVAout1 = $KVAout1 + $val['KVAout1'];
                    $frequency = $frequency + $val['frequency'];
                    $Ibat = $Ibat + $val['Ibat'];
                    $Vbat = $Vbat + $val['Vbat'];
                    $capacity = $capacity + $val['capacity'];
                    $temp = $temp + $val['ups_temperature'];
                    $index++;
                } else if ($nextDate[2] > $runningDate[2]) {
                    $bg_date = date("Y-m-d H:i:s", strtotime($ups_data[$key - 1]['date']));
                    $fomattedBgDate = strtotime(date("Y-m-d", strtotime($bg_date)));
                    $fomattedBgTime = strtotime(date("H:i:s", strtotime($bg_date)));
                    $fomattedBgDateTime = strtotime(date("Y-m-d H:i:s", strtotime($bg_date)));
                    $bgDate = date("Y-m-d", $fomattedBgDate);
                    $bgTime = date("H:i:s", $fomattedBgTime);
                    $bgDateTime = date("Y-m-d H:i:s", $fomattedBgDateTime);
                    $explodedBgDate = explode('-', $bgDate);
                    $explodedBgTime = explode(':', $bgTime);
                    $explodedBgDateTime = explode(':', $bgDateTime);
                    $date1 = new DateTime($rDateTime);
                    $date2 = new DateTime($bgDateTime);
                    $interval = $date1->diff($date2);

                    if ($interval->h > 1) {
                        $hoursCount = $hoursCount + $interval->h;
                        $missingHours[$missingHourIndex] = $bgTime . "to" . $rTime;
                        $missingHourTimings[$missingTimingsIndex] = $missingHours;
                        $missingTimingsIndex++;
                        if ($key + 1 < $last_index) {
                            $missingHourIndex++;
                        }
                    }
                    if ($interval->h <= 1) {
                        unset($missingHours[$missingHourIndex]);
                        $missingHourTimings[$missingTimingsIndex] = $missingHours;
                    }
                    $vMin = $vMin + $val['Vmin1'];
                    $vMax = $vMax + $val['Vmax1'];
                    $vBp1 = $vBp1 + $val['Vbp1'];
                    $Iin1 = $Iin1 + $val['Iin1'];
                    $Vout1 = $Vout1 + $val['Vout1'];
                    $Iout1 = $Iout1 + $val['Iout1'];
                    $Wout1 = $Wout1 + $val['Wout1'];
                    $KVAout1 = $KVAout1 + $val['KVAout1'];
                    $frequency = $frequency + $val['frequency'];
                    $Ibat = $Ibat + $val['Ibat'];
                    $Vbat = $Vbat + $val['Vbat'];
                    $capacity = $capacity + $val['capacity'];
                    $temp = $temp + $val['ups_temperature'];
                    $divider = $index + 1;
                    $avgVmin = $vMin / $divider;
                    $avgVmax = $vMax / $divider;
                    $avgVbp1 = $vBp1 / $divider;
                    $avgIin1 = $Iin1 / $divider;
                    $avgVout1 = $Vout1 / $divider;
                    $avgIout1 = $Iout1 / $divider;
                    $avgWout1 = $Wout1 / $divider;
                    $avgKVAout1 = $KVAout1 / $divider;
                    $avgFreq = $frequency / $divider;
                    $avgIbat = $Ibat / $divider;
                    $avgVbat = $Vbat / $divider;
                    $avgCapacity = $capacity / $divider;
                    $avgTemp = $temp / $divider;

                    $ups_view_data[$counter]['hourCount'] = $hoursCount;
                    $ups_view_data[$counter]['hours'] = $missingHourTimings[0];
                    $ups_view_data[$counter]['site'] = $val['site'];
                    $ups_view_data[$counter]['system_id'] = $val['system_id'];
                    $ups_view_data[$counter]['date'] = $currentDate;
                    $ups_view_data[$counter]['avg_Vmin'] = $avgVmin;
                    $ups_view_data[$counter]['avg_Vmax'] = $avgVmax;
                    $ups_view_data[$counter]['avg_Vbp1'] = $avgVbp1;
                    $ups_view_data[$counter]['avg_Iin1'] = $avgIin1;
                    $ups_view_data[$counter]['avg_Vout1'] = $avgVout1;
                    $ups_view_data[$counter]['avg_Iout1'] = $avgIout1;
                    $ups_view_data[$counter]['avg_Wout1'] = $avgWout1;
                    $ups_view_data[$counter]['avg_KVAout1'] = $avgKVAout1;
                    $ups_view_data[$counter]['avg_freq'] = $avgFreq;
                    $ups_view_data[$counter]['avg_Ibat'] = $avgIbat;
                    $ups_view_data[$counter]['avg_Vbat'] = $avgVbat;
                    $ups_view_data[$counter]['avg_capacity'] = $avgCapacity;
                    $ups_view_data[$counter]['avg_Temp'] = $avgTemp;
                    $counter++;

                    $missingHourTimings = [];
                    $missingHours = [];
                    $missingTimingsIndex = 0;
                    $missingHourIndex = 0;
                    $hoursCount = 0;
                    $index = 0;
                    $vMin = 0;
                    $vMax = 0;
                    $vBp1 = 0;
                    $Iin1 = 0;
                    $Vout1 = 0;
                    $Iout1 = 0;
                    $Wout1 = 0;
                    $KVAout1 = 0;
                    $frequency = 0;
                    $Ibat = 0;
                    $Vbat = 0;
                    $capacity = 0;
                    $temp = 0;
                }
            }
            if ($key == $last_index) {
                $bg_date = date("Y-m-d H:i:s", strtotime($ups_data[$key - 1]['date']));
                $fomattedBgDate = strtotime(date("Y-m-d", strtotime($bg_date)));
                $fomattedBgTime = strtotime(date("H:i:s", strtotime($bg_date)));
                $fomattedBgDateTime = strtotime(date("Y-m-d H:i:s", strtotime($bg_date)));
                $bgDate = date("Y-m-d", $fomattedBgDate);
                $bgTime = date("H:i:s", $fomattedBgTime);
                $bgDateTime = date("Y-m-d H:i:s", $fomattedBgDateTime);
                $explodedBgDate = explode('-', $bgDate);
                $explodedBgTime = explode(':', $bgTime);
                $explodedBgDateTime = explode(':', $bgDateTime);
                $date1 = new DateTime($rDateTime);
                $date2 = new DateTime($bgDateTime);
                $interval = $date1->diff($date2);

                if ($interval->h > 1) {
                    $hoursCount = $hoursCount + $interval->h;
                    $missingHours[$missingHourIndex] = $bgTime . " to " . $rTime;
                    $missingHourTimings[$missingTimingsIndex] = $missingHours;
                }
                if ($interval->h <= 1) {
                }


                $divider = $index + 1;
                $vMin = $vMin + $val['Vmin1'];
                $vMax = $vMax + $val['Vmax1'];
                $vBp1 = $vBp1 + $val['Vbp1'];
                $Iin1 = $Iin1 + $val['Iin1'];
                $Vout1 = $Vout1 + $val['Vout1'];
                $Iout1 = $Iout1 + $val['Iout1'];
                $Wout1 = $Wout1 + $val['Wout1'];
                $KVAout1 = $KVAout1 + $val['KVAout1'];
                $frequency = $frequency + $val['frequency'];
                $Ibat = $Ibat + $val['Ibat'];
                $Vbat = $Vbat + $val['Vbat'];
                $capacity = $capacity + $val['capacity'];
                $temp = $temp + $val['ups_temperature'];

                $avgVmin = $vMin / $divider;
                $avgVmax = $vMax / $divider;
                $avgVbp1 = $vBp1 / $divider;
                $avgIin1 = $Iin1 / $divider;
                $avgVout1 = $Vout1 / $divider;
                $avgIout1 = $Iout1 / $divider;
                $avgWout1 = $Wout1 / $divider;
                $avgKVAout1 = $KVAout1 / $divider;
                $avgFreq = $frequency / $divider;
                $avgIbat = $Ibat / $divider;
                $avgVbat = $Vbat / $divider;
                $avgCapacity = $capacity / $divider;
                $avgTemp = $temp / $divider;

                $ups_view_data[$counter]['hourCount'] = $hoursCount;
                $ups_view_data[$counter]['hours'] = $missingHourTimings[0];
                $ups_view_data[$counter]['site'] = $val['site'];
                $ups_view_data[$counter]['system_id'] = $val['system_id'];
                $ups_view_data[$counter]['date'] = $currentDate;
                $ups_view_data[$counter]['avg_Vmin'] = $avgVmin;
                $ups_view_data[$counter]['avg_Vmax'] = $avgVmax;
                $ups_view_data[$counter]['avg_Vbp1'] = $avgVbp1;
                $ups_view_data[$counter]['avg_Iin1'] = $avgIin1;
                $ups_view_data[$counter]['avg_Vout1'] = $avgVout1;
                $ups_view_data[$counter]['avg_Iout1'] = $avgIout1;
                $ups_view_data[$counter]['avg_Wout1'] = $avgWout1;
                $ups_view_data[$counter]['avg_KVAout1'] = $avgKVAout1;
                $ups_view_data[$counter]['avg_freq'] = $avgFreq;
                $ups_view_data[$counter]['avg_Ibat'] = $avgIbat;
                $ups_view_data[$counter]['avg_Vbat'] = $avgVbat;
                $ups_view_data[$counter]['avg_capacity'] = $avgCapacity;
                $ups_view_data[$counter]['avg_Temp'] = $avgTemp;
            }
        }
        $missingHourTimings = [];
        $missingHours = [];
        $missingTimingsIndex = 0;
        $missingHourIndex = 0;
        $hoursCount = 0;
        $numberOfDays = count($ups_view_data);
        $monthlyTemp = 0;
        $monthlyVbat = 0;
        foreach ($ups_data as $value) {
            $monthlyTemp = $monthlyTemp + $value['ups_temperature'];
            $monthlyVbat = $monthlyVbat + $value['Vbat'];
        }

        $oneDayTemp = $monthlyTemp / $numberOfDays;
        $oneDayVbat = $monthlyVbat / $numberOfDays;
        $this->page_data['monthlyTemp'] = $oneDayTemp / 24;
        $this->page_data['monthlyVbat'] = $oneDayVbat / 24;

        $this->page_data['ups_data'] = $ups_view_data;

        $this->page_data['page'] = 'UPS Dashboard';
        $this->response($ups_view_data, 200);
        // $this->load->view('back/ups_dashboard', $this->page_data);
    }
    //////////////////////////////////////////////////////
    ////////** UPS Dashboard Timer START *//////////////
    //////////////////////////////////////////////////////

    public function dashboard_timer($para1 = '')
    {
        $plaza = $this->input->post('plaza_id');
        $month = $this->input->post('month');
        $data = $this->Admin_model->timer_chartdata($plaza, $month);
        $previous_year = date("Y-m-d", strtotime(@$data['chart']['month'] . ' -1 year'));
        $previous_monthDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime(@$data['chart']['month'])) . "-1 month"));
        $pre_year_data = $this->Admin_model->get_chart_by(@$data['chart']['toolplaza_id'], $previous_year);
        $pre_month_data = $this->Admin_model->get_chart_by(@$data['chart']['toolplaza_id'], $previous_monthDate);

        $this->page_data['mtr'] = $this->db->get_where('mtr', array('id' => $data['mtr_id']))->result_array();
        $month_year = explode('-', $this->page_data['mtr'][0]['for_month']);
        $start_date = $month_year[0] . '-' . $month_year[1] . '-' . $this->page_data['mtr'][0]['start_date'];
        $end_date = $month_year[0] . '-' . $month_year[1] . '-' . $this->page_data['mtr'][0]['end_date'];
        $sql = "Select * From terrif Where FIND_IN_SET (" . $this->page_data['mtr'][0]['toolplaza'] . " ,toolplaza) AND (start_date <= '" . $start_date . "' AND end_date >= '" . $end_date . "')";
        $this->page_data['terrif'] = $this->db->query($sql)->result_array();
        $plazaId = $this->input->post('plaza_id');
        $month  = $this->input->post('month');
        $this->page_data['mtrid'] = $data['mtr_id'];
        $this->page_data['plaza_id'] = $plazaId;
        $this->page_data['month'] = $month;

        $this->page_data['tollplaza'] = $this->db->get_where('toolplaza', array('status' => 1))->result_array();
        $this->page_data['chart'] = $data['chart'];

        $this->page_data['revenue'] = $data['revenue'];
        $this->page_data['pre_month_chart'] = $pre_month_data['chart'];
        $this->page_data['pre_month_revenue'] = $pre_month_data['revenue'];
        $this->page_data['pre_year_chart'] = $pre_year_data['chart'];
        $this->page_data['pre_year_revenue'] = $pre_year_data['revenue'];
        $this->page_data['page'] = 'Dashboard';
        $this->load->view('back/timereload', $this->page_data);
    }
    /** Dashboard Timer END */

    /************************* */
    /** UPS Site Filters Start */
    /************************ */
    public function check_upsSites_dates($tollplaza = '')
    {
        // echo $tollplaza;
        // exit;
        $data = $this->Ups_dashboard_model->get_upsSites_dates($tollplaza);
        echo json_encode($data);
    }
    /** UPS Site Filter End */
    /*************************************** */
    /******* UPS Site and DATE filter Start */
    /************************************** */
    public function searchforUPS($para1 = '')
    {
        $tollplaza = $this->input->post('ups_site');
        $month  = $this->input->post('ups_formonth');
        $ups_data = $this->Ups_dashboard_model->get_filtered_UPS_data($tollplaza, $month);
        // echo "<pre>";
        // print_r($data);
        // exit;

        $this->page_data['tollplaza'] = $this->db->get_where('ups_ftp_credentials', array('status' => 1))->result_array();
        // echo "<pre>";
        // print_r($this->page_data['tollplaza']);
        // exit;
        $ups_view_data = array();
        $s_date = date("Y-m-d", strtotime($ups_data[0]['date']));
        $date = strtotime(date("Y-m-d", strtotime($s_date)));
        $e_date = date("Y-m-d", $date);
        $data1 = explode('-', $e_date);

        $vMin = 0;
        $vMax = 0;
        $vBp1 = 0;
        $Iin1 = 0;
        $Vout1 = 0;
        $Iout1 = 0;
        $Wout1 = 0;
        $KVAout1 = 0;
        $frequency = 0;
        $Ibat = 0;
        $Vbat = 0;
        $capacity = 0;
        $temp = 0;

        $counter = 0;
        $index = 0;
        $missingHourIndex = 0;

        $hoursCount = 0;
        $missingHours = array();
        $missingHourTimings = array();
        $missingTimingsIndex = 0;

        // Extracting First Record Date & Time Start
        $p_date = date("Y-m-d H:i:s", strtotime($ups_data[0]['date']));
        $preDate = strtotime(date("Y-m-d", strtotime($p_date)));
        $preTime = strtotime(date("H:i:s", strtotime($p_date)));
        $prevDate = date("Y-m-d", $preDate);
        $prevTime = date("H:i:s", $preTime);
        $prevDateArr = explode('-', $prevDate);
        $prevTimeArr = explode(':', $prevTime);
        // Extracting First Record Date & Time End

        $total_records = count($ups_data);
        $last_index = $total_records - 1;
        $l_date = date("Y-m-d", strtotime($ups_data[$last_index]['date']));
        $fomattedLastDate = strtotime(date("Y-m-d", strtotime($l_date)));
        $lastDay = date("Y-m-d", $fomattedLastDate);
        $explodedLastDay = explode('-', $lastDay);

        foreach ($ups_data as $key => $val) {
            // Extracting Running Record Date & Time Start
            $r_date = date("Y-m-d H:i:s", strtotime($val['date']));
            $fomattedDate = strtotime(date("Y-m-d", strtotime($r_date)));
            $fomattedTime = strtotime(date("H:i:s", strtotime($r_date)));
            $fomattedDateTime = strtotime(date("Y-m-d H:i:s", strtotime($r_date)));
            $currentDate = date("Y-m-d", $fomattedDate);
            $rTime = date("H:i:s", $fomattedTime);
            $rDateTime = date("Y-m-d H:i:s", $fomattedDateTime);
            $runningDate = explode('-', $currentDate);
            $runningTime = explode(':', $rTime);
            $runningDateTime = explode(':', $rDateTime);
            // Extracting Running Record Date & Time End

            if ($key < $last_index) {
                $n_date = date("Y-m-d", strtotime($ups_data[$key + 1]['date']));
                $fomattedNDate = strtotime(date("Y-m-d", strtotime($n_date)));
                $postDate = date("Y-m-d", $fomattedNDate);

                $nextDate = explode('-', $postDate);
                if ($nextDate[2] == $runningDate[2]) {
                    // check to calculate missing hours Start
                    if ($key > 0) {
                        $bg_date = date("Y-m-d H:i:s", strtotime($ups_data[$key - 1]['date']));
                        $fomattedBgDate = strtotime(date("Y-m-d", strtotime($bg_date)));
                        $fomattedBgTime = strtotime(date("H:i:s", strtotime($bg_date)));
                        $fomattedBgDateTime = strtotime(date("Y-m-d H:i:s", strtotime($bg_date)));
                        $bgDate = date("Y-m-d", $fomattedBgDate);
                        $bgTime = date("H:i:s", $fomattedBgTime);
                        $bgDateTime = date("Y-m-d H:i:s", $fomattedBgDateTime);
                        $explodedBgDate = explode('-', $bgDate);
                        $explodedBgTime = explode(':', $bgTime);
                        $explodedBgDateTime = explode(':', $bgDateTime);
                        $date1 = new DateTime($rDateTime);
                        $date2 = new DateTime($bgDateTime);
                        $interval = $date1->diff($date2);

                        if ($interval->h > 1) {
                            $hoursCount = $hoursCount + $interval->h;
                            $missingHours[$missingHourIndex] = $bgTime . " to " . $rTime;
                            $missingHourIndex++;
                        }
                        if ($interval->h <= 1) {
                            $missingHours[$missingHourIndex] =   "00:00:00 to 00:00:00";
                        }
                    }
                    // check to calculate missing hours End
                    $vMin = $vMin + $val['Vmin1'];
                    $vMax = $vMax + $val['Vmax1'];
                    $vBp1 = $vBp1 + $val['Vbp1'];
                    $Iin1 = $Iin1 + $val['Iin1'];
                    $Vout1 = $Vout1 + $val['Vout1'];
                    $Iout1 = $Iout1 + $val['Iout1'];
                    $Wout1 = $Wout1 + $val['Wout1'];
                    $KVAout1 = $KVAout1 + $val['KVAout1'];
                    $frequency = $frequency + $val['frequency'];
                    $Ibat = $Ibat + $val['Ibat'];
                    $Vbat = $Vbat + $val['Vbat'];
                    $capacity = $capacity + $val['capacity'];
                    $temp = $temp + $val['ups_temperature'];
                    $index++;
                } else if ($nextDate[2] > $runningDate[2]) {
                    $bg_date = date("Y-m-d H:i:s", strtotime($ups_data[$key - 1]['date']));
                    $fomattedBgDate = strtotime(date("Y-m-d", strtotime($bg_date)));
                    $fomattedBgTime = strtotime(date("H:i:s", strtotime($bg_date)));
                    $fomattedBgDateTime = strtotime(date("Y-m-d H:i:s", strtotime($bg_date)));
                    $bgDate = date("Y-m-d", $fomattedBgDate);
                    $bgTime = date("H:i:s", $fomattedBgTime);
                    $bgDateTime = date("Y-m-d H:i:s", $fomattedBgDateTime);
                    $explodedBgDate = explode('-', $bgDate);
                    $explodedBgTime = explode(':', $bgTime);
                    $explodedBgDateTime = explode(':', $bgDateTime);
                    $date1 = new DateTime($rDateTime);
                    $date2 = new DateTime($bgDateTime);
                    $interval = $date1->diff($date2);

                    if ($interval->h > 1) {
                        $hoursCount = $hoursCount + $interval->h;
                        $missingHours[$missingHourIndex] = $bgTime . "to" . $rTime;
                        $missingHourTimings[$missingTimingsIndex] = $missingHours;
                        $missingTimingsIndex++;
                        if ($key + 1 < $last_index) {
                            $missingHourIndex++;
                        }
                    }
                    if ($interval->h <= 1) {
                        unset($missingHours[$missingHourIndex]);
                        $missingHourTimings[$missingTimingsIndex] = $missingHours;
                    }
                    $vMin = $vMin + $val['Vmin1'];
                    $vMax = $vMax + $val['Vmax1'];
                    $vBp1 = $vBp1 + $val['Vbp1'];
                    $Iin1 = $Iin1 + $val['Iin1'];
                    $Vout1 = $Vout1 + $val['Vout1'];
                    $Iout1 = $Iout1 + $val['Iout1'];
                    $Wout1 = $Wout1 + $val['Wout1'];
                    $KVAout1 = $KVAout1 + $val['KVAout1'];
                    $frequency = $frequency + $val['frequency'];
                    $Ibat = $Ibat + $val['Ibat'];
                    $Vbat = $Vbat + $val['Vbat'];
                    $capacity = $capacity + $val['capacity'];
                    $temp = $temp + $val['ups_temperature'];
                    $divider = $index + 1;
                    $avgVmin = $vMin / $divider;
                    $avgVmax = $vMax / $divider;
                    $avgVbp1 = $vBp1 / $divider;
                    $avgIin1 = $Iin1 / $divider;
                    $avgVout1 = $Vout1 / $divider;
                    $avgIout1 = $Iout1 / $divider;
                    $avgWout1 = $Wout1 / $divider;
                    $avgKVAout1 = $KVAout1 / $divider;
                    $avgFreq = $frequency / $divider;
                    $avgIbat = $Ibat / $divider;
                    $avgVbat = $Vbat / $divider;
                    $avgCapacity = $capacity / $divider;
                    $avgTemp = $temp / $divider;

                    $ups_view_data[$counter]['hourCount'] = $hoursCount;
                    $ups_view_data[$counter]['hours'] = $missingHourTimings[0];
                    $ups_view_data[$counter]['site'] = $val['site'];
                    $ups_view_data[$counter]['system_id'] = $val['system_id'];
                    $ups_view_data[$counter]['date'] = $currentDate;
                    $ups_view_data[$counter]['avg_Vmin'] = $avgVmin;
                    $ups_view_data[$counter]['avg_Vmax'] = $avgVmax;
                    $ups_view_data[$counter]['avg_Vbp1'] = $avgVbp1;
                    $ups_view_data[$counter]['avg_Iin1'] = $avgIin1;
                    $ups_view_data[$counter]['avg_Vout1'] = $avgVout1;
                    $ups_view_data[$counter]['avg_Iout1'] = $avgIout1;
                    $ups_view_data[$counter]['avg_Wout1'] = $avgWout1;
                    $ups_view_data[$counter]['avg_KVAout1'] = $avgKVAout1;
                    $ups_view_data[$counter]['avg_freq'] = $avgFreq;
                    $ups_view_data[$counter]['avg_Ibat'] = $avgIbat;
                    $ups_view_data[$counter]['avg_Vbat'] = $avgVbat;
                    $ups_view_data[$counter]['avg_capacity'] = $avgCapacity;
                    $ups_view_data[$counter]['avg_Temp'] = $avgTemp;
                    $counter++;

                    $missingHourTimings = [];
                    $missingHours = [];
                    $missingTimingsIndex = 0;
                    $missingHourIndex = 0;
                    $hoursCount = 0;
                    $index = 0;
                    $vMin = 0;
                    $vMax = 0;
                    $vBp1 = 0;
                    $Iin1 = 0;
                    $Vout1 = 0;
                    $Iout1 = 0;
                    $Wout1 = 0;
                    $KVAout1 = 0;
                    $frequency = 0;
                    $Ibat = 0;
                    $Vbat = 0;
                    $capacity = 0;
                    $temp = 0;
                }
            }
            if ($key == $last_index) {
                $bg_date = date("Y-m-d H:i:s", strtotime($ups_data[$key - 1]['date']));
                $fomattedBgDate = strtotime(date("Y-m-d", strtotime($bg_date)));
                $fomattedBgTime = strtotime(date("H:i:s", strtotime($bg_date)));
                $fomattedBgDateTime = strtotime(date("Y-m-d H:i:s", strtotime($bg_date)));
                $bgDate = date("Y-m-d", $fomattedBgDate);
                $bgTime = date("H:i:s", $fomattedBgTime);
                $bgDateTime = date("Y-m-d H:i:s", $fomattedBgDateTime);
                $explodedBgDate = explode('-', $bgDate);
                $explodedBgTime = explode(':', $bgTime);
                $explodedBgDateTime = explode(':', $bgDateTime);
                $date1 = new DateTime($rDateTime);
                $date2 = new DateTime($bgDateTime);
                $interval = $date1->diff($date2);

                if ($interval->h > 1) {
                    $hoursCount = $hoursCount + $interval->h;
                    $missingHours[$missingHourIndex] = $bgTime . " to " . $rTime;
                    $missingHourTimings[$missingTimingsIndex] = $missingHours;
                }
                if ($interval->h <= 1) {
                    unset($missingHours[$missingHourIndex]);
                    $missingHourTimings[$missingTimingsIndex] = $missingHours;
                }

                $divider = $index + 1;
                $vMin = $vMin + $val['Vmin1'];
                $vMax = $vMax + $val['Vmax1'];
                $vBp1 = $vBp1 + $val['Vbp1'];
                $Iin1 = $Iin1 + $val['Iin1'];
                $Vout1 = $Vout1 + $val['Vout1'];
                $Iout1 = $Iout1 + $val['Iout1'];
                $Wout1 = $Wout1 + $val['Wout1'];
                $KVAout1 = $KVAout1 + $val['KVAout1'];
                $frequency = $frequency + $val['frequency'];
                $Ibat = $Ibat + $val['Ibat'];
                $Vbat = $Vbat + $val['Vbat'];
                $capacity = $capacity + $val['capacity'];
                $temp = $temp + $val['ups_temperature'];

                $avgVmin = $vMin / $divider;
                $avgVmax = $vMax / $divider;
                $avgVbp1 = $vBp1 / $divider;
                $avgIin1 = $Iin1 / $divider;
                $avgVout1 = $Vout1 / $divider;
                $avgIout1 = $Iout1 / $divider;
                $avgWout1 = $Wout1 / $divider;
                $avgKVAout1 = $KVAout1 / $divider;
                $avgFreq = $frequency / $divider;
                $avgIbat = $Ibat / $divider;
                $avgVbat = $Vbat / $divider;
                $avgCapacity = $capacity / $divider;
                $avgTemp = $temp / $divider;

                $ups_view_data[$counter]['hourCount'] = $hoursCount;
                $ups_view_data[$counter]['hours'] = $missingHourTimings[0];
                $ups_view_data[$counter]['site'] = $val['site'];
                $ups_view_data[$counter]['system_id'] = $val['system_id'];
                $ups_view_data[$counter]['date'] = $currentDate;
                $ups_view_data[$counter]['avg_Vmin'] = $avgVmin;
                $ups_view_data[$counter]['avg_Vmax'] = $avgVmax;
                $ups_view_data[$counter]['avg_Vbp1'] = $avgVbp1;
                $ups_view_data[$counter]['avg_Iin1'] = $avgIin1;
                $ups_view_data[$counter]['avg_Vout1'] = $avgVout1;
                $ups_view_data[$counter]['avg_Iout1'] = $avgIout1;
                $ups_view_data[$counter]['avg_Wout1'] = $avgWout1;
                $ups_view_data[$counter]['avg_KVAout1'] = $avgKVAout1;
                $ups_view_data[$counter]['avg_freq'] = $avgFreq;
                $ups_view_data[$counter]['avg_Ibat'] = $avgIbat;
                $ups_view_data[$counter]['avg_Vbat'] = $avgVbat;
                $ups_view_data[$counter]['avg_capacity'] = $avgCapacity;
                $ups_view_data[$counter]['avg_Temp'] = $avgTemp;
            }
        }
        $missingHourTimings = [];
        $missingHours = [];
        $missingTimingsIndex = 0;
        $missingHourIndex = 0;
        $hoursCount = 0;
        $numberOfDays = count($ups_view_data);
        $monthlyTemp = 0;
        $monthlyVbat = 0;
        foreach ($ups_data as $value) {
            $monthlyTemp = $monthlyTemp + $value['ups_temperature'];
            $monthlyVbat = $monthlyVbat + $value['Vbat'];
        }

        $oneDayTemp = $monthlyTemp / $numberOfDays;
        $oneDayVbat = $monthlyVbat / $numberOfDays;
        // echo "<pre>";
        // print_r($ups_view_data);
        // exit;

        $this->page_data['ups_data'] = $ups_view_data;

        $this->page_data['page'] = 'UPS Custom Dashboard';
        $this->load->view('back/ups_dashboard/customize_ups_search', $this->page_data);
    }
}
