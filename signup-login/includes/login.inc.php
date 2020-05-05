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
        $sql="SELECT * FROM users WHERE user_name=? OR user_email=?;";
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
                $pwdCheck= password_verify($password, $row['user_pwd']);
                if($pwdCheck==false){
                    header("Location: ../login.php?error=wrongpwd");
                    exit();
                }
                else if($pwdCheck==true){
                    session_start();
                    
                    $_SESSION['userUid']=$row['user_name'];
                    $_SESSION['userRole']=$row['user_role'];

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