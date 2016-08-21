<legend><?php echo $title;?></legend>
<?php echo validation_errors();?>
<?php echo $message;?>
<?php if($this->session->flashdata('sukses')):?>
    <?php echo $this->session->flashdata('sukses');?>
<?php endif;?>
<form class="form-horizontal" action="<?php echo site_url('dashboard/working_days');?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label class="col-lg-2 control-label">Bulan</label>
        <div class="col-lg-5">
            <select name="working_month" class="form-control">
                <option value="01">Januari</option>
                <option value="02">Februari</option>
                <option value="03">Maret</option>
                <option value="04">April</option>
                <option value="05">Mei</option>
                <option value="06">Juni</option>
                <option value="07">Juli</option>
                <option value="08">Agustus</option>
                <option value="09">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Total Hari Kerja</label>
        <div class="col-lg-5">
           <input type="text" name="days" id="days" class="form-control"> 
        </div>
    </div>
    <div class="form-group well">
        <button class="btn btn-primary"><i class="glyphicon glyphicon-hdd"></i> Simpan</button>
        <a href="<?php echo site_url('dashboard');?>" class="btn btn-default">Kembali</a>
    </div>
</form>
