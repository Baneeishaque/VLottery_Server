<?php

//error_reporting(E_ERROR | E_PARSE);

include_once '../config.php';

$username = filter_input(INPUT_POST, 'username');

$sql = "SELECT `username` FROM `agents` WHERE username='$username'";
$result = $con->query($sql);

if (mysqli_num_rows($result) == 0) {

    $category = filter_input(INPUT_POST, 'category');
    $name = filter_input(INPUT_POST, 'name');
    $shop_address = filter_input(INPUT_POST, 'shop_address');
    $place = filter_input(INPUT_POST, 'place');
    $phone = filter_input(INPUT_POST, 'phone');

    $password = filter_input(INPUT_POST, 'password');

    $sql = "INSERT INTO `agents`(`username`, `password`, `role`, `phone`, `name`, `shop_address`, `place`, `insertion_date_time`, `inserter`, `category`) VALUES ('$username','$password','Saler','$phone','$name','$shop_address','$place',CONVERT_TZ(NOW(),'-05:30','+00:00'),'Admin','$category')";

    if (!$con->query($sql)) {

        $arr = array('status' => "1", 'error' => $con->error);

    } else {

        //TODO : Use Trigger
        $sql = "INSERT INTO `payment_clear`(`agent`,`start_date`,`old_balance`) VALUES ('$username',CONVERT_TZ(NOW(),'-05:30','+00:00'),0)";

        if (!$con->query($sql)) {

            $arr = array('status' => "1", 'error' => $con->error);

        } else {

            $arr = array('status' => "0");

        }

        $arr = array('status' => "0");
    }

} else {

    $arr = array('status' => "1", 'error' => 'username already exists...');

}

echo json_encode($arr);
