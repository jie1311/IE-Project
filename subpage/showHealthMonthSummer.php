<?php
         echo "<br>","The chart below displays the air quality in Summer in your suburb in ", $graph_year, "<br>";
         echo "In Australia, Summer starts from December to February.", "<br>";

//*****************Summer Pie Chart********************
$summer_chart_veryGood = "0";
$summer_chart_Good = "0";
$summer_chart_fair = "0";
$summer_chart_poor = "0";
$summer_chart_verypoor = "0";
//Get the query for summer pie chart
$summer_chart_query = "select '1' as stat, count(*) as cnt from airquality_yearly aqiy
                            where (aqiy.st_id = '$air_station_id') and (YEAR(aqiy.aqy_date) = '$graph_year') and (MONTH(aqiy.aqy_date) in ('02', '12'))
                            and (aqiy.aqy_aqi BETWEEN '0' and '33')
                            UNION
                            select '2' as stat, count(*) as cnt from airquality_yearly aqiy
                            where (aqiy.st_id = '$air_station_id') and (YEAR(aqiy.aqy_date) = '$graph_year') and (MONTH(aqiy.aqy_date) in ('02', '12'))
                            and (aqiy.aqy_aqi BETWEEN '34' and '66')
                            UNION
                            select '3' as stat, count(*) as cnt from airquality_yearly aqiy
                            where (aqiy.st_id = '$air_station_id') and (YEAR(aqiy.aqy_date) = '$graph_year') and (MONTH(aqiy.aqy_date) in ('02', '12'))
                            and (aqiy.aqy_aqi BETWEEN '67' and '99')
                            UNION
                            select '4' as stat, count(*) as cnt from airquality_yearly aqiy
                            where (aqiy.st_id = '$air_station_id') and (YEAR(aqiy.aqy_date) = '$graph_year') and (MONTH(aqiy.aqy_date) in ('02', '12'))
                            and (aqiy.aqy_aqi BETWEEN '100' and '149')
                            UNION
                            select '5' as stat, count(*) as cnt from airquality_yearly aqiy
                            where (aqiy.st_id = '$air_station_id') and (YEAR(aqiy.aqy_date) = '$graph_year') and (MONTH(aqiy.aqy_date) in ('02', '12'))
                            and (cast(aqiy.aqy_aqi as UNSIGNED) BETWEEN '150' and '250')";

$summer_chart_result = mysqli_query($connectionString,$summer_chart_query);
if(!$summer_chart_result)
{
    echo mysqli_error($connectionString), "<br>";
    echo mysqli_errno($connectionString);
    mysqli_close($connectionString);
}
else
{
    while ($summer_chart_row = mysqli_fetch_array($summer_chart_result)) {
        switch ($summer_chart_row['stat']) {
            case 1: {
                $summer_chart_veryGood = $summer_chart_row['cnt'];
                break;
            }
            case 2: {
                $summer_chart_Good = $summer_chart_row['cnt'];
                break;
            }
            case 3: {
                $summer_chart_fair = $summer_chart_row['cnt'];
                break;
            }
            case 4: {
                $summer_chart_poor = $summer_chart_row['cnt'];
                break;
            }
            case 5:
            {
                $summer_chart_verypoor = $summer_chart_row['cnt'];
                break;
            }
        }
    }
}

?>

<div id="SummerPieChart" style="width: 100%; height: 300px"></div>
<script>

    google.charts.setOnLoadCallback(drawSummerPieChart);
    function drawSummerPieChart() {

        var summer_pie_data = google.visualization.arrayToDataTable([
            ['Quality', 'Number of Days'],
            ['Very Good', <?php echo $summer_chart_veryGood ?>],
            ['Good', <?php echo $summer_chart_Good ?>],
            ['Fair', <?php echo $summer_chart_fair ?>],
            ['Poor', <?php echo $summer_chart_poor ?>]
        ]);

        var summer_pie_options = {
            title: 'Quality of air in Summer',
            legend: {position: 'bottom'},
                pieSliceText: 'percentage',
                colors: ['#009955', '#559900', '#e6b800', '#ff8000', '#cc0000'],
        };

        var summer_pie_chart = new google.visualization.PieChart(document.getElementById('SummerPieChart'));

        summer_pie_chart.draw(summer_pie_data, summer_pie_options);
    }

</script>
