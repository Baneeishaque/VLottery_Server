<?php

include_once '../../config.php';
$agent = filter_input(INPUT_POST, 'agent');
$start_date = filter_input(INPUT_POST, 'start_date');
$old_balance = filter_input(INPUT_POST, 'old_balance');
$amount = filter_input(INPUT_POST, 'amount');

$sql = "INSERT INTO `payment`(`agent`, `insertion_date_time`, `received_amount`) VALUES ('$agent',CONVERT_TZ(NOW(),'-05:30','+00:00'),'$amount')";

if (!$con->query($sql)) {
    $arr = array('status' => "1", 'error' => $con->error);
} else {
    $sql = "INSERT INTO `payment_clear`(`agent`, `start_date`, `old_balance`) VALUES ('$agent','$start_date','$old_balance')";
    if (!$con->query($sql)) {
        $arr = array('status' => "1", 'error' => $con->error);
    } else {
        $arr = array('status' => "0");
    }
}

echo json_encode($arr);
