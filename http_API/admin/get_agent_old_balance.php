<?php

include_once '../config.php';
$agent = filter_input(INPUT_GET, 'agent');
$sql = "SELECT * FROM `payment_clear` WHERE agent='$agent'";
$result = $con->query($sql);
$emptyarray = array();
if (mysqli_num_rows($result) != 0) {

    array_push($emptyarray, array("status" => "0"));

    $emptyarray[] = mysqli_fetch_assoc($result);
} else {
    array_push($emptyarray, array("status" => "1"));
}

echo json_encode($emptyarray);
