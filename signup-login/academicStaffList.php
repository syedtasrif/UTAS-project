<?php
session_start(); //session start will bring the variables that has been created in login.inc.php page
if(!isset($_SESSION['loggedin_id'])){ //people won't be able to enter this page just by typing the url
    header("Location: login.php?error=anonymousUser");    
}

if($_SESSION['user_role_allocated'] != 'admin') { //only admin can enter this page
    header("Location: cms-dashboard.php?msg=accessdenied");    
}
?>
<?php
include('db_conn.php'); //db connection
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Master Staff List</title>
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

<!---------------------------------------------------------------- Add New Academic Staff Modal -------------------------------------------------------->

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
<!--                            Form submission will happen using post method-->
                            <form id="add-form" method="POST">

                                <label for="name"><b>Full Name</b></label>
                                <input type="text" placeholder="Your Name.." id="user_name" class="form-control" required>
                                <br/>
                                                    <!-- Role selection -->
                                <label for="Role"><b>Role</b></label> 
                                <select name="user_role" id="user_role" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="staff">Staff</option>
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
                        <!--once close button will be clicked, the page will be reloaded-->
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close" onclick="javascript:window.location.reload()">Close</button>
                    </div>
                </div>
            </div>
        </div>

<!-----------------------------------------Role Allocation Modal---------------------------------------------------------------------------------------->
        
        <div class="modal fade" id="insertNewStaffrole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel">Role Allocation</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <?php
                            $staffsql = "SELECT * FROM users WHERE  user_role != 'student' AND  user_role != 'admin'"; //filtering the admin and students
                            $staffresult = mysqli_query($conn, $staffsql);
                            ?>
                            <form id="add-form-role" method="POST">
                                <label for="Role"><b>Name</b></label>
                                <select name="user_name_role" id="user_name_role" class="form-control" required>
                                    <option value="">Select</option>
                                    <?php
                                    while($row = mysqli_fetch_assoc($staffresult)) {
                                    ?>
                                    <option value="<?php echo $row['user_id'];?>"><?php echo $row['user_name'];?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <br/>
                                <label for="Role"><b>UC Role</b></label>
                                <select name="user_role_role" id="user_role_role" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="Unit Coordinator">UC</option>
                                </select>
                                <br/>
                                <label for="Role"><b>Others Role</b></label>
                                <select name="user_role_allocated" id="user_role_allocated" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="Lecturer">Lecturer</option>
                                    <option value="Tutor">Tutor</option>
                                </select>
                                <br/>
                                <button type="submit" class="btn btn-success" id="addStaffButtonrole" name="addStaffButtonrole">Insert Role</button>


                            </form>
                        </div>

                    </div>
                    <div class="modal-footer">
                            <!-------------------------------------Page reload once press closed------------------------------------------------>
                        
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close" onclick="javascript:window.location.reload()">Close</button> 
                    </div>
                </div>
            </div>
        </div>

<!-----------------------------------------------------------------------------Navigation--------------------------------------------------------------->

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
<!-- Navigation bar buttons               -->
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a href="homepage_UWD.php">Home</a></li>
                        <li><a href="includes/logout.inc.php">Logout</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-left">
                        <li><a href="#">Welcome, <?php // one can see their name after login at hte navigation bar
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

<!-------------------------------------------------------------------------------Footer--------------------------------------------------------------->

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

<!------------------------------------------------------------------------------Dashboard--------------------------------------------------------------->
        
        <section id="main">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="list-group">
                            <a href="cms-dashboard.php" class="list-group-item main-color-bg">
                                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Dashboard
                            </a>
                                            <!--     Dashboard button option will appear based on acces level                       -->
                            <?php if($_SESSION['user_role_allocated'] == 'student') {?> 
                            <a href="enroll.php" class="list-group-item"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>Enroll<span class="badge">12</span></a>
                            <a href="timetable.php" class="list-group-item"><span class="glyphicon glyphicon-time" aria-hidden="true"></span>Individual Timetable<span class="badge">33</span></a>
                            <a href="tuteAllocate.php" class="list-group-item"><span class="glyphicon glyphicon-pushpin" aria-hidden="true"></span>Tutorial Allocation<span class="badge">203</span></a>
                            <?php } ?>

                            <?php if($_SESSION['user_role_allocated'] != 'student') {?>
                            <a href="unitManage.php" class="list-group-item"><span class="glyphicon glyphicon-list" aria-hidden="true"></span>Unit Management<span class="badge">197</span></a>
                            <?php } ?>

                            <?php if($_SESSION['user_role_allocated'] == 'admin') {?>
                            <a href="academicStaffList.php" class="active list-group-item"><span class="glyphicon glyphicon-list" aria-hidden="true"></span>Academic Staff (Master)<span class="badge">197</span></a>
                            <a href="unitMaster.php" class="list-group-item"><span class="glyphicon glyphicon-list" aria-hidden="true"></span>Unit List (Master))<span class="badge">1</span></a>
                            <?php } ?>
                            
                            <a href="userProfile.php" class="list-group-item"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>User Profile<span class="badge">3</span></a>
                        </div>

