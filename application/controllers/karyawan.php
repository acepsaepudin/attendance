<?php
class Karyawan extends CI_Controller{
    private $limit=20;
    
    function __construct(){
        parent::__construct();
        $this->load->library(array('template','pagination','form_validation','upload'));
        $this->load->model(['user_model','userrole_model']);
        
        if(!$this->session->userdata('username')){
            redirect('web');
        }
    }
    
    function index($offset=0,$order_column='full_name',$order_type='asc'){
        if(empty($offset)) $offset=0;
        if(empty($order_column)) $order_column='full_name';
        if(empty($order_type)) $order_type='asc';
        
        //load data
        $data['karyawan']=$this->user_model->get_karyawan_data($this->limit,$offset,$order_column,$order_type)->result();
        $data['title']="Data Karyawan";
        
        $config['base_url']=site_url('karyawan/index/');
        $config['total_rows']=$this->user_model->jumlah_karyawan();
        $config['per_page']=$this->limit;
        $config['uri_segment']=3;
        $this->pagination->initialize($config);
        $data['pagination']=$this->pagination->create_links();
        
        
        if($this->uri->segment(3)=="delete_success")
            $data['message']="<div class='alert alert-success'>Data berhasil dihapus</div>";
        else if($this->uri->segment(3)=="add_success")
            $data['message']="<div class='alert alert-success'>Data Berhasil disimpan</div>";
        else
            $data['message']='';
            $this->template->display('karyawan/index',$data);
    }
    
    
    function edit($id){
        $data['title']="Edit Data Karyawan";
        // $this->_set_rules();
        $this->form_validation->set_rules('nama','Nama','required|max_length[50]');
        $this->form_validation->set_rules('jk','Jenis Kelamin','required|max_length[2]');
        $this->form_validation->set_rules('ttl','Tanggal Lahir','required');
        $this->form_validation->set_rules('alamat','Alamat','required');
        // $this->form_validation->set_rules('status','Status','required|max_length[10]');
        $this->form_validation->set_error_delimiters("<div class='alert alert-danger'>","</div>");
        if($this->form_validation->run()==true){
            // $nis=$this->input->post('nis');
            $nis=$id;
            
            $info=array(
                'FULL_NAME'=>$this->input->post('nama'),
                // 'kelas'=>$this->input->post('kelas'),
                'BIRTHDATE'=>$this->input->post('ttl'),
                'GENDER'=>$this->input->post('jk'),
				'ADDRESS'=>$this->input->post('alamat'),
				'STATUS'=>$this->input->post('status'),
                // 'image'=>$gambar
            );
            //update data angggota
            $this->user_model->updatekar($nis,$info);
            
            //tampilkan pesan
            $data['message']="<div class='alert alert-success'>Data Berhasil diupdate</div>";
            
            //tampilkan data anggota 
            $data['karyawan']=$this->user_model->cek_karyawan($id)->row_array();
            $this->template->display('karyawan/edit',$data);
        }else{
            
            $data['karyawan']=$this->user_model->cek_karyawan($id)->row_array();
            $data['message']="";
            $this->template->display('karyawan/edit',$data);
        }
    }
    
    
    function tambah(){
        $data['title']="Tambah Data Anggota";
        $this->_set_rules();
        if($this->form_validation->run()==true){
            $nis=$this->input->post('nis');
            $cek=$this->m_anggota->cek($nis);
            if($cek->num_rows()>0){
                $data['message']="<div class='alert alert-warning'>Username sudah digunakan</div>";
                $this->template->display('anggota/tambah',$data);
            }else{
                //setting konfiguras upload image
                $config['upload_path'] = './assets/img/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1000';
		$config['max_width']  = '2000';
		$config['max_height']  = '1024';
                
                $this->upload->initialize($config);
                if(!$this->upload->do_upload('gambar')){
                    $gambar="";
                }else{
                    $gambar=$this->upload->file_name;
                }
                
                $info=array(
                    'nis'=>$this->input->post('nis'),
                    'nama'=>$this->input->post('nama'),
                    'jk'=>$this->input->post('jk'),
                    'ttl'=>$this->input->post('ttl'),
                    'kelas'=>$this->input->post('kelas'),
                    'image'=>$gambar
                );
                $this->m_anggota->simpan($info);
                redirect('anggota/index/add_success');
            }
        }else{
            $data['message']="";
            $this->template->display('anggota/tambah',$data);
        }
    }
    
    
    function hapus(){
        $kode=$this->input->post('kode');
        $detail=$this->m_anggota->cek($kode)->result();
	foreach($detail as $det):
	    unlink("assets/img/".$det->image);
	endforeach;
        $this->m_anggota->hapus($kode);
    }
    
