<?php
error_reporting(0);
define('IN_SITE',true);
require_once('../libs/core.php');
$result = array();
if(!$user_id && $right < 9){
    $result['data'] = "error";
}
else{
    $duser = input_post('user');
    $dlydo = input_post('lydo');
    $ddate = input_post('date');
    $type = input_post('type');
    if($duser && $dlydo && $ddate && $type){
        if(account::ban($duser,$dlydo,$ddate,$type)){
            $result['data'] = "success";
        }
        else{
            $result['data'] = "error";
        }
    }
    else{
        $result['data'] = "error";
    }
}
die(json_encode($result));
?>