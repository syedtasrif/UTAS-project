<?php
$weekday['Monday'] = date( 'Y-m-d', strtotime( 'monday' ) );
$weekday['Tuesday'] = date( 'Y-m-d', strtotime( 'tuesday' ) );
$weekday['Wednesday'] = date( 'Y-m-d', strtotime( 'wednesday' ) );
$weekday['Thursday'] = date( 'Y-m-d', strtotime( 'thursday' ) );
$weekday['Friday'] = date( 'Y-m-d', strtotime( 'friday' ) );
$weekday['Saturday'] = date( 'Y-m-d', strtotime( 'saturday' ) );
$weekday['Sunday'] = date( 'Y-m-d', strtotime( 'sunday' ) );

$dateofdays = array();
foreach($weekday as $key => $value) {
    $dateofdays[$key][0] = $value; //date("Y-m-d", strtotime($value . "+7 days"));

    for($i=1; $i<=107;$i++) {
        $dateofdays[$key][$i] = date("Y-m-d", strtotime($value . "+7 days"));
        $value = $dateofdays[$key][$i];
    }

}
//echo "<PRE>";
//var_dump($dateofdays);
//die;
?>