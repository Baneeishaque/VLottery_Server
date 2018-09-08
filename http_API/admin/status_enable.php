<?php

include_once '../config.php';

$action = filter_input(INPUT_POST, 'action');

switch ($action)
{
    case "pos_lite" : $configuration_sql = "UPDATE `pos_lite_configuration` SET `status`=1";
        break;
    case "pos_plus" : $configuration_sql = "UPDATE `pos_plus_configuration` SET `status`=1";
        break;
    case "pos_automation" : $configuration_sql = "UPDATE `pos_automation_configuration` SET `status`=1";
        break;
    case "reseller" : $configuration_sql = "UPDATE `reseller_configuration` SET `status`=1";
        break;
}

if (!$con->query($configuration_sql)) {

    $arr = array('status' => "1", 'error' => $con->error);
} else {
    $arr = array('status' => "0");
}
echo json_encode($arr);
