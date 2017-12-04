<?php

function logToFile($filename, $msg) {  
   // open file 
   $fd = fopen($filename, "a"); 
   // append date/time to message 
   $str = "[" . date("Y/m/d h:i:s", mktime()) . "] " . $msg;  
   // write string 
   fwrite($fd, $str . "\n"); 
   // close file 
   fclose($fd); 
} 

function get_user_info($username, $password) {

  global $db2;

  if (trim($username) !='' && trim($password) != '') {
      $password= md5($password);
      $sql = "SELECT * FROM users WHERE username='" .$username. "' AND password='" .$password. "'";
  
      $db2->query($sql);
      $rows = $db2->resultset();
      $result = $rows[0];

      return $result;
  }
  return false;

} 

function check_user_authentication($usertype) {
  global $db2;

  if ($_SESSION['userid']) {
    if ($_SESSION['userlevel']  == $usertype) {
      return true;
    }
    else {
      header('Location: access.php?msg=You are not authorized to access this page');
    }
  }
}

function get_landing_page() {

  if (!$_SESSION['userlevel']) {
    return 'login.php';
  }
  else { 
    if ($_SESSION['userlevel'] === "1") { // fieldsite technician 
      $location_href = "sheet1_cellsitetech_user_devicelist.php";
    }
    if ($_SESSION['userlevel'] === "2") {
      $location_href = "sheet1_switchtech_user_list.php";
    }
    return $location_href;
  }

}
function activemenu($filename) {
    $active = '';
    
    $current_file = $_SERVER['SCRIPT_NAME'];
    if(!is_array($filename)){
        if(strpos($current_file, $filename)){
            $active =  ' class="active"';
        }
        else {
            $active = '';
        }
    }
    else {
        foreach($filename as $flnm) {
            if(strpos($current_file, $flnm)){
                $active = ' class="active"';
                break;
            }
            else {
                $active = '';
            }
        }
    }
    
    return $active;
}

/*
* User Login check and user session creation
*/
function user_session_check() {
	global $db2;
  if (isset($_POST['username']) && $_POST['password']){


    $username = $_POST['username'];
    $password = $_POST['password'];

    if (trim($username) !='' && trim($password) != '') {
      $password= md5($password);
      $sql = "SELECT * FROM users WHERE username='" .$username. "' AND password='" .$password. "'";
      $db2->query($sql);
      $rows = $db2->resultset();
      $result = $rows[0];
  
      if ( ! $result ) {
        header("Location: login.php?msg=Username and Password is wrong");
        exit();
      }
      $userid = $_SESSION['userid'] = $result['id']; 
      $_SESSION['username'] = $username;
    }
    else { 
       header("Location: login.php");
       exit();
    }

  }
  else {

    if ( ! isset($_SESSION['userid'])) {
      
      header("Location: login.php?msg=User session expired");
      exit();
    }
  } 

}

function get_user_type(){
  global $db2;

  $db2->query("SELECT userlevel FROM users WHERE id=" . $_SESSION['userid']);
  $db2->query($sql);
      $rows = $db2->resultset();
      $result = $rows[0];
  return $result;
}
   
/*
* Checks for session live or not
*/
function is_live_session($sessid) {

    $db2 = new db2(); 
    //exit("SELECT COUNT(*) FROM sessions WHERE sessionid=" .$sessid );
    $db2->query( "SELECT COUNT(*) FROM sessions WHERE sessionid='" .$sessid ."'");
    $row = $db2->resultsetCols();
    $sess_record_count = $row[0];

    return $sess_record_count;
}

/*
* Nodes table for devices list
*/

function get_device_list_from_nodes($user_id) {

  global $db2, $pages; 
  $pages->paginate();
  if ($user_id > 0) {
    $sql_count = "SELECT COUNT(*) ";
    $sql_select = "SELECT n.id, n.custom_Location, n.deviceName, n.deviceIpAddr, n.model, v.vendorName, n.investigationstate, n.status, n.upsince, n.nodeVersion, n.severity, n.deviceseries ";
        
    $sql_condition = " FROM userdevices ud
         JOIN nodes n on ud.nodeid = n.id 
         
         LEFT JOIN vendors v on v.id = n.vendorId
         WHERE ud.userid = " . $user_id ;

    $sql_search_cond = '';
    if ( $_SESSION['search_term'] != ''){
      $search_term = $_SESSION['search_term'];

      $sql_search_cond = " AND ( n.deviceName LIKE '%" . $search_term . "%' ";      
      $sql_search_cond .= " OR n.deviceIpAddr LIKE '%" . $search_term . "%' ";           
      $sql_search_cond .= " OR n.custom_Location LIKE '%" . $search_term . "%' ";   

/* Other fields temporarely excluded*/

// $status_val = (strtolower(trim($search_term))  == 'reachable') ? '1' : '0';
// $sql_search_cond .= " OR n.status = " . $status_val;

// $sql_search_cond .= " OR n.upsince LIKE '%" . $search_term . "%' ";    
// $sql_search_cond .= " OR n.nodeVersion LIKE '%" . $search_term . "%' ";    

      $sql_search_cond .= " OR n.investigationstate LIKE '%" . $search_term . "%' ";    
      $sql_search_cond .= " OR n.model LIKE '%" . $search_term . "%' ) ";
    }
  }  
  $count_sql = $sql_count . $sql_condition . $sql_search_cond;

  // echo $count_sql;
  $db2->query($count_sql);
  $row = $db2->resultsetCols();
  $total_rec = $row[0];

  $sql = $sql_select . $sql_condition . $sql_search_cond;
  $sql .= $pages->limit;
        // echo "value of sql inside the get_device_list".$sql;  exit(0);
  // echo '<br>';
  // echo $sql;
  $db2->query($sql);
  
  $resultset['result'] = $db2->resultset();
  $resultset['total_rec'] = $total_rec;
  
  return $resultset;
}


