<?php  
	session_start();
	unset($_SESSION['user']);
	unset($_SESSION['admin']);
	unset($_SESSION['id']);
	header('location:home.php');
?>