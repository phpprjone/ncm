<?php
  include "classes/db2.class.php";
  include 'functions.php';
  $userid  = $_POST['userid'];
  $listid  = $_POST['switchlistid'];
  $result = usrfavritelistdel($userid,$listid);
  if ($_SESSION['switchlistid'] == $listid) {
    unset($_SESSION['switchlistid']);
  }
  // if ($result)  echo 'ok.from usrfavlistdel file'; 
?>