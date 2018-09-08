<?php

error_reporting(E_ERROR | E_PARSE);

include_once 'config.php';

$agent = filter_input(INPUT_POST, 'agent');
$amount = filter_input(INPUT_POST, 'amount');

$sql = "INSERT INTO `payment`(`agent`, `insertion_date`, `received_amount`, `insertion_time`) VALUES ('$agent',CONVERT_TZ(NOW(),'-05:30','+00:00'),$amount,CONVERT_TZ(NOW(),'-05:30','+00:00'))";

if (!$con->query($sql)) {
    $arr = array('status' => "1", 'error' => $con->error);
} else {
    $arr = array('status' => "0");
}
echo json_encode($arr);
