<?php
include ('db_conn.php'); //db connection

$input=filter_input_array(INPUT_POST);

$unit_code=mysqli_real_escape_string($conn, $input["unit_code"]);
$unit_name=mysqli_real_escape_string($conn, $input["unit_name"]);
$unit_semester=mysqli_real_escape_string($conn, $input["unit_semester"]);
$unit_campus=mysqli_real_escape_string($conn, $input["unit_campus"]);
$unit_coordinator=mysqli_real_escape_string($conn, $input["unit_coordinator"]);

if($input["action"]==='edit'){
    $query= "
        UPDATE units
        SET unit_code='".$unit_code."',
        unit_name='".$unit_name."',
        unit_semester='".$unit_semester."',
        unit_coordinator='".$unit_coordinator."',
        unit_campus='".$unit_campus."'
        WHERE unit_id= ".$input['unit_id'];
}
if($input["action"]==='delete'){
    $query="DELETE FROM units WHERE unit_id=".$input["unit_id"];

}
mysqli_query($conn, $query);
echo mysqli_error($conn);

echo json_encode($input);

?>