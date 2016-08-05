<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Attendance extends REST_Controller
{
	function __construct()
    {
    	parent::__construct();
		$this->load->model('attendance_model');
    }
	
	function masuk_post()
    {
		$model = $this->attendance_model->get_date();
		if(empty($model)){
			//cek jam masuk ganti kalau mau testing
			$max_hours = DateTime::createFromFormat('H:i', '08:00');
			$input = DateTime::createFromFormat('H:i', date('H:i'));
			$a = $max_hours->diff($input);

			if (($a->invert == 0) && ($a->h == 0) && ($a->i > 30)) {
				// die("lebih dari 8 30");
				$this->response(array('success' => false, 'message' => 'Anda Terlambat Lebih Dari 15 Menit.', 'responseCode' => 406), 406);
			} else {
				// die('Kurang dari 8 30');
				$model = $this->attendance_model->insert_masuk(post('username'), post('latitude'), post('longitude'));
				if(empty($model)){
					$this->response(array('success' => false, 'message' => 'Presensi Masuk Gagal', 'responseCode' => 406), 406);
				} else {
					$this->response(array('success' => true, 'message' => 'Presensi Masuk Berhasil', 'responseCode' => 200), 200);
				}	
			}
			
			exit;

		} else {
			$this->response(array('success' => true, 'message' => 'Sudah Melakukan Presensi Masuk Sebelumnya', 'responseCode' => 406), 406);
		}		
    }
	
	function pulang_post()
    {
    	date_default_timezone_set("Asia/Jakarta");
    	//cek jam masuk , ganti jam max_hours sesuai selera
		$max_hours = DateTime::createFromFormat('H:i', '16:00');
		
		$input = DateTime::createFromFormat('H:i', date('H:i'));
		$a = $max_hours->diff($input);
		// exit;
		if (($a->invert == 1)) {
			// die('jangan pulang');
			$this->response(array('success' => false, 'message' => 'Anda Belum Diperbolehkan Pulang.', 'responseCode' => 406), 406);
		}else {
			//check jika user alfa/gak masuk
			$check = $this->attendance_model->get_attendance_current_user(post('attendance_id'));

				// die('boleh pulang');
			if ($check) {
				$model = $this->attendance_model->update_pulang(post('attendance_id'), post('latitude'), post('longitude'));
				if(empty($model)){
					$this->response(array('success' => false, 'message' => 'Presensi Pulang Gagal', 'responseCode' => 406), 406);
				} else {
					$this->response(array('success' => true, 'message' => 'Presensi Pulang Berhasil', 'responseCode' => 200), 200);
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
}

?>