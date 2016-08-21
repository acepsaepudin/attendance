<div class="nav navbar-nav navbar-right">
    <!-- <form class="navbar-form navbar-left" role="search" action="<?php echo site_url('laporan/data_gaji');?>" method="post">
        <div class="form-group">
            <label>Cari Gaji Berdasarkan Bulan</label>
            <select class="form-control" name="tahun">
                <?php for($i=1990;$i<=date('Y');$i++):?>
                    <option value="<?php echo $i;?>"><?php echo $i?></option>
                <?php endfor;?>
            </select>
            <select class="form-control" name="bulan">
                <?php for($i=1;$i<=12;$i++):?>
                    <option value="<?php echo ($i <10) ? '0'.$i:$i;?>" ><?php echo ($i < 10) ? '0'.$i:$i;?></option>
                <?php endfor;?>
            </select>
        </div>
        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i> Cari</button>
    </form> -->
</div>
<!-- <hr> -->
<?php //echo $message;?>
<Table class="table table-striped">
    <thead>
        <tr>
            <td>No.</td>
            <td>Username</td>
            <td>Tanggal Masuk</td>
            <td>Jam Masuk</td>
            <td>Tanggal Pulang</td>
            <td>Jam Pulang</td>
            <td>Gaji Perhari</td>
            <td>Status</td>
			<!-- <td>Action</td> -->
            <!-- <td colspan="2"></td> -->
        </tr>
    </thead>
    <?php 
    $terlambat = 0;
    $hadir = 0;
    $total = 0;
    $no=0; foreach($gaji as $key => $value ): $no++;?>
    <tr>
        <td><?=$no;?></td>
        <td><?=$value->USERNAME?></td>
        <td><?=$value->ATTENDANCE_IN_DATE?></td>
        <td><?=$value->ATTENDANCE_IN_TIME?></td>
        <td><?=$value->ATTENDANCE_OUT_DATE?></td>
        <td><?=$value->ATTENDANCE_OUT_TIME?></td>
        <td>Rp. <?=$value->today_salary?></td>
        <td><?=$value->STATUS?></td>
        
    </tr>
    <?php 
    $terlambat += ($value->STATUS == 'terlambat') ? 1 : 0;
    $hadir += ($value->STATUS == 'hadir') ? 1 : 0;
    $total += $value->today_salary;
    endforeach;?>
    <tr>
        <td>Gaji bulan ini</td>
        <td>Rp. <?=$total;?></td>
    </tr>
    <tr>
        <td>Total terlambat</td>
        <td><?=$terlambat;?> Hari</td>
    </tr>
    <tr>
        <td>Total hadir</td>
        <td><?=$hadir;?> Hari</td>
    </tr>
</Table>
<?php 
//untuk print
// $_SESSION['print_terlambat'] = $terlambat;
// $_SESSION['print_working_days'] = $hadir + $terlambat;
// $_SESSION['print_hadir'] = $hadir;

?>
<a href="<?=site_url('laporan/data_gaji')?>" class="btn btn-info">Kembali</a>
<a href="<?=site_url('laporan/print_gaji/'.$username.'/'.$date)?>" class="btn btn-success">Print Gaji</a>
<a href="<?=site_url('laporan/print_absensi/'.$username.'/'.$date)?>" class="btn btn-success">Print Absensi</a>
<?php //echo $pagination;?>

<script>

</script>
