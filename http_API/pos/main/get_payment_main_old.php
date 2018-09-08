<?php

error_reporting(E_ERROR | E_PARSE);

include_once '../../config.php';

$start = filter_input(INPUT_POST, 'start_date');
$end = filter_input(INPUT_POST, 'end_date');
$agent = filter_input(INPUT_POST, 'agent');

if ($start == $end) {

    $flag = 0;

    $sql = "SELECT SUM(amount) AS total_sale_amount,DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date` FROM `ticket` WHERE `agent`='$agent' AND `insertion_date`='$start' AND `delete_status`=0";
    //echo $sql;

    $result = $con->query($sql);
    $row = mysqli_fetch_assoc($result);
    if ($row['total_sale_amount'] == '') {
        $flag = 1;
        $total_sale_amount = 0;
    } else {
        $total_sale_amount = $row['total_sale_amount'];
    }
    if ($flag != 1) {

        $sql = "SELECT SUM(`prize_money`*`count`) AS `total_win_amount`,DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date` FROM `ticket`,`result` WHERE `result`.`serial`=`ticket`.`serial` AND `result`.`scheme`=`ticket`.`scheme` AND `ticket`.`insertion_date`=`result`.`date_time` AND `agent`='$agent' AND `insertion_date`='$start' AND `delete_status`=0";

        $result = $con->query($sql);
        $row = mysqli_fetch_assoc($result);
        if ($row['total_win_amount'] == '') {
            $total_win_amount = 0;
        } else {
            $total_win_amount = $row['total_win_amount'];
        }
    } else {
        $total_win_amount = 0;
    }

    $sql = "SELECT SUM(received_amount) AS total_received_amount,DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date` FROM `payment` WHERE `agent`='$agent' AND `insertion_date`='$start'";

    $result = $con->query($sql);
    $row = mysqli_fetch_assoc($result);
    if ($row['total_received_amount'] == '') {
        $total_received_amount = 0;
    } else {
        $total_received_amount = $row['total_received_amount'];
    }
    $emptyarray = array();
    $emptyarray[] = array('total_sale_amount' => $total_sale_amount, 'total_win_amount' => $total_win_amount, 'total_received_amount' => $total_received_amount, 'insertion_date' => date_format(date_create($start), 'd-m-Y'), 'agent' => $agent);

    $sql = "SELECT `count`, `ticket`.`scheme`,`position`,`agent` FROM `ticket`,`result` WHERE `result`.`serial`=`ticket`.`serial` AND `result`.`scheme`=`ticket`.`scheme` AND `ticket`.`insertion_date`=`result`.`date_time` AND `agent`='$agent' AND `insertion_date`='$start' AND `delete_status`=0 ORDER BY `bill_no` DESC,`insertion_date`,`scheme`";

    $result = $con->query($sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $emptyarray[] = $row;
    }

    $sql = "SELECT `username` FROM `agents` WHERE `main_agent` = '$agent'";
//    echo $sql;

    $result = $con->query($sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $flag = 0;

        $sql2 = "SELECT `get_sub_agent_sale_day` ('$agent', '" . $row['username'] . "', '$start') AS total_sale_amount ";

//        $sql2 = "SELECT SUM(amount) AS total_sale_amount,DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date` FROM `ticket` WHERE `agent`='" . $row['username'] . "' AND `insertion_date`='$start'";
//        echo $sql2;

        $result2 = $con->query($sql2);
        $row2 = mysqli_fetch_assoc($result2);
        if ($row2['total_sale_amount'] == '') {
            $flag = 1;
            $total_sale_amount = 0;
        } else {
            $total_sale_amount = $row2['total_sale_amount'];
        }
        if ($flag != 1) {

            $sql2 = "SELECT SUM(`prize_money`*`count`) AS `total_win_amount`,DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date` FROM `ticket`,`result` WHERE `result`.`serial`=`ticket`.`serial` AND `result`.`scheme`=`ticket`.`scheme` AND `ticket`.`insertion_date`=`result`.`date_time` AND `agent`='" . $row['username'] . "' AND `insertion_date`='$start' AND `delete_status`=0";
            //echo $sql;

            $result2 = $con->query($sql2);
            $row2 = mysqli_fetch_assoc($result2);
            if ($row2['total_win_amount'] == '') {
                $total_win_amount = 0;
            } else {
                $total_win_amount = $row2['total_win_amount'];
            }
        } else {
            $total_win_amount = 0;
        }

        $sql2 = "SELECT SUM(received_amount) AS total_received_amount,DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date` FROM `payment` WHERE `agent`='" . $row['username'] . "' AND `insertion_date`='$start'";
        //echo $sql;

        $result2 = $con->query($sql2);
        $row2 = mysqli_fetch_assoc($result2);
        if ($row2['total_received_amount'] == '') {
            $total_received_amount = 0;
        } else {
            $total_received_amount = $row2['total_received_amount'];
        }

        $emptyarray[] = array('total_sale_amount' => $total_sale_amount, 'total_win_amount' => $total_win_amount, 'total_received_amount' => $total_received_amount, 'insertion_date' => date_format(date_create($start), 'd-m-Y'), 'agent' => $row['username']);

        $sql2 = "SELECT `count`, `ticket`.`scheme`,`position`,`agent` FROM `ticket` , `result` WHERE `result`.`serial`=`ticket`.`serial` AND `result`.`scheme`=`ticket`.`scheme` AND `ticket`.`insertion_date`=`result`.`date_time` AND `agent`='" . $row['username'] . "' AND `insertion_date`='$start' AND `delete_status`=0 ORDER BY `bill_no` DESC,`insertion_date`,`scheme`";
//        echo $sql2;

        $result2 = $con->query($sql2);

        while ($row2 = mysqli_fetch_assoc($result2)) {
            $emptyarray[] = $row2;
        }
    }
    echo json_encode($emptyarray);
} else {

    $start_date = date_create($start);
    $end_date = date_create($end);

    $end_date_plus = date_add($end_date, date_interval_create_from_date_string('1 day'));

    $emptyarray = array();
//    $temparray = array();

    while ($start_date != $end_date_plus) {

        $sql = "SELECT SUM(amount) AS total_sale_amount,DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date` FROM `ticket` WHERE `agent`='$agent' AND `insertion_date`='" . date_format($start_date, 'Y-m-d') . "' AND `delete_status`=0";
        //echo $sql;

        $result = $con->query($sql);
        $flag = 0;
        $row = mysqli_fetch_assoc($result);

        if ($row['total_sale_amount'] == '') {
            $flag = 1;
            $total_sale_amount = 0;
        } else {
            $total_sale_amount = $row['total_sale_amount'];
        }

        if ($flag != 1) {

            $sql = "SELECT SUM(`prize_money`*`count`) AS `total_win_amount`,DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date` FROM `ticket`,`result` WHERE `result`.`serial`=`ticket`.`serial` AND `result`.`scheme`=`ticket`.`scheme` AND `ticket`.`insertion_date`=`result`.`date_time` AND `agent`='$agent' AND `insertion_date`='" . date_format($start_date, 'Y-m-d') . "' AND `delete_status`=0";
            //echo $sql;

            $result = $con->query($sql);
            $row = mysqli_fetch_assoc($result);
            if ($row['total_win_amount'] == '') {
                $total_win_amount = 0;
            } else {
                $total_win_amount = $row['total_win_amount'];
            }
        } else {
            $total_win_amount = 0;
        }

        $sql = "SELECT SUM(received_amount) AS total_received_amount,DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date` FROM `payment` WHERE `agent`='$agent' AND `insertion_date`='" . date_format($start_date, 'Y-m-d') . "'";
        //echo $sql;

        $result = $con->query($sql);
        $row = mysqli_fetch_assoc($result);
        if ($row['total_received_amount'] == '') {
            $total_received_amount = 0;
        } else {
            $total_received_amount = $row['total_received_amount'];
        }

        array_push($emptyarray, array('total_sale_amount' => $total_sale_amount, 'total_win_amount' => $total_win_amount, 'total_received_amount' => $total_received_amount, 'insertion_date' => date_format($start_date, 'd-m-Y'), 'agent' => $agent));

        $sql = "SELECT `count`, `ticket`.`scheme`,`position`,DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date`,`agent` FROM `ticket`,`result` WHERE `result`.`serial`=`ticket`.`serial` AND `result`.`scheme`=`ticket`.`scheme` AND `ticket`.`insertion_date`=`result`.`date_time` AND `agent`='$agent' AND `insertion_date`='" . date_format($start_date, 'Y-m-d') . "' AND `delete_status`=0 ORDER BY `bill_no` DESC,`insertion_date`,`scheme`";
//    echo $sql;
        $result = $con->query($sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $emptyarray[] = $row;
        }

        $sql = "SELECT `username` FROM `agents` WHERE `main_agent` = '$agent'";
        //echo $sql;

        $i = 0;

        $result = $con->query($sql);

        while ($row = mysqli_fetch_assoc($result)) {

            $sql2 = "SELECT `get_sub_agent_sale_day` ('$agent', '" . $row['username'] . "', '" . date_format($start_date, 'Y-m-d') . "') AS total_sale_amount ";
//            echo $sql2;

            $result2 = $con->query($sql2);

            $flag = 0;

            $row2 = mysqli_fetch_assoc($result2);
            if ($row2['total_sale_amount'] == '') {
                $flag = 1;
                $total_sale_amount = 0;
            } else {
                $total_sale_amount = $row2['total_sale_amount'];
            }


            if ($flag != 1) {

                $sql2 = "SELECT SUM(`prize_money`*`count`) AS `total_win_amount`,DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date` FROM `ticket`,`result` WHERE `result`.`serial`=`ticket`.`serial` AND `result`.`scheme`=`ticket`.`scheme` AND `ticket`.`insertion_date`=`result`.`date_time` AND `agent`='" . $row['username'] . "' AND `insertion_date`='" . date_format($start_date, 'Y-m-d') . "' AND `delete_status`=0";
                //echo $sql;

                $result2 = $con->query($sql2);
                $row2 = mysqli_fetch_assoc($result2);
                if ($row2['total_win_amount'] == '') {
                    $total_win_amount = 0;
                } else {
                    $total_win_amount = $row2['total_win_amount'];
                }
            } else {
                $total_win_amount = 0;
            }

            $sql2 = "SELECT SUM(received_amount) AS total_received_amount,DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date` FROM `payment` WHERE `agent`='" . $row['username'] . "' AND `insertion_date`='" . date_format($start_date, 'Y-m-d') . "'";
            //echo $sql;

            $result2 = $con->query($sql2);
            $row2 = mysqli_fetch_assoc($result2);
            if ($row2['total_received_amount'] == '') {
                $total_received_amount = 0;
            } else {
                $total_received_amount = $row2['total_received_amount'];
            }

            array_push($emptyarray, array('total_sale_amount' => $total_sale_amount, 'total_win_amount' => $total_win_amount, 'total_received_amount' => $total_received_amount, 'insertion_date' => date_format($start_date, 'd-m-Y'), 'agent' => $row['username']));

            $sql2 = "SELECT `count`, `ticket`.`scheme`,`position`,`agent`,DATE_FORMAT(`insertion_date`,'%d-%m-%Y' ) AS `insertion_date` FROM `ticket` , `result` WHERE `result`.`serial`=`ticket`.`serial` AND `result`.`scheme`=`ticket`.`scheme` AND `ticket`.`insertion_date`=`result`.`date_time` AND `agent`='" . $row['username'] . "' AND `insertion_date`='" . date_format($start_date, 'Y-m-d') . "' AND `delete_status`=0 ORDER BY `bill_no` DESC,`insertion_date`,`scheme`";
//            echo $sql2;

            $result2 = $con->query($sql2);

            while ($row2 = mysqli_fetch_assoc($result2)) {
                $emptyarray[] = $row2;
            }
            $i++;
        }

        date_add($start_date, date_interval_create_from_date_string('1 day'));
//        echo date_format($start_date, 'Y-m-d');
    }
//    echo substr(json_encode($emptyarray), 0, -1) . "," . substr(json_encode($temparray), 1);
    echo json_encode($emptyarray);
}