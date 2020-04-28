<?php
include 'db.inc.php';
if(isset($_POST['signup-submit'])){

    $username=$_POST['uid'];
    $email=$_POST['mail'];
    $password=$_POST['pwd'];
    $passwordRepeat=$_POST['pwd-repeat'];
    $userId=$_POST['id'];
    $userRole=$_POST['role'];

    if(empty($username) || empty($email) || empty($password) || empty($passwordRepeat) || empty($userId)){
        header("Location: ../register.php?error=emptyfields&uid=".$username."&mail=".$email);
        exit();

    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)){
        header("Location: ../signup.php?error=invalidmail&uid");
        exit();

    }

    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        header("Location: ../signup.php?error=invalidmail&uid=".$username);
        exit();
    }
    else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
        header("Location: ../signup.php?error=invaliduid&mail=".$email);
        exit();
    }
    else if($password !== $passwordRepeat){
        header("Location: ../signup.php?error=passwordcheckuid=".$username."&mail=".$email);
    }
    else{
        $sql="SELECT uidUsers FROM users WHERE uidUsers=?";
        $stmt=mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../signup.php?error=sqlerror");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result_($stmt);
            $resultCheck=mysqli_stmt_num_rows($stmt);
            if($resultCheck>0){
                header("Location: ../signup.php?error=usertaken=".$email);
                exit();
                
            }
            else{
                $sql="INSERT INTO users (idUsers, uidUsers, emailUsers, roleUsers, pwdUsers) VALUES (?, ?, ?, ?, ?)";
                $stmt=mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    header("Location: ../signup.php?error=sqlerror");
                    exit();                    
                }
                else{
                    mysqli_stmt_bind_param($stmt, "issss", $userId, $username, $email, $userRole);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result_($stmt);
                }
            }
        }

    }
}
?>
