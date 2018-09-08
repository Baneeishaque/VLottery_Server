<?php

error_reporting(E_ERROR | E_PARSE);

include_once '../config.php';

$start = filter_input(INPUT_GET, 'start_date');
$end = filter_input(INPUT_GET, 'end_date');

$emptyarray = array();

if ($start == $end) {

    $sql_sum = "SELECT SUM(amount) AS Amount FROM ticket WHERE `insertion_date`='$start'  AND `delete_status`=0";
    $result_sum = $con->query($sql_sum);
    $row_sum = mysqli_fetch_assoc($result_sum);

//    array_push($emptyarray, array("sale" => $row_sum['Amount']));
//    $sql = "SELECT (`prize_money`*`count`) AS `win_amount`, `count`, `ticket`.`scheme`,`position`,DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date` FROM `ticket`,`result` WHERE `result`.`serial`=`ticket`.`serial` AND `result`.`scheme`=`ticket`.`scheme` AND `ticket`.`insertion_date`=`result`.`date_time` AND `insertion_date`='$start' AND `delete_status`=0 ORDER BY `insertion_date` ASC";

    $sql = "SELECT SUM((`prize_money`*`count`)) AS `win_amount`,DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date` FROM `ticket`,`result` WHERE `result`.`serial`=`ticket`.`serial` AND `result`.`scheme`=`ticket`.`scheme` AND `ticket`.`insertion_date`=`result`.`date_time` AND `insertion_date`='$start' AND `delete_status`=0 ORDER BY `insertion_date` ASC";

    $result = $con->query($sql);
    $row = mysqli_fetch_assoc($result);
    array_push($emptyarray, array("sale" => $row_sum['Amount'], "win" => $row['win_amount'], "insertion_date" => $start, "profit" => ($row_sum['Amount'] - $row['win_amount'])));
    
} else {
    
    $start_date = date_create($start);
    $end_date = date_create($end);
    $end_date_plus = date_add($end_date, date_interval_create_from_date_string('1 day'));
    
    while ($start_date != $end_date_plus) {

        $sql_sum = "SELECT SUM(amount) AS Amount FROM ticket WHERE `insertion_date`='" . date_format($start_date, 'Y-m-d') . "' AND `delete_status`=0";
        $result_sum = $con->query($sql_sum);
        $row_sum = mysqli_fetch_assoc($result_sum);

        $sql = "SELECT SUM((`prize_money`*`count`)) AS `win_amount`,DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date` FROM `ticket`,`result` WHERE `result`.`serial`=`ticket`.`serial` AND `result`.`scheme`=`ticket`.`scheme` AND `ticket`.`insertion_date`=`result`.`date_time` AND `insertion_date`='" . date_format($start_date, 'Y-m-d') . "' AND `delete_status`=0 ORDER BY `insertion_date` ASC";

        $result = $con->query($sql);
        $row = mysqli_fetch_assoc($result);
        array_push($emptyarray, array("sale" => $row_sum['Amount'], "win" => $row['win_amount'], "insertion_date" => date_format($start_date, 'Y-m-d'), "profit" => ($row_sum['Amount'] - $row['win_amount'])));

        date_add($start_date, date_interval_create_from_date_string('1 day'));
    }
}

echo json_encode($emptyarray);

