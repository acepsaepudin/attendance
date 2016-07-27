<legend><?php echo $title;?></legend>
<table class="table table-striped">
    <thead>
        <tr>
            <td>No.</td>
            <td>Tanggal</td>
            <td>Jam Masuk</td>
            <td>Jam Pulang</td>
        </tr>
    </thead>
    <?php $no=0; foreach($presensi as $row): $no++;?>
    <tr>
        <td><?php echo $no;?></td>
        <td><?php echo $row->attendance_in_date;?></td>
        <td><?php echo $row->attendance_in_time;?></td>
        <td><?php echo $row->attendance_out_time;?></td>
    </tr>
    <?php endforeach;?>
</table>