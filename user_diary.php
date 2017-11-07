<html lang="en">
    <head>
        <title>New Breath</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script>
            window.setTimeout('clickit()', 6000);
            function clickit() {
                document.getElementById("link").click();
            }
        </script>

    </head>

    <body>
        <?php
        session_start();
        $u_id = $_SESSION['user_id'];
        $_SESSION['id'] = $u_id;
        ?>

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

        <div class="container-fluid">
            <div class="row">

                <!-- First div -->
                <div class="col-sm-7" style="padding-left: 30px">

                    <ul class="nav nav-tabs">
                        <li><a data-toggle="tab" href="#diary" id="link">Diary</a></li>
                        <li class="active"><a data-toggle="tab" href="#month">Time</a></li>
                        <li><a data-toggle="tab" href="#video">Usefull Videos</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="diary" class="tab-pane fade in active" style="padding: 0">
                            <iframe src="subpage/diary_register.php" class="mod"></iframe>
                        </div>

                        <div id="month" class="tab-pane fade in active" style="padding: 0">
                            <iframe src="subpage/showHealthMonath.php" class="mod"></iframe>
                        </div>

                        <div id="video" class="tab-pane fade in active" style="padding: 0">
                            <iframe src="subpage/userfull_videos.php" class="mod"></iframe>
                        </div>

                    </div>
                </div>

                <!-- Second div -->
                <div class="col-sm-5">
                    <div style="padding: 15px"> <!-- To put the content of the second div -->
                        <!-- Showing the weather forecast -->
                        <h3>Today the weather is : </h3>
                        <div id="weather" style="width: 100%; padding-left: 50px">
                            <?php
                            $var = file_get_contents('http://api.openweathermap.org/data/2.5/weather?id=2158177&mode=html&APPID=16e7001b4d1203b9c837a2c72e699882');
                            echo $var;
                            ?>
                        </div><br>
                        <p>This tab displays the amount of particles in air in the suburb you are living.</p>

                        <div class="container-fluid" style="padding: 0">
                            <ul class="nav nav-tabs">
                                <li  class="active"><a data-toggle="tab" href="#suburb" id="link">Air quality of your suburb, Today</a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="suburb" class="tab-pane fade in active" style="padding: 0">
                                    <iframe src="subpage/showParticlesInSuburb.php" class="mod" style="height: 50%"></iframe>
                                </div>
                            </div>
                        </div>

                    </div> <!-- End of content of the second div -->

                </div> <!-- End of Second div -->
            </div>
        </div>

        <footer class="footer">
            <div class="container-fluid">
                <p>(c) 2016 New Breath Copyright Info</p>
            </div>
        </footer>
    </body>
</html>
