<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $databasename = "micro_project";
    $db = mysqli_connect($servername,$username,$password,$databasename);
    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
      }
?>