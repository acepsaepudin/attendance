<<!DOCTYPE html>
<html>
<head>
	<title>Print Gaji</title>
</head>
<body>
	<div class="container" style="border: 2px solid;">
		<div class="header" style="margin-left: 20px; margin-bottom: 30px;">
			<p>ECL LOGISTIK INDONESIA</p>
		</div>
		<div class="title" style="text-align: center;">
			<strong><u>Attendance</u></strong><br>
			<?php echo date('F Y', strtotime($date));?>
		</div><hr>
		<div>
			<table>
				<tr>
					<td>Nama</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>: <?php echo $user->FULL_NAME;?></td>
				</tr>
				<tr>
					<td>Position</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>: <?php echo $role->USER_ROLE_NAME;?></td>
				</tr>
			</table>
			<hr>
			
				
			</div>
			
			
		<table style=" width: 100%;">
		    <thead>
		        <tr>
		            <td><strong>No.</strong></td>
		            <td><strong>Tanggal Masuk</strong></td>
		            <td><strong>Jam Masuk</strong></td>
		            <td><strong>Tanggal Pulang</strong></td>
		            <td><strong>Jam Pulang</strong></td>
		            <!-- <td>Gaji Perhari</td> -->
		            <td><strong>Status</strong></td>
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
		        <td><?=$value->ATTENDANCE_IN_DATE?></td>
		        <td><?=$value->ATTENDANCE_IN_TIME?></td>
		        <td><?=$value->ATTENDANCE_OUT_DATE?></td>
		        <td><?=$value->ATTENDANCE_OUT_TIME?></td>
		        <!-- <td>Rp. <?=$value->today_salary?></td> -->
		        <td><?=$value->STATUS?></td>
		        
		    </tr>
		    <?php 
		    $terlambat += ($value->STATUS == 'terlambat') ? 1 : 0;
		    $hadir += ($value->STATUS == 'hadir') ? 1 : 0;
		    $total += $value->today_salary;
		    endforeach;?>
		    <!-- <tr>
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
		    </tr> -->
		</table>	
		</div>
		
		
		

	</div>
	
</body>
</html>