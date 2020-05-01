<?php
include ('db_conn.php'); //db connection

$input=filter_input_array(INPUT_POST);

$unit_code=mysqli_real_escape_string($conn, $input["unit_code"]);
$unit_name=mysqli_real_escape_string($conn, $input["unit_name"]);
$lecturer=mysqli_real_escape_string($conn, $input["lecturer"]);
$semester=mysqli_real_escape_string($conn, $input["semester"]);

if($input["action"]==='edit'){
    $query= "
        UPDATE units
        SET unit_code='".$unit_code."',
        unit_name='".$unit_name."',
        lecturer='".$lecturer."',
        semester='".$semester."'
        WHERE id= '".$input['id']."'
    ";
    }
if($input["action"]==='delete'){
    $query="DELETE FROM units WHERE id='".$input["id"]."';
    mysqli_query($conn, $query);
}
echo json_encode($input);
?>