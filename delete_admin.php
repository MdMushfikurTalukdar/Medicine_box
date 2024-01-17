<?php
session_start();
include_once "connection.php";

// Check if user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
  header('location: login.php');
}

// Check if delete button was pressed
if (isset($_POST['delete_admin'])) {
  $query = "DELETE FROM admins WHERE username='{$_SESSION['username']}'";
  mysqli_query($db, $query);
  header('location: logout.php');
  exit();
}

// // Get form data
// $username = mysqli_real_escape_string($db, $_POST['username']);
// $email = mysqli_real_escape_string($db, $_POST['email']);
// $password = mysqli_real_escape_string($db, $_POST['password']);
// $role = mysqli_real_escape_string($db, $_POST['role']);

// // Update admin data
// $query = "UPDATE admins SET username='$username', email='$email', password='$password', role='$role' WHERE username='{$_SESSION['username']}'";
// mysqli_query($db, $query);

// Redirect to dashboard page
header('location: admin_dashboard.php');
?>
