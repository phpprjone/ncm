<?php

include "classes/db2.class.php";
include 'functions.php';


user_session_check();
/**
* Device Search section
*/
if ( $_SESSION['userid'] && isset($_POST['search_term']) && trim($_POST['search_term']) != '' ) {
  $_SESSION['search_term'] = $_POST['search_term'];
}
$userid = $_SESSION['userid'];
$listid = $_GET['listid'];
//$device_list = get_device_list_from_nodes($_SESSION['userid']);
$title = get_user_mylist_name($userid,$listid);
$page_title = 'NCM';
?>
<!DOCTYPE html>
<html>
    <head>
   <?php include("includes.php");  ?>
 <script src="resources/js/switchtech_user_devices.js?t=".<?php echo date('his'); ?>></script>
 <script type="text/javascript">
function modalClose() {
    if (location.hash == '#mycmdModal') {
        location.hash = '';
    }
}

document.addEventListener('keyup', function(e) {
    if (e.keyCode == 27) {
        modalClose();
    }
});

var modal = document.querySelector('#mycmdModal');
modal.addEventListener('click', function(e) {
    modalClose();
}, false);

modal.children[0].addEventListener('click', function(e) {
    e.stopPropagation();
}, false);
 </script>
 </head>
     <body class="hold-transition skin-blue sidebar-mini ownfont">
        <!-- Modal HTML -->

        <div style="min-height: 620px" class="container-fluid">
            <?php include ('menu.php'); ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content">
                <!-- Main content -->
                <section class="content">
                  <div class="col-md-12">
                      <div class="panel">
                          <div class="panel-info">
                            <!-- Page title -->
                            <div class="panel-heading"> List Name : <?php echo $title ?>  </div>
                          </div>
                         	<input type="hidden" id='userid' value="<?php echo $userid ?>" name="">
                          <div class="panel-body">
                            <table id="example" class="display" data-listid="<?php echo $listid ?>" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>&nbsp;</th>
								  <th>Id</th>
                                  <th>Site Id</th>
                                  <th width="25%">Site Name</th>
                                  <th>Device Name</th>
                                  <th>Market  </th>
                                  <th>Device series</th>
                                  <th>Version</th>
                                  <th>Last Polled</th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        <!-- /.box-body -->
                      </div>
                    </div>
                </section> <!-- /.content -->
              </div>
              <div id="mycmdModal" class="modal fade">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <!-- Content will be loaded here from "remote.php" file -->
                      </div>
                  </div>
              </div>
            <!-- /.content-wrapper -->

            <!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed
            immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->
        <?php include ('footer.php'); ?>

    </body>
</html>
