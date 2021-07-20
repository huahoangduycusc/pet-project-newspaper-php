<?php
define('IN_SITE','TRUE');
$rootpath = '';
require_once('libs/core.php');
$result = array();
$email = input_post('email');
$title = input_post('title');
$message = input_post('message');
if($email && $title && $message){
    $config = [
        'email' => $email,
        'title' => $title,
        'message' => $message
    ];
    if(Feedback::send($config)){
        $result['msg'] = "success";
    }
}
else{
    $result['msg'] = "error";
}
die(json_encode($result));
?>