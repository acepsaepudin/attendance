<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class User extends REST_Controller
{
	function __construct()
    {
    	parent::__construct();
		$this->load->model('user_model');
    }
		
	function login_post()
	{
		$username = $this->post('useraname');
		$password = $this->post('password');
		if(!empty($username) || !empty($password)){
			$model = $this->user_model->login($username, $password);
			if(empty($model)){
				$this->response(array('errorCode' => 404, 'message' => 'Login Failed'), 404);
			} else {
				$this->response(array('errorCode' => 0, 'message' => 'Success', 'data' => $model), 200);
			}						
		} else {
			$this->response(array('errorCode' => 400, 'message' => 'Parameter not completed'), 400);
		}
	
	}
	
	public function register_post()
	{
		if($this->validateCreate()){					
			$model = $this->user_model->check_username(post('username'));
			if(empty($model)){
				$model = $this->user_model->register(post('username'), post('password'), post('full_name'), post('gender'), post('birthdate'), post('imei_number'), post('status'));
				if(empty($model)){
					$this->response(array('success' => false, 'message' => 'Registration Failed', 'responseCode' => 406), 406);
				} else {
					$this->response(array('success' => true, 'message' => 'Registration Successfull', 'responseCode' => 200), 200);
				}															
			} else {
				$this->response(array('success' => false, 'message' => 'Username already exist', 'responseCode' => 409), 409);					
			}					
		} else {
			$this->response(array('success' => false, 'message' => 'Registration Not Completed', 'responseCode' => 400), 400);
		}
	}
	
	function profile_get($username)
	{
		if(!empty($username)){
			$model = $this->user_model->profile($username);
			if(empty($model)){
				$this->response(array('errorCode' => 404, 'message' => 'Get Profile Failed'), 404);
			} else {
				$this->response(array('errorCode' => 0, 'message' => 'Success', 'data' => $model), 200);
			}						
		} else {
			$this->response(array('errorCode' => 400, 'message' => 'Parameter not completed'), 400);
		}
	
	}
	
	public function validateCreate()
	{
		if(!post('user_role_id') || !post('user_active_id') || !post('username') || !post('password') || !post('birthdate') || !post('gender'))
			return false;
		else
			return true;
	}
	
}

?>