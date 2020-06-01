<?php
//connect to mysql
$mysqli = new mysqli('localhost', 'root', '', 'assignment'); //database connection object-oriented methide

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error()); //if the connection failed, it will print this line
    exit();
}
?>
