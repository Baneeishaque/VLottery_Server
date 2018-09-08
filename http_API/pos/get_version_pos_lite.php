<?php

error_reporting(E_ERROR | E_PARSE);

include_once '../config.php';

$status_sql = "SELECT `status` FROM `configuration`";
$status_result = $con->query($status_sql);
$status_row = mysqli_fetch_assoc($status_result);

$emptyarray = array();

if ($status_row['status'] == '1') {

    $sql = "SELECT `status`,`version_code`, `version_name` FROM `pos_lite_configuration`";
    $result = $con->query($sql);
    $row = mysqli_fetch_assoc($result);

    if ($row['status'] == '1') {

        $emptyarray[] = array('version_code' => $row['version_code'], 'version_name' => $row['version_name']);
    } else {
        $emptyarray[] = array('version_code' => "0");
    }
    
} else {
    $emptyarray[] = array('version_code' => "0");
}

echo json_encode($emptyarray);


