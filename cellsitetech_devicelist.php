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
/**
* Device Search section
*/
if ( $_SESSION['userid'] && isset($_POST['search_term']) && trim($_POST['search_term']) != '' ) {
  $_SESSION['search_term'] = $_POST['search_term'];
}

$device_list = get_device_list_from_nodes($_SESSION['userid']); 
$page_title = 'NCM';
$pages = new paginator();
$pages->items_total = $device_list['total_rec'];
$pages->mid_range =7; 
$pages->paginate();
 
?>
<!DOCTYPE html>
<html>
   <?php include("includes.php");  ?>
     <body class="hold-transition skin-blue sidebar-mini ownfont">
        <!-- Modal HTML -->
        
        <div id="mycmdModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Content will be loaded here from "remote.php" file -->
            </div>
        </div>
        </div>

        <div class="wrapper">
            <?php include ('menu.php'); ?> 

            <!-- Content Wrapper. Contains page content -->
            <div class="content">
                <!-- Main content -->
                <section class="content"> 
                  <div class="col-md-12">
                      <div class="box">
                        <div class="box box-solid">
                        <div class="box-header with-border">
                          <!-- Page title -->
                          <h3 class="box-title">Device List</h3>
                        </div>              		
                        <div>
                          <form class="navbar-form search" method="POST" action="cellsitetech_devicelist.php" role="search">
                            <div class="input-group add-on">
                              <input class="form-control" placeholder="Search" name="search_term" id="srch-term" type="text">
                                <div class="input-group-btn">
                                  <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search" style="color:#D52B1E"></i></button>
                                </div>                                       
                            </div>
                            <?php
                            if ($_SESSION['search_term']) {
                              ?>
                              <a type="button" class="btn bg-purple btn-flat margin"  title="Cleasr Search" href="cellsitetech_devicelist.php?clear=search"> <?php echo $_SESSION['search_term'] ?> <i class="fa fa-close pull-right"></i></a>
                              <?php
                            }
                            ?>
                          </form>
                        </div>						 
                          <div class="box-body">                                 
                            <?php 
                            if (count ($device_list['result'])) {
                              echo '<div class="box-body" style="margin-bottom:10px;margin-top:10px;">';
                              // Display page no of total page
                              echo "<p class=\"paginate\">Page: $pages->current_page of $pages->num_pages</p>\n";

                              // Display Total Records at right side
                              echo "<p class=\"pull-right\">Total Records: &nbsp;<span class=\"badge bg-gray\">". $device_list['total_rec'] ." </span></p>";

                              // Display pagination boxes
                              echo $pages->display_pages();
                              echo "<div class=\"spacer\"></div>";
                              echo '</div>';  
                            ?>
                            <div class="box-group"  id="accordion">
                              <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                              <?php                                                          
          							      foreach($device_list['result'] as $k => $device) {
							                  $userid = $_SESSION['userid'];	 
                                if ($k == 0) {
                               ?>  
                               <!-- Table Header section -->                                       
                                <table class="table table_header">
                                  <thead style="background-color:#f6f6f6;"> 
                                    <tr>
                                     <th width="10%">Severity</th>      
                                      <th width="20%">Device Name</th>
                                      <th width="10%">IP Address</th>
                                      <th width="10%">Reachable</th>
                                      <th width="10%">Operational</th>
                                      <th width="15%">Device Series</th> 
                                      <th  width="8%">Version</th>
                                      <th >Up Since</th>
                                    </tr>                                             
                                  </thead>  
                                </table>                                          
                                <?php
                              }
                              ?>
                              <!-- Table Records section -->
                              <div class="panel"  style="border: 1px solid  <?php echo ($k%2==0) ? '#fcfcfc':'#f6f6f6' ?>; margin-bottom: 2px;"> 
                                <table style=" <?php echo ($k%2==0) ? 'background-color: #fcfcfc':'background-color:#ffffff'; ?>" class="table device_details collapsed"  data-userid="<?php echo $userid; ?>"  data-deviceid="<?php echo $device['id']; ?>" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $k+1 ?>">

                                  <tbody>
                                    <tr>
                                  <td width="10%"> <?php echo $device['severity']; ?></td>
                                      <td width="20%"> <?php echo $device['deviceName'];  ?></td>
                                      <td width="10%"><?php echo $device['deviceIpAddr']; ?></td>
                                      <td width="10%"><?php echo $device['status'] == 1 ?  'Reachable' : 'Not Reachable'; ?></td>
                                      <td width="10%"><?php echo $device['investigationstate']; ?></td>
                                      <td width="15%"><?php echo $device['model']; ?> </td> 
                                      <td  width="8%"><?php echo $device['nodeVersion']; ?></td>
                                      <td >Up Since <?php echo date('m/d/Y', strtotime($device['upsince'])); ?></th>
                                    </tr>                                             
                                  </tbody>
                                </table>  
                                <div id="collapse<?php echo $k+1; ?>" class="mydevicebox_<?php echo $device['id']; ?> panel-collapse collapse"> 
                                  <!-- Innter HTML will be depicted for the selected Device details from ajax call --> 
                                </div>
                              </div>                                         
                            <?php
                            }
                            ?>
                            <div class="box-body">
                              <?php  
                                echo '<div class="box-body" style="margin-bottom:10px;margin-top:10px;">';
                                echo $pages->display_pages();
                                echo "<div class=\"spacer\"></div>";
                                echo "<p class=\"paginate\" style=\"padding-top:7px;\">Page: $pages->current_page of $pages->num_pages</p>";
                                echo "</div>";
                              ?>
                            </div> 
                            <?php
                            }
                            else {
                            ?>
                            <div class="panel center">  
                              No Records found 
                            </div>
                            <?php
                            }
                            ?>
                          </div>
                        </div>        
                        <!-- /.box-body -->
                      </div> 
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

        <?php include ('footer.php'); ?> 
        <script src="resources/js/devices.js?t=".<?php echo date('his'); ?>></script>
    </body>
</html>
