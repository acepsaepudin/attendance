<?php
class Login extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        $this->load->model(array('user_model'));        
    }
    
    function index(){
        $this->load->view('login');
    }
	
	function proses(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username','username','required|trim|xss_clean');
        $this->form_validation->set_rules('password','password','required|trim|xss_clean');
        
        if($this->form_validation->run()==false){
            $this->session->set_flashdata('message','Username dan password harus diisi');
            redirect('web');
        }else{
            $username=$this->input->post('username');
            $password=$this->input->post('password');
            $cek=$this->m_petugas->cek($username,md5($password));
            if($cek->num_rows()>0){
                //login berhasil, buat session
                $this->session->set_userdata('username',$username);
                redirect('dashboard');
                
            }else{
                //login gagal
                $this->session->set_flashdata('message','Username atau password salah');
                redirect('web');
            }
        }
    }
}