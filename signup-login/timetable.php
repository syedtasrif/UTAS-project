<?php
session_start();
if(!isset($_SESSION['loggedin_id'])){
    header("Location: login.php?error=anonymousUser");    
}

include('db_conn.php'); //db connection
include('datebyday.php'); //db connection

$std_tut = "SELECT * FROM student_unit A 
            INNER JOIN tutorials B ON A.student_tutorial_id = B.tutorial_id 
            INNER JOIN units C ON A.student_unit_id = C.unit_id 

            WHERE A.student_id = " . $_SESSION['loggedin_id'];

$result= mysqli_query($conn, $std_tut);
$calender_arr = array();
while($row=mysqli_fetch_assoc($result)){

    foreach($dateofdays[$row['tutorial_day']] as $days) {
        $calender_arr[] = array(
            'title' => $row['tutorial_name'] . ' ' . $row['unit_name'],
            'start' => $days . 'T' . date("H:i", strtotime($row['tutorial_time'])),
            'backgroundColor' => 'green'
        );
    }

    foreach($dateofdays[$row['lecture_day']] as $days) {
        $calender_arr[] = array(
            'title' => 'Lecture: ' . $row['unit_name'],
            'start' => $days . 'T' . date("H:i", strtotime($row['lecture_time'])),
            'backgroundColor' => 'blue'
        );
    }
}
$calender_arr = json_encode($calender_arr);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Individual Timetable</title>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"> 
    <link href="CSS/dashboard.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <style> 
        
    </style>
    
</head>
    <body>
<!------------------------------------------------------------------Navigation------------------------------------------------------------------------->
        
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
              <li><a href="homepage_UWD.html">Home</a></li>

              <li><a href="includes/logout.inc.php">Logout</a></li>
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
<!------------------------------------------------------------------------------Footer----------------------------------------------------------------->
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
<!----------------------------------------------------------------------------Dashboard---------------------------------------------------------------->
        <section id="main">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="list-group">
                            <a href="cms-dashboard.php" class="list-group-item main-color-bg">
                                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Dashboard
                            </a>
<!--------------------------------------------------------------Dashboard button visibility based on user access level---------------------------------->
                            
                            <?php if($_SESSION['user_role_allocated'] == 'student') {?>
                            <a href="enroll.php" class="list-group-item"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>Enroll<span class="badge">12</span></a>
                            <a href="timetable.php" class="active list-group-item"><span class="glyphicon glyphicon-time" aria-hidden="true"></span>Individual Timetable<span class="badge">33</span></a>
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
<!--------------------------------------------------------------------------Just for visualization----------------------------------------------------->
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
                    
<!----------------------------------------------------------------------Content----------------------------------------------------------------------->
                    <div class="col-md-9">
                        <div class="panel panel-default">
                            <div class="panel-heading main-color-bg">
                                <h3 class="panel-title">Your schedule</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                          
                                    </div>
                                </div>
                                <br>
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <script>
            //scheduling calender plugins
            $(document).ready(function() {
                var jscalender_arr = '<?php echo $calender_arr; ?>';
                var parsearr = JSON.parse(jscalender_arr);
                console.log(parsearr);
                var calendar = $('#calendar').fullCalendar({
                    editable:true,
                    header:{
                        left:'prev,next today',
                        center:'title',
                        right:'month,agendaWeek,agendaDay'
                    },
                    
                    events: parsearr,
                    
                    

                });
            });
        </script>
    </body>
</html>
    
