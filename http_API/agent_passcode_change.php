<?php

error_reporting(E_ERROR | E_PARSE);

include_once 'config.php';

$agent = filter_input(INPUT_POST, 'agent');
$passcode = filter_input(INPUT_POST, 'passcode');
//$caution_time = filter_input(INPUT_POST, 'caution_time');

$configuration_sql = "UPDATE `agents` SET `password`='$passcode' WHERE `username`='$agent'";

if (!$con->query($configuration_sql)) {

    $arr = array('status' => "1", 'error' => $con->error);
} else {
    $arr = array('status' => "0");
}
echo json_encode($arr);
