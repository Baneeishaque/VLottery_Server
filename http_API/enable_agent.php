<?php

//error_reporting(E_ERROR | E_PARSE);

include_once 'config.php';

$agent = filter_input(INPUT_POST, 'agent');

$configuration_sql = "UPDATE `agents` SET `status`=0 WHERE `username`='$agent'";

if (!$con->query($configuration_sql)) {

    $arr = array('status' => "1", 'error' => $con->error);

} else {

    $arr = array('status' => "0");

}

echo json_encode($arr);
