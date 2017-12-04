<header class="main-header">
  <div class="nav">
    <div class="pull-left box"><a class="navbar-brand" href="#" >
        <img src="resources/img/ncmlogo.png"  height = "20px"  alt=" Verizon Logo"/>
      </a>
    </div>
    <?php 
    if (isset($_SESSION['welcome_username']) && $_SESSION['welcome_username']!= '') { 
    ?>

    <div class="pull-right box">
   
    <ul class="nav navbar-nav">
    
      <li class="dropdown messages-menu">
        <a >
         <b> Welcome </b><span class="hidden-xs"><?php echo $_SESSION['welcome_username'];?></span;>
        </a>
      </li> 
      <li class="dropdown messages-menu">
        <a href="login.php">                      
          <img src="resources/img/Logout.png"  width="15" alt="Logo"/>
        </a>
      </li>
    </ul>
  </div>
  <?php
  }
  ?>
  </div> 

  <hr style="border-top:5px solid red;"> 
    <ol class="breadcrumb"> 
	<?php 
    if (isset($_SESSION['welcome_username'])) {
    ?>
    <?php if ($_SESSION['userlevel'] === "1"){ ?>
    	<li <?php print activemenu("sheet1_cellsitetech_user_devicelist.php"); ?>><a href="sheet1_cellsitetech_user_devicelist.php">Dashboard</a></li>
    	<li <?php print activemenu("sheet2_cellsitetech_user_devicelist.php"); ?>><a href="sheet2_cellsitetech_user_devicelist.php">Discovery</a></li>
    	<li <?php print activemenu("sheet3_cellsitetech_user_devicelist.php"); ?>><a href="sheet3_cellsitetech_user_devicelist.php">Backup</a></li>
    	<li <?php print activemenu("sheet4_cellsitetech_user_devicelist.php"); ?>><a href="sheet4_cellsitetech_user_devicelist.php">Configuration</a></li>
    	<li <?php print activemenu("sheet5_cellsitetech_user_devicelist.php"); ?>><a href="sheet5_cellsitetech_user_devicelist.php">Scripting</a></li>
    	<li <?php print activemenu("sheet6_cellsitetech_user_devicelist.php"); ?>><a href="sheet6_cellsitetech_user_devicelist.php">Compliances</a></li>
    	<li <?php print activemenu("sheet7_cellsitetech_user_devicelist.php"); ?>><a href="sheet7_cellsitetech_user_devicelist.php">IP Management</a></li>
    	<li <?php print activemenu("sheet8_cellsitetech_user_devicelist.php"); ?>><a href="sheet8_cellsitetech_user_devicelist.php">Help</a></li>
    <?php }elseif($_SESSION['userlevel'] === "2"){  ?>
    	<li <?php print activemenu("sheet1_switchtech_user_list.php"); ?>><a href="sheet1_switchtech_user_list.php">Dashboard</a></li>
    	<li <?php print activemenu("sheet2_switchtech_user_list.php"); ?>><a href="sheet2_switchtech_user_list.php">Discovery</a></li>
    	<li <?php print activemenu("sheet3_switchtech_user_list.php"); ?>><a href="sheet3_switchtech_user_list.php">Backup</a></li>
    	<li <?php print activemenu("sheet4_switchtech_user_list.php"); ?>><a href="sheet4_switchtech_user_list.php">Configuration</a></li>
    	<li <?php print activemenu("sheet5_switchtech_user_list.php"); ?>><a href="sheet5_switchtech_user_list.php">Scripting</a></li>
    	<li <?php print activemenu("sheet6_switchtech_user_list.php"); ?>><a href="sheet6_switchtech_user_list.php">Compliances</a></li>
    	<li <?php print activemenu("sheet7_switchtech_user_list.php"); ?>><a href="sheet7_switchtech_user_list.php">IP Management</a></li>
    	<li <?php print activemenu("sheet8_switchtech_user_list.php"); ?>><a href="sheet8_switchtech_user_list.php">Help</a></li>    
    <?php } ?>
  <?php  } ?> 
    </ol>
</header> 