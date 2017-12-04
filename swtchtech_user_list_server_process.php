<?php

include "classes/db2.class.php"; 
include 'functions.php';
  
 
$list_for = $_GET['list_for'];

$list_type = $_GET['list_type'];
//$device_list = get_device_list_from_nodes($_SESSION['userid']); 
$resultset = get_swt_user_routers_list_datatable($list_for, $list_type);


exit(json_encode($resultset, 1));