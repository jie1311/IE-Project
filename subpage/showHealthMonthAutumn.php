<?php
    echo "<br>","The chart below displays the air quality in Autumn in your suburb in ", $graph_year, "<br>";
    echo "In Australia, Autumn starts from March to May.", "<br>";

//*****************Summer Pie Chart********************
$autumn_chart_veryGood = "0";
$autumn_chart_Good = "0";
$autumn_chart_fair = "0";
$autumn_chart_poor = "0";
$autumn_chart_verypoor = "0";
//Get the query for summer pie chart
$autumn_chart_query = "select '1' as stat, count(*) as cnt from airquality_yearly aqiy
                            where (aqiy.st_id = '$air_station_id') and (YEAR(aqiy.aqy_date) = '$graph_year') and (MONTH(aqiy.aqy_date) between '3' and '5')
                            and (aqiy.aqy_aqi BETWEEN '0' and '33')
                            UNION
                            select '2' as stat, count(*) as cnt from airquality_yearly aqiy
                            where (aqiy.st_id = '$air_station_id') and (YEAR(aqiy.aqy_date) = '$graph_year') and (MONTH(aqiy.aqy_date) between '3' and '5')
                            and (aqiy.aqy_aqi BETWEEN '34' and '66')
                            UNION
                            select '3' as stat, count(*) as cnt from airquality_yearly aqiy
                            where (aqiy.st_id = '$air_station_id') and (YEAR(aqiy.aqy_date) = '$graph_year') and (MONTH(aqiy.aqy_date) between '3' and '5')
                            and (aqiy.aqy_aqi BETWEEN '67' and '99')
                            UNION
                            select '4' as stat, count(*) as cnt from airquality_yearly aqiy
                            where (aqiy.st_id = '$air_station_id') and (YEAR(aqiy.aqy_date) = '$graph_year') and (MONTH(aqiy.aqy_date) between '3' and '5')
                            and (aqiy.aqy_aqi BETWEEN '100' and '149')
                            UNION
                            select '5' as stat, count(*) as cnt from airquality_yearly aqiy
                            where (aqiy.st_id = '$air_station_id') and (YEAR(aqiy.aqy_date) = '$graph_year') and (MONTH(aqiy.aqy_date) between '3' and '5')
                            and (cast(aqiy.aqy_aqi as UNSIGNED) BETWEEN '150' and '250')";

$autumn_chart_result = mysqli_query($connectionString,$autumn_chart_query);
if(!$autumn_chart_result)
{
    echo mysqli_error($connectionString), "<br>";
    echo mysqli_errno($connectionString);
    mysqli_close($connectionString);
}
else
{
    /*echo "Hello Azi....", "<br>";
   echo $graph_year , "<br>";
   echo $air_station_id , "<br>";*/

    while ($autumn_chart_row = mysqli_fetch_array($autumn_chart_result)) {

         /*echo $autumn_chart_row['cnt'], "<br>";
         echo $autumn_chart_row['stat'], "<br>";*/

        switch ($autumn_chart_row['stat']) {
            case 1: {
                $autumn_chart_veryGood = $autumn_chart_row['cnt'];
                break;
            }
            case 2: {
                $autumn_chart_Good = $autumn_chart_row['cnt'];
                break;
            }
            case 3: {
                $autumn_chart_fair = $autumn_chart_row['cnt'];
                break;
            }
            case 4: {
                $autumn_chart_poor = $autumn_chart_row['cnt'];
                break;
            }
            case 5:
            {
                $autumn_chart_verypoor = $autumn_chart_row['cnt'];
                break;
            }
        }
    }
}
?>
<div id="AutumnPieChart" style="width: 100%; height: 300px"></div>
<script>

    google.charts.setOnLoadCallback(drawAutumnPieChart);
    function drawAutumnPieChart() {

        var autumn_pie_data = google.visualization.arrayToDataTable([
            ['Quality', 'Number of Days'],
            ['Very Good', <?php echo $autumn_chart_veryGood ?>],
            ['Good', <?php echo $autumn_chart_Good ?>],
            ['Fair', <?php echo $autumn_chart_fair ?>],
            ['Poor', <?php echo $autumn_chart_poor ?>]
        ]);

        var autumn_pie_options = {
            title: 'Quality of air in Autumn',
            legend: {position: 'bottom'},
                pieSliceText: 'percentage',
                colors: ['#009955', '#559900', '#e6b800', '#ff8000', '#cc0000'],
        };

        var autumn_pie_chart = new google.visualization.PieChart(document.getElementById('AutumnPieChart'));

        autumn_pie_chart.draw(autumn_pie_data, autumn_pie_options);
    }

</script>


