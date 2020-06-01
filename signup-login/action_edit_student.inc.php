<?php
include ('db_conn.php'); //db connection

$input=filter_input_array(INPUT_POST);

$user_name=mysqli_real_escape_string($conn, $input["user_name"]); //escape special characters
$user_email=mysqli_real_escape_string($conn, $input["user_email"]);

if($input["action"]==='edit'){ //edit button in table action will update the table according to user input
    $query= "
        UPDATE users
        SET user_name='".$user_name."',
        user_email='".$user_email."'
        WHERE user_id= ".$input['user_id'];
}

mysqli_query($conn, $query);
echo mysqli_error($conn);

echo json_encode($input);

?>