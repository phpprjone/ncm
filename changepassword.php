<?php
include 'functions.php';
include "classes/db2.class.php";
if (isset($_POST['usremailid'])) {
    $emailid = $_POST['usremailid'];
   // $emailid ="enduser@gmail.com"; // Remove during live, this is temporary for testing.
    $output=userexist($emailid);
    if ($output >1 ) {
        // Create a unique salt. This will never leave PHP unencrypted.
        $salt = "498#2D83B631%3800EBD!801600D*7E3CC13";
        // Create the unique user password reset key
        $password = hash('sha512', $salt.$emailid); 
        // Create a url which we will direct them to reset their password
        $pwrurl = "http://localhost/ncm/reset_password.php?q=".$password; 
        // Mail them their key 
        //$mailbody = "Dear user,\n\nIf this e-mail does not apply to you please ignore it. It appears that you have requested a password reset at our website www.yoursitehere.com\n\nTo reset your password, please click the link below. If you cannot click it, please paste it into your web browser's address bar.\n\n" . $pwrurl . "\n\nThanks,\nThe Administration";
        $retval = sendmail($mailbody,$pwrurl);
        //echo "Value of returnval is  $retval";
        //$returnval = mail($emailid, "www.yoursitehere.com - Password Reset", $mailbody);
        //echo "Value of returnval is  $returnval";
        //echo "Your password recovery key has been sent to your e-mail address.".$returnval;    
        echo 'ok';
    };
};
?>