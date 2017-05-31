<?php  
	session_start();
	if(isset($_SESSION['register']))
	{
		unset($_SESSION['register']);
	}
	else
	{
		header('Location:register.php'); 
	}
?>

<html>

<head>
	<title>Register Success</title>
	<link rel="stylesheet" href="bootstrap/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="common.css" >
</head>

<body>

	<?php require("nav_bar_arc.php"); ?>
	
	<center>
		<div class="form">
			<center>
				<h1 style="color:white;">REGISTRATION SUCCESSFUL</h1>
				<div class="register"><a href="login.php">LOG IN</a></div>
			</center>
		</div>
	</center>
</body>

</html>