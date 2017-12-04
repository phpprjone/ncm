<?php
include ("classes/db2.class.php");
include "classes/paginator.class.php";  
include ("functions.php");


if ($_SESSION['userid'] && $_GET['marketname'] != ''){
  $_SESSION['marketname'] = $_GET['marketname'] ;
}

$sub_region_list = get_market_subregion_list( $_GET['marketname'] );  

header("content-type: application/json");
echo json_encode($sub_region_list['result']);
exit;