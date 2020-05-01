<html>
    <head>
        <title>
            Login Form
        </title>
        <link rel="stylesheet" type="text/css" href="CSS/formStyle.css">
        <body>
            <div class="loginbox">
                <img src="Images/avatar.png" class="avatar">
                <h1>Login Here</h1>
                <form action="includes/login.inc.php" method="POST">
                    <p>Username</p>
                    <input type="text" name="mailuid" placeholder="Enter Email Address/Username..">
                    <p>Password</p>
                    <input type="password" name="pwd" placeholder="Password">
                    <input type="submit" name="login-submit" value="Login">
                    <a href="#">Lost your password?</a><br>
                    <a href="register.php">Don't have an account?</a>
                    
                </form>
                
            </div>
            
        </body>
    </head>
</html>