
<?php 
	$conn = new mysqli("localhost", "root" , "", "has");
	
	$date=$_POST["date"];
	$doc_id=$_POST["d_id"];
	
	$sql_app=" SELECT date FROM appointments WHERE date = '$date' AND doc_id = '$doc_id' ";
	$result_app = $conn->query($sql_app);
	$count = mysqli_num_rows($result_app);
	if($count>0)
		echo "1";
	else
		echo "0";
?>