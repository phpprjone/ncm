<?php
include "classes/db2.class.php";
include 'functions.php';


$operation = $_POST['operation'];
$userid =$_POST['userid'];
$listid =$_POST['switchlistid'];

if ($operation == 'list') { 
  $output = usrfavritecondev_display($userid,$listid);
  //print_r($output['result']);
  $_SESSION['mylistname'] = $output['mylistname'];
  $_SESSION['listid'] = $listid;
  echo json_encode($output, 1);
}

if ($operation == 'add'){
  $data['deviceid'] = $_POST['deviceid'];
  $data['userid'] = $userid;
  $data['listid'] = $listid;

  insert_my_device_record($data);
}
?>