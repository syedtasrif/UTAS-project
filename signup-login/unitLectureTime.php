<?php
include('db_conn.php'); //db connection
?>
<html>
    <head>
        <title>Unit Lecture Details</title>
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
        <style>
            body {
                padding-top: 70px;
                padding-bottom:100px;
                background-image: url();
                background-repeat: no-repeat;
                background-position: right;

            }
            .jumbotron{            
                background: url(Images/jumbo1.jpg) no-repeat center center;
                -webkit-background-size: 100% 100%;
                -moz-background-size: 100% 100%;
                -o-background-size: 100% 100%;
                background-size: 100% 100%;
                color:green;
            }
            input[type=text] {
                width: 130px;
                box-sizing: border-box;
                border: 2px solid #ccc;
                border-radius: 4px;
                font-size: 16px;
                background-color: white;
                padding: 12px 20px 12px 40px;
                -webkit-transition: width 0.4s ease-in-out;
                transition: width 0.4s ease-in-out;
            }

            input[type=text]:focus {
                width: 100%;
            }
            .col-sm-8{
                background-color: azure;
                color: cadetblue;
            }
            table, th, td {
                color: cadetblue;
                font-size: 16px;        
            }            
        </style>
    </head>
    <body>

<!------------------------------------------------------------------Navigation Bar---------------------------------------------------------------------->
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
                        <li><a href="homepage_UWD.php">Home</a></li>
                    </ul>

                </div>

            </div>
        </div>
        <div class="container-fluid">
            <div class="jumbotron text-center">
                <h1>Welcome</h1>
                <h2>Experience Australia in Wonderland</h2>    
                <p class="lead">
                    <a class="btn btn-primary btn-primary" href="register.php">Register</a>    
                </p>

            </div>
        </div>
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
        <div class="container my-container">
            <div class="row">
                <div class="col-sm-4">
                    <h3><span class="glyphicon glyphicon-filter" aria-hidden="true"></span>Filter Unit Code</h3>

                    <form>
                        <input type="text" id="myInput" name="search" placeholder="Code.." onkeyup="myFunction()">
                    </form>
                    <ul id="myUL">
                        <?php
                        $sql= "SELECT * FROM units LEFT JOIN users ON units.unit_lecturer = users.user_id ORDER BY units.unit_id DESC;";
                        $result= mysqli_query($conn, $sql);
                        while($row=mysqli_fetch_assoc($result)){
                            echo "<li><a>".$row["unit_code"]." ".$row["unit_semester"]." Campus: ".$row["unit_campus"]."</a></li>";
                        }
                        ?>
                    </ul>
                </div>
                <div class="col-sm-8">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
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
        </div>
        <script>
            function myFunction() { //filter javascript plugins for the available units used for decorative purpose only in this assignemnt
                var input, filter, ul, li, a, i, txtValue;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                ul = document.getElementById("myUL");
                li = ul.getElementsByTagName("li");
                for (i = 0; i < li.length; i++) {
                    a = li[i].getElementsByTagName("a")[0];
                    txtValue = a.textContent || a.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        li[i].style.display = "";
                    } else {
                        li[i].style.display = "none";
                    }
                }
            }
        </script>
    </body>       
</html>