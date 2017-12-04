<?php

include "../classes/db2.class.php";
include "../classes/paginator.class.php";
include '../functions.php';

$error = array();

if (empty($_SESSION['userid'])) {
  $error['message'] = "Invalid access or User session expired";
}


if (isset($_GET['deviceid']) && isset($_GET['userid'])) {
  $device_details = getSWroutersDetails($_GET['deviceid'], $_SESSION['userid']);
}
 

?>

<div class="ownfont box-body launch-modal">
<?php
if (isset($device_details['result']) && count($device_details['result'])) {
  foreach ($device_details['result'] as $key => $output) {
    ?>
    <table class="draggable table table-bordered" cellspacing="0" data-userid="<?php echo $_SESSION['userid'] ?>" data-switchid="<?php echo $_GET['deviceid'] ?>" data-deviceid="<?php echo $output['id']; ?>"  data-devicename="<?php echo $output['deviceName']; ?>"cellpadding="0">
      <tbody> 
        <tr  >        
          <td><?php echo '<img src="./resources/img/router.png" alt="Router"   width="17" />&nbsp;' . $output['id']  ?></td>
          <td><?php echo $output['deviceName']; ?></td>
          <td><?php echo $output['deviceIpAddr']; ?></td>
          <td><?php echo $output['custom_Location']; ?>
          <td><?php echo $output['connPort']; ?></td>
          <td><?php echo $output['model']; ?></td> 
        </tr>       
      </tbody>
    </table>
    <?php
  }
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
</div>