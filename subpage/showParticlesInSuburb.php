<html>
    <head>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    </head>

    <body>
        <?php
        session_start();
        $id = $_SESSION['id'];
//echo "welcome, ", $id;

        $connectionString = mysqli_connect('localhost', 'root', '');
        if (!$connectionString) {
            die('Failed to connect to database....');
        } else {
            //Variables to keep the postcode and particles of the suburb of the user.
            $postcode = "";
            $co = "";
            $ozon = "";
            $nitrogen_dioxide = "";
            $sulfur_dioxide = "";
            $pm_two_five = "";
            $pm_ten = "";

            //To keep the colors
            $co_color = "";
            $ozon_color = "";
            $nitrogen_dioxide_color = "";
            $sulfur_dioxide_color = "";
            $pm_two_five_color = "";
            $pm_ten_color = "";

            //To keep tooltips
            $co_tooltip = "";
            $ozon_tooltip = "";
            $nitrogen_dioxide_tooltip = "";
            $sulfur_dioxide_tooltip = "";
            $pm_two_five_tooltip = "";
            $pm_ten_tooltip = "";

            mysqli_select_db($connectionString, 'dbcleanmelbourne');

            //To get the postcode of user
            $query = "select tt.su_postcode from suburb tt,  user uu where uu.user_suburb_id = tt.su_id and uu.user_id =$id";
            $result = mysqli_query($connectionString, $query);

            while ($row = mysqli_fetch_array($result)) {
                $postcode = $row['su_postcode'];
            }
            //echo "Your postcode is: ", $postcode, "<br>";
            //to select the air quality measurements from DB according to the postcode of the suburb
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
            }
            mysqli_close($connectionString);
            //echo $ozon, "<br>";
            //Setting different colors for different amount of particles
            if (($co >= 0) && ($co <= 2.9)) { //CO
                $co_color = "green";
                $co_tooltip = "According to EPA standard, The amount is bellow standard.";
            } elseif (($co >= 3.0) && ($co <= 5.8)) {
                $co_color = "blue";
                $co_tooltip = "According to EPA standard, The amount is bellow standard.";
            } elseif (($co >= 5.9) && ($co <= 8.9)) {
                $co_color = "yellow";
                $co_tooltip = "According to EPA standard, The amount is bellow standard.";
            } elseif (($co >= 9.0 ) && ($co <= 13.4)) {
                $co_color = "red";
                $co_tooltip = "Carbon monoxide is taken up by blood much more readily than oxygen is, " +
                        "so relatively small amounts of it in inhaled air can affect essential body processes, " +
                        "Prolonged exposure to carbon monoxide can cause tissue damage. People suffering from cardiovascular disease are particularly at risk.";
            } elseif ($co >= 13.5) {
                $co_color = "black";
                $co_tooltip = "Carbon monoxide is taken up by blood much more readily than oxygen is, " +
                        "so relatively small amounts of it in inhaled air can affect essential body processes, " +
                        "Prolonged exposure to carbon monoxide can cause tissue damage. People suffering from cardiovascular disease are particularly at risk.";
            }

            if (($ozon >= 0) && ($ozon <= 26)) {
                $ozon_color = "green";
                $ozon_tooltip = "Azzording to EPA, the amount is below standard.";
            } elseif (($ozon >= 27) && ($ozon <= 52)) {
                $ozon_color = "blue";
                $ozon_tooltip = "Azzording to EPA, the amount is below standard.";
            } elseif (($ozon >= 53) && ($ozon <= 79)) {
                $ozon_color = "yellow";
                $ozon_tooltip = "Azzording to EPA, the amount is very good";
            } elseif (($ozon >= 80) && ($ozon <= 119)) {
                $ozon_color = "red";
                $ozon_tooltip = "Ozone is very reactive, affecting the linings of the throat and lungs," +
                        "restricting the air passages and making breathing difficult. It also increases the risk of respiratory infections. " +
                        "Ozone is of greater concern for the elderly and those with existing lung disease";
            } elseif ($ozon >= 120) {
                $ozon_color = "black";
                $ozon_tooltip = "Ozone is very reactive, affecting the linings of the throat and lungs," +
                        "restricting the air passages and making breathing difficult. It also increases the risk of respiratory infections. " +
                        "Ozone is of greater concern for the elderly and those with existing lung disease";
            }
            if (($nitrogen_dioxide >= 0) && ($nitrogen_dioxide <= 39)) { //No2
                $nitrogen_dioxide_color = "green";
                $nitrogen_dioxide_tooltip = "According to EPA, the amount is low";
            } elseif (($nitrogen_dioxide >= 40) && ($nitrogen_dioxide <= 78)) {
                $nitrogen_dioxide_color = "blue";
                $nitrogen_dioxide_tooltip = "According to EPA, the amount is low";
            } elseif (($nitrogen_dioxide >= 79) && ($nitrogen_dioxide <= 119)) {
                $nitrogen_dioxide_color = "yellow";
                $nitrogen_dioxide_tooltip = "According to EPA, the amount is good";
            } elseif (($nitrogen_dioxide >= 120) && ($nitrogen_dioxide <= 179)) {
                $nitrogen_dioxide_color = "red";
                $nitrogen_dioxide_tooltip = "Nitrogen dioxide is known to affect the throat and the lungs. " +
                        "In levels encountered in polluted air, people with respiratory problems, particularly infants, children and the elderly," +
                        "may be affected. People with asthma are often sensitive to nitrogen dioxide.";
            } elseif ($nitrogen_dioxide >= 180) {
                $nitrogen_dioxide_color = "black";
                $nitrogen_dioxide_tooltip = "Nitrogen dioxide is known to affect the throat and the lungs. " +
                        "In levels encountered in polluted air, people with respiratory problems, particularly infants, children and the elderly," +
                        "may be affected. People with asthma are often sensitive to nitrogen dioxide.";
            }
            if (($sulfur_dioxide >= 0) && ($sulfur_dioxide <= 65)) {
                $sulfur_dioxide_color = "green";
                $sulfur_dioxide_tooltip = "According to EAP, the amount is very good";
            } elseif (($sulfur_dioxide >= 66) && ($sulfur_dioxide <= 131)) {
                $sulfur_dioxide_color = "blue";
                $sulfur_dioxide_tooltip = "According to EAP, the amount is good";
            } elseif (($sulfur_dioxide >= 132) && ($sulfur_dioxide <= 199)) {
                $sulfur_dioxide_color = "yellow";
                $sulfur_dioxide_tooltip = "According to EAP, the amount is fair";
            } elseif (($sulfur_dioxide >= 200) && ($sulfur_dioxide <= 299)) {
                $sulfur_dioxide_color = "red";
                $sulfur_dioxide_tooltip = "Sulfur dioxide is an irritant gas that attacks the throat and lungs." +
                        "Its effect on health is increased by the presence of airborne particles. " +
                        "Prolonged exposure to sulfur dioxide can lead to increases in respiratory illnesses like chronic bronchitis";
            } elseif ($sulfur_dioxide >= 300) {
                $sulfur_dioxide_color = "black";
                $sulfur_dioxide_tooltip = "Sulfur dioxide is an irritant gas that attacks the throat and lungs." +
                        "Its effect on health is increased by the presence of airborne particles. " +
                        "Prolonged exposure to sulfur dioxide can lead to increases in respiratory illnesses like chronic bronchitis";
            }
            if (($pm_two_five >= 0) && ($pm_two_five <= 8)) { //PM2.5
                $pm_two_five_color = "green";
                $pm_two_five_tooltip = "It meets EPA standard requirements.";
            } elseif (($pm_two_five >= 9) && ($pm_two_five <= 25)) {
                $pm_two_five_color = "blue";
                $pm_two_five_tooltip = "No tailored advice necessary. General air quality information and health advice is available from the EPA
                                Victoria and the Department of Health and Human Services websites.";
            } elseif (($pm_two_five >= 26) && ($pm_two_five <= 39)) {
                $pm_two_five_color = "yellow";
                $pm_two_five_tooltip = "People over 65, children 14 years and younger, pregnant women and those with existing heart or lung
                                conditions, should reduce* prolonged or heavy physical activity. Where possible, these people in the
                                community should also limit the time spent outdoors.
                                No specific message for everyone else other than sensitive groups.";
            } elseif (($pm_two_five >= 40) && ($pm_two_five <= 106)) {
                $pm_two_five_color = "orange";
                $pm_two_five_tooltip = "Everyone should reduce* prolonged or heavy physical activity. People over 65, children 14 years and younger,
                                pregnant women and those with existing heart or lung conditions should avoid prolonged or heavy physical
                                activity altogether.";
            } elseif (($pm_two_five >= 107) && ($pm_two_five <= 177)) {
                $pm_two_five_color = "red";
                $pm_two_five_tooltip = "Everyone should avoid prolonged or heavy physical activity. People over 65, children 14 years and younger,
                                pregnant women and those with existing heart or lung conditions should avoid all physical activity outdoors.
                                Consider closing some or all schools and early childhood centres and rescheduling outdoor events (such as
                                concerts and competitive sports) until air quality improves.";
            } elseif (($pm_two_five >= 178) && ($pm_two_five <= 249)) {
                $pm_two_five_color = "brown";
                $pm_two_five_tooltip = "Everyone should avoid all physical activity outdoors. People over 65, children 14 years and younger, pregnant
                                women and those with existing heart or lung conditions should temporarily relocate to a friend or relative
                                living outside the smoke-affected area. If this is not possible, remain indoors and keep activity levels as low
                                as possible.";
            } elseif ($pm_two_five >= 250) {
                $pm_two_five_color = "black";
                $pm_two_five_tooltip = "Cautionary health advice/actions the same as for Hazardous high above except for sensitive groups.
                                Sensitive groups: If the 24 hour rolling average PM2.5 values remain in this category for two days and are
                                predicted to continue at this level or increase:
                                People over 65, children 14 years and younger, pregnant women and those with existing heart or lung
                                conditions are strongly recommended to temporarily relocate until there is sustained improvement
                                in air quality.";
            }
            //echo "PM10 is: ",$pm_ten;
        }
        ?>
        <div id="columnchart_values" style="height: 100%; width: 100%"></div>

        <!-- some hiddden elelemts to keep the amount and color of the particles -->
        <!-- CO -->
        <div hidden="true">
        <input type="hidden" name="co_amount" id="co_amount" value=<?php echo $co; ?>>
        <input type="hidden" name="co_color" id="co_color" value=<?php echo $co_color; ?>>
        <textarea id="co_tooltip" style="visibility: hidden" rows="6" cols="70"><?php echo $co_tooltip; ?></textarea>


        <!-- O3 (ozon) -->
        <input type="hidden" name="ozon_amount" id="ozon_amount" value=<?php echo $ozon; ?>>
        <input type="hidden" name="ozon_color" id="ozon_color" value=<?php echo $ozon_color; ?>>
        <textarea id="ozon_tooltip" style="visibility: hidden" rows="6" cols="70"><?php echo $ozon_tooltip; ?></textarea>


        <!--No2 (nitrogen dioxide)-->
        <input type="hidden" name="nitrogen_dioxide_amount" id="nitrogen_dioxide_amount" value=<?php echo $nitrogen_dioxide; ?>>
        <input type="hidden" name="nitrogen_dioxide_color" id="nitrogen_dioxide_color" value=<?php echo $nitrogen_dioxide_color; ?>>
        <textarea id="nitrogen_dioxide_tooltip" style="visibility: hidden" rows="6" cols="70"><?php echo $nitrogen_dioxide_tooltip; ?></textarea>

        <!-- So2 -->
        <input type="hidden" name="sulfur_dioxide_amount" id="sulfur_dioxide_amount" value=<?php echo $sulfur_dioxide; ?>>
        <input type="hidden" name="sulfur_dioxide_color" id="sulfur_dioxide_color" value=<?php echo $sulfur_dioxide_color; ?>>
        <textarea id="sulfur_dioxide_tooltip" style="visibility: hidden" rows="6" cols="70"><?php echo $sulfur_dioxide_tooltip; ?></textarea>

        <!-- PM2.5 -->
        <input type="hidden" name="pm_two_five_amount" id="pm_two_five_amount" value=<?php echo $pm_two_five; ?>>
        <input type="hidden" name="pm_two_five_color" id="pm_two_five_color" value=<?php echo $pm_two_five_color; ?>>
        <textarea id="pm_two_five_tooltip" style="visibility: hidden" rows="6" cols="70"><?php echo $pm_two_five_tooltip; ?></textarea>
        <!-- PM10 -->
        <input type="hidden" name="pm_ten_amount" id="pm_ten_amount" value=<?php echo $pm_ten; ?>>
        <input type="hidden" name="pm_ten_color" id="pm_ten_color" value=<?php echo $pm_ten_color; ?>>
        <textarea id="pm_ten_tooltip" style="visibility: hidden" rows="6" cols="70"><?php echo $pm_ten_tooltip; ?></textarea>
        </div>
    </body>

    <script>
        google.charts.load("current", {packages: ['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            //CO
            var co_amount = document.getElementById("co_amount");
            var co_amount_float = parseFloat(co_amount.value);
            var co_col = document.getElementById("co_color");
            var co_tool = document.getElementById("co_tooltip");
            //ozon (o3)
            var ozon_amount = document.getElementById("ozon_amount");
            var ozon_amount_float = parseInt(ozon_amount.value)
            var ozon_col = document.getElementById("ozon_color");
            var ozon_tool = document.getElementById("ozon_tooltip");
            //No2
            var nitrogen_amount = document.getElementById("nitrogen_dioxide_amount");
            var nitrogen_amount_float = parseFloat(nitrogen_amount.value);
            var nitrogen_color = document.getElementById("nitrogen_dioxide_color");
            var nitrogen_tool = document.getElementById("nitrogen_dioxide_tooltip");
            //So2
            var sulfur_amount = document.getElementById("sulfur_dioxide_amount");
            var sulfur_amount_float = parseFloat(sulfur_amount.value);
            var sulfur_color = document.getElementById("sulfur_dioxide_color");
            var sulfur_tool = document.getElementById("sulfur_dioxide_tooltip");
            //PM2.5
            var pm_two_five_amount = document.getElementById("pm_two_five_amount");
            var pm_two_five_float = parseFloat(pm_two_five_amount.value);
            var pm_two_five_color = document.getElementById("pm_two_five_color");
            var pm_two_five_tool = document.getElementById("pm_two_five_tooltip");
            //PM10
            var pm_ten_amount = document.getElementById("pm_ten_amount");
            var pm_ten_float = parseFloat(pm_ten_amount.value);
            var pm_ten_color = document.getElementById("pm_ten_color");
            var pm_ten_tool = document.getElementById("pm_ten_tooltip");


            /*var dataTable = new google.visualization.DataTable();
             dataTable.addColumn('string', 'Element');
             dataTable.addColumn('number', 'Density');
         
             dataTable.addColumn({type: 'string', role: 'style'});
             dataTable.addColumn({type: 'string', role: 'tooltip'});
             dataTable.addRows([
             ["Co", co_amount_float, co_col.value,"The amount is below standard"],
             ["ozon", ozon_amount_float, ozon_col.value,"Salam"],
             ["nitrogen dioxide", nitrogen_amount_float, nitrogen_color.value,"Hi"],
             ["sulfur dioxide", sulfur_amount_float, sulfur_color.value,"Hi"],
             ["PM2.5",pm_two_five_float,pm_two_five_color.value,"Hi"],
             ["PM10",pm_ten_float,pm_ten_color.value,"Hi"]]);*/

            var dataTable = google.visualization.arrayToDataTable([
                ["Element", "Density", {role: "style"}, {role: 'annotation'}, {role: 'tooltip'}],
                ["CO", co_amount_float, co_col.value, co_amount_float, co_tool.value],
                ["ozone", ozon_amount_float, ozon_col.value, ozon_amount_float, ozon_tool.value],
                ["nitrogen dioxide", nitrogen_amount_float, nitrogen_color.value, nitrogen_amount_float, nitrogen_tool.value],
                ["sulfur dioxide", sulfur_amount_float, sulfur_color.value, sulfur_amount_float, sulfur_tool.value],
                ["PM2.5", pm_two_five_float, pm_two_five_color.value, pm_two_five_float, pm_two_five_tool.value],
                ["PM10", pm_ten_float, pm_ten_color.value, pm_ten_float, pm_ten_tool.value]
            ]);


            var options = {
                title: "Amount of particles in air, Today",
                bar: {groupWidth: "65%"},
                legend: {position: "none"},
            };

            var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
            chart.draw(dataTable, options);
        }

    </script>


</html>
