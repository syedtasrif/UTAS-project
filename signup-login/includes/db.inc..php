<?php
//connect to mysql

$servername="localhost";
$dBUsername="smat";
$dBPassword="555867";
$dBName="smat";

$conn=mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if(!$conn){
    die("Connection failed: ".mysqli_connect_error());
}