function get_device_list_from_nodes_datatable($userid) {

	global $db2, $pages;

  //print_r($_GET);
  $draw = $_GET['draw'];
  $start = isset($_GET['start']) ? $_GET['start'] : 0;
  $length = isset($_GET['length']) ? $_GET['length'] : 10;
  $search = trim($_GET['search']['value']) ? addslashes(trim($_GET['search']['value'])) : null;
  $order_col = $_GET['order'][0]['column'];
  $order_dir = $_GET['order'][0]['dir'];

  $columns = array(  
    'n.id',
    'n.csr_site_id',
    'n.csr_site_name',
    'n.deviceName',
    'n.market',
    'n.deviceseries',
    'n.nodeVersion',
    'n.lastpolled'
  );



  $sql_count = "SELECT COUNT(*) ";
  $sql_select = "SELECT " . implode(", ", $columns);
      
  $sql_condition = " FROM userdevices ud
       JOIN nodes n on ud.nodeid = n.id        
       WHERE ud.userid = " . $userid ;
  if ($search) {
    $sql_condition .=  " AND ( ";
    $sql_condition .=  " n.deviceName LIKE '%". $search ."%'";
    $sql_condition .=  " OR n.csr_site_id  LIKE '%". $search ."%'";
    $sql_condition .=  " OR n.csr_site_name  LIKE '%". $search ."%'";
    $sql_condition .=  " OR n.market  LIKE '%". $search ."%'";
    $sql_condition .=  " OR n.deviceseries  LIKE '%". $search ."%'";
    $sql_condition .=  " OR n.nodeVersion  LIKE '%". $search ."%'";
    $sql_condition .=  " OR n.lastpolled  LIKE '%". $search ."%'";
     $sql_condition .=  " ) ";
  }
  $count_sql = $sql_count . $sql_condition; 
 // echo $count_sql;
  $db2->query($count_sql);
  $row = $db2->resultsetCols();
  
  $total_rec = $row[0];


  $sql_order = "";
  if ($order_col != ''){
    $sql_order = " ORDER BY " . $columns[$order_col];
  }

  if ($order_dir != ''){
    $sql_order .= $order_dir != '' ? " $order_dir ": " asc ";
  }

    $sql_limit = " LIMIT $start, $length ";
  
  $sql = $sql_select . $sql_condition  . $sql_order . $sql_limit ;
  // echo '<br>';
  // echo $sql;

  $db2->query($sql);
  
  
  $resultset['draw'] = $draw;

  if ($db2->resultset()) {
  foreach ($db2->resultset() as $key => $value) {
    $value['DT_RowId'] = "row_" . $value['id'] ;
    $records[$key] = $value;
  }
  $resultset['data'] = $records;
  $resultset['recordsTotal'] = $total_rec;
  $resultset['recordsFiltered'] = $total_rec;
  }
  else { 
    $resultset['data'] = array();
    $resultset['recordsTotal'] = 10;
    $resultset['recordsFiltered'] =0;
  }

 return $resultset;
}

/*
*  get device details for the current users
*/
function get_device_list($user_id, $usertype='ME') {

	$db2 = new db2();
	$pages = new Paginator;
	$pages->paginate();

	if ($user_id > 0) {

		$sql = "SELECT dd.* FROM currentusers cu 
				 JOIN devicedetails dd on cu.deviceId = dd.id 
				 WHERE cu.userid = " . $user_id . " AND cu.usertype='" . $usertype . "' ";
	}
	else {
		$sql = "SELECT dd.* FROM currentusers cu 
				 JOIN devicedetails dd on cu.deviceId = dd.id ";
	}	

	$count_sql = str_replace("dd.*", 'count(*)', $sql);
	
	$db2->query($count_sql);
	$row = $db2->resultsetCols();
	$total_rec = $row[0];
	//$pages->items_total = $count_result['total'];
	//$pages->mid_range = 7; // Number of pages to display. Must be odd and > 3

	$sql .= $pages->limit;

	// exit($sql);
	$db2->query($sql);
	// print_R($sql);
	
	$resultset['result'] = $db2->resultset();
	$resultset['total_rec'] = $total_rec;
	
	return $resultset;
}

/* 
 *	Updates the device_details table and
 *  current_users table
*/
function update_devicedetails($userid, $usertype, $device_details){

	$db2 = new db2();

	//Swich Tech API and Field Tech API calls are handled here
	//for device_details information
	foreach ($device_details as $key => $device) {
		 
            $devicename = $device['name'];
            $ipaddress  = $device['ipaddress'];
            $vendor	= $device['vendor'];
            $prompt = $device['prompt']; 
            $username = $device['username'];
            $password = $device['password']; 
            $port = $device['port'];
            $access_type = $device['access_type']; 		

		$sql = "INSERT INTO `devicedetails` (`name`, `ipaddress`, `vendor`, `prompt`, `username`, `password`, `port`, 
				`access_type`) VALUES
				('$devicename', '$ipaddress', '$vendor', '$prompt', '$username', '$password', '$port', '$access_type')";

		$db2->query($sql);
		$db2->execute();
		$lastInsertId  = $db2->lastInsertId(); 

		$sql = "INSERT INTO currentusers (userId, deviceId, userType)
				VALUES ('$userid', $lastInsertId, '$usertype' )";		

		$db2->query($sql);
		$db2->execute();
	} 
}

/*
* Updates the sessions table
*
*/
function update_sessions($userid, $usertype, $sessionid) {

		$db2   = new db2();

		$sql = "SELECT * FROM sessions WHERE sessionId = '".$sessionid."'";
		$db2->query($sql);
		$recordset = $db2->resultset();

		if (!$recordset) {
			$sql = "INSERT INTO `sessions` (`userId`, `userType`, `sessionId`, `initLogged`, `LastLogged`) VALUES
					('$userid', '$usertype', '$sessionid', now(), now() )";
			$db2->query($sql);
			$db2->execute();
		}
		else {

			$sql = "UPDATE `sessions` SET lastLogged = now() WHERE sessionId = '".$sessionid."'"; 
			// exit ($sql);
			$db2->query($sql);
			$db2->execute();		
		}
}

