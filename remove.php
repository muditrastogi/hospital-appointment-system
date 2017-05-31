<?php  
	session_start();
	if(!isset($_SESSION['admin']))
	header('Location: admin_login.php'); 
?>

<?php 
	$id= $_POST["id"];
	if($id==0)
	{
		$conn = new mysqli("localhost", "root" , "", "has");
	
		$d_id= $_POST["d_id"];
		$sql = "DELETE FROM doctor WHERE doc_id='$d_id' ";
		$result = $conn->query($sql);
	}
?>
<?php 
	$id= $_POST["id"];
	if($id==1)
	{
		$conn = new mysqli("localhost", "root" , "", "has");
		
		$city= $_POST["city"];
		$hospital= $_POST["hospital"];
		
		$sql2=" SELECT hos_id from hospital WHERE hos_city = '$city' AND hos_name = '$hospital' ";
		$result2 = $conn->query($sql2);
		$row=mysqli_fetch_array($result2);
		$h_id=$row['hos_id'];
		
		$sql = " DELETE from hospital WHERE hos_city = '$city' AND hos_name = '$hospital' ";
		$result= $conn->query($sql);
		
		$sql3= "DELETE FROM doctor WHERE hos_id='$h_id' ";
		$result3 = $conn->query($sql3);
	}
?>
