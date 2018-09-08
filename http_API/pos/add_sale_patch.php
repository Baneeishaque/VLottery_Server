<?php

error_reporting(E_ERROR | E_PARSE);

include_once '../config.php';

$flavour = filter_input(INPUT_POST, 'flavour');

$time_difference_query = "SELECT TIMEDIFF( DATE_FORMAT( CONVERT_TZ( NOW( ) , '-05:30', '+00:00' ) , '%H:%i:%s' ) , DATE_FORMAT( cut_time, '%H:%i:%s' ) ) AS difference,resume_time,`" . $flavour . "_configuration`.`status` AS `flavour_status` FROM `" . $flavour . "_configuration`,configuration";
$time_difference_result = $con->query($time_difference_query);
$time_difference_row = mysqli_fetch_assoc($time_difference_result);

if ($time_difference_row['flavour_status'] == '1') {
    if (strpos($time_difference_row['difference'], '-') !== false) {
//    echo 'before';
        $json_data = $_POST['json_data'];
        $json_data = str_replace("\\","",$json_data);
        
        //echo $json_data;
        $agent = $_POST['agent'];

        $result = "0";

        $someObject = json_decode($json_data);
        $bill_id_query = "SELECT MAX(bill_no) AS id from ticket";
        $bill_no_result = $con->query($bill_id_query);

        $bill_no_row = mysqli_fetch_assoc($bill_no_result);
        if ($bill_no_row['id'] == '') {
            $bill_no = 1;
        } else {
            $bill_no = $bill_no_row['id'] + 1;
        }
//echo $bill_no;

        foreach ($someObject as $key => $value) {
            $sql = "INSERT INTO `ticket`( `bill_no`, `serial`, `count`, `agent`, `scheme`, `amount`, `insertion_date`,`insertion_time`) VALUES ($bill_no,'$value->serial',$value->count,'$agent','$value->scheme',$value->amount,CONVERT_TZ(NOW(),'-05:30','+00:00'),CONVERT_TZ(NOW(),'-05:30','+00:00'))";
            if (!$con->query($sql)) {
                $result = "1";
                break;
            }
        }

        if ($result == "1") {
            $arr = array('result' => "1", 'error' => mysqli_error($con));
        } else {
            $arr = array('result' => "0", 'bill_no' => $bill_no);
        }
    } else {
//    echo 'later';

        $time_difference_query2 = "SELECT TIMEDIFF( DATE_FORMAT( CONVERT_TZ( NOW( ) , '-05:30', '+00:00' ) , '%H:%i:%s' ) , DATE_FORMAT( resume_time, '%H:%i:%s' ) ) AS difference FROM configuration";
        $time_difference_result2 = $con->query($time_difference_query2);
        $time_difference_row2 = mysqli_fetch_assoc($time_difference_result2);
        if (strpos($time_difference_row2['difference'], '-') !== false) {
            $arr = array('result' => "2", 'resume' => $time_difference_row['resume_time']);
        } else {
            $json_data = $_POST['json_data'];
            $json_data = str_replace("\\","",$json_data);
            $agent = $_POST['agent'];

            $result = "0";

            $someObject = json_decode($json_data);

            $bill_id_query = "SELECT MAX(bill_no) AS id from ticket";
            $bill_no_result = $con->query($bill_id_query);

            $bill_no_row = mysqli_fetch_assoc($bill_no_result);

            if ($bill_no_row['id'] == '') {
                $bill_no = 1;
            } else {
                $bill_no = $bill_no_row['id'] + 1;
            }
            //echo $bill_no;

            foreach ($someObject as $key => $value) {
                $sql = "INSERT INTO `ticket`( `bill_no`, `serial`, `count`, `agent`, `scheme`, `amount`, `insertion_date`,`insertion_time`) VALUES ($bill_no,'$value->serial',$value->count,'$agent','$value->scheme',$value->amount,DATE_ADD(CONVERT_TZ(NOW(),'-05:30','+00:00'), INTERVAL 1 DAY),CONVERT_TZ(NOW(),'-05:30','+00:00'))";

                if (!$con->query($sql)) {
                    $result = "1";
                    break;
                }
            }

            if ($result == "1") {
                $arr = array('result' => "1", 'error' => mysqli_error($con));
            } else {
                $arr = array('result' => "0", 'bill_no' => $bill_no);
            }
        }
    }
} else {
    $arr = array('result' => "2");
}

echo json_encode($arr);