/*
* Deletes users from sessions table where users are idle for last 20 mins or more
*
*/
function delete_idleuser() {

	$db2 = new db2();

	$sql = "select * from sessions T where TIMESTAMPDIFF(MINUTE,T.initLogged,T.lastLogged) > " . CRON_TIME_INTERVAL;

	$db2->query($sql);
	$recset = $db2->resultset();
	$deleted_users = array();
	foreach ($recset as $key => $value) {

		$userid =  $value['userId'];

		$sql = "DELETE FROM currentusers WHERE userId=$userid ";
		$db2->query($sql);
		$db2->execute();

		$sql = "DELETE FROM sessions WHERE userId=$userid ";
		$db2->query($sql);
		$db2->execute();
		
		$deleted_users[] = $userid;
		
	}
	return $deleted_users;

}



/*
* Deletes users from sessions table where users are idle for last 20 mins or more
*
*/
function delete_alluser() {

	$db2 = new db2();

	$sql = "select * from sessions T where TIMESTAMPDIFF(MINUTE,T.initLogged,T.lastLogged) > " . CRON_TIME_INTERVAL;
	$sql = "DELETE FROM sessions";
	$db2->query($sql);
	$db2->execute();

	$sql = "DELETE FROM currentusers";
	$db2->query($sql);
	$db2->execute();

	$sql = "DELETE FROM devicedetails";
	$db2->query($sql);
	$db2->execute();

}
 
/*
* Api call
*/

function sendPostData ($url) { 
 //exit($url);
  // Curl GET methods begins 
	//echo "Inside the sendpostdata method value of url is $url";;  
	$ch = curl_init();   
    curl_setopt($ch, CURLOPT_POST, 0);
	curl_setopt($ch, CURLOPT_HTTPGET, 1);
    curl_setopt($ch, CURLOPT_URL,$url);
    //curl_setopt($ch, CURLOPT_POSTFIELDS,$query);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec ($ch);
    curl_close ($ch);

    //error handling for cURL
    if ($reply === false) {
       // throw new Exception('Curl error: ' . curl_error($crl));
       print_r('Curl error: ' . curl_error($crl));
    };
    curl_close($crl);
 
	return $result;
    //cURL ends	   
	// Curl GET method ends
}

function getDetailViewData($userid, $deviceid) {
	$db2 = new db2(); 
	$sql_select = "SELECT hk.deviceid, hk.cpuutilization, hk.freememory, hk.buffers, hk.iosversion, hk.bootstatement, hk.configregister, hk.environmental, hk.platform, hk.bfdsession, hk.interfacestates, hk.interfacecounters, hk.mplsinterfaces, hk.mplsneighbors, hk.bgpvfourneighbors, hk.bgpvsixneighbors, hk.bgpvfourroutes, hk.bgpvsixroutes, hk.twothsndbyteping, hk.fivethsndbyteping, hk.logentries, hk.xconnect, hk.lightlevel, hk.userid ";
	$sql_condition = " 
	FROM 
	healthcheck hk 
	JOIN nodes n on n.id = hk.deviceid
	JOIN userdevices ud on ud.nodeid = hk.deviceid AND ud.userid = hk.userid
	WHERE hk.userid = $userid and hk.deviceid = ". $deviceid; 

	$sql = $sql_select . $sql_condition;

	logToFile(my.log, $sql);
	$db2->query($sql);
	 
		$resultset['result'] = $db2->resultset(); 
		logToFile(my.log, $resultset);
		return $resultset;	 
}

/*
* Function to get the Switches list of user
*/
function getSwitchDevicesList($userid){

  global $db2;

  $sql = "SELECT n.id, n.deviceName, n.custom_Location, n.submarket  FROM userdevices ud  
          JOIN nodes n ON n.id = ud.nodeid
          WHERE ud.userid = $userid AND n.submarket != ''
          ORDER BY ud.nodeid
          ";
  $db2->query($sql);

  $resultset['result'] = $db2->resultset(); 
  return $resultset;
}


/*
* Functin to get the switch devices list by city wise for the user
*/
function getSwitchDevicesListByCity($userid, $city){

  global $db2, $pages;

  $sql_count = " SELECT count(*) ";
  $sql_select = " SELECT n.id, n.deviceName, n.custom_Location, n.submarket ";

  $sql_condition = " FROM userdevices ud  
                    JOIN nodes n ON n.id = ud.nodeid
                    WHERE ud.userid = $userid AND n.submarket = '$city' ";
  $sql_order = " ORDER BY ud.nodeid ";

  $count_sql = $sql_count . $sql_condition ;  
  $db2->query($count_sql);
  $row = $db2->resultsetCols(); 

  $resultset['total_rec'] = $row[0];

  $sql = $sql_select . $sql_condition . $sql_order;
  $sql .= $pages->limit; 
  $db2->query($sql);

  $resultset['result'] = $db2->resultset(); 
  return $resultset;
}


