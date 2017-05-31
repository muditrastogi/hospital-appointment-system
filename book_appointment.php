<?php  
	session_start();
	if(!isset($_SESSION['id']))
	header('Location: login.php'); 
?>
<?php 
	$conn = new mysqli("localhost", "root" , "", "has");
	
	$doc_id= $_GET["d_id"];
	$hos_id= $_GET["h_id"];
	
	$sql_doc = " SELECT * from doctor WHERE doc_id='$doc_id' ";
	$result_doc = $conn->query($sql_doc);
	$row_doc = mysqli_fetch_array($result_doc);
	
	$sql_hos = " SELECT * from hospital WHERE hos_id='$hos_id' ";
	$result_hos = $conn->query($sql_hos);
	$row_hos = mysqli_fetch_array($result_hos);
	
	$conn->close();
?>
<?php /*--------To genereate time slot list---------------*/

	$con = new mysqli("localhost", "root" , "", "has");
	$doc_id = $_GET["d_id"];

	$data = array();
	$sql = "SELECT DISTINCT date FROM appointments WHERE doc_id = '$doc_id' ";
	$result = mysqli_query($con,$sql);
	while($row = mysqli_fetch_array($result))
	{
	   $date = $row['date'];
	   $slot = array();
	   $sql2 ="SELECT slot_no FROM appointments WHERE date = '$date' AND doc_id = '$doc_id' ";
	   $result2 = mysqli_query($con,$sql2);
	   while($row2 = mysqli_fetch_array($result2))
	   {
		array_push($slot, $row2['slot_no']);
	   }
	   $data[$date] = $slot;
	}
	$con->close();
?>
<?php /*--------Validate and Insert-----------------------*/

	$nameErr = $ageErr = $genderErr = $dateErr = $timeErr = "" ;
	$name = $age = $date = $gender = $time = "";
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		////////////////////////////////////////////////////////////
		if (empty($_POST["patient_name"])) 
		{
			$nameErr = "*Patient name is required";
		} 
		else 
		{
			$name = $_POST["patient_name"];
			if (!preg_match("/^[a-zA-Z ]*$/",$name)) 
			{
				$nameErr = "*Only letters and white space allowed"; 
			}
		}	   
		//////////////////////////////////////////////////////////	   
		if (empty($_POST["patient_age"])) 
		{
			$ageErr = "*Patient age is required";
		} 
		else 
		{
			$age = $_POST["patient_age"];
			if (!is_numeric($age)) 
			{
				$ageErr = "*Enter valid Age"; 
			}
		}
		//////////////////////////////////////////////////////////	   
		if (empty($_POST["gender"])) 
		{
			$genderErr = "*Select Gender";
		} 
		else
			$gender=$_POST["gender"];
		//////////////////////////////////////////////////////////	   
		if (empty($_POST["time"])) 
		{
			$timeErr = "*Select Time Slot";
		} 	
		else
			$time=$_POST["time"];
		if($time == '10:00 am-10:20 am')
			$slot_no = 1;
		else if($time == '10:20 am-10:40 am')
			$slot_no = 2;
		else if($time == '10:40 am-11:00 am')
			$slot_no = 3;
		else if($time == '11:10 am-11:30 am')
			$slot_no = 4;
		else if($time == '11:30 am-11:50 am')
			$slot_no = 5;
		else if($time == '12:00 pm-12:20 pm')
			$slot_no = 6;
		else if($time == '12:20 pm-12:40 pm')
			$slot_no = 7;
		else if($time == '12:40 pm-01:00 pm')
			$slot_no = 8;
		///////////////////////////////////////////////////////
		$today_date = date("j-m-Y"); 
		$date = $_POST["date"];
		$date1 = strtotime($today_date);
		$date2 = strtotime($date);
		if ( empty($_POST["date"]) )
		{
			$dateErr = "*Select Date";
		}
		else
		{
			if ($date2 <= $date1) 
			{
				$dateErr = "*Select valid Date"; 
			}
		}	
		///////////////////////////////////////////////////////

	
		//----------------------Inserting into Database----------------------------------
		if( empty($nameErr) && empty($ageErr) && empty($genderErr) && empty($dateErr) && empty($timeErr) )
		{
			$u_id=$_SESSION['id'];
			$conn = new mysqli("localhost", "root" , "", "has");
			$sql = "INSERT INTO appointments (user_id,doc_id,hos_id,patient_name,patient_age,gender,date,time_slot,slot_no)
					VALUES ('$u_id','$doc_id','$hos_id','$name','$age','$gender','$date','$time','$slot_no')";	
			if(($conn->query($sql)))
			{
				header("Location:user_menu.php");
			}
		}
	}
?>

