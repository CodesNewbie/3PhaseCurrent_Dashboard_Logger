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

    <link rel="stylesheet" href="assets/css/style.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="assets/css/daterangepicker.css">
    <link rel="stylesheet" href="assets/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="assets/css/buttons.dataTables.min.css">

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
   
    <script src="assets/js/bootstrap-datepicker.min.js"></script>
    <script src="assets/js/daterangepicker.min.js"></script>
    <script src="assets/js/chart.js"></script>
    <script src="assets/js/hammerjs.js"></script>
    <script src="assets/js/chartjs-plugin-zoom.js"></script>

    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.buttons.min.js"></script>
    <script src="assets/js/buttons.flash.min.js"></script>
    <script src="assets/js/jszip.min.js"></script>
    <script src="assets/js/pdfmake.min.js"></script>
    <script src="assets/js/vfs_fonts.js"></script>
    <script src="assets/js/buttons.html5.min.js"></script>
    <script src="assets/js/buttons.print.min.js"></script>




</head>

<body>
    <?php

    $active = "active";
    $current_page = 'home';

    if (array_key_exists('page', $_GET)) {
        $current_page = $_GET['page'];
    };
    ?>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <a class="navbar-brand" href="./index.php?page=home">เครื่องวัดกระแสไฟฟ้า 3 เฟส ระบบเครื่อข่าย</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page != "report") ? $active : ''; ?>" href="./index.php?page=home">หน้าหลัก</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == "report") ?  $active : ''; ?>" href="./index.php?page=report">รายงาน</a>
                </li>
            </ul>
        </div>
    </nav>
    <?php
    switch ($current_page) {
        case 'report':
            $ac = 1;
            define('BASEPATH', "");
            include 'report.php';
            break;
        case 'home':
        default:
            $ac = 2;
            define('BASEPATH', "");
            include 'dashboard.php';
    }
    ?>