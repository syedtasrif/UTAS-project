<html>
    <head>
        <title>Registration</title>

        <link rel="stylesheet" type="text/css" href="CSS/formStyle1.css">
    </head>

    <body>

        <main>
            <div class="wrapper-main">
                <section class="section-default">
                    <h1>Sign Up</h1>
                    <p>Please fill in this form to create an account.</p>
                    <hr>
                    <form action="includes/signup.inc.php" method="POST">
                        <label for="Role"><b>I am a</b></label>
                        <select name="role" id="users">
                            <option value="">Select</option>
                            <option value="staff">Staff</option>
                            <option value="student">Student</option>
                        </select>

                        <label for="name"><b>Username</b></label>
                        <input type="text" placeholder="Username..." name="uid">
                        <label for="userID"><b>User ID</b></label>
                        <input type="text" placeholder="ID.." name="id">
                        <label for="email"><b>Email</b></label>
                        <input type="text" placeholder="Enter Email" name="mail">
                        <label for="psw"><b>Password</b></label>
                        <input type="password" placeholder="Enter Password" name="pwd">
                        <label for="psw-repeat"><b>Confirm Password</b></label>
                        <input type="password" placeholder="Repeat Password" name="pwd-repeat">
                        <button type="submit" name="signup-submit">Sign Up</button>
                    </form>
                </section>
            </div>
        </main>


    </body>
</html>
