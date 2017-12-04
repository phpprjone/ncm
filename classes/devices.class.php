<?php

include_once ("db2.class.php");
class DeviceApi {

	public function getDeviceList($arrayparam) {

		$db2 = new db2();

		$db2->query("SELECT * FROM devices WHERE userid ='" .$arrayparam['userId'] ."' AND usertype='".$arrayparam['userType'] ."'");

		$result = $db2->resultset();

		return $result;

	}
}
