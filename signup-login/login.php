<html>
    <head>
        <title>
            Login Form
        </title>
                        <!--CSS page to style the login page-->
        <link rel="stylesheet" type="text/css" href="CSS/formStyle.css">
        <body>
            <div class="loginbox">
                <img src="Images/avatar.png" class="avatar">
                <h1>Login Here</h1>
                <form action="includes/login.inc.php" method="POST">
                    <p>Email</p>
                    <input type="text" name="email" placeholder="Enter Email Address..">
                    <p>Password</p>
                    <input type="password" name="pwd" placeholder="Password">
                    <input type="submit" name="login-submit" value="Login">
                    <a href="homepage_UWD.php">Back to Main</a><br>
                    <a href="register.php">Don't have an account?</a>
                    
                </form>
                
            </div>
            
        </body>
    </head>
</html>