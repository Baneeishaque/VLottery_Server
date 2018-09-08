<?php

error_reporting(E_ERROR | E_PARSE);

include_once 'config.php';

$cut_time = filter_input(INPUT_POST, 'cut_time');
$resume_time = filter_input(INPUT_POST, 'resume_time');
$caution_time = filter_input(INPUT_POST, 'caution_time');

$configuration_sql = "UPDATE `configuration` SET `cut_time`='$cut_time',`resume_time`='$resume_time',`caution_time`='$caution_time'";

if (!$con->query($configuration_sql)) {

    $arr = array('status' => "1", 'error' => $con->error);
} else {
    $arr = array('status' => "0");
}
echo json_encode($arr);
