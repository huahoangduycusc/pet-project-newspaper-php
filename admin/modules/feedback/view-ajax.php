<?php
define('IN_SITE',true);
$rootpath = "../../../";
require_once('../../../libs/core.php');
$result = array();
if(Feedback::getRow($id)){
    $result = Feedback::getRow($id);
    $result['message'] = nl2br($result['message']);
}
die(json_encode($result));
?>