<?php
$rootpath = '';
define('IN_SITE',true);
require_once('libs/core.php');
session_delete($_SESSION['uid']);
session_destroy();
redirect(homeurl());
?>