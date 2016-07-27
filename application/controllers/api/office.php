<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Office extends REST_Controller
{
	function __construct()
    {
    	parent::__construct();
		$this->load->model('office_model');
    }
	
	function detail_get()
    {
		$model = $this->office_model->get_details();
			if(empty($model)){
				$this->response(array('success' => false, 'message' => 'No Office Data', 'responseCode' => 406), 406);
			} else {
				$this->response(array('success' => true, 'message' => 'Success', 'responseCode' => 200, 'data' => $model), 200);
			}
    }
	
}

?>