<!------------------------------------------------------------------------Just for visualization------------------------------------------------------>
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
<!-------------------------------------------------------------------------------Content---------------------------------------------------------------->
                    
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
                                        <th>Staff Unavailability</th>
                                        <th>Staff Email</th>
                                    </tr>
                                    <?php
                                    $sql= "SELECT * FROM users WHERE user_role != 'student'"; //selecting database table users and rows which are not students                    
                                    $result= mysqli_query ($conn, $sql);


                                    while($row=mysqli_fetch_assoc($result)){ //loop to display the rows based on the selection results
                                        echo "<tr><td>".$row["user_id"]."</td><td>".$row["user_name"]."</td><td>".$row["user_qualification"]."</td><td>".$row["user_expertise"]."</td><td>".$row["user_unavailability"]."</td><td>".$row["user_email"]."</td></tr>";
                                    }
                                    echo "</table>";                 

                                    ?>
                                </table>
                            </div>

                        </div>
<!---------------------------------------------------------------Modal activate button------------------------------------------------------------->
                        <a type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#insertNewStaff">Add New Staff</a> 
                        
 <!--------------------------------------------------------- Content for Role Allocation---------------------------------------------------------------->
                        
                        <div class="panel-heading main-color-bg">
                            <h3 class="panel-title">Staff Role Allocation</h3>                           
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" border="1px" id="editable_table_role">
                                    <tr>
                                        <th>ID</th>
                                        <th>Staff Name</th>
                                        <th>Staff Email</th>
                                        <th>UC Role</th>
                                        <th>Other Role</th>

                                    </tr>
                                    <?php
                                    $sql= "SELECT * FROM users WHERE user_role != 'student' AND  user_role != 'admin'";                    
                                    $result= mysqli_query ($conn, $sql);


                                    while($row=mysqli_fetch_assoc($result)){
                                        echo "<tr><td>".$row["user_id"]."</td><td>".$row["user_name"]."</td><td>".$row["user_email"]."</td><td>".$row["user_role"]."</td><td>".$row["user_role_allocated"]."</td></tr>";
                                    }
                                    echo "</table>";                 

                                    ?>
                                </table>
                            </div>

                        </div>
                        <a type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#insertNewStaffrole">Assign New Role</a>
                    </div>                  

                </div>
            </div>
        </section>
        
        <script>
            $(document).ready(function(){ //table edit plugin 
                $('#editable_table').Tabledit({
                    url:'academicStaffList_action.inc.php',
                    columns:{
                        identifier:[0, "user_id"], //will work according to id selection
                        editable:[[1, 'user_name'], [2, 'user_qualification'], [3, 'user_expertise'], [4, 'user_unavailability'], [5, 'user_email']]
                    }, //we can edit these columns
                    restoreButton: false,
                    onSuccess: function(data, textStatus, jqXHR){
                        if(data.action=='delete'){
                            $('#'+data.id).remove(); //deletion of rows
                        }                       
                    }
                }); 
            });


            $(document).ready(function(){
                $("#addStaffButton").click(function() { //fetching variables from the modal form
                    var user_name = $("#user_name").val(); //user input values
                    var user_pwd = $("#user_pwd").val();
                    var user_email = $("#user_email").val();
                    var user_expertise = $("#user_expertise").val();
                    var user_role = $("#user_role").val();
                    var user_qualification = $("#user_qualification").val();

                    if (user_name == '' || user_pwd == '' || user_email == '' || user_expertise == '' || user_role == '' || user_qualification == '') {
                        alert("Insertion Failed Some Fields are Blank....!!"); //check for empty fields
                    } else {
                        // Returns successful data submission message when the entered information is stored in database.
                        $.post("insertNewStaff.inc.php", {   //add staff button on modal will take user to this page and post variables                                        
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


                $("#addStaffButtonrole").click(function() {
                    var user_name = $("#user_name_role").val();
                    var user_role = $("#user_role_role").val();
                    var user_role_allocated = $("#user_role_allocated").val();

                    if (user_name == '' || (user_role == '' && user_role_allocated == '')) {
                        alert("Insertion Failed Some Fields are Blank....!!");
                    } else {
                        // Returns successful data submission message when the entered information is stored in database.
                        $.post("insertNewStaffRole.inc.php", {  //insertion of new staff role will happen in this page                                         
                            user_name1: user_name,
                            user_role1: user_role,
                            user_role_allocated: user_role_allocated                           
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
