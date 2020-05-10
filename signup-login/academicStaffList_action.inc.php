<?php
include ('db_conn.php'); //db connection

$input=filter_input_array(INPUT_POST);

$user_name=mysqli_real_escape_string($conn, $input["user_name"]);
$user_qualification=mysqli_real_escape_string($conn, $input["user_qualification"]);
$user_expertise=mysqli_real_escape_string($conn, $input["user_expertise"]);
$user_role_allocated=mysqli_real_escape_string($conn, $input["user_role_allocated"]);
$user_email=mysqli_real_escape_string($conn, $input["user_email"]);
$user_unavailability=mysqli_real_escape_string($conn, $input["user_unavailability"]);
if($input["action"]==='edit'){
$query= "
UPDATE users
SET user_name='".$user_name."',
user_qualification='".$user_qualification."',
user_expertise='".$user_expertise."',
user_role_allocated='".$user_role_allocated."',
user_unavailability='".$user_unavailability."',
user_email='".$user_email."'
WHERE user_id= ".$input['user_id'];
}
if($input["action"]==='delete'){
$query="DELETE FROM users WHERE user_id=".$input["user_id"];

}
mysqli_query($conn, $query);
echo mysqli_error($conn);

echo json_encode($input);

?>