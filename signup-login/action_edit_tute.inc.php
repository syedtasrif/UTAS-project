<?php
include ('db_conn.php'); //db connection

$input=filter_input_array(INPUT_POST);

$tutorial_name=mysqli_real_escape_string($conn, $input["tutorial_name"]);
$tutorial_tutor=mysqli_real_escape_string($conn, $input["tutorial_tutor"]);
$tutorial_size=mysqli_real_escape_string($conn, $input["tutorial_size"]);
$tutorial_day=mysqli_real_escape_string($conn, $input["tutorial_day"]);
$tutorial_time=mysqli_real_escape_string($conn, $input["tutorial_time"]);

if($input["action"]==='edit'){
    $query= "
        UPDATE tutorials
        SET tutorial_tutor='".$tutorial_tutor."',
        tutorial_name='".$tutorial_name."',
        tutorial_size='".$tutorial_size."',
        tutorial_day='".$tutorial_day."',
        tutorial_time='".$tutorial_time."'
        WHERE tutorial_id= ".$input['tutorial_id'];
}
/*if($input["action"]==='delete'){
    $query="DELETE FROM units WHERE unit_id=".$input["unit_id"];

}*/
mysqli_query($conn, $query);
echo mysqli_error($conn);

echo json_encode($input);

?>