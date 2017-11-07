<html>

    <head>

        <title>New Breath</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

        <script>
            var ccc;
            window.setTimeout('clickit()', 3000);
            function clickit() {
                document.getElementById("link").click();
            }

        </script>
    </head>
    <body>
        <?php
        $graph_year = date("Y");
        $air_station_id = "0";

        session_start();
        $id = $_SESSION['id'];


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $graph_year = $_POST['analysis_year'];
        }
//echo "welcome ",$id, "<br>";
        $_SESSION['year'] = $graph_year;
//$_SESSION['userid_'] = $id;
//variables to get from database
        $Jan_VG = "0";
        $Jan_G = "0";
        $Jan_ok = "0";
        $Jan_NG = "0";
        $Feb_VG = "0";
        $Feb_G = "0";
        $FEb_ok = "0";
        $Feb_NG = "0";
        $Mar_VG = "0";
        $Mar_G = "0";
        $Mar_ok = "0";
        $Mar_NG = "0";
        $AP_VG = "0";
        $AP_G = "0";
        $AP_ok = "0";
        $AP_NG = "0";
        $May_VG = "0";
        $May_G = "0";
        $May_ok = "0";
        $May_NG = "0";
        $Jun_VG = "0";
        $Jun_G = "0";
        $Jun_ok = "0";
        $Jun_NG = "0";
        $Jul_VG = "0";
        $Jul_G = "0";
        $Jul_ok = "0";
        $Jul_NG = "0";
        $Aug_VG = "0";
        $Aug_G = "0";
        $Aug_ok = "0";
        $Aug_NG = "0";
        $Sep_VG = "0";
        $Sep_G = "0";
        $Sep_ok = "0";
        $Sep_NG = "0";
        $Oct_VG = "0";
        $Oct_G = "0";
        $Oct_ok = "0";
        $Oct_NG = "0";
        $Nov_VG = "0";
        $Nov_G = "0";
        $Nov_ok = "0";
        $Nov_NG = "0";
        $Dec_VG = "0";
        $Dec_G = "0";
        $Dec_ok = "0";
        $Dec_NG = "0";

        $connectionString = mysqli_connect('localhost', 'root', '');
        if (!$connectionString) {
            die('Failed to connect to database....');
        } else {
            mysqli_select_db($connectionString, 'dbcleanmelbourne');
            //Getting the nearest air station of suburb where user lives

            $air_station_query = "select ss.su_id, ss.su_postcode, ss.su_name, ast.st_name, ast.st_postcode, ast.st_id  
                            from suburb ss, user uu, airstation ast
                            where (uu.user_suburb_id = ss.su_id) and (uu.user_id = '$id') and (ast.st_postcode >= ss.su_postcode)
                            order by ast.st_postcode
                            limit 1";
            $air_station_result = mysqli_query($connectionString, $air_station_query);
            while ($air_station_row = mysqli_fetch_array($air_station_result)) {
                $air_station_id = $air_station_row['st_id'];
            }

            $query = "select dd.di_feeling_status,MONTH(dd.di_date) as mon, count(*) as cnt 
                from diary dd 
                where (dd.di_user_id = '$id') and (YEAR(dd.di_date) = '$graph_year')
                group by dd.di_feeling_status,MONTH(dd.di_date)
                order by MONTH(dd.di_date)";
            $result = mysqli_query($connectionString, $query);

            while ($row = mysqli_fetch_array($result)) {
                if ($row['mon'] == 1) { //January
                    switch ($row['di_feeling_status']) {
                        case 1: {
                                $Jan_VG = $row['cnt'];
                                break;
                            }
                        case 2: {
                                $Jan_G = $row['cnt'];
                                break;
                            }
                        case 3: {
                                $Jan_ok = $row['cnt'];
                                break;
                            }
                        case 4: {
                                $Jan_NG = $row['cnt'];
                                break;
                            }
                    }
                } elseif ($row['mon'] == 2) { //February
                    switch ($row['di_feeling_status']) {
                        case 1: {
                                $Feb_VG = $row['cnt'];
                                break;
                            }
                        case 2: {
                                $Feb_G = $row['cnt'];
                                break;
                            }

                        case 3: {
                                $FEb_ok = $row['cnt'];
                                break;
                            }
                        case 4: {
                                $Feb_NG = $row['cnt'];
                                break;
                            }
                    }
                } elseif ($row['mon'] == 3) {//March
                    switch ($row['di_feeling_status']) {
                        case "1": {
                                $Mar_VG = $row['cnt'];
                                break;
                            }
                        case "2": {
                                $Mar_G = $row['cnt'];
                                break;
                            }
                        case "3": {
                                $Mar_ok = $row['cnt'];
                                break;
                            }
                        case "4": {
                                $Mar_NG = $row['cnt'];
                                break;
                            }
                    }
                } elseif ($row['mon'] == 4) {//April
                    switch ($row['di_feeling_status']) {
                        case 1: {
                                $AP_VG = $row['cnt'];
                                break;
                            }
                        case 2: {
                                $AP_G = $row['cnt'];
                                break;
                            }
                        case 3: {
                                $AP_ok = $row['cnt'];
                                break;
                            }
                        case 4: {
                                $AP_NG = $row['cnt'];
                                break;
                            }
                    }
                } elseif ($row['mon'] == 5) {//May
                    switch ($row['di_feeling_status']) {
                        case 1: {
                                $May_VG = $row['cnt'];
                                break;
                            }
                        case 2: {
                                $May_G = $row['cnt'];
                                break;
                            }
                        case 3: {
                                $May_ok = $row['cnt'];
                                break;
                            }
                        case 4: {
                                $May_NG = $row['cnt'];
                                break;
                            }
                    }
                } elseif ($row['mon'] == 6) {//June
                    switch ($row['di_feeling_status']) {
                        case 1: {
                                $Jun_VG = $row['cnt'];
                                break;
                            }
                        case 2: {
                                $Jun_G = $row['cnt'];
                                break;
                            }
                        case 3: {
                                $Jun_ok = $row['cnt'];
                                break;
                            }
                        case 4: {
                                $Jun_VG = $row['cnt'];
                                break;
                            }
                    }
                } elseif ($row['mon'] == 7) { //July
                    switch ($row['di_feeling_status']) {
                        case 1: {
                                $Jul_VG = $row['cnt'];
                                break;
                            }
                        case 2: {
                                $Jul_G = $row['cnt'];
                                break;
                            }
                        case 3: {
                                $Jul_ok = $row['cnt'];
                                break;
                            }
                        case 4: {
                                $Jul_NG = $row['cnt'];
                                break;
                            }
                    }
                } elseif ($row['mon'] == 8) {//August
                    switch ($row['di_feeling_status']) {
                        case 1: {
                                $Aug_VG = $row['cnt'];
                                break;
                            }
                        case 2: {
                                $Aug_G = $row['cnt'];
                                break;
                            }
                        case 3: {
                                $Aug_ok = $row['cnt'];
                                break;
                            }
                        case 4: {
                                $Aug_NG = $row['cnt'];
                                break;
                            }
                    }
                } elseif ($row['mon'] == 9) {//September
                    switch ($row['di_feeling_status']) {
                        case 1: {
                                $Sep_VG = $row['cnt'];
                                break;
                            }
                        case 2: {
                                $Sep_G = $row['cnt'];
                                break;
                            }
                        case 3: {
                                $Sep_ok = $row['cnt'];
                                break;
                            }
                        case 4: {
                                $Sep_NG = $row['cnt'];
                                break;
                            }
                    }
                } elseif ($row['mon'] == 10) { //October
                    switch ($row['di_feeling_status']) {
                        case 1: {
                                $Oct_NG = $row['cnt'];
                                break;
                            }
                        case 2: {
                                $Oct_G = $row['cnt'];
                                break;
                            }
                        case 3: {
                                $Oct_ok = $row['cnt'];
                                break;
                            }
                        case 4: {
                                $Oct_NG = $row['cnt'];
                                break;
                            }
                    }
                } elseif ($row['mon'] == 11) {//November
                    switch ($row['di_feeling_status']) {
                        case 1: {
                                $Nov_VG = $row['cnt'];
                                break;
                            }
                        case 2: {
                                $Nov_G = $row['cnt'];
                                break;
                            }
                        case 3: {
                                $Nov_ok = $row['cnt'];
                                break;
                            }
                        case 4: {
                                $Nov_NG = $row['cnt'];
                                break;
                            }
                    }
                } elseif ($row['mon'] == 12) {//December
                    switch ($row['di_feeling_status']) {
                        case 1: {
                                $Dec_VG = $row['cnt'];
                                break;
                            }
                        case 2: {
                                $Dec_G = $row['cnt'];
                                break;
                            }
                        case 3: {
                                $Dec_ok = $row['cnt'];
                                break;
                            }
                        case 4: {
                                $Dec_NG = $row['cnt'];
                                break;
                            }
                    }
                }
            }
            //*****************Spring Pie Chart********************
            //variables for keeping the feelings
            $spring_chart_veryGood = "0";
            $spring_chart_Good = "0";
            $spring_chart_fair = "0";
            $spring_chart_poor = "0";
            $spring_chart_verypoor = "0";
            //Get the query for spring pie chart
            $spring_chart_query = "select '1' as stat, count(*) as cnt from airquality_yearly aqiy
                            where (aqiy.st_id = '$air_station_id') and (YEAR(aqiy.aqy_date) = '$graph_year') and (MONTH(aqiy.aqy_date) between '9' and '11')
                            and (aqiy.aqy_aqi BETWEEN '0' and '33')
                            UNION
                            select '2' as stat, count(*) as cnt from airquality_yearly aqiy
                            where (aqiy.st_id = '$air_station_id') and (YEAR(aqiy.aqy_date) = '$graph_year') and (MONTH(aqiy.aqy_date) between '9' and '11')
                            and (aqiy.aqy_aqi BETWEEN '34' and '66')
                            UNION
                            select '3' as stat, count(*) as cnt from airquality_yearly aqiy
                            where (aqiy.st_id = '$air_station_id') and (YEAR(aqiy.aqy_date) = '$graph_year') and (MONTH(aqiy.aqy_date) between '9' and '11')
                            and (aqiy.aqy_aqi BETWEEN '67' and '99')
                            UNION
                            select '4' as stat, count(*) as cnt from airquality_yearly aqiy
                            where (aqiy.st_id = '$air_station_id') and (YEAR(aqiy.aqy_date) = '$graph_year') and (MONTH(aqiy.aqy_date) between '9' and '11')
                            and (aqiy.aqy_aqi BETWEEN '100' and '149')
                            UNION
                            select '5' as stat, count(*) as cnt from airquality_yearly aqiy
                            where (aqiy.st_id = '$air_station_id') and (YEAR(aqiy.aqy_date) = '$graph_year') and (MONTH(aqiy.aqy_date) between '9' and '11')
                            and (cast(aqiy.aqy_aqi as UNSIGNED) BETWEEN '150' and '250')";

            $spring_chart_result = mysqli_query($connectionString, $spring_chart_query);
            if (!$spring_chart_result) {
                echo mysqli_error($connectionString), "<br>";
                echo mysqli_errno($connectionString);
                mysqli_close($connectionString);
            } else {
                /* echo "Hello Azi....", "<br>";
                  echo $graph_year , "<br>";
                  echo $air_station_id , "<br>"; */
                while ($spring_chart_row = mysqli_fetch_array($spring_chart_result)) {
                    /* echo $spring_chart_row['cnt'], "<br>";
                      echo $spring_chart_row['stat'], "<br>"; */
                    switch ($spring_chart_row['stat']) {
                        case 1: {
                                $spring_chart_veryGood = $spring_chart_row['cnt'];
                                break;
                            }
                        case 2: {
                                $spring_chart_Good = $spring_chart_row['cnt'];
                                break;
                            }
                        case 3: {
                                $spring_chart_fair = $spring_chart_row['cnt'];
                                break;
                            }
                        case 4: {
                                $spring_chart_poor = $spring_chart_row['cnt'];
                                break;
                            }
                        case 5: {
                                $spring_chart_verypoor = $spring_chart_row['cnt'];
                                break;
                            }
                    }
                }
            } //************************* end of spring pie chart **********************
        }
        ?>
        <form id="frmGraph" method="post" action="#">

            <br><p>This tab displays your health condition based on Month.</p>
            <p>Please select a year to see the analysis results:</p>
            <p>Year: <select class="btn btn-default" name="analysis_year" id="analysis_year">
                    <option value="0">Select year</option>
                    <?php
                    for ($y = 1; $y <= 8; $y++) {
                        $yy = 2013 + $y;
                        ?>
                        <option value="<?php echo $yy ?>"><?php echo $yy ?></option>
                    <?php } ?>

                </select>   <input type="submit" id="btnShowGraph" name="Show Graph" value="Show Graph" class="btn btn-primary">

            </p>

            <div id="columnchart_material" style="width: 100%; height: fit-content"></div>

            <ul class="nav nav-tabs">
                <li><a data-toggle="tab" href="#spring" id="link">Spring</a></li>
                <li class="active"><a data-toggle="tab" href="#summer">Summer</a></li>
                <li><a data-toggle="tab" href="#autumn" id="link_autumn">Autumn</a></li>
                <li><a data-toggle="tab" href="#winter" id="diary_winter">Winter</a></li>
                <li><a data-toggle="tab" href="#symptomAnalysis" id="symptom">Analysis of your Symptoms</a></li>
            </ul>

            <div class="tab-content">
                <div id="spring" class="tab-pane fade in active" style="padding: 0; width: 100%">
                    <?php
                    echo "<br>", "The chart below displays the air quality in spring in your suburb in ", $graph_year, "<br>";
                    echo "In Australia, spring starts from September to November.", "<br>";
                    ?>
                    <div id="piechart" style="width: 100%; height: 300px"></div>
                </div>

                <div id="summer" class="tab-pane fade in in active" style="padding: 0">
                    <?php include "showHealthMonthSummer.php" ?>
                </div>

                <div id="autumn" class="tab-pane fade in in active" style="padding: 0">
                    <!-- <iframe src="showHealthMonthAutumn.php" class="mod" style="height: 50%"></iframe> -->
                    <?php include "showHealthMonthAutumn.php"; ?>
                </div>

                <div id="winter" class="tab-pane fade in active" style="padding: 0">
                    <!-- <iframe src="showHealthMonthWinter.php" class="mod" style="height: 50%"></iframe> -->
                    <?php include "showHealthMonthWinter.php"; ?>
                </div>
                <div id="symptomAnalysis" class="tab-pane fade in active" style="padding: 0">
                    <!-- <iframe src="showHealthMonthWinter.php" class="mod" style="height: 50%"></iframe> -->
                    <?php include "symptomAnalysis.php"; ?>
                </div>
            </div>
        </form>

    </body>

    <script>

        /*function relaodPage() {
         location.reload(false);
         }*/

        google.charts.load('current', {'packages': ['bar', 'corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Month', 'Very Good', 'Good', 'OK', 'Not Good'],
                ['Jan', <?php echo $Jan_VG; ?>, <?php echo $Jan_G; ?>, <?php echo $Jan_ok; ?>, <?php echo $Jan_NG; ?>],
                ['Feb', <?php echo $Feb_VG; ?>, <?php echo $Feb_G; ?>, <?php echo $FEb_ok; ?>, <?php echo $Feb_NG; ?>],
                ['March', <?php echo $Mar_VG ?>, <?php echo $Mar_G ?>, <?php echo $Mar_ok ?>, <?php echo $Mar_NG ?>],
                ['April', <?php echo $AP_VG ?>, <?php echo $AP_G ?>, <?php echo $AP_ok ?>, <?php echo $AP_NG ?>],
                ['May',<?php echo $May_VG ?>,<?php echo $May_G ?>,<?php echo $May_ok ?>,<?php echo $May_NG ?>],
                ['June',<?php echo $Jun_VG ?>,<?php echo $Jun_G ?>,<?php echo $Jun_ok ?>,<?php echo $Jun_NG ?>],
                ['July',<?php echo $Jul_VG ?>,<?php echo $Jul_G ?>,<?php echo $Jul_ok ?>,<?php echo $Jul_NG ?>],
                ['August',<?php echo $Aug_VG ?>,<?php echo $Aug_G ?>,<?php echo $Aug_ok ?>,<?php echo $Aug_NG ?>],
                ['Sep',<?php echo $Sep_VG ?>,<?php echo $Sep_G ?>,<?php echo $Sep_ok ?>,<?php echo $Sep_NG ?>],
                ['Oct',<?php echo $Oct_VG ?>,<?php echo $Oct_G ?>,<?php echo $Oct_ok ?>,<?php echo $Oct_NG ?>],
                ['Nov',<?php echo $Nov_VG ?>,<?php echo $Nov_G ?>,<?php echo $Nov_ok ?>,<?php echo $Nov_NG ?>],
                ['Dec',<?php echo $Dec_VG ?>,<?php echo $Dec_G ?>,<?php echo $Dec_ok ?>,<?php echo $Dec_NG ?>]
            ]);

            var options = {
                legend: {position: "bottom left"},
                bar: {groupWidth: "70%"},
            };

            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
            chart.draw(data, options);
        }

        google.charts.setOnLoadCallback(drawPieChart);
        function drawPieChart() {

            var pie_data = google.visualization.arrayToDataTable([
                ['Quality', 'Number of Days'],
                ['Very Good', <?php echo $spring_chart_veryGood ?>],
                ['Good', <?php echo $spring_chart_Good ?>],
                ['Fair', <?php echo $spring_chart_fair ?>],
                ['Poor', <?php echo $spring_chart_poor ?>]
            ]);

            var pie_options = {
                title: 'Quality of air in Spring',
                legend: {position: 'bottom'},
                pieSliceText: 'percentage',
                colors: ['#009955', '#559900', '#e6b800', '#ff8000', '#cc0000'],
            };

            var pie_chart = new google.visualization.PieChart(document.getElementById('piechart'));

            pie_chart.draw(pie_data, pie_options);
        }
    </script>
</html>
