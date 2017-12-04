<html>
<style>
hr{color:red;
   border-top:1px solid red;
  }
</style>
<body onblur=this.focus();>
 <h1 style="font-size:12px;font-family:arial;text-align:center;">Device Console Output - Command Issued - <?php echo $_GET['command'];?></h1>
<hr>
<br><br>

<?php 
              $command  = $_GET['command'];

				switch($command) {
				    
				    case 'showprocessescpu':
					$url='http://localhost:8080/healthcheck/1/show-process-cpu';

					break;
				    case 'freememory':
					$url='http://localhost:8080/healthcheck/1/show-memory-statistics';
					break;
				    case 'buffers':
					$url='http://localhost:8080/healthcheck/1/sho-buffers';
					break;             
				    case 'showversion':
					$url='http://localhost:8080/healthcheck/1/show-version';
					break;
				    case 'showversioniconfig':
					$url='http://localhost:8080/healthcheck/1/show-version-i-config';
					break;
				    case 'environment':
					$url='http://localhost:8080/healthcheck/1/show-environment';
					break;
				    case 'platform':
					$url='http://localhost:8080/healthcheck/1/show-platform';
					break;
				    case 'bfdsession':
					$url='http://localhost:8080/healthcheck/1/show-bfd-neighbor';
					break;
				    case 'interfacestates':
					$url='http://localhost:8080/healthcheck/1/show-ip-interface-brief';
					break;
				    case 'showinterfaces':
					$url='http://localhost:8080/healthcheck/1/show-interfaces';
					break;
 				    case 'mplsinterfaces':
					$url='http://localhost:8080/healthcheck/1/show-mpls-interfaces';
					break;
 				    case 'mplsneighbors':
					$url='http://localhost:8080/healthcheck/1/show-mpls-ldp-neighbor';
					break;
 				    case 'show-ip-bgp-vpnv6-unicast-vrf-LTE':
					$url='http://localhost:8080/healthcheck/1/show-ip-bgp-vpnv6-unicast-vrf-LTE';
					break;
 				    case 'show-running-config-|-i-boot':
					$url='http://localhost:8080/healthcheck/1/show-running-config-boot';
					break; 
					
				    case 'cpuutilization':
					$url='http://localhost:8080/healthcheck/1/show-process-cpu';
					break; 
                                    case 'fivethsndbyteping':
					$url='http://localhost:8080/healthcheck/1/ping-192.168.56.100-size-5000';
					break;
                                    case 'twothsndbyteping':
					$url='http://localhost:8080/healthcheck/1/ping-192.168.56.100-size-2000';
					break;

				    default: 
					break;
				}  

                  /*    Ends  */   
 
	      if (isset($url))
		     //$data = file_get_contents('http://localhost:8080/healthcheck/1/show-version'); 
		     $data = file_get_contents($url); 
	      else 
		   $data = "CLI command needs is in progress.";
?>

	   <span style="font-family:courier;font-size:12px;font-weight:500;"> <?php  print_r($data);?></span> 
</body>
</html>
