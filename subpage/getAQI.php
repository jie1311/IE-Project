<?php

//get the paramater of this script
if ($_GET) {
    $airStationId = $_GET['id'];
    $time = $_GET['tm'];
} else {
    $airStationId = $argv[1];
    $time = $argv[2];
}

//buit the json array, pre-declear the colums
$table = array();
$role = array();
$role['role'] = 'tooltip';
$table['cols'] = array(
    array('id' => 'date', 'label' => 'Date', 'type' => 'string'),
    array('id' => 'aqi', 'label' => 'Air Quality Index (the lower the better)', 'type' => 'number'),
    array('id' => 'aqi', 'label' => 'Very Good', 'type' => 'number'),
    array('id' => 'aqi', 'label' => 'Good', 'type' => 'number'),
    array('id' => 'aqi', 'label' => 'Fair', 'type' => 'number'),
    array('id' => 'aqi', 'label' => 'Poor', 'type' => 'number'),
    array('id' => 'aqi', 'label' => 'Very Poor', 'type' => 'number'),
    array('id' => 'tooltip', 'label' => 'Summary', 'type' => 'string', 'p' => $role)
);
$rows = array();

switch ($time) {
    case "wk":
        $date = "WEEK";
        break;
    case "mt":
        $date = "MONTH";
        break;
    case "yr":
        $date = "YEAR";
        break;
}

//connect to the database and get data, the query depends on the season
$link = mysql_connect('localhost', 'root', '');
mysql_select_db("dbcleanmelbourne");
$query = mysql_query("SELECT DATE_FORMAT(aqy_date, '%d-%m-%Y') as d, aqy_aqi, aqy_summary "
        . "FROM airquality_yearly "
        . "WHERE st_id =" . $airStationId . " "
        . "AND aqy_date >= DATE_SUB(NOW(),INTERVAL 1 " . $date . ") "
        . "AND aqy_aqi > 0 "
        . "ORDER BY aqy_date");


// put data into the array built before
while ($data = mysql_fetch_array($query)):
    $temp = array();
    $temp[] = array('v' => $data['d']);
    $temp[] = array('v' => $data['aqy_aqi']);
    $temp[] = array('v' => 33);
    $temp[] = array('v' => 33);
    $temp[] = array('v' => 34);
    $temp[] = array('v' => 50);
    $temp[] = array('v' => 50);
    $temp[] = array('v' => (string) $data['aqy_aqi'] . ' ' . $data['aqy_summary']);
    $rows[] = array('c' => $temp);
endwhile;

//close the link and return thr json as a table
mysql_close($link);
$table['rows'] = $rows;
$jsonTable = json_encode($table, true);
echo $jsonTable;
?>