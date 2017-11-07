<?php
//get the paramater of this script
if ($_GET) {
    $airStationId = $_GET['id'];
    $season = $_GET['ss'];
} else {
    $airStationId = $argv[1];
    $season = $argv[2];
}

// buit the json array, pre-declear the colums 
$table = array();
$table['cols'] = array(
    array('id' => 'summary', 'label' => 'Air Quality', 'type' => 'string'),
    array('id' => 'count', 'label' => 'Count', 'type' => 'number'),   
);
$rows = array();

//connect to the database and get data
// put data into the array built before
$aq_sum = array('Very Good', 'Good', 'Fair', 'Poor', 'Very Poor');
$date = "";

switch ($season) {
    case "sp":
        $date = "BETWEEN '09-01' AND '11-30'";
        break;
    case "sm":
        $date = "NOT BETWEEN '03-01' AND '11-30'";
        break;
    case "at":
        $date = "BETWEEN '03-01' AND '05-31'";
        break;
    case "wt":
        $date = "BETWEEN '06-01' AND '08-31'";
        break;
    case "yr":
        $date = "BETWEEN '01-01' AND '12-31'";
        break;
}

foreach ($aq_sum as $value) {
    $temp = array();
    $temp[] = array('v' => $value);
    $number = 0;
    
    $link = mysql_connect('localhost', 'root', '');
    mysql_select_db("dbcleanmelbourne");
    $query = mysql_query("SELECT aqy_summary AS aq, COUNT(aqy_summary) AS c "
            . "FROM airquality_yearly where st_id = " . $airStationId . " "
            . "AND (aqy_date >= DATE_SUB(NOW(),INTERVAL 1 YEAR) "
            . "AND DATE_FORMAT(aqy_date, '%m-%d' ) " . $date . ") "
            . "GROUP BY aqy_summary "
            . "ORDER BY FIELD(aqy_summary,'Very Good','Good','Fair','Poor','Very Poor')");
   
    while ($data = mysql_fetch_array($query)):
        if ($value == (string) $data['aq']) {
            $number = (int) $data['c'];
            break;
        }
    endwhile;
    mysql_close($link);
    
    $temp[] = array('v' => $number);
    $rows[] = array('c' => $temp);
}

//close the link and return thr json as a table
$table['rows'] = $rows;
$jsonTable = json_encode($table, true);
echo $jsonTable;
?>