/*
* Functin to get the switch devices list by market and subregion wise for the user
*/
function get_switchlist_for_market_subregion($userid, $market, $subregion){

  global $db2, $pages;
  $pages->paginate();
  
  $sql_count = " SELECT count(*) ";
  $sql_select = " SELECT n.id, n.deviceName, n.custom_Location, n.submarket, n.market as 'subregion' ";

  $sql_join = " FROM userdevices ud  
                    JOIN nodes n ON n.id = ud.nodeid ";

                   // JOIN mst_market mm on mm.subregion = n.subregion ";

  $sql_where_condition = " WHERE ud.userid = $userid and n.switch_name !='' ";

  if ($market != '') {
    $sql_where_condition .= " AND n.market  = '$market' ";
  }
  if ($subregion != '') {
    $sql_where_condition .= " AND n.submarket = '$subregion' ";
  }

  $sql_order = " ORDER BY ud.nodeid ";

  $count_sql = $sql_count .  $sql_join . $sql_where_condition  ;  
  $db2->query($count_sql);
  $row = $db2->resultsetCols(); 

  $resultset['total_rec'] = $row[0];
  

  $sql = $sql_select . $sql_join . $sql_where_condition . $sql_order;
  $sql .= $pages->limit;  
 
  $db2->query($sql);

  $resultset['result'] = $db2->resultset(); 
  return $resultset;
}



/*
*
*/
function getSWroutersDetails($deviceid, $userid) {
  global $db2;

  $sql_select = " SELECT n2.id,n2.deviceName,n2.deviceIpAddr, n2.custom_Location, n2.connPort, n2.model, n2.systemname ";
  $sql_condition = " FROM nodes n
                    JOIN userdevices ud ON ud.nodeid = n.id
                    JOIN connectingdevices cd ON cd.swname = n.switch_name
                    JOIN nodes n2 ON cd.swrtrconnodeid = n2.id  
                    WHERE n.id = $deviceid AND ud.userid = $userid  ";

  $sql = $sql_select . $sql_condition;
  $db2->query($sql);

  $resultset['result'] = $db2->resultset(); 
  return $resultset;

}

/*
* Function to get the Switch Technician city list
*/
function getSEuserCityList($userid)  {

  global $db2;

  $sql = "SELECT  n.submarket  FROM userdevices ud  
          JOIN nodes n ON n.id = ud.nodeid
          WHERE ud.userid = $userid AND n.submarket != ''
          group BY n.submarket 
          ORDER BY n.submarket ";
  $db2->query($sql);

  $resultset['result'] = $db2->resultset(); 
  return $resultset;
}



function usrfavritelist_display($userid){
  $db2 = new db2(); 
  $sql_select = " SELECT listname, listid ";
  $sql_condition = "  
  FROM 
  userdevices
  WHERE userid = $userid  and listid <> 0 
  group by listname, listid  
  order by listid desc ";

  $sql = $sql_select . $sql_condition;
  $db2->query($sql);
  $resultset['result'] = $db2->resultset(); 
   return $resultset;   
}

function insert_my_device_record($data){
   $db2 = new db2();
   $listid = $data['listid'];
   $userid =$data['userid']; 
   $nodeid = $data['deviceid'];
  

    $sql = "SELECT  listname FROM userdevices WHERE listid = $listid group by listname ";

    $db2->query($sql);
    $recordset = $db2->resultset();  
    $listname = addslashes($recordset[0]['listname']);
    
     $sql = "INSERT INTO userdevices (nodeid, userid, listid, listname) 
           VALUES($nodeid,$userid,$listid,'$listname')";
     // echo $sql;           
     $db2->query($sql);
     $result =$db2->execute();
    
   return $result;

}

function insert_ipaddrmgmt_record($data){
    $db2 = new db2();
    
    $sql = "INSERT INTO ipaddrmgmt (market, fromipvfour, toipvfour, fromipvsix, toipvsix)
           VALUES('".$data['market']."','".$data['fromipvfour']."','".$data['toipvfour']."','".$data['fromipvsix']."','".$data['toipvsix']."')";
    
    $db2->query($sql);
    $result =$db2->execute();
    
    return $result;
    
}

function insert_usrfavritedev($data){
   $db2 = new db2();
   $lname = addslashes($data['listname']);
   $userid =$data['userid']; 
   $nodes = array($data['deviceid']);
    $sql = "SELECT  max(listid) + 1  as listidmaxval FROM userdevices WHERE listid <> 0 ";
    $db2->query($sql);
    $recordset = $db2->resultset();      
    $listid = $recordset[0]['listidmaxval']+1;
    
     $sql = "INSERT INTO userdevices (nodeid, userid, listid, listname) 
           VALUES(0,$userid,$listid,'$lname')";
// echo $sql ; 
     $_SESSION['mylistname'] = $lname;
     $_SESSION['switchlistid'] = $listid;
     $db2->query($sql);
     $result =$db2->execute();
    
   return $result;

}

function usrfavritecondev_display($userid,$listid){
  $db2 = new db2(); 
  $sql_select = " SELECT ud.id, ud.listid, ud.listname, ud.nodeid, n.deviceName ";
  $sql_condition = " 
  FROM 
  userdevices ud
  LEFT JOIN nodes n on ud.nodeid = n.id
  WHERE ud.listid = $listid and ud.userid = $userid and ud.listid != 0  order by ud.id desc "; 
  $sql = $sql_select . $sql_condition;

  $db2->query($sql);
  $resultset['result'] = $db2->resultset(); 

  $resultset['mylistname'] = $resultset['result'][0]['listname'];
  
  array_pop($resultset['result']);

  return $resultset;   
}


function user_mylist_devieslist($userid,$listid){ 

  
  global $db2, $pages; 
  $pages->paginate();
  if ($userid > 0) {
    $sql_count = "SELECT COUNT(*) ";
    $sql_select = "SELECT n.id, n.custom_Location, n.deviceName, n.deviceIpAddr, n.model, v.vendorName, n.investigationstate, n.status, n.upsince, n.nodeVersion, ud.listname, n.severity, n.deviceseries ";
        
    $sql_condition = " FROM userdevices ud
         JOIN nodes n on ud.nodeid = n.id 
        
         LEFT JOIN vendors v on v.id = n.vendorId
         WHERE ud.userid = " . $userid ." and ud.listid = " . $listid ;
 
     
  }  
  $count_sql = $sql_count . $sql_condition; 
  // echo "$count_sql";
  $db2->query($count_sql);
  $row = $db2->resultsetCols();
  $total_rec = $row[0];

  $sql = $sql_select . $sql_condition;
  $sql .= $pages->limit;
  // echo "$sql";
  $db2->query($sql);
  
  $resultset['result'] = $db2->resultset();
  $resultset['total_rec'] = $total_rec;
  return $resultset;
}

