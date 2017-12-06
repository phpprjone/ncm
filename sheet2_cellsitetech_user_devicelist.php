<?php

include "classes/db2.class.php";
include "classes/paginator.class.php";
include 'functions.php';

//Static variable values set
if (isset($_GET['clear']) ) {
    if (strtolower($_GET['clear']) == 'search') {
        unset($_SESSION['search_term']);
    }
}

user_session_check();
check_user_authentication('1'); //cellsite tech type user

$page_title = 'NCM';

?>
<!DOCTYPE html>
<html>
    <head>
   <?php include("includes.php");  ?>
   <script src="resources/js/cellsitetech_user_discresults.js?t=".<?php echo date('his'); ?>></script>
 </head>	
     <body class="hold-transition skin-blue sidebar-mini ownfont">
        <div id="mainctr" class="container-fluid">
  <div id="mainctrow" class="row">
    <?php 
    // Include menu bar htmls [ Logo, welcome text, menu ]
    include ('menu.php'); 
    ?>   
  </div>
  <div class="row">
   <!-- <div id="lhspanel"  class="col-sm-6 col-md-6 panel-info" style="background-color: white; min-height: 780px"> -->
   <div id="lhspanel" style="background-color: white; min-height: 780px">
      <div id="mylist" class="panel-heading"><font color="black"><b>Discovery Results</b></font>
      </div>	
      <div class="panel-body">	
        <div class="col-md-6" style="background-color:nonelightgreen;">  
          <?php 
          // Switch list create success message display
          if ($succss_msg != '') {  
          ?>
            <div class="text-success"><?php echo $succss_msg ?></div>
          <?php
          }
          ?>
        </div>
      </div>
      <div class="col-md-12">
        <div class="row">
          
		  <div class="content">
                <!-- Main content -->
                <section class="content"> 
                  <div class="col-md-12">
                      <div class="panel"> 
                          <div class="panel-info">
                            <!-- Page title -->
                          <!--  <div class="panel-heading"> My Devices List </div>
                          </div>                  
						  -->
                          <input type="hidden" id='userid' value="<?php echo $userid ?>" name="">
                          <div class="panel-body">
                            <table id="example" class="display" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>&nbsp;</th>                                  
                                  <th>Scan Time</th>
                                  <th>Device IP</th>
                                  <th>PING  </th>
                                  <th>Device ID</th>
                                  <th>OS</th>
								  <th>Version</th>
								  <th>Device Series</th>
								  <th>Processed</th>
                                </tr>
                              </thead>                              
                            </table>                            
                          </div> 
                        <!-- /.box-body -->
                      </div>
                  </div> 
                </section> <!-- /.content -->
              </div>
            <!-- /.content-wrapper --> 
            <!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed
            immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->
         
          </div>
        </div>
    </div>
    <!-- START : Right side panel  -->
	<!--
    <div id="rhsPanel" class="col-sm-6 col-md-6" >
    </div> 
	-->
  <!-- Start: Modal popup place holder 
  <div id="mycmdModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            Content will be loaded here from "remote.php" file 
        </div>
    </div>
  </div> END: Modal popup place holder -->

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
</html>