<script type ="text/javascript">
$(document).ready(function(){
                $('.anchorcmd').click(function () { 
                $("#mycmdModal").modal({
                    remote: $(this).attr('href'),
                    refresh: true
                });            
                 $('#mycmdModal').removeData()   
                 return false;                  
              })
            });        

</script>

<?php

include "classes/db2.class.php";
include "classes/paginator.class.php";  
include 'functions.php';
//$userid = $_GET['userid'];
//$deviceid = $_GET['deviceid'];
//$arr_res = getDetailViewData($userid, $deviceid );  
//$output = $arr_res['result'][0];
// print_r($output); 
?>
    <?php  
                                               //  Python API Request using curl Begins                    
						$userid = $_GET['userid'];
						$deviceid = $_GET['deviceid'];						   
                        $data = 
                                array(
                                "username" => $_SESSION['username'],
                                "password" => "python",
                                "ip_addr" => $device['deviceIpAddr'],
                                "command" => "showversion"
                                
                                ); 
                       // $url_send ="http://localhost/ncm/sshpost.php";	
			  $url_send ="http://localhost:8080/healthcheck/1";	
						$deviceid = $_GET['deviceid'];							
						$url_final = $url_send.'?deviceid='.$deviceid;						
                        $output = json_decode(sendPostData($url_final),true);
                        
                        ?>

 								<div class="ownfont box-body launch-modal">
									<table class="table table-bordered"  cellspacing="0" cellpadding="0" >
										<tbody>
                                            <tr>                  
                                              <td><b>IOS Version</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl.php?commandname=showversion"><img src="resources/img/RDimage.png"  alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['iosversion']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['iosversion']['message'].'</span>';echo $display; ?></td>
                                              <td><b>CPU Utilization</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl.php?commandname=cpuutilization"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"></img></a><?php echo $output['cpuutilization']; ?></td>
                                              <td><b>Free Memory</b> </td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl.php?commandname=freememory"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['freememory']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['freememory']['message'].'</span>';
echo $display; ?></td>
                                            </tr>
                                            <tr>                  
                                              <td><b>Buffers</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl.php?commandname=buffers"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['buffers']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['buffers']['message'].'</span>';
echo $display; ?></td>
                                              <td><b>Boot statement</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl.php?commandname=bootstatement"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['bootstatement']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['bootstatement']['message'].'</span>';
echo $display; ?> </td>
                                              <td><b>Platform </b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl.php?commandname=platform"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['platform']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['platform']['message'].'</span>';
echo $display; ?></td>
                                            </tr>
                                            
                                            <tr>                  
                                              <td><b>Environmental</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl.php?commandname=environment"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['environmental']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['environmental']['message'].'</span>';
echo $display; ?></td>
                                              <td><b>Config Register</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl.php?commandname=configregister"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['configregister']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['configregister']['message'].'</span>';
echo $display; ?></td>
                                              <td><b>Interface Counters</b> </td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl.php?commandname=interfacecounters"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['interfacecounters']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['interfacecounters']['count'].'</span>';
echo $display; ?></td>
                                            </tr>
                                            <tr>                  
                                              <td><b>2000 Byte Ping</b></td>                                              
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl.php?commandname=twothsndbyteping"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['twothsndbyteping']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['twothsndbyteping']['message'].'</span>';
echo $display; ?></td>
                                              <td><b>BFD Sessions</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl.php?commandname=bfdsession"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['bfdsession']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['bfdsession']['message'].'</span>';
echo $display; ?></td>
                                              <td><b>Log Entries</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl.php?commandname=logentries"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php echo 'Buffer Logging :'.$output['logentries']['buffer_logging']." Trap logging :".$output['logentries']['trap_logging']; ?></td>
                                            </tr>
                                            <tr>                  
                                              <td><b>5000 Byte Ping</b></td>                                              
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl.php?commandname=fivethsndbyteping"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['fivethsndbyteping']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['fivethsndbyteping']['message'].'</span>';
echo $display; ?></td>
                                              <td><b>Interface State</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl.php?commandname=interfacestates"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['interfacestates']['R'] == 1) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['interfacestates']['message'].'</span>';
echo $display; ?> 
</td>
                                              <td><b>Xconnect</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl.php?commandname=xconnect"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['xconnect']['R'] == 1) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['xconnect']['count'].'</span>';
echo $display; ?></td>
                                            </tr>
                                            <tr>                  
                                              <td><b>MPLS Interfaces</b></td>                                              
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl.php?commandname=mplsinterfaces"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['mplsinterfaces']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['mplsinterfaces']['message'].'</span>';
echo $display; ?></td>
                                              <td><b>BGPV4Neighbors</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl.php?commandname=bgpvfourneighbors"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['bgpvfourneighbors']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['bgpvfourneighbors']['neighbours'].'</span>';
echo $display; ?></td>
                                              <td><b>BGPV4Routes</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl.php?commandname=bgpvfourroutes"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a> <?php
$color = ($output['ran']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['ran']['count'].'</span>';
echo $display; ?></td> 
                                            </tr>                  
                                            <tr>   
                                              <td><b>MPLS Neighbors</b></td>                                              
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl.php?commandname=mplsneighbors"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php $color = ($output['mplsneighbors']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['mplsneighbors']['message'].'</span>';
echo $display; ?></td>
                                              <td><b>BGPV6Neighbors</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl.php?commandname=bgpvsixneighbors"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php
$color = ($output['bgpvsixneighbors']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['bgpvsixneighbors']['neighbours'].'</span>';
echo $display; ?></td>
                                              <td><b>BGPV6Routes</b></td>
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl.php?commandname=bgpvsixroutes"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a> <?php
$color = ($output['bgpvsixroutes']['R'] == 0) ? 'green':'red';  
$display ="<span style='color:".$color."'>".$output['bgpvsixroutes']['count'].'</span>';
echo $display; ?></td>
                                            </tr>                  
                                            <tr>  
                                            <!--  <td><b>Light Level</b></td>      
                                              <td><a id="anchorcmd" class="anchorcmd" href="devdetmdl.php?commandname=lightlevel"><img src="resources/img/RDimage.png" alt="Smiley face" height="22" width="22"> </img></a><?php echo $output['lightlevel']; ?></td>-->
                                              <td>&nbsp;&nbsp;&nbsp;</td>      						
                                              <td>&nbsp;&nbsp;&nbsp;</td>      
                                              <td>&nbsp;&nbsp;&nbsp;</td>                                                 
                                              <td> <b> Rerun All checks </b></td> 
                                              <td>&nbsp;&nbsp;&nbsp;</td>         
                                            </tr>
                                          </tbody>
                                       </table>
                                    </div>
