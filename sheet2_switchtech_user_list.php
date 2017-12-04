<?php
  include ("classes/db2.class.php");
  include "classes/paginator.class.php";  
  include ("functions.php");   
  user_session_check(); 
  //Check for switch tech type user
  check_user_authentication('2'); 
  $page_title =  'NCM';
  // Default map dispaly flag true
  $show_map_flag = true;
  // Map flag set to false once map is clicked
  // print_r($_GET);

  if (isset($_GET['markets']) &&  $_GET['markets'] !='') { 
      $marketname =  $_SESSION['marketname'] = $_GET['markets']; 
       $show_map_flag = false;
      unset($_SESSION['switch_device_id']);     
  }
  else {  
    $marketname = null;
    unset($_SESSION['marketname']);  
  }
   
 
  $userid = $_SESSION['userid'];
  $succss_msg  = '';

  if (isset($_POST['addlist']) && $_POST['addlist'] ) {
    $_SESSION['succss_msg'] = '';

    if ($_SESSION['mylistname'] != $_POST['addlist']){
      $data=array('listname'=>$_POST['addlist'],'userid'=>$userid);
      $result = insert_usrfavritedev($data);
      $_SESSION['mylistname'] = $_POST['addlist'];
      $_SESSION['succss_msg'] = 'Created succesfully';
    } 
  }

  if (isset($_GET['action']) && $_GET['action'] == 'editmylist') {
    $switchlistid = $_SESSION['switchlistid'] = $_GET['switchlistid'];
  } 
   
  
?>
<!DOCTYPE html>
<html lang="en">
<head>  
<?php include("includes.php");  ?>
<script src="resources/js/switchtech_user_list.js?t=<?php echo date('his'); ?>"></script>
</head>  
<body>
<div id="mainctr" class="container-fluid">
  <div id="mainctrow" class="row">
    <?php 
    // Include menu bar htmls [ Logo, welcome text, menu ]
    include ('menu.php'); 
    ?>   
  </div>
  <div class="row">
    
    <div id="mylist" class="panel-heading" style="height:450px;" ><center><h1>This Page Under Construction</h1></div> 


  <!-- Hidden field for user id value -->
  <input type="hidden" id="hidd_userid" value="<?php echo $_SESSION['userid'] ?>">     
  
  <!-- Include custom js file for switchtech_devicelist page -->  
  <div style="clear:both;"></div>
  </div>
</div>
  

 <?php 
    // Footder section include file
    include ('footer.php');
  ?> 
</body>
</html>