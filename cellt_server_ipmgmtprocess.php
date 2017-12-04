<?php

include "classes/db2.class.php"; 
include 'functions.php';
 


$userid = $_SESSION['userid']; 
//$device_list = get_device_list_from_nodes($_SESSION['userid']); 
$device_list = get_device_list_ipmgmt_datatable($_SESSION['userid']); 
// print_r($device_list);
exit(json_encode($device_list, 1)); 