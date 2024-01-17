<?php
session_start();
include_once "connection.php";

if (!isset($_SESSION['username'])) {
    header('location: login.php');
  }
  
  // Get user data from database
  $query = "SELECT * FROM patient WHERE p_email='{$_SESSION['username']}'";
  $result = mysqli_query($db, $query);
  $user = mysqli_fetch_assoc($result);
  
  // Format date
  $created = date("F j, Y, g:i a", strtotime($user['p_id']));
  
  // Display user data
  echo "<h1>Welcome, {$user['p_name']}!</h1>";
  echo "<p>Email: {$user['p_email']}</p>";
  echo "<p>Joined on: {$created}</p>";

  echo "<h2> Here is your Medicine list and time</h2>";
  $query1 = "SELECT * FROM medicine WHERE p_id='{$user['p_id']}'";
  $result1 = mysqli_query($db, $query1);

  if ($result1->num_rows > 0) {
    //echo "<table><tr><th>Medicine Name</th> <th>Morning</th> <th>Noon</th> <th>Night</th> <th>Total Medicine</th></tr>";
?>
            <div class="row1">
                <div class="col col1"><?php echo "Medicine Name"; ?> </div>
                <div class="col col2"><?php echo "Morning"; ?> </div>
                <div class="col col2"><?php echo "Noon"; ?> </div>
                <div class="col col2"><?php echo "Night"; ?> </div>
                <div class="col col2"><?php echo "Left Medicine"; ?> </div>
            </div>

<?php
    while($row = $result1->fetch_assoc()) {
        //echo "<tr><td>" . $row["m_name"]. "</td><td>" . $row["first_time"]. "</td><td>" . $row["second_time"]. 
        //$row["third_time"]. "</td><td>" . $row["left_medicine"]."</td>"
        ?>

              <div class="row">
                <div class="col col1"><?php echo $row["m_name"]; ?> </div>
                <div class="col col2"><?php echo $row["first_time"]; ?> </div>
                <div class="col col2"><?php echo $row["second_time"]; ?> </div>
                <div class="col col2"><?php echo $row["third_time"]; ?> </div>
                <div class="col col2"><?php echo $row["left_medicine"]; ?> </div>
                
              </div>

        <!-- </tr> -->
        
        <?php
    }
    //echo "</table>";
    ?>
    

    <?php
} 
else {
    echo "0 results";
    ?>
<?php
}
  ?>
<a href="logout.php"><button>Logout</button></a>

<link rel="stylesheet" href="admin_dashboard.css">