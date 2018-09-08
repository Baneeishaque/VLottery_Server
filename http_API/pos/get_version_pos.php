<?php

//error_reporting(E_ERROR | E_PARSE);

include_once '../config.php';

$status_sql = "SELECT `system_status` FROM `configuration`";
$status_result = $con->query($status_sql);
$status_row = mysqli_fetch_assoc($status_result);

$empty_array = array();

if ($status_row['system_status'] == '1') {

    $sql = "SELECT `status` AS `system_status`,`version_code`, `version_name` FROM `pos_configuration`";
    $result = $con->query($sql);
    $row = mysqli_fetch_assoc($result);

    if ($row['system_status'] == '1') {
        $empty_array[] = $row;
    } else {
        $empty_array[] = array('system_status' => "0");
    }

} else {
    $empty_array[] = $status_row;
}

echo json_encode($empty_array);


