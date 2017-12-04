<!DOCTYPE html>
<html lang="en">
     <?php include "header.php"; ?>
	<script type ="text/javascript">
  </script>
     <body class="hold-transition skin-blue sidebar-mini ownfont" style="padding-top: 70px">  
        
		<!-- 09 Oct 17: Changed the entire code for header and added breadcrumb -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#topFixedNavbar1" aria-expanded="false"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></button>
				<a class="navbar-brand" href="index.html">
				<ul class="nav navbar-nav navbar-left">
					<li><img src="resources/img/ncmlogo.png" width="100" height="22" alt="Verizon Logo"/></li>
					<li><img src="resources/img/ncmlogo.png" width="100" height="31" alt="Verizon Logo"/></li>
				</ul>	
				</a>
			</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="topFixedNavbar1">
      		
				<ul class="nav navbar-nav navbar-right">
					<li><a class="welcome">Welcome <span><?php echo 'username' ?></span></a></li>
					<li><a href="#"><img src="resources/img/Help.png" width="22" height="22" alt="Help"/></a></li>
					<li><a href="login.php"><img src="resources/img/Logout.png" width="20" height="20" alt="Log Out"/></a></button></li>
				</ul>
     
				</div>
				<!-- /.navbar-collapse -->
			</div>
			<!-- /.container-fluid -->
		</nav>
	
		<ol class="breadcrumb">
			<li class="active">Home</li>
		</ol>

        <!-- Content Wrapper. Contains page content -->
        <!-- 09 Oct 17: Added class container-fluid, panel-default and panel-body -->
		<div class="container-fluid">
		<div class="panel panel-default">
            <div class="panel-body">
                <!-- Main content -->
				<!-- 09 Oct 17: Added class page-title and cleared up unnecessary code -->
        		<P class="page-title"> Device List <p> 
                                <div class="box-body">          
                                  <?php
                                  include 'functions.php';
                                  include "classes/db2.class.php";
                                   if (isset($_POST))  {
                                     // Gather the post data
                                    $emailid = $_POST["emailid"];
                                    $newpasswd = $_POST["newpasswd"];
                                    $cnfrmpasswd = $_POST["cnfrmpasswd"];
                                    $hash = $_POST["q"];
                                    // Use the same salt from the forgot_password.php file
                                    $salt = "498#2D83B631%3800EBD!801600D*7E3CC13";
                                    // Generate the reset key
                                    //$resetkey = hash('sha512', $salt.$emailid);            
                                    $resetkey = hash('sha512', $salt.$emailid);            
                                    // Verifying the new key matches the old one  
                                    if ($resetkey == $hash ) {    
                                      if ($newpasswd == $cnfrmpasswd) {
                                       // has and secure the password         
                                        //$password = hash('sha512', $salt.$newpasswd);        
                                        $password = md5($newpasswd);
                                       // update the user's password           
                                       $returnval = updateuserpassword($emailid,$password);
                                       if ($returnval) echo "Your password has been successfully reset.";
                                      } else { 
                                          echo "Your password's do not match.";      
                                      }; 
                                    } else 
                                        echo "your password reset key is invalid"; 
                                  }
                                  ?> 
                                </div>        
                                <!-- /.box-body -->
            </div> 
        </div>
        </div> 
                            
        <!-- 09 Oct 17: Added footer -->
        <?php include "footer.php";?> 
    </body>
</html>