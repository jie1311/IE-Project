<html lang="en">
    <head>
        <title>New Breath</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {

                var token = 'MOYH5XX45VVJ7W754DZC';
                var $events = $("#events");


                $.get('https://www.eventbriteapi.com/v3/events/search/?token=' + token + '&q=asthma&location.address=melbourne&expand=venue&sort_by=date', function (res) {
                    if (res.events.length) {

                        var s = "<ul class='eventList' style=\"padding: 0\">";                        
                        for (var i = 0; i < res.events.length; i++) {
                            var event = res.events[i];
                            console.dir(event);

                            s += "<div class=\"panel panel-primary\">";

                            s += "<div class=\"panel-heading\">";
                            s += "<h2 class=\"panel-title\">" + event.name.text + "</h2>";
                            s += "</div>";

                            s += "<div class=\"panel-body\">";
                            s += "<div class=\"row\">";
                            s += "<div class=\"col-sm-3\">";
                            try {
                                s += "<p><img src='" + event.logo.url + "' style=\"width: 100%\"></p>";
                            } catch (e) {
                            }
                            try {
                                var eventTime = moment(event.start.local).format('D/M/YYYY h:mm A');
                                s += "<h4>Time: " + eventTime + "</h4>";
                            } catch (e) {
                            }
                            try {
                                s += "<h4>Address: " + event.venue.address.address_1 + "</h4>";
                            } catch (e) {
                            }
                            try {
                                s += "<p><a class=\"btn btn-lg btn-default\" href='" + event.url + "' style=\"width: 100%\" target=\"_blank\">Go to the Website</a></p>";
                            } catch (e) {
                            }
                            s += "</div>";
                            s += "<div class=\"col-sm-9\">";
                            try {
                                s += "<div class=\"eventcontent\">" + event.description.html + "</div>";
                            } catch (e) {
                            }
                            try {
                                s += "<p><a class=\"btn btn-lg btn-default\" href='" + event.url + "' target=\"_blank\">Go to the Website</a></p>";
                            } catch (e) {
                            }
                            s += "</div>";
                            s += "</div>";
                            s += "</div>";
                            
                            s += "</div>";
                        }
                        s += "</ul>";
                        $events.html(s);
                    } else {
                        $events.html("<p>Sorry, there are no upcoming events.</p>");
                    }
                });
            });
        </script>
    </head>
    <body>
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
                        <li><a href="current.php">Air Quality</a></li>
                        <li class="active"><a href="event.php">Event</a></li>
                        <li><a href="user_login.php">Journal</a></li>
                        <li><a href="aboutus.php">About Us</a></li>
                    </ul>

                </div>
            </div>
        </nav>
        <div style="padding: 15px">
            <h1>Events about Asthma in Melbourne</h1>
            <p>Here we found some events about asthma in Melbourne for you. You can see the details of the events. Go to the original site to get more information.</p>

            <form action="" method="post">
                Input your email here and click "Subscribe" to get a weekly notice of the new events: 
                <input type="email" name="email" class="form-control">
                <input type="submit" class="btn btn-primary" value="Subscribe">
            </form>
            <?php
            if (!empty($_POST)) {
                $link = mysql_connect('localhost', 'root', '');
                mysql_select_db("dbcleanmelbourne");
                // Insert our data
                $query = "INSERT INTO email ( e_email ) VALUES ( '" . $_POST['email'] . "' )";
                $insert = mysql_query($query);
                // Print response from MySQL
                if ($insert) {
                    echo "Success!";
                } else {
                    die("Error!");
                }
                // Close our connection
                mysql_close($link);
            }
            ?>
        </div>
        <div id="events" class="container-fluid">
            <h4>Please wait, we are fetching events. :-)</h4>
        </div>


        <footer class="footer">
            <div class="container-fluid">
                <p>(c) 2016 New Breath Copyright Info</p>
            </div>
        </footer>
    </body>
</html>
