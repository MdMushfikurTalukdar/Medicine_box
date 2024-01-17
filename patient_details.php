<?php
include_once "connection.php";
$id = $_GET["p_id"];

$sql ="SELECT * FROM medicine where p_id='$id'";
$result = mysqli_query($db,$sql);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_dashboard.css">
    <title>Medicine</title>
</head>

<body>
    
<div class="body"></div>

		<div>
        <h2>
            <?php 
                if ($result->num_rows > 0) {
                    //echo "<table><tr><th>Phone Number</th><th>Name</th><th>Country</th></tr>";
    
                    while($row = $result->fetch_assoc()) {
                        //echo "<tr><td>" . $row["m_name"]. "</td><td>" . $row["left_medicine"]. "</td><td>" . $row["first_time"]. "</td><td>" . $row["second_time"].
                        //"</td><td>" . $row["third_time"]. "</td><td>" . $row["status"]. "</td>"
                        ?>

                    <div class="row">
                        <div class="col col1"><?php echo $row["m_name"]; ?> </div>
                        <div class="col col2"><?php echo $row["left_medicine"]; ?> </div>
                        <div class="col col2"><?php echo $row["first_time"]; ?> </div>
                        <div class="col col2"><?php echo $row["second_time"]; ?> </div>
                        <div class="col col2"><?php echo $row["third_time"]; ?> </div>
                        <div class="col col2"><?php echo $row["status"]; ?> </div>
                        <div class="col col2"><a href= "medicine_update.php?m_id=<?php echo $row['m_id'];?>"><button>Update</button></a></div>
                        <div class="col col2"><a href= "medicine_delete.php?m_id=<?php echo $row['m_id'];?>"><button>Delete</button></a></div>
                    </div>

                        <!-- <td> <a href= "medicine_update.php?m_id=<?php echo $row['m_id'];?>"><button>Update</button></a> </td>
                        <td> <a href= "medicine_delete.php?m_id=<?php echo $row['m_id'];?>"><button>Delete</button></a> </td>
                        </tr> -->

                        <?php
                }
                // echo "</table>";
            } 
            else {
                echo "0 results";
            }

            ?></h2>

    <br>

            <a href="medicine_add.php?p_id=<?php echo $id;?>"><button>Add new medicine</button></a>
            <a href="admin_dashboard.php"><button>Go Back</button></a>
            
        </div>
        




</body>
</html>