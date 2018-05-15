<?php

$host = "192.168.1.107";
$port = 10000;
//$ip_address = gethostbyname("www.google.com");
//echo $ip_address;
$var = array(
    'unit_id' => '9',
    'license_no' => 'xxxx11111aaaaa',
    'status' => '1',
    'cert_cd' => '2',
);
$var_ser = json_encode($var);

$message = $var_ser;

// create socket
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Could not create socket\n");
// connect to server
$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");
// send string to server
socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
// get server response
while (true) {
    $result = socket_read($socket, 1024) or die("Success\n");

    echo "Reply From Server  :" . $result . "\n\r";
}

// close socket
//socket_close($socket);
