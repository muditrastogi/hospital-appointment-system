<?php  
	session_start();
	if(!isset($_SESSION['admin']))
	header('Location: admin_login.php'); 
?>

<html>

<head>
	<title>Admin Menu</title>
	<link rel="stylesheet" href="bootstrap/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="common.css" >
</head>

<body>
	
	<?php require("nav_bar_clc.php"); ?>

	<div class="form">
		<center>
		<table>
			<tr>
				<td>
					<a href="add_doctor.php" ><button type="button" class="btn btn-primary btn-lg " style="width:200; margin-right:40; margin-bottom:15;">Add Docotor</button></a>
				</td>
				<td>
					<a href="del_doctor.php" ><button type="button" class="btn btn-primary btn-lg" style="width:200; margin-bottom:15;">Remove Doctor</button></a>
				</td>
			</tr>
				
			<tr>
				<td>
					<a href="add_hospital.php" ><button type="button" class="btn btn-primary btn-lg" style="width:200; margin-right:40; margin-bottom:15;">Add hospital</button></a>
				</td>
				<td>
					<a href="del_hospital.php" ><button type="button" class="btn btn-primary btn-lg" style="width:200;  margin-bottom:15;">Remove Hospital</button></a>
				</td>
			</tr>
			
			<tr>
				<td>
					<button type="button" class="btn btn-primary btn-lg" style="width:200; margin-right:40; margin-bottom:15;">Generate Report</button>
				</td>
				<td>
					<a href="change_password.php" ><button type="button" class="btn btn-primary btn-lg" style="width:200; margin-right:40; margin-bottom:15;">Change Password</button></a>
				</td>
			</tr>
			
		</table>
		</center>
	</div>
</body>

</html>