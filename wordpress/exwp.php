<?php

	function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string ($d)) {
        return utf8_encode($d);
    }
    return $d;
	}

	require_once('wp.php');
	$objXMLRPClientWordPress = new XMLRPClientWordPress("wordpress" ,"user","pass");

	$resp = $objXMLRPClientWordPress->createPost();
	$arr = xmlrpc_decode($resp);
	//echo $arr['post_id'];
	//echo $resp;
	$json = json_encode(utf8ize($arr),JSON_PRETTY_PRINT);
	//var_dump($arr);
	echo $json;
?>