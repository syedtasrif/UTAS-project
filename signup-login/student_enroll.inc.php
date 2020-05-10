<?php
include ('db_conn.php'); //db connection

$student_id1 = $_POST['student_id']; // Fetching Values from URL
$unit_id1 = $_POST['unit_id'];


$query = "INSERT INTO student_unit(student_id, student_unit_id) VALUES ('$student_id1','$unit_id1')"; //Insert query

if(mysqli_query($conn, $query)){
    echo "You Enrolled succesfully";
}
mysqli_close($conn); // Connection Closed.
?>