function get_user_mylist_name($userid,$listid) {
  global $db2;

  $sql = "SELECT ud.listname  FROM userdevices ud
         JOIN nodes n on ud.nodeid = n.id 
         
         WHERE ud.userid = " . $userid ." and ud.listid = " . $listid . "
         limit 0,1 " ;

  $db2->query($sql);
  
  $resultset = $db2->resultset();
  if(isset($resultset[0]['listname']))  {
      return($resultset[0]['listname']);
  }
  else {
    return;
  }
}

function user_mylist_devieslist_datatable($userid,$listid){ 

  
  global $db2, $pages; 

  if (!$userid) {
    return false;
  }
  //print_r($_GET);
  $draw = $_GET['draw'];
  $start = isset($_GET['start']) ? $_GET['start'] : 0;
  $length = isset($_GET['length']) ? $_GET['length'] : 10;
  $search = trim($_GET['search']['value']) ? addslashes(trim($_GET['search']['value'])) : null;
  $order_col = $_GET['order'][0]['column'];
  $order_dir = $_GET['order'][0]['dir'];

  $columns = array(
    'n.model',
	'n.id',
    'n.csr_site_id',
    'n.csr_site_name',
    'n.deviceName',
    'n.market',
    'n.deviceseries',
    'n.nodeVersion',
    'n.lastpolled'
  );
 

  $sql_count = "SELECT COUNT(*) ";
  $sql_select = "SELECT " . implode(", ", $columns);
      
  $sql_condition = " FROM userdevices ud
       JOIN nodes n on ud.nodeid = n.id        
       WHERE ud.userid = " . $userid ." and ud.listid = " . $listid ;
  if ($search) {
    $sql_condition .=  " AND ( ";
    $sql_condition .=  " n.deviceName LIKE '%". $search ."%'";
    $sql_condition .=  " OR n.csr_site_id LIKE '%". $search ."%'";
    $sql_condition .=  " OR n.csr_site_name  LIKE '%". $search ."%'";
    $sql_condition .=  " OR n.market  LIKE '%". $search ."%'";
    $sql_condition .=  " OR n.deviceseries  LIKE '%". $search ."%'";
    $sql_condition .=  " OR n.nodeVersion  LIKE '%". $search ."%'";
    $sql_condition .=  " OR n.lastpolled  LIKE '%". $search ."%'";
     $sql_condition .=  " ) ";
  }
  $count_sql = $sql_count . $sql_condition; 
  // echo $count_sql;
  $db2->query($count_sql);
  $row = $db2->resultsetCols();
  
  $total_rec = $row[0];


  $sql_order = "";
  if ($order_col != ''){
    $sql_order = " ORDER BY " . $columns[$order_col];
  }

  if ($order_dir != ''){
    $sql_order .= $order_dir != '' ? " $order_dir ": " asc ";
  }

  $sql_limit = " LIMIT $start, $length ";
  
  $sql = $sql_select . $sql_condition  . $sql_order . $sql_limit ;

  $db2->query($sql);
  
  
  $resultset['draw'] = $draw;
if ($db2->resultset()) {
  foreach ($db2->resultset() as $key => $value) {
    $value['DT_RowId'] = "row_" . $value['id'] ;
    $records[$key] = $value;
  }
  $resultset['data'] = $records;
  $resultset['recordsTotal'] = $total_rec;
  $resultset['recordsFiltered'] = $total_rec;
}
else {
  $resultset['data'] = '';
  $resultset['recordsTotal'] =10;
  $resultset['recordsFiltered'] = 0;
}
return $resultset;

}


function usrfavritelistdel ($userid,$switchlistid){
  $db2 = new db2(); 
  $sql = "delete from userdevices where userid = $userid and listid = $switchlistid and listname !='Default'";
  $db2->query($sql);
  $db2->execute();
  return;
}


function usrfavritelistswdel($userid,$switchlistid,$switchid){
  $db2 = new db2(); 
  $sql = "delete from userdevices where listid = $switchlistid and nodeid = $switchid and userid = $userid and listname !='Default'";
    $db2->query($sql);
  $db2->execute(); 
  return;
}

function get_market_subregion_list($market_name) {
  global $db2;
  $sql_select = "SELECT submarket as subregion ";
  $sql_condition = " FROM 
                     nodes
                     WHERE market = '$market_name'
                     group by subregion
                     order by submarket ";
  $sql = $sql_select . $sql_condition;
  $db2->query($sql);
  $resultset['result'] = $db2->resultset(); 
  return $resultset;
}
 
 
 
function  userexist($emailid) { 
    $db2 = new db2(); 
    $sql = "SELECT COUNT(*) FROM users WHERE email ='" .$emailid."'";
    $db2->query($sql);
    $row = $db2->resultsetCols();
    $resultset['result'] = $db2->resultset();

   return $row;
} 

