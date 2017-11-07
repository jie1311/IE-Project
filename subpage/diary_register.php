<html>
    <head>
        <title>New Breath</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    </head>
    <body>
        <?php
        session_start();
        $id = $_SESSION['id'];


//input validation for diary table elements
//variables to keep the error message to each information inserted
        $Month = "";
        $Day = "";
        $yyear = "";
        $txtFeelingDesc = "";
        $cough = "0";
        $ChectTight = "0";
        $Wheezing = "0";
        $BreathShortness = "0";
        $feeling = "";
        $YEAR = "";

        $CO = "0";
        $CT = "0";
        $WH = "0";
        $SB = "0";

//To keep the error message of each form element
        $MonthErr = "";
        $DayErr = "";
        $yyearErr = "";
        $txtFeelingDescErr = "";
        $coughErr = "";
        $ChectTightErr = "";
        $WheezingErr = "";
        $BreathShortnessErr = "";
        $feelingErr = "";
        $YEARErr = "";
        $Error = "";
        $flag = "0";

        if ($_SERVER["REQUEST_METHOD"] == "POST") { //if the Register button has been clicked
            $year = date("Y");
            $current_month = date("m");
            $current_day = date("d");

            if ((empty($_POST['year'])) || ($_POST['year']) == 0) {
                $yyearErr = "*";
            } else {
                $yyearErr = "";
                $yyear = test_input($_POST['year']);
                if ($yyear > $year) {
                    $yyearErr = "  You can not select any year from future";
                }
            }
            if ((empty($_POST['Month'])) || ($_POST['Month']) == 0) {
                $MonthErr = "*";
            } else {
                $MonthErr = "";
                $Month = test_input($_POST['Month']);
                if (($year == $yyear) && ($Month > $current_month)) {
                    $MonthErr = "You can not select any month from future";
                }
            }
            if ((empty($_POST['Day'])) || ($_POST['Day']) == 0) {
                $DayErr = "*";
            } else {
                $DayErr = "";
                $Day = test_input($_POST['Day']);
                if (($year == $yyear) && ($Month == $current_month) && ($Day > $current_day)) {
                    $DayErr = "  You can not select any day from future";
                } elseif (($yyear <= $year) && ($Month == "02") && ($Day > 29)) { //February checking
                    $DayErr = " February is not more than 29 days";
                } elseif (($yyear <= $year) && ($Month == "04") && ($Day > 30)) { //April checking
                    $DayErr = " April is not more than 30 days";
                } elseif (($yyear <= $year) && ($Month == "06") && ($Day > 30)) { //June checking
                    $DayErr = " June is not more than 30 days";
                } elseif (($yyear <= $year) && ($Month == "09") && ($Day > 30)) { //September checking
                    $DayErr = " September is not more than 30 days";
                } elseif (($yyear <= $year) && ($Month == "11") && ($Day > 30)) { //November checking
                    $DayErr = " November is not more than 30 days";
                }
            }
            if (empty($_POST['txtFeelingDesc'])) {
                $txtFeelingDesc = "";
            } else {
                $txtFeelingDesc = test_input($_POST['txtFeelingDesc']);
            }
            if ((empty($_POST['feeling'])) || ($_POST['feeling']) == 0) {
                $feelingErr = "*";
            } else {
                $feelingErr = "";
                $feeling = test_input($_POST['feeling']);
            }
            if (isSet($_POST['cough']) && ($_POST['cough'] == 1)) {//checkbox
                $cough = "1";
                $coughErr = "";
            } else {
                $cough = "0";
                $coughErr = "*";
            }
            if (isSet($_POST['ChestTight']) && ($_POST['ChestTight'] == 1)) {
                $ChectTightErr = "";
                $ChectTight = "1";
            } else {
                $ChectTight = "0";
                $ChectTightErr = "*";
            }
            if (isSet($_POST['Wheezing']) && ($_POST['Wheezing'] == 1)) {
                $Wheezing = "1";
                $WheezingErr = "";
            } else {
                $Wheezing = "0";
                $WheezingErr = "*";
            }
            if (isSet($_POST['BreathShortness']) && ($_POST['BreathShortness'] == 1)) {
                $BreathShortness = "1";
                $BreathShortnessErr = "";
            } else {
                $BreathShortness = "0";
                $BreathShortnessErr = "*";
            }
            if (($feeling == 4) && ($cough == 0) && ($Wheezing == 0) && ($BreathShortness == 0) && ($ChectTight == 0)) {
                $Error = "Please select atleast one of the following options";
                $flag = "1";
            } else {
                $Error = "";
                $flag = "0";
            }
            if (($MonthErr == "") && ($DayErr == "") && ($feelingErr == "") && ($Error == "")) { //If all the required fields are filled, we can insert the record into the database.
                $connectionString = mysqli_connect('localhost', 'root', '');
                if (!$connectionString) {
                    die('Failed to connect to database....');
                } else { //Inserting into database
                    date_default_timezone_set("Australia/Melbourne");

                    $month = $_POST['Month'];
                    $day = $_POST['Day'];
                    $aa = $yyear . "-" . $month . "-" . $day;

                    $bb = strtotime($aa);
                    $cc = date('Y-m-d', $bb);
                    if ($cough == 1) {
                        $CO = true;
                    }
                    if ($ChectTight == 1) {
                        $CT = true;
                    }
                    if ($Wheezing == 1) {
                        $WH = true;
                    }
                    if ($BreathShortness == 1) {
                        $SB = true;
                    }

                    mysqli_select_db($connectionString, 'dbcleanmelbourne');
                    $query = "INSERT INTO diary(di_user_id, di_message, di_feeling_status, di_coughing, di_chect_tightness, di_wheezing, di_short_breath, di_date) VALUES ('$id','$txtFeelingDesc','$feeling','$CO','$CT','$WH','$SB','$cc')";
                    $result = mysqli_query($connectionString, $query);

                    if (!$result) {
                        echo mysqli_error($connectionString), "<br>";
                        echo mysqli_errno($connectionString);
                        mysqli_close($connectionString);
                    } else {
                        echo "<script> alert ('New Record has been inserted successfully....'); </script>";
                        $Month = "";
                        $Day = "";
                        $txtFeelingDesc = "";
                        $cough = "0";
                        $ChectTight = "0";
                        $Wheezing = "0";
                        $BreathShortness = "0";
                        $feeling = "";
                        $CO = false;
                        $CT = false;
                        $WH = false;
                        $SB = false;
                    }
                }
            }
        }

