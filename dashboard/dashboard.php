<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card text-center text-white bg-dark" style="width:100%;">
                <div class="card-header">
                    กระแส Phase A,B,C
                </div>
                <div class="card-body">
                    <div id="canvas-holder1" style="width:100%;">
                        <canvas id="mainChart"></canvas>
                        <div class="chartjs-tooltip" id="tooltip-0"></div>
                        <div class="chartjs-tooltip" id="tooltip-1"></div>
                        <div class="chartjs-tooltip" id="tooltip-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card text-center text-white bg-dark  card-block justify-content-center" style="width:100%;">
                <div class="card-header">
                    กระแส Phase A
                </div>
                <div class="card-body ">
                    <div class="container-fluid">
                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="col-md-8">
                                <canvas id="chart1"></canvas>
                            </div>
                            <div class="col-md-4">
                                <div class="showNum" id="lastI1">--</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card text-center text-white bg-dark" style="width:100%;">
                <div class="card-header">
                    กระแส Phase B
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="col-md-8">
                                <canvas id="chart2"></canvas>
                            </div>
                            <div class="col-md-4">
                                <div class="showNum" id="lastI2">--</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card text-center text-white bg-dark" style="width:100%;">
                <div class="card-header">
                    กระแส Phase C
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="col-md-8">
                                <canvas id="chart3"></canvas>
                            </div>
                            <div class="col-md-4">
                                <div class="showNum" id="lastI3">--</div>
                            </div>
                        </div>
                    </div>
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

