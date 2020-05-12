<?php
include ('db_conn.php'); //db connection
session_start();
$student_id1 = $_SESSION['loggedin_id']; // Fetching Values from URL
$unit_id1 = $_POST['unit_id'];


$query="DELETE FROM student_unit WHERE student_unit_id=$unit_id1 AND student_id=$student_id1"; //Delete query

if(mysqli_query($conn, $query)){
    echo "You have Withdrawn from the Unit succesfully";
}

mysqli_close($conn); // Connection Closed.
?>





