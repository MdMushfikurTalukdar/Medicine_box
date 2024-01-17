<?php
include_once "connection.php";

if($_SERVER['REQUEST_METHOD'] =="POST")
{
$name = $_POST['p_name'];
$number = $_POST['p_phone'];
$mail = $_POST['p_email'];
$password = $_POST['p_password'];


if(!empty($name) && !empty($number) 
 && !empty($mail) && !empty($password))
{

$sql = "INSERT into patient(p_name,p_phone,p_email,p_password) 
values('$name','$number','$mail','$password')";
$result = mysqli_query($db,$sql);
if($result){
  header("location: admin_dashboard.php");
  die;
}
else{
  echo '<script >alert("Warning!! Unable to Update Information")</script>';
}
}

else
{
  echo '<script >alert("Warning!! Unable to Update Information")</script>';
}
}
?>


<!doctype html>
<html>
<head>
	<title>Adding patient</title>
  <link rel="stylesheet" href="add_patient.css">
</head>
<body>


<h1>Add New Patient</h1>
	<form method="post">
		<label for="name">Name :</label>
		<input type="text" id="name" name="p_name" placeholder="Patient Name" required>

		<label for="email">Email :</label>
		<input type="email" id="email" name="p_email" placeholder="Enter email" required>

    <label for="name">Phone Number :</label>
		<input type="text" id="name" name="p_phone" placeholder="Phone Number" required>

		<label for="email">Password :</label>
		<input type="text" id="name" name="p_password" placeholder="password" required>

		<button id="button" type="submit" value="Submit">Add Patient</button>
	</form>


</body>
</html>