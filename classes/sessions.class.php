<?php

class Sessions {

protected $sessionID;

public function __construct(){
    if( !isset($_SESSION) ){
        $this->init_session();
    }
    //session_start();
    //$this->sessionID = session_id();
}

public function init_session(){
    session_start();
}

public function set_session_id(){
    $this->sessionID = MD5();
}

public function get_session_id(){
    return $this->sessionID;
}

public function session_exist( $session_name ){
    return isset($_SESSION[$session_name]);
}

public function create_session( $session_name , $is_array = false ){
    if( !isset($_SESSION[$session_name])  ){
        if( $is_array == true ){
            $_SESSION[$session_name] = array();
        }
        else{
            $_SESSION[$session_name] = '';
        }
    }
}

public function insert_value( $session_name , array $data ){
    if( is_array($_SESSION[$session_name]) ){
        array_push( $_SESSION[$session_name], $data );
    }
}

public function display_session( $session_name ){
    echo '<pre>';print_r($_SESSION[$session_name]);echo '</pre>';
}

public function remove_session( $session_name = '' ){
    if( !empty($session_name) ){
        unset( $_SESSION[$session_name] );
    }
    else{
        unset($_SESSION);
        //session_unset();
        //session_destroy();
    }
}
}