<?php
    echo "<br>","The chart below displays an analysis of your symptoms in ", $graph_year, "<br>";
//echo "Welcome: ", $id;

//****************** variables************************
//Spring
$sp_cough = "0";
$sp_chest_tight = "0";
$sp_wheez = "0";
$sp_short_brea = "0";
//Summer
$sum_cough = "0";
$sum_chest_tight = "0";
$sum_wheez = "0";
$sum_short_brea = "0";
//Autumn
$aut_cough = "0";
$aut_chest_tight = "0";
$aut_wheez = "0";
$aut_short_brea = "0";
//winter
$win_cough = "0";
$win_chest_tight = "0";
$win_wheez = "0";
$win_short_brea = "0";

$query = "select '1' as stat,'1' as tt, dd.di_feeling_status, count(*) as cnt from diary dd
            where (dd.di_user_id = '$id') and (YEAR(dd.di_date) = '$graph_year') and (MONTH(dd.di_date) BETWEEN '9'and '11') and (dd.di_coughing = 1)
            UNION
            select '1' as stat,'2' as tt, dd.di_feeling_status, count(*) as cnt from diary dd
            where (dd.di_user_id = '$id') and (YEAR(dd.di_date) = '$graph_year') and (MONTH(dd.di_date) BETWEEN '9'and '11') and (dd.di_chect_tightness = 1)
            UNION
            select '1' as stat,'3' as tt, dd.di_feeling_status,count(*) as cnt from diary dd
            where (dd.di_user_id = '$id') and (YEAR(dd.di_date) = '$graph_year') and (MONTH(dd.di_date) BETWEEN '9'and '11') and (dd.di_wheezing = 1)
            UNION
            select '1' as stat,'4' as tt, dd.di_feeling_status, count(*) as cnt from diary dd
            where (dd.di_user_id = '$id') and (YEAR(dd.di_date) = '$graph_year') and (MONTH(dd.di_date) BETWEEN '9'and '11') and (dd.di_short_breath = 1)
            union
            select '2' as stat,'1' as tt, dd.di_feeling_status, count(*) as cnt from diary dd
            where (dd.di_user_id = '$id') and (YEAR(dd.di_date) = '$graph_year') and (MONTH(dd.di_date) in ('1','2','12')) and (dd.di_coughing = 1)
            UNION
            select '2' as stat,'2' as tt, dd.di_feeling_status, count(*) as cnt from diary dd
            where (dd.di_user_id = '$id') and (YEAR(dd.di_date) = '$graph_year') and (MONTH(dd.di_date) in ('1','2','12')) and (dd.di_chect_tightness = 1)
            UNION
            select '2' as stat,'3' as tt, dd.di_feeling_status,count(*) as cnt from diary dd
            where (dd.di_user_id = '$id') and (YEAR(dd.di_date) = '$graph_year') and (MONTH(dd.di_date) in ('1','2','12')) and (dd.di_wheezing = 1)
            UNION
            select '2' as stat,'4' as tt, dd.di_feeling_status, count(*) as cnt from diary dd
            where (dd.di_user_id = '$id') and (YEAR(dd.di_date) = '$graph_year') and (MONTH(dd.di_date) in ('1','2','12')) and (dd.di_short_breath = 1)
            union
            select '3' as stat,'1' as tt, dd.di_feeling_status, count(*) as cnt from diary dd
            where (dd.di_user_id = '$id') and (YEAR(dd.di_date) = '$graph_year') and (MONTH(dd.di_date) BETWEEN '3'and '5') and (dd.di_coughing = 1)
            UNION
            select '3' as stat,'2' as tt, dd.di_feeling_status, count(*) as cnt from diary dd
            where (dd.di_user_id = '$id') and (YEAR(dd.di_date) = '$graph_year') and (MONTH(dd.di_date) BETWEEN '3'and '5') and (dd.di_chect_tightness = 1)
            UNION
            select '3' as stat,'3' as tt, dd.di_feeling_status,count(*) as cnt from diary dd
            where (dd.di_user_id = '$id') and (YEAR(dd.di_date) = '$graph_year') and (MONTH(dd.di_date) BETWEEN '3'and '5') and (dd.di_wheezing = 1)
            UNION
            select '3' as stat,'4' as tt, dd.di_feeling_status, count(*) as cnt from diary dd
            where (dd.di_user_id = '$id') and (YEAR(dd.di_date) = '$graph_year') and (MONTH(dd.di_date) BETWEEN '3'and '5') and (dd.di_short_breath = 1)
            union
            select '4' as stat,'1' as tt, dd.di_feeling_status, count(*) as cnt from diary dd
            where (dd.di_user_id = '$id') and (YEAR(dd.di_date) = '$graph_year') and (MONTH(dd.di_date) BETWEEN '6'and '8') and (dd.di_coughing = 1)
            UNION
            select '4' as stat,'2' as tt, dd.di_feeling_status, count(*) as cnt from diary dd
            where (dd.di_user_id = '$id') and (YEAR(dd.di_date) = '$graph_year') and (MONTH(dd.di_date) BETWEEN '6'and '8') and (dd.di_chect_tightness = 1)
            UNION
            select '4' as stat,'3' as tt, dd.di_feeling_status,count(*) as cnt from diary dd
            where (dd.di_user_id = '$id') and (YEAR(dd.di_date) = '$graph_year') and (MONTH(dd.di_date) BETWEEN '6'and '8') and (dd.di_wheezing = 1)
            UNION
            select '4' as stat,'4' as tt, dd.di_feeling_status, count(*) as cnt from diary dd
            where (dd.di_user_id = '$id') and (YEAR(dd.di_date) = '$graph_year') and (MONTH(dd.di_date) BETWEEN '6'and '8') and (dd.di_short_breath = 1)";

