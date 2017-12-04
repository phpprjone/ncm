<?php
  /* Partial code of listing routers list which is 
  *  tacken away from switchtech_devicelist.php file and being included as sw_results_for_map.php
  *  to implement tow type of record set for same query with different pagination limit
  */
                    $pages='';
                    if (isset($device_details['result']) && count($device_details['result'])) {
                      $pages = new Paginator();
                      // echo "<br>rec count : " ;
                      // echo $device_details['total_rec'];
                      $pages->items_total = $device_details['total_rec'];
                      $pages->mid_range =7;  
                      $pages->default_ipp = $page_limit;  
                      $temp_page_var = (isset($_GET['page'])) ? $_GET['page'] : 1;
                     
                      if (isset($_GET['page'])) {

                        if ($_GET['ipp'] ==  $high_limit) {
                          $_SESSION['high_page'] = $_GET['page'];
                        }

                        if ($_GET['ipp'] ==  $low_limit) {
                          $_SESSION['low_page'] = $_GET['page'];
                        }


                        if ($page_limit  ==  $high_limit) {
                          $_GET['page'] = ($_SESSION['high_page']) ? $_SESSION['high_page'] : '1';
                        }

                        if ($page_limit  ==  $low_limit) {
                          $_GET['page'] = ($_SESSION['low_page']) ? $_SESSION['low_page'] : '1';
                        }                      
                      }
                      else {
                        unset($_SESSION['low_page']);
                        unset($_SESSION['high_page']);
                        $_GET['page'] = 1;
                      }
                      $pages->paginate();
                      $_GET['page']=   $temp_page_var;
                     
                      ?>
                        <table class="table  table-border">
                          <thead>
                            <tr>        
                              <td width="18%"><b>ID</b></td>
                              <td width="36%"><b>Device Name</td>
                              <td width="20%"><b>Ip Address</td>
                              <td ><b>Custom Location</td>
                            </tr>
                          </thead>
                          <tbody> 
                      <?php
                      $k=0;
                      foreach ($device_details['result'] as $key => $output) {
                        ?>
                            <tr style="<?php echo ($k%2==0) ? 'background-color: #fcfcfc':'background-color:#ffffff'; ?>"  class="draggable table table-bordered" cellspacing="0" data-userid="<?php echo $_SESSION['userid'] ?>" data-listid="<?php echo $output['id'] ?>" data-deviceid="<?php echo $output['id']; ?>"  data-devicename="<?php echo $output['deviceName']; ?>"cellpadding="0" >        
                              <td width="15%"><?php echo '<img src="./resources/img/router.png" alt="Router"   width="17" />&nbsp;' . $output['id']  ?></td>
                              <td width="34%" ><?php echo $output['deviceName']; ?></td>
                              <td width="20%" ><?php echo $output['deviceIpAddr']; ?></td>
                              <td ><?php echo $output['custom_Location']; ?> </td>
                            </tr>       
                        <?php
                        $k++;
                      }
                      ?>
                          </tbody>
                        </table>
                      <?php
                        echo '<div class="box-body" style="margin-top:10px;">';
                        // Display page no of total page
                        echo "<p class=\"paginate\">Page: $pages->current_page of $pages->num_pages</p>\n";

                        // Display pagination boxes
                        echo $pages->display_pages();
                        echo "<div class=\"spacer\"></div>";
                        echo '</div>';  
                    }
                     
                    
                    else {
                      ?>
                      <table class="table table-bordered"  cellspacing="0" cellpadding="0">
                          <tbody>
                          <tr><td><span class="error-warning">No Devices assigned for this switch</span></td></tr>
                          </tbody>
                      </table>
                      <?php
                    }
?>