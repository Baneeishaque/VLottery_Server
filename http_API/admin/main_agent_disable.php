<?php

include_once '../config.php';

$agent = filter_input(INPUT_POST, 'agent');
//$resume_time = filter_input(INPUT_POST, 'resume_time');
//$caution_time = filter_input(INPUT_POST, 'caution_time');

$configuration_sql = "UPDATE `agents` SET `status`=1 WHERE `username`='$agent'";

if (!$con->query($configuration_sql)) {

    $arr = array('status' => "1", 'error' => $con->error);
} else {
    $arr = array('status' => "0");
}
echo json_encode($arr);
