<?php

include_once '../config.php';
$get_agents_sql = "SELECT `ticket_scheme`, `scheme_limit`, `active` FROM `scheme_limits` ORDER BY `scheme_limits`.`position` ASC";

$result = $con->query($get_agents_sql);
$emptyarray = array();
if (mysqli_num_rows($result) != 0) {

    array_push($emptyarray, array("status" => "0"));
    while ($row = mysqli_fetch_assoc($result)) {
        $emptyarray[] = $row;
    }
} else {
    array_push($emptyarray, array("status" => "1"));
}

echo json_encode($emptyarray);
