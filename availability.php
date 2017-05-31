<?php  
	session_start();
	if(!isset($_SESSION['id']))
	header('Location: login.php'); 
?>
<?php 
	$doc_id= $_GET["d_id"];
	$hos_id= $_GET["h_id"];
?>

<html>
<head>
	<title>Check Availability</title>
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
	
	<script type = "text/javascript" language = "javascript">
	$(document).ready(function() {
		
		$("#check").click(function(event){
			var date = $('#date').val();
			var passedData = 'date=' + date + '&d_id=' + <?php echo $doc_id;?> + '&h_id=' + <?php echo $hos_id;?> ;
			
			$.ajax( {
			type: "POST",
			url:'load_availability.php',
			data:passedData,
			cache: false,
			success:function(data) {
			$('#data').html(data);
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
			<div class="register" style="font-size:32;">Check Availability</div>
			<div class="form_box">
				<form class="form-horizontal" role="form" method="post">
					
					<div class="form-group">
						<label class="control-label col-sm-4">Select Date</label>
						<div class="col-sm-8"> 
							<input  type="text" class="form-control" placeholder="DD-MM-YYYY" readonly="readonly" name="date" id="date">
						</div>
					</div>
						
					<div class="form-group"> 
						<div class="col-sm-offset-1 col-sm-10">
							<input type = "button" class="btn btn-primary" id = "check" value = "Check" />
						</div>
					</div>
						
				</form>
			</div>
		</div>
		
		<div id = "data" class="form">
			
		</div>
	
	</center>
</body>
</html>