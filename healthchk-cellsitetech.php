<script type ="text/javascript">
$(document).ready(function(){
                $('.anchorcmd').click(function () { 

                $("#mycmdModal").on("hidden.bs.modal", function(){
                    $(".modal-content").html("<div>Loading Please Wait!</div>");
                }); 

                $("#mycmdModal").modal({
                    remote: $(this).attr('href'),
                    refresh: true
                });            
                 $('#mycmdModal').removeData()   
                 return false;                  
              });


            });        

</script>
<?php
include "classes/db2.class.php";
include "classes/paginator.class.php";  
include 'functions.php'; 
?>
    <?php  
                                               //  Python API Request using curl Begins                    
            $userid = $_GET['userid'];
            $deviceid = $_GET['deviceid'];               
            $devicetype='ios';
            $url_send =" http://txaroemsda2z.nss.vzwnet.com:8080/healthcheck/";
            $deviceid = $_GET['deviceid'];              
 	          $url_final = 'http://txaroemsda2z.nss.vzwnet.com:8080/healthcheck/'.$devicetype.'/'.$deviceid;			
            $output = json_decode(sendPostData($url_final),true);   
            $_SESSION['deviceidcs'] = $deviceid;                 
     ?>

                <div class="ownfont box-body launch-modal">
                  <table class="table table-bordered"  cellspacing="0" cellpadding="0" >
                    <tbody>
                                            <tr>                  
                                              <td><b>IOS Version </b></td>
                                              <td> <a id="anchorcmd" class="anchorcmd" href="devdetmdl-cellsite.php?commandname=showversion&deviceid=<?php echo $_SESSION['deviceidcs'];?>"><img src="resources/img/RDimage.png"  alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['iosversion']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['iosversion']['message'].'</span>';echo $display; ?></td>
                                              <td><b>CPU Utilization</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-cellsite.php?commandname=cpuutilization&deviceid=<?php echo $_SESSION['deviceidcs'];?>"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"></img></a><?php $color = ($output['cpuutilization']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['cpuutilization']['message'].'</span>';
echo $display; ?>  </td>
</td>
                                              <td><b>Free Memory</b> </td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-cellsite.php?commandname=freememory&deviceid=<?php echo $_SESSION['deviceidcs'];?>"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['freememory']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['freememory']['message'].'</span>';
echo $display; ?></td>
                                            </tr>
                                            <tr>                  
                                              <td><b>Buffers</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-cellsite.php?commandname=buffers&deviceid=<?php echo $_SESSION['deviceidcs'];?>"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['buffers']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['buffers']['message'].'</span>';
echo $display; ?></td>
                                              <td><b>Boot statement</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-cellsite.php?commandname=bootstatement&deviceid=<?php echo $_SESSION['deviceidcs'];?>"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['bootstatement']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['bootstatement']['message'].'</span>';
echo $display; ?> </td>
                                              <td><b>Platform </b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-cellsite.php?commandname=platform&deviceid=<?php echo $_SESSION['deviceidcs'];?>"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['platform']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['platform']['message'].'</span>';
echo $display; ?></td>
                                            </tr>
                                            
                                            <tr>                  
                                              <td><b>Environmental</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-cellsite.php?commandname=environment&deviceid=<?php echo $_SESSION['deviceidcs'];?>"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['environmental']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['environmental']['message'].'</span>';
echo $display; ?></td>
                                              <td><b>Config Register</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-cellsite.php?commandname=configregister&deviceid=<?php echo $_SESSION['deviceidcs'];?>"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['configregister']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['configregister']['message'].'</span>';
echo $display; ?></td>
                                              <td><b>Interface Counters</b> </td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-cellsite.php?commandname=interfacecounters&deviceid=<?php echo $_SESSION['deviceidcs'];?>"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['interfacecounters']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['interfacecounters']['count'].'</span>';
echo $display; ?></td>
                                            </tr>
                                            <tr>                  
                                              <td><b>2000 Byte Ping</b></td>                                              
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-cellsite.php?commandname=twothsndbyteping&deviceid=<?php echo $_SESSION['deviceidcs'];?>"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['twothsndbyteping']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['twothsndbyteping']['message'].'</span>';
echo $display; ?> 
</td>

                                              <td><b>BFD Sessions</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-cellsite.php?commandname=bfdsession&deviceid=<?php echo $_SESSION['deviceidcs'];?>"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['bfdsession']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['bfdsession']['message'].'</span>';
echo $display; ?></td>
											  <td><b>Log Entries</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-cellsite.php?commandname=logentries&deviceid=<?php echo $_SESSION['deviceidcs'];?>"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php if (isset($output['logentries']['buffer_logging']['R'])){
													$color = ($output['logentries']['buffer_logging']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>"." Buffer Logging : ".$output['logentries']['buffer_logging']['value'].'</span>';
											  echo $display;}?> 
											  <?php if (isset($output['logentries']['trap_logging']['R'])) {
												  $color = ($output['logentries']['trap_logging']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>"."<br> Trap Logging : ".$output['logentries']['trap_logging']['value'].'</span>';
											  echo $display;}; ?></td>
                                            </tr>
                                            <tr>                  
                                              <td><b>5000 Byte Ping</b></td>                                              
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-cellsite.php?commandname=fivethsndbyteping&deviceid=<?php echo $_SESSION['deviceidcs'];?>"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['fivethsndbyteping']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['fivethsndbyteping']['message'].'</span>';
echo $display; ?> 
</td>
</td>
                                              <td><b>Interface State</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-cellsite.php?commandname=interfacestates&deviceid=<?php echo $_SESSION['deviceidcs'];?>"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['interfacestates']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['interfacestates']['message'].'</span>';
echo $display; ?> 
</td>
                                              <td><b>Xconnect</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-cellsite.php?commandname=xconnect&deviceid=<?php echo $_SESSION['deviceidcs'];?>"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['xconnect']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['xconnect']['count'].'</span>';
echo $display; ?></td>
                                            </tr>
                                            <tr>                  
                                              <td><b>MPLS Interfaces</b></td>                                              
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-cellsite.php?commandname=mplsinterfaces&deviceid=<?php echo $_SESSION['deviceidcs'];?>"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['mplsinterfaces']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['mplsinterfaces']['message'].'</span>';
echo $display; ?></td>
                                              <td><b>BGPV4Neighbors</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-cellsite.php?commandname=bgpvfourneighbors&deviceid=<?php echo $_SESSION['deviceidcs'];?>"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['bgpvfourneighbors']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['bgpvfourneighbors']['neighbours'].'</span>';
echo $display; ?></td>
                                              <td><b>BGPV4Routes</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-cellsite.php?commandname=bgpvfourroutes&deviceid=<?php echo $_SESSION['deviceidcs'];?>"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a> <?php
$color = ($output['ran']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['ran']['count'].'</span>';
echo $display; ?></td> 
                                            </tr>                  
                                            <tr>   
                                              <td><b>MPLS Neighbors</b></td>                                              
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-cellsite.php?commandname=mplsneighbors&deviceid=<?php echo $_SESSION['deviceidcs'];?>"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['mplsneighbors']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['mplsneighbors']['message'].'</span>';
echo $display; ?></td>
                                              <td><b>BGPV6Neighbors</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-cellsite.php?commandname=bgpvsixneighbors&deviceid=<?php echo $_SESSION['deviceidcs'];?>"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php
$color = ($output['bgpvsixneighbors']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['bgpvsixneighbours']['neighbours'].'</span>';
echo $display; ?></td>
                                              <td><b>BGPV6Routes</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-cellsite.php?commandname=bgpvsixroutes&deviceid=<?php echo $_SESSION['deviceidcs'];?>"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a> <?php
$color = ($output['bgpvsixroutes']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['bgpvsixroutes']['count'].'</span>';
echo $display; ?></td>
                                            </tr>                  
                                            <tr>  
                                            <!--  <td><b>Light Level</b></td>      
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl-cellsite.php?commandname=lightlevel&deviceid=<?php echo $_SESSION['deviceidcs'];?>"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php echo $output['lightlevel']; ?></td>-->
                                              <td>&nbsp;&nbsp;&nbsp;</td>                 
                                              <td>&nbsp;&nbsp;&nbsp;</td>      
                                              <td>&nbsp;&nbsp;&nbsp;</td>                                                 
<!--                                              <td class="run_all_checks" data-deviceid="<?php echo $deviceid ?>"  data-userid="<?php echo $_SESSION['userid'] ?>" style="cursor: pointer;"> <b> Rerun All checks </b></td> -->
                                              <td colspan="2">&nbsp;&nbsp;&nbsp;</td>         
                                            </tr>
                                          </tbody>
                                       </table>
                                    </div>
