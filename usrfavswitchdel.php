<?php
  include "classes/db2.class.php";
  include 'functions.php';
  $userid  = $_POST['userid'];
  $listid  = $_POST['listid'];
  $switchid  = $_POST['switchid'];
  $result = usrfavritelistswdel($userid,$listid,$switchid);
?>