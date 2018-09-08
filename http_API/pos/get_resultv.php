<?php

error_reporting(E_ERROR | E_PARSE);

include_once '../config.php';

$start = filter_input(INPUT_POST, 'start_date');
$end = filter_input(INPUT_POST, 'end_date');
$sql = "SELECT `id`, `scheme`, DATE_FORMAT(`date_time`,'%d-%m-%Y' ) AS `date_time`, `serial`, `position`, `prize_money` FROM `resultv` WHERE `date_time` BETWEEN '$start' AND '$end' AND `scheme`='LSK' ORDER BY `date_time` DESC ,`position`";
// echo $sql;
$result = $con->query($sql);
if (mysqli_num_rows($result) != 0) {
    $emptyarray = array();
    array_push($emptyarray, array("status" => "0"));
    while ($row = mysqli_fetch_assoc($result)) {
        $emptyarray[] = $row;
    }
} else {
    array_push($emptyarray, array("status" => "1"));
}
echo json_encode($emptyarray);