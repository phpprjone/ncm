<?php
  include ("classes/db2.class.php");
  include "classes/paginator.class.php";  
  include ("functions.php"); 
  user_session_check(); 
  //Check for switch tech type user
  check_user_authentication('2'); 
  $page_title = 'NCM';
  // Default map dispaly flag true
  $show_map_flag = true;
  // Map flag set to false once map is clicked
  // print_r($_GET);

  if (isset($_GET['markets']) &&  $_GET['markets'] !='') { 
      $marketname =  $_SESSION['marketname'] = $_GET['markets']; 
       $show_map_flag = false;
      unset($_SESSION['switch_device_id']);     
  }
  else {  
    $marketname = null;
    unset($_SESSION['marketname']);  
  }
  
  // To set map flag false if user seached by search form submit
  if (isset($_GET['search_term'])) {
    $show_map_flag = false;
  } 
  
  // To set map flag true if user clicked low limit pagination
  if (isset($_GET['ipp']) &&  $_GET['ipp'] == LOW_LIMIT){
          $show_map_flag = true;
  }
  // To set map flag flase if user clicked high limit pagination
  if (isset($_GET['ipp']) &&  $_GET['ipp'] == HIGH_LIMIT){
          $show_map_flag = false;
  }
 
  $userid = $_SESSION['userid'];
  $succss_msg  = '';

  if (isset($_POST['addlist']) && $_POST['addlist'] ) {
    $_SESSION['succss_msg'] = '';

    if ($_SESSION['mylistname'] != $_POST['addlist']){
      $data=array('listname'=>$_POST['addlist'],'userid'=>$userid);
      $result = insert_usrfavritedev($data);
      $_SESSION['mylistname'] = $_POST['addlist'];
      $_SESSION['succss_msg'] = 'Created succesfully';
    } 
  }

  if (isset($_GET['action']) && $_GET['action'] == 'editmylist') {
    $switchlistid = $_SESSION['switchlistid'] = $_GET['switchlistid'];
  } 
  
  if ( isset($_GET['search_term']) ){
    $search_term = ( trim($_GET['search_term']) != '') ? trim($_GET['search_term']) : '';
  } 

  if (isset($_GET['submit']) && strtolower($_GET['submit']) == 'clear' ) {
    $search_term = null;
  }
  
