<?php
session_start(); //logout can happen after the session starts in this page
session_unset(); // all changes which are not saved will be unset
session_destroy(); //kill the session
header("Location: ../login.php?msg=logoutsuccess");
exit();

?>