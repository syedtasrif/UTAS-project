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
        <title>Student Area | Dashboard</title>
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
    </head>
    <body>
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
                        <li class="active"><a href="homepage_UWD.html">Home</a></li>
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
                            <a href="cms-dashboard.php" class="list-group-item main-color-bg">
                                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Dashboard
                            </a>

                            <?php if($_SESSION['user_role_allocated'] == 'student') {?>
                            <a href="enroll.php" class="list-group-item"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>Enroll<span class="badge">12</span></a>
                            <a href="timetable.php" class="list-group-item"><span class="glyphicon glyphicon-time" aria-hidden="true"></span>Individual Timetable<span class="badge">33</span></a>
                            <a href="tuteAllocate.php" class="active list-group-item"><span class="glyphicon glyphicon-pushpin" aria-hidden="true"></span>Tutorial Allocation<span class="badge">203</span></a>
                            <?php } ?>

                            <?php if($_SESSION['user_role_allocated'] != 'student') {?>
                            <a href="unitManage.php" class="list-group-item"><span class="glyphicon glyphicon-list" aria-hidden="true"></span>Unit Management<span class="badge">197</span></a>
                            <?php } ?>

                            <?php if($_SESSION['user_role_allocated'] == 'admin') {?>
                            <a href="academicStaffList.php" class="list-group-item"><span class="glyphicon glyphicon-list" aria-hidden="true"></span>Academic Staff (Master)<span class="badge">197</span></a>
                            <a href="unitMaster.php" class="list-group-item"><span class="glyphicon glyphicon-list" aria-hidden="true"></span>Unit List (Master))<span class="badge">1</span></a>
                            <?php } ?>
                        </div>
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
                        <div class="panel panel-default">
                            <div class="panel-heading main-color-bg">
                                <h3 class="panel-title">Tutorials Available</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-striped table-hover">
                                            <tr>
                                                <th>Name</th>
                                                <th>Tutorial Unit Code</th>                                                
                                                <th>Tutorial Semester</th>
                                                <th>Tutorial Campus</th>  
                                                <th>Unit Tutor</th>
                                                <th>Tutorial Day</th>
                                                <th>Tutorial Time</th>
                                                <th>Action</th>                    
                                            </tr>
                                            <?php
                                            $all_unit_sql= "SELECT * FROM tutorials 
                                INNER JOIN student_unit ON student_unit.student_unit_id = tutorials.tutorial_unit 
                                INNER JOIN units ON units.unit_id = tutorials.tutorial_unit 
                                INNER JOIN users ON users.user_id = tutorials.tutorial_tutor
                                WHERE student_unit.student_id = ". $_SESSION['loggedin_id'] ." 
                                AND student_unit.student_tutorial_id != tutorials.tutorial_id 
                                ORDER BY tutorials.tutorial_id DESC;";                    
                                            $result= mysqli_query($conn, $all_unit_sql);
                                            echo mysqli_error($conn);
                                            while($row=mysqli_fetch_assoc($result)){
                                                

                                                echo "<tr>
                              <td>".$row["tutorial_name"]."</td>
                              <td>".$row["unit_code"]."</td>
                              <td>".$row["unit_semester"]."</td>
                              <td>".$row["unit_campus"]."</td>
                              <td>".$row["user_name"]."</td>
                              <td>".$row["tutorial_day"]."</td>
                              <td>".$row["tutorial_time"]."</td>
                              <td><a href='student_tutorial_enroll.inc.php?tutorial_id=".$row['tutorial_id']."&unit_id=".$row['unit_id']."' class='btn btn-success tute-enroll-btn' >Enroll</button></td></tr>";
                                            }
                                            echo "</table>";            

                                            ?>
                                        </table>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="panel panel-default">
                            <div class="panel-heading main-color-bg">
                                <h3 class="panel-title">Enrolled Tutorials</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-striped table-hover">
                                            <tr>
                                                <th>Name</th>
                                                <th>Tutorial Unit Code</th>                                                
                                                <th>Tutorial Semester</th>
                                                <th>Tutorial Campus</th>  
                                                <th>Unit Tutor</th>
                                                <th>Tutorial Day</th>
                                                <th>Tutorial Time</th>
                                                <th>Action</th>                    
                                            </tr>
                                            <?php
                                            $all_unit_sql= "SELECT * FROM tutorials 
                                INNER JOIN student_unit ON student_unit.student_unit_id = tutorials.tutorial_unit AND student_tutorial_id = tutorials.tutorial_id
                                INNER JOIN units ON units.unit_id = tutorials.tutorial_unit 
                                INNER JOIN users ON users.user_id = tutorials.tutorial_tutor
                                WHERE student_unit.student_id = ". $_SESSION['loggedin_id'] ." 
                                AND student_unit.student_tutorial_id != 0 
                                ORDER BY tutorials.tutorial_id DESC;";                    
                                            $result= mysqli_query($conn, $all_unit_sql);
                                            echo mysqli_error($conn);
                                            while($row=mysqli_fetch_assoc($result)){

                                                echo "<tr>
                              <td>".$row["tutorial_name"]."</td>
                              <td>".$row["unit_code"]."</td>
                              <td>".$row["unit_semester"]."</td>
                              <td>".$row["unit_campus"]."</td>
                              <td>".$row["user_name"]."</td>
                              <td>".$row["tutorial_day"]."</td>
                              <td>".$row["tutorial_time"]."</td>
                              <td>
                                <a href='student_tutorial_withdraw.inc.php?tutorial_id=".$row['tutorial_id']."&unit_id=".$row['unit_id']."' 
                                    class='btn btn-danger tute-enroll-btn' >Withdraw</button></td>
                              </tr>";
                                            }
                                            echo "</table>";            

                                            ?>
                                        </table>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script>

        </script>

    </body>
</html>

