<?php

error_reporting(E_ERROR | E_PARSE);

include_once '../config.php';

$serial = $_GET['serial'];
$scheme = $_GET['scheme'];
$entry_count = $_GET['entry_count'];
$flavour = filter_input(INPUT_GET, 'flavour');

$time_difference_query = "SELECT TIMEDIFF( DATE_FORMAT( CONVERT_TZ( NOW( ) , '-05:30', '+00:00' ) , '%H:%i:%s' ) , DATE_FORMAT( cut_time, '%H:%i:%s' ) ) AS difference,resume_time,`" . $flavour . "_configuration`.`status` AS `flavour_status` FROM `" . $flavour . "_configuration`,configuration";
$time_difference_result = $con->query($time_difference_query);
$time_difference_row = mysqli_fetch_assoc($time_difference_result);

if ($time_difference_row['flavour_status'] == '1') {
    if (strpos($time_difference_row['difference'], '-') !== false) {

        $sum_serial_sql = "SELECT 
                        * 
                    FROM (
                        SELECT 
                            SUM(  `count` ) AS  `count` 
                        FROM  `ticket` 
                            WHERE  `scheme` =  '$scheme'
                            AND  `insertion_date` = STR_TO_DATE( CONVERT_TZ( NOW( ) ,  '-05:30',  '+00:00' ) ,  '%Y-%m-%d' ) 
                            AND  `serial` =  '$serial'
                            AND  `delete_status` =0
                         ) AS  `current_ticket_status` 
                    JOIN (

                        SELECT  
                            `scheme_limit` 
                        FROM  `scheme_limits` 
                            WHERE  `ticket_scheme` =  '$scheme'
                            AND  `active` =1
                        ) AS  `ticket_status_result`";

//    echo $sum_serial_sql;
    } else {

//    echo 'later';

        $time_difference_query2 = "SELECT TIMEDIFF( DATE_FORMAT( CONVERT_TZ( NOW( ) , '-05:30', '+00:00' ) , '%H:%i:%s' ) , DATE_FORMAT( resume_time, '%H:%i:%s' ) ) AS difference FROM configuration";
        $time_difference_result2 = $con->query($time_difference_query2);
        $time_difference_row2 = mysqli_fetch_assoc($time_difference_result2);
        if (strpos($time_difference_row2['difference'], '-') !== false) {
            echo "-1";
            exit();
        } else {

            $sum_serial_sql = "SELECT 
                        * 
                    FROM (
                        SELECT 
                            SUM(  `count` ) AS  `count` 
                        FROM  `ticket` 
                            WHERE  `scheme` =  '$scheme'
                            AND `insertion_date`=DATE_ADD(STR_TO_DATE(CONVERT_TZ(NOW(),'-05:30','+00:00'),'%Y-%m-%d'), INTERVAL 1 DAY) 
                            AND  `serial` =  '$serial'
                            AND  `delete_status` =0
                         ) AS  `current_ticket_status` 
                    JOIN (

                        SELECT  
                            `scheme_limit` 
                        FROM  `scheme_limits` 
                            WHERE  `ticket_scheme` =  '$scheme'
                            AND  `active` =1
                        ) AS  `ticket_status_result`";

//        echo $sum_serial_sql;
        }
    }

    $sum_serial_result = $con->query($sum_serial_sql);
    $sum_serial_row = mysqli_fetch_assoc($sum_serial_result);

//echo mysqli_num_rows($sum_serial_result);

    if (mysqli_num_rows($sum_serial_result) == 0) {
        echo "0";
    } else {
        if ($sum_serial_row['count'] == '') {
            if ($entry_count <= $sum_serial_row['scheme_limit']) {
                echo "0";
            } else {
                echo "2";
            }
        } else {

//    echo $sum_serial_row['count'] + $entry_count;
//    echo $sum_serial_row['limit'];

            if (($sum_serial_row['count'] + $entry_count) <= $sum_serial_row['scheme_limit']) {
                echo "0";
            } else {
                if ($sum_serial_row['count'] < $sum_serial_row['scheme_limit']) {
                    echo "2";
                } else {
                    echo "1";
                }
            }
        }
    }
} else {
    echo "3";
}