function sendmail($mailbody,$pwrurl) {
  $mail = new PHPMailer();
  $mail->IsSMTP(); // send via SMTP
  $mail->SMTPAuth = true; // turn on SMTP authentication
  $mail->Username = "ncmadministrator@gmail.com"; // SMTP username
  $mail->Password = "ncmadministratorpassword"; // SMTP password
  $webmaster_email = "ncmadministrator@gmail.com"; //Reply to this email ID
  $email="enduser@gmail.com"; // Recipients email ID
  $name="enduser"; // Recipient's name
  $mail->From = $webmaster_email;
  $mail->FromName = "NCM Administrator";
  $mail->AddAddress($email,$name);
  $mail->AddReplyTo($webmaster_email,"ncmadministrator@gmail.com");
  $mail->WordWrap = 50; // set word wrap
  //$mail->AddAttachment("/var/tmp/file.tar.gz"); // attachment
  //$mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // attachment
  $mail->IsHTML(true); // send as HTML
  $mail->Subject = "NCM Password Reset";
  //$mail->Body = "Hi,
  //This is the HTML BODY "; //HTML Body
  $mail->Body = file_get_contents('emailcontent.php').$mailbody.$pwrurl;
  $mail->AltBody = "This is the body when user views in plain text format"; //Text Body
  if(!$mail->Send())
  {
  echo "Mailer Error: " . $mail->ErrorInfo;
  }
  else
  {
  //echo "Message has been sent";
  }
  //echo "<br>"."sendmail completed";
}

function updateuserpassword($emailid,$password) {
   // Update the user's password
    $db2   = new db2();
    $sql = "SELECT * FROM users WHERE email = '".$emailid."'";
    $db2->query($sql);
    $recordset = $db2->resultset();      
    if (!$recordset) {
      echo "Username not found in our records.";    
    }  else {          
        $sql = "UPDATE `users` SET password = '".$password."' WHERE email = '".$emailid."'"; 
        $db2->query($sql);
        $db2->execute();   
        return true;
    };      
}
function get_market_list() {
  global $db2;

  $sql_select = "SELECT market as market_name ";
  $sql_condition = " FROM nodes
                      where market != ''
                      GROUP BY market "; 
  $sql = $sql_select . $sql_condition;
  $db2->query($sql);
  // echo $sql;
  $resultset['result'] = $db2->resultset(); 
  return $resultset;
}




/*
* Functin to get the switch devices list by market and subregion wise for the user
*/
function get_switchlist_all_market($userid){

  global $db2;
  
  $sql_count = " SELECT count(*) ";
  $sql_select = " SELECT n.switch_name ";

  $sql_join = " FROM  nodes n
                      JOIN users u on u.username = n.swt_tech_id ";
                    
  $sql_where_condition = " WHERE u.id = $userid and n.switch_name !='' limit 0,1 ";

  /*if ($market != '') {
    $sql_where_condition .= " AND n.market  = '$market' ";
  }
  if ($subregion != '') {
    $sql_where_condition .= " AND n.submarket = '$subregion' ";
  }*/

  $sql_order = " ";

  $count_sql = $sql_count .  $sql_join . $sql_where_condition  ;  
  $db2->query($count_sql);
  $row = $db2->resultsetCols(); 

  $resultset['total_rec'] = $row[0];
  

  $sql = $sql_select . $sql_join . $sql_where_condition . $sql_order;
//  $sql .= $pages->limit;  

  $db2->query($sql);

  $resultset['result'] = $db2->resultset(); 
  return $resultset;
}


/*
*
*/
function getSWroutersDetails_all($swich_devince_name, $search_term='', $userid, $page_limit) {
  global $db2;

  $high_limit = HIGH_LIMIT;
  $low_limit = LOW_LIMIT;
  $pages = new Paginator();
  $pages->default_ipp = $page_limit;
  $temp_page_var = (isset($_GET['page'])) ? $_GET['page'] : 1;
 
  if (isset($_GET['page'])) {

    if ($_GET['ipp'] ==  $high_limit) {
      $_SESSION['high_page'] = $_GET['page'];
    }

    if ($_GET['ipp'] ==  $low_limit) {
      $_SESSION['low_page'] = $_GET['page'];
    }


    if ($page_limit  ==  $high_limit) {
      $_GET['page'] = ($_SESSION['high_page']) ? $_SESSION['high_page'] : '1';
    }

    if ($page_limit  ==  $low_limit) {
      $_GET['page'] = ($_SESSION['low_page']) ? $_SESSION['low_page'] : '1';
    }                      
  }
  else {
    unset($_SESSION['low_page']);
    unset($_SESSION['high_page']);

    $_SESSION['low_page'] = 1;
    $_GET['ipp'] = LOW_LIMIT;
    $_GET['page'] = 1;
  }
  $pages->paginate();
  $_GET['page']=   $temp_page_var;



  $sql_count = " SELECT count(*) ";
  $sql_select = " SELECT n2.id,n2.deviceName,n2.deviceIpAddr, n2.custom_Location, n2.connPort, n2.model, n2.systemname ";
  $sql_condition = " FROM nodes n2 
                      join userdevices ud on ud.nodeid = n2.id
                      join users u on u.id = ud.userid
                    WHERE n2.switch_name ='$swich_devince_name' AND u.id = $userid  ";

  if ($search_term != '') {
    $sql_condition .= " AND ( ";
    $sql_condition .= "  n2.deviceName LIKE '%". addslashes($search_term) ."%' " ;
    $sql_condition .= "  OR n2.deviceIpAddr LIKE '%". addslashes($search_term) ."%' " ;
    $sql_condition .= "  OR n2.market LIKE '%". addslashes($search_term) ."%' " ;
    $sql_condition .= "  OR n2.submarket LIKE '%". addslashes($search_term) ."%' " ;
    $sql_condition .= " ) ";
  }
  $count_sql = $sql_count .  $sql_condition  ;  
  $db2->query($count_sql);
  $row = $db2->resultsetCols(); 

  $resultset['total_rec'] = $row[0];

  $sql = $sql_select . $sql_condition;
  $sql .= $pages->limit;
  
  $db2->query($sql);

  $resultset['result'] = $db2->resultset(); 
  return $resultset;

} 

