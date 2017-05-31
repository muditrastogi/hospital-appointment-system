<?php 
	$conn = new mysqli("localhost", "root" , "", "has");
	
	$date= $_POST["date"];
	$doc_id= $_POST["d_id"];
	$hos_id= $_POST["h_id"];
	$sql = " SELECT slot_no from appointments WHERE doc_id = '$doc_id' AND date = '$date' ";
?>

<html>
	
	<head>
		<script src="bootstrap/bootstrap.min.js"></script>
		<script src="bootstrap/jquery-1.11.3.min.js"></script>
		<script src="bootstrap/bootstrap.min.js"></script>
	</head>
	
<body>
	<table>
		<tr>
			<td>
				<?php 
					$flag=0;
					$result = $conn->query($sql);
					while($row=mysqli_fetch_array($result))
					{ 
						if( $row['slot_no'] == 1 )
						{	?>
							<button type="button" class="btn btn-warning disabled" style="width:200; margin-right:40; margin-bottom:15;">Booked<br>10:00 am-10:20 am</button>
							<?php $flag=1; break;
						}
					}
					if($flag == 0){ ?>
						<a href="book_appointment.php?d_id=<?php echo $doc_id;?>&&h_id=<?php echo $hos_id;?>"><button type="button" class="btn btn-primary" style="width:200; margin-right:40; margin-bottom:15;">Available<br>10:00 am-10:20 am</button></a>
				<?php } ?>
			</td>
				
			<td>
				<?php 
					$flag=0;
					$result = $conn->query($sql);
					while($row=mysqli_fetch_array($result))
					{ 
						if( $row['slot_no'] == 2 )
						{	?>
							<button type="button" class="btn btn-warning disabled" style="width:200; margin-bottom:15;">Booked<br>10:20 am-10:40 am</button>
							<?php $flag=1; break;
						}
					}
					if($flag == 0){ ?>
						<a href="book_appointment.php?d_id=<?php echo $doc_id;?>&&h_id=<?php echo $hos_id;?>"><button type="button" class="btn btn-primary" style="width:200; margin-bottom:15;">Available<br>10:20 am-10:40 am</button></a>
				<?php } ?>
			</td>
		</tr>
			
		<tr>
			<td>
				<?php 
					$flag=0;
					$result = $conn->query($sql);
					while($row=mysqli_fetch_array($result))
					{ 
						if( $row['slot_no'] == 3 )
						{	?>
							<button type="button" class="btn btn-warning disabled" style="width:200; margin-right:40; margin-bottom:15;">Booked<br>10:40 am-11:00 am</button>
							<?php $flag=1; break;
						}
					}
					if($flag == 0){ ?>
						<a href="book_appointment.php?d_id=<?php echo $doc_id;?>&&h_id=<?php echo $hos_id;?>"><button type="button" class="btn btn-primary" style="width:200; margin-right:40; margin-bottom:15;">Available<br>10:40 am-11:00 am</button></a>
				<?php } ?>
			</td>
				
			<td>
				<?php 
					$flag=0;
					$result = $conn->query($sql);
					while($row=mysqli_fetch_array($result))
					{ 
						if( $row['slot_no'] == 4 )
						{	?>
							<button type="button" class="btn btn-warning disabled" style="width:200; margin-bottom:15;">Booked<br>11:10 am-11:30 am</button>
							<?php $flag=1; break;
						}
					}
					if($flag == 0){ ?>
						<a href="book_appointment.php?d_id=<?php echo $doc_id;?>&&h_id=<?php echo $hos_id;?>"><button type="button" class="btn btn-primary" style="width:200; margin-bottom:15;">Available<br>11:10 am-11:30 am</button></a>
				<?php } ?>
			</td>
		</tr>
		
		<tr>
			<td>
				<?php 
					$flag=0;
					$result = $conn->query($sql);
					while($row=mysqli_fetch_array($result))
					{ 
						if( $row['slot_no'] == 5 )
						{	?>
							<button type="button" class="btn btn-warning disabled" style="width:200; margin-right:40; margin-bottom:15;">Booked<br>11:30 am-11:50 am</button>
							<?php $flag=1; break;
						}
					}
					if($flag == 0){ ?>
						<a href="book_appointment.php?d_id=<?php echo $doc_id;?>&&h_id=<?php echo $hos_id;?>"><button type="button" class="btn btn-primary" style="width:200; margin-right:40; margin-bottom:15;">Available<br>11:30 am-11:50 am</button></a>
				<?php } ?>
			</td>
				
			<td>
				<?php 
					$flag=0;
					$result = $conn->query($sql);
					while($row=mysqli_fetch_array($result))
					{ 
						if( $row['slot_no'] == 6 )
						{	?>
							<button type="button" class="btn btn-warning disabled" style="width:200; margin-bottom:15;">Booked<br>12:00 pm-12:20 pm</button>
							<?php $flag=1; break;
						}
					}
					if($flag == 0){ ?>
						<a href="book_appointment.php?d_id=<?php echo $doc_id;?>&&h_id=<?php echo $hos_id;?>"><button type="button" class="btn btn-primary" style="width:200; margin-bottom:15;">Available<br>12:00 pm-12:20 pm</button></a>
				<?php } ?>
			</td>
		</tr>
			
		<tr>
			<td>
				<?php 
					$flag=0;
					$result = $conn->query($sql);
					while($row=mysqli_fetch_array($result))
					{ 
						if( $row['slot_no'] == 7 )
						{	?>
							<button type="button" class="btn btn-warning disabled" style="width:200; margin-right:40; margin-bottom:15;">Booked<br>12:20 pm-12:40 pm</button>
							<?php $flag=1; break;
						}
					}
					if($flag == 0){ ?>
						<a href="book_appointment.php?d_id=<?php echo $doc_id;?>&&h_id=<?php echo $hos_id;?>"><button type="button" class="btn btn-primary" style="width:200; margin-right:40; margin-bottom:15;">Available<br>12:20 pm-12:40 pm</button></a>
				<?php } ?>
			</td>
				
			<td>
				<?php 
					$flag=0;
					$result = $conn->query($sql);
					while($row=mysqli_fetch_array($result))
					{ 
						if( $row['slot_no'] == 8 )
						{	?>
							<button type="button" class="btn btn-warning disabled" style="width:200; margin-bottom:15;">Booked<br>12:40 pm-01:00 pm</button>
							<?php $flag=1; break;
						}
					}
					if($flag == 0){ ?>
						<a href="book_appointment.php?d_id=<?php echo $doc_id;?>&&h_id=<?php echo $hos_id;?>"><button type="button" class="btn btn-primary" style="width:200; margin-bottom:15;">Available<br>12:40 pm-01:00 pm</button></a>
				<?php } ?>
			</td>
		</tr>
		
	</table>
</body>

</html>
