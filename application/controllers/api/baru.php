<?php
/**
* 
*/
class Baru extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model(['attendance_model','userrole_model','user_model','salary_model','workingdays_model']);
	}

	public function index()
	{
			die('asdf');
	}

	public function detail_gaji()
    {
    	$username = 'verajuliantika';
    	$date = '2016-08';
        $exdate = explode('-', $date);
        $res_data = array();
        $res_data = $this->attendance_model->get_all("USERNAME = '".$username."' and ATTENDANCE_IN_DATE like '".$date.'-%'."' and status in ('hadir','terlambat','sakit','izin')")->result();
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

        $data['attendance'] = $res_data;
        // $this->template->display('laporan/detail_gaji',$data);
        // $this->response(array('success' => true, 'attendance' => $res_data, 'responseCode' => 200), 200);
  
        header('Content-Type: application/json');
        echo json_encode(array('attendance' => $res_data));

        die();
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


}