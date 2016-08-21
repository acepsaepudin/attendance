<<!DOCTYPE html>
<html>
<head>
	<title>Print Gaji</title>
</head>
<body>
	<div class="container" style="border: 1px solid;">
		<div class="header" style="margin-left: 20px; margin-bottom: 30px;">
			<p>ECL LOGISTIK INDONESIA</p>
		</div>
		<div class="title" style="text-align: center;">
			<strong><u>SALARY SLIP</u></strong><br>
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
			<div class="allowance" style="float: left; width: 35%; margin-left: 5%;">
				<strong>ALLOWANCE</strong>
			</div>
			<div class="deduction" style="float: left; width: 40%">
				<strong>DEDUCTION</strong>
			</div>
			<div class="attendance" style="float: left; width: 20%">
				<strong>ATTENDANCE</strong>
			</div>
			<!-- <hr style="border: 10px solid;"> -->
			<div class="hr" style="border: 1px solid;">
				
			</div>
			<div class="allowance-detail" style="float: left; width: 35%; height: 40%; ">
				<table style="margin: 10px 0 0 45px;">
					<tr>
						<td>Gaji Pokok</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><?php echo number_format($salary->USER_SALARY,2,",",".")?></td>
					</tr>
				</table>
				
			</div>
			<div class="deduction-detail" style="float: left; width: 35%; margin-left: 5%; height: 40%;">
				
				<table style="margin: 10px 0 0 0;">
					<tr>
						<td>Keterlambatan</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><?php echo $terlambat.' x'.number_format(round((($salary->USER_SALARY/$working_days))),2,",",".");?></td>
					</tr>
				</table>
			</div>
			<div class="attendance-detail" style="float: left; width: 20%; height: 40%;border-left: 1px solid;">
				<table style="margin: 20px 0 0 0;">
					<tr>
						<td>Working Days</td>
						<td>: <?php echo $working_days;?></td>
					</tr>
					<tr>
						<td>Attendance</td>
						<td>: <?php echo $hadir;?></td>
					</tr>
					<tr>
						<td>Terlambat</td>
						<td>: <?php echo $terlambat;?></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="hr" style="border: 1px solid;">
		<div style="float: left; width: 35%;">
			<table style="margin: 10px 0 0 45px;">
					<tr>
						<td><strong>Total Allowance</strong></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						
						<td><?php echo '<strong>'.number_format($salary->USER_SALARY,2,",",".").'</strong>';?></td>
					</tr>
				</table>
		</div>
		<div style="float: left; width: 40%;">
			<table style="margin: 10px 0 0 45px;">
					<tr>
						<td><strong>Total Deduction</strong></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						
						<td><?php echo '<strong>'.number_format(round(($salary->USER_SALARY/$working_days),0)*$terlambat,2,",",".").'</strong>';?></td>
					</tr>
				</table>
		</div>
		<div class="attendance-detail" style="float: left; width: 20%;">
				&nbsp;
		</div>

	</div>
	<div class="hr" style="border: 1px solid;">
	<div style="float: left; width: 40%;">
			<table style="margin: 10px 0 0 20px;">
					<tr>
						<td><strong>Take Home Pay</strong></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						
						<td><?php echo '<strong>'.number_format($sal,2,",",".").'</strong>';?></td>
					</tr>
				</table>
		</div>
</body>
</html>