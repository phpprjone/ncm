<?php 
include "classes/db2.class.php";
include 'functions.php';

if(isset($_POST['optradio']) && $_POST['optradio'] == 'ip-v4'){
    if(validate_ip_address($_POST['market'], 'ip-v4', $_POST['from_ipv4'], $_POST['to_ipv4'])){
        $post_arr = array('market' => $_POST['market'], 'fromipvfour' => $_POST['from_ipv4'], 'toipvfour' => $_POST['to_ipv4'], 'fromipvsix' => '', 'toipvsix' => '' );
        insert_ipaddrmgmt_record($post_arr);
    }
}else{
    if(validate_ip_address($_POST['market'], 'ip-v6', $_POST['from_ipv6'], $_POST['to_ipv6'])){
        $post_arr = array('market' => $_POST['market'], 'fromipvfour' => '', 'toipvfour' => '', 'fromipvsix' => $_POST['from_ipv6'], 'toipvsix' => $_POST['to_ipv6'] );
        insert_ipaddrmgmt_record($post_arr);
    }
}
header("Location:sheet7_cellsitetech_user_devicelist.php");

/*
 * Validating IP in use for other markets
 */
function validate_ip_address($market, $type, $low_ip, $high_ip){
    $ipaddrmgtlist = getIpAddrMgmtList();
    foreach ($ipaddrmgtlist['result'] as $key => $val){
        if($market != $val['market']){
            if(!empty($val['fromipvfour']) && !empty($val['toipvfour'])){
                if ($low_ip <= $val['toipvfour'] && $val['fromipvfour'] <= $low_ip) {
                    $err_flag = true;
                }elseif ($high_ip <= $val['toipvfour'] && $val['fromipvfour'] <= $high_ip){
                    $err_flag = true;
                }
            }elseif (!empty($val['fromipvsix']) && !empty($val['toipvsix'])){
                if ($low_ip <= $val['toipvsix'] && $val['fromipvsix'] <= $low_ip) {
                    $err_flag = true;
                }elseif ($high_ip <= $val['toipvsix'] && $val['fromipvsix'] <= $high_ip){
                    $err_flag = true;
                }
            }
            if($err_flag){
                $_SESSION['ip_err'] = array('market' => $val['market'], 'type' => 'ip-err');
                header("Location:sheet7_cellsitetech_user_devicelist.php");
                return false;
            }
        }else{
            $_SESSION['ip_err'] = array('market' => $val['market'], 'type' => 'market-exist');
            header("Location:sheet7_cellsitetech_user_devicelist.php");
            return false;
        }
    }
    return true;
}
?>