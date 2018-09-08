<?php

//error_reporting(E_ERROR | E_PARSE);

include_once '../config.php';

$username = $_POST['username'];
$password = $_POST['password'];
$flavour = $_POST['flavour'];

//TODO : Use dump from Symphony
//echo $username . " " . $password . " " . $flavour;

$sql = "SELECT COUNT(`username`) AS `user_count`, `role`, `userid`, `phone`, `name`, `shop_address`, `place`, `main_agent`, `insertion_date_time`, `inserter`, TIMEDIFF( DATE_FORMAT( CONVERT_TZ( NOW( ) , '-05:30', '+00:00' ) , '%H:%i:%s' ) , DATE_FORMAT( cut_time, '%H:%i:%s' ) ) AS difference, `" . $flavour . "_configuration`.`status` AS `flavour_status` FROM `agents`,`configuration`,`" . $flavour . "_configuration` WHERE username='$username' and password='$password' and `agents`.`status`=0";

//echo $sql;

$result = $con->query($sql);
$count = mysqli_num_rows($result);

$empty_array = array();

$time_difference_row = mysqli_fetch_assoc($result);

$empty_array[] = $time_difference_row;

if ($time_difference_row['flavour_status'] == '1') {

    if (strpos($time_difference_row['difference'], '-') !== false) {

        $empty_array[] = array('time_status' => "0");

    } else {

//    $time_difference_query2 = "SELECT TIMEDIFF( DATE_FORMAT( CONVERT_TZ( NOW( ) , '-05:30', '+00:00' ) , '%H:%i:%s' ) , DATE_FORMAT( resume_time, '%H:%i:%s' ) ) AS difference FROM configuration";
//
//    $time_difference_result2 = $con->query($time_difference_query2);
//
//    $time_difference_row2 = mysqli_fetch_assoc($time_difference_result2);
//
//    if (strpos($time_difference_row2['difference'], '-') !== false) {
//        $empty_array[] = array('time_status' => "1", 'resume' => $time_difference_row['resume_time']);
//    } else {
//        $empty_array[] = array('time_status' => "2");
//    }

        $empty_array[] = array('time_status' => "1");

    }

} else {

    $empty_array[] = array('time_status' => "-1");

}

echo json_encode($empty_array);
