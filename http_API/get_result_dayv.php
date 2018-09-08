<?php

error_reporting(E_ERROR | E_PARSE);

include_once 'config.php';

$date = filter_input(INPUT_POST, 'date');
$sql = "SELECT `id`, `scheme`, `date_time`, `serial`, `position`, `prize_money` FROM `resultv` WHERE `date_time`='$date' ORDER BY `scheme` ,`position`";
// echo $sql;
$result = $con->query($sql);
$emptyarray = array();
if (mysqli_num_rows($result) != 0) {
    array_push($emptyarray, array("status" => "0"));
    while ($row = mysqli_fetch_assoc($result)) {
        $emptyarray[] = $row;
    }
} else {
    array_push($emptyarray, array("status" => "1"));
    $prize_sql = "SELECT `id`, `scheme`, `position`, `amount` FROM `prize` ORDER BY `scheme` ,`position`";
    $prize_result = $con->query($prize_sql);
    while ($prize_row = mysqli_fetch_assoc($prize_result)) {
        $emptyarray[] = $prize_row;
    }
}
echo json_encode($emptyarray);