/*
*
*/
function get_swt_user_routers_list_datatable($list_for, $list_type) {
  global $db2;


  //print_r($_GET);
  $draw = $_GET['draw'];
  $start = isset($_GET['start']) ? $_GET['start'] : 0;
  $length = isset($_GET['length']) ? $_GET['length'] : 10;
  $search_term = trim($_GET['search']['value']) ? addslashes(trim($_GET['search']['value'])) : null;
  $order_col = $_GET['order'][0]['column'];
  $order_dir = $_GET['order'][0]['dir'];

  $columns = array(
    'n.id',
    'n.id',
    'n.deviceName',
    'n.deviceIpAddr',
    'n.custom_Location',
  );


  $sql_count = " SELECT count(*) ";
  $sql_select = " SELECT " . implode(", ", $columns);

  if ($list_type == 'user') {
    $userid = $_SESSION['userid'];
    $switch_device_name = addslashes($list_for);
    $sql_condition = " FROM nodes n 
                      join userdevices ud on ud.nodeid = n.id
                      join users u on u.id = ud.userid
                      WHERE n.switch_name ='$switch_device_name' AND u.id = $userid  ";
  }
  else {
    $market = addslashes($list_for);
    $sql_condition = " FROM nodes n
                        WHERE trim(lower(REPLACE(n.market,' ',''))) ='$market'";

  }

  if ($search_term != '') {
    $sql_condition .= " AND ( ";
    $sql_condition .= "  n.deviceName LIKE '%". addslashes($search_term) ."%' " ;
    $sql_condition .= "  OR n.deviceIpAddr LIKE '%". addslashes($search_term) ."%' " ; 
    $sql_condition .= "  OR n.market LIKE '%". addslashes($search_term) ."%' " ;
    $sql_condition .= "  OR n.custom_Location LIKE '%". addslashes($search_term) ."%' " ;
    $sql_condition .= " ) ";
  }

  $count_sql = $sql_count .  $sql_condition  ;  
  $db2->query($count_sql);
  $row = $db2->resultsetCols(); 

  $total_rec = $row[0];



  $sql_order = "";
  if ($order_col != ''){
    $sql_order = " ORDER BY " . $columns[$order_col];
  }

  if ($order_dir != ''){
    $sql_order .= $order_dir != '' ? " $order_dir ": " asc ";
  }

  $sql_limit = " LIMIT $start, $length ";
  
  $sql = $sql_select . $sql_condition  . $sql_order . $sql_limit ;
  $db2->query($sql);  
  
  $resultset['draw'] = $draw;

  if (count($db2->resultset())) {
  foreach ($db2->resultset() as $key => $value) {
    $value['DT_RowId'] = "row_" . $value['id'] ;
    $records[$key] = $value;
  }
  $resultset['data'] = $records;
  $resultset['recordsTotal'] = $total_rec;
  $resultset['recordsFiltered'] = $total_rec;

}
else { 
  $resultset['data'] = '';
  $resultset['recordsTotal'] = 10;
  $resultset['recordsFiltered'] =0;
}
  
  return $resultset;
} 

function get_market_list_new() {
  global $db2;

  $sql_select = "SELECT market as market_name ";
  $sql_condition = " FROM nodes
                      where market != ''
                      GROUP BY market "; 
  $sql = $sql_select . $sql_condition;
  $db2->query($sql);
   
  $resultset['result'] = $db2->resultset(); 
  return $resultset;
}



function getmarketroutersDetails_all($market, $search_term, $page_limit) {
  global $db2;
  $pages = new Paginator();
 

  $high_limit = HIGH_LIMIT;
  $low_limit = LOW_LIMIT; 
  $pages->default_ipp = $page_limit;
  $temp_page_var = (isset($_GET['page'])) ? $_GET['page'] : 1;
 
  if (isset($_GET['page'])) {

    if ($_GET['ipp'] ==  $high_limit) {
      $_SESSION['high_page'] = $_GET['page'];
    }

    if ($_GET['ipp'] ==  $low_limit) {
      $_SESSION['low_page'] = $_GET['page'];
    }


    if ($page_limit  ==  $high_limit) {
      $_GET['page'] = ($_SESSION['high_page']) ? $_SESSION['high_page'] : '1';
    }

    if ($page_limit  ==  $low_limit) {
      $_GET['page'] = ($_SESSION['low_page']) ? $_SESSION['low_page'] : '1';
    }                      
  }
  else {
    unset($_SESSION['low_page']);
    unset($_SESSION['high_page']);

    $_SESSION['low_page'] = 1;
    $_GET['ipp'] = LOW_LIMIT;
    $_GET['page'] = 1;
  }
  $pages->paginate();
  $_GET['page']=   $temp_page_var;


  $sql_count = " SELECT count(*) ";
  $sql_select = " SELECT n2.id,n2.deviceName,n2.deviceIpAddr, n2.custom_Location, n2.connPort, n2.model, n2.systemname ";
  $sql_condition = " FROM nodes n2 
                        WHERE trim(lower(REPLACE(n2.market,' ',''))) ='$market'";

  if ($search_term != '') {
    $sql_condition .= " AND ( ";
    $sql_condition .= "  n2.deviceName LIKE '%". addslashes($search_term) ."%' " ;
    $sql_condition .= "  OR n2.deviceIpAddr LIKE '%". addslashes($search_term) ."%' " ;
    $sql_condition .= "  OR n2.market LIKE '%". addslashes($search_term) ."%' " ;
    $sql_condition .= "  OR n2.submarket LIKE '%". addslashes($search_term) ."%' " ;
    $sql_condition .= " ) ";
  }
  $count_sql = $sql_count .  $sql_condition  ;  
  $db2->query($count_sql);
  $row = $db2->resultsetCols(); 

  $resultset['total_rec'] = $row[0];

  $sql = $sql_select . $sql_condition;
  $sql .= $pages->limit;
  // echo $sql;;
   //echo $sql; exit(0);
  $db2->query($sql);
  $resultset['result'] = $db2->resultset(); 
  return $resultset;

}   


