<?php  
	session_start();
	if(!isset($_SESSION['admin']))
	header('Location: admin_login.php'); 
?>

<?php

	$con = new mysqli("localhost", "root" , "", "has");
	$data = array();
	$sql = ("SELECT DISTINCT hos_city from hospital");
	$result = mysqli_query($con,$sql);
	while($row = mysqli_fetch_array($result))
	{
	   $city = $row['hos_city'];
	   $hos = array();
	   $sql2 =("SELECT DISTINCT hos_name from hospital WHERE hos_city = '$city'");
	   $result2 = mysqli_query($con,$sql2);
	   while($row2 = mysqli_fetch_array($result2))
	   {
		array_push($hos, $row2['hos_name']);
	   }
	   $data[$city] = $hos;
	}
	$con->close();
?>

<html>

	<head>
		<title>Remove Doctor</title>
		<link rel="stylesheet" href="bootstrap/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="common.css" >
		<script src="bootstrap/jquery-1.11.3.min.js"></script>
		<script src="bootstrap/bootstrap.min.js"></script>
	</head>

<script>

	$(document).ready(function(){

		$("#city").change(function(){
	  var data = '<?php echo json_encode($data);?>';
	  var city = $(this).val();
	  var arr = JSON.parse(data);
	  $(".added").remove();
	   if(city !=  " ")
	   {
		var hos = arr[city];
		for(var i=0;i<hos.length;i++)
		{
			$("#hospital").append('<option class="added" value = '+JSON.stringify(hos[i]) +'>'+hos[i]+'</option>')
		}
	   }

	});
	});

</script>

<script type = "text/javascript" language = "javascript">
	$(document).ready(function() {
		
		$("#remove").click(function(event){
			var city = $('#city').val();
			var hospital = $("#hospital").val();
			var passedData = 'city=' + city + "&hospital=" + hospital + '&id=2';  //to decide button
			
			$.ajax( {
			type: "POST",
			url:'load_data.php',
			data:passedData,
			cache: false,
			success:function(data) {
			$('#table').html(data);
			}
			});
	});
 });
</script>


<body>
	
	<?php require("nav_bar_clc.php"); ?>

	<center>
		<div class="form">
			<div class="register">
				Search Doctor
			</div>

			<div class="form_box">
				<form class="form-horizontal" role="form" action="" method="post">
					
					<div class="form-group">
					
						<label class="control-label col-sm-4">Select City:</label>
						<div class="col-sm-8">  
							<select class="form-control" id="city">
								<option value=" ">SELECT City</option>
								<?php
									foreach ($data as $key => $value) 
									{
										echo "<option value ='".$key."'>$key</option>";
									}
								?>
							</select>
						</div>

						<label for="sel1" class="control-label col-sm-4">Select Hospital:</label>
						<div class="col-sm-8">
							<select  class="form-control" id="hospital">
								<option>SELECT Hospital</option>
							</select>
						</div>
						
					</div>
					
					<div class="form-group"> 
						<div class="col-sm-offset-1 col-sm-10">
							<input type = "button" class="btn btn-primary" id = "remove" value = "Search" />
						</div>
					</div>
				</form>
			</div>
		</div>
		
		<div id = "table" class="form">
        
		</div>
		
	</center>
</body>
</html>