<?php

error_reporting(E_ERROR | E_PARSE);

//$con = new mysqli("localhost", "edcccet_ndk", "9895204814", "edcccet_lottery");
//$con = new mysqli("localhost", "vfmobo6d_ndk", "9895204814", "vfmobo6d_lottery");
//$con = new mysqli("localhost", "mudraqd8_root", "9895204814", "mudraqd8_wordpress");

$cpanel_username = "vfmobo6d";
//echo $cpanel_username;
//$con = new mysqli("localhost", "edcccet_ndk", "9895204814", "edcccet_lottery");
//$con = new mysqli("localhost", "vfmobo6d_ndk", "9895204814", "vfmobo6d_account_ledger");
$con = new mysqli("localhost", $cpanel_username . "_ndk", "aA9895204814", $cpanel_username . "_vlottery");
//echo $cpanel_username . "_ndk";
