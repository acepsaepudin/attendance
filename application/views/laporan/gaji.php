<div class="nav navbar-nav navbar-right">
    <form class="navbar-form navbar-left" role="search" action="<?php echo site_url('laporan/data_gaji');?>" method="post">
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
    </form>
</div>
<!-- <hr> -->
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
        <td><a href="<?php echo site_url('laporan/detail_gaji/'.$key.'/'.$thn.'-'.$tgl);?>"><i class="glyphicon glyphicon-edit"></i> Detail</a></td>
        <!-- <td><a href="#" class="hapus" kode="<?php //echo $row->username;?>"><i class="glyphicon glyphicon-trash"></i></a></td> -->
    </tr>
    <?php endforeach;?>
</Table>
<?php //echo $pagination;?>

<script>

</script>
