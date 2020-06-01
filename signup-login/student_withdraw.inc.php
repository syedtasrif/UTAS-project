<?php
include ('db_conn.php'); //db connection
session_start();
$student_id1 = $_SESSION['loggedin_id']; // Fetching Values from URL
$unit_id1 = $_POST['unit_id'];

$select_qry = "SELECT * FROM student_unit WHERE student_unit_id=$unit_id1 AND student_id=$student_id1 AND student_tutorial_id != 0";
$result_slt = mysqli_query($conn, $select_qry);
//echo mysqli_error($conn);
if(mysqli_num_rows($result_slt) > 0) { 
    //check if the student also enrolled in the tutorial for the unit, if both he/she will be withdrawn from tutorial once withdrawn from a unit and the tutorial class size will be increased by 1
    $std_unit = mysqli_fetch_assoc($result_slt);
    $dec_qry = "UPDATE tutorials SET tutorial_enrolled = tutorial_enrolled - 1 WHERE tutorial_id = " . $std_unit['student_tutorial_id'];
    if(mysqli_query($conn, $dec_qry)) {
        echo "Withdraw from Tutorial. "; //alert message
    } else {
        echo mysqli_error($conn);
    }
}

$query="DELETE FROM student_unit WHERE student_unit_id=$unit_id1 AND student_id=$student_id1"; //Delete query

if(mysqli_query($conn, $query)){
    echo "You have Withdrawn from the Unit succesfully";
}

mysqli_close($conn); // Connection Closed.
?>





