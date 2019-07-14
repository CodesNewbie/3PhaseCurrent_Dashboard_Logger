<?php
include "./inc/conn.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $title; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/dist.css">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</head>

<body>

    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <a class="navbar-brand" href="./index.php?page=home">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="./index.php?page=home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./index.php?page=report">Report</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card text-center text-white bg-dark" style="width:100%;">
                    <div class="card-header">
                        กระแส Phase
                    </div>
                    <div class="card-body">
                        <div id="canvas-holder1" style="width:100%;">
                            <canvas id="chart1"></canvas>
                            <div class="chartjs-tooltip" id="tooltip-0"></div>
                            <div class="chartjs-tooltip" id="tooltip-1"></div>
                            <div class="chartjs-tooltip" id="tooltip-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center text-white bg-dark" style="width:100%;">
                    <div class="card-header">
                        กระแส Phase1
                    </div>
                    <div class="card-body">
                        กระแส Phase1
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center text-white bg-dark" style="width:100%;">
                    <div class="card-header">
                        กระแส Phase2
                    </div>
                    <div class="card-body">
                        กระแส Phase1
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center text-white bg-dark" style="width:100%;">
                    <div class="card-header">
                        กระแส Phase3
                    </div>
                    <div class="card-body">
                        กระแส Phase1
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
        </div>
    </div>
    <section class="footer">
        <footer id="sticky-footer" class="py-4 bg-dark text-white-50">
            <div class="container text-center">
                <small>Copyright &copy;test</small>
            </div>
        </footer>
    </section>
    <script src="assets/js/Chart.min.js"></script>
    <script src="assets/js/utils.js"></script>
    <script>
        var customTooltips = function(tooltip) {
            $(this._chart.canvas).css('cursor', 'pointer');

            var positionY = this._chart.canvas.offsetTop;
            var positionX = this._chart.canvas.offsetLeft;

            $('.chartjs-tooltip').css({
                opacity: 0,
            });

            if (!tooltip || !tooltip.opacity) {
                return;
            }

            if (tooltip.dataPoints.length > 0) {
                tooltip.dataPoints.forEach(function(dataPoint) {
                    var content = [dataPoint.xLabel, dataPoint.yLabel].join(': ');
                    var $tooltip = $('#tooltip-' + dataPoint.datasetIndex);

                    $tooltip.html(content);
                    $tooltip.css({
                        opacity: 1,
                        top: positionY + dataPoint.y + 'px',
                        left: positionX + dataPoint.x + 'px',
                    });
                });
            }
        };
        var color = Chart.helpers.color;
        var lineChartData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                label: 'Phase1',
                borderColor: "black",
                pointBackgroundColor: "black",
                fill: false,
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor()
                ]
            }, {
                label: 'Phase2',
                borderColor: "red",
                pointBackgroundColor: "red",
                fill: false,
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor()
                ]
            }, {
                label: 'Phase3',
                borderColor: "blue",
                pointBackgroundColor: "blue",
                fill: false,
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor()
                ]
            }]
        };

        window.onload = function() {
            var chartEl = document.getElementById('chart1');
            new Chart(chartEl, {
                type: 'line',
                data: lineChartData,
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text: 'กระแส'
                    },
                    tooltips: {
                        enabled: false,
                        mode: 'index',
                        intersect: false,
                        custom: customTooltips
                    },

                }
            });
        };
    </script>
</body>

</html>