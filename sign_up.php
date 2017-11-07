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
                        <li class="active"><a href="user_login.php">Journal</a></li>
                        <li><a href="aboutus.php">About Us</a></li>
                    </ul>

                </div>
            </div>
        </nav>

        <div class="container-fluid second_div" style="padding: 0">
            <div class="col-sm-2"></div>
            <div class="col-sm-4 signup_table">
                <!-- SignUp Form -->
                <?php
                session_start();

                $connectionString = mysqli_connect('localhost', 'root', '');
                if (!$connectionString) {
                    die('Failed to connect to database....');
                } else {
                    mysqli_select_db($connectionString, 'dbcleanmelbourne');
                    $query = "select sub.su_id, sub.su_name, sub.su_postcode from suburb sub order by sub.su_name";
                    $result = mysqli_query($connectionString, $query);
                    mysqli_close($connectionString);
                }

                //variables to keep the content of the form elements.
                $firstName = "";
                $lastName = "";
                $suburbID = "0";
                $userName = "";
                $password = "";
                $password_conf = "";
                $email = "";
                //variables to keep the error message to each information inserted
                $nameErr = "";
                $lastnameErr = "";
                $suburbIDErr = "";
                $userNameErr = "";
                $passwordErr = "";
                $password_confErr = "";
                $emailErr = "";

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (empty($_POST["FirstName"])) { //FirstName
                        $nameErr = "*";
                    } else {
                        $firstName = test_input($_POST["FirstName"]);
                        $nameErr = "";
                        if (!preg_match("/^[a-zA-Z ]*$/", $firstName)) { // To check whether the name is in correct format.
                            $nameErr = "* only letters and white space allowed.";
                        }
                    }
                    if (empty($_POST["LastName"])) { //LastName
                        $lastnameErr = "*";
                    } else {
                        $lastName = test_input($_POST["LastName"]);
                        $lastnameErr = "";
                        if (!preg_match("/^[a-zA-Z ]*$/", $lastName)) { // To check whether the lastname is in correct format.
                            $lastnameErr = "* only letters and white space allowed.";
                        }
                    }
                    if ($_POST["suburb"] == 0) { //suburb
                        $suburbIDErr = "*";
                    } else {
                        $suburbID = test_input($_POST["suburb"]);
                        $suburbIDErr = "";
                    }
                    if (empty($_POST["UserName"])) { //UserName
                        $userNameErr = "*";
                    } else {
                        $userName = test_input($_POST["UserName"]);
                        $userNameErr = "";
                    }
                    if (empty($_POST["Password"])) { //Password
                        $passwordErr = "*";
                    } else {
                        $password = test_input($_POST["Password"]);
                        $passwordErr = "";
                    }
                    if (empty($_POST["ConfPassword"])) { //Confirm Password
                        $password_confErr = "*";
                    } else {
                        $password_conf = test_input($_POST["ConfPassword"]);
                        $password_confErr = "";
                    }
                    if (empty($_POST["EmailAddress"])) { //Email
                        $emailErr = "*";
                    } else {
                        $email = test_input($_POST["EmailAddress"]);
                        $emailErr = "";
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $emailErr = "* Invalid email format.";
                        }
                    }
                    //inserting into database
                    if (($nameErr == "") && ($lastnameErr == "") && ($suburbIDErr == "") && ($userNameErr == "") && ($passwordErr == "") && ($password_confErr == "") && ($emailErr == "")) {
                        $InsertconnectionString = mysqli_connect('localhost', 'root', '');
                        if (!$InsertconnectionString) {
                            die('Failed to connect to database....');
                        } else {

                            mysqli_select_db($InsertconnectionString, 'dbcleanmelbourne');

                            $insert_query = "INSERT INTO user(user_given_name, user_last_name, user_suburb_id, user_username, user_password, user_email) VALUES ('$firstName','$lastName','$suburbID','$userName','$password','$email')";
                            $insert_result = mysqli_query($InsertconnectionString, $insert_query);

                            $get_user_id = "select uu.user_id from user uu where uu.user_username = '$userName' and uu.user_password = '$password' ";
                            $get_user_id_result = mysqli_query($InsertconnectionString, $get_user_id);
                            while ($row = mysqli_fetch_array($get_user_id_result)) {
                                $ii = $row['user_id'];
                            }
                            //echo "user id: ", $ii;

                            $_SESSION['user_id'] = $ii;

                            mysqli_close($InsertconnectionString);
                            echo '<script> window.location = "user_diary.php";</script>';
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
                    <p><h3>Create an account</h3></p>

                    <p style="color: red">* Required Fields</p>

                    <p>Given Name:<br><input class="form-control"  type="text" name="FirstName" id="First_Name" value="<?php echo $firstName; ?>"><span style="color: red"><?php echo $nameErr; ?></span></p>

                    <p>Last Name:<br><input class="form-control"  type="text" name="LastName" id="LastName" value="<?php echo $lastName; ?>"><span style="color: red"><?php echo $lastnameErr; ?></span></p>

                    <p>Suburb:<br><select class="btn btn-default" name="suburb" id="suburb">

                            <option value="0">select suburb</option>
                            <?php
                            while ($row = mysqli_fetch_array($result)) {
                                ?>
                                <option value=<?php echo $row['su_id'] ?>> <?php echo $row['su_name'], " , ", $row['su_postcode'] ?> </option>
                                <?php
                            }
                            mysqli_close($connectionString);
                            ?>
                        </select><span style="color: red"><?php echo $suburbIDErr; ?></span></p>

                    <p>UserName:<br><input class="form-control"  type="text" name="UserName" id="UserName" value="<?php echo $userName; ?>"><span style="color: red"><?php echo $userNameErr; ?></span></p>

                    <p>Password:<br><input class="form-control"  type="password" name="Password" id="Password"><span style="color: red"><?php echo $passwordErr ?></span></p>

                    <p>Confirm Password:<br><input class="form-control"  type="password" name="ConfPassword" id="ConfPassword"><span style="color:red;"><?php echo $password_confErr; ?></span></p>

                    <p>Email Address:<br><input class="form-control"  type="email" name="EmailAddress" id="EmailAddress" value="<?php echo $email; ?>"><span style="color: red"><?php echo $emailErr; ?></span></p>

                    <p><input type="submit" name="btnSubmit" id="btnSubmit" value="Join us" class="btn btn-lg btn-primary"></p>


                </form>
            </div>

            <div class="col-sm-4 signup_MessageBox">
                <p><h3>Start your journey with us....</h3></p>
                <p><h5><br>By signing up with New Breath you will have a personal assistant that helps you to look after yourself.<br><br>
                    We assisst you to keep track of your medical and health condition. We provide you with a personal diary where you would be able to register days when you have breathing issues or when you are perfectly fine.
                    <br><br>
                    Having the suburb where you live into account and by the aid of analysis graphs which will be resulting of your diaries,
                    we can tell you in which particulare time of year you might be at risk of brathing difficulties.</h5><br><br></p>
            </div>

        </div>

        <footer class="footer">
            <div class="container-fluid">
                <p>(c) 2016 New Breath Copyright Info</p>
            </div>
        </footer>
    </body>
</html>
