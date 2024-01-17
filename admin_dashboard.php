<?php
session_start();
include_once "connection.php";

// Check if user is logged in and is an admin
// if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
//   header('location: login.php');
// }

// // Get admin data
 $query = "SELECT * FROM patient";
 $result = mysqli_query($db, $query);
?>


<?php 
    if ($result->num_rows > 0) {
        //echo "<table><tr><th>Patient Name</th><th>Email</th><th>Phone Number</th></tr>";
    
        while($row = $result->fetch_assoc()) {
            //echo "<tr><td>" . $row["p_name"]. "</td><td>" . $row["p_email"]. " " . $row["p_phone"]. "</td>"
            ?>
            <div class="row">
                <div class="col col1"><?php echo $row["p_name"]; ?> </div>
                <div class="col col2"><?php echo $row["p_email"]; ?> </div>
                <div class="col col2"><?php echo $row["p_phone"]; ?> </div>
                <div class="col col2"><a href= "patient_details.php?p_id=<?php echo $row['p_id'];?>"><button>Details</button></a></div>
                <div class="col col2"><a href= "patient_delete.php?p_email=<?php echo $row['p_email'];?>"><button>Delete</button></a></div>
            </div>
            
            
                <!-- <td> <a href= "patient_details.php?p_id=<?php echo $row['p_id'];?>"><button>Details</button></a> </td>
            <td> <a href= "patient_delete.php?p_email=<?php echo $row['p_email'];?>"><button>Delete</button></a> </td>
            </tr> -->
            
            <?php
        }
        //echo "</table>";
    } 
    else {
        echo "0 results";
    }

    ?></h2>
<br>

<a href="add_patient.php"><button>Add Patient</button></a>
<a href="logout.php"><button>Logout</button></a>


<link rel="stylesheet" href="admin_dashboard.css">