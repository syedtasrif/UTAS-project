<?php
session_start();
if(!isset($_SESSION['loggedin_id'])){
    header("Location: login.php?error=anonymousUser");    
}

if($_SESSION['user_role_allocated'] == 'student') {
    header("Location: cms-dashboard.php?msg=accessdenied");    
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
<!-------------------------------------------- Add UC & Lec Modal popup for Department Coordinator use--------------------------------------------------->
        
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
                                $sql= "SELECT * FROM users WHERE user_role = 'Unit Coordinator'";
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
                                    $sql= "SELECT * FROM users WHERE user_role_allocated = 'Lecturer'";
                                    $result= mysqli_query($conn, $sql);
                                    $user1_json=array();
                                    while ($row =mysqli_fetch_array($result)){
                                        echo "<option value='".$row['user_id']."'>".$row['user_name']."</option>";
                                        $user1_json[$row['user_id']] = $row['user_name'];
                                    }
                                    $user1_json = json_encode($user1_json);
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

<!----------------------------------------------------------------- Search Modal for DC ----------------------------------------------------------------->
        
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
        
<!--------------------------------------------------------Modal for Student List View for Tutors -------------------------------------------------------->
        
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
                        <?php if($_SESSION['user_role_allocated'] == "Tutor") {?>
                        <div class="panel panel-default">
                            <?php
                        $sql= "SELECT student_id student_unit_id student_tutorial_id FROM student_unit 
                                                FULL OUTER JOIN units ON student_unit.student_unit_id = units.unit_id 
                                                FULL OUTER JOIN tutorials ON student_unit.student_tutorial_id = tutorials.tutorial_id
                                                INNER JOIN users ON student_unit.student_id = users.user_id
                                                WHERE users.user_id = ".$_SESSION['loggedin_id'].";";                    
                        $result= mysqli_query($conn, $sql);                               
                        if(mysqli_num_rows($result) != 0){

                            ?>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" border="1px" id="editable_student_table">

                                        <tr>
                                            <th>ID</th>
                                            <th>Student Name</th>
                                            <th>Unit</th>
                                            <th>Tutorial</th>
                                        </tr>

                                        <?php
                                        while($row=mysqli_fetch_assoc($result)){
                                            echo "<tr><td>".$row["auto_id"]."</td><td>".$row["user_name"]."</td><td>".$row["unit_code"]."</td><td>".$row["tuorial_name"]."</td></tr>";
                                        }
                                        echo "</table>";                 

                                        ?>
                                    </table>
                                </div>
                            </div>
                            <?php
                            } // end !empty if
                            else {
                            ?>
                            <div class="panel-body">
                                <p>No student enrolled</p>
                            </div>
                            <?php
                            }
                            ?>
                        </div>

                        <?php } ?>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

<!---------------------------------------------------------- Modal for creating tutorial class----------------------------------------------------------->
        
        <div class="modal fade" id="editTute" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel">Allocate Tutor</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <form id="add_tute_form" method="post">
                                <label>Tutorial Unit</label>
                                <select class="form-control" id="tutorial_unit" name="tutorial_unit">
                                    <option value="">Choose</option>
                                    <?php
                                    $sql= "SELECT units.*, D.user_name lecturer_name 
                                                    FROM units INNER JOIN users C ON units.unit_coordinator = C.user_id
                                                    INNER JOIN users D ON units.unit_lecturer = D.user_id

                                                    WHERE C.user_id = ".$_SESSION['loggedin_id']." OR
                                                          D.user_id = ".$_SESSION['loggedin_id']."
                                                    ORDER BY units.unit_id DESC;";
                                    $result= mysqli_query($conn, $sql);

                                    while ($row =mysqli_fetch_array($result)){
                                        echo "<option value='".$row['unit_id']."'>".$row['unit_code'].' '.$row['unit_campus'].' '.$row['unit_semester']."</option>";
                                    }
                                    ?>
                                </select>
                                <br/>
                                <label>Tutorial Name</label>
                                <input type="text" class="form-control" id="tutorial_name" name="tutorial_name">
                                <br/>
                                <label>Unit Tutor</label>
                                <select class="form-control" id="tutorial_tutor" name="tutorial_tutor">
                                    <option value="">Choose</option>
                                    <?php
                                    $sql= "SELECT * FROM users WHERE user_role_allocated = 'Tutor'";
                                    $result= mysqli_query($conn, $sql);
                                    $user2_json=array();
                                    while ($row =mysqli_fetch_array($result)){
                                        echo "<option value='".$row['user_id']."'>".$row['user_name']."</option>";
                                        $user2_json[$row['user_id']] = $row['user_name'];
                                    }
                                    $user2_json = json_encode($user2_json);
                                    ?>
                                </select> 
                                <br/>
                                <label>Tutorial Class Size</label>
                                <input type="text" class="form-control" id="tutorial_size" name="tutorial_size">
                                <br/>
                                <label>Tutorial Day</label>
                                <select class="form-control" id="tutorial_day" name="tutorial_day">
                                    <option value="">Choose</option>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                </select>
                                <br/>
                                <label>Tutorial Time</label>
                                <div class="form-group">
                                    <div class="input-group date" id="timepicker" data-target-input="nearest">
                                        <input type="text" id="tutorial_time" name="tutorial_time" class="form-control datetimepicker-input" data-target="#datetimepicker3"/>
                                        <span class="input-group-addon" data-target="#datetimepicker3" data-toggle="datetimepicker">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                                <script type="text/javascript">
                                    $(function () {
                                        $('#timepicker').datetimepicker({
                                            format: 'LT'
                                        });
                                    });
                                </script>
                                <br/>
                                <a type="submit" class="btn btn-success" name="add_tutor" id="add_tutor">Add Tutor</a>
                            </form>

                        </div>                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal" id="close" onclick="javascript:window.location.reload()">Close</button>
                    </div>
                </div>
            </div>
        </div>

<!-------------------------------------------------- Modal for Adding and Removing Student--------------------------------------------------------------->
        
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
        
<!--------------------------------------------------------- Modal for Allocating Lecturer---------------------------------------------------------------->
        
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
                                    $sql= "SELECT * FROM users WHERE user_role_allocated = 'Lecturer'";
                                    $result= mysqli_query($conn, $sql);
                                    $user1_json=array();
                                    while ($row =mysqli_fetch_array($result)){
                                        echo "<option value='".$row['user_id']."'>".$row['user_name']."</option>";
                                        $user1_json[$row['user_id']] = $row['user_name'];
                                    }
                                    $user1_json = json_encode($user1_json);
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

<!-------------------------------------------------------------------Navigation------------------------------------------------------------------------->
        
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
<!---------------------------------------------------------------------Footer-------------------------------------------------------------------------->
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
        
<!---------------------------------------------------------------Dashboard------------------------------------------------------------------------------->
        
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
                            <a href="unitManage.php" class="active list-group-item"><span class="glyphicon glyphicon-list" aria-hidden="true"></span>Unit Management<span class="badge">197</span></a>
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
                    
<!-------------------------------------------------------------------Content----------------------------------------------------------------------------->
                   
                    <div class="col-md-9">
    
                        
<!----------------------------------------------------------- Lecture Management Area--------------------------------------------------------------->
                        <?php if($_SESSION['user_role'] == "admin") {?>
                        <div class="panel panel-default">
                            <div class="panel-heading main-color-bg">
                                <h3 class="panel-title">Unit Lecture Management (DC Area)</h3>
                            </div>
                            <div class="panel-body">
                                
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
                        <?php } ?>
                        
                        
                        
                        <?php if($_SESSION['user_role'] == "Unit Coordinator") {?>


                        <div class="panel panel-default">
                            <div class="panel-heading main-color-bg">
                                <h3 class="panel-title">Unit Lecture Management (UC Area)</h3>
                            </div>
                            <?php
                            $sql= "SELECT units.*, D.user_name lecturer_name 
                                                    FROM units INNER JOIN users C ON units.unit_coordinator = C.user_id
                                                    INNER JOIN users D ON units.unit_lecturer = D.user_id

                                                    WHERE C.user_id = ".$_SESSION['loggedin_id']." ORDER BY units.unit_id DESC;";                    
                            $result= mysqli_query($conn, $sql);
//                           
                            if(mysqli_num_rows($result) != 0){

                            ?>
                            <div class="panel-body">

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
                                        while($row=mysqli_fetch_assoc($result)){
                                            echo "<tr><td>".$row["unit_id"]."</td><td>".$row["unit_code"]."</td><td>".$row["unit_name"]."</td><td>".$row["unit_semester"]."</td><td>".$row["unit_campus"]."</td><td>".$row["lecturer_name"]."</td><td>".$row["lecture_day"]."</td><td>".$row["lecture_time"]."</td></tr>";
                                        }
                                        echo "</table>";                 

                                        ?>
                                    </table>
                                </div>
                            </div>
                            <?php
                            } // end !empty if
                            else {
                            ?>
                            <div class="panel-body">
                                <p>NO Units</p>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                        
                        <?php } ?>

<!---------------------------------------------------------------- Tutorial Management Area------------------------------------------------------------->
                        
                        <?php if($_SESSION['user_role'] == "admin") {?>

                        
                        <div class="panel panel-default">
                            <div class="panel-heading main-color-bg">
                                <h3 class="panel-title">Unit Tutorial Management (DC)</h3>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <a type="button" class="btn btn-default pull-right" data-toggle="modal" data-target="#editTute">Add Tutorial</a>
                                    <table class="table table-striped table-hover" border="1px" id="editable_tute_table">
                                        <tr>
                                            <th>ID</th>
                                            <th>Tutorial Name</th>
                                            <th>Tutorial Tutor</th>
                                            <th>Tutorial Unit</th>
                                            <th>Tutorial Size</th>
                                            <th>Tutorial Day</th>
                                            <th>Tutorial Time</th>
                                        </tr>


                                        <?php
                                        $sql= "SELECT * FROM tutorials 
                                                LEFT JOIN units ON tutorials.tutorial_unit = units.unit_id 
                                                LEFT JOIN users ON tutorials.tutorial_tutor = users.user_id 
                                                ORDER BY tutorials.tutorial_id DESC;";                    
                                        $result= mysqli_query($conn, $sql);
                                        while($row=mysqli_fetch_assoc($result)){
                                            echo "<tr><td>".$row["tutorial_id"]."</td><td>".$row["tutorial_name"]."</td><td>".$row["user_name"]."</td><td>".$row["unit_code"]."</td><td>".$row["tutorial_size"]."</td><td>".$row["tutorial_day"]."</td><td>".$row["tutorial_time"]."</td></tr>";
                                        }
                                        echo "</table>";                 

                                        ?>



                                    </table>
                                </div>                           

                            </div>
                        </div>
                        <?php } ?>
                        <?php if($_SESSION['user_role'] == "Unit Coordinator") {?>
                        
                        
                        <div class="panel panel-default">
                            <div class="panel-heading main-color-bg">
                                <h3 class="panel-title">Unit Tutorial Management (UC Area)</h3>
                            </div>
                            <?php
                            $sql= "SELECT * FROM tutorials 
                                                LEFT JOIN units ON tutorials.tutorial_unit = units.unit_id 
                                                LEFT JOIN users ON tutorials.tutorial_tutor = users.user_id 
                                                WHERE units.unit_coordinator = ".$_SESSION['loggedin_id']." 
                                                OR units.unit_lecturer = ".$_SESSION['loggedin_id']."
                                                ORDER BY tutorials.tutorial_id DESC;";                    
                            $result= mysqli_query($conn, $sql);
                            if(mysqli_num_rows($result) != 0){

                            ?>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <a type="button" class="btn btn-default pull-right" data-toggle="modal" data-target="#editTute">Add Tutorial</a>
                                    <table class="table table-striped table-hover" border="1px" id="editable_tute_table">
                                        <tr>
                                            <th>ID</th>
                                            <th>Tutorial Name</th>
                                            <th>Tutorial Tutor</th>
                                            <th>Tutorial Unit</th>
                                            <th>Tutorial Size</th>
                                            <th>Tutorial Day</th>
                                            <th>Tutorial Time</th>
                                        </tr>


                                        <?php
                                        
                                        while($row=mysqli_fetch_assoc($result)){
                                            echo "<tr><td>".$row["tutorial_id"]."</td><td>".$row["tutorial_name"]."</td><td>".$row["user_name"]."</td><td>".$row["unit_code"]."</td><td>".$row["tutorial_size"]."</td><td>".$row["tutorial_day"]."</td><td>".$row["tutorial_time"]."</td></tr>";
                                        }
                                        echo "</table>";                 

                                        ?>



                                    </table>
                                </div>                        

                            </div>
                            <?php
                            } // end !empty if
                            else {
                            ?>
                            <div class="panel-body">
                                <p>NO Units</p>
                            </div>
                            <?php
                            }
                            ?>
                        </div>

                        <?php } ?>

                        <?php if($_SESSION['user_role_allocated'] == "Lecturer") {?>

                        <div class="panel panel-default">
                            <div class="panel-heading main-color-bg">
                                <h3 class="panel-title">Unit Tutorial Management (Lecturer Area)</h3>
                            </div>
                            <?php
                            $sql= "SELECT * FROM tutorials 
                                                LEFT JOIN units ON tutorials.tutorial_unit = units.unit_id 
                                                LEFT JOIN users ON tutorials.tutorial_tutor = users.user_id 
                                                WHERE units.unit_lecturer =  ".$_SESSION['loggedin_id']."
                                                ORDER BY tutorials.tutorial_id DESC;";                    
                            $result= mysqli_query($conn, $sql);
                            if(mysqli_num_rows($result) != 0){

                            ?>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <a type="button" class="btn btn-default pull-right" data-toggle="modal" data-target="#editTute">Add Tutorial</a>
                                    <table class="table table-striped table-hover" border="1px" id="editable_tute_table">
                                        <tr>
                                            <th>ID</th>
                                            <th>Tutorial Name</th>
                                            <th>Tutorial Tutor</th>
                                            <th>Tutorial Unit</th>
                                            <th>Tutorial Size</th>
                                            <th>Tutorial Day</th>
                                            <th>Tutorial Time</th>
                                        </tr>


                                        <?php
                                        $sql= "SELECT * FROM tutorials 
                                                LEFT JOIN units ON tutorials.tutorial_unit = units.unit_id 
                                                LEFT JOIN users ON tutorials.tutorial_tutor = users.user_id 
                                                WHERE units.unit_lecturer =  ".$_SESSION['loggedin_id']."
                                                ORDER BY tutorials.tutorial_id DESC;";                    
                                        $result= mysqli_query($conn, $sql);
                                        while($row=mysqli_fetch_assoc($result)){
                                            echo "<tr><td>".$row["tutorial_id"]."</td><td>".$row["tutorial_name"]."</td><td>".$row["user_name"]."</td><td>".$row["unit_code"]."</td><td>".$row["tutorial_size"]."</td><td>".$row["tutorial_day"]."</td><td>".$row["tutorial_time"]."</td></tr>";
                                        }
                                        echo "</table>";                 

                                        ?>



                                    </table>
                                </div>                           

                            </div>
                            <?php
                            } // end !empty if
                            else {
                            ?>
                            <div class="panel-body">
                                <p>NO Units</p>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                        <?php } ?>
                        
<!------------------------------------------------------------------ Tutor Area ----------------------------------------------------------------------->
                       
                        <?php if($_SESSION['user_role_allocated'] == "Tutor") {?>

                        <div class="panel panel-default">
                            <div class="panel-heading main-color-bg">
                                <h3 class="panel-title">Unit Tutorial Management (Tutor Area)</h3>
                            </div>
                            <div class="panel-body">
                                <td><a class="btn btn-link" data-toggle="modal" data-target="#view">View</a></td>
                                <table class="table table-striped table-hover" border="1px" id="tute_table">
                                    <tr>
                                        <th>ID</th>
                                        <th>Tutorial Name</th>
                                        <th>Tutorial Tutor</th>
                                        <th>Tutorial Unit</th>
                                        <th>Tutorial Size</th>
                                        <th>Tutorial Day</th>
                                        <th>Tutorial Time</th>
                                    </tr>
                                    <?php
                                    $sql= "SELECT * FROM tutorials 
                                                LEFT JOIN units ON tutorials.tutorial_unit = units.unit_id 
                                                LEFT JOIN users ON tutorials.tutorial_tutor = users.user_id 
                                                WHERE tutorials.tutorial_tutor = ".$_SESSION['loggedin_id']."
                                                ORDER BY tutorials.tutorial_id DESC;";                    
                                    $result= mysqli_query($conn, $sql);
                                    while($row=mysqli_fetch_assoc($result)){
                                        echo "<tr><td>".$row["tutorial_id"]."</td><td>".$row["tutorial_name"]."</td><td>".$row["user_name"]."</td><td>".$row["unit_code"]."</td><td>".$row["tutorial_size"]."</td><td>".$row["tutorial_day"]."</td><td>".$row["tutorial_time"]."</td></tr>";
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
        </section>
        
<!-----------------------Javascript pluggins column edit and modal form submit codes-------------------------------------------------------------------->        
        
        <script>

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
                        editable:[[5, 'unit_lecturer', '<?php echo $user1_json; ?>'], [6, 'lecture_day'], [7, 'lecture_time']]
                    },
                    restoreButton: false,
                    onSuccess: function(data, textStatus, jqXHR){
                        if(data.action=='delete'){
                            //$('#'+data.id).remove();
                            
                        }                       
                    }
                }); 
            });
            
            $(document).ready(function() {
                $("#add_tutor").click(function() {
                    var tutorial_name = $("#tutorial_name").val();
                    var tutorial_unit = $("#tutorial_unit").val();
                    var tutorial_tutor = $("#tutorial_tutor").val();
                    var tutorial_size = $("#tutorial_size").val();
                    var tutorial_day = $("#tutorial_day").val();
                    var tutorial_time = $("#tutorial_time").val();

                    if (tutorial_name == '' || tutorial_unit == '' || tutorial_tutor == '' || tutorial_size == '' || tutorial_day == '' || tutorial_time == '') {
                        alert("Add Lecture: Insertion Failed Some Fields are Blank....!!");
                    } else {
                        // Returns successful data submission message when the entered information is stored in database.
                        $.post("insertTutor.inc.php", {
                            tutorial_name1: tutorial_name,                            
                            tutorial_unit1: tutorial_unit,                            
                            tutorial_tutor1: tutorial_tutor,                            
                            tutorial_size1: tutorial_size,
                            tutorial_day1: tutorial_day,
                            tutorial_time1: tutorial_time
                        }, function(data) {
                            alert(data);
                            $('#add_tute_form')[0].reset(); // To reset form fields
                        });
                    }
                });
            });
            
            $(document).ready(function(){

                $('#editable_tute_table').Tabledit({
                    url:'action_edit_tute.inc.php',
                    columns:{
                        identifier:[0, "tutorial_id"],
                        editable:[[1, 'tutorial_name'], [2, 'tutorial_tutor', '<?php echo $user2_json; ?>'], [4, 'tutorial_size'], [5, 'tutorial_day'], [6, 'tutorial_time']]
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

