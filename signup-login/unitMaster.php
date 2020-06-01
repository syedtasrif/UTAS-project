<?php
session_start();
if(!isset($_SESSION['loggedin_id'])){
    header("Location: login.php?error=anonymousUser");    
}

if($_SESSION['user_role_allocated'] != 'admin') {
    header("Location: cms-dashboard.php?msg=accessdenied");    
}
?>
<?php
include('db_conn.php'); //db connection
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Master Unit Page</title>
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
                                        $user_json[$row['user_id']] = $row['user_name']; //json array to fetch the user name who can be UC and can be used later for edit table dropdowns
                                    }
                                    $user_json = json_encode($user_json); //parameter passing
                                    ?>
                                </select>

                                <br/>
                                <label>Unit Lecturer</label>

                                <select class="form-control" id="inputLec" name="unit_lecturer">
                                    <option value="">Choose</option>
                                    <?php
                                    $sql= "SELECT * FROM users WHERE user_role_allocated = 'Lecturer'";
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
                                    $(function () { //time pickeer javascript plugin function
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

<!--------------------------------------------------------- Search Modal for DC ----------------------------------------------------------------->

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

<!----------------------------------------------------------------Navigation---------------------------------------------------------------------------->
        
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
                        <li><a href="#">Welcome, <?php //user name display of the person who just logged in 
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

<!-------------------------------------------------------------------Footer---------------------------------------------------------------------------->
        
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

<!------------------------------------------------------------------Dashboard------------------------------------------------------------------------->

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
                            <a href="unitMaster.php" class="active list-group-item"><span class="glyphicon glyphicon-list" aria-hidden="true"></span>Unit List (Master))<span class="badge">1</span></a>
                            <?php } ?>
                            
                            <a href="userProfile.php" class="list-group-item"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>User Profile<span class="badge">3</span></a>
                        </div>

<!-------------------------------------------------------------Just for visualization------------------------------------------------------------------->
                        
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
<!-------------------------------------------------------------------------Content---------------------------------------------------------------------->
                    <div class="col-md-9">
                        <div class="panel panel-default">
                            <div class="panel-heading main-color-bg">
                                <h3 class="panel-title">Units List</h3>
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


                                        <?php //Table display for all the units with unit-coordinator names and the admin will be able to edit it
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


                    </div>
                </div>
            </div>
        </section>
        
        <script>
            $(document).ready(function() { //search modal form submit will trigger this function to work
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


            $(document).ready(function(){ //edit table plugin

                $('#editable_table').Tabledit({
                    url:'action.inc.php',
                    columns:{
                        identifier:[0, "unit_id"],
                        editable:[[1, 'unit_code'], [2, 'unit_name'], [3, 'unit_semester'], [4, 'unit_campus'], [5, 'unit_coordinator', '<?php echo $user_json; ?>']] // can edit all columns
                    },
                    restoreButton: false,
                    onSuccess: function(data, textStatus, jqXHR){
                        if(data.action=='delete'){
                            $('#'+data.id).remove();// delete unit 
                        }                       
                    }
                }); 
            });

            $(document).ready(function() {//unit modal form submit post variables
                $("#addButton").click(function() {
                    var inputCode = $("#inputCode").val();
                    var inputName = $("#inputName").val();                    
                    var inputSem = $("#inputSem").val();
                    var inputUC = $("#inputUC").val();
                    var inputCamp = $("#inputCamp").val();

                    if (inputCode == '' || inputName == '' || inputSem == '' || inputCamp == '' || inputUC == '') {//empty field check
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
        </script>
    </body>
</html>

