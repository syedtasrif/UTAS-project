<!DOCTYPE html>
<html lang="en">
<head>
    <title>UDW</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">   
    <style>
        .jumbotron{
            background: url(Images/jumbo1.jpg);
            background-size: 100% 100%;
            color:green;
        }
        body {
            padding-top: 70px;
            padding-bottom:100px;
        }
        /*Style to make all the images in thumbnail of equal size*/
        .thumbnail img {    
            height:250px;
            width:100%;
        }
    </style>
    
</head>
    
<body>
    
<!----------------------------------------------------------------------Navigation-------------------------------------------------------------------->
    
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
              <li><a href="login.php">Login</a></li>
          </ul>
      </div>
    </div>
</div>
    
<!------------------------------------------------------------------------Footer------------------------------------------------------------------------>
    
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
    
<!-------------------------------------------------------------------------Jumbotron-------------------------------------------------------------------->
    
    <div class="container-fluid">
        <div class="jumbotron text-center">
            <h1>Welcome</h1>
            <h2>Experience Australia in Wonderland</h2>    
            <p class="lead">
                <a class="btn btn-primary btn-primary" href="register.php" role="button">Register</a>    
            </p>
        </div>
    </div>
    
 <!-----------------------------------------------------------Thumbnail used in bootstrap 3.4.1 container---------------------------------------------> 
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="thumbnail">
                <img src="Images/enrol.jpg" alt="Theme 2"></a>
                <h3>Unit Enrollment</h3>
                <p></p>
                <a href="login.php" class="btn btn-info">Enter</a>
                <p></p>
            </div>
            <div class="col-md-6">
                <a href="#" class="thumbnail">
                <img src="Images/Time.jpg" alt="Theme 3"></a>
                <h3>Timetable</h3>
                <p></p>
                <a class="btn btn-info" href="unitLectureTime.php">Enter</a>
            </div>
        </div>
    </div>
    </body>
</html>