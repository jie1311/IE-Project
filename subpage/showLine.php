<html>
    <head>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script type="text/javascript">
            //prepare for google chart
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            //get the paramater of this script
            var GET = {};
            var query = window.location.search.substring(1).split("&");
            for (var i = 0, max = query.length; i < max; i++) {
                if (query[i] === "")
                    continue;
                var param = query[i].split("=");
                GET[decodeURIComponent(param[0])] = decodeURIComponent(param[1] || "");
            }
            var id = GET['id'];
            var tm = GET['tm'];

            // drwa the chart
            function drawChart() {
                //get data as json
                var jsonData = $.ajax({
                    url: "getAQI.php?id=" + id + "&tm=" + tm,
                    dataType: "json",
                    async: false
                }).responseText;
                var data = new google.visualization.DataTable(jsonData);

                //modify some options
                var options = {
                    title: 'Air Quality Index Trend',
                    legend: {position: 'bottom'},                   
                    isStacked: true,
                    vAxis: {
                        minValue: 0,
                        maxValue: 200,
                        gridlines: {color: 'transparent'},
                        ticks: [{v: 16, f: 'Very Good'},
                            {v: 49, f: 'Good'},
                            {v: 83, f: 'Fair'},
                            {v: 125, f: 'Poor'},
                            {v: 175, f: 'Very Poor'}
                        ]      
                    },
                    colors: ['#3344ff', '#009955', '#559900', '#e6b800', '#ff8000', '#cc0000'],
                    series: {
                        0: {
                            type: 'line',
                            lineWidth: 3,
                            curveType: 'function',                                                     
                        },
                        1: {
                            lineWidth: 0,
                            type: 'area',
                            visibleInLegend: false,
                            enableInteractivity: false
                        },
                        2: {
                            lineWidth: 0,
                            type: 'area',
                            visibleInLegend: false,
                            enableInteractivity: false
                        },
                        3: {
                            lineWidth: 0,
                            type: 'area',
                            visibleInLegend: false,
                            enableInteractivity: false
                        },
                        4: {
                            lineWidth: 0,
                            type: 'area',
                            visibleInLegend: false,
                            enableInteractivity: false
                        },
                        5: {
                            lineWidth: 0,
                            type: 'area',
                            visibleInLegend: false,
                            enableInteractivity: false
                        },
                        6: {
                            lineWidth: 0,
                            type: 'area',
                            visibleInLegend: false,
                            enableInteractivity: false
                        }
                    }
                };
                var chart = new google.visualization.ComboChart(document.getElementById('curve_chart'));
                chart.draw(data, options);
            }
        </script>
    </head>
    <body>
        <div id="curve_chart" style="width: 90%; height: 90%"><h3>Fetching data and rendering, Please wait.</h3></div>
    </body>
</html>