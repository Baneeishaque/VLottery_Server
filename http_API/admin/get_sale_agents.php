<?php

include_once '../config.php';

$date = filter_input(INPUT_GET, 'date');

$emptyarray = array();

$agents_sql = "SELECT `username` FROM `agents`";
//$main_agents_sql = "SELECT `username` FROM `agents` WHERE `main_agent`='NA'";
//$distinct_serial_sql = "SELECT DISTINCT `serial` FROM `ticket` WHERE `scheme`='$scheme' AND `insertion_date`='$date'  AND `delete_status`=0";
//echo $agents_sql;
$agents_result = $con->query($agents_sql);
while ($agents_row = mysqli_fetch_assoc($agents_result)) {
//    $sum_serial_sql = "SELECT SUM(`count`) AS `count` FROM `ticket` WHERE  `scheme`='$scheme' AND `insertion_date`='$date' AND `serial`='" . $main_agents_row['serial'] . "'  AND `delete_status`=0";
    $total_sales_sql = "SELECT SUM(`amount`) AS `total_sales` FROM `ticket` WHERE `agent`='" . $agents_row['username'] . "' AND `insertion_date`='" . $date . "' AND `delete_status`=0";

//    echo $total_sales_sql;
    $total_sales_result = $con->query($total_sales_sql);
    while ($total_sales_row = mysqli_fetch_assoc($total_sales_result)) {
        if ($total_sales_row['total_sales'] != '') {
            array_push($emptyarray, array("agent" => $agents_row['username'], "total_sales" => $total_sales_row['total_sales']));
        }
    }
}

echo json_encode($emptyarray);
