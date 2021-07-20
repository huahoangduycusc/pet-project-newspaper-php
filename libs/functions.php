<?php
if(!defined('IN_SITE')) die('The request not found');
// get user
function db_user_get_by_username($username){
    $username = htmlspecialchars($username);
    $sql = "SELECT `id`,`username`,`password` FROM `account` WHERE `username` = '{$username}' LIMIT 1";
    return db_get_row($sql);
}
// function check ban user
function db_ban_user($id){
    $sql = "SELECT `ban_time`,`ban_message` FROM `account_ban` WHERE `ban_user` = '{$id}' ORDER BY `ban_id` DESC LIMIT 1";
    $row = db_get_row($sql);
    return $row;
}
// get email
function db_get_email($email){
    $sql = "SELECT count(id) as counter FROM account WHERE email='$email'";
    $row = db_get_row($sql);
    if($row['counter'] > 0){
        return '1';
    }
    return '0';
}
//// thoigian forum ////
function thoigian($from, $to = '') {
    if (empty($to))
    $to = time();
    $diff = (int) abs($to - $from);
    if ($diff <= 60) {
    $since = sprintf('To go 0 giây');
    } elseif ($diff <= 3600) {
    $mins = round($diff / 60);
    if ($mins <= 1) {
    $mins = 1;
    }
    $since = sprintf('%s phút', $mins);
    } else if (($diff <= 86400) && ($diff > 3600)) {
    $hours = round($diff / 3600);
    if ($hours <= 1) {
    $hours = 1;
    }
    $since = sprintf('%s giờ', $hours);
    } elseif (($diff >= 86400) && ($diff < 604800)){
    $days = round($diff / 86400);
    if ($days <= 1) {
    $days = 1;
    }
    $since = sprintf('%s ngày', $days);
    }
    elseif (($diff >= 604800) && ($diff < 2592000)) {
    $tuans = round($diff / 604800);
    if ($tuans <= 1) {
    $tuans = 1;
    }
    $since = sprintf('%s tuần', $tuans);
    }
    elseif (($diff >= 2592000) && ($diff < 31092000)) {
    $tuanss = round($diff / 2592000);
    if ($tuanss <= 1) {
    $tuanss = 1;
    }
    $since = sprintf('%s tháng', $tuanss);
    }
    elseif (($diff >= 31092000) && ($diff < 31092000000000)) {
    $tuansss = round($diff / 31092000);
    if ($tuansss <= 1) {
    $tuansss = 1;
    }
    $since = sprintf('%s năm', $tuansss);
    }
    return $since;
}
    //// het code ///
?>