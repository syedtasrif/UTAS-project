<html>
    <head>
        <title>Registration</title>
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

       <link rel="stylesheet" type="text/css" href="CSS/formStyle1.css">
    </head>
    <body>
        <main>
            <div class="form-group">
                <img src="Images/avatar.png" class="avatar">
                
                <section class="section-default">
                    <h2>Sign Up</h2>
                    <p>Please fill in this form to create an account.</p>
                    <hr>
                    <form action="includes/signup.inc.php" method="POST">

                        <label for="name"><b>Full Name</b></label>
                        <input type="text" placeholder="Your Name.." name="uid" class="form-control" required>
                        <br/>
                        <label for="Role"><b>I am a</b></label>
                        <select name="role" id="roles" class="form-control">
                            <option value="">Select</option>
                            <option value="staff">Staff</option>
                            <option value="student">Student</option>
                        </select>
                        <br/>
                        <div class="staff">
                            <label for="Position"><b>Highest Academic Qualification</b></label>
                            <select name="academicQual" id="qualification" class="form-control">
                                <option value="">Select</option>
                                <option value="Bachelors">Bachelors Degree</option>
                                <option value="Masters">Masters Degree</option>
                                <option value="PhD">PhD</option>
                                <option value="Other">Other</option>
                            </select>
                            <br/>
                            <label for="expertise"><b>Expertise</b></label>
                            <input type="text" class="form-control" placeholder="Expert In.." name="expertise"  id= "user_expertise">
                            <br/>
                        </div>
                        <label for="email"><b>Email</b></label>
                        <input type="text" placeholder="Enter Email" name="mail" id= "email" class="form-control" required>
                        <br/>
                        <label for="pwd"><b>Password</b></label>
                        <input type="password" placeholder="Password minimum 6 letters including special characters digits and capital letters" name="pwd" id= 'pass' class="form-control" required>
                        <br/>
                        <label for="pwd-repeat"><b>Confirm Password</b></label>
                        <input type="password" placeholder="Repeat Password" name="pwd-repeat" id="confpass" class="form-control" required>
                        <br/>
                        <a type="button" class="btn btn-link pull-right" href="homepage_UWD.php">Back to Homepage</a>
                        <br/>
                        <input type="submit" class="signup-submit" name="signup-submit" value="Sign Up">


                    </form>
                </section>
            </div>
        </main>
        <script>
            $(document).ready(function() { //javascript triggering when clicked the signup button 
                $('.signup-submit').click(function(event){
                    data = $('#pass').val();
                    inp=$("#confpass").val(); //user input values in the form
                    var length=inp.length;
                    var len = data.length;
                    if(len < 1) {
                        alert("Password cannot be blank"); //password cannot be blank
                        // Prevent form submission
                        event.preventDefault();
                    }
                    if(length<1){
                        alert("Please Confirm Your Password"); //Repeated password cannot be blank
                        // Prevent form submission
                        event.preventDefault();
                    }
                    else if(data!=inp) {
                        alert("Password and Confirm Password don't match"); //if password and repeated password does not match
                        // Prevent form submission
                        event.preventDefault();
                    }
                });
            });
            $(document).ready(function(){

                $("#email").keyup(function(){
                    if(validateEmail()){
                        // if the email is validated
                        // set input email border green
                        $("#email").css("border","2px solid green"); //email validation front end check 

                    }
                    else{
                        $("#email").css("border","2px solid red");

                    }

                });
                // use keyup event on password
                $("#pass").keyup(function(){ //keyup function check for validation on a each key typed by the user
                    // check
                    if(validatePassword()){
                        // set input password border green
                        $("#pass").css("border","2px solid green");

                    }else{
                        // set input password border red
                        $("#pass").css("border","2px solid red");

                    }

                });
            });

            function validateEmail(){
                // get value of input email
                var email=$("#email").val(); //email input field validation
                // use reular expression
                var reg = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/
                if(reg.test(email)){
                    return true;
                }else{
                    return false;
                }

            }
            function validatePassword(){ //password frontend validation
                //get input password value
                var pass=$("#pass").val();
                // check it s length
                if(pass.length < 6){
                    return false;            
                }
                else if(pass.search(/[0-9]/)==-1){
                    return false;
                }
                else if(pass.search(/[a-z]/)==-1){
                    return false;
                }
                else if(pass.search(/[A-Z]/)==-1){
                    return false;
                }
                /*else if(pass.search(/[!\@\#\$\%\^]/)==-1){
                    return false;
                } */       
                else{
                    return true;
                }
            }  


            $(document).ready(function(){ //form options visibility based on user inputs
                $("#roles").change(function(){
                    $(this).find("option:selected").each(function(){
                        var optionValue = $(this).attr("value");
                        if(optionValue){
                            $(".staff").not("." + optionValue).hide();
                            $("." + optionValue).show();
                        }
                        else{
                            $(".staff").hide(); //hide() function is used to hide a div or an input field
                        }
                    });
                }).change();
            });

        </script>

    </body>
</html>