<html>
<head>
	<title>Booking Page</title>
	<link rel="stylesheet" href="bootstrap/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="common.css" >
	<script src="bootstrap/jquery-1.11.3.min.js"></script>
	<script src="bootstrap/bootstrap.min.js"></script>
	<link rel="stylesheet" href="bootstrap/jquery-ui.css">
	<script src="bootstrap/jquery-ui.js"></script>
	<script>
		$(function(){
			$( "#date" ).datepicker({ minDate: +1, maxDate: "+2W", dateFormat:'dd-mm-yy' });
		});	
	</script>
	
	
<script type = "text/javascript" language = "javascript">  /*-----------Display slots Dynamically------------*/
	
	$(document).ready(function() {
		
		$("#date").change(function(){
			
			
			var data = '<?php echo json_encode($data);?>';
			var date = $(this).val();
			
			var passedData = 'date=' + date + '&d_id=' + <?php echo $_GET['d_id'] ?>;
			
			$(".added").remove();
			$.ajax( {
			type: "POST",
			url:'load_slot.php',
			data:passedData,
			cache: false,
			success:function(x) {
			var y=1;
			if(x == y)
			{
			
				var arr = JSON.parse(data);
				
				if(date !=  "")
				{
					var slot = arr[date];
					/*------------------Slot 1---------------------------*/
					for(var i=0;i<slot.length;i++)
					{
						//$("#slot_list").append('<option class="added" value = '+JSON.stringify(slot[i]) +'>'+slot[i]+'</option>')
						var flag=0;
						if(slot[i] == 1)
						{
							$("#slot_list").append('<option class="added" style="color:orange;" value = "10:00 am-10:20 am" disabled>'+'10:00 am-10:20 am (Booked)'+'</option>')
							flag=1; break;
						}
					}
						if(flag == 0)
							$("#slot_list").append('<option class="added" style="color:blue;" value = "10:00 am-10:20 am">'+'10:00 am-10:20 am (Available)'+'</option>')
					/*------------------Slot 2---------------------------*/
					for(var i=0;i<slot.length;i++)
					{
						var flag=0;
						if(slot[i] == 2)
						{
							$("#slot_list").append('<option class="added" style="color:orange;" value = "10:20 am-10:40 am" disabled>'+'10:20 am-10:40 am (Booked)'+'</option>')
							flag=1; break;
						}
					}
						if(flag == 0)
							$("#slot_list").append('<option class="added" style="color:blue;" value = "10:20 am-10:40 am">'+'10:20 am-10:40 am (Available)'+'</option>')
					/*------------------Slot 3---------------------------*/
					for(var i=0;i<slot.length;i++)
					{
						var flag=0;
						if(slot[i] == 3)
						{
							$("#slot_list").append('<option class="added" style="color:orange;" value = "10:40 am-11:00 am" disabled>'+'10:40 am-11:00 am (Booked)'+'</option>')
							flag=1; break;
						}
					}
						if(flag == 0)
							$("#slot_list").append('<option class="added" style="color:blue;" value = "10:40 am-11:00 am">'+'10:40 am-11:00 am (Available)'+'</option>')
					/*------------------Slot 4---------------------------*/
					for(var i=0;i<slot.length;i++)
					{
						var flag=0;
						if(slot[i] == 4)
						{
							$("#slot_list").append('<option class="added" style="color:orange;" value = "11:10 am-11:30 am" disabled>'+'11:10 am-11:30 am (Booked)'+'</option>')
							flag=1; break;
						}
					}
						if(flag == 0)
							$("#slot_list").append('<option class="added" style="color:blue;" value = "11:10 am-11:30 am">'+'11:10 am-11:30 am (Available)'+'</option>')
					/*------------------Slot 5---------------------------*/
					for(var i=0;i<slot.length;i++)
					{
						var flag=0;
						if(slot[i] == 5)
						{
							$("#slot_list").append('<option class="added" style="color:orange;" value = "11:30 am-11:50 am" disabled>'+'11:30 am-11:50 am (Booked)'+'</option>')
							flag=1; break;
						}
					}
						if(flag == 0)
							$("#slot_list").append('<option class="added" style="color:blue;" value = "11:30 am-11:50 am">'+'11:30 am-11:50 am (Available)'+'</option>')
					/*------------------Slot 6---------------------------*/
					for(var i=0;i<slot.length;i++)
					{
						var flag=0;
						if(slot[i] == 6)
						{
							$("#slot_list").append('<option class="added" style="color:orange;" value = "12:00 pm-12:20 pm" disabled>'+'12:00 pm-12:20 pm (Booked)'+'</option>')
							flag=1; break;
						}
					}
						if(flag == 0)
							$("#slot_list").append('<option class="added" style="color:blue;" value = "12:00 pm-12:20 pm">'+'12:00 pm-12:20 pm (Available)'+'</option>')
					/*------------------Slot 7---------------------------*/
					for(var i=0;i<slot.length;i++)
					{
						var flag=0;
						if(slot[i] == 7)
						{
							$("#slot_list").append('<option class="added" style="color:orange;" value = "12:20 pm-12:40 pm" disabled>'+'12:20 pm-12:40 pm (Booked)'+'</option>')
							flag=1; break;
						}
					}
						if(flag == 0)
							$("#slot_list").append('<option class="added" style="color:blue;" value = "12:20 pm-12:40 pm">'+'12:20 pm-12:40 pm (Available)'+'</option>')
					/*------------------Slot 8---------------------------*/
					for(var i=0;i<slot.length;i++)
					{
						var flag=0;
						if(slot[i] == 8)
						{
							$("#slot_list").append('<option class="added" style="color:orange;" value = "12:40 pm-01:00 pm" disabled>'+'12:40 pm-01:00 pm (Booked)'+'</option>')
							flag=1; break;
						}
					}
						if(flag == 0)
							$("#slot_list").append('<option class="added" style="color:blue;" value = "12:40 pm-01:00 pm">'+'12:40 pm-01:00 pm (Available)'+'</option>')
					/*--------------------------------------------------*/
				}
			}
			else
			{
				$("#slot_list").append('<option class="added" style="color:blue;" value = "10:00 am-10:20 am">'+'10:00 am-10:20 am (Available)'+'</option>')
				$("#slot_list").append('<option class="added" style="color:blue;" value = "10:20 am-10:40 am">'+'10:20 am-10:40 am (Available)'+'</option>')
				$("#slot_list").append('<option class="added" style="color:blue;" value = "10:40 am-11:00 am">'+'10:40 am-11:00 am (Available)'+'</option>')
				$("#slot_list").append('<option class="added" style="color:blue;" value = "11:10 am-11:30 am">'+'11:10 am-11:30 am (Available)'+'</option>')
				$("#slot_list").append('<option class="added" style="color:blue;" value = "11:30 am-11:50 am">'+'11:30 am-11:50 am (Available)'+'</option>')
				$("#slot_list").append('<option class="added" style="color:blue;" value = "12:00 pm-12:20 pm">'+'12:00 pm-12:20 pm (Available)'+'</option>')
				$("#slot_list").append('<option class="added" style="color:blue;" value = "12:20 pm-12:40 pm">'+'12:20 pm-12:40 pm (Available)'+'</option>')
				$("#slot_list").append('<option class="added" style="color:blue;" value = "12:40 pm-01:00 pm">'+'12:40 pm-01:00 pm (Available)'+'</option>')
			}
				
		  }
	   });

	  });
   });
 
 </script>	
	
