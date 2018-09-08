<?php

error_reporting(E_ERROR | E_PARSE);

include_once 'config.php';

$start = filter_input(INPUT_POST, 'start_date');
$end = filter_input(INPUT_POST, 'end_date');

//$agent = filter_input(INPUT_POST, 'agent');

$sql = "SELECT `id`, `bill_no`, `serial`, `count`, `agent`, `scheme`, `amount`, DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date`,`insertion_time` FROM `ticket` WHERE `insertion_date` BETWEEN '$start' AND '$end' ORDER BY `bill_no` DESC,`insertion_date`,`scheme`,`id` DESC";
// echo $sql;

$result = $con->query($sql);

while ($row = mysqli_fetch_assoc($result)) {
    $emptyarray[] = $row;
}
echo json_encode($emptyarray);
