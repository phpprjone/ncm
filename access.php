<?php 
include "classes/db2.class.php";
include 'functions.php';
?> 
<!DOCTYPE html>
<html>
   <head>
   <?php include("includes.php");  ?>
 </head>
     <body class="hold-transition skin-blue sidebar-mini ownfont">
        <!-- Modal HTML -->
         <div class="wrapper">
            <?php include ('menu.php'); ?> 
            <div class="content-wrapper">
            <!-- Content Wrapper. Contains page content -->
            <section class="content"  style="padding: 20px">

      <div class="error-page">
        <h2 class="headline text-red">401</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-red"></i> Access Denied</h3>
          <br>
          <p>
           <?php echo $_GET['msg']  ?>
          </p>

           
        </div>
      </div>
      <!-- /.error-page -->

    </section>  
</div>
</div>
</body>
</html>
