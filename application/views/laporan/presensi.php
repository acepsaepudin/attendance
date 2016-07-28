<legend><?php echo $title;?></legend>
<div class="nav navbar-nav navbar-right">
    <form class="navbar-form navbar-left" role="search" action="<?php echo site_url('laporan/presensi');?>" method="post">
        <div class="form-group">
            <label>Cari Tanggal</label>
            <input type="text" class="form-control" placeholder="Search" name="cari" id="tanggal">
        </div>
        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i> Cari</button>
    </form>
</div>
<!-- <hr> -->
<table class="table table-striped">
    <thead>
        <tr>
            <td>No.</td>
            <td>Tanggal</td>
            <td>Nama</td>
            <td>Jam Masuk</td>
            <td>Jam Pulang</td>
            <td>Action</td>
        </tr>
    </thead>
    <?php $no=0; foreach($presensi as $key => $value): $no++;?>
    <tr>
        <td><?php echo $no;?></td>
        <td><?php echo $value->USERNAME;?></td>
        <td><?php echo $value->ATTENDANCE_IN_DATE;?></td>
        <td><?php echo $value->ATTENDANCE_IN_TIME;?></td>
        <td><?php echo $value->ATTENDANCE_OUT_DATE;?></td>
        <td><a href="<?php echo site_url('laporan/presensi_edit/'.$value->USERNAME);?>"><i class="glyphicon glyphicon-edit"></i></a></td>
    </tr>
    <?php endforeach;?>
</table>