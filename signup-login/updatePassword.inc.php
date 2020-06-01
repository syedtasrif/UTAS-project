<?php
session_start();
include ('db_conn.php'); //db connection


$user_email2 = $_POST['user_email1']; // Fetching Values from URL
$old_pwd2 = $_POST['old_pwd1'];
$new_pwd2 = $_POST['new_pwd1'];
$conf_pwd2 = $_POST['conf_pwd1'];

$sql="SELECT * FROM users WHERE user_email=?;"; //safe method of statement use rather that putting user_eamil='".$user_email2."'
$stmt= mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)){

    echo "Server Error"; //alert
}
else{
    mysqli_stmt_bind_param($stmt, "s", $user_email2);
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);
    if($row=mysqli_fetch_assoc($result)){
        $pwdCheck= password_verify($old_pwd2, $row['user_pwd']); //default php password verify 
        if($pwdCheck==false){ //boolean password right or wrong check
            echo "Your current password is wrong";
        }
        else if($pwdCheck==true){
            if($new_pwd2!=$conf_pwd2){
                echo "Please Type Your New Password Again";  //alert                            
            }
            else{
                $hashedPwd=password_hash($new_pwd2, PASSWORD_DEFAULT); //password encryption before update
                $query="UPDATE users SET user_pwd='".$hashedPwd."' WHERE user_email='".$user_email2."';";
                if(mysqli_query($conn, $query)){
                    echo "Password Updated Succesfully";
                } else echo "Mysql Error " . mysqli_error($conn);
            }
        }
    }
    else{
        echo "No user email found";
    }
}

?>