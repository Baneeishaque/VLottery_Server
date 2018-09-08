<?php

error_reporting(E_ERROR | E_PARSE);

include_once '../../config.php';

$username = filter_input(INPUT_POST, 'username');

$sql = "SELECT `username` FROM `agents` WHERE username='$username'";
$result = $con->query($sql);

if (mysqli_num_rows($result) == 0) {
    
    $name = filter_input(INPUT_POST, 'name');
    $agent = filter_input(INPUT_POST, 'agent');
    $shop = filter_input(INPUT_POST, 'shop');
    $address = filter_input(INPUT_POST, 'address');
    $place = filter_input(INPUT_POST, 'place');
    $contact = filter_input(INPUT_POST, 'contact');

    $password = filter_input(INPUT_POST, 'password');
    $a = filter_input(INPUT_POST, 'a');
    $ab = filter_input(INPUT_POST, 'ab');
    $abc = filter_input(INPUT_POST, 'abc');

    $agent_money_lsk1 = filter_input(INPUT_POST, 'agent_money_lsk1');
    $agent_money_lsk2 = filter_input(INPUT_POST, 'agent_money_lsk2');
    $agent_money_lsk3 = filter_input(INPUT_POST, 'agent_money_lsk3');
    $agent_money_lsk4 = filter_input(INPUT_POST, 'agent_money_lsk4');
    $agent_money_lsk5 = filter_input(INPUT_POST, 'agent_money_lsk5');
    $agent_money_lsk6 = filter_input(INPUT_POST, 'agent_money_lsk6');

    $agent_money_box1 = filter_input(INPUT_POST, 'agent_money_box1');
    $agent_money_box2 = filter_input(INPUT_POST, 'agent_money_box2');

    $agent_money_ab = filter_input(INPUT_POST, 'agent_money_ab');
    $agent_money_a = filter_input(INPUT_POST, 'agent_money_a');


    $sql = "INSERT INTO `agents`(`username`, `password`, `role`, `A`, `AB`, `ABC`, `phone`, `name`, `shop`, `address`, `place`,`agent_money_lsk1`,`agent_money_lsk2`,`agent_money_lsk3`,`agent_money_lsk4`,`agent_money_lsk5`,`agent_money_lsk6`,`agent_money_box1`,`agent_money_box2`,`agent_money_ab`,`agent_money_a`,`main_agent`, `insertion_date_time`, `inserter`) VALUES ('$username','$password','Sub',$a,$ab,$abc,'$contact','$name','$shop','$address','$place',$agent_money_lsk1,$agent_money_lsk2,$agent_money_lsk3,$agent_money_lsk4,$agent_money_lsk5,$agent_money_lsk6,$agent_money_box1,$agent_money_box2,$agent_money_ab,$agent_money_a,'$agent',CONVERT_TZ(NOW(),'-05:30','+00:00'),'Plus')";

    if (!$con->query($sql)) {
        $arr = array('status' => "1", 'error' => $con->error);
    } else {
        
//        $sql = "INSERT INTO `payment_clear`(`agent`) VALUES ('$username')";
//        if (!$con->query($sql)) {
//            $arr = array('status' => "1", 'error' => $con->error);
//        } else {
//            $arr = array('status' => "0");
//        }
        $arr = array('status' => "0");
    }
    
    
} else {
    
    $arr = array('status' => "1", 'error' => 'username already exists...');
}

echo json_encode($arr);
