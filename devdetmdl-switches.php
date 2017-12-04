<?php 
        $command  = $_GET['commandname'];
        $deviceid = $_GET['deviceid'];
                                
				switch($command) { 
          
            case 'freememory':
//          $url='http://63.49.0.192:8080/healthcheck/ios/2///          
            $url='http://63.49.0.192:8080/healthcheck/ios/'.$deviceid.'/8'; 
            break;
            case 'buffers':
          $url='http://63.49.0.192:8080/healthcheck/ios/'.$deviceid.'/5';
          break;             
            case 'showversion':
          $url='http://63.49.0.192:8080/healthcheck/ios/'.$deviceid.'/2';
          break;
            case 'configregister':
          $url='http://63.49.0.192:8080/healthcheck/ios/'.$deviceid.'/3';
          break;
            case 'environment':
          $url='http://63.49.0.192:8080/healthcheck/ios/'.$deviceid.'/4';
          break;
            case 'platform':
          $url='http://63.49.0.192:8080/healthcheck/ios/'.$deviceid.'/6';
          break;
            case 'bfdsession':
          $url='http://63.49.0.192:8080/healthcheck/ios/'.$deviceid.'/10';
          break;
            case 'interfacestates':
          $url='http://63.49.0.192:8080/healthcheck/ios/'.$deviceid.'/9';
          break;
            case 'showinterfaces':
          $url='http://63.49.0.192:8080/healthcheck/ios/'.$deviceid.'/7';
          break;
            case 'mplsinterfaces':
          $url='http://63.49.0.192:8080/healthcheck/ios/'.$deviceid.'/12';
          break;
            case 'mplsneighbors':
          $url='http://63.49.0.192:8080/healthcheck/ios/'.$deviceid.'/11';
          break;
            case 'bgpvsixroutes':
          $url='http://63.49.0.192:8080/healthcheck/ios/'.$deviceid.'/17';
          break;
            case 'show-running-config-|-i-boot':
          $url='http://63.49.0.192:8080/healthcheck/ios/'.$deviceid.'/16';
          break;           
            case 'cpuutilization':
          $url='http://63.49.0.192:8080/healthcheck/ios/'.$deviceid.'/1';
          break; 
            case 'fivethsndbyteping':
          $url='http://63.49.0.192:8080/healthcheck/ios/'.$deviceid.'/23';
          break;
            case 'twothsndbyteping':
          $url='http://63.49.0.192:8080/healthcheck/ios/'.$deviceid.'/22';
          break;
            case 'bgpvsixneighbors':
          $url='http://63.49.0.192:8080/healthcheck/ios/'.$deviceid.'/14';
          break;
            case 'bgpvfourneighbors':
          $url='http://63.49.0.192:8080/healthcheck/ios/'.$deviceid.'/13';
          break;
           case 'xconnect':
          $url='http://63.49.0.192:8080/healthcheck/ios/'.$deviceid.'/20';
          break;
           case 'bgpvfourroutes':
          $url='http://63.49.0.192:8080/healthcheck/ios/'.$deviceid.'/19';
          break;
           case 'bootstatement':
          $url='http://63.49.0.192:8080/healthcheck/ios/'.$deviceid.'/16';
          break;
           case 'interfacecounters':
          $url='http://63.49.0.192:8080/healthcheck/ios/'.$deviceid.'/7';

			case 'logentries':
          $url='http://63.49.0.192:8080/healthcheck/ios/'.$deviceid.'/15';
          break;

            default: 
          break;
        }   
                  /*    Ends  */    
        ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 style="font-size:12px;font-family:arial;text-align:center;" class="modal-title">Device Console Output  - Command Issued - <?php echo $_GET['commandname'];?> </h4>
    
</div>

<div class="modal-body">    
<?php
	      if (isset($url)) {
		       if (!$data = @file_get_contents($url)) {
             $error = error_get_last(); 
             $data = "HTTP request failed. Error was: " . $error['message'];
           } 
        } else 
            $data = "CLI command needs is in progress.";
          
     echo "<span style='font-family:courier;font-size:12px;font-weight:500;'> $data</span>";
?>  
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    
</div>
