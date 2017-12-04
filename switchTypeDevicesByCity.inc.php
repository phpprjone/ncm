<?php
if (empty($_SESSION['userid'])){
  exit("Invalid access or User session expired");
}
$userid = $_SESSION['userid'];


$device_list = get_switchlist_for_market_subregion($_SESSION['userid'],$_SESSION['marketname'], $_SESSION['city_name']); 

$pages = new Paginator();
$pages->items_total = $device_list['total_rec'];
$pages->mid_range =7; 
$pages->paginate();

?>
<div class="panel-group"  id="accordion">
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

$k=0;
foreach ($device_list['result'] as $key => $device) {
    ?>
  <div class="panel"  style="border: 1px solid  <?php echo ($k%2==0) ? 'lightblue':'lightgray' ?>; margin-bottom: 2px;"> 
    <table style=" <?php echo ($k%2==0) ? 'background-color: rgb(236,245,245)':'background-color:rgb(245,245,245)'; ?>" class="table device_details collapsed"  data-userid="<?php echo $userid; ?>"  data-deviceid="<?php echo $device['id']; ?>" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $k+1 ?>">
      <tbody>
        <tr>
          <td width="3%"><span class=" fa fa-reorder">&nbsp;</span></span></td>
          <td width="10%"> <?php  echo $device['id']; ?></td>
          <td width="20%"> <?php echo $device['deviceName'];  ?></td>
          <td width="10%"><?php echo $device['city']; ?></td>
          <td width="10%"><?php echo $device['custom_Location'] ?></td> 
        </tr>                                             
      </tbody>
    </table>     

  <div id="collapse<?php echo $k+1; ?>" class="panel-collapse collapse" style="max-height: 200px; overflow-y:scroll; ">
    <!-- Innter HTML will be depicted for the selected Device details from ajax call --> 
     
  </div>       
  </div>                                
    <?php
    $k++;
  }
}
else {
  ?>
   <div class="panel"  style="border: 1px solid lightblue; padding:15px; margin-bottom: 2px;"> 
    <div>No records found for this region : <?php echo $city_name ?></div>
   </div>
  <?php
}
?>
</div>