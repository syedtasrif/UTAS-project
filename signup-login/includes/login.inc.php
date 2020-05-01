<?php
include 'db.inc.php';
if(isset($_POST['login-submit'])){
    
    $mailuid=$_POST['mailuid'];
    $password=$_POST['pwd'];
    if(empty($mailuid) || empty($password)){
        header("Location: ../login.php?error=emptyfields");
        exit();
    }
    else{
        $sql="SELECT * FROM users WHERE uidUsers=? OR emailUsers=?;";
        $stmt= mysqli_stmt_init($mysqli);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            
            header("Location: ../login.php?error=sqlerror");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
            mysqli_stmt_execute($stmt);
            $result=mysqli_stmt_get_result($stmt);
            if($row=mysqli_fetch_assoc($result)){
                //printf("[004] [%d] %s\n", mysqli_stmt_errno($stmt), mysqli_stmt_error($stmt));die;
                $pwdCheck= password_verify($password, $row['pwdUsers']);
                if($pwdCheck==false){
                    header("Location: ../login.php?error=wrongpwd");
                    exit();
                }
                else if($pwdCheck==true){
                    session_start();
                    $_session['userId']=$row['idUsers'];
                    $_session['userUid']=$row['uidUsers'];
                    $_session['userRole']=$row['roleUsers'];

                    header("Location: ../cms-dashboard.php?login=success");
                    exit();
                }
                else{
                    header("Location: ../login.php?error=wrongpwd");
                    exit();
                }

            }
            else{
                header("Location: ../login.php?error=nouser");
                exit();
            }
        }
    }
}
else{
    header("Location: ../login.php");
    exit();
}