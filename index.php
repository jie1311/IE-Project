<!DOCTYPE html>
<html lang="en">
    <head>
        <title>New Breath</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script type = "text/javascript" src = "https://www.google.com/jsapi"></script>
        <script type = "text/javascript" src = "http://www.google.com/uds/solutions/dynamicfeed/gfdynamicfeedcontrol.js"></script>
        <!--<link rel="stylesheet" href="http://www.google.com/uds/solutions/dynamicfeed/gfdynamicfeedcontrol.css">-->
        <script type = "text/javascript">
            function load() {

                var options = {
                    numResults: 5,
                    scrollOnFadeOut: false
                };
                var feed_1 = "http://www.abc.net.au/news/feed/1678/rss.xml"; // Asthma News
                var feed_2 = "http://www.abc.net.au/news/feed/1464/rss.xml"; // Air Pollution News
                var feed_3 = "http://www.abc.net.au/news/feed/1406/rss.xml"; // General Environment News
                var feed_4 = "http://www.abc.net.au/news/feed/1460/rss.xml"; // General Pollution News
                new GFdynamicFeedControl(feed_1, "feedControl_1", options);
                new GFdynamicFeedControl(feed_2, "feedControl_2", options);
                new GFdynamicFeedControl(feed_3, "feedControl_3", options);
                new GFdynamicFeedControl(feed_4, "feedControl_4", options);
            }
            google.load("feeds", "1");
            google.setOnLoadCallback(load);
        </script>
</head>
<body>

    <div class="page-header">
        <h1><img src="img/logo.png" height="80px"/>New Breath</h1>
    </div>

    <nav class="navbar navbar-default navbar-static-top ">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>                        
                </button>
                <a class="navbar-brand">New Breath</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li  class="active"><a href="index.php">Home</a></li>
                    <li><a href="asthma.php">About Asthma</a></li>
                    <li><a href="current.php">Air Quality</a></li>
                    <li><a href="event.php">Event</a></li>
                    <li><a href="user_login.php">Journal</a></li>
                    <li><a href="aboutus.php">About Us</a></li>
                </ul>
                
            </div>
        </div>
    </nav>

    <div class="container-fluid" >
        <div class="row">

            <div class="col-sm-7" style="padding: 0">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">

                        <div class="item active">
                            <img src="img/aiqquality.jpg" alt="AirQuality" >
                            <div class="carousel-caption" style="background: rgba(0,0,0,0.25); border-radius: 10px; padding-top: 0; padding-left: 15px; padding-right: 15px; padding-bottom: 0">
                                <h4>Pay attention to air quality</h4>
                                <p style="text-align: left">Extremely hot and humid weather and poor air quality can exacerbate asthma symptoms for many people. Limit outdoor activity when these conditions exist or a pollution alert has been issued.</p>
                            </div>
                        </div>

                        <div class="item">
                            <img src="img/indoorworkout.jpg" alt="Indooor" >
                            <div class="carousel-caption" style="background: rgba(0,0,0,0.25); border-radius: 10px; padding-top: 0; padding-left: 15px; padding-right: 15px; padding-bottom: 0">
                                <h4>Exercise indoors</h4>
                                <p style="text-align: left">Physical activity is important - even for people with asthma. Reduce the risk for exercise-induced asthma attacks by working out inside on very cold or very warm days. Talk to your doctor about asthma and exercise.</p>
                            </div>
                        </div>

                        <div class="item">
                            <img src="img/avoidsmoke.jpg" alt="AvoidSmoke" >
                            <div class="carousel-caption" style="background: rgba(0,0,0,0.25); border-radius: 10px; padding-top: 0; padding-left: 15px; padding-right: 15px; padding-bottom: 0">
                                <h4>Avoid areas where people smoke</h4>
                                <p style="text-align: left">Breathing smoke - even secondhand smoke and smoke on clothing, furniture or drapes - can trigger an asthma attack. Be sure to ask for a smoke-free hotel room when traveling.</p>
                            </div>
                        </div>
                    </div>
                    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>

            <div class="col-sm-5">
                <h3>Looking for a fresher air to Breath?</h3>
                <p>Are you concern about your Asthma? 
                    In New Breath we offer you a fantastic solution. 
                    Select any suburb and click on Air Quality, 
                    we show you how clean the air is...</p>
                <div style="padding-left: 15px; padding-right: 15px">
                    <?php
                    $connectionString = mysqli_connect('localhost', 'root', '');
                    if (!$connectionString) {
                        die('Failed to connect to database....');
                    } else {
                        mysqli_select_db($connectionString, 'dbcleanmelbourne');
                        $query = "select sub.su_id, sub.su_name, sub.su_postcode from suburb sub order by sub.su_name";
                        $result = mysqli_query($connectionString, $query);
                    }
                    ?>
                    
                    <form id="HomePage" class="margin-horiz-10 " action="map.php" method="get">                        
                        <p><select name="suburb" style="width: 100%" class="btn btn-lg btn-default" id="selectsub">
                                <option value="0">select suburb</option>
                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                    <option value=<?php echo $row['su_id'] ?>> <?php echo $row['su_name'], " , ", $row['su_postcode'] ?> </option>
                                    <?php
                                }
                                mysqli_close($connectionString);
                                ?>
                            </select></p>
                        <p><input type="submit"  value="Air Quality" class="btn btn-lg btn-primary" style="width: 100%" /></p>                    
                    </form>
                    <h5 style="text-align: center">Or</h5>
                    <p>
                        <a class="btn btn-lg btn-primary" href="current.php" style="width: 100%">Current Location</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid newstab">

        <div><h3>Relevant NewsFeed:</h3></div>

        <div class="row">
            <div class="col-sm-1" style="padding: 0">

            </div>
            <div class="col-sm-11" style="padding: 12px">
                <div class="col-sm-4" style="padding-left: 6px; padding-right: 6px">
                    <div id = "feedControl_1" class="panel panel-default"><h3>Fetching news...</h3></div>
                </div>
                <div class="col-sm-4" style="padding-left: 6px; padding-right: 6px">
                    <div id = "feedControl_2" class="panel panel-default"><h3>Fetching news...</h3></div>
                </div>
                <div class="col-sm-4" style="padding-left: 6px; padding-right: 6px">
                    <div id = "feedControl_3" class="panel panel-default"><h3>Fetching news...</h3></div>
                </div>
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
