<?php
include 'db.inc.php';
if(isset($_POST['login-submit'])){
    
    $email=$_POST['email'];
    $password=$_POST['pwd'];
    if(empty($email) || empty($password)){
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
            mysqli_stmt_bind_param($stmt, "ss", $email, $email);
            mysqli_stmt_execute($stmt);
            $result=mysqli_stmt_get_result($stmt);
            if($row=mysqli_fetch_assoc($result)){
                $pwdCheck= password_verify($password, $row['user_pwd']);
                if($pwdCheck==false){
                    header("Location: ../login.php?error=wrongpwd");
                    exit();
                }
                else if($pwdCheck==true){
                    session_start();
                    
                    $_SESSION['loggedin_email']=$row['user_email'];
                    $_SESSION['loggedin_id']=$row['user_id'];
                    $_SESSION['user_role_allocated']=$row['user_role_allocated'];
                    $_SESSION['user_role']=$row['user_role'];



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