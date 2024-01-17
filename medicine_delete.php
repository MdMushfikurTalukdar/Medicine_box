<?php
	$email = $_GET["m_id"];

	include_once "connection.php";
	
	$sql = "DELETE FROM medicine WHERE m_id='$email'";
	
	$result = mysqli_query($db,$sql);
	
	if($result){
		
		header("Location: admin_dashboard.php");
	}
	else{
		echo '<script >alert("Warning!! This is not able to delete")</script>';
	}
?>