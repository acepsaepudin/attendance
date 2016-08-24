<div class="nav navbar-nav navbar-right">
    <!-- <form class="navbar-form navbar-left" role="search" action="<?php echo site_url('karyawan/cari');?>" method="post">
        <div class="form-group">
            <label>Cari Nama</label>
            <input type="text" class="form-control" placeholder="Search" name="cari">
        </div>
        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i> Cari</button>
    </form> -->
    <a href="<?php echo site_url('dashboard/working_days');?>" class="btn btn-info" >Tambah</a>
</div>
<hr>
<?php echo $message;?>
<Table class="table table-striped">
    <thead>
        <tr>
            <td>No.</td>
            <td>Bulan</td>
            <td>Total Hari Kerja</td>
            <!-- <td colspan="2">Action</td> -->
        </tr>
    </thead>
    <?php $no=0; foreach($working_days as $row ): $no++;?>
    <tr>
        <td><?php echo $no;?></td>
        <td><?php echo bulan($row->WORKING_MONTH);?></td>
        <td><?php echo $row->WORKING_DAYS;?> Hari</td>
        <!-- <td><a href="<?php echo site_url('karyawan/edit/'.$row->username);?>"><i class="glyphicon glyphicon-edit"></i></a></td>
        <td><a href="#" class="hapus" kode="<?php echo $row->username;?>"><i class="glyphicon glyphicon-trash"></i></a></td> -->
    </tr>
    <?php endforeach;?>
</Table>
<?php //echo $pagination;?>

<script>
    $(function(){
        $(".hapus").click(function(){
            var kode=$(this).attr("kode");
            
            $("#idhapus").val(kode);
            $("#myModal").modal("show");
        });
        
        $("#konfirmasi").click(function(){
            var kode=$("#idhapus").val();
            
            $.ajax({
                url:"<?php echo site_url('karyawan/hapus');?>",
                type:"POST",
                data:"kode="+kode,
                cache:false,
                success:function(html){
                    location.href="<?php echo site_url('karyawan/index/delete_success');?>";
                }
            });
        });
    });
</script>
