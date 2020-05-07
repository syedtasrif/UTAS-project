<?php
include ('db_conn.php'); //db connection
$user_name2=$_POST['user_name1']; // Fetching Values from URL
$user_pwd2=$_POST['user_pwd1'];
$user_email2=$_POST['user_email1'];
$user_qualification2=$_POST['user_qualification1'];
$user_expertise2= $_POST['user_expertise1'];
$user_role2= $_POST['user_role1'];
$hashedPwd=password_hash($user_pwd2, PASSWORD_DEFAULT);
$query = "INSERT INTO users(user_name, user_email, user_role, user_pwd, user_qualification, user_expertise) VALUES ('$user_name2','$user_email2','$user_role2', '$hashedPwd', '$user_qualification2', '$user_expertise2')"; //Insert query
if(mysqli_query($conn, $query)){
    echo "Data Submitted succesfully";
}
mysqli_close($conn); // Connection Closed.
?>




