<?php
session_start();
include_once "connection.php";

if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  //Check user table
  $query = "SELECT * FROM patient WHERE p_email='$username' AND p_password='$password'";
  $results = mysqli_query($db, $query);
  if (mysqli_num_rows($results) == 1) {
    $_SESSION['username'] = $username;
    header('location: user_dashboard.php');
  }

  // Check admin table
  
    $query = "SELECT * FROM doctor WHERE d_email='$username' AND d_password='$password'";
    $results = mysqli_query($db, $query);
    if (mysqli_num_rows($results) == 1) {
      $_SESSION['username'] = $username;
      header('location: admin_dashboard.php');
  }
  
  
}
?>
