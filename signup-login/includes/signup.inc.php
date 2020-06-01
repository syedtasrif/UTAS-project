<?php
include 'db.inc.php';
if(isset($_POST['signup-submit'])){ //check for the button clicked

    $username=$_POST['uid'];
    $email=$_POST['mail'];
    $password=$_POST['pwd'];
    $passwordRepeat=$_POST['pwd-repeat'];
    $userRole=$_POST['role'];
    $userQualification=$_POST['academicQual'];
    $userExpertise=$_POST['expertise'];

   if(empty($username) || empty($email) || empty($password) || empty($passwordRepeat) || empty($userRole)){ //check if any field is empty
        header("Location: ../register.php?error=emptyfields&uid=".$username."&mail=".$email);
        exit();

    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ //default backend email format validation
        header("Location: ../register.php?error=invalidmail");
        exit();

    }

    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        header("Location: ../register.php?error=invalidmail&uid=".$email);
        exit();
    }
    else if(!preg_match("/^[a-z A-Z]*$/", $username)){ //checking the name format, i.e. it must be alphabets
        header("Location: ../register.php?error=invaliduid&mail=".$email);
        exit();
    }
    else if($password !== $passwordRepeat){ //check if the repeated password does not match
        header("Location: ../register.php?error=passwordcheckuid=".$username."&mail=".$email);
    }
    else{
        $sql="SELECT user_name FROM users WHERE user_name=?"; //select database table
        $stmt=mysqli_stmt_init($mysqli);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../register.php?error=sqlerror");
            
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "s", $username); //check for similar username
            mysqli_stmt_execute($stmt); //binding statement execution 
            mysqli_stmt_store_result($stmt);
            $resultCheck=mysqli_stmt_num_rows($stmt);
            if($resultCheck>0){
                header("Location: ../register.php?error=usertaken=".$email);
                exit();
                
            }
            else{
                $sql="INSERT INTO users (user_name, user_email, user_role, user_role_allocated, user_pwd, user_qualification, user_expertise) VALUES (?, ?, ?, ?, ?, ?, ?)"; // ? is for the user input variable
                $stmt=mysqli_stmt_init($mysqli);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    header("Location: ../register.php?error=sqlerror");
                    exit();  
                    
                }
                else{
                    $hashedPwd=password_hash($password, PASSWORD_DEFAULT); //password encryption technique using php default encryption method
                    mysqli_stmt_bind_param($stmt, "sssssss", $username, $email, $userRole, $userRole, $hashedPwd, $userQualification, $userExpertise);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    header("Location: ../login.php?signup=success");
                    exit();
                }
            }
        }

    }
    mysqli_stmt_close($stmt); //close statement
    mysqli_close($mysqli); //close the connection to the database
}
else{
    header("Location: ../register.php");
    exit();
}
?>

