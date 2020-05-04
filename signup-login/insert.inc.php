<?php
include ('db_conn.php'); //db connection
$inputCode2=$_POST['inputCode1']; // Fetching Values from URL
$inputName2=$_POST['inputName1'];
$inputLec2=$_POST['inputLec1'];
$inputSem2=$_POST['inputSem1'];
$query = "INSERT INTO units(unit_code, unit_name, lecturer, semester) VALUES ('$inputCode2','$inputName2','$inputLec2', '$inputSem2')"; //Insert query
if(mysqli_query($conn, $query)){
    echo "Data Submitted succesfully";
}
mysqli_close($conn); // Connection Closed.
?>