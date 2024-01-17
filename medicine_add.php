<?php
include_once "connection.php";
$p_id = $_GET['p_id'];

if($_SERVER['REQUEST_METHOD'] =="POST")
{
$name = $_POST['m_name'];
$left = $_POST['left_medicine'];
$first = $_POST['first_time'];
$second_time = $_POST['second_time'];
$third = $_POST['third_time'];


if(!empty($name) && !empty($left))
{

$sql = "INSERT into medicine(p_id,m_name,left_medicine,first_time,second_time,third_time) 
values('$p_id','$name','$left','$first','$second_time','$third')";
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
	<title>Medicine</title>
  <link rel="stylesheet" href="medicine_update.css">
</head>
<body>


<div>

<h1>Adding New Medicine</h1>
	<form method="post">
		<label for="title">Medicine Name</label>
		<input type="text" id="title" name="m_name" placeholder="medicine name">

		<label for="title">Total Medicine</label>
		<input type="text" id="title" name="left_medicine" placeholder="total medicine">
    
    <label for="title">Morning Time</label>
		<input type="text" id="title" name="first_time" placeholder="first time">

    <label for="title">Day Time</label>
		<input type="text" id="title" name="second_time" placeholder="second time">

    <label for="title">Night Time</label>
		<input type="text" id="title" name="third_time" placeholder="third time">

		<button type="submit" value="Submit">Add Medicine</button>
	</form>

</div>

</body>
</html>