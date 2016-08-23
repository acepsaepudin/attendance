<legend><?php echo $title;?></legend>
<?php echo validation_errors();?>
<?php echo $message;?>

<form class="form-horizontal" action="<?php echo site_url('laporan/presensi_edit/'.$presensi->USERNAME);?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label class="col-lg-2 control-label">Username</label>
        <div class="col-lg-5">
            <input type="text" name="name" class="form-control" value="<?php echo $presensi->USERNAME;?>" readonly="readonly">
        </div>
    </div>
    
    
	<div class="form-group">
        <label class="col-lg-2 control-label">Status</label>
        <div class="col-lg-5">
            <select name="status" class="form-control">
                <option value="izin" <?php echo ($presensi->STATUS == 'izin') ? 'selected' : '';?>>Izin</option>
                <option value="sakit" <?php echo ($presensi->STATUS == 'sakit') ? 'selected' : '';?>>Sakit</option>
                <option value="sakit" <?php echo ($presensi->STATUS == 'alfa') ? 'selected' : '';?>>Alpha</option>
            </select>
        </div>
    </div>
    <div class="form-group well">
        <button class="btn btn-primary"><i class="glyphicon glyphicon-hdd"></i> Update</button>
        <a href="<?php echo site_url('laporan/presensi');?>" class="btn btn-default">Kembali</a>
    </div>
</form>
