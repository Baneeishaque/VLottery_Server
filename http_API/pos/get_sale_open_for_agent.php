<?php

error_reporting(E_ERROR | E_PARSE);

include_once '../config.php';

$start = filter_input(INPUT_GET, 'start_date');
$end = filter_input(INPUT_GET, 'end_date');
$agent = filter_input(INPUT_GET, 'agent');
$emptyarray = array();

if ($start == $end) {

    $sql3 = "SELECT SUM(`count`) AS `count`,DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date` FROM `ticket` WHERE `agent`='$agent' AND `insertion_date`='$start' AND (`scheme`='A' OR `scheme`='B' OR `scheme`='C')  AND `delete_status`=0";
//    echo $sql3;

    $result3 = $con->query($sql3);
    $emptyarray[] = mysqli_fetch_assoc($result3);
} else {

//    echo 'test';

    $start_date = date_create($start);
//    echo 'Start date' . date_format($start_date, 'Y-m-d');

    $end_date = date_create($end);

    $end_date_plus = date_add($end_date, date_interval_create_from_date_string('1 day'));

    while ($start_date != $end_date_plus) {

        $sql = "SELECT SUM(`count`) AS `count`,DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date` FROM `ticket` WHERE `agent`='$agent' AND `insertion_date`='" . date_format($start_date, 'Y-m-d') . "' AND (`scheme`='A' OR `scheme`='B' OR `scheme`='C')  AND `delete_status`=0";
//        echo $sql;

        $result = $con->query($sql);
        $emptyarray[] = mysqli_fetch_assoc($result);

        date_add($start_date, date_interval_create_from_date_string('1 day'));
//        echo date_format($start_date, 'Y-m-d');
    }
}

echo json_encode($emptyarray);
