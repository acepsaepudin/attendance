<?php class Laporan extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        $this->load->library(array('template'));
        $this->load->model('attendance_model');
        
        if(!$this->session->userdata('username')){
            redirect('web');
        }
    }
     
    function presensi(){
        $data['title']="Data Laporan Presensi";
        $cek=$this->attendance_model->get_attendance_report();
        echo $cek->row();
        /*$data['message']="";
        $data['presensi']=$cek->result();
        $this->template->display('laporan/presensi',$data);
        */
    }
    
}