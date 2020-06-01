<?php
session_start();
if(!isset($_SESSION['loggedin_id'])){
    header("Location: login.php?error=anonymousUser");    
}
?>

<?php
include('db_conn.php'); //db connection
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Profile</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link href="CSS/dashboard.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
        <!--Timepicker plugins compatible for bootrap versioin 3 only-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
        <script src="jquery.tabledit.js" type="text/javascript"></script>
        <!-- Link to use icon-->

        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"> 

    </head>
    <body>
<!-------------------------------------------------- Modal for Changing Password-------------------------------------------------------------->

        <div class="modal fade" tabindex="-1" role="dialog" id="update_pwd_modal"  aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Change Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <form class="update_pwd_form" method="post">
                                <label>Your Email Address</label>
                                <input type="text" class="form-control" id="user_email" name="user_email">
                                <br/>
                                <label>Old Password</label>
                                <input type="password" class="form-control" id="old_pwd" name="old_pwd">
                                <br/>
                                <label>New Password</label>
                                <input type="password" class="form-control" id="new_pwd" name="new_pwd">
                                <br/>
                                <label>Confirm Password</label>
                                <input type="password" class="form-control" id="conf_pwd" name="conf_pwd">
                                <br/>
                                <a type="submit" class="btn btn-primary" id="pwd_change_button">Submit</a>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">                        
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
<!------------------------------------------------------------------------Navigation-------------------------------------------------------------------->
        
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
                            $sql= "SELECT * FROM users WHERE user_id= ".$_SESSION['loggedin_id'].";";
                            $result= mysqli_query($conn, $sql);
                            while($row=mysqli_fetch_assoc($result)){
                                echo $row["user_name"];
                            }
                            ?>
                            </a></li>
                    </ul>
                </div>
            </div>
        </div>

<!-------------------------------------------------------------------------Footer----------------------------------------------------------------------->
        
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

<!---------------------------------------------------------------------------Dashboard------------------------------------------------------------------>

        <section id="main">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="list-group">
                            <a href="cms-dashboard.php" class="list-group-item main-color-bg">
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

                            <a href="userProfile.php" class="active list-group-item"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>User Profile<span class="badge">3</span></a>

                        </div>

<!-----------------------------------------------------------------------Just for visualization-------------------------------------------------------->
                        
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
<!-----------------------------------------------------------------------Content------------------------------------------------------------------------>
                    
                    <div class="col-md-9">
                        <?php //div area for user if not a student 
                        if($_SESSION['user_role'] != "student") {?>
                        <div class="panel panel-default">
                            <div class="panel-heading main-color-bg">
                                <h3 class="panel-title">Update Profile Details</h3>
                            </div>
                            <div class="panel-body">
                                <a class="btn btn-default" data-toggle="modal" data-target="#update_pwd_modal">Update Password</a>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" border="1px" id="editable_user_table">

                                        <tr>
                                            <th>ID</th>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Qualification</th>
                                            <th>Expertise</th>
                                            <th>Unavailability</th>
                                        </tr>
                                        <?php
                                            $sql= "SELECT * FROM users WHERE user_id=". $_SESSION['loggedin_id'] ." ;";                    
                                            $result= mysqli_query($conn, $sql);


                                            while($row=mysqli_fetch_assoc($result)){
                                                echo "<tr><td>".$row["user_id"]."</td><td>".$row["user_name"]."</td><td>".$row["user_email"]."</td><td>".$row["user_qualification"]."</td><td>".$row["user_expertise"]."</td><td>".$row["user_unavailability"]."</td></tr>";
                                            }
                                            echo "</table>";               

                                        ?>
                                    </table>
                                </div>
                            </div>
                            <?php } ?>
                            
                            <?php if($_SESSION['user_role'] == "student") {?>
                            <div class="panel panel-default">
                                <div class="panel-heading main-color-bg">
                                    <h3 class="panel-title">Update Profile Details</h3>
                                </div>
                                <div class="panel-body">
                                    <a class="btn btn-default" data-toggle="modal" data-target="#update_pwd_modal">Update Password</a>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover" border="1px" id="editable_student_table">

                                            <tr>
                                                <th>ID</th>
                                                <th>Full Name</th>
                                                <th>Email</th>
                                            </tr>
                                            <?php
                                                $sql= "SELECT * FROM users WHERE user_id=". $_SESSION['loggedin_id'] ." ;";                    
                                                $result= mysqli_query($conn, $sql);


                                                while($row=mysqli_fetch_assoc($result)){
                                                echo "<tr><td>".$row["user_id"]."</td><td>".$row["user_name"]."</td><td>".$row["user_email"]."</td></tr>";
                                            }
                                            echo "</table>";               

                                            ?>
                                        </table>
                                    </div>
                                </div>
                                <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
        <script>
            $(document).ready(function(){

                $('#editable_user_table').Tabledit({ //edit table plugin javascript function
                    url:'action_edit_user.inc.php',
                    columns:{
                        identifier:[0, "user_id"],
                        editable:[[1, 'user_name'], [2, 'user_email'], [3, 'user_qualification'], [4, 'user_expertise'], [5, 'user_unavailability']]
                    },
                    restoreButton: false,
                    deleteButton: false,
                    onSuccess: function(data, textStatus, jqXHR){
                        if(data.action=='delete'){
                            //$('#'+data.id).remove();

                        }                       
                    }
                }); 
            });
            
            $(document).ready(function(){
                
                $('#editable_student_table').Tabledit({
                    url:'action_edit_student.inc.php',
                    columns:{
                        identifier:[0, "user_id"],
                        editable:[[1, 'user_name'], [2, 'user_email']]
                    },
                    restoreButton: false,
                    deleteButton: false,
                    onSuccess: function(data, textStatus, jqXHR){
                        if(data.action=='delete'){
                            //$('#'+data.id).remove();

                        }                       
                    }
                });
                
            });
            
            $(document).ready(function() { //modal submit of form by click the button with id= pwd_change_button
                $("#pwd_change_button").click(function() {
                    var user_email = $("#user_email").val();
                    var old_pwd = $("#old_pwd").val(); //user input 
                    var new_pwd = $("#new_pwd").val();
                    var conf_pwd = $("#conf_pwd").val();;

                    if (user_email == '' || old_pwd == '' || new_pwd == '' || conf_pwd == '') { //empty field check
                        alert("Password Update Failed: Some Fields are Blank....!!");
                    } else {
                        // Returns successful data submission message when the entered information is stored in database.
                        $.post("updatePassword.inc.php", {
                            user_email1: user_email,                            
                            old_pwd1: old_pwd,                            
                            new_pwd1: new_pwd,                            
                            conf_pwd1: conf_pwd
                        }, function(data) {
                            alert(data);
                            $('#update_pwd_form')[0].reset(); // To reset form fields
                        });
                    }
                });
            });

        </script>
    </body>
</html>

