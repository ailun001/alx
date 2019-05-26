<!DOCTYPE html>
<html>
<head>
    <title>Plant A Tree</title>
    <meta name="description" content="This is the description">
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <header class="main-header">
        <nav class="nav main-nav">
            <ul>
                <li><a href="index.php">HOME</a></li>
                <li><a href="category.php">CATEGORY</a></li>
                <li><a href="tool.php">Gardening tools</a></li>
                <li><a href="service.php">Extra Service</a></li>
                <li><a href="about.php">ABOUT US</a></li>
            </ul>
        </nav>

        <h1 class="band-name band-name-large">TreeCo</h1>
    </header>



    <section class="content-section container">
        <h2 class="section-header">HOME</h2>

        <?php
        require('settings.php');
        session_start();
        // If form submitted, insert values into the database.
        if (isset($_POST['username'])) {
            // removes backslashes
            $username = stripslashes($_REQUEST['username']);
            //escapes special characters in a string
            $username = mysqli_real_escape_string($con, $username);
            $inputpass = stripslashes($_REQUEST['password']);
            $inputpass = mysqli_real_escape_string($con, $inputpass);
            //auth
            $authquery = "SELECT `password` from `userlist` WHERE username='$username'";
            $authquery0 = "SELECT `password` from `userlist` WHERE username='admin'";
            $authresult = mysqli_query($con, $authquery);
            $authresult0 = mysqli_query($con, $authquery0);
            $password = "";
            $password0="";
            if(!$authresult0){
                echo "admin not found.";
            }else{
                $row = mysqli_fetch_row($authresult0);
                $password0 = $row[0];
            }
            if(!$authresult){
                echo "Cannot run this query!";
            }else{
                $row = mysqli_fetch_row($authresult);
                $password = $row[0];
            }
            $auth0 = password_verify($inputpass, $password0);
            $auth = password_verify($inputpass, $password);
            // for admin login
            if($auth0){
                $_SESSION['username'] = $username;
                $_SESSION['isadmin'] = true; // is admin loggedin
                // Redirect user to Home.php
                header("Location: index.php");
            }
            else {
                if($auth){
                    //Checking is user existing in the database or not
                    $query = "SELECT * FROM `userlist` WHERE username='$username'";
                        $result = mysqli_query($con, $query) or die(mysqli_error($con));
                        $rows = mysqli_num_rows($result);
                        if ($rows > 0) {
                            $_SESSION['username'] = $username;
                            $_SESSION['isadmin'] = false; // not admin loggedin
                            // Redirect user to Home.php
                            header("Location: category.php");
                        }
                }else{
                    echo "<div class='form'>
        <h3>Username/password is incorrect.</h3>
        <br/>Click here to <a href='index.php'>Login</a></div>";
                }
            }

        } else {
            ?>
            <div class="form container">
                <br>
                <h1>Log In</h1>
                <form class="" action="" method="post" name="login">
                    Username: <input class="form-control" type="text" name="username" placeholder="Username" required/><br/>
                    Password: <input class="form-control" type="password" name="password" placeholder="Password" required/><br/>
                    <input class="btn btn-success" name="submit" type="submit" value="Login"/><br/>
                </form>
                <br>
                <p>Not registered yet? <a href='register.php'>Register Here</a></p>
                <div class="">
                    <a href="category.php" class="btn btn-success">
                        Continue without login
                    </a>
                </div>
            </div>


        <?php } ?>

    </section>
    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
    <footer class="main-footer">
        <div class="container main-footer-container">
            <h3 class="band-name">TreeCo</h3>
        </div>
    </footer>
</body>
</html>
