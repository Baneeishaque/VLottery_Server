
<?php

include_once '../config.php';

$date = filter_input(INPUT_POST, 'date');
$scheme = filter_input(INPUT_POST, 'scheme');
$emptyarray = array();

$sql_sum = "SELECT SUM(amount) AS Amount FROM ticket WHERE `insertion_date`='$date'  AND `delete_status`=0";
$result_sum = $con->query($sql_sum);
$row_sum = mysqli_fetch_assoc($result_sum);
array_push($emptyarray, array("sum" => $row_sum['Amount']));

$sql = "SELECT DISTINCT `agent`,`name` FROM `ticket`,`agents` WHERE `agent`=`username` AND `scheme`='$scheme' AND `insertion_date`='$date'  AND `delete_status`=0";
//echo $sql;
$result = $con->query($sql);
while ($row = mysqli_fetch_assoc($result)) {
    $sql2 = "SELECT DISTINCT `serial` FROM `ticket` WHERE `agent`='" . $row['agent'] . "' AND `scheme`='$scheme' AND `insertion_date`='$date'  AND `delete_status`=0";
//    echo $sql2;
    $result2 = $con->query($sql2);
    while ($row2 = mysqli_fetch_assoc($result2)) {
        $sql3 = "SELECT SUM(`count`) AS `count` FROM `ticket` WHERE `agent`='" . $row['agent'] . "' AND `scheme`='$scheme' AND `insertion_date`='$date' AND `serial`='" . $row2['serial'] . "'  AND `delete_status`=0";
//        echo $sql3;
        $result3 = $con->query($sql3);
        while ($row3 = mysqli_fetch_assoc($result3)) {
            array_push($emptyarray, array("serial" => $row2['serial'], "count" => $row3['count'], "agent" => $row['agent'], "name" => $row['name']));
        }
    }
}

echo json_encode($emptyarray);
