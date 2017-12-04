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

$page_title = 'Cellsite tech device list';

?>
<!DOCTYPE html>
<html>
    <head>
   <?php include("includes.php");  ?>
<!--   <script src="resources/js/cellsitetech_user_devices.js?t=".<?php //echo date('his'); ?>></script>  -->
   <script src="resources/js/cellsitetech_user_devipmgmt.js?t=".<?php echo date('his'); ?>></script>
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
      <div id="mylist" class="panel-heading"><font color="black"><b>IP Address Management</b></font>
      </div>	
      <div class="panel-body">	
        <div class="col-md-6" style="background-color:nonelightgreen;">
          <!-- 
          
          <form id="usrmyfavlstfrm" name="usrmyfavlstfrm" action="switchtech_user_list.php" method = "POST" class="navbar-form search">
            <div class="input-group add-on" style="min-width:350px;margin-left:0px;">
              <input name="addlist" id="addlist" class="form-control search-details" placeholder="Create New List"  type="text">
              <span class="input-group-btn">
                <button class="btn btn-default search-details"  type ="submit" name="addlistbtn" name="addlistbtn"  value="Submit"><font color="black"><b>Submit</b></font></button>
              </span>                                       
            </div>
          </form>
           -->



    <form id="ip-mgmt" method="POST" action="cellsitetech_user_ip_mgt.php" class="form-horizontal">
    <?php if(isset($_SESSION['ip_err'])): ?>
    <div class="alert alert-danger">
    <?php if(isset($_SESSION['ip_err']['type']) && $_SESSION['ip_err']['type'] == 'ip-err'){ ?>
  	<strong>Danger!</strong> IP already In Use for <?php echo $_SESSION['ip_err']['market']; unset($_SESSION['ip_err']); ?>.
	<?php }elseif(isset($_SESSION['ip_err']['type']) && $_SESSION['ip_err']['type'] == 'market-exist'){?>
	<strong>Danger!</strong> Market already In Use for <?php echo $_SESSION['ip_err']['market']; unset($_SESSION['ip_err']); ?>.
	<?php }?>
	</div>
    <?php endif;?>
     <div class="form-group">
 <div class="col-xs-8">
 <?php $market_list = get_market_list();
 
 //print '<pre>';
 //print_r($market_list);
 ?>
  <select name="market" class="form-control" required id="sel1">
  	<option value="">Select Market</option>
  	<?php foreach ($market_list['result'] as $key => $val): ?>
    <option value="<?php echo $val['market_name']; ?>"><?php echo $val['market_name']; ?></option>
    <?php endforeach;?>
  </select>
  </div>
</div>
<div class="form-group">
<div class="col-xs-8">
<label class="radio-inline"><input type="radio" value="ip-v4" id="ip-v4-grp" checked="checked" name="optradio">IP V4</label>
<label class="radio-inline"><input type="radio" value="ip-v6" id="ip-v6-grp" name="optradio">IP V6</label>
</div>
</div>
<div id="ip-v4-grp-display">
<div class="form-group">
    <div class="col-xs-8">
        <input type="text" name="from_ipv4" class="form-control" required id="from_ipv4" placeholder="From IPV4">
    </div>
</div>
<div class="form-group">
    <div class="col-xs-8">
        <input type="text" name="to_ipv4" class="form-control" required id="to_ipv4" placeholder="To IPV4">
    </div>
</div>
</div> 
<div id="ip-v6-grp-display" style="display: none;">
<div class="form-group">
    <div class="col-xs-8">
        <input type="text" name="from_ipv6" class="form-control" id="from_ipv6" placeholder="From IPV6">
    </div>
</div>
<div class="form-group">
    <div class="col-xs-8">
        <input type="text" name="to_ipv6" class="form-control" id="to_ipv6" placeholder="To IPV6">
    </div>
</div>
</div> 


        <div class="form-group">
            <div class="col-xs-offset-2 col-xs-8">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>

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
                                  
                                  <th width="25%">Market Name</th>
                                  <th>From IPV4</th>
                                  <th>ToIPV4  </th>
                                  <th>From IPV6</th>
                                  <th>ToIPV6</th>
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