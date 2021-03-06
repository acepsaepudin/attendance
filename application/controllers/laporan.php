<?php 
include_once APPPATH.'/third_party/mpdf/mpdf.php';
class Laporan extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        $this->load->library(array('template', 'form_validation'));
        $this->load->model(array('attendance_model','user_model','salary_model','userrole_model','late_model','workingdays_model'));
        
        // if(!$this->session->userdata('username')){
        //     redirect('web');
        // }
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
    function list_presensi(){
        $data['title']="Input Presensi";
        $data['message']="";
        $data_user = $this->user_model->get_all(array('status' => 'aktif'));
        $this->form_validation->set_rules('tgl','Tanggal','required');
        if ($this->form_validation->run() == false) {
            
            $data['user'] = $data_user->result();
            $this->template->display('laporan/presensi_input',$data);
        } else {
            date_default_timezone_set("Asia/Jakarta");
            $epoch = new DateTime(date('Y/m/d H:i:s'));
            $attendance_id = $epoch->format('U');
            $stat = $this->input->post('status');
            $tgl = $this->input->post('tgl');
            $array_data = array(
                    ''
                );
            switch ($stat) {
                case 'sakit':
                    $array_data = array(
                        'USERNAME' => $this->input->post('username'),
                        'OFFICE_ID' => 1,
                        'ATTENDANCE_ID' => $attendance_id,
                        'ATTENDANCE_IN_DATE' => $tgl,
                        'ATTENDANCE_IN_TIME' => '08:00:00',
                        'ATTENDANCE_OUT_DATE' => $tgl,
                        'ATTENDANCE_OUT_TIME' => '16:00:00',
                        'STATUS' => $stat
                        );
                    break;
                case 'izin':
                    $array_data = array(
                        'USERNAME' => $this->input->post('username'),
                        'OFFICE_ID' => 1,
                        'ATTENDANCE_ID' => $attendance_id,
                        'ATTENDANCE_IN_DATE' => $tgl,
                        'ATTENDANCE_IN_TIME' => '08:00:00',
                        'ATTENDANCE_OUT_DATE' => $tgl,
                        'ATTENDANCE_OUT_TIME' => '16:00:00',
                        'STATUS' => $stat
                        );
                    break;
                case 'tugas_luar':
                    $array_data = array(
                        'USERNAME' => $this->input->post('username'),
                        'OFFICE_ID' => 1,
                        'ATTENDANCE_ID' => $attendance_id,
                        'ATTENDANCE_IN_DATE' => $tgl,
                        'ATTENDANCE_IN_TIME' => '08:00:00',
                        'ATTENDANCE_OUT_DATE' => $tgl,
                        'ATTENDANCE_OUT_TIME' => '16:00:00',
                        'STATUS' => $stat
                        );
                    break;
                case 'cuti':
                    $array_data = array(
                        'USERNAME' => $this->input->post('username'),
                        'OFFICE_ID' => 1,
                        'ATTENDANCE_ID' => $attendance_id,
                        'ATTENDANCE_IN_DATE' => $tgl,
                        'ATTENDANCE_IN_TIME' => '08:00:00',
                        'ATTENDANCE_OUT_DATE' => $tgl,
                        'ATTENDANCE_OUT_TIME' => '16:00:00',
                        'STATUS' => $stat
                        );
                    break;
                
                
            }   
            $this->attendance_model->save($array_data);         
            $this->session->set_flashdata('sukses',"<div class='alert alert-success'>Berhasil Menyimpan Presensi.</div>");
            redirect('laporan/presensi');
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

    public function data_gaji($tgl =null)
    {
        $data['title']="Edit Data Karyawan";
        date_default_timezone_set("Asia/Jakarta");
        // print_r($this->get_working_hours('2016-06-28 08:00','2016-06-28 19:26'));
        //ambil data user aktif
        $data_user = $this->user_model->get_all(array('status' => 'aktif'));
        $data_user = $data_user->result();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // $now = date('Y-m');
            foreach ($data_user as $key => $value) {
                //get data attendance one month
                $res_data = $this->attendance_model->get_all("USERNAME = '".$value->USERNAME."' and ATTENDANCE_IN_DATE like '".$this->input->post('tahun').'-'.$this->input->post('bulan').'-%'."' and status in ('hadir','terlambat')")->result();
                // if ($res_data) {
                    $month_attendance[$value->USERNAME] = $res_data;
                // }
                
            }
            $data['tgl'] = $this->input->post('bulan');
            $data['thn'] = $this->input->post('tahun');
            
        } else {
            
            // $now = date('Y-m');
            foreach ($data_user as $key => $value) {
                //get data attendance one month
                $res_data = $this->attendance_model->get_all("USERNAME = '".$value->USERNAME."' and ATTENDANCE_IN_DATE like '".$this->get_previous_month().'-%'."' and status in ('hadir','terlambat')")->result();
                // if ($res_data) {
                    $month_attendance[$value->USERNAME] = $res_data;
                // }
                
            }
            $tanggal = explode('-', $this->get_previous_month());
            $data['tgl'] = $tanggal[1];
            $data['thn'] = $tanggal[0];
        }
        foreach ($month_attendance as $key => $value) {
            foreach ($value as $k => $v) {

                // total sehari kerja
                //ceil
                // $value[$k]->total_hours = floor($this->get_working_hours($v->ATTENDANCE_IN_DATE.' '.$v->ATTENDANCE_IN_TIME,$v->ATTENDANCE_OUT_DATE.' '.$v->ATTENDANCE_OUT_TIME));
                if ($v->STATUS == 'hadir') {
                    //get user salary
                    $role_user = $this->user_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_ROLE_ID;
                    $salary = $this->userrole_model->get_by_id(['USER_ROLE_ID' => $role_user])->SALARY;
                    $weekdays = $this->get_weekdays($data['tgl'],$data['thn']);
                    $day_salary = $salary / $weekdays;
                    $value[$k]->today_salary = round($day_salary,0); //pembulatan keatas sampai hilang nilai desimal
                }
                if ($v->STATUS == 'sakit') {
                    // $salary = $this->salary_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_SALARY;
                    $role_user = $this->user_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_ROLE_ID;
                    $salary = $this->userrole_model->get_by_id(['USER_ROLE_ID' => $role_user])->SALARY;
                    $weekdays = $this->get_weekdays($data['tgl'],$data['thn']);
                    $day_salary = $salary / $weekdays;

                    $value[$k]->today_salary = round($day_salary,0); //pembulatan keatas sampai hilang nilai desimal
                }
                if ($v->STATUS == 'izin') {
                    // $salary = $this->salary_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_SALARY;
                    $role_user = $this->user_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_ROLE_ID;
                    $salary = $this->userrole_model->get_by_id(['USER_ROLE_ID' => $role_user])->SALARY;
                    $weekdays = $this->get_weekdays($data['tgl'],$data['thn']);
                    $day_salary = $salary / $weekdays;

                    $value[$k]->today_salary = round($day_salary,0); //pembulatan keatas sampai hilang nilai desimal
                }
                if ($v->STATUS == 'terlambat') {
                    // $salary = $this->salary_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_SALARY;
                    $role_user = $this->user_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_ROLE_ID;
                    $salary = $this->userrole_model->get_by_id(['USER_ROLE_ID' => $role_user])->SALARY;
                    $weekdays = $this->get_weekdays($data['tgl'],$data['thn']);
                    $day_salary = $salary / $weekdays;

                    $value[$k]->today_salary = round($day_salary / 2,0); //pembulatan keatas sampai hilang nilai desimal
                }

            }

        }

        $month_salary = 0;
        foreach ($data_user as $key => $value) {
            $user_data = $month_attendance[$value->USERNAME];
            if ($user_data) {
                foreach ($user_data as $k => $v) {
                    $month_salary += $v->today_salary;
                }
                $month_attendance[$value->USERNAME]['month_salary'] = $month_salary;
                $month_attendance[$value->USERNAME]['dates'] = $this->get_previous_month();
                $month_salary = 0;
            }
        }
        $data['gaji'] = $month_attendance;
    
        $this->template->display('laporan/gaji',$data);
    }

    public function detail_gaji($username,$date)
    {
        $data['title'] = 'Detail Gaji';
        $exdate = explode('-', $date);
        $res_data = $this->attendance_model->get_all("USERNAME = '".$username."' and ATTENDANCE_IN_DATE like '".$date.'-%'."' and status in ('hadir','terlambat','absen','sakit','cuti')")->result();
        foreach ($res_data as $k => $v) {
                if ($v->STATUS == 'hadir') {
                    //get user salary
                    // $salary = $this->salary_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_SALARY;
                    $role_user = $this->user_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_ROLE_ID;
                    $salary = $this->userrole_model->get_by_id(['USER_ROLE_ID' => $role_user])->SALARY;
                    // $weekdays = $this->get_weekdays($exdate[1],$exdate[0]);
                    // $day_salary = $salary / $weekdays;
                    $weekdays = $this->workingdays_model->get_by_id(['WORKING_MONTH' => $exdate[1]])->WORKING_DAYS;
                    $day_salary = $salary / $weekdays;
                    $res_data[$k]->today_salary = round($day_salary,0); //pembulatan keatas sampai hilang nilai desimal
                }
                if ($v->STATUS == 'sakit') {
                    // $salary = $this->salary_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_SALARY;
                    $role_user = $this->user_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_ROLE_ID;
                    $salary = $this->userrole_model->get_by_id(['USER_ROLE_ID' => $role_user])->SALARY;
                    // $weekdays = $this->get_weekdays($exdate[1],$exdate[0]);
                    // $day_salary = $salary / $weekdays;
                    $weekdays = $this->workingdays_model->get_by_id(['WORKING_MONTH' => $exdate[1]])->WORKING_DAYS;
                    $day_salary = $salary / $weekdays;

                    $res_data[$k]->today_salary = round($day_salary,0); //pembulatan keatas sampai hilang nilai desimal
                }
                if ($v->STATUS == 'cuti') {
                    // $salary = $this->salary_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_SALARY;
                    $role_user = $this->user_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_ROLE_ID;
                    $salary = $this->userrole_model->get_by_id(['USER_ROLE_ID' => $role_user])->SALARY;
                    // $weekdays = $this->get_weekdays($exdate[1],$exdate[0]);
                    // $day_salary = $salary / $weekdays;
                    $weekdays = $this->workingdays_model->get_by_id(['WORKING_MONTH' => $exdate[1]])->WORKING_DAYS;
                    $day_salary = $salary / $weekdays;

                    $res_data[$k]->today_salary = round($day_salary,0); //pembulatan keatas sampai hilang nilai desimal
                }
                if ($v->STATUS == 'izin') {
                    // $salary = $this->salary_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_SALARY;
                    $role_user = $this->user_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_ROLE_ID;
                    $salary = $this->userrole_model->get_by_id(['USER_ROLE_ID' => $role_user])->SALARY;
                    // $weekdays = $this->get_weekdays($exdate[1],$exdate[0]);
                    // $day_salary = $salary / $weekdays;
                    $weekdays = $this->workingdays_model->get_by_id(['WORKING_MONTH' => $exdate[1]])->WORKING_DAYS;
                    $day_salary = $salary / $weekdays;

                    $res_data[$k]->today_salary = round($day_salary,0); //pembulatan keatas sampai hilang nilai desimal
                }
                if ($v->STATUS == 'terlambat') {
                    // $salary = $this->salary_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_SALARY;
                    $role_user = $this->user_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_ROLE_ID;
                    $salary = $this->userrole_model->get_by_id(['USER_ROLE_ID' => $role_user])->SALARY;
                    // $weekdays = $this->get_weekdays($exdate[1],$exdate[0]);
                    // $day_salary = $salary / $weekdays;
                    $weekdays = $this->workingdays_model->get_by_id(['WORKING_MONTH' => $exdate[1]])->WORKING_DAYS;
                    $day_salary = $salary / $weekdays;

                    $res_data[$k]->today_salary = round($day_salary / 2,0); //pembulatan keatas sampai hilang nilai desimal
                }
                // $res_data[$k]->month_salary += $res_data[$k]->today_salary;

        }
        $data['username'] = $username;
        $data['date'] = $date;
        $data['gaji'] = $res_data;
        $this->template->display('laporan/detail_gaji',$data);
        
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

    public function get_weekdays($m,$y) {
        $lastday = date("t",mktime(0,0,0,$m,1,$y));
        $weekdays=0;
        for($d=29;$d<=$lastday;$d++) {
            $wd = date("w",mktime(0,0,0,$m,$d,$y));
            if($wd > 0 && $wd < 6) $weekdays++;
            }
        return $weekdays+20;
    }

    public function get_previous_month($m=null,$y=null)
    {
        if ($m && $y) {
            $month = date($m);
            $year = date($y);
            $last_month = $month-1%12;
            return ($last_month==0?($year-1):$year)."-".($last_month==0?'12':($last_month < 10) ? '0'.$last_month : $last_month);
        } else {
            $month = date('m');
            $year = date('Y');
            $last_month = $month-1%12;
            return ($last_month==0?($year-1):$year)."-".($last_month==0?'12':($last_month <10) ? '0'.$last_month : $last_month );
        }
    }

    public function print_gaji($username,$date)
    {
        $exdate = explode('-', $date);
        $res_data = $this->attendance_model->get_all("USERNAME = '".$username."' and ATTENDANCE_IN_DATE like '".$date.'-%'."' and status in ('hadir','terlambat','sakit','cuti')")->result();
        foreach ($res_data as $k => $v) {
                if ($v->STATUS == 'hadir') {
                    //get user salary
                    // $salary = $this->salary_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_SALARY;
                    $role_user = $this->user_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_ROLE_ID;
                    $salary = $this->userrole_model->get_by_id(['USER_ROLE_ID' => $role_user])->SALARY;
                    // $weekdays = $this->get_weekdays($exdate[1],$exdate[0]);
                    // $day_salary = $salary / $weekdays;
                    $weekdays = $this->workingdays_model->get_by_id(['WORKING_MONTH' => $exdate[1]])->WORKING_DAYS;
                    $day_salary = $salary / $weekdays;
                    $res_data[$k]->today_salary = round($day_salary,0); //pembulatan keatas sampai hilang nilai desimal
                }
                if ($v->STATUS == 'cuti') {
                    //get user salary
                    // $salary = $this->salary_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_SALARY;
                    $role_user = $this->user_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_ROLE_ID;
                    $salary = $this->userrole_model->get_by_id(['USER_ROLE_ID' => $role_user])->SALARY;
                    // $weekdays = $this->get_weekdays($exdate[1],$exdate[0]);
                    // $day_salary = $salary / $weekdays;
                    $weekdays = $this->workingdays_model->get_by_id(['WORKING_MONTH' => $exdate[1]])->WORKING_DAYS;
                    $day_salary = $salary / $weekdays;
                    $res_data[$k]->today_salary = round($day_salary,0); //pembulatan keatas sampai hilang nilai desimal
                }
                if ($v->STATUS == 'sakit') {
                    // $salary = $this->salary_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_SALARY;
                    $role_user = $this->user_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_ROLE_ID;
                    $salary = $this->userrole_model->get_by_id(['USER_ROLE_ID' => $role_user])->SALARY;
                    // $weekdays = $this->get_weekdays($exdate[1],$exdate[0]);
                    // $day_salary = $salary / $weekdays;
                    $weekdays = $this->workingdays_model->get_by_id(['WORKING_MONTH' => $exdate[1]])->WORKING_DAYS;
                    $day_salary = $salary / $weekdays;

                    $res_data[$k]->today_salary = round($day_salary,0); //pembulatan keatas sampai hilang nilai desimal
                }
                if ($v->STATUS == 'izin') {
                    // $salary = $this->salary_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_SALARY;
                    $role_user = $this->user_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_ROLE_ID;
                    $salary = $this->userrole_model->get_by_id(['USER_ROLE_ID' => $role_user])->SALARY;
                    // $weekdays = $this->get_weekdays($exdate[1],$exdate[0]);
                    // $day_salary = $salary / $weekdays;
                    $weekdays = $this->workingdays_model->get_by_id(['WORKING_MONTH' => $exdate[1]])->WORKING_DAYS;
                    $day_salary = $salary / $weekdays;

                    $res_data[$k]->today_salary = round($day_salary,0); //pembulatan keatas sampai hilang nilai desimal
                }
                if ($v->STATUS == 'terlambat') {
                    // $salary = $this->salary_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_SALARY;
                    $role_user = $this->user_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_ROLE_ID;
                    $salary = $this->userrole_model->get_by_id(['USER_ROLE_ID' => $role_user])->SALARY;
                    // $weekdays = $this->get_weekdays($exdate[1],$exdate[0]);
                    // $day_salary = $salary / $weekdays;
                    $weekdays = $this->workingdays_model->get_by_id(['WORKING_MONTH' => $exdate[1]])->WORKING_DAYS;
                    $day_salary = $salary / $weekdays;

                    $res_data[$k]->today_salary = round($day_salary / 2,0); //pembulatan keatas sampai hilang nilai desimal
                }
                // $res_data[$k]->month_salary += $res_data[$k]->today_salary;

        }
        foreach ($res_data as $key => $value) {
            $terlambat += ($value->STATUS == 'terlambat') ? 1 : 0;
            $hadir += ($value->STATUS == 'hadir') ? 1 : 0;
            $total += $value->today_salary;
        }
        $data = [];
        $data['terlambat'] = $terlambat;
        $data['hadir'] =  $hadir;
        $data['working_days'] = $this->workingdays_model->get_by_id(['WORKING_MONTH' => $exdate[1]])->WORKING_DAYS;
        $data['sal'] = $total;
        
        $data['telat'] = $this->late_model->get_all()->row();
        
        $data['date'] = $date;
        $data['username'] = $username;
        $data['salary'] = $this->salary_model->get_by_id(['USERNAME' => $username]);
        $data['user'] = $this->user_model->get_by_id(['USERNAME' => $username]);
        $data['role'] = $this->userrole_model->get_by_id(['USER_ROLE_ID' => $data['user']->USER_ROLE_ID]);

        //load the view and saved it into $html variable
        $html=$this->load->view('print/gaji', $data, true);
        $mpdf = new mPDF('', 'A4');

        $mpdf->AddPage('L'); // Adds a new page in Landscape orientation

        $mpdf->WriteHTML($html);

        $mpdf->Output();
 
        //this the the PDF filename that user will get to download
       //  $pdfFilePath = "output_pdf_name.pdf";
 
       //  //load mPDF library
       //  // $this->load->library('m_pdf');

       //  $m_pdf = new mPDF('utf-8', 'P');

       // //generate the PDF from the given html
       //  $m_pdf->WriteHTML($html);
 
       //  //download it.
       //  $m_pdf->Output($pdfFilePath, "I");
    }

    public function print_absensi($username,$date)
    {
        
        $exdate = explode('-', $date);
        $res_data = $this->attendance_model->get_all("USERNAME = '".$username."' and ATTENDANCE_IN_DATE like '".$date.'-%'."'")->result();
        foreach ($res_data as $k => $v) {
                if ($v->STATUS == 'hadir') {
                    //get user salary
                    // $salary = $this->salary_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_SALARY;
                    $role_user = $this->user_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_ROLE_ID;
                    $salary = $this->userrole_model->get_by_id(['USER_ROLE_ID' => $role_user])->SALARY;
                    $weekdays = $this->get_weekdays($exdate[1],$exdate[0]);
                    $day_salary = $salary / $weekdays;
                    $res_data[$k]->today_salary = round($day_salary,0); //pembulatan keatas sampai hilang nilai desimal
                }
                if ($v->STATUS == 'sakit') {
                    // $salary = $this->salary_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_SALARY;
                    $role_user = $this->user_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_ROLE_ID;
                    $salary = $this->userrole_model->get_by_id(['USER_ROLE_ID' => $role_user])->SALARY;
                    $weekdays = $this->get_weekdays($exdate[1],$exdate[0]);
                    $day_salary = $salary / $weekdays;

                    $res_data[$k]->today_salary = round($day_salary,0); //pembulatan keatas sampai hilang nilai desimal
                }
                if ($v->STATUS == 'izin') {
                    // $salary = $this->salary_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_SALARY;
                    $role_user = $this->user_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_ROLE_ID;
                    $salary = $this->userrole_model->get_by_id(['USER_ROLE_ID' => $role_user])->SALARY;
                    $weekdays = $this->get_weekdays($exdate[1],$exdate[0]);
                    $day_salary = $salary / $weekdays;

                    $res_data[$k]->today_salary = round($day_salary,0); //pembulatan keatas sampai hilang nilai desimal
                }
                if ($v->STATUS == 'terlambat') {
                    // $salary = $this->salary_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_SALARY;
                    $role_user = $this->user_model->get_by_id(['USERNAME' => $v->USERNAME])->USER_ROLE_ID;
                    $salary = $this->userrole_model->get_by_id(['USER_ROLE_ID' => $role_user])->SALARY;
                    $weekdays = $this->get_weekdays($exdate[1],$exdate[0]);
                    $day_salary = $salary / $weekdays;

                    $res_data[$k]->today_salary = round($day_salary / 2,0); //pembulatan keatas sampai hilang nilai desimal
                }
                // $res_data[$k]->month_salary += $res_data[$k]->today_salary;

        }
        // foreach ($res_data as $key => $value) {
        //     $terlambat += ($value->STATUS == 'terlambat') ? 1 : 0;
        //     $hadir += ($value->STATUS == 'hadir') ? 1 : 0;
        //     $total += $value->today_salary;
        // }
        // $data = [];
        // $data['terlambat'] = $terlambat;
        // $data['hadir'] =  $hadir;
        // $data['working_days'] = $terlambat + $hadir;
        // $data['sal'] = $total;
        $data['gaji'] = $res_data;
        $data['telat'] = $this->late_model->get_all()->row();
        
        $data['date'] = $date;
        $data['username'] = $username;
        $data['salary'] = $this->salary_model->get_by_id(['USERNAME' => $username]);
        $data['user'] = $this->user_model->get_by_id(['USERNAME' => $username]);
        $data['role'] = $this->userrole_model->get_by_id(['USER_ROLE_ID' => $data['user']->USER_ROLE_ID]);

        //load the view and saved it into $html variable
        $html=$this->load->view('print/absensi', $data, true);
        $mpdf = new mPDF('', 'A4');

        $mpdf->AddPage('P'); // Adds a new page in Landscape orientation

        $mpdf->WriteHTML($html);

        $mpdf->Output();
    }
    
}