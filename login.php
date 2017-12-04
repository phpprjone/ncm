<?php
include 'classes/db2.class.php';
include 'functions.php';
$page_title = 'NCM';
    //Destroy All sessions
    $_SESSION = array();

if (isset($_POST['username']) && $_POST['password']) {
   $username = $_POST['username'];
   $password = $_POST['password'];

   $userinfo = get_user_info($username, $password);
//exit(print_r( $userinfo));
   if ( ! $userinfo ) {
      $message['error'] = 'Username or Password is incorrect ';
   }
   else {
      $_SESSION['userid'] = $userinfo['id'];
      $_SESSION['username'] = $userinfo['username'];
      $_SESSION['userlevel'] = $userinfo['userlevel'];

      $_SESSION['welcome_username'] = $userinfo['fname'] . ' ' . $userinfo['lname'];
   }
   
    if (isset($_SESSION['userlevel']) && $_SESSION['userlevel']) {
      $location_href = get_landing_page(); 
// exit($location_href);
      header('Location:' . $location_href );
      exit;
    }

}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
   <?php include "includes.php" ?>
  </head> 
  <body>
    
    <!-- POPUP model bootrstap modle  -->  
    <!-- Links -->    
     <!--
     <a href ="#" class=" launch-modal" >Launch Demo Modal </a>
     -->
     <?php
     include "menu.php";
     ?>
     <div id="div1"></div> 
    <!-- Modal HTML -->
    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Content will be loaded here from "remote.php" file -->
            </div>
        </div>
    </div> 
    
    <!-- 12 Oct 17: Added class login-page and ncm logo -->
    <div class="login-page">
      <p class="logo"><a class="one"></a><a class="ems">NCM</a></p>
      
    <?php


    if (isset($message['error'])) {
      ?>
    
    <p class="warning"><?php echo $message['error']; ?></p>
    <?php }
    ?>
    
    <div class="form">
      <form class="login-form" action="login.php" method="post">
    
        <p class="box-title"> Username </p>
        <input name="username" type="text" />
        <p class="input-error" id="username"></p>
      
        <p class="box-title"> Password </p>
        <input name="password" type="password" />
        <p class="input-error" id="password"></p>
                             
        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        <!--
        
        <a href ="#" class=" launch-modal" ><p class="message">Forgot your password?</p> </a>
-->       <a href="#"><p class="message">Forgot your password?</p></a>

      
      </form>
    </div>
    </div> 
  </body>
</html>
