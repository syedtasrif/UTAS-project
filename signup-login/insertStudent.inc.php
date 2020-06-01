<?php
include ('db_conn.php'); //db connection

$unitId2= $_POST['unitId1'];                            
$userId2= $_POST['userId1'];


$query="INSERT INTO student_unit(student_id, student_unit_id) VALUES('$userId2', '$unitId2')"; //insert query

if(mysqli_query($conn, $query)){
    echo "Data Submitted succesfully"; //alert message
} else echo "Submittion error" . mysqli_error($conn);
mysqli_close($conn); // Connection Closed.

?>