//this function eliminates the extra space and new line and backslasesh from input.
        function test_input($data) {
            $data = trim($data);
            $data = stripcslashes($data);
            $data = htmlspecialchars($data);

            return $data;
        }
        ?>
        <!-- First div -->
        <div class="col-sm-12" style="padding-left: 25px">

            <!-- Date and Time div -->
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">

                <div style="padding: 0">
                    <h3><?php echo date("l"), "      ", date("d/m/y") . "<br>"; ?></h3>
                    <p>Here, you can have an online diary where following your health condition would be easier.<br>
                        Please fill out the following form and you have submitted your diary of the day...</p>
                </div> <!-- End of date and time -->


                    <div class="user_diary_table"> <!-- For the diary details to be put here -->
                        <p>Select your desired date to make a diary... </p>
                        <p>Year: <select class="btn btn-default" name="year" id="year">
                                <option value="0">Select Year</option>
                                <option value="2014">2014</option>
                                <option value="2015">2015</option>
                                <option value="2016">2016</option>
                                <option value="2017">2017</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                            </select><span style="color: red"><?php echo $yyearErr; ?></span>
                        </p>

                        <p>Month: <select class="btn btn-default" name="Month" id="Month">
                                <option value="0">Select Month</option>
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select><span style="color: red"><?php echo $MonthErr; ?></span><p>

                        <p> Day: <select class="btn btn-default" name="Day" id="Day">
                                <option value="0">Select Day</option>
<?php
for ($aa = 1; $aa <= 31; $aa ++) {
    ?>
                                    <option value=<?php echo $aa ?>><?php echo $aa; ?></option>
<?php } ?>
                                ?>
                            </select><span style="color: red"><?php echo $DayErr; ?></span></p>

                <!-- <p>What do you feel like to write?
                    <textarea name="txtFeelingDesc" id="txtFeelingDesc" rows="8" cols="80" style="overflow-y: scroll"></textarea></p> -->
                        <p>I am feeling: <select class="btn btn-default" name="feeling" id="feeling" onchange="ChecngeEnable()">
                                <option value="0">Select One</option>
                                <option value="1">Very Good</option>
                                <option value="2">Good</option>
                                <option value="3">Ok</option>
                                <option value="4">Not Good</option>
                            </select><span style="color: red"><?php echo $feelingErr; ?></span>
                        </p>
                        <div class="user_diary_symptom" id="symptom"> <!-- To add the check boxes of Asthma general symptoms -->
                            <p>Symptoms: <span style="color: red"><?php echo $Error; ?></span></p>

                            <p><input type="checkbox" name="cough" id="cough" value="1" <?php if ($cough == 1) { ?> checked <?php } ?>> Coughing<br>

                                <input  type="checkbox" name="ChestTight" id="ChestTight" value="1" <?php if ($ChectTight == 1) { ?> checked <?php } ?>> Chect Tightness<br>

                                <input type="checkbox" name="Wheezing" id="Wheezing" value="1" <?php if ($Wheezing == 1) { ?> checked <?php } ?>> Wheezing<br>

                                <input type="checkbox" name="BreathShortness" id="BreathShortness" value="1" <?php if ($BreathShortness == 1) { ?> checked <?php } ?>> Shortness of Breath<br></p>
                        </div>
                        <p><br><input type="submit" class="btn btn-lg btn-primary" name="submit" value="Register"></p>

                        </form>
                    </div> <!-- End of user diary table div -->

                    <script> //To enable or disable checkboxes by selecting different values from Feeling dropdown list.

                        function ChecngeEnable() {
                            var aa = document.getElementById("feeling");
                            //window.alert(aa.value);
                            if (aa.value > 1)
                            {
                                document.getElementById("cough").disabled = false;
                                document.getElementById("ChestTight").disabled = false;
                                document.getElementById("Wheezing").disabled = false;
                                document.getElementById("BreathShortness").disabled = false;
                            } else
                            {
                                document.getElementById("cough").disabled = true;
                                document.getElementById("ChestTight").disabled = true;
                                document.getElementById("Wheezing").disabled = true;
                                document.getElementById("BreathShortness").disabled = true;

                                document.getElementById("cough").checked = false;
                                document.getElementById("ChestTight").checked = false;
                                document.getElementById("Wheezing").checked = false;
                                document.getElementById("BreathShortness").checked = false;
                            }
                        }

                    </script>

                    </body>
                    </html>