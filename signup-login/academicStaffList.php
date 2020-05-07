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
        <title>Admin Dashboard</title>
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

        <!-- Add New Academic Staff Modal -->

        <div class="modal fade" id="insertNewStaff" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel">Add New Academic Staff</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <form id="add-form" method="POST">

                                <label for="name"><b>Full Name</b></label>
                                <input type="text" placeholder="Your Name.." id="user_name" class="form-control" required>
                                <br/>
                                <label for="Role"><b>Role</b></label>
                                <select name="user_role" id="user_role" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="staff">Staff</option>
                                    <option value="UC">UC</option>
                                    <option value="lecturer">Lecturer</option>
                                    <option value="tutor">Tutor</option>
                                </select>
                                <br/>
                                <label for="Position"><b>Highest Academic Qualification</b></label>
                                <select name="user_qualification" id="user_qualification" class="form-control" required>
                                    <option value="Bachelors">Bachelors Degree</option>
                                    <option value="Masters">Masters Degree</option>
                                    <option value="PhD">PhD</option>
                                    <option value="Other">Other</option>
                                </select>
                                <br/>
                                <label for="expertise"><b>Expertise</b></label>
                                <input type="text" id="user_expertise" name="user_expertise" class="form-control" required>                   <br/>
                                <label for="email"><b>Email</b></label>
                                <input type="text" placeholder="Enter Email" name="user_email" id= "user_email" class="form-control" required>
                                <br/>
                                <label for="password"><b>Password</b></label>
                                <input type="password" placeholder="Enter Password" name="user_pwd" id= 'user_pwd' class="form-control" required>
                                <br/>
                                <label for="pwd-repeat"><b>Confirm Password</b></label>
                                <input type="password" placeholder="Repeat Password" name="pwd-repeat" id="pwd-repeat" class="form-control" required>
                                <br/>
                                <button type="submit" class="btn btn-success" id="addStaffButton" name="addStaffButton">Insert</button>


                            </form>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close" onclick="javascript:window.location.reload()">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!--Navigation-->

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
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">User<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-header">Admin and Dashboard</li>
                                <li><a href="#">Course Coordinator</a></li>
                                <li><a href="#">Unit Coordinator</a></li>
                                <li><a href="#">Lecturer</a></li>
                                <li><a href="#">Tutor</a></li>
                                <li class="divider"></li>
                                <li class="dropdown-header">Student CWS</li>
                                <li><a href="#">Student</a></li>
                            </ul>
                        </li>
                        <li><a href="includes/logout.inc.php">Logout</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-left">
                        <li><a href="#">Welcome, Syed</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!--Footer-->

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

        <!--Dashboard-->
        <section id="main">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="list-group">
                            <a href="index.html" class="list-group-item active main-color-bg">
                                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Dashboard
                            </a>
                            <a href="enroll.php" class="list-group-item"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>Enroll<span class="badge">12</span></a>
                            <a href="timetable.php" class="list-group-item"><span class="glyphicon glyphicon-time" aria-hidden="true"></span>Individual Timetable<span class="badge">33</span></a>
                            <a href="tuteAllocate.php" class="list-group-item"><span class="glyphicon glyphicon-pushpin" aria-hidden="true"></span>Tutorial Allocation<span class="badge">203</span></a>
                            <a href="unitManage.php" class="list-group-item"><span class="glyphicon glyphicon-list" aria-hidden="true"></span>Unit Management<span class="badge">197</span></a>
                            <a href="academicStaffList.php" class="list-group-item"><span class="glyphicon glyphicon-list" aria-hidden="true"></span>Academic Staff (Master)<span class="badge">197</span></a>
                        </div>

                        <!--Just for visualization-->
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
                    <!---Content--->
                    <div class="col-md-9">
                        <div class="panel-heading main-color-bg">
                            <h3 class="panel-title">Staff List</h3>                           
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" border="1px" id="editable_table">
                                    <tr>
                                        <th>ID</th>
                                        <th>Staff Name</th>
                                        <th>Staff Qualification</th>
                                        <th>Staff Expertise</th>
                                        <th>Staff Role</th>
                                        <th>Staff Unavailability</th>
                                        <th>Staff Email</th>
                                    </tr>
                                    <?php
                                    $sql= "SELECT * FROM users WHERE user_role != 'student'";                    
                                    $result= mysqli_query ($conn, $sql);


                                    while($row=mysqli_fetch_assoc($result)){
                                        echo "<tr><td>".$row["user_id"]."</td><td>".$row["user_name"]."</td><td>".$row["user_qualification"]."</td><td>".$row["user_expertise"]."</td><td>".$row["user_role"]."</td><td>".$row["user_unavailability"]."</td><td>".$row["user_email"]."</td></tr>";
                                    }
                                    echo "</table>";                 

                                    ?>
                                </table>
                            </div>

                        </div>
                        <a type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#insertNewStaff">Add New Staff</a>
                    </div>
                </div>
            </div>
        </section>
        <script>
            $(document).ready(function(){
                $('#editable_table').Tabledit({
                    url:'academicStaffList_action.inc.php',
                    columns:{
                        identifier:[0, "user_id"],
                        editable:[[1, 'user_name'], [2, 'user_qualification'], [3, 'user_expertise'], [4, 'user_role'], [5, 'user_unavailability'], [6, 'user_email']]
                    },
                    restoreButton: false,
                    onSuccess: function(data, textStatus, jqXHR){
                        if(data.action=='delete'){
                            $('#'+data.id).remove();
                        }                       
                    }
                }); 
            });


            $(document).ready(function(){
                $("#addStaffButton").click(function() {
                    var user_name = $("#user_name").val();
                    var user_pwd = $("#user_pwd").val();
                    var user_email = $("#user_email").val();
                    var user_expertise = $("#user_expertise").val();
                    var user_role = $("#user_role").val();
                    var user_qualification = $("#user_qualification").val();

                    if (user_name == '' || user_pwd == '' || user_email == '' || user_expertise == '' || user_role == '' || user_qualification == '') {
                        alert("Insertion Failed Some Fields are Blank....!!");
                    } else {
                        // Returns successful data submission message when the entered information is stored in database.
                        $.post("insertNewStaff.inc.php", {                                           
                            user_name1: user_name,
                            user_pwd1: user_pwd,
                            user_email1: user_email,
                            user_expertise1: user_expertise,
                            user_role1: user_role,
                            user_qualification1: user_qualification                           
                        }, function(data) {
                            alert(data);
                            $('#add-form')[0].reset(); // To reset form fields
                        });
                    }
                });
            });

        </script>
    </body>
</html>
