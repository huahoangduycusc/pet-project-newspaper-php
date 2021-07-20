<?php
define('IN_SITE',true);
$rootpath = '';
require_once('libs/core.php');
echo date("Y-m-d");
echo "<br/>";
$date = date("Y-m-d",strtotime('-7 days'));
echo $date;
?>