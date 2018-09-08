<?php

include_once '../config.php';

$configuration_sql="SELECT `pos_lite_configuration`.`status` AS `pos_lite_status`,`pos_plus_configuration`.`status` AS `pos_plus_status`,`pos_automation_configuration`.`status` AS `pos_automation_status`,`reseller_configuration`.`status` AS `reseller_status` FROM `pos_lite_configuration`,`pos_plus_configuration`,`pos_automation_configuration`,`reseller_configuration`";

$result = $con->query($configuration_sql);

echo json_encode(mysqli_fetch_assoc($result));
