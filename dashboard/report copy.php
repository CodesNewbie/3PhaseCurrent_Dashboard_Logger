<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card text-center text-white bg-dark" style="width:100%;">
                <div class="card-header">
                    กระแส
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="col-md-12">
                                <canvas id="mainChart"></canvas>
                                <div id="highchart" style="height: 400px; min-width: 310px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card text-center text-white bg-dark  card-block justify-content-center" style="width:100%;">
                <div class="card-header">
                    ตารางข้อมูล
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="col-md-12">
                                <div class="input-group col-md-8 mx-auto">
                                    <input type="text" class="form-control" id="beDate" placeholder="Start Date" aria-label="date" aria-describedby="basic-addon2">

                                    <div class="input-group-append">
                                        <button id="getformdate" class="btn  btn-success" type="button">ดูข้อมูล</button>
                                    </div>
                                </div>
                                <table id="tData" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="th-sm">ลำดับที่
                                            </th>
                                            <th class="th-sm">วันที่ เวลา
                                            </th>
                                            <th class="th-sm">กระแส I1
                                            </th>
                                            <th class="th-sm">กระแส I2
                                            </th>
                                            <th class="th-sm">กระแส I3
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="th-sm">ลำดับที่
                                            </th>
                                            <th class="th-sm">วันที่ เวลา
                                            </th>
                                            <th class="th-sm">กระแส I1
                                            </th>
                                            <th class="th-sm">กระแส I2
                                            </th>
                                            <th class="th-sm">กระแส I3
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
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
<script src="assets/js/highstock.js"></script>
<script src="assets/js/exporting.js"></script>
<script src="assets/js/export-data.js"></script>
<script>
    /*
    src="assets/js/Chart.min.js"
src="assets/js/utils.js"
*/
var seriesOptions = [],


/**
 * Create the chart when all data is loaded
 * @returns {undefined}
 */
function createChart() {

    Highcharts.stockChart('highchart', {

        rangeSelector: {
            selected: 4
        },

        yAxis: {
            labels: {
                formatter: function () {
                    return (this.value > 0 ? ' + ' : '') + this.value + '%';
                }
            },
            plotLines: [{
                value: 0,
                width: 2,
                color: 'silver'
            }]
        },

        plotOptions: {
            series: {
                compare: 'percent',
                showInNavigator: true
            }
        },

        tooltip: {
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.change}%)<br/>',
            valueDecimals: 2,
            split: true
        },

        series: seriesOptions
    });
}

/*

    $.getJSON('https://www.highcharts.com/samples/data/' + name.toLowerCase() + '-c.json',    function (data) {

        seriesOptions[0] = {
            name: name,
            data: data
        };
        seriesOptions[1] = {
            name: name,
            data: data
        };
        seriesOptions[2] = {
            name: name,
            data: data
        };

        // As we're loading the data asynchronously, we don't know what order it will arrive. So
        // we keep a counter and create the chart when all the data is loaded.
        seriesCounter += 1;

        if (seriesCounter === names.length) {
            createChart();
        }
    });
*/
    var label = [];
    var data1 = [];
    var data2 = [];
    var data3 = [];
    var DataTable = [];
    $('#beDate').daterangepicker({
        timePicker: true,
        startDate: moment().startOf('hour'),
        endDate: moment().startOf('hour').add(1, 'hour'),
        locale: {
            format: 'YYYY/MM/DD HH:mm:ss'
        }
    });
    $("#datepicker").datepicker().datepicker("setDate", new Date());
    $('#tData').DataTable();
    $('.dataTables_length').addClass('bs-select');
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
                    type: 'linear',
                    display: true,
                    ticks: {
                        beginAtZero: true,
                        steps: 10,
                        stepValue: 5,
                        max: 100
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
            hover: {
                mode: 'nearest',
                intersect: false
            },
            pan: {
                enabled: true,
                mode: 'x',
                rangeMax: {
                    x: 4000
                },
                rangeMin: {
                    x: 0
                }
            },
            zoom: {
                enabled: true,
                mode: 'x',
                rangeMax: {
                    x: 20000
                },
                rangeMin: {
                    x: 1000
                }
            }
        },
        data: {
            labels: label,
            datasets: [{
                label: "Source 1",
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
                label: "Source 2",
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
                label: "Source 3",
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
    var resultNum = 1;
    $('#getformdate').on('click', function() {
        var date = $('#beDate').val();
        callData(date);
    });

    function callData(val) {
        $.getJSON('./api.php?p=getbetwin&date=' + val, function(result) {
            label.length = 0;
            data1.length = 0;
            data2.length = 0;
            data3.length = 0;
            DataTable.length = 0;
            for (var i in result) {
                label.push(moment(result[i].time).format("HH:mm:ss"));
                data1.push(result[i].i1);
                data2.push(result[i].i2);
                data3.push(result[i].i3);
                var valueToPush = new Array();
                valueToPush[0] = resultNum;
                valueToPush[1] = result[i].time;
                valueToPush[2] = result[i].i1;
                valueToPush[3] = result[i].i2;
                valueToPush[4] = result[i].i3;
                DataTable.push(valueToPush);
                resultNum++;
            }
            mainChart.update();
            $('#tData').DataTable().clear();
            $('#tData').DataTable().rows.add(DataTable).draw();

        });
    }
</script>
</body>

</html>