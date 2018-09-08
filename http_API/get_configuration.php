<?php

error_reporting(E_ERROR | E_PARSE);

include_once 'config.php';

$sql = "SELECT `cut_time`, `resume_time`, `caution_time` FROM `configuration`";
// echo $sql;
$result = $con->query($sql);
$emptyarray = array();
while ($row = mysqli_fetch_assoc($result)) {
    $emptyarray[] = $row;
}
echo json_encode($emptyarray);