</head>

<body>

	<?php require("nav_bar_uc.php"); ?>
	
	<center>
		<div class="form">
			<center>
				<div class="register" style="font-size:32;">Appointment Details</div>
				<div class="form_box">
					<form class="form-horizontal" role="form" action="" method="post">
					
						<hr>
						<div class="form-group">
							<label class="control-label col-sm-4">Doctor</label>
							<div class="col-sm-8"> 
								<input type="text" class="form-control" value="<?php echo $row_doc['name'];?>" readonly>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-4">Hospital</label>
							<div class="col-sm-8"> 
								<input type="text" class="form-control" value="<?php echo $row_hos['hos_name'].' , '.$row_hos['hos_city']; ?>" readonly>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-4">Specialization</label>
							<div class="col-sm-8"> 
								<input type="text" class="form-control" value="<?php echo $row_doc['specialization'];?>" readonly>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-4">City</label>
							<div class="col-sm-8"> 
								<input type="text" class="form-control" value="<?php echo $row_hos['hos_city'];?>" readonly>
							</div>
						</div>
						<hr>
						<div class="form-group">
							<label class="control-label col-sm-4">Patient Name</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="patient_name" value="<?php echo $name;?>"  placeholder="Enter Patient Name">
								<span><?php echo $nameErr; ?></span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-4">Age</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="patient_age" value="<?php echo $age;?>" placeholder="Enter Age of Patient">
								<span><?php echo $ageErr; ?></span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-4">Gender</label>
							<div class="col-sm-8"> 
								<select name="gender" class="form-control" >
									<?php if(empty($gender)){?>
									<option value="">Select Gender</option> <?php } else { ?>
									<option value="<?php echo $gender;?>"><?php echo "$gender";?></option> <?php } ?>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
								</select>
								<span><?php echo $genderErr; ?></span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-4">Select Date</label>
							<div class="col-sm-8"> 
								<input  type="text" class="form-control" placeholder="DD-MM-YYYY" readonly="readonly" name="date" id="date">
								<span><?php echo $dateErr; ?></span>
							</div>
						</div>

						<div class="form-group">
							<label for="sel1" class="control-label col-sm-4">Select Time Slot</label>
							<div class="col-sm-8">
								<select  class="form-control" id="slot_list" name="time">
									<option value="">Select Time</option>
									
								</select>
								<span><?php echo $timeErr; ?></span>
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