$result = mysqli_query($connectionString,$query);
if(! $result)
{
    echo mysqli_error($connectionString), "<br>";
    echo mysqli_errno($connectionString);
    //mysqli_close($connectionString);
}
else
{
    while($row = mysqli_fetch_array($result))
    {
        switch ($row['stat'])
        {
            case 1: //Spring
            {
                if($row['tt'] == '1')
                {
                    $sp_cough = $row['cnt'];
                }
                elseif ($row['tt'] == '2')
                {
                    $sp_chest_tight = $row['cnt'];
                }
                elseif ($row['tt'] == '3')
                {
                    $sp_wheez = $row['cnt'];
                }
                elseif ($row['tt'] == '4')
                {
                    $sp_short_brea = $row['cnt'];
                }
                break;
            } //end of Spring
            case 2: //summer
            {
                if($row['tt'] == '1')
                {
                    $sum_cough = $row['cnt'];
                }
                elseif ($row['tt'] == '2')
                {
                    $sum_chest_tight = $row['cnt'];
                }
                elseif ($row['tt'] == '3')
                {
                    $sum_wheez = $row['cnt'];
                }
                elseif ($row['tt'] == '4')
                {
                    $sum_short_brea = $row['cnt'];
                }
                break;
            } //end of summer
            case 3: //Autumn
            {
                if($row['tt'] == '1')
                {
                    $aut_cough = $row['cnt'];
                }
                elseif ($row['tt'] == '2')
                {
                    $aut_chest_tight = $row['cnt'];
                }
                elseif ($row['tt'] == '3')
                {
                    $aut_wheez = $row['cnt'];
                }
                elseif ($row['tt'] == '4')
                {
                    $aut_short_brea = $row['cnt'];
                }
                break;
            } //end of Autumn
            case 4: //winter
            {
                if($row['tt'] == '1')
                {
                    $win_cough = $row['cnt'];
                }
                elseif ($row['tt'] == '2')
                {
                    $win_chest_tight = $row['cnt'];
                }
                elseif ($row['tt'] == '3')
                {
                    $win_wheez = $row['cnt'];
                }
                elseif ($row['tt'] == '4')
                {
                    $win_short_brea = $row['cnt'];
                }
                break;
            }
        }
    }
}

?>
<div id="analysis_chart_div" style="width: 100%; height: fit-content"></div>

<script type="text/javascript">

    google.charts.setOnLoadCallback(drawStacked);

    function drawStacked() {

        var analysis_data = google.visualization.arrayToDataTable([
            ['Season', 'Coughing', 'Chest Tightness', 'Wheezing', 'Short Breath'],
            ['Spring', <?php echo $sp_cough ?>, <?php echo $sp_chest_tight ?>, <?php echo $sp_wheez ?>, <?php echo $sp_short_brea ?>],
            ['Summer', <?php echo $sum_cough ?>, <?php echo $sum_chest_tight ?>, <?php echo $sum_wheez ?>, <?php echo $sum_short_brea ?>],
            ['Autumn', <?php echo $aut_cough ?>, <?php echo $aut_chest_tight ?>, <?php echo $aut_wheez ?>, <?php echo $aut_short_brea ?>],
            ['Winter',<?php echo $win_cough ?>, <?php echo $win_chest_tight ?>, <?php echo $win_wheez ?>, <?php echo $win_short_brea ?>]
        ]);

        var analysis_options = {

            legend: { position: 'bottom vertical' },
            bar: { groupWidth: '45%' },
            isStacked: true
        };
        var analysis_chart = new google.visualization.ColumnChart(document.getElementById('analysis_chart_div'));
        analysis_chart.draw(analysis_data, analysis_options);
    }

</script>



