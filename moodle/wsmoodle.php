<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Moodle class to consume moodle web service api.                												  //
// Implemented methods:                                          												 //
// getUserById($user_id)                                            											//
// getUserCourses($user_id)                             	   												   //
// getCalendar($event_ids,$group_ids,$course_ids) 			  												  //
// createUser($username,$password,$firstname,$lastname,$email,$auth)                       					 // 
//                                           																// 
//                         								   												   // 
//                                 						  												  // 
//            											 												 //
//////////////////////////////////////////////////////////////////////////////////////////////////////////
class WSMoodle{
	var $token = null;
	var $domain = null;
	var $error = null;

function init($fields) {
    $this->token = $fields['token'];
    $this->domain = $fields['domain'];

  }

  //Return an user filtered by user id
  function getUserById($user_id){
  	$params = array('userids' => array($user_id));

	$functionname = 'core_user_get_users_by_id';

	/// REST CALL
	$restformat = 'json';
	
	$serverurl = $this->domain . '/webservice/rest/server.php'. '?wstoken=' . $this->token . '&wsfunction='.$functionname;

	require_once('./curl.php');

	$curl = new curl;

	$restformat = ($restformat == 'json')?'&moodlewsrestformat=' . $restformat:'';

	$resp = $curl->post($serverurl . $restformat, $params);

	$arr = json_decode($resp,TRUE);
	if(!is_array($arr) || !is_array($arr[0]) || !array_key_exists('id', $arr[0])){

		$this->error = "User ID ". $user_id . " nao encontrado. Certifique-se de que o user_id informado esta correto e que o moodle esta configurado para uso do Web Service";
		return false;		
	}else{

		return $arr;
	}

	
  }

  //Return courses of an user filtered by user id
  function getUserCourses($user_id){
  	$params = array('userid'=>$user_id);
	$functionname = 'core_enrol_get_users_courses';

	/// REST CALL
	$restformat = 'json';

	$serverurl = $this->domain . '/webservice/rest/server.php'. '?wstoken=' . $this->token . '&wsfunction='.$functionname;

	require_once('./curl.php');

	$curl = new curl;

	$restformat = ($restformat == 'json')?'&moodlewsrestformat=' . $restformat:'';

	$resp = $curl->post($serverurl . $restformat, $params);

	$arr = json_decode($resp,TRUE);
	if(!is_array($arr) || !is_array($arr[0]) || !array_key_exists('id', $arr[0])){

		$this->error = "User ID ". $user_id . " nao encontrado. Certifique-se de que o user_id informado esta correto e que o moodle esta configurado para uso do Web Service";
		return false;		
	}else{

		return $arr;
	}

	
  }

  //Return calendar events filtered by id and course id
  function getCalendar($event_ids,$group_ids,$course_ids){
  	$params = array('events'=>array('eventids'=>$event_ids, 'courseids'=>$course_ids, 'groupids'=>$group_ids));
	$functionname = 'core_calendar_get_calendar_events';

	/// REST CALL
	$restformat = 'json';

	$serverurl = $this->domain . '/webservice/rest/server.php'. '?wstoken=' . $this->token . '&wsfunction='.$functionname;

	require_once('./curl.php');

	$curl = new curl;

	$restformat = ($restformat == 'json')?'&moodlewsrestformat=' . $restformat:'';

	$resp = $curl->post($serverurl . $restformat, $params);

	$arr = json_decode($resp,TRUE);

	$count = 0;
	$arrayOut = array();
	foreach($arr['events'] as $event) {
		if(in_array($event['courseid'],$course_ids)){

			array_push($arrayOut,$event);

		}else{

		}
	}
	if($arrayOut[0]==null){
		$this->error = "Event ID ". $event_ids . " nao encontrado. Certifique-se de que o event_id informado esta correto e que o moodle esta configurado para uso do Web Service";
		return false;
	}else{
	return $arrayOut;
	}
  }


  //Create new user on moodle database, it returns new user id and username
  function createUser($username,$password,$firstname,$lastname,$email,$auth){
	$user = new stdClass();
	$user->username = $username;
	$user->password =  $password;
	$user->firstname = $firstname;
	$user->lastname = $lastname;
	$user->email = $email;
	$user->city = "";
	$user->country = "";
	$user->auth = 'manual';
	$params = array('users'=>array($user));
	$functionname = 'core_user_create_users';

	/// REST CALL
	$restformat = 'json';

	$serverurl = $this->domain . '/webservice/rest/server.php'. '?wstoken=' . $this->token . '&wsfunction='.$functionname;

	require_once('./curl.php');

	$curl = new curl;

	$restformat = ($restformat == 'json')?'&moodlewsrestformat=' . $restformat:'';

	$resp = $curl->post($serverurl . $restformat, $params);
	

	$arr = json_decode($resp,TRUE);

	if(!is_array($arr) || !is_array($arr[0]) || !array_key_exists('id', $arr[0])){
		$this->error = "Usuario nao criado. Certifique-se de que os dados informados estao corretos e que o moodle esta configurado para uso do Web Service. ";
		$this->error .="Codigo retornado -> ".$arr['debuginfo'] ;
		return false;
	}else{
		return $arr;
	}

  }


  //Return an user filtered by user id
  function getForum($course_id){
  	//$params = array('userids' => array($user_id));
  	$params = array('course_id'=>$course_id);
	$functionname = 'mod_forum_get_forums_by_courses';

	/// REST CALL
	$restformat = 'json';
	
	$serverurl = $this->domain . '/webservice/rest/server.php'. '?wstoken=' . $this->token . '&wsfunction='.$functionname;

	require_once('./curl.php');

	$curl = new curl;

	$restformat = ($restformat == 'json')?'&moodlewsrestformat=' . $restformat:'';

	$resp = $curl->post($serverurl . $restformat, $params);

	$arr = json_decode($resp,TRUE);
	if(!is_array($arr) || !is_array($arr[0]) || !array_key_exists('id', $arr[0])){

		$this->error = "User ID ". $user_id . " nao encontrado. Certifique-se de que o user_id informado esta correto e que o moodle esta configurado para uso do Web Service";
		return false;		
	}else{

		return $arr;
	}

	
  }



}