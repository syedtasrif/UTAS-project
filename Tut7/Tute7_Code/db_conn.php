<?php
//connect to mysql

$servername="localhost";
$dBUsername="root";
$dBPassword="";
$dBName="assignment";

$conn=mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if(!$conn){
    die("Connection failed: ".mysqli_connect_error());
}