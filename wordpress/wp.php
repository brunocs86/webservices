<?php 
class XMLRPClientWordPress{
    var $XMLRPCURL = "";
    var $UserName  = "";
    var $PassWord = "";
   

// Constructor
public function __construct($xmlrpcurl, $username, $password)
{
    $this->XMLRPCURL = $xmlrpcurl;
    $this->username  = $username;
    $this->password = $password;
}


function send_request($requestname, $params)
{
    $request = xmlrpc_encode_request($requestname, $params);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
    curl_setopt($ch, CURLOPT_URL, $this->XMLRPCURL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1);
    $results = curl_exec($ch);
    curl_close($ch);
    return $results;
}


	function sayHello(){
    $params = array();
    return $this->send_request('demo.sayHello',$params);
	}

	function getPost($post_id){
    $params = array(1,$this->username,$this->password,$post_id);
    return $this->send_request('wp.getPost',$params);
	}

    function createPost(){
     $params = array(1,$this->username,$this->password,array("post_title"=>"Bla","post_type"=>"post","post_status"=>"publish","post_name"=>"aula-de-speedup-ppd","post_content"=>"Conteudo"));   
      return $this->send_request('wp.newPost',$params);
    }
   }

  ?>