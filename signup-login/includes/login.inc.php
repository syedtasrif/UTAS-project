<?php
include 'db.inc.php'; //database inclusion
if(isset($_POST['login-submit'])){ //check if the user actually clicked the login button to enter
    
    $email=$_POST['email']; //fetch variable from login form using post method
    $password=$_POST['pwd'];
    if(empty($email) || empty($password)){
        header("Location: ../login.php?error=emptyfields");
        exit();
    }
    else{
        $sql="SELECT * FROM users WHERE user_email=?;"; //query to select user table
        $stmt= mysqli_stmt_init($mysqli); //statement prep is secure
        if(!mysqli_stmt_prepare($stmt, $sql)){
            
            header("Location: ../login.php?error=sqlerror"); //sending back location
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "s", $email); //check the parameters in the statement
            mysqli_stmt_execute($stmt);
            $result=mysqli_stmt_get_result($stmt);
            if($row=mysqli_fetch_assoc($result)){
                $pwdCheck= password_verify($password, $row['user_pwd']); //checking the hashed password in the database
                if($pwdCheck==false){
                    header("Location: ../login.php?error=wrongpwd");
                    exit();
                }
                else if($pwdCheck==true){
                    session_start(); //login session for access control and visibility functionality
                    
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