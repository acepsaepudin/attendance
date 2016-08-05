<legend><?php echo $title;?></legend>
<?php echo validation_errors();?>
<?php echo $message;?>
<?php if($this->session->flashdata('sukses')):?>
    <?php echo $this->session->flashdata('sukses');?>
<?php endif;?>
<form class="form-horizontal" action="<?php echo site_url('karyawan/potongan_terlambat');?>" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label class="col-lg-3 control-label">Potongan Terlambat</label>
        <div class="col-lg-5">
            <input type="text" name="late" class="form-control" value="<?php echo (isset($late->LATE_VALUE)) ? $late->LATE_VALUE : '';?>">
        </div>
    </div>

    
	
    <div class="form-group well">
        <button class="btn btn-primary"><i class="glyphicon glyphicon-hdd"></i> Update</button>
        <a href="<?php echo site_url('karyawan/gaji_pokok');?>" class="btn btn-default">Kembali</a>
    </div>
</form>
