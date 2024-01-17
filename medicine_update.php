<?php

include_once "connection.php";

$m_id = $_GET['m_id']; 

if($_SERVER['REQUEST_METHOD'] =="POST")
{
    $m_name = $_POST['m_name'];
    $left_medicine = $_POST['left_medicine'];
    $first = $_POST['first_time'];
    $second = $_POST['second_time'];
    $third = $_POST['third_time'];

if(!empty($m_name))
{
  
  $quantity3 = "UPDATE medicine SET m_name='$m_name',left_medicine='$left_medicine',first_time='$first', second_time='$second', third_time='$third' where m_id = '$m_id'";
  $result = mysqli_query($db,$quantity3);

if($result){
header("Location:admin_dashboard.php");
die;
}
}
else
{
echo "Please enter some valid information";
}
}

?>


<!doctype html>
<html>
<head>
  <link rel="stylesheet" href="medicine_update.css">
	<title>Modify</title>
</head>
<body>


<h1>Update Document</h1>
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

		<button type="submit" value="Finish">Update Document</button>
	</form>

</body>
</html>