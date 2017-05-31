<?php  
	session_start();
	if(isset($_SESSION['id']))
	{
		unset($_SESSION['id']);
		unset($_SESSION['user']);
	}
	else if(isset($_SESSION['admin']))
		header('Location: admin_menu.php'); 
?>
<?php

	$passwordErr = "";
	$password = "";
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		$password = $_POST['password'];	
		if (empty($password)) 
		{
			$passwordErr = "Password required ";
		}

		//-------------Create connection---------------------------------
		$conn = new mysqli("localhost", "root" , "", "has");
   
		if( empty($passwordErr) ) 
	   {
			$sql = "SELECT password FROM admin";
			$result = $conn->query($sql);
			$row=mysqli_fetch_array($result);
			$pass_from_db= $row['password'];
		
			if( $pass_from_db == sha1($password) ) 
			{
				$_SESSION['admin'] = 'Admin';
				header("location:admin_menu.php");
			}
			else 
			{
				$passwordErr = "*Password is incorrect";
			}
	   }
	}
?>


<html>
<head>
	<title>Login Page</title>
	<link rel="stylesheet" href="bootstrap/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="common.css" >
</head>

<body>

	<?php require("nav_bar_arc.php"); ?>
	
	<center>
		<div class="form">
			<center>
				<div class="register">ADMIN LOG IN</div>
				<div class="form_box">
					<form class="form-horizontal" role="form" action="" method="post">
					
						<div class="form-group"> </div>
						<div class="form-group">
							<label class="control-label col-sm-4" for="email">User Name:</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" value="Admin" readonly>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-4" for="Password">Password:</label>
							<div class="col-sm-8"> 
								<input type="password" class="form-control" value="<?php echo "$password"; ?>" name="password" placeholder="Enter password">
								<span> <?php echo $passwordErr; ?></span>
							</div>
						</div>
						
						<div class="form-group"></div>
						<div class="form-group"> 
							<div class="col-sm-offset-1 col-sm-10">
								<button type="submit" class="btn btn-primary">Log In</button>
							</div>
						</div>
					</form>
				</div>
			</center>
		</div>
	</center>
</body>
</html>