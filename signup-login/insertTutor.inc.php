<?php
include ('db_conn.php'); //db connection

$tutorial_name2 = $_POST['tutorial_name1']; // Fetching Values from URL
$tutorial_unit2 = $_POST['tutorial_unit1'];
$tutorial_tutor2 = $_POST['tutorial_tutor1'];
$tutorial_size2 = $_POST['tutorial_size1'];
$tutorial_day2 = $_POST['tutorial_day1'];
$tutorial_time2 = $_POST['tutorial_time1'];

$query = "INSERT INTO tutorials(tutorial_name, tutorial_unit, tutorial_tutor, tutorial_size, tutorial_day, tutorial_time) VALUES ('$tutorial_name2','$tutorial_unit2', '$tutorial_tutor2', '$tutorial_size2', '$tutorial_day2', '$tutorial_time2')"; //Insert query

if(mysqli_query($conn, $query)){ //checking if the query statment is alright or not
    echo "Data Submitted succesfully";
}
mysqli_close($conn); // Connection Closed.
?>





