<?php
echo "<br>","The chart below displays the air quality in Winter in your suburb in ", $graph_year, "<br>";
echo "In Australia, Autumn starts from June to August.", "<br>";

//*****************Summer Pie Chart********************
$winter_chart_veryGood = "0";
$winter_chart_Good = "0";
$winter_chart_fair = "0";
$winter_chart_poor = "0";
$winter_chart_verypoor = "0";
//Get the query for summer pie chart
$winter_chart_query = "select '1' as stat, count(*) as cnt from airquality_yearly aqiy
                            where (aqiy.st_id = '$air_station_id') and (YEAR(aqiy.aqy_date) = '$graph_year') and (MONTH(aqiy.aqy_date) between '6' and '8')
                            and (aqiy.aqy_aqi BETWEEN '0' and '33')
                            UNION
                            select '2' as stat, count(*) as cnt from airquality_yearly aqiy
                            where (aqiy.st_id = '$air_station_id') and (YEAR(aqiy.aqy_date) = '$graph_year') and (MONTH(aqiy.aqy_date) between '6' and '8')
                            and (aqiy.aqy_aqi BETWEEN '34' and '66')
                            UNION
                            select '3' as stat, count(*) as cnt from airquality_yearly aqiy
                            where (aqiy.st_id = '$air_station_id') and (YEAR(aqiy.aqy_date) = '$graph_year') and (MONTH(aqiy.aqy_date) between '6' and '8')
                            and (aqiy.aqy_aqi BETWEEN '67' and '99')
                            UNION
                            select '4' as stat, count(*) as cnt from airquality_yearly aqiy
                            where (aqiy.st_id = '$air_station_id') and (YEAR(aqiy.aqy_date) = '$graph_year') and (MONTH(aqiy.aqy_date) between '6' and '8')
                            and (aqiy.aqy_aqi BETWEEN '100' and '149')
                            UNION
                            select '5' as stat, count(*) as cnt from airquality_yearly aqiy
                            where (aqiy.st_id = '$air_station_id') and (YEAR(aqiy.aqy_date) = '$graph_year') and (MONTH(aqiy.aqy_date) between '6' and '8')
                            and (cast(aqiy.aqy_aqi as UNSIGNED) BETWEEN '150' and '250')";

$winter_chart_result = mysqli_query($connectionString,$winter_chart_query);
if(!$winter_chart_result)
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

    while ($winter_chart_row = mysqli_fetch_array($winter_chart_result)) {

        /*echo $winter_chart_row['cnt'], "<br>";
        echo $winter_chart_row['stat'], "<br>";*/

        switch ($winter_chart_row['stat']) {
            case 1: {
                $winter_chart_veryGood = $winter_chart_row['cnt'];
                break;
            }
            case 2: {
                $winter_chart_Good = $winter_chart_row['cnt'];
                break;
            }
            case 3: {
                $winter_chart_fair = $winter_chart_row['cnt'];
                break;
            }
            case 4: {
                $winter_chart_poor = $winter_chart_row['cnt'];
                break;
            }
            case 5:
            {
                $winter_chart_verypoor = $winter_chart_row['cnt'];
                break;
            }
        }
    }
}
?>

<div id="WinterPieChart" style="width: 100%; height: 300px"></div>
<script>

    google.charts.setOnLoadCallback(drawAutumnPieChart);
    function drawAutumnPieChart() {

        var winter_pie_data = google.visualization.arrayToDataTable([
            ['Quality', 'Number of Days'],
            ['Very Good', <?php echo $winter_chart_veryGood ?>],
            ['Good', <?php echo $winter_chart_Good ?>],
            ['Fair', <?php echo $winter_chart_fair ?>],
            ['Poor', <?php echo $winter_chart_poor ?>]
        ]);

        var winter_pie_options = {
            title: 'Quality of air in Winter',
            legend: {position: 'bottom'},
                pieSliceText: 'percentage',
                colors: ['#009955', '#559900', '#e6b800', '#ff8000', '#cc0000'],
        };

        var winter_pie_chart = new google.visualization.PieChart(document.getElementById('WinterPieChart'));

        winter_pie_chart.draw(winter_pie_data, winter_pie_options);
    }

</script>
