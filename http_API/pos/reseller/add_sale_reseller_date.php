<?php

error_reporting(E_ERROR | E_PARSE);

//upload test
include_once '../../config.php';

$json_data = $_POST['json_data'];
$json_data = str_replace("\\","",$json_data);

$agent = $_POST['agent'];
$date = $_POST['date'];

$result = "0";

$someObject = json_decode($json_data);
$bill_id_query = "SELECT MAX(bill_no) AS id from ticket";
$bill_no_result = $con->query($bill_id_query);

$bill_no_row = mysqli_fetch_assoc($bill_no_result);
if ($bill_no_row['id'] == '') {
    $bill_no = 1;
} else {
    $bill_no = $bill_no_row['id'] + 1;
}
//echo $bill_no;

foreach ($someObject as $key => $value) {
    $sql = "INSERT INTO `ticket`( `bill_no`, `serial`, `count`, `agent`, `scheme`, `amount`, `insertion_date`,`insertion_time`, `inserter`) VALUES ($bill_no,'$value->serial',$value->count,'$agent','$value->scheme',$value->amount,'$date',CONVERT_TZ(NOW(),'-05:30','+00:00'),'Reseller')";
    if (!$con->query($sql)) {
        $result = "1";
        break;
    }
}

if ($result == "1") {
    $arr = array('result' => "1", 'error' => mysqli_error($con));
} else {
    $arr = array('result' => "0", 'bill_no' => $bill_no);
}

echo json_encode($arr);
