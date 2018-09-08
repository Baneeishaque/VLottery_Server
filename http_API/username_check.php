<?php

error_reporting(E_ERROR | E_PARSE);

include_once 'config.php';

$username = $_POST['username'];

$sql = "SELECT COUNT(`username`) AS `count` FROM `agents` WHERE username='$username'";
//echo $sql;
$result = $con->query($sql);
//print_r($result);
$row=mysqli_fetch_assoc($result);
//print_r($row);
if ($row['count'] != 0) {
    echo "1";
} else {
    echo "0";
}
