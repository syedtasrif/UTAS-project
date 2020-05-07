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
        <title>Dashboard</title>
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
        <!-- Add UC & Lec Modal popup for Department Coordinator use-->
        <div class="modal fade" id="add_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel">Add New Unit</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <form id="add-form" method="post">
                                <label>Unit Code</label>
                                <input type="text" class="form-control" id="inputCode" name="unit_code">
                                <br/>
                                <label>Unit Name</label>
                                <input type="text" class="form-control" id="inputName" name="unit_name">
                                <br/>
                                <label>Unit Coordinator</label>
                                
                                <select class="form-control" id="inputUC" name="unit_coordinator">
                                <?php
                                $sql= "SELECT * FROM users WHERE user_role = 'staff'";
                                $result= mysqli_query($conn, $sql);
                                $user_json=array();
                                while ($row =mysqli_fetch_array($result)){
                                    echo "<option value='".$row['user_id']."'>".$row['user_name']."</option>";
                                    $user_json[$row['user_id']] = $row['user_name'];
                                }
                                    $user_json = json_encode($user_json);
                                    ?>
                                </select>
                                
                                <br/>
                                <label>Unit Lecturer</label>
                                
                                <select class="form-control" id="inputLec" name="unit_lecturer">
                                    <option value="">Choose</option>
                                    <?php
                                    $sql= "SELECT * FROM users WHERE user_role = 'staff'";
                                    $result= mysqli_query($conn, $sql);

                                    while ($row =mysqli_fetch_array($result)){
                                        echo "<option value='".$row['user_id']."'>".$row['user_name']."</option>";
                                    }
                                    ?>
                                </select>
                                <br/>
                                <label>Semester</label>
                                <select class="form-control" id="inputSem" name="unit_semester">
                                    <option value="">Choose</option>
                                    <option value="Semester 1">Semester 1</option>
                                    <option value="Semester 2">Semester 2</option>
                                    <option value="Winter School">Winter School</option>
                                    <option value="Spring School">Spring School</option>
                                </select>
                                <br/>
                                <label>Campus</label>
                                <select class="form-control" id="inputCamp" name="unit_campus">
                                    <option value="">Choose</option>
                                    <option value="Pandora">Pandora</option>
                                    <option value="Rivendell">Rivendell</option>
                                    <option value="Neverland">Neverland</option>
                                </select>
                                <br/>
                                <label>Lecture Day</label>
                                <select class="form-control" id="inputLecDay" name="lecture_day">
                                    <option value="">Choose</option>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                </select>
                                <br/>
                                <label>Lecture Time</label>
                                <div class="form-group">
                                    <div class="input-group date" id="datetimepicker3" data-target-input="nearest">
                                        <input type="text" id="inputTime" name="lecture_time" class="form-control datetimepicker-input" data-target="#datetimepicker3"/>
                                        <span class="input-group-addon" data-target="#datetimepicker3" data-toggle="datetimepicker">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                                <script type="text/javascript">
                                    $(function () {
                                        $('#datetimepicker3').datetimepicker({
                                            format: 'LT'
                                        });
                                    });
                                </script>
                                <br/>
                                <a type="submit" class="btn btn-success" name="addButton" id="addButton">Add</a>
                            </form>

                        </div>                       
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-light" data-dismiss="modal" id="close" onclick="javascript:window.location.reload()">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Modal popup -->
        <div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel">Search</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <form id="search-form">
                                <label>Search</label>
                                <input type="text" class="form-control" id="input">
                                <br>
                                <label><a type="submit" class="btn btn-warning" name="submit-search" id="submitButton">Search</a></label>
                            </form>
                            <div class="results-container">


                            </div>
                        </div>                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal" id="close" onclick="javascript:window.location.reload()">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modalfor Tutors -->
        <div class="modal" tabindex="-1" role="dialog" id="view"  aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Student List</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped table-hover">
                            <tr>
                                <th>Student ID</th>
                                <th>Name</th>

                            </tr>
                            <tr>
                                <td>PHP Content</td>
                                <td>PHP Content</td>

                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for creating tutorial class-->
        <div class="modal fade" id="editTute" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel">Allocate Lecturer</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">

                                    <h4>Select Tutor:</h4>

                                    <select class="custom-select" required>
                                        <option value="">Choose</option>
                                        <option value="1">Tutor</option>
                                    </select>

                                    <h4>Campus:</h4>

                                    <select class="custom-select" required>
                                        <option value="">Choose</option>
                                        <option value="1">Pandora</option>
                                        <option value="2">Rivendell</option>
                                        <option value="3">Neverland</option>
                                    </select>
                                    <h4>Tutorial Day:</h4>

                                    <select class="custom-select" required>
                                        <option value="">Choose</option>
                                        <option value="1">Monday</option>
                                        <option value="2">Tuesday</option>
                                        <option value="3">Wednesday</option>
                                        <option value="4">Thursday</option>
                                        <option value="5">Friday</option>
                                    </select>
                                    <h4>Class Size:</h4>

                                    <select class="custom-select" required>
                                        <option value="">Choose</option>
                                        <option value="1">10</option>
                                        <option value="2">20</option>
                                    </select>


                                </div>

                                <div class="col-md-6">
                                    <h4>Semester:</h4>

                                    <select class="custom-select" required>
                                        <option value="">Choose</option>
                                        <option value="1">Semester 1</option>
                                        <option value="2">Semester 2</option>
                                        <option value="3">Winter School</option>
                                        <option value="3">Spring School</option>
                                    </select> 
                                    <h4>Tutorial Duration:</h4>

                                    <select class="custom-select" required>
                                        <option value="">Choose</option>
                                        <option value="1">1 Hour</option>
                                        <option value="2">2 Hour</option>
                                    </select>
                                    <h4>Tutorial Time:</h4> 
                                    <div class="form-group">
                                        <div class="input-group date" id="datetimepicker3" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker3"/>
                                            <span class="input-group-addon" data-target="#datetimepicker3" data-toggle="datetimepicker">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <script type="text/javascript">
                                        $(function () {
                                            $('#datetimepicker3').datetimepicker({
                                                format: 'LT'
                                            });
                                        });
                                    </script>


                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Adding and Removing Student-->
        <div class="modal" tabindex="-1" role="dialog" id="remove"  aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Student List</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped table-hover">
                            <tr>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th></th>
                            </tr>
                            <tr>
                                <td>PHP Content</td>
                                <td>PHP Content</td>
                                <td><a class="btn btn-danger" href="#">Remove</a></td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for adding New student -->
        <div class="modal" tabindex="-1" role="dialog" id="add"  aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Student to Lecture</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form >
                            <p>Student Name</p>
                            <input type="text" name="" placeholder="Name">
                            <p></p>
                            <p>Student ID</p>
                            <input type="text" name="" placeholder="ID">
                            <p></p>
                            <input type="submit" name="" value="Add">

                        </form>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal for Allocating Lecturer -->
        <div class="modal fade" id="add_modal_lec" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel">Add Lecture Class</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <form id="add_lecture_form" method="post">
                                <label>Unit Code</label>
                                <select class="form-control" name="unit_code" id="lecture_unit">
                                    <?php
                                    $sql= "SELECT * FROM units";
                                    $result= mysqli_query($conn, $sql);

                                    while ($row =mysqli_fetch_array($result)){
                                        echo "<option value='".$row['unit_id']."'>".$row['unit_code'].' '.$row['unit_campus']."</option>";
                                    }
                                    ?>
                                </select>
                                <br/>
                                <label>Unit Lecturer</label>

                                <select class="form-control" id="lecturer_lecturer" name="unit_lecturer">
                                    <?php
                                    $sql= "SELECT * FROM users WHERE user_role = 'staff'";
                                    $result= mysqli_query($conn, $sql);

                                    while ($row =mysqli_fetch_array($result)){
                                        echo "<option value='".$row['user_id']."'>".$row['user_name']."</option>";
                                    }
                                    ?>
                                </select>
                                <br/>
                                <label>Lecture Day</label>
                                <select class="form-control" id="lecture_day" name="lecture_day">
                                    <option value="">Choose</option>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                </select>
                                <br/>
                                <label>Lecture Time</label>
                                <div class="form-group">
                                    <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                                        <input type="text" id="lecture_time" name="lecture_time" class="form-control datetimepicker-input" data-target="#datetimepicker3"/>
                                        <span class="input-group-addon" data-target="#datetimepicker3" data-toggle="datetimepicker">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                                <script type="text/javascript">
                                    $(function () {
                                        $('#datetimepicker4').datetimepicker({
                                            format: 'LT'
                                        });
                                    });
                                </script>
                                <br/>
                                <a type="submit" class="btn btn-success" name="add_lec_buttonInModal" id="add_lec_buttonInModal">Add</a>
                            </form>

                        </div>                       
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-light" data-dismiss="modal" id="close" onclick="javascript:window.location.reload()">Close</button>
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
        <!-->
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
                            <a href="tuteAllocate.php" class="active list-group-item"><span class="glyphicon glyphicon-list" aria-hidden="true"></span>Unit Management<span class="badge">197</span></a>
                            <a href="academicStaffList.php" class="list-group-item"><span class="glyphicon glyphicon-list" aria-hidden="true"></span>Academic Staff (Master)<span class="badge">197</span></a>

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
                        <!--Department Coordinator Area-->
                        <div class="panel panel-default">
                            <div class="panel-heading main-color-bg">
                                <h3 class="panel-title">Units (DC Area)</h3>
                            </div>
                            <div class="panel-body">
                                <h3 align ="center">Manage Unit Details</h3>


                                <div class="table-responsive">
                                    <a type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#search">Search</a>
                                    <table class="table table-striped table-hover" border="1px" id="editable_table">

                                        <tr>
                                            <th>ID</th>
                                            <th>Unit Code</th>
                                            <th>Unit Name</th>
                                            <th>Semester</th>
                                            <th>Campus</th>
                                            <th>Unit Coordinator</th>

                                        </tr>


                                        <?php
                                        $sql= "SELECT * FROM units INNER JOIN users ON units.unit_coordinator = users.user_id ORDER BY units.unit_id DESC;";                    
                                        $result= mysqli_query($conn, $sql);


                                        while($row=mysqli_fetch_assoc($result)){
                                            echo "<tr><td>".$row["unit_id"]."</td><td>".$row["unit_code"]."</td><td>".$row["unit_name"]."</td><td>".$row["unit_semester"]."</td><td>".$row["unit_campus"]."</td><td>".$row["user_name"]."</td></tr>";
                                        }
                                        echo "</table>";                 

                                        ?>



                                    </table>
                                </div>
                                <a type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#add_modal">Add New Unit</a>


                            </div>
                        </div>
                        <!-- Unit Coordinator Area-->
                        <div class="panel panel-default">
                            <div class="panel-heading main-color-bg">
                                <h3 class="panel-title">Unit Management (UC Area)</h3>
                            </div>
                            <div class="panel-body">
                                <a class="btn btn-default" data-toggle="modal" data-target="#editTute">Add Tutorial</a>
                                <a class="btn btn-default" data-toggle="modal" data-target="#add_modal_lec">Add/Edit Lecturer</a>
                                <a class="btn btn-link" data-toggle="modal" data-target="#remove">View</a>
                                <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#add">Add</a>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" border="1px" id="editable_lec_table">

                                        <tr>
                                            <th>ID</th>
                                            <th>Unit Code</th>
                                            <th>Unit Name</th>
                                            <th>Semester</th>
                                            <th>Campus</th>
                                            <th>Unit Lecturer</th>
                                            <th>Lecture Day</th>
                                            <th>Lecture Time</th>

                                        </tr>


                                        <?php
                                        $sql= "SELECT * FROM units LEFT JOIN users ON units.unit_lecturer = users.user_id ORDER BY units.unit_id DESC;";                    
                                        $result= mysqli_query($conn, $sql);


                                        while($row=mysqli_fetch_assoc($result)){
                                            echo "<tr><td>".$row["unit_id"]."</td><td>".$row["unit_code"]."</td><td>".$row["unit_name"]."</td><td>".$row["unit_semester"]."</td><td>".$row["unit_campus"]."</td><td>".$row["user_name"]."</td><td>".$row["lecture_day"]."</td><td>".$row["lecture_time"]."</td></tr>";
                                        }
                                        echo "</table>";                 

                                        ?>



                                    </table>
                                </div>
                              
                                
                            </div>
                        </div>
                        <!-- Lecturer Area-->
                        <div class="panel panel-default">
                            <div class="panel-heading main-color-bg">
                                <h3 class="panel-title">Unit Management (Lecturer)</h3>
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped table-hover">
                                    <tr>
                                        <th>Activity</th>
                                        <th>Unit Code</th>
                                        <th>Location</th>
                                        <th>Semester</th>
                                        <th>Day</th>  
                                        <th>Time</th>
                                        <th>Duratioin</th>
                                        <th>Student List</th>

                                    </tr>
                                    <tr>
                                        <td>Lec-01</td>
                                        <td>KIT502</td>
                                        <td>Campus:</td>
                                        <td>PHP Content</td>
                                        <td>PHP Content</td>
                                        <td>PHP Content</td>
                                        <td>PHP Content</td>
                                        <td><p><a class="btn btn-link" data-toggle="modal" data-target="#remove">View</a></p><a class="btn btn-success btn-sm" data-toggle="modal" data-target="#add">Add</a></td>
                                    </tr>
                                </table>
                                <table class="table table-striped table-hover">
                                    <tr>
                                        <th>Activity</th>
                                        <th>Unit Code</th>
                                        <th>Tutor</th>
                                        <th>Location</th>
                                        <th>Semester</th>
                                        <th>Day</th>
                                        <th>Time</th>
                                        <th>Duration</th>
                                        <th>Class Size</th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td>Tut-01</td>
                                        <td>KIT502</td>
                                        <td>PHP Content</td>
                                        <td>Campus:</td>
                                        <td>PHP Content</td>
                                        <td>PHP Content</td>
                                        <td>PHP Content</td>
                                        <td>PHP Content</td>
                                        <td>PHP Content</td>
                                        <td><a class="btn btn-default" data-toggle="modal" data-target="#editTute">Add Tutorial</a></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!-- Tutor Area-->

                        <div class="panel panel-default">
                            <div class="panel-heading main-color-bg">
                                <h3 class="panel-title">Unit Management (Tutor)</h3>
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped table-hover">
                                    <tr>
                                        <th>Activity</th>
                                        <th>Unit Code</th>
                                        <th>Location</th>
                                        <th>Semester</th>
                                        <th>Day</th>  
                                        <th>Time</th>
                                        <th>Duratioin</th>
                                        <th>Student List</th>

                                    </tr>
                                    <tr>
                                        <td>Tut-01</td>
                                        <td>KIT502</td>
                                        <td>Campus:</td>
                                        <td>PHP Content</td>
                                        <td>PHP Content</td>
                                        <td>PHP Content</td>
                                        <td>PHP Content</td>
                                        <td><a class="btn btn-link" data-toggle="modal" data-target="#view">View</a></td>
                                    </tr>
                                </table>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <script>
            $(document).ready(function() {
                $("#submitButton").on("click", function(event) {
                    event.preventDefault();
                    event1();
                    event2();
                });
                function event1(){
                    $("#search-form").hide();
                }
                function event2(){
                    $.post("search_results.inc.php", {user_input: $("#input").val()}, 
                           function(data){
                        $(".results-container").html(data);


                    });         


                }

            });


            $(document).ready(function(){
                
                $('#editable_table').Tabledit({
                    url:'action.inc.php',
                    columns:{
                        identifier:[0, "unit_id"],
                        editable:[[1, 'unit_code'], [2, 'unit_name'], [3, 'unit_semester'], [4, 'unit_campus'], [5, 'unit_coordinator', '<?php echo $user_json; ?>']]
                    },
                    restoreButton: false,
                    onSuccess: function(data, textStatus, jqXHR){
                        if(data.action=='delete'){
                            $('#'+data.id).remove();
                        }                       
                    }
                }); 
            });

            $(document).ready(function() {
                $("#addButton").click(function() {
                    var inputCode = $("#inputCode").val();
                    var inputName = $("#inputName").val();                    
                    var inputSem = $("#inputSem").val();
                    var inputUC = $("#inputUC").val();
                    var inputCamp = $("#inputCamp").val();
                    
                    if (inputCode == '' || inputName == '' || inputSem == '' || inputCamp == '' || inputUC == '') {
                        alert("Insertion Failed Some Fields are Blank....!!");
                    } else {
                        // Returns successful data submission message when the entered information is stored in database.
                        $.post("insert.inc.php", {
                            inputCode1: inputCode,
                            inputName1: inputName,                            
                            inputSem1: inputSem,
                            inputUC1: inputUC,                            
                            inputCamp1: inputCamp
                            
                        }, function(data) {
                            alert(data);
                            $('#add-form')[0].reset(); // To reset form fields
                        });
                    }
                });
            });
            $(document).ready(function() {
                $("#add_lec_buttonInModal").click(function() {
                    var inputCode = $("#lecture_unit").val();
                    var inputLec = $("#lecturer_lecturer").val();
                    var inputTime = $("#lecture_time").val();
                    var inputLecDay = $("#lecture_day").val();

                    if (inputCode == '' || inputLec == '' || inputTime == '' || inputLecDay == '') {
                        alert("Add Lecture: Insertion Failed Some Fields are Blank....!!");
                    } else {
                        // Returns successful data submission message when the entered information is stored in database.
                        $.post("insertLecture.inc.php", {
                            inputCode1: inputCode,                            
                            inputLec1: inputLec,                            
                            inputTime1: inputTime,                            
                            inputLecDay1: inputLecDay
                        }, function(data) {
                            alert(data);
                            $('#add_lecture_form')[0].reset(); // To reset form fields
                        });
                    }
                });
            });
            
            $(document).ready(function(){

                $('#editable_lec_table').Tabledit({
                    url:'action_edit_lec.inc.php',
                    columns:{
                        identifier:[0, "unit_id"],
                        editable:[[5, 'unit_lecturer', '<?php echo $user_json; ?>'], [6, 'lecture_day'], [7, 'lecture_time']]
                    },
                    restoreButton: false,
                    onSuccess: function(data, textStatus, jqXHR){
                        if(data.action=='delete'){
                            //$('#'+data.id).remove();
                            
                        }                       
                    }
                }); 
            });

        </script>
    </body>
</html>

