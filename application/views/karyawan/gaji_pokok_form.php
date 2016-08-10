<legend><?php echo $title;?></legend>
<?php echo validation_errors();?>
<?php echo $message;?>
<?php if($this->session->flashdata('sukses')):?>
    <?php echo $this->session->flashdata('sukses');?>
<?php endif;?>
<form class="form-horizontal" action="<?php echo site_url('karyawan/update_gaji_pokok/'.$role->USER_ROLE_ID);?>" method="post" enctype="multipart/form-data">
    <!-- <div class="form-group">
        <label class="col-lg-2 control-label">Username</label>
        <div class="col-lg-5">
            <input type="text" name="name" class="form-control" value="<?php echo $karyawan->USERNAME;?>" readonly="readonly">
        </div>
    </div> -->
    <div class="form-group">
        <label class="col-lg-2 control-label">Jabatan</label>
        <div class="col-lg-5">
            <input type="text" name="name" class="form-control" value="<?php echo $role->USER_ROLE_NAME;?>" readonly="readonly">
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Gaji Pokok</label>
        <div class="col-lg-5">
            <input type="text" name="gapok" class="form-control" value="<?php echo (isset($role->SALARY)) ? $role->SALARY : '';?>">
        </div>
    </div>
    
    
    
	
    <div class="form-group well">
        <button class="btn btn-primary"><i class="glyphicon glyphicon-hdd"></i> Update</button>
        <a href="<?php echo site_url('karyawan/gaji_pokok');?>" class="btn btn-default">Kembali</a>
    </div>
</form>
