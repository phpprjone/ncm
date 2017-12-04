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
                                <form id = "frmFormForgot" name="frmFormForgot" action="changepassword.php" method = "POST">
                                    E-mailaddress: <input type ="text" id ="usremailid" name="usremailid" size = "20" />
                                    <input type ="submit" id ="fgtpasswd"  name ="fgtpasswd" value = "Request Reset" /> 		
                                </form> 
                                </div>        
                                <!-- /.box-body -->
            </div> 
        </div>
        </div> 
                            
        <!-- 09 Oct 17: Added footer -->
        <?php include "footer.php";?> 
    </body>
</html>