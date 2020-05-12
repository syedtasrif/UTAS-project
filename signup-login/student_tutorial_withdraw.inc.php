<?php
include ('db_conn.php'); //db connection
session_start();
$student_id1 = $_SESSION['loggedin_id']; //$_POST['student_id']; // Fetching Values from URL
$tutorial_id = $_GET['tutorial_id'];
$unit_id = $_GET['unit_id'];

$query="UPDATE student_unit SET student_tutorial_id = " . 0 . " WHERE student_id = ". $student_id1 ." AND student_unit_id = ". $unit_id .";";

if(mysqli_query($conn, $query)){
    mysqli_close($conn); // Connection Closed.

    header("Location: tuteAllocate.php?msg=tutorialdeletionsuccess");
    exit();
}
?>


