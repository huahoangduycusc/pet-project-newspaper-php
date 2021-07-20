<?php
define('IN_SITE',true);
require_once('../libs/core.php');
if($rights < 1){
    redirect(homeurl());
}

// get module and action on url
$m = input_get('m'); // modules
$a = input_get('a'); // action
// neu khong truyen action va module
// thi set mac dinh duong dan den trang
// quan ly mac dinh
if(!$m || !$a){
    $m = "common";
    $a = "dashbroad";
}
require_once('widgets/header.php');
// tao duong dan va luu vao bien path
$path = 'modules/'.$m.'/'.$a.'.php';
if(file_exists($path)){
    include($path);
}
else{
    include('modules/common/404.php');
}
require_once('widgets/footer.php');
?>