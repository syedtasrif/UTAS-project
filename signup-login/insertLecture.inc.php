<?php
include ('db_conn.php'); //db connection
$inputCode2=$_POST['inputCode1']; // Fetching Values from URL
$inputLec2=$_POST['inputLec1'];
$inputTime2= $_POST['inputTime1'];
$inputLecDay2= $_POST['inputLecDay1'];

$query = "UPDATE  units SET unit_lecturer = '".$inputLec2."', lecture_day = '".$inputLecDay2."', lecture_time = '".$inputTime2."' WHERE unit_id = " .$inputCode2; //Insert query
if(mysqli_query($conn, $query)){
    echo "Data Submitted succesfully";
}
mysqli_close($conn); // Connection Closed.
?>