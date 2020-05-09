<!DOCTYPE html>
<html lang="en">
<head>
  <title>Student Area | Dashboard</title>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"> 
    <link rel="stylesheet" href="CSS/dashboard.css">
    <style> 
        
    </style>
    
</head>
    <body>
        <!-- Modal -->
<div class="modal fade" id="check" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Check Availability</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <h4>Select Semester:</h4>
       <div class="form-group">
    <select class="custom-select" required>
      <option value="">Choose</option>
      <option value="1">Semester 1</option>
      <option value="2">Semester 2</option>
      <option value="3">Spring School</option>
        <option value="3">Winter School</option>
           </select>
          </div>
          <h4>Select Campus:</h4>
       <div class="form-group">
    <select class="custom-select" required>
      <option value="">Choose</option>
      <option value="1">Pandora</option>
      <option value="2">Rivendell</option>
      <option value="3">Neverland</option>
           </select>
          </div>

        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Submit</button>
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
              <li><a href="homepage_UWD.html">Home</a></li>
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
              <li><a href="login.html">Logout</a></li>
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
              <a href="enroll.html" class="active list-group-item"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>Enroll<span class="badge">12</span></a>
              <a href="timetable.html" class="list-group-item"><span class="glyphicon glyphicon-time" aria-hidden="true"></span>Individual Timetable<span class="badge">33</span></a>
              <a href="tuteAllocate.html" class="list-group-item"><span class="glyphicon glyphicon-pushpin" aria-hidden="true"></span>Tutorial Allocation<span class="badge">203</span></a>
            <a href="unitManage.html" class="list-group-item"><span class="glyphicon glyphicon-list" aria-hidden="true"></span>Unit Management<span class="badge">197</span></a>
            <a href="academicStaffList.html" class="list-group-item"><span class="glyphicon glyphicon-list" aria-hidden="true"></span>Academic Staff (Master)<span class="badge">197</span></a>
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
                <h3 class="panel-title">Units Available</h3>
              </div>
                  <div class="panel-body">
                      <div class="row">
                      <div class="col-md-12">
                          <button type="button" class="btn btn-success btn-sm pull-right">Save</button>
                      </div>
                </div>
                <br>
                      <table class="table table-striped table-hover">
                      <tr>
                        <th>Unit Code</th>
                        <th>Name</th>
                        <th>Detail</th>
                        <th>Availability</th>  
                        <th>Availability Status</th>
                        <th></th>
                      </tr>
                      <tr>
                        <td>PHP Content</td>
                        <td>PHP Content</td>
                        <td><a class="btn btn-link" href="unitdetails.html">Details</a></td> 
                        <td><a class="btn btn-link" href="unitdetails.html" data-toggle="modal" data-target="#check">Check</a></td>  
                        <td><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></td>
                        
                        <td><a class="btn btn-success" href="#">Enroll</a> <a class="btn btn-danger" href="#">Withdraw</a></td>
                      </tr>

                    </table>
                  </div>
              </div>
  
              
          </div>
        </div>
      </div>
    </section>
    </body>
</html>
    
