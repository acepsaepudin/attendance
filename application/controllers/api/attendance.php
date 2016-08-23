<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Attendance extends REST_Controller
{
	function __construct()
    {
    	parent::__construct();
		$this->load->model(['attendance_model','userrole_model','user_model','salary_model']);
    }
	
	function masuk_post()
    {
    	date_default_timezone_set("Asia/Jakarta");
		$model = $this->attendance_model->get_date_masuk();
		if(empty($model)){
			//cek jam masuk ganti kalau mau testing
			$max_hours = DateTime::createFromFormat('H:i','09:00');

			$input = DateTime::createFromFormat('H:i', date('H:i'));
			$a = $max_hours->diff($input);

			if (($a->invert == 0) && ($a->h == 0) && ($a->i > 30)) {
				$absen = array(
					'username' => post('username'),
					'office_id' => '1',
					'attendance_id' => date('U'),
					'attendance_in_date' => date('Y-m-d'),
					'attendance_in_time' => '',
					'attendance_out_date' => '',
					'attendance_out_time' => '',
					'latitude_in' => post('latitude'),
					'longitude_in' => post('longitude'),
					'status' => 'absen'			
				);
				$this->attendance_model->save($absen);
				// die("lebih dari 8 30");
				$this->response(array('success' => true, 'message' => 'Anda Sudah Tidak Diperbolehkan Untuk Presensi Masuk.', 'responseCode' => 200), 200);
			}
			if (($a->invert == 0) && ($a->h == 0) && ($a->i > 30)) {
				// die('telat dipotong 4 jam');
				$epoch = new DateTime(date('Y/m/d H:i:s'));	
				//ganti jam masuk start dari jam 12
				$masuk = DateTime::createFromFormat('H:i','09:00');
				$absen = array(
					'username' => post('username'),
					'office_id' => '1',
					'attendance_id' => $epoch->format('U'),
					'attendance_in_date' => date('Y-m-d'),
					'attendance_in_time' => date('H:i:s'),
					'attendance_out_date' => '',
					'attendance_out_time' => '',
					'latitude_in' => post('latitude'),
					'longitude_in' => post('longitude'),
					'status' => 'terlambat'			
				);
				$this->attendance_model->save($absen);

				$this->response(array('success' => true, 'message' => 'Anda Terlambat', 'responseCode' => 200), 200);
			}
			else {
				//dianggap masuk jam 8 untuk perhitungan gaji
				$epoch = new DateTime(date('Y/m/d H:i:s'));
				$masuk = DateTime::createFromFormat('H:i','09:00');
				$absen = array(
					'username' => post('username'),
					'office_id' => '1',
					'attendance_id' => $epoch->format('U'),
					'attendance_in_date' => date('Y-m-d'),
					'attendance_in_time' => date('H:i:s'),
					'attendance_out_date' => '',
					'attendance_out_time' => '',
					'latitude_in' => post('latitude'),
					'longitude_in' => post('longitude'),
					'status' => 'hadir'			
				);
				$this->attendance_model->save($absen);
				$this->response(array('success' => true, 'message' => 'Presensi Masuk Berhasil', 'responseCode' => 200), 200);
			}

		} else {
			$this->response(array('success' => true, 'message' => 'Sudah Melakukan Presensi Masuk Sebelumnya', 'responseCode' => 406), 406);
		}		
    }
	
	function pulang_post()
    {
    	date_default_timezone_set("Asia/Jakarta");
    	//cek jam masuk , ganti jam max_hours sesuai selera
		$max_hours = DateTime::createFromFormat('H:i','16:00');
		
		$input = DateTime::createFromFormat('H:i', date('H:i'));
		$a = $max_hours->diff($input);

		if (($a->invert == 1)) {
			// die('jangan pulang');
			$this->response(array('success' => false, 'message' => 'Anda Belum Diperbolehkan Pulang.', 'responseCode' => 406), 406);
		}else {
			//check jika user alfa/gak masuk
			$check = $this->attendance_model->get_attendance_current_user(post('attendance_id'));

				// die('boleh pulang');
			if ($check) {
				$pernah_absen = $this->attendance_model->get_by_id(array('attendance_id' => post('attendance_id')));

				//check apakah user pernah keluar absen
				if ($pernah_absen->ATTENDANCE_OUT_DATE == '0000-00-00') {

					//set maksimal jam lembur
					$max_pulang = DateTime::createFromFormat('H:i','21:00');
					$input_pulang = DateTime::createFromFormat('H:i', date('H:i'));
					$max_db_input = DateTime::createFromFormat('H:i','21:00');
					$b = $max_pulang->diff($input_pulang);

					//inputan dibawah jam 9 malam
					if ($b->invert == 1) {
						$absen = array(
							'attendance_out_date' => date('Y-m-d'),
							'attendance_out_time' => date('H:i:s'),
							'latitude_in' => post('latitude'),
							'longitude_in' => post('longitude')	
						);
					} else {
						//inputan diatas jam 9 malam,jadi input dipaksa lembur hanya sampai jam 9 malam saja.
						$absen = array(
							'attendance_out_date' => date('Y-m-d'),
							'attendance_out_time' => date('H:i:s'),
							'latitude_in' => post('latitude'),
							'longitude_in' => post('longitude')	
						);
					}
					$this->attendance_model->update($absen, array('attendance_id' => post('attendance_id')));
					$this->response(array('success' => true, 'message' => 'Presensi Pulang Berhasil', 'responseCode' => 200), 200);
				} else {
					//sudah pernah klik absen pulang
					$this->response(array('success' => false, 'message' => 'Anda Sudah Melakukan Presensi Pulang', 'responseCode' => 406), 406);
				}
			} else {
				$this->response(array('success' => false, 'message' => 'Anda Absen Hari ini', 'responseCode' => 406), 406);
			}
		}

    }
	
	function uid_get()
    {
		$model = $this->attendance_model->get_date();
		if(empty($model)){
			$this->response(array('success' => false, 'message' => 'Data Empty', 'responseCode' => 406), 406);
		} else {
			$this->response(array('success' => true, 'data' => $model, 'responseCode' => 200), 200);
		}			
    }
	
	function current_get()
    {
		$model = $this->attendance_model->get_current_attendance();
		if(empty($model)){
			$this->response(array('success' => false, 'message' => 'Data Empty', 'responseCode' => 406), 406);
		} else {
			$this->response(array('success' => true, 'data' => $model, 'responseCode' => 200), 200);
		}			
    }
	
	function info_get()
    {
		$model = $this->attendance_model->get_info_attendance();
		if(empty($model)){
			$this->response(array('success' => false, 'message' => 'Data Empty', 'responseCode' => 406), 406);
		} else {
			$this->response(array('success' => true, 'data' => $model, 'responseCode' => 200), 200);
		}			
    }	
	
	function test_get()
    {
		$model = $this->attendance_model->get_date();
		if(empty($model)){
			$this->response(array('success' => false, 'message' => $model, 'responseCode' => 406), 406);				
		} else {
			$this->response(array('success' => true, 'message' => 'Sudah Absen', 'responseCode' => 406), 406);
		}		
    }
	
	function reports_get()
    {
		$model = $this->attendance_model->get_report_attendance();
		if(empty($model)){
			$this->response(array('success' => false, 'message' => $model, 'responseCode' => 406), 406);				
		} else {
			$this->response(array('success' => true, 'message' => 'Sudah Absen', 'responseCode' => 406), 406);
		}		
    }

    public function detail_gaji_get()
    {
    	$username = 'verajuliantika';
    	$date = '2016-07';
        $exdate = explode('-', $date);
        $res_data = array();
        $res_data = $this->attendance_model->get_all("USERNAME = '".$username."' and ATTENDANCE_IN_DATE like '".$date.'-%'."' and status in ('hadir','terlambat')")->result();
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

?>
