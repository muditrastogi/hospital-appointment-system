<?php  
	session_start();
	if(!isset($_SESSION['admin']))
	header('Location: admin_login.php'); 
?>

<?php 

	$old_passwordErr = $new_passwordErr = $pwd_matchErr = "" ;
	$old_password = $new_password = $new_r_password = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		/////////////////////////////////////////////////////////	   
		if (empty($_POST["old_password"])) 
		{
			$old_passwordErr = "*Old Password is required";
		}
		else	
			$old_password=$_POST["old_password"];
		/////////////////////////////////////////////////////////	   
		if (empty($_POST["new_password"])) 
		{
			$new_passwordErr = "*New Password is required";
		}
		else	
			$new_password=$_POST["new_password"];
		////////////////////////////////////////////////////////
		
			$new_r_password=$_POST["new_r_password"];
			
		///////////////////////////////////////////////////////
		if ( ($_POST["new_password"]) != ($_POST["new_r_password"]) )
		{
			$pwd_matchErr = "*Password miss match";
		}
		else
			$new_password=$_POST["new_password"];
		///////////////////////////////////////////////////////

	
		//----------------------Inserting into Database----------------------------------
		if( empty($pwd_matchErr) )
		{
			if( empty($old_passwordErr) )
			{
				$con = new mysqli("localhost", "root" , "", "has");
				$enc_pass=sha1($new_password);
				
				$sql="SELECT password FROM admin";
				$result = $con->query($sql);
				$row=mysqli_fetch_array($result);
				$pass_from_db= $row['password'];
				if($pass_from_db == $old_password)
				{	
					$sql = "UPDATE admin SET password='$enc_pass'
							WHERE password='$old_password';";
							
					if(($con->query($sql)))
					{
						header("Location:admin_menu.php");
					}
				}
				else
				{
					$old_passwordErr = "*Old Password is incorrect";
				}
				$con->close();
			}	
		}
		else
			$pwd_matchErr = "*Password miss match";
	}
?>

<html>
<head>
	<title>Change Admin Password</title>
	<link rel="stylesheet" href="bootstrap/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="common.css" >
</head>

<body>

	<?php require("nav_bar_clc.php"); ?>
	
	<center>
		<div class="form">
			<center>
				<div class="register">Change Password</div>
				<div class="form_box">
					<form class="form-horizontal" role="form" action="" method="post">
					
						<div class="form-group">
							<label class="control-label col-sm-4" for="Password">Old Password:</label>
							<div class="col-sm-8"> 
								<input type="password" class="form-control" value="<?php echo "$old_password"; ?>" name="old_password" placeholder="Enter old password">
								<span><?php echo $old_passwordErr; ?></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" for="Password">New Password:</label>
							<div class="col-sm-8"> 
								<input type="password" class="form-control" value="<?php echo "$new_password"; ?>" name="new_password" placeholder="Enter new password">
								<span><?php echo $new_passwordErr; ?></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" for="Password">Re Enter New Password:</label>
							<div class="col-sm-8"> 
								<input type="password" class="form-control" value="<?php echo "$new_r_password"; ?>" name="new_r_password" placeholder="Re-enter new password">
								<span><?php echo $pwd_matchErr; ?></span>
							</div>
						</div>
						
						<div class="form-group"> </div>
						
						<div class="form-group"> 
							<div class="col-sm-offset-1 col-sm-10">
								<button type="submit" class="btn btn-primary">Submit</button>
							</div>
						</div>
						
					</form>
				</div>
			</center>
		</div>
	</center>
	
</body>
</html>