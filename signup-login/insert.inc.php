<?php
include ('db_conn.php'); //db connection
$inputCode2=$_POST['inputCode1']; // Fetching Values from URL
$inputName2=$_POST['inputName1'];
$inputLec2=$_POST['inputLec1'];
$inputSem2=$_POST['inputSem1'];
$inputUC2= $_POST['inputUC1'];
$inputTime2= $_POST['inputTime1'];
$inputCamp2= $_POST['inputCamp1'];
$inputLecDay2= $_POST['inputLecDay1'];
$query = "INSERT INTO units(unit_code, unit_name, unit_lecturer, unit_semester, unit_coordinator, lecture_time, unit_campus, lecture_day) VALUES ('$inputCode2','$inputName2','$inputLec2', '$inputSem2', '$inputUC2', '$inputTime2', '$inputCamp2', '$inputLecDay2')"; //Insert query
if(mysqli_query($conn, $query)){
    echo "Data Submitted succesfully";
}
mysqli_close($conn); // Connection Closed.
?>