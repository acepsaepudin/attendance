<?php class Laporan extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        $this->load->library(array('template', 'form_validation'));
        $this->load->model(array('attendance_model','user_model'));
        
        if(!$this->session->userdata('username')){
            redirect('web');
        }
    }
     
    function presensi(){
        $data['title']="Data Laporan Presensi";
        // $cek=$this->attendance_model->get_attendance_report();
        // echo $cek->row();
        /*$data['message']="";
        $data['presensi']=$cek->result();
        */
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data['presensi'] = $this->attendance_model->get_all("ATTENDANCE_IN_DATE like '".$this->input->post('cari')."'")->result();
            
            $this->template->display('laporan/presensi',$data);
        } else {
            $data['presensi'] = $this->attendance_model->get_all("ATTENDANCE_IN_DATE like '".date('Y-m-d')."'")->result();
            $this->template->display('laporan/presensi',$data);
        }
    }

    public function presensi_edit($username)
    {
        $data['title']="Data Laporan Presensi";
        $data['message'] = '';
        $this->form_validation->set_rules('status', 'Status', 'required');
        if ($this->form_validation->run() == true) {
            # code...
        } else {
            $data['presensi'] = $this->attendance_model->get_by_id(array('USERNAME' => $username));
            $this->template->display('laporan/presensi_edit',$data);
        }
    }

    public function data_gaji()
    {
        $data['title']="Edit Data Karyawan";
        date_default_timezone_set("Asia/Jakarta");
        // print_r($this->get_working_hours('2016-06-28 08:00','2016-06-28 19:26'));
        //ambil data user aktif
        $data_user = $this->user_model->get_all(array('status' => 'aktif'));
        $data_user = $data_user->result();
        // $now = date('Y-m');
        foreach ($data_user as $key => $value) {
            //get data attendance one month
            $res_data = $this->attendance_model->get_all("USERNAME = '".$value->USERNAME."' and ATTENDANCE_IN_DATE like '2016-08-%'")->result();
            // if ($res_data) {
                $month_attendance[$value->USERNAME] = $res_data;
            // }
            
        }
        foreach ($month_attendance as $key => $value) {
            foreach ($value as $k => $v) {
                // total sehari kerja
                //ceil
                $value[$k]->total_hours = floor($this->get_working_hours($v->ATTENDANCE_IN_DATE.' '.$v->ATTENDANCE_IN_TIME,$v->ATTENDANCE_OUT_DATE.' '.$v->ATTENDANCE_OUT_TIME));

            }

        }
        $month_salary = 0;
        foreach ($data_user as $key => $value) {
            $user_data = $month_attendance[$value->USERNAME];
            if ($user_data) {
                foreach ($user_data as $k => $v) {
                    $month_salary += $v->total_hours*18750;
                }
                $month_attendance[$value->USERNAME]['month_salary'] = $month_salary;
                $month_salary = 0;
            }
        }
        $data['gaji'] = $month_attendance;
        $this->template->display('laporan/gaji',$data);
    }

    function get_working_hours($from,$to)
    {
        // timestamps
        $from_timestamp = strtotime($from);
        $to_timestamp = strtotime($to);

        // work day seconds
        $workday_start_hour = 8;
        $workday_end_hour = 16;
        $workday_seconds = ($workday_end_hour - $workday_start_hour)*3600;

        // work days beetwen dates, minus 1 day
        $from_date = date('Y-m-d',$from_timestamp);
        $to_date = date('Y-m-d',$to_timestamp);
        $workdays_number = count($this->get_workdays($from_date,$to_date))-1;
        $workdays_number = $workdays_number<0 ? 0 : $workdays_number;

        // start and end time
        $start_time_in_seconds = date("H",$from_timestamp)*3600+date("i",$from_timestamp)*60;
        $end_time_in_seconds = date("H",$to_timestamp)*3600+date("i",$to_timestamp)*60;

        // final calculations
        $working_hours = ($workdays_number * $workday_seconds + $end_time_in_seconds - $start_time_in_seconds) / 86400 * 24;

        return $working_hours;
    }

    function get_workdays($from,$to) 
    {
        // arrays
        $days_array = array();
        $skipdays = array("Saturday", "Sunday");
        $skipdates = $this->get_holidays();

        // other variables
        $i = 0;
        $current = $from;

        if($current == $to) // same dates
        {
            $timestamp = strtotime($from);
            if (!in_array(date("l", $timestamp), $skipdays)&&!in_array(date("Y-m-d", $timestamp), $skipdates)) {
                $days_array[] = date("Y-m-d",$timestamp);
            }
        }
        elseif($current < $to) // different dates
        {
            while ($current < $to) {
                $timestamp = strtotime($from." +".$i." day");
                if (!in_array(date("l", $timestamp), $skipdays)&&!in_array(date("Y-m-d", $timestamp), $skipdates)) {
                    $days_array[] = date("Y-m-d",$timestamp);
                }
                $current = date("Y-m-d",$timestamp);
                $i++;
            }
        }

        return $days_array;
    }

    function get_holidays() 
    {
        // arrays
        $days_array = array();

        // You have to put there your source of holidays and make them as array...
        // For example, database in Codeigniter:
        // $days_array = $this->my_model->get_holidays_array();

        return $days_array;
    }

    function work_hours_diff($date1,$date2) {
        if ($date1>$date2) { $tmp=$date1; $date1=$date2; $date2=$tmp; unset($tmp); $sign=-1; } else $sign = 1;
        if ($date1==$date2) return 0;

        $days = 0;
        $working_days = array(1,2,3,4,5); // Monday-->Friday
        $working_hours = array(8.0, 16.0); // from 8:30(am) to 17:30
        $current_date = $date1;
        $beg_h = floor($working_hours[0]); $beg_m = ($working_hours[0]*60)%60;
        $end_h = floor($working_hours[1]); $end_m = ($working_hours[1]*60)%60;

        // setup the very next first working timestamp

        if (!in_array(date('w',$current_date) , $working_days)) {
            // the current day is not a working day

            // the current timestamp is set at the begining of the working day
            $current_date = mktime( $beg_h, $beg_m, 0, date('n',$current_date), date('j',$current_date), date('Y',$current_date) );
            // search for the next working day
            while ( !in_array(date('w',$current_date) , $working_days) ) {
                $current_date += 24*3600; // next day
            }
        } else {
            // check if the current timestamp is inside working hours

            $date0 = mktime( $beg_h, $beg_m, 0, date('n',$current_date), date('j',$current_date), date('Y',$current_date) );
            // it's before working hours, let's update it
            if ($current_date<$date0) $current_date = $date0;

            $date3 = mktime( $end_h, $end_m, 59, date('n',$current_date), date('j',$current_date), date('Y',$current_date) );
            if ($date3<$current_date) {
                // outch ! it's after working hours, let's find the next working day
                $current_date += 24*3600; // the day after
                // and set timestamp as the begining of the working day
                $current_date = mktime( $beg_h, $beg_m, 0, date('n',$current_date), date('j',$current_date), date('Y',$current_date) );
                while ( !in_array(date('w',$current_date) , $working_days) ) {
                    $current_date += 24*3600; // next day
                }
            }
        }

        // so, $current_date is now the first working timestamp available...

        // calculate the number of seconds from current timestamp to the end of the working day
        $date0 = mktime( $end_h, $end_m, 59, date('n',$current_date), date('j',$current_date), date('Y',$current_date) );
        $seconds = $date0-$current_date+1;

        printf("\nFrom %s To %s : %d hours\n",date('d/m/y H:i',$date1),date('d/m/y H:i',$date0),$seconds/3600);

        // calculate the number of days from the current day to the end day

        $date3 = mktime( $beg_h, $beg_m, 0, date('n',$date2), date('j',$date2), date('Y',$date2) );
        while ( $current_date < $date3 ) {
            $current_date += 24*3600; // next day
            if (in_array(date('w',$current_date) , $working_days) ) $days++; // it's a working day
        }
        if ($days>0) $days--; //because we've allready count the first day (in $seconds)

        printf("\nFrom %s To %s : %d working days\n",date('d/m/y H:i',$date1),date('d/m/y H:i',$date3),$days);

        // check if end's timestamp is inside working hours
        $date0 = mktime( $beg_h, 0, 0, date('n',$date2), date('j',$date2), date('Y',$date2) );
        if ($date2<$date0) {
            // it's before, so nothing more !
        } else {
            // is it after ?
            $date3 = mktime( $end_h, $end_m, 59, date('n',$date2), date('j',$date2), date('Y',$date2) );
            if ($date2>$date3) $date2=$date3;
            // calculate the number of seconds from current timestamp to the final timestamp
            $tmp = $date2-$date0+1;
            $seconds += $tmp;
            printf("\nFrom %s To %s : %d hours\n",date('d/m/y H:i',$date2),date('d/m/y H:i',$date3),$tmp/3600);
        }

        // calculate the working days in seconds

        $seconds += 3600*($working_hours[1]-$working_hours[0])*$days;

        printf("\nFrom %s To %s : %d hours\n",date('d/m/y H:i',$date1),date('d/m/y H:i',$date2),$seconds/3600);

        return $sign * $seconds/3600; // to get hours
    }
    
}