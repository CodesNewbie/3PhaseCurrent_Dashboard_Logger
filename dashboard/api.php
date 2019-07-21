<?php
header('Content-Type: application/json');
date_default_timezone_set('Asia/Bangkok');
include_once('./inc/conn.php');
include_once('./inc/sqli.php');

$action = $_GET["p"];

$jsonSim = "{\"i1\":" . rand(1, 50) . ",\"i2\":" . rand(1, 50) . ",\"i3\":" . rand(1, 50) . "}";


class sim extends database
{
    function __construct()
    {
        $this->conn = new database($GLOBALS['serverName'], $GLOBALS['userName'], $GLOBALS['userPassword'], $GLOBALS['dbName']);
    }
    function addsim()
    {
        try {
            $this->conn->insert('logger', array('device' => 'test',  'data' => $GLOBALS['jsonSim']));
            $res['status'] = "ok";
            $res['number'] = $this->conn->insert_id();
            echo json_encode($res);
        } catch (Exception $e) {
            $res2['status'] = "fail";
            $res2['data'] =  $e->getMessage();
            echo json_encode($res2);
        }
    }
}
class adddata extends database
{
    public $deviceid;
    public $data;

    function __construct()
    {
        $this->conn = new database($GLOBALS['serverName'], $GLOBALS['userName'], $GLOBALS['userPassword'], $GLOBALS['dbName']);
    }
    function add()
    {
        try {
            $this->conn->insert('logger', array('device' => $this->deviceid,  'data' => $this->data, 'time' => date("Y-m-d G:i:s")));
            $res['status'] = "ok";
            $res['number'] = $this->conn->insert_id();
            echo json_encode($res);
        } catch (Exception $e) {
            $res2['status'] = "fail";
            $res2['data'] =  $e->getMessage();
            echo json_encode($res2);
        }
    }
}
class getdata extends database
{
    public $limit;
    public $date;
    function __construct()
    {
        $this->conn = new database($GLOBALS['serverName'], $GLOBALS['userName'], $GLOBALS['userPassword'], $GLOBALS['dbName']);
    }
    function getsize()
    {
        try {
            $res = $this->conn->limit($this->limit)->order_by('time', 'DESC')->get('logger', array('data', 'time'));
            $array = array();
            if ($this->limit > 1) {
                foreach ($res as $val) {
                    $jsonResult = json_decode($val['data'], true);
                    $resau['time'] = $val['time'];
                    $resau['i1'] = $jsonResult['i1'];
                    $resau['i2'] = $jsonResult['i2'];
                    $resau['i3'] = $jsonResult['i3'];
                    array_push(
                        $array,
                        $resau
                    );
                }
            } else {
                $jsonResult = json_decode($res['data'], true);
                $resau['time'] = $res['time'];
                $resau['i1'] = $jsonResult['i1'];
                $resau['i2'] = $jsonResult['i2'];
                $resau['i3'] = $jsonResult['i3'];
                array_push(
                    $array,
                    $resau
                );
            }
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage();
        }
        echo json_encode(array_reverse($array), JSON_PRETTY_PRINT);
    }
    function getdate()
    {
        $days = str_replace('/', '-', $this->day);
        try {
            $res = $this->conn->wherelike('time', $days . '%')->order_by('time', 'DESC')->get('logger', array('data', 'time'));
            $array = array();

            if (sizeof($res) > 1) {
                foreach ($res as $val) {
                    $jsonResult = json_decode($val['data'], true);
                    $resau['time'] = $val['time'];
                    $resau['i1'] = $jsonResult['i1'];
                    $resau['i2'] = $jsonResult['i2'];
                    $resau['i3'] = $jsonResult['i3'];
                    array_push(
                        $array,
                        $resau
                    );
                }
            } else {
                $jsonResult = json_decode($res['data'], true);
                $resau['time'] = $res['time'];
                $resau['i1'] = $jsonResult['i1'];
                $resau['i2'] = $jsonResult['i2'];
                $resau['i3'] = $jsonResult['i3'];
                array_push(
                    $array,
                    $resau
                );
            }
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage();
        }
        echo json_encode(array_reverse($array), JSON_PRETTY_PRINT);
    }

    function getbetween()
    {

        $result_explode = explode('-', $this->date);
        $dateStart = $result_explode[0];
        $dateSEnd = $result_explode[1];
        $Start = str_replace('/', '-', $dateStart);
        $End = str_replace('/', '-', $dateSEnd);
        try {
            $res = $this->conn->wherebetween(array('time' => $Start, 'times' => $End))->order_by('time', 'DESC')->get('logger', array('data', 'time'));
            $array = array();

            if (sizeof($res) > 1) {
                foreach ($res as $val) {
                    $jsonResult = json_decode($val['data'], true);
                    $resau['time'] = $val['time'];
                    $resau['i1'] = $jsonResult['i1'];
                    $resau['i2'] = $jsonResult['i2'];
                    $resau['i3'] = $jsonResult['i3'];
                    array_push(
                        $array,
                        $resau
                    );
                }
            } else {
                $jsonResult = json_decode($res['data'], true);
                $resau['time'] = $res['time'];
                $resau['i1'] = $jsonResult['i1'];
                $resau['i2'] = $jsonResult['i2'];
                $resau['i3'] = $jsonResult['i3'];
                array_push(
                    $array,
                    $resau
                );
            }
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage();
        }
        echo json_encode(array_reverse($array), JSON_PRETTY_PRINT);
    }
}


switch ($action) {
    case "addsim":
        $x = new sim();
        $x->addsim();
        break;
    case "getdata":
        if (isset($_GET["limit"])) {
            $i = $_GET["limit"];
        } else {
            $i = 1;
        }
        $v = new getdata();
        $v->limit = $i;
        $v->getsize();
        break;
    case "getdate":
        if (isset($_GET["date"])) {
            $x = $_GET["date"];
        } else {
            $x = date("Y-m-d");
        }
        $y = new getdata();
        $y->date = $x;
        $y->getdate();
        break;
    case "getbetwin":
        if (isset($_GET["date"])) {
            $x = $_GET["date"];
        } else {
            $x = date("Y/m/d H:i:s", strtotime("-10 minutes")) . "-" . date("Y/m/d H:i:s");
        }
        $y = new getdata();
        $y->date = $x;
        $y->getbetween();
        break;
    case "adddata":
        if (isset($_POST["device"])) {
            $deviceid = $_POST["device"];
        }else{
            $deviceid = "null";
        }
        if (isset($_POST["data"])) {
            $data =  $_POST["data"];
        } else {
            $data = "{\"i1\":0,\"i2\":0,\"i3\":0}";
        }
            $y = new adddata();
            $y->deviceid = $deviceid;
            $y->data = $data;
            $y->add();
      
        break;
    case "add2":
        if (isset($_GET["d"]) && isset($_GET["d2"])) {
            $y = new adddata();
            $y->deviceid = $_GET["d"];
            $y->data = $_GET["d2"];
            $y->add();
        } else {
            echo ('false');
        }
        break;
    default:
        echo "Hi!";
}
