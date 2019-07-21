<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card text-center text-white bg-dark" style="width:100%;">
                <div class="card-header">

                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="col-md-12">
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
                <div class="card-subtitle ">
                    <div class="row">
                        <div class="input-group col-md-8 mx-auto">
                            <input type="text" class="form-control" id="beDate" placeholder="Start Date" aria-label="date" aria-describedby="basic-addon2">

                            <div class="input-group-append">
                                <button id="getformdate" class="btn  btn-success" type="button">ดูข้อมูล</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="col-md-12">

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
    $('#beDate').daterangepicker({
        timePicker: true,
        startDate: moment().startOf('hour'),
        endDate: moment().startOf('hour').add(1, 'hour'),
        locale: {
            format: 'YYYY/MM/DD HH:mm:ss'
        }
    });
    $("#datepicker").datepicker().datepicker("setDate", new Date());
    $('#tData').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'print'
        ]
    });
    $('.dataTables_length').addClass('bs-select');
    var date = $('#beDate').val();

    var seriesOptions = [];
    var label = [];
    var data1 = [];
    var data2 = [];
    var data3 = [];
    var DataTable = [];

    callData(date);

    function createChart() {

        Highcharts.stockChart('highchart', {

            chart: {
                zoomType: 'x'
            },

            rangeSelector: {

                buttons: [{
                    type: 'second',
                    count: 30,
                    text: '30s'
                }, {
                    type: 'second',
                    count: 60,
                    text: '1m'
                }, {
                    type: 'minute',
                    count: 3,
                    text: '3m'
                }, {
                    type: 'minute',
                    count: 5,
                    text: '5m'
                }, {
                    type: 'minute',
                    count: 15,
                    text: '15m'
                }, {
                    type: 'all',
                    text: 'All'
                }],
                selected: 1
            },

            yAxis: {
                title: {
                    text: 'Current (Amp)'
                }
            },

            title: {
                text: 'เครื่องวัดกระแสไฟฟ้า 3 เฟส ระบบเครื่อข่าย'
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> A<br/>',
                valueDecimals: 2,
                split: true
            },

            series: seriesOptions
        });
    }







    $('#getformdate').on('click', function() {

        var date1 = $('#beDate').val();
        callData(date1);
    });

    function callData(val) {
        var resultNum = 1;
        $.getJSON('./api.php?p=getbetwin&date=' + val, function(result) {
            label.length = 0;
            data1.length = 0;
            data2.length = 0;
            data3.length = 0;
            DataTable.length = 0;
            for (var i in result) {
                var t = moment(result[i].time).valueOf();
                var v1 = new Array();
                var v2 = new Array();
                var v3 = new Array();
                var tb = new Array();
                v1[0] = t;
                v1[1] = result[i].i1;
                data1.push(v1);
                v2[0] = t;
                v2[1] = result[i].i2;
                data2.push(v2);
                v3[0] = t;
                v3[1] = result[i].i3;
                data3.push(v3);
                tb[0] = resultNum;
                tb[1] = result[i].time;
                tb[2] = result[i].i1;
                tb[3] = result[i].i2;
                tb[4] = result[i].i3;
                DataTable.push(tb);
                resultNum++;
            }

            seriesOptions[0] = {
                name: 'I1',
                data: data1
            };
            seriesOptions[1] = {
                name: 'I2',
                data: data2
            };
            seriesOptions[2] = {
                name: 'I3',
                data: data3
            };
            createChart();
            $('#tData').DataTable().clear();
            $('#tData').DataTable().rows.add(DataTable).draw();

        });
    }
</script>
</body>

</html>