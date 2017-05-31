<?php 
	$conn = new mysqli("localhost", "root" , "", "has");
	
	$a_id=$_POST['appid'];

	$sql = "DELETE from appointments WHERE app_id = $a_id";
	if($conn->query($sql))
	{
		echo "1";
	}	
?>

