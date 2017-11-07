<html lang="en">
    <head>
        <title>New Breath</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </head>
    <body>

        <nav class="navbar navbar-default navbar-static-top ">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php" style="padding: 7px"><img src="img/logo.png" style="height: 100%"/></a>
                    <a class="navbar-brand">New Breath</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="asthma.php">About Asthma</a></li>
                        <li><a href="current.php">Air Quality</a></li>
                        <li><a href="event.php">Event</a></li>
                        <li  class="active"><a href="user_login.php">Journal</a></li>
                        <li><a href="aboutus.php">About Us</a></li>
                    </ul>

                </div>
            </div>
        </nav>

        <div class="container-fluid Login_second_div" style="padding: 0">
            <div class="col-sm-2"></div>
            <div class="col-sm-4 Login_table">

                <?php
                //variables to keep the content of the form elements.
                $userName = "";
                $password = "";
                //variables to keep the error message to each information inserted
                $userNameErr = "";
                $passwordErr = "";
                $existance_check_Err = "";

                $fetch_username = "0";
                $fetch_password = "0";
                $fetch_userid = "0";
                $fetch_name = "0";
                $fetch_lastname = "0";

                if ($_SERVER["REQUEST_METHOD"] == "POST") { //if the Login button has been clicked
                    if (empty($_POST['Login_username'])) {
                        $userNameErr = "*";
                    } else {
                        $userName = test_input($_POST['Login_username']);
                        $userNameErr = "";
                    }
                    if (empty($_POST['Login_password'])) {
                        $passwordErr = "*";
                    } else {
                        $password = test_input($_POST['Login_password']);
                        $passwordErr = "";
                    }

                    if (($userNameErr == "") && ($passwordErr == "")) {
                        $connectionString = mysqli_connect('localhost', 'root', '');
                        if (!$connectionString) {
                            die('Failed to connect to database....');
                        } else { //Successful database connection
                            mysqli_select_db($connectionString, 'dbcleanmelbourne');
                            $query = "select user_username, user_password, user_id, user_given_name, user_last_name from user where user_username = '$userName' and user_password = '$password'";
                            $result = mysqli_query($connectionString, $query);
                            mysqli_close($connectionString);

                            while ($row = mysqli_fetch_array($result)) {
                                $fetch_username = $row['user_username'];
                                $fetch_password = $row['user_password'];
                                $fetch_userid = $row['user_id'];
                                $fetch_name = $row['user_given_name'];
                                $fetch_lastname = $row['user_last_name'];
                            }
                            if (($fetch_password == "0") && ($fetch_userid == "0") && ($fetch_username == "0")) {
                                $existance_check_Err = "username or password do not exist or they do not match";
                            } else {
                                $existance_check_Err = "";
                                session_start();
                                $_SESSION['user_id'] = $fetch_userid;
                                /* $_SESSION['username'] = $fetch_username;
                                  $_SESSION['password'] = $fetch_password;
                                  $_SESSION['name'] = $fetch_name;
                                  $_SESSION['lastname'] = $fetch_lastname; */

                                echo '<script> window.location = "user_diary.php"; </script>';
                            }
                        }
                    }
                }

                //this function eliminates the extra space and new line and backslasesh from input.
                function test_input($data) {
                    $data = trim($data);
                    $data = stripcslashes($data);
                    $data = htmlspecialchars($data);

                    return $data;
                }
                ?>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">

                    <div>
                        <p style="color: white;"><h3>Login</h3></p><br>
                        <p style="color: white">* Reqired Fields</p>
                        <p>
                            Username:<br><input class="form-control" type="text" name="Login_username" value="<?php echo $userName; ?>"><span style="color: white"><?php echo $userNameErr; ?></span>
                        </p>
                        <p>
                            Password:<br><input class="form-control" type="password" name="Login_password" value="<?php echo $password; ?>"><span style="color: white"><?php echo $passwordErr ?></span>
                        </p>
                        <p style="color: white"><?php echo $existance_check_Err; ?></p>
                        <p>
                            <input type="submit" name="Login" value="Login" class="btn btn-lg btn-primary">
                        </p>
                        <p><a href="sign_up.php" style="color: white">Sign up</a> </p>
                    </div>
                </form>
            </div>
            <!-- </div> --> <!-- End of First div -->

            <!-- second_div -->

            <div class="col-sm-4 signup_MessageBox">
                <p><h3>Thank you for choosing New Breath...</h3>
                <p><h5><br> With New Breath you will have a personal assistant that helps you to look after yourself.<br><br>
                    We assisst you to keep track of your medical and health condition. We provide you with a personal diary where you would be able to register days when you have breathing issues or when you are perfectly fine.
                    <br><br>
                    Having the suburb where you live into account and by the aid of analysis graphs which will be resulting of your diaries,
                    we can tell you in which particulare time of year you might be at risk of brathing difficulties.</h5><br><br></p>


            </div>

        </div>

    </div>

    <footer class="footer">
        <div class="container-fluid">
            <p>(c) 2016 New Breath Copyright Info</p>
        </div>
    </footer>
</body>
</html>
