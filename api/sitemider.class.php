<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/sample_devices/api/rest.inc.php");


class SiteMinderAPI extends REST {

	private $user_session = null;

	public function __construct(){
        parent::__construct();              // Init parent contructor
        
	}

	 
}