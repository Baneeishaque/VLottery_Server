<?php

//error_reporting(E_ERROR | E_PARSE);

include_once 'config.php';

$get_agents_sql = "SELECT `username`, `password`, `role`, `userid`, `phone`, `name`, `shop_address`, `place`, `status`, `main_agent`, `insertion_date_time`, `inserter`, `category` FROM `agents`";
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
