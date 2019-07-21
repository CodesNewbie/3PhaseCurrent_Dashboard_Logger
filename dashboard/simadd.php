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
    <script src="assets/js/moment.min.js"></script>

</head>

<body>
    <textarea id="data" style="width:100%;"></textarea>
    <center><button id="add">add</button> <button id="stop">stop</button></center>
    <script>
        var autoadd = false;
        $('#add').on('click', function() {
            autoadd = true;
        });
        $('#stop').on('click', function() {
            autoadd = false;
        });

        setInterval(ajaxCall, 1000);

        function ajaxCall() {
            if (autoadd) {
                $.getJSON('./api.php?p=addsim', function(result) {
                    $("#data").html(JSON.stringify(result));
                });
            }
        }
    </script>
</body>

</html>