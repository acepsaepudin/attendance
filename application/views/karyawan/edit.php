<legend><?php echo $title;?></legend>
<?php echo validation_errors();?>
<?php echo $message;?>

<form class="form-horizontal" action="<?php echo site_url('karyawan/edit/'.$karyawan['username']);?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label class="col-lg-2 control-label">Username</label>
        <div class="col-lg-5">
            <input type="text" name="name" class="form-control" value="<?php echo $karyawan['username'];?>" readonly="readonly">
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">IMEI</label>
        <div class="col-lg-5">
            <input type="text" name="imei" class="form-control" value="<?php echo $karyawan['imei_number'];?>" >
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Nama</label>
        <div class="col-lg-5">
            <input type="text" name="nama" class="form-control" value="<?php echo $karyawan['full_name'];?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Jenis Kelamin</label>
        <div class="col-lg-5">
            <select name="jk" class="form-control">
                <option value="<?php echo $karyawan['gender'];?>"><?php echo $karyawan['gender'];?></option>             
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Tanggal Lahir</label>
        <div class="col-lg-5">
            <input type="text" name="ttl" id="tanggal" class="form-control" value="<?php echo $karyawan['birthdate'];?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Alamat</label>
        <div class="col-lg-5">
            <input type="text" name="alamat" class="form-control" value="<?php echo $karyawan['address'];?>">
        </div>
    </div>
	<div class="form-group">
        <label class="col-lg-2 control-label">Status</label>
        <div class="col-lg-5">
            <select name="status" class="form-control">
                <option value="aktif" <?php echo ($karyawan['status'] == 'aktif') ? 'selected' : '';?>>Aktif</option>
                <option value="non-aktif" <?php echo ($karyawan['status'] == 'non-aktif') ? 'selected' : '';?>>Non-Aktif</option>
            </select>
        </div>
    </div>
    <div class="form-group well">
        <button class="btn btn-primary"><i class="glyphicon glyphicon-hdd"></i> Update</button>
        <a href="<?php echo site_url('karyawan');?>" class="btn btn-default">Kembali</a>
    </div>
</form>
