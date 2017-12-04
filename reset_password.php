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
					<li><img src="resources/img/ncmlogo.png"  height="20px" alt="Verizon Logo"/></li>
					<li><img src="resources/img/ncmlogo.png"  height="20px" alt="Verizon Logo"/></li>
				</ul>	
				</a>
			</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="topFixedNavbar1">
      		
				<ul class="nav navbar-nav navbar-right">
					<li><a class="welcome">Welcome <span><?php echo 'username' ?></span></a></li>
					<li><a href="#"><img src="resources/img/Help.png" height="20px" alt="Help"/></a></li>
					<li><a href="login.php"><img src="resources/img/Logout.png" height="20px" alt="Log Out"/></a></button></li>
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
                                  <div id="passwdresetfrm" >
                                  <form  id ="resetpasswordfrm" name ="resetpasswordfrm" action = "reset.php" method='POST' >
                                    <div>
                                    <label for ="emailid">Email Id address </label><input type = "text" id="emailid" name="emailid" > 
                                    </div>
                                    <div>
                                    <label for ="newpasswd">New password </label><input type = "password" id="newpasswd" name ="newpasswd" > 
                                    </div>
                                    <div>
                                    <label for="cnfrmpasswd">Confirm password </label><input type = "password" id ="cnfrmpasswd" name ="cnfrmpasswd" > <br>
                                    </div>
                                    <div class="button">
                                    <button type="submit" name="resetpasswordbtn" value="Reset Password">Change Password</button>
                                  </div>
                                  <!--
                                    <input type="submit" name="resetpasswordbtn" value="Reset Password">
                                  -->  
                                    <input type="hidden" name="q" value="<?php if (isset($_GET['q']))  echo $_GET['q'] ; ?>" > 
                                  
                                  </form>  
                                  </div>
                                </div>        
                                <!-- /.box-body -->
            </div> 
        </div>
        </div> 
                            
        <!-- 09 Oct 17: Added footer -->
        <?php include "footer.php";?> 
    </body>
</html>