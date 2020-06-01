<?php
$weekday['Monday'] = date( 'Y-m-d', strtotime( 'monday' ) ); // strtotime () Parse about any English textual datetime description into a Unix timestamp
$weekday['Tuesday'] = date( 'Y-m-d', strtotime( 'tuesday' ) );
$weekday['Wednesday'] = date( 'Y-m-d', strtotime( 'wednesday' ) );
$weekday['Thursday'] = date( 'Y-m-d', strtotime( 'thursday' ) );
$weekday['Friday'] = date( 'Y-m-d', strtotime( 'friday' ) );
$weekday['Saturday'] = date( 'Y-m-d', strtotime( 'saturday' ) );
$weekday['Sunday'] = date( 'Y-m-d', strtotime( 'sunday' ) );

$dateofdays = array();
foreach($weekday as $key => $value) {
    $dateofdays[$key][0] = $value; 

    for($i=1; $i<=12;$i++) {
        $dateofdays[$key][$i] = date("Y-m-d", strtotime($value . "+7 days")); //13 weeks time schedule +7 days increment
        $value = $dateofdays[$key][$i];
    }

}