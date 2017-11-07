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
            var ss = GET['ss'];

            // draw the chart
            function drawChart() {
                //get data as json
                var jsonData = $.ajax({
                    url: "getCount.php?id=" + id + "&ss=" + ss,
                    dataType: "json",
                    async: false
                }).responseText;
                var data = new google.visualization.DataTable(jsonData);
                
                //modify some options
                var options = {
                    title: 'Air Quality Percentage',
                    legend: {position: 'bottom'},
                    pieSliceText: 'percentage',
                    colors: ['#009955', '#559900', '#e6b800', '#ff8000', '#cc0000'],
                    tooltip: {
                        trigger: 'focus'
                    },
                    sliceVisibilityThreshold: 0
                };

                var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
                chart.draw(data, options);
            }
        </script>  
    </head>
    <body>
        <div id="chart_div" style="width: 100%; height: 80%; "><h3>Fetching data and rendering, Please wait.</h3></div>
    </body>
</html>