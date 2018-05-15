<?php

$url = 'http://localhost/svn/atsmd/new_source/req?class=alv';
$var = array(
    'unit_id' => '11',
    'license_no' => 'no1',
    'status' => '0',
    'cert_cd' => 'Ab@123',
);

/**
 * postDataCurl
 * @param type $post
 * @param type $url
 * @return type
 */
function postDataCurl($post, $url) {
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch,CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

	// execute!
	$response = curl_exec($ch);
	// close the connection, release resources used
	curl_close($ch);

	return $response;
}	

$message = postDataCurl($var, $url);
var_dump($message);
