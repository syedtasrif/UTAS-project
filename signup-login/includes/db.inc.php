<?php
//connect to mysql
$mysqli = new mysqli('localhost', 'root', '', 'assignment');

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>
