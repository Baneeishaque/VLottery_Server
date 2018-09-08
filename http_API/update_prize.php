<?php

error_reporting(E_ERROR | E_PARSE);

$agent_money_lsk1 = filter_input(INPUT_POST, 'agent_money_lsk1');
$agent_money_lsk2 = filter_input(INPUT_POST, 'agent_money_lsk2');
$agent_money_lsk3 = filter_input(INPUT_POST, 'agent_money_lsk3');
$agent_money_lsk4 = filter_input(INPUT_POST, 'agent_money_lsk4');
$agent_money_lsk5 = filter_input(INPUT_POST, 'agent_money_lsk5');
$agent_money_lsk6 = filter_input(INPUT_POST, 'agent_money_lsk6');

$agent_money_box1 = filter_input(INPUT_POST, 'agent_money_box1');
$agent_money_box2 = filter_input(INPUT_POST, 'agent_money_box2');
$agent_money_box3 = filter_input(INPUT_POST, 'agent_money_box3');
$agent_money_box4 = filter_input(INPUT_POST, 'agent_money_box4');
$agent_money_box5 = filter_input(INPUT_POST, 'agent_money_box5');
$agent_money_box6 = filter_input(INPUT_POST, 'agent_money_box6');

$agent_money_ab = filter_input(INPUT_POST, 'agent_money_ab');
$agent_money_bc = filter_input(INPUT_POST, 'agent_money_bc');
$agent_money_ac = filter_input(INPUT_POST, 'agent_money_ac');

$agent_money_a = filter_input(INPUT_POST, 'agent_money_a');
$agent_money_b = filter_input(INPUT_POST, 'agent_money_b');
$agent_money_c = filter_input(INPUT_POST, 'agent_money_c');


$sql = "UPDATE `prize` SET `amount`=$agent_money_lsk1 WHERE `scheme`='LSK' AND `position`=1";

if (!$con->query($sql)) {
    $arr = array('status' => "1", 'error' => $con->error);
} else {
    $sql = "UPDATE `prize` SET `amount`=$agent_money_lsk2 WHERE `scheme`='LSK' AND `position`=2";
    if (!$con->query($sql)) {
        $arr = array('status' => "1", 'error' => $con->error);
    } else {
        $sql = "UPDATE `prize` SET `amount`=$agent_money_lsk3 WHERE `scheme`='LSK' AND `position`=3";
        if (!$con->query($sql)) {
            $arr = array('status' => "1", 'error' => $con->error);
        } else {
            $sql = "UPDATE `prize` SET `amount`=$agent_money_lsk4 WHERE `scheme`='LSK' AND `position`=4";
            if (!$con->query($sql)) {
                $arr = array('status' => "1", 'error' => $con->error);
            } else {
                $sql = "UPDATE `prize` SET `amount`=$agent_money_lsk5 WHERE `scheme`='LSK' AND `position`=5";
                if (!$con->query($sql)) {
                    $arr = array('status' => "1", 'error' => $con->error);
                } else {
                    $sql = "UPDATE `prize` SET `amount`=$agent_money_lsk6 WHERE `scheme`='LSK' AND `position`=6";
                    if (!$con->query($sql)) {
                        $arr = array('status' => "1", 'error' => $con->error);
                    } else {
                        $sql = "UPDATE `prize` SET `amount`=$agent_money_box1 WHERE `scheme`='BOX' AND `position`=1";
                        if (!$con->query($sql)) {
                            $arr = array('status' => "1", 'error' => $con->error);
                        } else {
                            $sql = "UPDATE `prize` SET `amount`=$agent_money_box2 WHERE `scheme`='BOX' AND `position`=2";
                            if (!$con->query($sql)) {
                                $arr = array('status' => "1", 'error' => $con->error);
                            } else {
                                $sql = "UPDATE `prize` SET `amount`=$agent_money_box3 WHERE `scheme`='BOX' AND `position`=3";
                                if (!$con->query($sql)) {
                                    $arr = array('status' => "1", 'error' => $con->error);
                                } else {
                                    $sql = "UPDATE `prize` SET `amount`=$agent_money_box4 WHERE `scheme`='BOX' AND `position`=4";
                                    if (!$con->query($sql)) {
                                        $arr = array('status' => "1", 'error' => $con->error);
                                    } else {
                                        $sql = "UPDATE `prize` SET `amount`=$agent_money_box5 WHERE `scheme`='BOX' AND `position`=5";
                                        if (!$con->query($sql)) {
                                            $arr = array('status' => "1", 'error' => $con->error);
                                        } else {
                                            $sql = "UPDATE `prize` SET `amount`=$agent_money_box6 WHERE `scheme`='BOX' AND `position`=6";
                                            if (!$con->query($sql)) {
                                                $arr = array('status' => "1", 'error' => $con->error);
                                            } else {
                                                $sql = "UPDATE `prize` SET `amount`=$agent_money_ab WHERE `scheme`='AB' AND `position`=1";
                                                if (!$con->query($sql)) {
                                                    $arr = array('status' => "1", 'error' => $con->error);
                                                } else {
                                                    $sql = "UPDATE `prize` SET `amount`=$agent_money_bc WHERE `scheme`='BC' AND `position`=1";
                                                    if (!$con->query($sql)) {
                                                        $arr = array('status' => "1", 'error' => $con->error);
                                                    } else {
                                                        $sql = "UPDATE `prize` SET `amount`=$agent_money_ac WHERE `scheme`='AC' AND `position`=1";
                                                        if (!$con->query($sql)) {
                                                            $arr = array('status' => "1", 'error' => $con->error);
                                                        } else {
                                                            $sql = "UPDATE `prize` SET `amount`=$agent_money_a WHERE `scheme`='A' AND `position`=1";
                                                            if (!$con->query($sql)) {
                                                                $arr = array('status' => "1", 'error' => $con->error);
                                                            } else {
                                                                $sql = "UPDATE `prize` SET `amount`=$agent_money_b WHERE `scheme`='B' AND `position`=1";
                                                                if (!$con->query($sql)) {
                                                                    $arr = array('status' => "1", 'error' => $con->error);
                                                                } else {
                                                                    $sql = "UPDATE `prize` SET `amount`=$agent_money_c WHERE `scheme`='C' AND `position`=1";
                                                                    if (!$con->query($sql)) {
                                                                        $arr = array('status' => "1", 'error' => $con->error);
                                                                    } else {
                                                                        $arr = array('status' => "0");
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
echo json_encode($arr);
