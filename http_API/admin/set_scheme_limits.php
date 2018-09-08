<?php

include_once '../config.php';

$scheme_limit = filter_input(INPUT_POST, 'scheme_limit');
$ticket_scheme = filter_input(INPUT_POST, 'ticket_scheme');

$get_agents_sql = "UPDATE `scheme_limits` SET `scheme_limit`='$scheme_limit' WHERE `ticket_scheme`='$ticket_scheme'";

if (!$con->query($get_agents_sql)) {

    $arr = array('status' => "1", 'error' => $con->error);
} else {
    $arr = array('status' => "0");
}
echo json_encode($arr);
