<?php

//error_reporting(E_ERROR | E_PARSE);

include_once '../../config.php';

$start = filter_input(INPUT_POST, 'start_date');
$end = filter_input(INPUT_POST, 'end_date');
$main_agent = filter_input(INPUT_POST, 'agent');

if ($start == $end) {

    $flag = 0;

    $main_agent_sale_sql = "SELECT SUM(amount) AS total_sale_amount,DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date` FROM `ticket` WHERE `agent`='$main_agent' AND `insertion_date`='$start' AND `delete_status`=0";
//    echo 'Main Agent Sale SQL : '.$main_agent_sale_sql.'<br/>';

    $main_agent_sale_result = $con->query($main_agent_sale_sql);
    $main_agent_sale_row = mysqli_fetch_assoc($main_agent_sale_result);
    if ($main_agent_sale_row['total_sale_amount'] == '') {
        $flag = 1;
        $main_agent_total_sale_amount = "0";
    } else {
        $main_agent_total_sale_amount = $main_agent_sale_row['total_sale_amount'];
    }
    if ($flag != 1) {

        $main_agent_win_sql = "SELECT SUM(`prize_money`*`count`) AS `total_win_amount`,DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date` FROM `ticket`,`result` WHERE `result`.`serial`=`ticket`.`serial` AND `result`.`scheme`=`ticket`.`scheme` AND `ticket`.`insertion_date`=`result`.`date_time` AND `agent`='$main_agent' AND `insertion_date`='$start' AND `delete_status`=0";
//        echo 'Main Agent Win SQL : '.$main_agent_win_sql.'<br/>';

        $main_agent_win_result = $con->query($main_agent_win_sql);
        $main_agent_win_row = mysqli_fetch_assoc($main_agent_win_result);
        if ($main_agent_win_row['total_win_amount'] == '') {
            $main_agent_total_win_amount = "0";
        } else {
            $main_agent_total_win_amount = $main_agent_win_row['total_win_amount'];
        }
    } else {
        $main_agent_total_win_amount = "0";
    }

    $emptyarray = array();
    $emptyarray[] = array('total_sale_amount' => $main_agent_total_sale_amount, 'total_win_amount' => $main_agent_total_win_amount, 'total_received_amount' => "0", 'insertion_date' => date_format(date_create($start), 'd-m-Y'), 'agent' => $main_agent);

    $main_agent_tickets_sql = "SELECT `count`, `ticket`.`scheme`,`position`,`agent` FROM `ticket`,`result` WHERE `result`.`serial`=`ticket`.`serial` AND `result`.`scheme`=`ticket`.`scheme` AND `ticket`.`insertion_date`=`result`.`date_time` AND `agent`='$main_agent' AND `insertion_date`='$start' AND `delete_status`=0 ORDER BY `bill_no` DESC,`insertion_date`,`scheme`";
//    echo 'Main Agent Tickets SQL : '.$main_agent_tickets_sql.'<br/>';

    $tickets_result = $con->query($main_agent_tickets_sql);

    while ($tickets_row = mysqli_fetch_assoc($tickets_result)) {
        $emptyarray[] = $tickets_row;
    }

    $sub_agent_sql = "SELECT `username` FROM `agents` WHERE `main_agent` = '$main_agent'";
//    echo 'Sub Agent SQL : '.$sub_agent_sql.'<br/>';

    $sub_agent_result = $con->query($sub_agent_sql);
    while ($sub_agent_row = mysqli_fetch_assoc($sub_agent_result)) {

        $flag = 0;

        $sub_agent_sale_sql = "SELECT `get_sub_agent_sale_day` ('$main_agent', '" . $sub_agent_row['username'] . "', '$start') AS total_sale_amount ";
//        echo 'Sub Agent Sale SQL : ' . $sub_agent_sale_sql . '<br/>';
//        $sub_agent_sale_compare_sql = "SELECT `get_sub_agent_sale_day` ('$main_agent', '" . $sub_agent_row['username'] . "', '$start') AS total_sale_amount,SUM(amount) AS tamount FROM `ticket` WHERE `agent`='" . $sub_agent_row['username'] . "' AND `insertion_date` BETWEEN '$start' AND '$start' AND `delete_status`=0";
//        echo $sub_agent_sale_compare_sql . ';<br/>';

        $sub_agent_sale_result = $con->query($sub_agent_sale_sql);

        $sub_agent_sale_row = mysqli_fetch_assoc($sub_agent_sale_result);

        if ($sub_agent_sale_row['total_sale_amount'] == '') {

            $flag = 1;
            $sub_agent_total_sale_amount = "0";
        } else {
            $sub_agent_total_sale_amount = $sub_agent_sale_row['total_sale_amount'];
        }

        if ($flag != 1) {

            $sub_agent_win_sql = "SELECT SUM(`prize_money`*`count`) AS `total_win_amount`,DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date` FROM `ticket`,`result` WHERE `result`.`serial`=`ticket`.`serial` AND `result`.`scheme`=`ticket`.`scheme` AND `ticket`.`insertion_date`=`result`.`date_time` AND `agent`='" . $sub_agent_row['username'] . "' AND `insertion_date`='$start' AND `delete_status`=0";
//            echo 'Sub Agent Win SQL : '.$sub_agent_win_sql.'<br/>';

            $sub_agent_win_result = $con->query($sub_agent_win_sql);

            $sub_agent_win_row = mysqli_fetch_assoc($sub_agent_win_result);

            if ($sub_agent_win_row['total_win_amount'] == '') {
                $sub_agent_total_win_amount = "0";
            } else {
                $sub_agent_total_win_amount = $sub_agent_win_row['total_win_amount'];
            }
        } else {
            $sub_agent_total_win_amount = "0";
        }

        $emptyarray[] = array('total_sale_amount' => $sub_agent_total_sale_amount, 'total_win_amount' => $sub_agent_total_win_amount, 'total_received_amount' => "0", 'insertion_date' => date_format(date_create($start), 'd-m-Y'), 'agent' => $sub_agent_row['username']);

        $sub_agent_tickets_sql = "SELECT `count`, `ticket`.`scheme`,`position`,`agent` FROM `ticket` , `result` WHERE `result`.`serial`=`ticket`.`serial` AND `result`.`scheme`=`ticket`.`scheme` AND `ticket`.`insertion_date`=`result`.`date_time` AND `agent`='" . $sub_agent_row['username'] . "' AND `insertion_date`='$start' AND `delete_status`=0 ORDER BY `bill_no` DESC,`insertion_date`,`scheme`";
//        echo 'Sub Agent Tickets SQL : '.$sub_agent_tickets_sql.'<br/>';

        $sub_agent_tickets_result = $con->query($sub_agent_tickets_sql);

        while ($sub_agent_tickets_row = mysqli_fetch_assoc($sub_agent_tickets_result)) {
            $emptyarray[] = $sub_agent_tickets_row;
        }
    }

    echo json_encode($emptyarray);
} else {

    $start_date = date_create($start);
    $end_date = date_create($end);

    $end_date_plus = date_add($end_date, date_interval_create_from_date_string('1 day'));

    $emptyarray = array();

    while ($start_date != $end_date_plus) {

        $sql = "SELECT SUM(amount) AS total_sale_amount,DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date` FROM `ticket` WHERE `agent`='$main_agent' AND `insertion_date`='" . date_format($start_date, 'Y-m-d') . "' AND `delete_status`=0";
        //echo $sql;

        $flag = 0;

        $result = $con->query($sql);

        $row = mysqli_fetch_assoc($result);

        if ($row['total_sale_amount'] == '') {
            $flag = 1;
            $total_sale_amount = "0";
        } else {
            $total_sale_amount = $row['total_sale_amount'];
        }

        if ($flag != 1) {

            $sql = "SELECT SUM(`prize_money`*`count`) AS `total_win_amount`,DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date` FROM `ticket`,`result` WHERE `result`.`serial`=`ticket`.`serial` AND `result`.`scheme`=`ticket`.`scheme` AND `ticket`.`insertion_date`=`result`.`date_time` AND `agent`='$main_agent' AND `insertion_date`='" . date_format($start_date, 'Y-m-d') . "' AND `delete_status`=0";
            //echo $sql;

            $result = $con->query($sql);
            $row = mysqli_fetch_assoc($result);
            if ($row['total_win_amount'] == '') {
                $total_win_amount = "0";
            } else {
                $total_win_amount = $row['total_win_amount'];
            }
        } else {
            $total_win_amount = "0";
        }

        array_push($emptyarray, array('total_sale_amount' => $total_sale_amount, 'total_win_amount' => $total_win_amount, 'total_received_amount' => "0", 'insertion_date' => date_format($start_date, 'd-m-Y'), 'agent' => $main_agent));

        $sql = "SELECT `count`, `ticket`.`scheme`,`position`,DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date`,`agent` FROM `ticket`,`result` WHERE `result`.`serial`=`ticket`.`serial` AND `result`.`scheme`=`ticket`.`scheme` AND `ticket`.`insertion_date`=`result`.`date_time` AND `agent`='$main_agent' AND `insertion_date`='" . date_format($start_date, 'Y-m-d') . "' AND `delete_status`=0 ORDER BY `bill_no` DESC,`insertion_date`,`scheme`";
//    echo $sql;

        $result = $con->query($sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $emptyarray[] = $row;
        }

        $sql = "SELECT `username` FROM `agents` WHERE `main_agent` = '$main_agent'";
        //echo $sql;

        $result = $con->query($sql);

        while ($row = mysqli_fetch_assoc($result)) {

            $sql2 = "SELECT `get_sub_agent_sale_day` ('$main_agent', '" . $row['username'] . "', '" . date_format($start_date, 'Y-m-d') . "') AS total_sale_amount ";
//            echo $sql2;

            $flag = 0;

            $result2 = $con->query($sql2);

            $row2 = mysqli_fetch_assoc($result2);
            if ($row2['total_sale_amount'] == '') {
                $flag = 1;
                $total_sale_amount = "0";
            } else {
                $total_sale_amount = $row2['total_sale_amount'];
            }


            if ($flag != 1) {

                $sql2 = "SELECT SUM(`prize_money`*`count`) AS `total_win_amount`,DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date` FROM `ticket`,`result` WHERE `result`.`serial`=`ticket`.`serial` AND `result`.`scheme`=`ticket`.`scheme` AND `ticket`.`insertion_date`=`result`.`date_time` AND `agent`='" . $row['username'] . "' AND `insertion_date`='" . date_format($start_date, 'Y-m-d') . "' AND `delete_status`=0";
                //echo $sql;

                $result2 = $con->query($sql2);
                $row2 = mysqli_fetch_assoc($result2);
                if ($row2['total_win_amount'] == '') {
                    $total_win_amount = "0";
                } else {
                    $total_win_amount = $row2['total_win_amount'];
                }
            } else {
                $total_win_amount = "0";
            }

            array_push($emptyarray, array('total_sale_amount' => $total_sale_amount, 'total_win_amount' => $total_win_amount, 'total_received_amount' => "0", 'insertion_date' => date_format($start_date, 'd-m-Y'), 'agent' => $row['username']));

            $sql2 = "SELECT `count`, `ticket`.`scheme`,`position`,`agent`,DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date` FROM `ticket` , `result` WHERE `result`.`serial`=`ticket`.`serial` AND `result`.`scheme`=`ticket`.`scheme` AND `ticket`.`insertion_date`=`result`.`date_time` AND `agent`='" . $row['username'] . "' AND `insertion_date`='" . date_format($start_date, 'Y-m-d') . "' AND `delete_status`=0 ORDER BY `bill_no` DESC,`insertion_date`,`scheme`";
//            echo $sql2;

            $result2 = $con->query($sql2);

            while ($row2 = mysqli_fetch_assoc($result2)) {
                $emptyarray[] = $row2;
            }
        }

        date_add($start_date, date_interval_create_from_date_string('1 day'));
    }

    echo json_encode($emptyarray);
}