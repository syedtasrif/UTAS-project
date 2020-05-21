<?php
include ('db_conn.php'); //db connection
$user_name2=$_POST['user_name1']; // Fetching Values from URL
$user_role2= !empty($_POST['user_role1']) ? $_POST['user_role1'] : "staff";
$user_role_allocated= $_POST['user_role_allocated'];

$query = "UPDATE users SET user_role = '".$user_role2."', user_role_allocated = '".$user_role_allocated."' WHERE user_id = " . $user_name2; //Insert query

if($user_role2 == "Unit Coordinator" && $user_role_allocated == "Tutor") {
    echo "cannot UC and Tutor";
} else if(mysqli_query($conn, $query)){
    echo "Data Submitted succesfully";
} else echo "Submittion error" . mysqli_error($conn);
mysqli_close($conn); // Connection Closed.
?>




