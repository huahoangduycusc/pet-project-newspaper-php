<?php
error_reporting(0);
define('IN_SITE',true);
require_once('../libs/core.php');
if(!$user_id){
    redirect(homeurl());
}
$account = new account($id);
if($account->flag == true){
    Follow::createFollow($account->id);
}
redirect($homeurl."user/?id=$id");
?>