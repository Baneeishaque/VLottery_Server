<?php

error_reporting(E_ERROR | E_PARSE);

include_once '../config.php';

$start = filter_input(INPUT_POST, 'start_date');
$end = filter_input(INPUT_POST, 'end_date');
$agent = filter_input(INPUT_POST, 'agent');
$sql = "SELECT SUM(`count`) AS tcount,SUM(amount) AS tamount,TIMEDIFF( DATE_FORMAT( CONVERT_TZ( NOW( ) , '-05:30', '+00:00' ) , '%H:%i:%s' ) , DATE_FORMAT( cut_time, '%H:%i:%s' ) ) AS difference,DATE_FORMAT(CONVERT_TZ( NOW( ) , '-05:30', '+00:00' ),'%d-%m-%Y' ) AS `current_date` FROM `ticket`,configuration WHERE `agent`='$agent' AND `insertion_date` BETWEEN '$start' AND '$end' AND `delete_status`=0";
//echo $sql;
$result = $con->query($sql);
$emptyarray = array();
while ($row = mysqli_fetch_assoc($result)) {
    $emptyarray[] = $row;
}

$sql = "SELECT `id`, `bill_no`, `serial`, `count`, `agent`, `scheme`, `amount`, DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date`,DATE_FORMAT( `insertion_time`, '%H:%i:%s' ) AS `insertion_time` FROM `ticket` WHERE `agent`='$agent' AND `insertion_date` BETWEEN '$start' AND '$end' AND `delete_status`=0 ORDER BY `bill_no` DESC,`insertion_date`,`scheme`,`id` DESC";
// echo $sql;
$result = $con->query($sql);

while ($row = mysqli_fetch_assoc($result)) {
    $emptyarray[] = $row;
}
echo json_encode($emptyarray);
