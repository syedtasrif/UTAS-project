<?php
 session_start();
if(!isset($_SESSION['loggedin_id'])){
    header("Location: login.php?error=anonymousUser");    
} //session start ensuring happened by clicking the login page
?>
<?php
include('db_conn.php'); //db connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>CMS-Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"> 
    <link rel="stylesheet" href="CSS/dashboard.css">
        
</head>
    <body>
<!------------------------------------------------------------Navigation------------------------------------------------------------------------------->
        
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"> UDW </a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a href="homepage_UWD.php">Home</a></li>
                        <li><a href="login.php">Logout</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-left">
                        <li><a href="#">Welcome, <?php
                            $sql= "SELECT * FROM users WHERE user_id= ".$_SESSION['loggedin_id'].";"; //select only the user row based on loggedin id
                            $result= mysqli_query($conn, $sql);
                            while($row=mysqli_fetch_assoc($result)){
                                echo $row["user_name"]; //logged in user name display on the navbar
                            }
                            ?>
                            </a></li>
                    </ul>
                </div>
            </div>
        </div>
        
<!----------------------------------------------------------------------Footer------------------------------------------------------------------------->
        
        <div class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
            <div class="container-fluid">
                <div class="navbar-text pull-left">
                    <p>Copyright 2020 Syed Tasrif</p>
                </div>
                <div class="navbar-text pull-right">
                    <a href="#"><i class="fa fa-facebook-square fa-2x"></i></a>
                    <a href="#"><i class="fa fa-twitter-square fa-2x"></i></a>
                    <a href="#"><i class="fa fa-google-plus-square fa-2x"></i></a>
                </div>
            </div>
        </div>
        
<!-----------------------------------------------------------------Dashboard---------------------------------------------------------------------------->
        
        <section id="main">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="list-group">
<!------------------------------------------------------------------Buttons on dahboard bar visibility based on role---------------------------------->
                            
                            <a href="cms-dashboard.php" class="list-group-item active main-color-bg">
                                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Dashboard
                            </a>

                            <?php if($_SESSION['user_role_allocated'] == 'student') {?>
                            <a href="enroll.php" class="list-group-item"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>Enroll<span class="badge">12</span></a>
                            <a href="timetable.php" class="list-group-item"><span class="glyphicon glyphicon-time" aria-hidden="true"></span>Individual Timetable<span class="badge">33</span></a>
                            <a href="tuteAllocate.php" class="list-group-item"><span class="glyphicon glyphicon-pushpin" aria-hidden="true"></span>Tutorial Allocation<span class="badge">203</span></a>
                            <?php } ?>

                            <?php if($_SESSION['user_role_allocated'] != 'student') {?>
                            <a href="unitManage.php" class="list-group-item"><span class="glyphicon glyphicon-list" aria-hidden="true"></span>Unit Management<span class="badge">197</span></a>
                            <?php } ?>

                            <?php if($_SESSION['user_role_allocated'] == 'admin') {?>
                            <a href="academicStaffList.php" class="list-group-item"><span class="glyphicon glyphicon-list" aria-hidden="true"></span>Academic Staff (Master)<span class="badge">197</span></a>
                            <a href="unitMaster.php" class="list-group-item"><span class="glyphicon glyphicon-list" aria-hidden="true"></span>Unit List (Master))<span class="badge">1</span></a>
                            <?php } ?>
                            
                            <a href="userProfile.php" class="list-group-item"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>User Profile<span class="badge">3</span></a>

                        </div>
                        
<!--------------------------------------------------------------------------Just for visualization---------------------------------------------------->
                        <div class="well">
                            <h4>Disk Space Used</h4>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                    60%
                                </div>
                            </div>
                            <h4>Bandwidth Used </h4>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">
                                    40%
                                </div>
                            </div>
                        </div>
                    </div>
<!---------------------------------------------------------------------------No Content------------------------------------------------------------->
                    <div class="col-md-9">
                        
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>
    
