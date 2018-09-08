<?php

error_reporting(E_ERROR | E_PARSE);

include_once '../config.php';

$status_sql = "SELECT `status` FROM `configuration`";
$status_result = $con->query($status_sql);
$status_row = mysqli_fetch_assoc($status_result);

$emptyarray = array();

if ($status_row['status'] == '1') {

    $flavour = filter_input(INPUT_POST, 'flavour');

//    case "ndk.snake_automation":
//    return "pos_automation";
//    case "ndk.snake_pos_lite":
//    return "pos_lite";
//    case "ndk.snake_pos_partner":
//    return "pos_partner";
//    case "snake.pos_plus":
//    return "pos_plus";
//    case "ndk.prism.snake_reseller":
//    return "reseller";

    if ($flavour == "master") {
        $sql = "SELECT `version_code`, `version_name` FROM `admin_configuration`";
    } else if ($flavour == "pos") {
        $sql = "SELECT `version_code`, `version_name` FROM `client_configuration`";
    }

    $result = $con->query($sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $emptyarray[] = $row;
    }
} else {
    $emptyarray[] = array('version_code' => "0");
}

echo json_encode($emptyarray);


