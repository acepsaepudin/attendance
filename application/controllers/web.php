<?php
class Web extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        $this->load->model(array('user_model'));
        if($this->session->userdata('username')){
            redirect('dashboard');
        }
    }
    
    function index(){
        $this->load->view('web/index');
    }
    
    function anggota(){
        $data['title']="Data Anggota";
        $data['anggota']=$this->m_anggota->semua()->result();
        $this->load->view('web/anggota',$data);
    }
    
    function login(){
        $this->load->view('web/login');
    }
    
    function proses(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username','Username','required|trim|xss_clean');
        $this->form_validation->set_rules('password','password','required|trim|xss_clean');
        
        if($this->form_validation->run()==false){
            $this->session->set_flashdata('message','Username dan password harus diisi');
            redirect('web');
        }else{
            $username=$this->input->post('username');
            $password=$this->input->post('password');
            $cek=$this->user_model->cek($username,md5($password));
            if ($cek->row()->USER_ROLE_ID == 2) {
                $this->session->set_flashdata('message','Username anda tidak bisa login ke aplikasi.');
                redirect('web');
            }
            if($cek->num_rows()>0){
                //login berhasil, buat sessionf
                
                $this->session->set_userdata('username',$username);
                $this->session->set_userdata('user_role_id',$cek->row()->USER_ROLE_ID);
                redirect('dashboard');
                
            }else{
                //login gagal
                $this->session->set_flashdata('message','Username atau password salah');
                redirect('web');
            }
        }
    }
}