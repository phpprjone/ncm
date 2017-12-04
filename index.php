<?php 
echo time();
$ip = ip2long('192.168.1.15');
$low_ip = ip2long('192.168.1.10');
$high_ip = ip2long('192.168.1.100');


if ($ip <= $high_ip && $low_ip <= $ip) {
    echo "in range";
}
echo '<br>'.time();
?>