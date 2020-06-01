<?php
include ('db_conn.php'); //db connection
session_start();
$student_id1 = $_SESSION['loggedin_id']; //$_POST['student_id']; // Fetching Values from URL
$tutorial_id = $_GET['tutorial_id'];
$unit_id = $_GET['unit_id'];

$query = "UPDATE student_unit SET student_tutorial_id = " . $tutorial_id . " WHERE student_id = ". $student_id1 ." AND student_unit_id = ". $unit_id .";"; //Insert query

if(mysqli_query($conn, $query)){
    $query_2 = "UPDATE tutorials SET tutorial_enrolled = tutorial_enrolled + 1 WHERE tutorial_id = " . $tutorial_id; //tutorial enrolled is used limit the number of students can enroll in a tutorial class size defined by UC, lecturer or even DC
    
    if(mysqli_query($conn, $query_2)) {
        mysqli_close($conn); // Connection Closed.

        header("Location: tuteAllocate.php?msg=success"); //location header for page refresh
    } else {
        header("Location: tuteAllocate.php?msg=errro_tutorial_tbl");
    }
    //    echo "You Enrolled succesfully";
} else {
    header("Location: tuteAllocate.php?msg=student_uni_tbl");
}
exit();

?>





