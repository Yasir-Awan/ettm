<?php
defined('BASEPATH') or exit('NO direct script is allowed');
class Ups_dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->page_data = array();
        $this->page_data['page_url'] = current_url();
        $this->load->model('Ups_dashboard_model');
    }

    public function index()
    {
        if (!$this->session->userdata('adminid')) {
            return redirect('admin/login');
        }
        if ($this->session->userdata('adminid') == 22) {
            return redirect('NHMP_dashboard/index');
        }
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

        // $prevDate = $data1[2];
        $counter = 0;
        $index = 0;
        $lastDayIndex = 0;

        $total_records = count($ups_data);
        $last_index = $total_records - 1;
        $l_date = date("Y-m-d", strtotime($ups_data[$last_index]['date']));
        $fomattedLastDate = strtotime(date("Y-m-d", strtotime($l_date)));
        $lastDay = date("Y-m-d", $fomattedLastDate);
        $explodedLastDay = explode('-', $lastDay);
        // echo "<pre>";
        // print_r($explodedLastDay);
        // exit;

        foreach ($ups_data as $key => $val) {
            $r_date = date("Y-m-d", strtotime($val['date']));
            $fomattedDate = strtotime(date("Y-m-d", strtotime($r_date)));
            $currentDate = date("Y-m-d", $fomattedDate);
            $runningDate = explode('-', $currentDate);

            $n_date = date("Y-m-d", strtotime($ups_data[$key + 1]['date']));
            $fomattedNDate = strtotime(date("Y-m-d", strtotime($n_date)));
            $postDate = date("Y-m-d", $fomattedNDate);
            $nextDate = explode('-', $postDate);

            if ($nextDate[2] == $runningDate[2]) {
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
                $index = 0;
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

                $avgVmin = $vMin / 24;
                $avgVmax = $vMax / 24;
                $avgVbp1 = $vBp1 / 24;
                $avgIin1 = $Iin1 / 24;
                $avgVout1 = $Vout1 / 24;
                $avgIout1 = $Iout1 / 24;
                $avgWout1 = $Wout1 / 24;
                $avgKVAout1 = $KVAout1 / 24;
                $avgFreq = $frequency / 24;
                $avgIbat = $Ibat / 24;
                $avgVbat = $Vbat / 24;
                $avgCapacity = $capacity / 24;
                $avgTemp = $temp / 24;

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
            } else {
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

                $avgVmin = $vMin / $index;
                $avgVmax = $vMax / $index;
                $avgVbp1 = $vBp1 / $index;
                $avgIin1 = $Iin1 / $index;
                $avgVout1 = $Vout1 / $index;
                $avgIout1 = $Iout1 / $index;
                $avgWout1 = $Wout1 / $index;
                $avgKVAout1 = $KVAout1 / $index;
                $avgFreq = $frequency / $index;
                $avgIbat = $Ibat / $index;
                $avgVbat = $Vbat / $index;
                $avgCapacity = $capacity / $index;
                $avgTemp = $temp / $index;

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

        // echo "<pre>";
        // print_r($ups_view_data);
        // exit;
        $this->page_data['ups_data'] = $ups_view_data;

        $this->page_data['page'] = 'UPS Dashboard';

        $this->load->view('back/ups_dashboard', $this->page_data);
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
}
