<?php

error_reporting(E_ERROR | E_PARSE);

include_once '../config.php';

$start = filter_input(INPUT_POST, 'start_date');
$end = filter_input(INPUT_POST, 'end_date');
$agent = filter_input(INPUT_POST, 'agent');

if ($start == $end) {

    $emptyarray = array();

    $sql = "SELECT SUM(`prize_money`*`count`) AS `total_win_amount`,DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date` FROM `ticket`,`resultv` WHERE `resultv`.`serial`=`ticket`.`serial` AND `resultv`.`scheme`=`ticket`.`scheme` AND `ticket`.`insertion_date`=`resultv`.`date_time` AND `agent`='$agent' AND `insertion_date`='$start' AND `delete_status`=0";
    //echo $sql;

    $result = $con->query($sql);
    $row = mysqli_fetch_assoc($result);
    if ($row['total_win_amount'] != '') {
        $emptyarray[] = $row;
//        array_push($emptyarray, array('total_win_amount' => "0", 'insertion_date' => $start));
//            $total_win_amount = 0;
    }
//    else {
//        $emptyarray[] = $row;
//            $total_win_amount = $row['total_win_amount'];
//    }

    $sql = "SELECT (`prize_money`*`count`) AS `win_amount`, `bill_no`, `ticket`.`serial`, `count`, `ticket`.`scheme`, DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date`,`prize_money`,`position` FROM `ticket`,`resultv` WHERE `resultv`.`serial`=`ticket`.`serial` AND `resultv`.`scheme`=`ticket`.`scheme` AND `ticket`.`insertion_date`=`resultv`.`date_time` AND `agent`='$agent' AND `insertion_date` BETWEEN '$start' AND '$end' AND `delete_status`=0 ORDER BY `bill_no` DESC,`insertion_date`,`scheme`";
    //echo $sql;
    $result = $con->query($sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $emptyarray[] = $row;
    }

//    $emptyarray = array('total_sale_amount' => $total_sale_amount, 'total_win_amount' => $total_win_amount, 'total_received_amount' => $total_received_amount, 'insertion_date' => $start);
} else {

    $start_date = date_create($start);
    $end_date = date_create($end);
    $end_date_plus = date_add($end_date, date_interval_create_from_date_string('1 day'));

    $emptyarray = array();

    while ($start_date != $end_date_plus) {

//        $sql = "SELECT SUM(`prize_money`*`count`) AS `total_win_amount`,`insertion_date` FROM `ticket`,`resultv` WHERE `resultv`.`serial`=`ticket`.`serial` AND `resultv`.`scheme`=`ticket`.`scheme` AND `ticket`.`insertion_date`=`resultv`.`date_time` AND `agent`='$agent' AND `insertion_date`='" . date_format($start_date, 'Y-m-d') . "'";
        //echo $sql;

//        $result = $con->query($sql);
//        $row = mysqli_fetch_assoc($result);
//        if ($row['total_win_amount'] != '') {
//            $emptyarray[] = $row;
//            array_push($emptyarray, array('total_win_amount' => "0", 'insertion_date' => $start));
//            $total_win_amount = 0;
//        } 
//        else {
//            $emptyarray[] = $row;
//            $total_win_amount = $row['total_win_amount'];
//        }

        $sql = "SELECT (`prize_money`*`count`) AS `win_amount`, `bill_no`, `ticket`.`serial`, `count`, `ticket`.`scheme`, DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date`,`prize_money`,`position` FROM `ticket`,`resultv` WHERE `resultv`.`serial`=`ticket`.`serial` AND `resultv`.`scheme`=`ticket`.`scheme` AND `ticket`.`insertion_date`=`resultv`.`date_time` AND `agent`='$agent' AND `insertion_date`='" . date_format($start_date, 'Y-m-d') . "' AND `delete_status`=0 ORDER BY `bill_no` DESC,`insertion_date`,`scheme`";
        //echo $sql;
        $result = $con->query($sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $emptyarray[] = $row;
        }



        date_add($start_date, date_interval_create_from_date_string('1 day'));
//        echo date_format($start_date, 'Y-m-d');
    }
}
echo json_encode($emptyarray);
