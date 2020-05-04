<html>
    <head>
        <title>Registration</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

        <link rel="stylesheet" type="text/css" href="CSS/formStyle1.css">
    </head>
    <body>
        <main>
            <div class="container">

                <a type="button" class="btn btn-link" href="homepage_UWD.php">Back to Homepage</a>
                <section class="section-default">
                    <h1>Sign Up</h1>
                    <p>Please fill in this form to create an account.</p>
                    <hr>
                    <form action="includes/signup.inc.php" method="POST">

                        <label for="name"><b>Full Name</b></label>
                        <input type="text" placeholder="Your Name.." name="uid" required>
                        <label for="userID"><b>User ID</b></label>

                        <input type="text" placeholder="ex. 12345" name="id" required>
                        <label for="Role"><b>I am a</b></label>
                        <select name="role" id="users">
                            <option value="">Select</option>
                            <option value="staff">Staff</option>
                            <option value="student">Student</option>
                        </select>
                        <div class="staff">
                            <label for="Position"><b>Highest Academic Qualification</b></label>
                            <select name="academicQual" id="users">
                                <option value="Bachelors">Bachelors Degree</option>
                                <option value="Masters">Masters Degree</option>
                                <option value="PhD">PhD</option>
                                <option value="Other">Other</option>
                            </select>
                            <label for="expertise"><b>Expertise</b></label>
                            <textarea name="expertise" rows="5" cols="90"></textarea>

                        </div>
                        <label for="email"><b>Email</b></label>
                        <input type="text" placeholder="Enter Email" name="mail" id= "email" required>

                        <label for="pwd"><b>Password</b></label>
                        <input type="password" placeholder="Enter Password" name="pwd" id= 'pass' required>
                        <br/>
                        <label for="pwd-repeat"><b>Confirm Password</b></label>
                        <input type="password" placeholder="Repeat Password" name="pwd-repeat" id="confpass" required>
                        <br/>
                        <button type="submit" class="signup-submit" name="signup-submit">Sign Up</button>


                    </form>
                </section>
            </div>
        </main>
        <script>
            $(document).ready(function() {
                $('.signup-submit').click(function(event){
                    data = $('#pass').val();
                    inp=$("#confpass").val();
                    var length=inp.length;
                    var len = data.length;
                    if(len < 1) {
                        alert("Password cannot be blank");
                        // Prevent form submission
                        event.preventDefault();
                    }
                    if(length<1){
                        alert("Please Confirm Your Password");
                        // Prevent form submission
                        event.preventDefault();
                    }
                    else if(data!=inp) {
                        alert("Password and Confirm Password don't match");
                        // Prevent form submission
                        event.preventDefault();
                    }
                });
            });
            $(document).ready(function(){
                // set initially button state hidden
                //$('.signupbtn').hide();
                // use keyup event on email field
                $("#email").keyup(function(){
                    if(validateEmail()){
                        // if the email is validated
                        // set input email border green
                        $("#email").css("border","2px solid green");

                    }
                    else{
                        // if the email is not validated
                        // set border red
                        $("#email").css("border","2px solid red");

                    }

                });
                // use keyup event on password
                $("#pass").keyup(function(){
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
                var email=$("#email").val();
                // use reular expression
                var reg = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/
                if(reg.test(email)){
                    return true;
                }else{
                    return false;
                }

            }
            function validatePassword(){
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


            $(document).ready(function(){
                $("#users").change(function(){
                    $(this).find("option:selected").each(function(){
                        var optionValue = $(this).attr("value");
                        if(optionValue){
                            $(".staff").not("." + optionValue).hide();
                            $("." + optionValue).show();
                        }
                        else{
                            $(".staff").hide();
                        }
                    });
                }).change();
            });

        </script>

    </body>
</html>