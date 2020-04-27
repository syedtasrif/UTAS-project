<?php
include('db_conn.php'); //db connection

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
     <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- Link to use icon-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script> 
    </head>
    <body>
        <!-- Modal popup -->
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
                            <form action="tute7_view.php" method="get">
                            <label>Search</label>
                            <input type="text" class="form-control">
                            <br>
                            <label><a type="submit" class="btn btn-warning" name="search" onclick="searchResults()">Search</a></label>
                            </form>
                        </div>                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!--Content-->
        
        <div class ="container">
            <h3 align ="center">Unit Details</h3>
            <a type="button" class="btn btn-link" href="tute7_main.php">Back to the Main</a>
            <a type="button" class="btn btn-light float-right" data-toggle="modal" data-target="#search">Search</a>
            <div class="table-responsive">
                <table class="table table-striped table-hover" border="1px">
                    <tr>
                        <th>ID</th>
                        <th>Unit Code</th>
                        <th>Unit Name</th>
                        <th>Lecturer</th>
                        <th>Semester</th>
                    </tr>
                    <?php
                    $sql= "SELECT * FROM units;";                    
                    $result= mysqli_query($mysqli, $sql);
                    $resultCheck=mysqli_num_rows($result);
                    if($resultCheck>0){
                        while($row=mysqli_fetch_assoc($result)){
                            echo "<tr><td>".$row["id"]."</td><td>".$row["unit_code"]."</td><td>".$row["unit_name"]."</td><td>".$row["lecturer"]."</td><td>".$row["semester"]."</td></tr>";
                        }
                        echo "</table>";
                        
                    }
                    else{
                        echo "0 result";
                    }
                    $mysqli->close();
                    ?>
                </table>
            </div>
        </div>
    </body>  
</html>  