?>
<!DOCTYPE html>
<html lang="en">
<head>  
<?php include("includes.php");  ?>
</head>  
<body>
<div id="mainctr" class="container-fluid">
  <div id="mainctrow" class="row">
    <?php 
    // Include menu bar htmls [ Logo, welcome text, menu ]
    include ('menu.php'); 
    ?>   
  </div>
  <div class="row" >
    <div id="lhspanel"  class="col-sm-6 col-md-6 panel-info" style="background-color: white; min-height: 780px">
      <div id="mylist" class="panel-heading"><b>My List</b>
      </div>
      <div class="panel-body">
        <div class="col-md-12" style="background-color: nonelightgreen;">
          <form id="usrmyfavlstfrm" name="usrmyfavlstfrm" action="switchtech_devicelist.php" method = "POST" class="navbar-form search">
            <div class="input-group add-on">
              <input name="addlist" id="addlist" class="form-control search-details" placeholder="Create New List"  type="text">
              <span class="input-group-btn">
                <button class="btn btn-default search-details"  type ="submit" name="addlistbtn" name="addlistbtn"  value="Submit">Submit</button>
              </span>                                       
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
          <div id="switchlist" class="panel-warning col-md-6 ">
            <div class="panel-heading" id="delete_mylists" style="background-color:#F6F6F6";>
              <b>My Device List </b>
              <!-- Deleted selected switch list by drag and drop area -->
              <span id="myswitchlist_delete" type="button" class="droppable pull-right box box-danger">
                <i class="fa fa-trash"></i>&nbsp; Delete 
              </span>
            </div>
            <div class ="panel-body" style="border: 1px solid #FAEBCC">
              <table  width="100%"  id="<?php echo $device['id'] ?>" class="myswlist table table-border">
                <thead>
                  <tr>
                    <td width="80%" >List name  </td><td  width="20%"> Edit </td><td  width="20%">View</td>           
                  </tr>
                </thead>
                <tbody> 
                <?php  
                  $userid =  $_SESSION['userid'];
                  $myswitchlist = usrfavritelist_display($userid);                       
                  foreach($myswitchlist['result'] as $key=>$value) { 
                  ?> 
                    <tr class="del_<?php echo $value['listid'];?>">                            
                      <td width="73%" >
                        <i data-listid="<?php echo $value['listid'] ?>" data-listname=" <?php echo $value['listname']; ?>" data-deviceid="<?php echo $value['nodeid'] ?>" class="<?php echo (strtolower($value['listname']) != 'default') ? 'draggable' : '' ?> fa fa-arrows"></i>&nbsp;
                      <?php echo $value['listname']; ?>
                      </td>
                      <td>&nbsp;<a href="?action=editmylist&switchlistid=<?php echo $value['listid'];?>"><i class="fa fa-edit"></i></a>
                      </td>                    
                      <td>&nbsp;<a href="mylist_devices.php?userid=<?php echo $userid;?>&listid=<?php echo $value['listid'];?>"><i class="fa fa-eye" width="20" height="22"></i></a>
                      </td>
                    </tr>
                  <?php  
                  } 
                ?>   
                </tbody>
              </table><!-- End: Start Switch list table -->
            </div> <!-- END : class : body-panel -->
          </div> <!--  class : col-md-6 -->
        <?php 
        if (isset( $_SESSION['switchlistid'] )) {
          $switchlist = usrfavritecondev_display($userid,$_SESSION['switchlistid']);
          ?>
          <div class="col-md-6 panel-warning">
            <div class="panel-heading" id="mylist_delete" style="background-color:#F6F6F6";>
              <b>View Device List :</b> <?php echo $switchlist['mylistname'] ?>
                <!-- Deleted selected list by drag and drop area -->
                <span type="button" class="box box-danger border pull-right"><i class="fa fa-trash"></i>&nbsp;Delete
                </span>
            </div>
            <div class ="panel-body" style="border: 1px solid #FAEBCC">
              <!-- Start : View devices list table -->
              <table id="deviceslist" class="droppable myswlist table table-border" <?php echo ($_SESSION['switchlistid']!='') ? 'data-mylistid="'.$_SESSION['switchlistid'] .'"':'' ?>  >
                <thead><tr><td ><b> Device Id</b> </td><td><b>Device Name</b></td></tr></thead>
                <tbody id="mydevicestbl">
                <?php                              
                  foreach ($switchlist['result'] as $key => $listitem) {
                    ?>
                    <tr class='<?php echo "del_" . $listitem['nodeid']; echo " swtlistid_".$_SESSION['switchlistid']; ?>'>
                      <td align='left'>
                        <i data-listid="<?php echo $_SESSION['switchlistid']; ?>" data-deviceid="<?php echo  $listitem['nodeid'] ?>" data-devicename="<?php echo $listitem['deviceName'] ?>" class='fa fa-arrows draggable'></i>&nbsp;<?php echo $listitem['nodeid'] ?>
                      </td>
                      <td align='left'><?php echo $listitem['deviceName'] ?></td>
                    </tr>
                    <?php
                  }
                ?>
                </tbody>
              </table> <!-- ENd : View devices list table -->
            </div>
          </div>
          <!-- Hidden field for getting selected switch list id -->
          <input type="hidden" name="hidd_mylistid" id="hidd_mylistid" value="<?php echo  $_SESSION['switchlistid']; ?>">
          <?php
          }
          ?>
          </div>
        </div>
    </div>
    <!-- START : Right side panel  -->
    <div id="rhsPanel" class="col-sm-6 col-md-6" >
      <div class="row"> 
            <!-- START : Map section -->
            <div id="map_section" class="sec_with_map" style='<?php echo ($show_map_flag) ? "display: block" : "display: none" ?>; border:1px solid lightgray;'> 
              <!-- US Map Image -->
              <img src="resources/img/map_new.png" id="map_image" usemap="#United States of America"  border=0 height="50%" border=0>
              <!-- Map market area co-ordinats -->
              <map name="United States of America"> 
                <!-- Pacific Northwest -->
                <area name="Pacific Northwest" shape="poly" coords="63,31,64,17,68,17,92,24,110,29,121,31,119,42,121,50,120,52,122,56,127,62,129,66,131,68,127,76,126,82,126,86,114,83,111,85,110,85,107,81,104,81,102,83,101,85,97,87,97,92,99,94,97,102,95,110,93,116,93,120,92,123,22,104,21,100,21,93,25,87,31,76,32,73,34,64,41,51,45,49,42,45,43,43,43,40,44,38,43,32,43,25,42,23,43,20,44,19,48,22,53,25,59,26,61,28,63,30" href="#" onclick class="map_region" data-market="PacificNorthwest"  alt="Pacific Northwest" title="Pacific Northwest" OnMouseOver="window.status='Pacific Northwest'; return true" OnMouseOut="window.status=''; return true">

                <!-- Northern California/Nevada -->
                <area name="Northern California/Nevada" shape="poly" coords="21,104,120,130,107,200,91,198,94,181,101,183,102,173,96,166,84,163,74,162,65,160,62,160,64,163,62,166,59,167,97,222,97,225,100,230,99,233,99,235,96,237,94,242,92,246,92,250,93,253,89,254,88,252,62,248,62,241,53,229,50,226,46,226,41,218,32,216,29,214,32,206,28,200,24,191,23,185,25,179,21,175,21,164,18,160,17,155,14,148,14,143,16,138,16,133,13,128,13,123,16,119,20,112" href="#" class="map_region" data-market="NorthernCalifornia/Nevada"  alt="Northern California/Nevada" title="Northern California/Nevada" OnMouseOver="window.status='Northern California/Nevada'; return true" OnMouseOut="window.status=''; return true">
                
                <!-- Pacific Northwest/Alaska -->
                <area name="Pacific Northwest/Alaska" shape="poly" coords="102,348,104,293,91,293,81,290,74,283,64,287,49,292,51,299,55,309,47,305,40,306,43,313,51,316,53,322,45,324,37,328,35,338,40,342,42,345,42,350,50,350,53,353,46,362,32,368,16,371,44,367,61,359,74,353,84,348,91,351,104,354,112,359,117,366,132,380,138,372,131,366,120,354,114,353,108,354,102,349" href="#" class="map_region" data-market="PacificNorthwest/Alaska"  alt="Pacific Northwest/Alaska" title="Pacific Northwest/Alaska" Onclick="test();"  OnMouseOver="window.status='Pacific Northwest/Alaska'; return true" OnMouseOut="window.status=''; return true">
                
                <!-- Pacific Northwest Hawaii -->
                <area name="Pacific Northwest Hawaii" shape="poly" coords="155,333,161,329,203,349,221,369,221,374,213,376,207,377,206,361,199,354,183,347,170,340,160,337,149,336,152,333,155,332,155,332" href="#" class="map_region" data-market="PacificNorthwest/Hawaii"  alt="Pacific Northwest Hawaii" title="Pacific Northwest Hawaii" OnMouseOver="window.status='Pacific Northwest Hawaii'; return true" OnMouseOut="window.status=''; return true">
                
                <!-- South West  -->
                <area name="South West" shape="poly" coords="187,287,187,276,200,279,216,281,223,282,226,224,227,215,162,207,164,188,141,185,129,183,129,180,112,178,108,202,90,197,93,180,100,182,102,172,94,166,83,163,73,162,64,160,60,162,58,167,97,221,100,225,100,231,98,236,96,240,94,244,92,249,92,253,90,255,89,256,127,280,134,281,154,283,161,284,163,279,168,279,182,281,187,286" href="#" class="map_region" data-market="SouthWest"  alt="South West" title="South West" OnMouseOver="window.status='South West'; return true" OnMouseOut="window.status=''; return true">
                
                <!-- Central Texas  -->
                <area name="Central Texas" shape="poly" coords="227,215,224,284,188,278,188,289,195,296,201,303,203,306,203,312,207,316,217,323,219,322,224,316,231,312,239,313,243,317,250,323,251,330,257,339,262,344,264,352,268,360,277,365,288,367,288,366,287,357,288,349,288,343,289,341,292,341,296,338,302,333,302,326,297,321,292,318,289,315,294,313,298,310,294,308,292,303,295,302,294,297,308,292,314,292,318,294,318,288,323,288,325,291,332,291,333,293,338,292,344,289,340,287,341,282,345,282,350,283,349,286,352,287,352,292,354,288,358,287,361,282,361,279,361,277,358,272,326,273,325,264,319,263,315,260,305,259,302,260,295,260,290,261,284,259,278,256,273,256,269,255,266,251,261,251,258,251,258,246,259,228,260,223,253,222,236,222,228,219" href="#" class="map_region" data-market="CentralTexas"  alt="Central Texas" title="Central Texas" OnMouseOver="window.status='Central Texas'; return true" OnMouseOut="window.status=''; return true">
                
                <!-- Houston/Gulf Coast  -->  
                <area name="Houston/Gulf Coast" shape="poly" coords="305,334,302,328,296,322,292,317,295,314,295,308,293,304,295,296,304,294,310,294,313,293,317,294,318,288,323,289,328,291,331,292,338,289,342,286,340,284,345,281,348,283,349,288,349,290,355,289,360,285,362,282,362,276,359,272,359,268,360,263,360,261,364,261,364,267,368,270,375,273,381,272,389,274,393,274,395,282,397,282,399,277,402,277,405,281,413,281,412,286,416,286,417,292,416,294,419,294,419,299,420,302,414,302,409,303,405,308,404,310,400,310,397,308,394,304,389,303,385,305,382,308,381,310,380,313,382,312,384,311,383,315,375,312,379,316,388,321,386,323,374,325,366,324,354,314,350,320,333,316,322,324" href="#" class="map_region" data-market="Houston/GulfCoast"  alt="Houston/Gulf Coast" title="Houston/Gulf Coast" OnMouseOver="window.status='Houston/Gulf Coast'; return true" OnMouseOut="window.status=''; return true">
                
                <!-- South Central  -->  
                <area name="South Central" shape="poly" coords="226,213,227,218,235,221,253,221,259,222,261,228,260,247,267,253,279,256,286,258,294,258,305,258,312,258,319,261,327,264,328,271,355,269,359,265,361,259,364,261,365,266,371,270,377,270,385,271,389,273,393,271,393,237,394,237,392,219,379,221,376,229,366,229,370,223,369,221,359,222,345,223,329,224,321,225,319,223,319,217,280,217,260,216,245,214,232,213" href="#" class="map_region" data-market="SouthCentral"  alt="South Central" title="South Central" OnMouseOver="window.status='South Central'; return true" OnMouseOut="window.status=''; return true">
                
                <!-- Florida  -->  
                <area name="Florida" shape="poly" coords="435,291,417,292,418,298,421,302,431,307,438,309,442,309,448,302,450,303,458,309,462,314,467,323,468,328,473,334,470,338,474,343,478,348,481,349,484,354,486,357,490,357,493,363,499,363,502,361,503,353,504,342,502,337,496,329,493,321,492,317,486,308,481,301,478,292,477,289,471,290,468,294,460,294,451,295,441,295,436,294,433,290,433,290" href="#" class="map_region" data-market="Florida"  alt="Florida" title="Florida" OnMouseOver="window.status='Florida'; return true" OnMouseOut="window.status=''; return true">
                
                <!-- Georgia/Alabama  -->  
                <area name="Georgia/Alabama" shape="poly" coords="422,237,396,239,394,241,393,274,396,277,401,278,408,281,411,281,414,284,417,289,418,290,432,291,435,291,438,293,445,294,455,294,465,293,469,291,471,290,476,288,478,282,480,272,481,270,474,261,473,259,469,255,476,249,469,242,462,251,457,247,453,241,452,240,450,241,448,234,443,236,430,234,429,243,423,243,422,237" href="#" class="map_region" data-market="Georgia/Alabama"  alt="Georgia/Alabama" title="Georgia/Alabama" OnMouseOver="window.status='Georgia/Alabama'; return true" OnMouseOut="window.status=''; return true">
                
                <!-- Carolina/Tennessee  -->  
                <area name="Carolina/Tennessee" shape="poly" coords="464,210,461,204,460,200,456,197,446,213,398,218,397,211,395,211,395,220,394,224,394,233,395,238,422,236,424,240,429,238,429,232,442,235,447,232,451,238,457,245,462,248,469,242,475,248,469,255,474,260,476,263,483,269,485,266,488,262,490,262,498,251,498,248,504,241,509,239,512,232,519,226,526,226,522,221,522,215,528,214,531,208,527,206,524,204,517,205,517,201,464,210" href="#" class="map_region" data-market="Carolina/Tennessee"  alt="Carolina/Tennessee" title="Carolina/Tennessee" OnMouseOver="window.status='Carolina/Tennessee'; return true" OnMouseOut="window.status=''; return true">
                
                <!-- New York Metro  -->  
                <area name="New York Metro" shape="poly" coords="550,131,547,128,536,135,534,131,533,125,529,126,527,131,520,129,517,133,523,137,524,140,522,143,526,144,531,145,534,147,534,141,531,141,531,139,534,138,538,138,543,135,547,133,550,131" href="#" class="map_region" data-market="NewYorkMetro"  alt="New York Metro" title="New York Metro">
                
                <!-- New England  -->  
                <area name="New England" shape="poly" coords="529,91,529,93,530,99,532,100,533,112,533,118,535,127,536,131,546,124,550,124,565,116,558,109,557,96,558,86,569,79,568,74,572,75,576,70,581,70,585,67,585,62,579,60,577,56,574,56,570,39,566,36,562,36,559,39,556,36,553,41,552,56,548,67,544,74,532,78,525,80" href="#" class="map_region" data-market="NewEngland"  alt="NewEngland" title="NewEngland" OnMouseOver="window.status='NewEngland'; return true" OnMouseOut="window.status=''; return true">
                
                <!-- New York  -->  
                <area name="New York" shape="poly" coords="524,168,524,163,519,159,520,155,529,161,533,153,533,148,527,145,523,143,522,138,524,134,523,130,520,133,517,131,518,127,519,124,524,127,528,124,534,123,532,108,530,94,524,81,509,82,500,95,502,103,497,109,488,111,476,113,478,118,476,122,471,131,472,133,484,129,485,136,486,141,490,142,492,146,492,150,492,152,487,154,487,159,491,161,495,159,502,156,508,153" href="#" class="map_region" data-market="NewYork"  alt="New York" title="New York" OnMouseOver="window.status='New York'; return true" OnMouseOut="window.status=''; return true">
                
                <!-- Washington/Baltimore/Virginia  -->  
                <area name="Washington/Baltimore/Virginia" shape="poly" coords="501,160,489,161,494,162,494,166,490,165,491,169,484,178,480,177,478,185,471,187,470,183,467,186,468,190,462,189,461,189,461,192,464,196,464,201,460,203,464,210,516,201,516,205,524,203,527,206,532,207,522,195,518,195,518,193,519,192,517,182,513,180,508,178,514,176,512,172,512,162,515,159,516,168,516,174,521,178,523,180,522,185,523,189,526,188,529,170,523,169,518,162,514,155" href="#" class="map_region" data-market="Washington/Baltimore/Virginia"  alt="Washington/Baltimore/Virginia" title="Washington/Baltimore/Virginia" OnMouseOver="window.status='Washington/Baltimore/Virginia'; return true" OnMouseOut="window.status=''; return true">
                
                <!-- Michigan/Indiana/KY  -->  
                <area name="Michigan/Indiana/KY" shape="poly" coords="402,142,421,143,426,144,433,140,438,136,437,137,436,131,441,125,441,119,438,113,437,109,432,109,430,114,427,115,426,115,424,112,428,109,429,103,430,97,428,97,428,93,425,91,421,91,420,89,416,88,412,89,411,91,412,93,410,94,410,100,407,101,407,98,404,97,404,101,403,106,401,108,400,114,401,122,405,127,405,132,402,141,404,137,402,142,410,143,417,145,417,140" href="#" class="map_region" data-market="Michigan/Indiana/KY"  alt="Michigan/Indiana/KY" title="Michigan/Indiana/KY" OnMouseOver="window.status='Michigan/Indiana/KY'; return true" OnMouseOut="window.status=''; return true">
                
                <!-- OPW  -->  
                <area name="OPW" shape="poly" coords="436,146,442,144,449,144,454,140,460,137,463,135,468,130,472,132,478,132,482,130,483,135,485,140,488,142,491,147,489,152,485,154,485,159,488,162,489,166,489,172,483,176,478,183,475,186,471,186,467,189,463,188,461,194,464,197,464,201,457,197,454,193,450,194,444,191,444,182,434,181,432,181,428,183,424,180,420,181,421,177,425,176,421,146,435,142" href="#" class="map_region" data-market="opw"  alt="opw" title="opw" OnMouseOver="window.status='opw'; return true" OnMouseOut="window.status=''; return true">
                
                <!-- Michigan/Indiana/KY  -->  
                <area name="Michigan/Indiana/KY" shape="poly" coords="392,153,396,152,399,155,404,151,403,159,407,156,411,155,411,152,416,152,416,148,420,147,422,175,420,176,423,181,425,184,431,184,437,185,440,184,444,188,447,193,451,195,453,196,446,209,398,216,398,210,393,209,393,216,381,218,385,211,391,205,396,191,391,189,391,186,397,187,395,180,395,167,393,154,393,154" href="#" class="map_region" data-market="Michigan/Indiana/KY"  alt="Michigan/Indiana/KY" title="Michigan/Indiana/KY" OnMouseOver="window.status='Michigan/Indiana/KY'; return true" OnMouseOut="window.status=''; return true">
                
                <!-- Illinois/Wisconsin  -->  
                <area name="Illinois/Wisconsin" shape="poly" coords="392,97,394,100,390,106,389,115,388,125,388,133,389,141,392,148,403,142,419,143,420,147,414,151,406,154,394,151,389,153,392,167,393,181,392,190,380,191,371,187,370,180,364,180,364,174,366,172,361,168,355,168,354,165,349,163,351,158,354,157,354,143,361,142,362,136,359,134,356,133,356,124,352,118,351,115,350,105,350,98,339,98,338,92,342,88,350,89,348,80,352,77,360,82,380,68,378,75,384,75,390,82,400,76,404,78,409,75,411,79,417,78,420,81,426,81,426,84,420,84,412,84,408,82,402,85,396,91,391,90,387,99,384,106" href="#" class="map_region" data-market="Illinois/Wisconsin"  alt="Illinois/Wisconsin" title="Illinois/Wisconsin" OnMouseOver="window.status='Illinois/Wisconsin'; return true" OnMouseOut="window.status=''; return true">
                
                <!-- Kansas/Missouri  -->  
                <area name="Kansas/Missouri" shape="poly" coords="242,171,311,174,308,166,318,164,350,164,360,169,364,176,369,183,377,190,391,189,392,192,390,200,387,208,383,215,379,217,376,224,375,227,368,226,368,219,362,221,320,223,318,216,279,216,239,214,243,171" href="#" class="map_region" data-market="Kansas/Missouri"  alt="Kansas/Missouri" title="Kansas/Missouri" OnMouseOver="window.status='Kansas/Missouri'; return true" OnMouseOut="window.status=''; return true">
                
                <!-- Mountain  -->  
                <area name="Mountain" shape="poly" coords="243,158,239,214,227,211,226,213,163,206,165,190,128,181,129,178,112,177,122,128,95,121,100,91,97,90,98,85,101,85,104,79,124,85,131,66,125,56,120,47,120,38,123,31,149,37,173,40,195,44,214,46,231,48,222,157,222,155" href="#" class="map_region" data-market="Mountain"  alt="Mountain" title="Mountain" OnMouseOver="window.status='Mountain'; return true" OnMouseOut="window.status=''; return true">
                
                <!-- Pacific  -->  
                <area name="Great Plains" shape="poly" coords="270,50,230,47,224,153,244,155,244,168,250,171,307,172,307,164,316,162,346,162,353,152,353,142,359,140,360,136,354,132,354,123,351,116,349,99,339,98,336,92,340,87,348,87,347,79,344,81,343,77,353,68,362,63,372,64,376,60,374,57,367,61,353,60,352,59,347,62,331,53,327,56,317,53,314,45,313,50" href="#" class="map_region" data-market="GreatPlains"  alt="GreatPlains" title="GreatPlains" OnMouseOver="window.status='GreatPlains'; return true" OnMouseOut="window.status=''; return true">
                <area shape="default" href="#" target="">
              </map> 
            </div><!-- END : Map section -->    
      <div class="panel-info">
        <div class="panel-heading router_search_box">
          <form id="city_form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">  
            <?php
            $str_marketname =  $marketname ;        
            ?> 
            <input placeholder="Search" name="search_term" style="color: blue;" value="<?php echo $search_term; ?>" id="srch-term" type="text">
            <input id="hidd_markets_name" name="markets" type="hidden" value="<?php echo $marketname ?>">
            <button type="submit" name="submit" value="search"><i class="glyphicon glyphicon-search" style="color:#D52B1E"></i></button> 
            <?php
            if ($search_term) {
              ?>
              <button type="submit" name="submit" style="color:orange;"  value="clear" title="Clear Search" hxref="switchtech_devicelist.php?clear=search"><i class="fa fa-close"></i></button>
              <?php
            }
            $switch_device_name = '';

            // Function call to get Switch name assigned for the user
            $switch_list = get_switchlist_all_market($_SESSION['userid']); 
            if (isset($switch_list['result'])){                
              $switch_device_name = $switch_list['result'][0]['switch_name'];
            }
          
            if (!isset($str_marketname)) { 
            ?>
              <!-- Displays user assigned switch name -->
              <span style="padding-left: 20px; "><label>Switch Name : &nbsp; </label><?php echo $switch_device_name ?></span>
            <?php 
            } 
            elseif (isset($str_marketname)) {
            ?>
              <!-- Displays user selected market name -->
              <span style="padding-left: 20px; "><label>Market Name :&nbsp;</label><?php echo $str_marketname; ?></span>
            <?php 
            }
          ?>
          <!-- Show/Hide map link and icon section -->
          <span id="map_show_link" class="pull-right sec_without_map" style='cursor: pointer; <?php echo ($show_map_flag) ? "display: none" : "display: block" ?>' onclick="showMap()"> Show Map&nbsp;  <img width="25px" src="resources/img/usmap-icon.png" >&nbsp;</span>
          <span id="map_hide_link" class="pull-right sec_with_map" style='cursor: pointer; <?php echo ($show_map_flag) ? "display: block" : "display: none" ?>' onclick="hideMap()"> Hide Map&nbsp;  <img width="25px" src="resources/img/usmap-icon.png" >&nbsp;</span>
          </form>      
        </div>
        <div  id="container_mymarketswitches" class="panel-body"> 
          <!-- $show_map_flag is used to set default value invisiblie -->
          <div id="sw_result_without_map" class="sec_without_map" style='<?php echo ($show_map_flag) ? "display: none" : "display: block" ?>; '>
          <?php

            // Highest possible listing item when map is invisible
            $high_limit = HIGH_LIMIT;

            // Highest possible listing item when map is Visible
            $low_limit = LOW_LIMIT;

            if(isset($switch_device_name) && $switch_device_name != '' ) {
              $page_limit = $high_limit;
              if (!isset($str_marketname)) {  // IF No Market is selected

                // Get  Routersfor users assigned switch
                $device_details = getSWroutersDetails_all($switch_device_name, $search_term, $_SESSION['userid'], $page_limit);
              }
              else { //  If market is clicke on the map 

                // Get routers for the selected market
                $device_details = getmarketroutersDetails_all(strtolower($str_marketname), $search_term, $page_limit );
              }
              // Include Routers list HTML section
              include "sw_results_for_map.php";
            }
          ?>                  
          </div> <!-- END : Switch results without map -->

          <!-- START : Switch results with map -->
          <div id="sw_result_with_map" class="sec_with_map" style='<?php echo ($show_map_flag) ? "display: block" : "display: none" ?>; '>
          <?php
          $device_details= '';
            if(isset($switch_device_name) && $switch_device_name != '' ) {
              $page_limit = $low_limit;
              if (!isset($str_marketname)) {
                $device_details = getSWroutersDetails_all($switch_device_name, $search_term, $_SESSION['userid'],$page_limit);
              }
              else {
                $device_details = getmarketroutersDetails_all(strtolower($str_marketname), $search_term , $page_limit);
              }
              include "sw_results_for_map.php";
            }
          ?>                    
          </div> <!-- END : Switch results with map -->
        </div>
      </div>
    </div> 
  </div> 
  <!-- Start: Modal popup place holder -->
  <div id="mycmdModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Content will be loaded here from "remote.php" file -->
        </div>
    </div>
  </div> <!-- END: Modal popup place holder -->

  <!-- Hidden field for user id value -->
  <input type="hidden" id="hidd_userid" value="<?php echo $_SESSION['userid'] ?>">     
  
  <!-- Include custom js file for switchtech_devicelist page -->  
  <div style="clear:both;"></div>
  </div>
</div>
  <script src="resources/js/mydashboardlist.js?t=<?php echo date('his'); ?>"></script>

 <?php 
    // Footder section include file
    include ('footer.php');
  ?> 
</body>
</html>