<legend><?php echo $title;?></legend>
<?php echo validation_errors();?>
<?php echo $message;?>

<form class="form-horizontal" action="<?php echo site_url('laporan/list_presensi');?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label class="col-lg-2 control-label">Username</label>
        <div class="col-lg-5">
            <select name="username" class="form-control">
                <?php foreach($user as $k => $v):?>
                <option value="<?php echo $v->USERNAME;?>" ><?php echo $v->USERNAME;?></option>
                <?php endforeach;?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Tanggal</label>
        <div class="col-lg-5">
           <input type="text" name="tgl" id="tanggal" class="form-control" readonly="readonly"> 
        </div>
    </div>
	<div class="form-group">
        <label class="col-lg-2 control-label">Status</label>
        <div class="col-lg-5">
            <select name="status" class="form-control">
<!--                 <option value="hadir" >Hadir</option> -->
                <option value="izin" >Izin</option>
                <option value="sakit" >Sakit</option>
                <option value="cuti" >Cuti</option>
                <!-- <option value="tugas_luar" >Perjalanan Dinas</option> -->
                <!-- <option value="absen" >Alfa</option> -->
            </select>
        </div>
    </div>
    <div class="form-group well">
        <button class="btn btn-primary"><i class="glyphicon glyphicon-hdd"></i> Simpan</button>
        <a href="<?php echo site_url('laporan/presensi');?>" class="btn btn-default">Kembali</a>
    </div>
</form>
