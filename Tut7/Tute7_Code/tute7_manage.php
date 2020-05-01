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
    <!-- add library-->
    
    <script src="jquery.tabledit.min.js"></script>
    </head>
    <body>
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

        <!--Content-->

        <div class ="container">
            <h3 align ="center">Manage Unit Details</h3>
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
                    $sql= "SELECT * FROM units ORDER BY id DESC;";                    
                    $result= mysqli_query($conn, $sql);


                    while($row=mysqli_fetch_assoc($result)){
                        echo "<tr><td>".$row["id"]."</td><td>".$row["unit_code"]."</td><td>".$row["unit_name"]."</td><td>".$row["lecturer"]."</td><td>".$row["semester"]."</td></tr>";
                    }
                    echo "</table>";                 

                    ?>
                </table>
            </div>
            <a type="button" class="btn btn-primary float-right" href="#">Add New Unit</a>

        </div>
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
                    $.post("tute7_view.inc.php", {user_input: $("#input").val()}, 
                           function(data){
                        $(".results-container").html(data);


                    });         


                }

            });
            
            $($document).ready(function(){
               $('.table').Tableedit({
                   url:'action.inc.php',
                   columns:{
                       identifier:[0, "id"],
                       editable:[[1, 'unit_code'], [2, 'unit_name'], [3, 'lecturer'], [4, 'semester']]
                   },
                   restoreButton: false,
                   onSuccess: function(data, textStatus, jqXHR){
                       if(data.action=='delete'){
                           $('#'+data.id).remove();
                       }                       
                   }
               }); 
            });
            

        </script>

    </body>  
</html> 

