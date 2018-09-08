<?php

//TODO : Add payment clear to agent addition
//TODO : Add agent_money table and avoid while loop

//error_reporting(E_ERROR | E_PARSE);

include_once 'config.php';

$agent = filter_input(INPUT_POST, 'agent');

$sql = "SELECT `clear_date` FROM `payment_clear` WHERE `agent`='$agent'";
//    echo $sql;
$result = $con->query($sql);

$row = mysqli_fetch_assoc($result);

$clear_date = $row['clear_date'];
//echo $clear_date;

$sql = "SELECT SUM(amount) AS total_sale_amount FROM `ticket` WHERE `agent`='$agent' AND `insertion_date`>'$clear_date'";
$result = $con->query($sql);

$row = mysqli_fetch_assoc($result);
if ($row['total_sale_amount'] == '') {

    $total_balance = 0;
} else {
    $total_balance = $row['total_sale_amount'];

//    echo '<br>' . $total_balance;

    $sql = "SELECT SUM(`prize_money`*`count`) AS `total_win_amount` FROM `ticket`,`result` WHERE `result`.`serial`=`ticket`.`serial` AND `result`.`scheme`=`ticket`.`scheme` AND `ticket`.`insertion_date`=`result`.`date_time` AND `agent`='$agent' AND `insertion_date`>'$clear_date'";
    $result = $con->query($sql);
    $row = mysqli_fetch_assoc($result);
    if ($row['total_win_amount'] != '') {

        $total_balance = $total_balance - $row['total_win_amount'];
    }

//    echo '<br>' . $total_balance;

    $sql = "SELECT `count`, `ticket`.`scheme`,`position` FROM `ticket`,`result` WHERE `result`.`serial`=`ticket`.`serial` AND `result`.`scheme`=`ticket`.`scheme` AND `ticket`.`insertion_date`=`result`.`date_time` AND `agent`='$agent' AND `insertion_date`>'$clear_date' ORDER BY `scheme`,`position`";
    $result = $con->query($sql);
    $total_agent_money = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $sql2 = "SELECT `get_agent_money` ('$agent' , '" . $row['scheme'] . "' , '" . $row['position'] . "') AS `get_agent_money`";
//    echo '<br>' . $sql2;
        $result2 = $con->query($sql2);
        $row2 = mysqli_fetch_assoc($result2);
//    echo '<br>' . $row2['get_agent_money'];
        $total_agent_money = $total_agent_money + ($row['count'] * $row2['get_agent_money']);
    }

    $total_balance = $total_balance - $total_agent_money;
}

echo $total_balance;

