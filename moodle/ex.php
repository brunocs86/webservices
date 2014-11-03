<?php

require_once('wsmoodle.php');

header('Content-Type: application/json');
$token = 'token';
$domain = 'moodle';

$moodle = new WSMoodle();


$fields = array('token'=>$token,'domain'=>$domain);
$moodle->init($fields);


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

$id = 3; // User id in Moodle. 1 for guest user.

$user = $moodle->getUserById($id);

if ($user)
  echo json_encode(utf8ize($user), JSON_PRETTY_PRINT); 

else
  echo $moodle->error; 


?>