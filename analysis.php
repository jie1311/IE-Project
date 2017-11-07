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
            window.setTimeout('clickit()', 3000);
            function clickit() {
                document.getElementById("link").click();
            }
        </script>
    </head>
    <body>
        <?php
        $suburb_id = $_GET['id'];
        ?>
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button>
                    <a class="navbar-brand" href="index.php" style="padding: 7px"><img src="img/logo.png" style="height: 100%"/></a>
                    <a class="navbar-brand" >New Breath</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="asthma.php">About Asthma</a></li>
                        <li class="active"><a href="current.php">Air Quality</a></li>
                        <li><a href="event.php">Event</a></li>
                        <li><a href="user_login.php">Journal</a></li>
                        <li><a href="aboutus.php">About Us</a></li>
                    </ul>
                    
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <h1>Air Quality Index Analysis form Last Year</h1>
            <div class="row">
                <div class="col-sm-5" style="padding: 25px">                    
                    <ul class="nav nav-tabs">
                        <li><a data-toggle="tab" href="#year" id="link">Whole Year</a></li>
                        <li class="active"><a data-toggle="tab" href="#sp">Spring</a></li>
                        <li><a data-toggle="tab" href="#sm">Summer</a></li>
                        <li><a data-toggle="tab" href="#fl">Autumn</a></li>
                        <li><a data-toggle="tab" href="#wt">Winter</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="year" class="tab-pane fade in active" style="padding: 0">
                            <p>We divide the days of last year to five catagories by air quality index. The pie chart shows how much of each catagory in the whole year by percentage.</p>
                            <iframe src="subpage/showPie.php?id=<?php echo $suburb_id; ?>&ss=yr" class="mod" ></iframe>
                        </div>
                        <div id="sp" class="tab-pane fade in in active" style="padding: 0">
                            <p>We divide the days of last spring to five catagories by air quality index. The pie chart shows how much of each catagory in spring by percentage.</p>
                            <iframe src="subpage/showPie.php?id=<?php echo $suburb_id; ?>&ss=sp" class="mod" ></iframe>
                        </div>
                        <div id="sm" class="tab-pane fade in in active" style="padding: 0">
                            <p>We divide the days of last summer to five catagories by air quality index. The pie chart shows how much of each catagory in summer by percentage.</p>
                            <iframe src="subpage/showPie.php?id=<?php echo $suburb_id; ?>&ss=sm" class="mod" ></iframe>
                        </div>
                        <div id="fl" class="tab-pane fade in in active" style="padding: 0">
                            <p>We divide the days of last autumn to five catagories by air quality index. The pie chart shows how much of each catagory in autumn by percentage.</p>
                            <iframe src="subpage/showPie.php?id=<?php echo $suburb_id; ?>&ss=at" class="mod" ></iframe>
                        </div>
                        <div id="wt" class="tab-pane fade in in active" style="padding: 0">
                            <p>We divide the days of last winter to five catagories by air quality index. The pie chart shows how much of each catagory in winter by percentage.</p>
                            <iframe src="subpage/showPie.php?id=<?php echo $suburb_id; ?>&ss=wt" class="mod" ></iframe>
                        </div>

                    </div>
                </div>
                <div class="col-sm-7" style="padding: 25px">
                    <iframe src="subpage/showLine.php?id=<?php echo $suburb_id; ?>&tm=yr" class="mod" style="height: 50%"></iframe>
                    <p>According to EPA, we uses an air quality index (AQI) summary to give an overall measurement of air quality at each air monitoring site. The lower the index, the better the air quality is. <br /> 
                        There are five AQI categories:<br />
                    <ul>
                        <li><b>Very Good (0-33)</b></li>
                        <li><b>Good (34-66)</b><br />No tailored advice necessary. General air quality information and health advice is available from EPA’s and the department’s websites.</li>
                        <li><b>Fair (67-100)</b><br />People with heart or lung conditions, children, pregnant women and older adults should reduce prolonged or heavy physical activity.<br />No specific message for everyone else.</li>
                        <li><b>Poor (100-150)</b><br />People with heart or lung conditions, children, pregnant women and older adults should avoid prolonged or heavy physical activity.<br />Everyone else should reduce prolonged or heavy physical activity.</li>
                        <li><b>Very Poor (150+)</b><br />People with heart or lung conditions, children, pregnant women and older adults should remain indoors and keep activity levels as low as possible.<br />Everyone should avoid all physical activity outdoors.<br />If conditions persist (two or more days), some people may be advised to temporarily relocate.</li>
                    </ul>
                    </p>
                    <p><a href="http://www.epa.vic.gov.au/your-environment/air/air-pollution/air-quality-index/calculating-a-station-air-quality-index" target="_blank">Click here </a>
                    to get information about calculating a station air quality index.</p>
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
