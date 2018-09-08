<?php

include_once '../config.php';

$ticket_scheme = filter_input(INPUT_POST, 'ticket_scheme');

$configuration_sql = "UPDATE `scheme_limits` SET `active`=1 WHERE `ticket_scheme`='$ticket_scheme'";

if (!$con->query($configuration_sql)) {
    $arr = array('status' => "1", 'error' => $con->error);
} else {
    $arr = array('status' => "0");
}
echo json_encode($arr);
