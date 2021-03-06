<?php
class Dashboard extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library(array('form_validation','template'));
        
        if(!$this->session->userdata('username')){
            redirect('web');
        }
    }
    
    function index(){
        $data['title']="Home";
        $this->template->display('dashboard/index',$data);
    }
    
    function admin(){
        $data['title']="Data Admin";
        $data['petugas']=$this->user_model->admin()->result();
        if($this->uri->segment(3)=="delete_success")
            $data['message']="<div class='alert alert-success'>Data berhasil dihapus</div>";
        else if($this->uri->segment(3)=="add_success")
            $data['message']="<div class='alert alert-success'>Data berhasil disimpan</div>";
        else
            $data['message']='';
        $this->template->display('dashboard/admin',$data);
    }
    
    function tambahpetugas(){
        $data['title']="Tambah Petugas";
        $this->_set_rules();
        if($this->form_validation->run()==true){
            $user=$this->input->post('user');
            $cek=$this->m_petugas->cekKode($user);
            if($cek->num_rows()>0){
                $data['message']="<div class='alert alert-danger'>Username sudah digunakan</div>";
                $this->template->display('dashboard/tambahpetugas',$data);
            }else{
                $info=array(
                    'user'=>$this->input->post('user'),
                    'password'=>md5($this->input->post('password'))
                );
                $this->m_petugas->simpan($info);
                redirect('dashboard/petugas/add_success');
            }
        }else{
            $data['message']="";
            $this->template->display('dashboard/tambahpetugas',$data);
        }
    }
    
    function edit($id){
        $data['title']="Update Data Admin";
        $this->_set_rules();
        if($this->form_validation->run()==true){
            $info=array(
                'username'=>$this->input->post('user'),
                'password'=>md5($this->input->post('password'))
            );
            $this->user_model->update_admin($id, $info);
            $data['admin']=$this->user_model->cek_admin($id)->row_array();
            $data['message']="<div class='alert alert-success'>Data Berhasil diupdate</div>";
            $this->template->display('dashboard/editadmin',$data);
        }else{
            $data['message']="";
            $data['admin']=$this->user_model->cek_admin($id)->row_array();
            $this->template->display('dashboard/editadmin',$data);
        }
    }
    
    function hapus(){
        $kode=$this->input->post('kode');
        $this->m_petugas->hapus($kode);
    }
    
    function _set_rules(){
        $this->form_validation->set_rules('user','username','required|trim');
        $this->form_validation->set_rules('password','password','required|trim');
        $this->form_validation->set_error_delimiters("<div class='alert alert-danger'>","</div>");
    }
    
    function logout(){
        $this->session->unset_userdata('username');
        redirect('web');
    }

    public function working_days()
    {
        $this->load->model('workingdays_model');
        $data['title'] = "Input Hari Kerja";
        $this->form_validation->set_rules('days', 'Jumlah Hari Kerja','required|is_natural');
        if ($this->form_validation->run() == false) {
            $data['message'] = '';
            $this->template->display('dashboard/working_days',$data);
        } else {
            $get_data = $this->workingdays_model->get_by_id(['WORKING_MONTH' => $this->input->post('working_month')]);
            if ($get_data) {
                $this->workingdays_model->update(['WORKING_DAYS' => $this->input->post('days')], ['WORKING_MONTH' => $this->input->post('working_month')]);
                $this->session->set_flashdata('sukses',"<div class='alert alert-success'>Berhasil Menyimpan Hari Kerja.</div>");
                redirect('dashboard/working_days');
            } else {
                $this->workingdays_model->save(['WORKING_MONTH' => $this->input->post('working_month'), 'WORKING_DAYS' => $this->input->post('days')]);

                $this->session->set_flashdata('sukses',"<div class='alert alert-success'>Berhasil Menyimpan Hari Kerja.</div>");
                redirect('dashboard/working_days');
            }
            
        }
    }
    public function working_days_list()
    {
        $this->load->model('workingdays_model');
        $data['title'] = 'List Working days';
        $data['working_days'] = $this->workingdays_model->get_all()->result();
        $data['message'] ='';
        $this->template->display('dashboard/working_days_list',$data);
    }
}