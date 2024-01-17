<?php
	$email = $_GET["p_email"];

	include_once "connection.php";
	
	$sql = "DELETE FROM patient WHERE p_email='$email'";
	
	$result = mysqli_query($db,$sql);
	
	if($result){
		
		header("Location: admin_dashboard.php");
	}
	else{
		echo '<script >alert("Warning!! This is not able to delete")</script>';
	}
?>