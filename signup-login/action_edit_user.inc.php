<?php
include ('db_conn.php'); //db connection

$input=filter_input_array(INPUT_POST);

$user_name=mysqli_real_escape_string($conn, $input["user_name"]); //escape special characters
$user_email=mysqli_real_escape_string($conn, $input["user_email"]);
$user_expertise=mysqli_real_escape_string($conn, $input["user_expertise"]);
$user_qualification=mysqli_real_escape_string($conn, $input["user_qualification"]);
$user_unavailability=mysqli_real_escape_string($conn, $input["user_unavailability"]);

if($input["action"]==='edit'){
    $query= "
        UPDATE users
        SET user_name='".$user_name."',
        user_email='".$user_email."',
        user_expertise='".$user_expertise."',
        user_qualification='".$user_qualification."',
        user_unavailability='".$user_unavailability."'
        WHERE user_id= ".$input['user_id'];
}

mysqli_query($conn, $query);
echo mysqli_error($conn); //error statement will print if any in connection

echo json_encode($input); //json use for jquery edit table plugin

?>