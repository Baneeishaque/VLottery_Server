<?php

include_once '../config.php';

$date = filter_input(INPUT_POST, 'date');
$scheme = filter_input(INPUT_POST, 'scheme');
$emptyarray = array();

$distinct_serial_sql = "SELECT DISTINCT `serial` FROM `ticket` WHERE `scheme`='$scheme' AND `insertion_date`='$date'  AND `delete_status`=0";
//echo $distinct_serial_sql;
$distinct_serial_result = $con->query($distinct_serial_sql);
while ($distinct_serial_row = mysqli_fetch_assoc($distinct_serial_result)) {
    $sum_serial_sql = "SELECT SUM(`count`) AS `count` FROM `ticket` WHERE  `scheme`='$scheme' AND `insertion_date`='$date' AND `serial`='" . $distinct_serial_row['serial'] . "'  AND `delete_status`=0";
//    echo $sum_serial_sql;
    $sum_serial_result = $con->query($sum_serial_sql);
    while ($sum_serial_row = mysqli_fetch_assoc($sum_serial_result)) {
        array_push($emptyarray, array("serial" => $distinct_serial_row['serial'], "count" => $sum_serial_row['count']));
    }
}

echo json_encode($emptyarray);
