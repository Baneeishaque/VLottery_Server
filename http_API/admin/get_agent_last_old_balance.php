<?php

include_once '../config.php';
$agent = filter_input(INPUT_GET, 'agent');
$last_payment_id_sql = "SELECT MAX(id) AS id FROM `payment_clear` WHERE agent='$agent'";
$last_payment_id_result = $con->query($last_payment_id_sql);
$emptyarray = array();
if (mysqli_num_rows($last_payment_id_result) != 0) {

    array_push($emptyarray, array("status" => "0"));
    $last_payment_id_row = mysqli_fetch_assoc($last_payment_id_result);
    $last_payment_sql = "SELECT * FROM `payment_clear` WHERE id='" . $last_payment_id_row['id'] . "'";
    $last_payment_result = $con->query($last_payment_sql);
    $emptyarray[] = mysqli_fetch_assoc($last_payment_result);
} else {
    array_push($emptyarray, array("status" => "1"));
}

echo json_encode($emptyarray);
