<?php
if(!defined('IN_SITE')) die('Error: restricted access');
date_default_timezone_set('Asia/Ho_Chi_Minh');
// start session
session_start();
$rootpath = isset($rootpath) ? $rootpath : '../';
// title website
$title = 'Trang web tin tức truyền thông âm nhạc số 1 Việt Nam';
// pagination
$page = isset($_GET['page']) ? abs(intval($_GET['page'])) : 1;
$limit = 10;
$start = abs(intval($limit*$page)-$limit);
// include files
include_once('database.php');
include_once('helper.php');
include_once('session.php');
include_once('functions.php');
// autoload class
spl_autoload_register('autoload');
function autoload($name){
    global $rootpath;
    $file = $rootpath.'libs/classes/'.$name.'.php';
    if(file_exists($file)){
        require_once($file);
    }
}
// authorize
$core = new authenticate() or die('Error: Core System');
unset($core);
$user_id = authenticate::$user_id;
$datauser = authenticate::$get_user;
$rights = authenticate::$rights;
?>