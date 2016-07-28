<div class="nav navbar-nav navbar-right">
    <!-- <form class="navbar-form navbar-left" role="search" action="<?php echo site_url('karyawan/cari');?>" method="post">
        <div class="form-group">
            <label>Cari Nama</label>
            <input type="text" class="form-control" placeholder="Search" name="cari">
        </div>
        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i> Cari</button>
    </form> -->
</div>
<hr>
<?php //echo $message;?>
<Table class="table table-striped">
    <thead>
        <tr>
            <td>No.</td>
            <td>Username</td>
            <td>Gaji Bulan ini</td>
			<td>Action</td>
            <!-- <td colspan="2"></td> -->
        </tr>
    </thead>
    <?php $no=0; foreach($gaji as $key => $value ): $no++;?>
    <tr>
        <td><?=$no;?></td>
        <td><?=$key?></td>
        <?php if($value):?>
            <td>Rp. <?=$value['month_salary'];?></td>
        <?php else:?>
            <td>-</td>
        <?php endif;?>
        <td><a href="<?php //echo site_url('karyawan/edit/'.$row->username);?>"><i class="glyphicon glyphicon-edit"></i></a></td>
        <!-- <td><a href="#" class="hapus" kode="<?php //echo $row->username;?>"><i class="glyphicon glyphicon-trash"></i></a></td> -->
    </tr>
    <?php endforeach;?>
</Table>
<?php //echo $pagination;?>

<script>

</script>
