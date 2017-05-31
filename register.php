<?php  
	session_start();  
	unset($_SESSION['user']);
	unset($_SESSION['admin']);
	unset($_SESSION['id']);	
?>
<?php 

	$nameErr = $emailErr = $passwordErr = $r_passwordErr = $pwd_matchErr = "" ;
	$name = $email = $password = $r_password = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		////////////////////////////////////////////////////////////
		if (empty($_POST["name"])) 
		{
			$nameErr = "*Name is required";
		} 
		else 
		{
			$name = $_POST["name"];
			if (!preg_match("/^[a-zA-Z ]*$/",$name)) 
			{
				$nameErr = "*Only letters and white space allowed"; 
			}
		}	   
		//////////////////////////////////////////////////////////	   
		if (empty($_POST["email"])) 
		{
			$emailErr = "*Email is required";
		}
		else 
		{
			$email = $_POST["email"];
			if (!filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$emailErr = "*Invalid email format"; 
			}
		}
		/////////////////////////////////////////////////////////	   
		if (empty($_POST["password"])) 
		{
			$passwordErr = "*Password is required";
		}
		else	
			$password=$_POST["password"];
		////////////////////////////////////////////////////////
		
			$r_password=$_POST["r_password"];
			
		///////////////////////////////////////////////////////
		if ( ($_POST["password"]) != ($_POST["r_password"]) )
		{
			$pwd_matchErr = "*Password miss match";
		}
		else
			$password=$_POST["password"];
		///////////////////////////////////////////////////////

	
		//----------------------Inserting into Database----------------------------------
		if( empty($pwd_matchErr) )
		{
			if( empty($nameErr) && empty($emailErr) && empty($passwordErr) && empty($r_passwordErr) )
			{
				$hostname = "localhost";
				$username = "root";
				$key = "";
				$dbname = "has";
				$con = new mysqli($hostname, $username, $key, $dbname);
				$enc_pass=sha1($password);
				
				$checkmail="SELECT email FROM registered where email='{$email}'";
				
				$result = $con->query($checkmail);
				if(mysqli_num_rows($result) < 1)
				{
					$sql = "INSERT INTO registered (name,email,password)
					VALUES ('$name','$email','$enc_pass')";	
					
					if(($con->query($sql)))
					{
						header("Location:register_success.php");
						$_SESSION['register']=2;  //for signup success
					}
				}
				else	
				{
					$emailErr = "*Email is already registered";
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
	<title>Register Page</title>
	<link rel="stylesheet" href="bootstrap/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="common.css" >
</head>

<body>

	<?php require("nav_bar_alc.php"); ?>
	
	<center>
		<div class="form">
			<center>
				<div class="register">REGISTER</div>
				<div class="form_box">
					<form class="form-horizontal" role="form" action="" method="post">
					
						<div class="form-group"> </div>
						<div class="form-group">
							<label class="control-label col-sm-4" for="name">Name:</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" value="<?php echo "$name" ?>" name="name" placeholder="Enter your Name">
								<span><?php echo $nameErr; ?></span>
							</div>
						</div>
						
						<div class="form-group">
						
							<label class="control-label col-sm-4" for="email">Email:</label>
							<div class="col-sm-8">
								<input type="email" class="form-control" value="<?php echo "$email" ?>" name="email" placeholder="Enter email">
								<span><?php echo $emailErr; ?></span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-4" for="password">Create Password:</label>
							<div class="col-sm-8">
								<input type="password" class="form-control" value="<?php echo "$password" ?>" name="password" placeholder="Enter new password">
								<span><?php echo $passwordErr; ?></span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-4" for="r_password">Re-Enter Password:</label>
							<div class="col-sm-8"> 
								<input type="password" class="form-control" value="<?php echo "$r_password" ?>" name="r_password" placeholder="Re-Enter password">
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