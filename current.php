<html lang="en">
    <head>
        <title>New Breath</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<!--        <script async defer
 src +="https://maps.googleapis.com/maps/api/js?key=AIzaSyC2gASlQ9PrJIPLkX8Ekks_LcGY4pEe830&callback=initMap">
</script> -->

    </head>
    <body>
        <?php
        if (isset($_POST['txtLatitude'])) {
            $current_lat = $_POST['txtLatitude'];
            //echo $current_lat;
            //echo "<br>";

            $current_longi = $_POST['txtLongitude'];
            //echo $current_longi;
            //echo "<br>";

            $FormatedAddre = $_POST['txtFormatedAddress'];
            //echo $FormatedAddre;
            //echo "<br>";

            $array = explode(",", $FormatedAddre);
            //print_r(explode(",",$FormatedAddre));
            //echo "<br>";

            $address = explode(" ", $array[1]);
            /* print_r(explode(" ",$array[1]));
              echo "<br>";
              echo count($address);
              echo "<br>"; */

            $count = count($address);
            $postcode = $address[$count - 1];
            //echo "This is your postcode: ", $postcode;

            $connectionString = mysqli_connect('localhost', 'root', '');
            if (!$connectionString) {
                die('Failed to connect to database....');
            } else {
                mysqli_select_db($connectionString, 'dbcleanmelbourne');
                $query_air_quality_measurement = "select * from airquality_daily aqd, airstation ais
                                        where ais.st_id = aqd.st_id and ais.st_postcode >= $postcode and
                                        aqd.aqd_from_date in (select max(aqd.aqd_from_date) from airquality_daily aqd where aqd.aqd_from_date <= (select now())) 
                                        order by ais.st_postcode limit 1";
                $result_air_quality_measurement = mysqli_query($connectionString, $query_air_quality_measurement);

                while ($row_qir_quality_measurement = mysqli_fetch_array($result_air_quality_measurement)) {
                    $co = $row_qir_quality_measurement['aqd_co'];
                    $ozon = $row_qir_quality_measurement['aqd_o3'];
                    $nitrogen_dioxide = $row_qir_quality_measurement['aqd_no2'];
                    $sulfur_dioxide = $row_qir_quality_measurement['aqd_so2'];
                    $pm_two_five = $row_qir_quality_measurement['aqd_pm25'];
                    $pm_ten = $row_qir_quality_measurement['aqd_pm10'];
                    $visible_reduce = $row_qir_quality_measurement['aqd_vr'];
                    $aqi = $row_qir_quality_measurement['aqd_aqi'];
                    $summary = $row_qir_quality_measurement['aqd_summary'];
                    $st_id = $row_qir_quality_measurement['st_id'];
                } //End of while
                $_SESSION['st_id'] = $st_id;
                //Setting an indicator for carbon monoxide
                if (($co >= 0) && ($co <= 2.9)) { //Very Good
                    $co_indicator = 5;
                } elseif (($co >= 2) && ($co <= 5.8)) { //Good
                    $co_indicator = 4;
                } elseif (($co >= 5.9) && ($co <= 8.9)) { //fair
                    $co_indicator = 3;
                } elseif (($co >= 9) && ($co <= 13.4)) { //Poor
                    $co_indicator = 2;
                } elseif ($co >= 13.9) { //Very Poor
                    $co_indicator = 1;
                }
                //Setting an indicator for Nitrogen dioxide
                if (($nitrogen_dioxide >= 0) && ($nitrogen_dioxide <= 39)) { //Very Good
                    $nitrogen_dioxide_indicator = 5;
                } elseif (($nitrogen_dioxide >= 40) && ($nitrogen_dioxide <= 78)) { //Good
                    $nitrogen_dioxide_indicator = 4;
                } elseif (($nitrogen_dioxide >= 79) && ($nitrogen_dioxide <= 119)) { //Fair
                    $nitrogen_dioxide_indicator = 3;
                } elseif (($nitrogen_dioxide >= 120) && ($nitrogen_dioxide <= 179)) { //Poor
                    $nitrogen_dioxide_indicator = 2;
                } elseif ($nitrogen_dioxide >= 180) { //Very Poor
                    $nitrogen_dioxide_indicator = 1;
                }
                //Setting an indicator for PM2.5
                if (($pm_two_five >= 0) && ($pm_two_five <= 8)) { //Very Good
                    $pm_two_five_indicateor = 5;
                } elseif (($pm_two_five > 8) && ($pm_two_five <= 25)) { //Good
                    $pm_two_five_indicateor = 4;
                } elseif (($pm_two_five > 25) && ($pm_two_five <= 39)) { //Fair
                    $pm_two_five_indicateor = 3;
                } elseif (($pm_two_five > 39) && ($pm_two_five <= 106)) { //Poor
                    $pm_two_five_indicateor = 2;
                } elseif (($pm_two_five > 106) && ($pm_two_five <= 177)) { //Very Poor
                    $pm_two_five_indicateor = 1;
                } elseif ($pm_two_five > 177) { //Dangerous
                    $pm_two_five_indicateor = 0;
                }
                //Setting an indicator for PM10
                if (($pm_ten >= 0) && ($pm_ten <= 16)) { //Very Good
                    $pm_ten_indicator = 5;
                } elseif (($pm_ten >= 17) && ($pm_ten <= 32)) { //Good
                    $pm_ten_indicator = 4;
                } elseif (($pm_ten >= 33) && ($pm_ten <= 49)) { //Fair
                    $pm_ten_indicator = 3;
                } elseif (($pm_ten >= 50) && ($pm_ten <= 74)) { //Poor
                    $pm_ten_indicator = 2;
                } elseif ($pm_ten >= 75) { //Very Poor
                    $pm_ten_indicator = 1;
                }
                //Setting an indivator for sulfur dioxide
                if (($sulfur_dioxide >= 0) && ($sulfur_dioxide <= 65)) { //Very Good
                    $sulfur_dioxide_indicator = 5;
                } elseif (($sulfur_dioxide >= 66) && ($sulfur_dioxide <= 131)) { //Good
                    $sulfur_dioxide_indicator = 4;
                } elseif (($sulfur_dioxide >= 132) && ($sulfur_dioxide <= 199)) { //Fair
                    $sulfur_dioxide_indicator = 3;
                } elseif ($sulfur_dioxide > 200) { //Poor
                    $sulfur_dioxide_indicator = 2;
                }
                //co + No2 + So2
                $sum = $co_indicator + $nitrogen_dioxide_indicator + $sulfur_dioxide_indicator;

                //This variable will be used to indicate what type of features (hospitals, parks, gyms)
                //need to be shown on map
                $status = 0;
                $park_status = 0;
                $gym_status = 0;
            } //End of Else
        }
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
            <div class="row">
                <div class="col-sm-7" style="padding: 0">

                    <div style="padding: 25px">
                        <h3>Current Location</h3>
                        <p>Here you can see the quality of air in your current location.</p>
                    </div>
                    <div id="map" style="width: 100%; height: 75%"></div>

                </div>

                <div class="col-md-5" style="padding: 5px">
                    <form name="frmCurrentLocation" id="frmCurrentLocation" method="post">
                        <div  style="padding: 15px">
                            <!-- Showing the weather forecast of the current location of user -->
                            <p><h3><?php echo date("l"), "      ", date("d/m/Y") . "<br>"; ?></h3>
                            <?php
                            $var = file_get_contents('http://api.openweathermap.org/data/2.5/weather?id=2158177&mode=html&APPID=16e7001b4d1203b9c837a2c72e699882');
                            echo $var;
                            ?>
                        </div>

                        <div style="padding: 15px; font-size: 14px">

                            <!-- Showing hospitals near by -->
                            <p>Do you need medical attention?  <a href="#" onclick="ShowHospitalOnMap()">  click Here  </a> to see a list of Medical centers around you.</p>

                            <!-- Calling Cabs -->
                            <p>Do you need to call a cab?  call <a href= "tel: 132227"> 13Cabs </a> <em style="color: red">(Dail 132227)</em> </p>
                            <p>Do you need to call ambulence?  call <a href= "tel: 000"> Emergency </a> <em style="color: red"> (Dail 000)</em> </p>

                            <input type="hidden" name="txtLatitude" id="txtLatitude" />
                            <input type="hidden" name="txtLongitude" id="txtLongitude" />
                            <input type="hidden" name="txtFormatedAddress" id="txtFormatedAddress">
                            <input type="submit" class="btn btn-lg btn-primary" style="width: 100%" name="sub"  value="Click here to see the air quality in your suburb" onclick="functionTest()" id="sub" />
                        </div>

                        <div id="airQualityAnalysis" style="padding: 15px; font-size: 14px">
                            <?php if (isset($_POST['txtLatitude'])) { ?>

                                <!-- outdoor activity -->
                                <p><?php if ($pm_two_five_indicateor == 5) { ?>
                                        <img src="img/suburb_map/happy-face01.jpg" style="width:27px;height:25px;">
                                        <?php echo " Very Good time for outdoor activity   "; ?><br>
                                        <?php echo "  Want to do some exercise?  "; ?>
                                        <a href="#" onclick="ShowFeaturesOnMap()" >Gyms</a><?php echo "  and "; ?>
                                        <a href="#" onclick="ShowParkOnMap()">Parks</a><br>
                                    <?php } ?>

                                    <?php if ($pm_two_five_indicateor == 4) { ?>
                                        <img src="img/suburb_map/happy-face02.jpg" style="width:27px;height:25px;">
                                        <?php echo " Good time for outdoor activity   "; ?><br>
                                        <?php echo "Want to do some exercise?  "; ?>
                                        <a href="#" onclick="ShowFeaturesOnMap()" >Gyms</a><?php echo "  and "; ?>
                                        <a href="#" onclick="ShowParkOnMap()">Parks</a><br>
                                    <?php } ?>

                                    <?php if ($pm_two_five_indicateor == 3) { ?><img src="img/suburb_map/confuse-face.jpg" style="width:27px;height:25px;">
                                        <?php echo " Outdoor activities are not recommended   "; ?><br>
                                        <?php echo "Want to do some exercise?  "; ?>
                                        <a href="#" onclick="ShowFeaturesOnMap()" >Gyms</a><?php echo "  and "; ?>
                                        <a href="#" onclick="ShowParkOnMap()">Parks</a><br>
                                    <?php } ?>

                                    <?php if ($pm_two_five_indicateor == 2) { ?><img src="img/suburb_map/sad-face-01.jpg" style="width:27px;height:25px;">
                                        <?php echo " It is recommended to avoid outdoor activities "; ?><br><br>
                                    <?php } ?></p>

                                <!-- Opening window, it is assessed based on sum of co, No2 and So2 -->
                                <p><?php if ($sum == 15) { ?><img src="img/suburb_map/happy-face01.jpg" style="width:27px;height:25px;">
                                        <?php
                                        echo " Very Good time to open windows";
                                    }
                                    ?>

                                    <?php if ($sum == 14) { ?><img src="img/suburb_map/happy-face02.jpg" style="width:27px;height:25px;">
                                        <?php
                                        echo " Good time to open windows";
                                    }
                                    ?>

                                    <?php if ((($sum == 12) || ($sum == 13)) && (($co_indicator > 3) && ($nitrogen_dioxide_indicator > 3) && ($sulfur_dioxide_indicator > 3))) { ?>
                                        <img src="img/suburb_map/happy-face02.jpg" style="width:27px;height:25px;">
                                        <?php
                                        echo " Good time to open windows";
                                    }
                                    ?>

                                    <?php if ((($sum == 12) || ($sum == 13)) && ((($co_indicator >= 3) && ($co_indicator <= 5)) && (($nitrogen_dioxide_indicator >= 3) && ($nitrogen_dioxide_indicator <= 5)) && (($sulfur_dioxide_indicator >= 3) && ($sulfur_dioxide_indicator <= 5)))) { ?>
                                        <img src="img/suburb_map/confuse-face.jpg" style="width:27px;height:25px;">
                                        <?php
                                        echo " Opening windows is not recommended";
                                    }
                                    ?>

                                    <?php if ((($sum == 9) || ($sum == 10) || ($sum == 11)) && ((($co_indicator >= 3) && ($co_indicator <= 4)) && (($nitrogen_dioxide_indicator >= 3) && ($nitrogen_dioxide_indicator <= 4)) && (($sulfur_dioxide_indicator >= 3) && ($sulfur_dioxide_indicator <= 4)))) { ?>
                                        <img src="img/suburb_map/confuse-face.jpg" style="width:27px;height:25px;">
                                        <?php
                                        echo " Opening windows is not recommended";
                                    }
                                    ?>

                                    <?php if ((($sum >= 6) && ($sum <= 12)) && (($co_indicator == 2) || ($nitrogen_dioxide_indicator == 2) || ($sulfur_dioxide_indicator == 2))) { ?><img src="img/suburb_map/sad-face-01.jpg" style="width:27px;height:25px;">
                                        <?php
                                        echo " It is recommended to avoid opening windows";
                                    }
                                    ?>

                                    <?php if ((($sum >= 3) && ($sum <= 11)) && (($co_indicator == 1) || ($nitrogen_dioxide_indicator == 1) || ($sulfur_dioxide_indicator == 1))) { ?><img src="img/suburb_map/scared-face01.jpg" style="width:27px;height:25px;">
                                        <?php
                                        echo " It is absolutely dangerous to open any windows";
                                    }
                                    ?></p>

                                <!-- Using Mask -->
                                <p><?php if ((($sum >= 12) && ($sum <= 15)) && (($co_indicator > 3) && ($nitrogen_dioxide_indicator > 3) && ($sulfur_dioxide_indicator > 3))) { ?>
                                        <img src="img/suburb_map/happy-face01.jpg" style="width:27px;height:25px;">
                                        <?php
                                        echo " No need to use Mask at all";
                                    }
                                    ?>

                                    <?php if ((($sum == 12) || ($sum == 13)) && ((($co_indicator >= 3) && ($co_indicator <= 5)) && (($nitrogen_dioxide_indicator >= 3) && ($nitrogen_dioxide_indicator <= 5)) && (($sulfur_dioxide_indicator >= 3) && ($sulfur_dioxide_indicator <= 5)))) { ?>
                                        <img src="img/suburb_map/confuse-face.jpg" style="width:27px;height:25px;">
                                        <?php
                                        echo " Using a mask is recommended";
                                    }
                                    ?>

                                    <?php if ((($sum == 9) || ($sum == 10) || ($sum == 11)) && ((($co_indicator >= 3) && ($co_indicator <= 4)) && (($nitrogen_dioxide_indicator >= 3) && ($nitrogen_dioxide_indicator <= 4)) && (($sulfur_dioxide_indicator >= 3) && ($sulfur_dioxide_indicator <= 4)))) { ?>
                                        <img src="img/suburb_map/confuse-face.jpg" style="width:27px;height:25px;">
                                        <?php
                                        echo " Using a mask is recommended";
                                    }
                                    ?>

                                    <?php if ((($co_indicator == 1) || ($co_indicator == 2)) || (($nitrogen_dioxide_indicator == 1) || ($nitrogen_dioxide_indicator == 2)) || (($sulfur_dioxide_indicator == 1) || ($sulfur_dioxide_indicator == 2))) { ?><img src="img/suburb_map/scared-face01.jpg" style="width:27px;height:25px;">
                                        <?php
                                        echo " It is a must to use a mask";
                                    }
                                    ?></p>
                                <p style="padding-left: 15%; padding-right: 15%">
                                    <a class="btn btn-lg btn-default" href="analysis.php?id=<?php echo $st_id; ?>" style="width: 100%">AQI analysis from Last Year</a>
                                </p>
                                <iframe src="subpage/showLine.php?id=<?php echo $st_id; ?>&tm=wk" class="mod" style="height: 50%"></iframe>
                                <ul>
                                    <li><b>Very Good (0-33)</b></li>
                                    <li><b>Good (34-66)</b><br />No tailored advice necessary. General air quality information and health advice is available from EPA’s and the department’s websites.</li>
                                    <li><b>Fair (67-100)</b><br />People with heart or lung conditions, children, pregnant women and older adults should reduce prolonged or heavy physical activity.<br />No specific message for everyone else.</li>
                                    <li><b>Poor (100-150)</b><br />People with heart or lung conditions, children, pregnant women and older adults should avoid prolonged or heavy physical activity.<br />Everyone else should reduce prolonged or heavy physical activity.</li>
                                    <li><b>Very Poor (150+)</b><br />People with heart or lung conditions, children, pregnant women and older adults should remain indoors and keep activity levels as low as possible.<br />Everyone should avoid all physical activity outdoors.<br />If conditions persist (two or more days), some people may be advised to temporarily relocate.</li>
                                </ul>
                            </div>




                        <?php } ?>

                </div>


                </form>


            </div>

            <script>
                // Note: This example requires that you consent to location sharing when
                // prompted by your browser. If you see the error "The Geolocation service
                // failed.", it means you probably did not give permission for the browser to
                // locate you.
                var map;
                var error;
                var Lati;
                var Longi;

                function initMap() {
                    var map = new google.maps.Map(document.getElementById('map'), {
                        center: {lat: -34.397, lng: 150.644},
                        zoom: 15
                    });
                    var infowindow = new google.maps.InfoWindow;
                    var geocoder = new google.maps.Geocoder;

                    // Try HTML5 geolocation.
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function (position) {
                            var pos = {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude
                            };
                            Lati = position.coords.latitude;
                            Longi = position.coords.longitude;


                            var t_lat = document.getElementById("txtLatitude");
                            var t_long = document.getElementById("txtLongitude");

                            t_lat.value = position.coords.latitude;
                            t_long.value = position.coords.longitude;

                            Latitude = position.coords.latitude;
                            Longitude = position.coords.longitude;

                            map = new google.maps.Map(document.getElementById('map'), {
                                zoom: 15,
                                center: pos
                            });

                            var marker = new google.maps.Marker({
                                position: pos,
                                map: map
                            });
                            var latlng = {lat: parseFloat(Lati), lng: parseFloat(Longi)};
                            geocoder.geocode({'location': latlng}, function (results, status) {
                                if (status === google.maps.GeocoderStatus.OK) {
                                    if (results[0]) {

                                        infowindow.setContent(results[0].formatted_address);
                                        var FormatedAdd = document.getElementById('txtFormatedAddress');
                                        FormatedAdd.value = results[0].formatted_address.toString();

                                        marker.addListener('click', function () {
                                            infowindow.open(map, marker);
                                        });
                                    } else {
                                        window.alert('No results found');
                                    }
                                } else {
                                    window.alert('Geocoder failed due to: ' + status);
                                }
                            });

                            marker.addListener('click', function () {
                                infowindow.open(map, marker);
                            })
                        }
                        , function () {
                            handleLocationError(true, infoWindow, map.getCenter());
                        });
                    } else {
                        // Browser doesn't support Geolocation
                        handleLocationError(false, infoWindow, map.getCenter());
                    }
                }

                function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                    infoWindow.setPosition(pos);
                    infoWindow.setContent(browserHasGeolocation ?
                            'Error: The Geolocation service failed.' :
                            'Error: Your browser doesn\'t support geolocation.');
                }

                //**************************Ask For Hospital**********************
                function ShowHospitalOnMap() {

                    /*var latitude;
                     var longitude;
                     latitude = document.getElementById("txtLatitude");
                     longitude = document.getElementById("txtLongitude");
                     
                     var tt = document.getElementById("txtLatitude");
                     var ll = document.getElementById("txtLongitude");*/


                    var pyrmont = {lat: Lati, lng: Longi};

                    Extrainfowindow = new google.maps.InfoWindow();
                    var service = new google.maps.places.PlacesService(map);
                    service.nearbySearch({
                        location: pyrmont,
                        radius: 1000,
                        type: ['hospital']
                    }, callbackhospital);
                }

                function callbackhospital(results, status) {
                    if (status === google.maps.places.PlacesServiceStatus.OK) {
                        for (var i = 0; i < results.length; i++) {
                            createMarkerHospital(results[i]);
                        }
                    }
                }

                function createMarkerHospital(place) {
                    var placeLoc = place.geometry.location;
                    var marker = new google.maps.Marker({
                        map: map,
                        icon: 'img/suburb_map/hospital02.jpg',
                        position: place.geometry.location
                    });
                    google.maps.event.addListener(marker, 'click', function () {
                        Extrainfowindow.setContent(place.name);
                        Extrainfowindow.open(map, this);
                    });
                }
                //*************************Ask For Gym************************
                function ShowFeaturesOnMap() {
                    var pyrmont = {lat: Lati, lng: Longi};

                    Extrainfowindow = new google.maps.InfoWindow();
                    var service = new google.maps.places.PlacesService(map);
                    service.nearbySearch({
                        location: pyrmont,
                        radius: 1000,
                        type: ['gym']
                    }, callback);
                }

                function callback(results, status) {
                    if (status === google.maps.places.PlacesServiceStatus.OK) {
                        for (var i = 0; i < results.length; i++) {
                            createMarker(results[i]);
                        }
                    }
                }

                function createMarker(place) {
                    var placeLoc = place.geometry.location;
                    var marker = new google.maps.Marker({
                        map: map,
                        icon: 'img/suburb_map/gym01.jpg',
                        position: place.geometry.location
                    });
                    google.maps.event.addListener(marker, 'click', function () {
                        Extrainfowindow.setContent(place.name);
                        Extrainfowindow.open(map, this);
                    });
                }

                //***********************Ask for park*****************************
                function ShowParkOnMap() {
                    var pyrmont = {lat: Lati, lng: Longi};

                    Extrainfowindow = new google.maps.InfoWindow();
                    var service = new google.maps.places.PlacesService(map);
                    service.nearbySearch({
                        location: pyrmont,
                        radius: 1000,
                        type: ['park']
                    }, callbackPark);
                }

                function callbackPark(results, status) {
                    if (status === google.maps.places.PlacesServiceStatus.OK) {
                        for (var i = 0; i < results.length; i++) {
                            createMarkerPark(results[i]);
                        }
                    }
                }

                function createMarkerPark(place) {
                    var marker = new google.maps.Marker({
                        map: map,
                        icon: 'img/suburb_map/park02.jpg',
                        position: place.geometry.location
                    });
                    google.maps.event.addListener(marker, 'click', function () {
                        Extrainfowindow.setContent(place.name);
                        Extrainfowindow.open(map, this);
                    });
                }

            </script>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC2gASlQ9PrJIPLkX8Ekks_LcGY4pEe830&callback=initMap&libraries=places" async defer></script>
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