function export_table($table_name, $table_fields = array()) {
  
  global $db2;


  $sql_select = " SELECT * FROM ";
  $sql_where .= " nodes ";


  $db2->query($sql);
  $resultset['result'] = $db2->resultset();
  return $resultset;
}

function get_device_list_ipmgmt_datatable($userid) {
  global $db2, $pages;
  $draw = $_GET['draw'];
  $start = isset($_GET['start']) ? $_GET['start'] : 0;
  $length = isset($_GET['length']) ? $_GET['length'] : 10;
  $search = trim($_GET['search']['value']) ? addslashes(trim($_GET['search']['value'])) : null;
  $order_col = $_GET['order'][0]['column'];
  $order_dir = $_GET['order'][0]['dir'];

  $columns = array(
    'n.id',  
    'n.market',
    'n.fromipvfour',
    'n.toipvfour',
    'n.fromipvsix',
    'n.toipvsix'
     ); 
	 
  $sql_count = "SELECT COUNT(*) ";
  $sql_select = "SELECT " . implode(", ", $columns);

  $sql_condition = " FROM  ipaddrmgmt n";
  if ($search) {
    $sql_condition .=  " where ( ";
    //$sql_condition .=  " n.id LIKE '%". $search ."%'";
    $sql_condition .=  " n.market  LIKE '%". $search ."%'";
    $sql_condition .=  " OR n.fromipvfour  LIKE '%". $search ."%'";
    $sql_condition .=  " OR n.toipvfour  LIKE '%". $search ."%'";
    $sql_condition .=  " OR n.fromipvsix  LIKE '%". $search ."%'";
    $sql_condition .=  " OR n.toipvsix  LIKE '%". $search ."%'";
    $sql_condition .=  " ) ";
  }
  $count_sql = $sql_count . $sql_condition; 
  //echo $count_sql;
  $db2->query($count_sql);
  $row = $db2->resultsetCols();
  
  
  $total_rec = $row[0];


  $sql_order = "";
  if ($order_col != ''){
    $sql_order = " ORDER BY " . $columns[$order_col];
  }

  if ($order_dir != ''){
    $sql_order .= $order_dir != '' ? " $order_dir ": " asc ";
  }

    $sql_limit = " LIMIT $start, $length ";
  
  $sql = $sql_select . $sql_condition  . $sql_order . $sql_limit ;

  $db2->query($sql);
  $resultset['draw'] = $draw;
  if ($db2->resultset()) {
  foreach ($db2->resultset() as $key => $value) {
    $value['DT_RowId'] = "row_" . $value['id'] ;
    $records[$key] = $value;
  }

  
  $resultset['data'] = $records;
  $resultset['recordsTotal'] = $total_rec;
  $resultset['recordsFiltered'] = $total_rec;
  }
  else { 
    $resultset['data'] = array();
    $resultset['recordsTotal'] = 10;
    $resultset['recordsFiltered'] =0;
  }

 return $resultset;
}

/*
 * Function to get the Switches list of user
 */
function getIpAddrMgmtList($userid){
    global $db2;
    $sql = "SELECT market,fromipvfour,toipvfour,fromipvsix,toipvsix FROM ipaddrmgmt as ipmgt ORDER BY ipmgt.id";
    $db2->query($sql);
    $resultset['result'] = $db2->resultset();
    return $resultset;
}
function get_discovery_list_datatable($userid) {
global $db2, $pages;
  $draw = $_GET['draw'];
  $start = isset($_GET['start']) ? $_GET['start'] : 0;
  $length = isset($_GET['length']) ? $_GET['length'] : 10;
  $search = trim($_GET['search']['value']) ? addslashes(trim($_GET['search']['value'])) : null;
  $order_col = $_GET['order'][0]['column'];
  $order_dir = $_GET['order'][0]['dir'];

  $columns = array(
    'n.scantime',
    'n.deviceipaddr',
    'n.ping',
    'n.deviceid',
    'n.deviceos', 
    'n.nodeversion', 
     ); 
	 
  $sql_count = "SELECT COUNT(*) ";
  $sql_select = "SELECT " . implode(", ", $columns);

  $sql_condition = " FROM  discoveryres n";
  if ($search) {
    $sql_condition .=  " where ( ";
    $sql_condition .=  " n.scantime  LIKE '%". $search ."%'";
    $sql_condition .=  " OR n.deviceipaddr  LIKE '%". $search ."%'";
    $sql_condition .=  " OR n.ping  LIKE '%". $search ."%'";
    $sql_condition .=  " OR n.deviceid  LIKE '%". $search ."%'";
    $sql_condition .=  " OR n.deviceos  LIKE '%". $search ."%'";
    $sql_condition .=  " OR n.nodeversion  LIKE '%". $search ."%'";
    
    $sql_condition .=  " ) ";
  }
  $count_sql = $sql_count . $sql_condition; 
  //echo $count_sql;
  $db2->query($count_sql);
  $row = $db2->resultsetCols();
  
  
  $total_rec = $row[0];


  $sql_order = "";
  if ($order_col != ''){
    $sql_order = " ORDER BY " . $columns[$order_col];
  }

  if ($order_dir != ''){
    $sql_order .= $order_dir != '' ? " $order_dir ": " asc ";
  }

    $sql_limit = " LIMIT $start, $length ";
  
  $sql = $sql_select . $sql_condition  . $sql_order . $sql_limit ;

  $db2->query($sql);
  $resultset['draw'] = $draw;
  if ($db2->resultset()) {
  foreach ($db2->resultset() as $key => $value) {
    $value['DT_RowId'] = "row_" . $value['id'] ;
    $records[$key] = $value;
  }

  
  $resultset['data'] = $records;
  $resultset['recordsTotal'] = $total_rec;
  $resultset['recordsFiltered'] = $total_rec;
  }
  else { 
    $resultset['data'] = array();
    $resultset['recordsTotal'] = 10;
    $resultset['recordsFiltered'] =0;
  }

 return $resultset;
}