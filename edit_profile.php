<?php  
	session_start();
	if(!isset($_SESSION['id']))
	header('Location: login.php'); 
?>

<?php
	$hostname = "localhost";
	$username = "root";
	$key = "";
	$dbname = "has";
	$con = new mysqli($hostname, $username, $key, $dbname);
	
	$current_user_id=$_SESSION['id'];
	$sql="SELECT * FROM registered WHERE user_id='$current_user_id'";
	$result = $con->query($sql);
	$row=mysqli_fetch_array($result);
	$name= $row['name'];
	$email= $row['email'];
	$birth_date= $row['dob'];
	$gender= $row['gender'];
	$city= $row['city'];
	$mobile= $row['mobile'];
	$image= $row['image'];
	$con->close();
?>

<?php
	$mobileErr = $cityErr = $dobErr = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{	
		$current_user_id=$_SESSION['id'];
		$dob = $_POST["dob"];
		$gender = $_POST["gender"];
		$mobile = $_POST["mobile"];
		$city = $_POST["city"];
		$remove_image = $_POST["remove_image"];
		
		/*-------------------Image--------------------------------*/
			$image_name=$_FILES['file']['name'];
			$image_path="image/user_img/".$image_name;
			$image_tmpname=$_FILES['file']['tmp_name'];
			if( empty($image_tmpname) )
				$image_name = $image;
			if($remove_image == "yes")
			{
				$image_name = "";
			}
			if( !empty($image_tmpname) )
				move_uploaded_file($image_tmpname,$image_path);		
		/*-------------------Mobile Check------------------------*/
		if(!empty($mobile))
		{
			if (preg_match("/^[0-9]*$/",$mobile)) 
			{
				if((strlen($mobile))!=10)
					$mobileErr = "*Must be of 10 digits"; 
			}
			else
				$mobileErr = "*Invalid Mobile Number"; 
		}
		/*-------------------DOB Check------------------------*/
		$today_date = date("j-m-Y"); 
		$date1 = strtotime($today_date);
		$date2 = strtotime($dob);
		if ( ($date1 - $date2) < 3650) 
		{
			$dobErr = "*Select valid Date"; 
		}
		/*-------------------City Check------------------------*/
		if (!preg_match("/^[a-zA-Z ]*$/",$city)) 
			{
				$cityErr = "*Only letters and white space allowed"; 
			}
		/*----------------Insetting into Database--------------*/
		if(empty($mobileErr) && empty($cityErr) && empty($dobErr) && empty($imgErr) )
		{
			$con = new mysqli($hostname, $username, $key, $dbname);
		
			$sql=" UPDATE registered SET dob='$dob' , mobile='$mobile' , gender='$gender' , city='$city' , image='$image_name'
			WHERE user_id='$current_user_id'; ";
			
			$result = $con->query($sql);
			if(($con->query($sql)))
			{
				header("Location:user_menu.php");
			}
			$con->close();
		}
	}
?>

<html>

	<head>
		<title>Profile</title>
		<link rel="stylesheet" href="bootstrap/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="common.css" >
		<script src="bootstrap/jquery-1.11.3.min.js"></script>
		<script src="bootstrap/bootstrap.min.js"></script>
		<script src="bootstrap/bootstrap-filestyle.min.js"> </script>
		
		<script>
		$(document).ready(function() {
			$('#button').filestyle({
				buttonName : 'btn-info',
                buttonText : 'Select Image'
			});  
		});			
		</script>
	</head>

	<body>
		<?php require("nav_bar_uc.php"); ?>
		<div class="form">
			<center>
			<div class="register">Profile</div>
			<div class="form_box">
				<form class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data">
					
					<br>
					
					<div class="form-group">
						<div>
							<?php if($image==""){?>
							<img alt="user-image" src="image/user_img/default_profile_pic_user_<?php if($row['gender']!='-Select-')echo $row['gender']; else echo"male"; ?>.jpg" style="height:150px; width:130px; ">
							<?php }else{?>
							<img alt="user-image" src="image/user_img/<?php echo $image;?>" style="height:150px; width:130px; ">							
							<?php }?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4">Remove Image</label>
						<div class="col-sm-8"> 
							<select name="remove_image" class="form-control" >
								<option value="no">No</option>
								<option value="yes">Yes</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4">Change Profile Pic</label>
						<div class="col-sm-8">
							<input type="file" id="button" name="file">
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-4">Name</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" value="<?php echo "$name";?>" readonly>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-4">Email</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" value="<?php echo "$email";?>"readonly>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-4">Birth Date</label>
						<div class="col-sm-8">
							<input type="date" class="form-control" name="dob" value="<?php echo "$birth_date";?>" placeholder="Enter your Birth Date" >
							<span><?php echo $dobErr; ?></span>
						</div>
					</div>
  
					<div class="form-group">
						<label class="control-label col-sm-4">Mobile</label>
						<div class="col-sm-8"> 
							<input type="text" class="form-control" name="mobile" value="<?php echo "$mobile";?>" placeholder="Enter your Mobile No" >
							<span><?php echo $mobileErr; ?></span>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-4">Gender</label>
						<div class="col-sm-8"> 
							<select name="gender" class="form-control" >
								<option value="<?php echo $gender; ?>"><?php echo "$gender";?></option>
								<option value="Male">Male</option>
								<option value="Female">Female</option>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-4">City</label>
						<div class="col-sm-8"> 
							<input type="text" class="form-control" name="city" value="<?php echo "$city";?>" placeholder="Enter your City" >
							<span><?php echo $cityErr; ?></span>
						</div>
					</div>
					
					<div class="form-group"> </div>
					
					<div class="form-group"> 
						<div class="col-sm-offset-1 col-sm-10">
							<button type="submit" class="btn btn-primary" style="width:100">Save</button>
						</div>
					</div>
					
				</form>
			</div>
			</center>
		</div>
	</body>
</html>