<script>
    var label = [];
    var data1 = [];
    var data2 = [];
    var data3 = [];

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
                var content = [dataPoint.xLabel, dataPoint.yLabel].join(': ') + " Amp";
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
    var ctx = document.getElementById("mainChart").getContext("2d");
    var ctx1 = document.getElementById("chart1").getContext("2d");
    var ctx2 = document.getElementById("chart2").getContext("2d");
    var ctx3 = document.getElementById("chart3").getContext("2d");
    var mainctx = document.getElementById("mainChart").getContext("2d");
    var mainChart = new Chart(mainctx, {
        type: 'line',
        options: {
            responsive: true,
            title: {
                display: false,
                text: 'กระแส'
            },
            scales: {
                yAxes: [{
                    display: true,
                    ticks: {
                        beginAtZero: true,
                        steps: 10,
                        stepValue: 5,
                        max: 500
                    }
                }]
            },
            tooltips: {
                //enabled: false,
                mode: 'index',
                intersect: false,
                callbacks: {
                    label: function(t, d) {
                        if (t.datasetIndex === 0) {
                            return t.yLabel.toFixed(2) + ' Amp';
                        } else if (t.datasetIndex === 1) {
                            return t.yLabel.toFixed(2) + ' Amp';
                        } else if (t.datasetIndex === 2) {
                            return t.yLabel.toFixed(2) + ' Amp';
                        }
                    }
                }
                //custom: customTooltips
            },
        },
        data: {
            labels: label,
            datasets: [{
                label: "I1",
                data: data1,
                borderWidth: 2,
                backgroundColor: "rgba(6, 167, 125, 0.1)",
                borderColor: "rgba(6, 167, 125, 1)",
                pointBackgroundColor: "rgba(225, 225, 225, 1)",
                pointBorderColor: "rgba(6, 167, 125, 1)",
                pointHoverBackgroundColor: "rgba(6, 167, 125, 1)",
                pointHoverBorderColor: "#fff",
                fill: false
            }, {
                label: "I2",
                data: data2,
                borderWidth: 2,
                backgroundColor: "rgba(246, 71, 64, 0.1)",
                borderColor: "rgba(246, 71, 64, 1)",
                pointBackgroundColor: "rgba(225, 225, 225, 1)",
                pointBorderColor: "rgba(246, 71, 64, 1)",
                pointHoverBackgroundColor: "rgba(246, 71, 64, 1)",
                pointHoverBorderColor: "#fff",
                fill: false
            }, {
                label: "I3",
                data: data3,
                borderWidth: 2,
                backgroundColor: "rgba(26, 143, 227, 0.1)",
                borderColor: "rgba(26, 143, 227, 1)",
                pointBackgroundColor: "rgba(225, 225, 225, 1)",
                pointBorderColor: "rgba(26, 143, 227, 1)",
                pointHoverBackgroundColor: "rgba(26, 143, 227, 1)",
                pointHoverBorderColor: "#fff",
                fill: false
            }]
        }
    });
    var chart1 = new Chart(ctx1, {
        type: 'line',
        options: {
            responsive: true,
            title: {
                display: false,
                text: 'กระแส'
            },
            scales: {
                yAxes: [{
                    display: true,
                    ticks: {
                        beginAtZero: true,
                        steps: 10,
                        stepValue: 5,
                        max: 500
                    }
                }]
            },
            tooltips: {
                //enabled: false,
                mode: 'index',
                intersect: false,
                callbacks: {
                    label: function(t, d) {
                        if (t.datasetIndex === 0) {
                            return t.yLabel.toFixed(2) + ' Amp';
                        } else if (t.datasetIndex === 1) {
                            return t.yLabel.toFixed(2) + ' Amp';
                        } else if (t.datasetIndex === 2) {
                            return t.yLabel.toFixed(2) + ' Amp';
                        }
                    }
                }
                //custom: customTooltips
            },
        },
        data: {
            labels: label,
            datasets: [{
                label: "I1",
                data: data1,
                borderWidth: 2,
                backgroundColor: "rgba(6, 167, 125, 0.1)",
                borderColor: "rgba(6, 167, 125, 1)",
                pointBackgroundColor: "rgba(225, 225, 225, 1)",
                pointBorderColor: "rgba(6, 167, 125, 1)",
                pointHoverBackgroundColor: "rgba(6, 167, 125, 1)",
                pointHoverBorderColor: "#fff",
                fill: false
            }]
        }
    });
    var chart2 = new Chart(ctx2, {
        type: 'line',
        options: {
            responsive: true,
            title: {
                display: false,
                text: 'กระแส'
            },
            scales: {
                yAxes: [{
                    display: true,
                    ticks: {
                        beginAtZero: true,
                        steps: 10,
                        stepValue: 5,
                        max: 500
                    }
                }]
            },
            tooltips: {
                //enabled: false,
                mode: 'index',
                intersect: false,
                callbacks: {
                    label: function(t, d) {
                        if (t.datasetIndex === 0) {
                            return t.yLabel.toFixed(2) + ' Amp';
                        } else if (t.datasetIndex === 1) {
                            return t.yLabel.toFixed(2) + ' Amp';
                        } else if (t.datasetIndex === 2) {
                            return t.yLabel.toFixed(2) + ' Amp';
                        }
                    }
                }
                //custom: customTooltips
            },
        },
        data: {
            labels: label,
            datasets: [{
                label: "I2",
                data: data2,
                borderWidth: 2,
                backgroundColor: "rgba(246, 71, 64, 0.1)",
                borderColor: "rgba(246, 71, 64, 1)",
                pointBackgroundColor: "rgba(225, 225, 225, 1)",
                pointBorderColor: "rgba(246, 71, 64, 1)",
                pointHoverBackgroundColor: "rgba(246, 71, 64, 1)",
                pointHoverBorderColor: "#fff",
                fill: false
            }]
        }
    });
    var chart3 = new Chart(ctx3, {
        type: 'line',
        options: {
            responsive: true,
            title: {
                display: false,
                text: 'กระแส'
            },
            scales: {
                yAxes: [{
                    display: true,
                    ticks: {
                        beginAtZero: true,
                        steps: 10,
                        stepValue: 5,
                        max: 500
                    }
                }]
            },
            tooltips: {
                //enabled: false,
                mode: 'index',
                intersect: false,
                callbacks: {
                    label: function(t, d) {
                        if (t.datasetIndex === 0) {
                            return t.yLabel.toFixed(2) + ' Amp';
                        } else if (t.datasetIndex === 1) {
                            return t.yLabel.toFixed(2) + ' Amp';
                        } else if (t.datasetIndex === 2) {
                            return t.yLabel.toFixed(2) + ' Amp';
                        }
                    }
                }
                //custom: customTooltips
            },
        },
        data: {
            labels: label,
            datasets: [{
                label: "I3",
                data: data3,
                borderWidth: 2,
                backgroundColor: "rgba(26, 143, 227, 0.1)",
                borderColor: "rgba(26, 143, 227, 1)",
                pointBackgroundColor: "rgba(225, 225, 225, 1)",
                pointBorderColor: "rgba(26, 143, 227, 1)",
                pointHoverBackgroundColor: "rgba(26, 143, 227, 1)",
                pointHoverBorderColor: "#fff",
                fill: false
            }]
        }
    });
    var lasttime;
    $.getJSON('./api.php?p=getdata&limit=20', function(result) {
        for (var i in result) {
            label.push(moment(result[i].time).format("HH:mm:ss"));
            data1.push(result[i].i1);
            data2.push(result[i].i2);
            data3.push(result[i].i3);
            lasttime = moment(result[i].time).format("HH:mm:ss");
        }
        mainChart.update();
        chart1.update();
        chart2.update();
        chart3.update();

    });

    setInterval(updateChart, 1000);

    function updateChart() {



        $.getJSON('./api.php?p=getdata', function(result) {
            if (lasttime != moment(result[0].time).format("HH:mm:ss")) {
                label.push(moment(result[0].time).format("HH:mm:ss"));
                data1.push(result[0].i1);
                data2.push(result[0].i2);
                data3.push(result[0].i3);
                $("#lastI1").html(result[0].i1);
                $("#lastI2").html(result[0].i2);
                $("#lastI3").html(result[0].i3);
                label.shift();
                data1.shift();
                data2.shift();
                data3.shift();
                mainChart.update();
                chart1.update();
                chart2.update();
                chart3.update();
                lasttime = moment(result[0].time).format("HH:mm:ss");
            }
        });
    }

    function addData(chart, labels1, data) {
        chart.data.labels.push(labels1);
        chart.data.datasets.forEach((dataset) => {
            dataset.data.push(data);
        });
        chart.update();
    }
</script>
</body>

</html>