<?php
include ('db_conn.php'); //db connection

$input=filter_input_array(INPUT_POST);

$unit_lecturer=mysqli_real_escape_string($conn, $input["unit_lecturer"]);
$lecture_day=mysqli_real_escape_string($conn, $input["lecture_day"]);
$lecture_time=mysqli_real_escape_string($conn, $input["lecture_time"]);

if($input["action"]==='edit'){
    $query= "
        UPDATE units
        SET unit_lecturer='".$unit_lecturer."',
        lecture_day='".$lecture_day."',
        lecture_time='".$lecture_time."'
        WHERE unit_id= ".$input['unit_id'];
}
/*if($input["action"]==='delete'){
    $query="DELETE FROM units WHERE unit_id=".$input["unit_id"];

}*/
mysqli_query($conn, $query);
echo mysqli_error($conn);

echo json_encode($input);

?>