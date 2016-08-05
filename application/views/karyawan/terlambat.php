<div class="nav navbar-nav navbar-right">
    <form class="navbar-form navbar-left" role="search" action="<?php echo site_url('');?>" method="post">
        <div class="form-group">
            <label>Cari Nama</label>
            <input type="text" class="form-control" placeholder="Search" name="cari">
        </div>
        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i> Cari</button>
    </form>
</div>
<hr>
<?php echo $message;?>
<Table class="table table-striped">
    <thead>
        <tr>
            <td>No.</td>
            <td>Username</td>
            <td>Nama Lengkap</td>
            <td>JK</td>
            <td>Tanggal Lahir</td>
            <td>Alamat</td>
			<td>Status</td>
            <td colspan="2"></td>
        </tr>
    </thead>
    <?php $no=0; foreach($karyawan as $row ): $no++;?>
    <tr>
        <td><?php echo $no;?></td>
        <td><?php echo $row->USERNAME;?></td>
        <td><?php echo $row->FULL_NAME;?></td>
        <td><?php echo $row->GENDER;?></td>
        <td><?php echo $row->BIRTHDATE;?></td>
        <td><?php echo $row->ADDRESS;?></td>
		<td><?php echo $row->STATUS;?></td>
        <td><a href="<?php echo site_url('karyawan/update_terlambat/'.$row->USERNAME);?>"><i class="glyphicon glyphicon-edit"></i> Update Potongan Terlambat</a></td>
        <!-- <td><a href="#" class="hapus" kode="<?php echo $row->USERNAME;?>"><i class="glyphicon glyphicon-trash"></i></a></td> -->
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