    function cari(){
        $data['title']="Pencarian";
        $cari=$this->input->post('cari');
        $cek=$this->user_model->cari_karyawan($cari);
        if($cek->num_rows()>0){
            $data['message']="";
            $data['karyawan']=$cek->result();
            $this->template->display('karyawan/cari',$data);
        }else{
            $data['message']="<div class='alert alert-success'>Data tidak ditemukan</div>";
            $data['karyawan']=$cek->result();
            $this->template->display('karyawan/cari',$data);
        }
    }
    
    function _set_rules(){
        $this->form_validation->set_rules('nis','Name','required|max_length[10]');
        $this->form_validation->set_rules('nama','Nama','required|max_length[50]');
        $this->form_validation->set_rules('jk','Jenis Kelamin','required|max_length[2]');
        $this->form_validation->set_rules('ttl','Tanggal Lahir','required');
        $this->form_validation->set_rules('kelas','Alamat','required|max_length[10]');
		$this->form_validation->set_rules('status','Status','required|max_length[10]');
        $this->form_validation->set_error_delimiters("<div class='alert alert-danger'>","</div>");
    }

    public function gaji_pokok()
    {
        $data['message'] = '';
        $data['title']="Gaji Pokok";
        $data['karyawan'] = $this->userrole_model->get_all()->result();
        
        $this->template->display('karyawan/gaji_pokok',$data);
    }

    function cari_gaji_pokok(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $data['title']="Pencarian";
            $cari=$this->input->post('cari');
            $cek=$this->user_model->cari_karyawan($cari);
            
            if($cek->num_rows()>0){
                $data['message']="";
                $data['karyawan']=$cek->result();

                
                $this->template->display('karyawan/gaji_pokok',$data);
            }else{
                $data['message']="<div class='alert alert-success'>Data tidak ditemukan</div>";
                $data['karyawan']=$cek->result();
                $this->template->display('karyawan/gaji_pokok',$data);
            }
        } else {
            redirect('karyawan/gaji_pokok');
        }
    }

    public function update_gaji_pokok($user_role_id)
    {
        $this->load->model(['salary_model', 'userrole_model']);
        $data['title']="Gaji Pokok";
        $this->form_validation->set_rules('gapok', 'Gaji Pokok', 'required|is_natural');
        // $data['salary'] = $this->salary_model->get_by_id(['USERNAME' => $username]);
        // $data['karyawan'] = $this->user_model->get_by_id(['USERNAME' => $username]);
        $data['role'] = $this->userrole_model->get_by_id(['USER_ROLE_ID' => $user_role_id]);
        
        
        if ($this->form_validation->run() == false) {
            $data['message']="";
            // $data['karyawan']=$cek->result();
            $this->template->display('karyawan/gaji_pokok_form',$data);
        } else {
            $get_data = $this->userrole_model->get_by_id(['USER_ROLE_ID' => $user_role_id]);

            // if ($get_data) {
            $this->userrole_model->update(['SALARY' => $this->input->post('gapok')], ['USER_ROLE_ID' => $user_role_id]);
                // redirect('karyawan/update_gaji_pokok/'.$username);
                // $this->template->display('karyawan/gaji_pokok_form',$data);
            // } else {
            //     $this->userrole_model->save(['USERNAME' => $username, 'USER_SALARY' => $this->input->post('gapok')]);
            // }
            // $data['message']="<div class='alert alert-success'>Berhasil Mengubah Gaji Pokok.</div>";
            $this->session->set_flashdata('sukses',"<div class='alert alert-success'>Berhasil Mengubah Gaji Pokok.</div>");
            redirect('karyawan/update_gaji_pokok/'.$user_role_id);
            // $this->template->display('karyawan/gaji_pokok_form',$data);
        }
    }

    // public function potongan_terlambat()
    // {
    //     $data['message'] = '';
    //     $data['title']="Gaji Pokok";
    //     $data['karyawan'] = $this->user_model->get_all()->result();
        
    //     $this->template->display('karyawan/terlambat',$data);
    // }

    public function potongan_terlambat()
    {
        $this->load->model('late_model');
        $data['title']="Update Terlambat";
        $this->form_validation->set_rules('late', 'Potongan Terlambat', 'required|is_natural');
        
        
        if ($this->form_validation->run() == false) {
            $data['message']="";
            // $data['karyawan']=$cek->result();
            $data['late'] = $this->late_model->get_all()->row();
            $this->template->display('karyawan/terlambat_form',$data);
        } else {
            $get_data = $this->late_model->get_all();
            
            if ($get_data->num_rows() > 0) {
                $this->late_model->update([
                        'LATE_VALUE' => $this->input->post('late')
                    ],[
                        'ID' => $get_data->row()->ID
                    ]);
            } else {
                $this->late_model->save(['LATE_VALUE' => $this->input->post('late')]);
            }
                $this->session->set_flashdata('sukses',"<div class='alert alert-success'>Berhasil Mengubah Potongan Terlambat.</div>");
                redirect('karyawan/potongan_terlambat');
            // $this->template->display('karyawan/gaji_pokok_form',$data);
        }
    }
}
