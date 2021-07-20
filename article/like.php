<?php
sleep(1);
define('IN_SITE',true);
require_once('../libs/core.php');
if(!$user_id){
    die();
}
$aid = input_get('aid');
$uid = input_get('uid');
$emoji = input_get('emoji');
$result = array();
if($aid && $uid && $emoji){
    $sql = "SELECT `article_id` FROM `article` WHERE `article_id` = '$aid' LIMIT 1";
    $row = db_get_row($sql);
    if($row){
        $checkLike = "SELECT * FROM `article_like` WHERE `article_id` = '$aid' AND `user_id` = '$uid' LIMIT 1";
        $row2 = db_get_row($checkLike);
        if($row2){
            if($row2['emoji'] == $emoji){
                $old = "DELETE FROM `article_like` WHERE `like_id` = '".$row2['like_id']."'";
                db_execute($old);
            }
            else{
                $old = "DELETE FROM `article_like` WHERE `like_id` = '".$row2['like_id']."'";
                db_execute($old);
                $table = 'article_like';
                $data = array(
                    'like_id' => null,
                    'article_id' => $aid,
                    'user_id' => $user_id,
                    'emoji' => $emoji
                );
                db_insert($table,$data);
            }
        }
        else{
            $table = 'article_like';
            $data = array(
                'like_id' => null,
                'article_id' => $aid,
                'user_id' => $user_id,
                'emoji' => $emoji
            );
            db_insert($table,$data);
        }
        // return number reaction
        $heart = db_get_row("SELECT COUNT(`like_id`) as counter FROM `article_like` WHERE `emoji` = 'heart' AND `article_id` = '$aid'");
        $smile = db_get_row("SELECT COUNT(`like_id`) as counter FROM `article_like` WHERE `emoji` = 'smile' AND `article_id` = '$aid'");
        $angry = db_get_row("SELECT COUNT(`like_id`) as counter FROM `article_like` WHERE `emoji` = 'angry' AND `article_id` = '$aid'");
        $cry = db_get_row("SELECT COUNT(`like_id`) as counter FROM `article_like` WHERE `emoji` = 'cry' AND `article_id` = '$aid'");
        $scared = db_get_row("SELECT COUNT(`like_id`) as counter FROM `article_like` WHERE `emoji` = 'scared' AND `article_id` = '$aid'");
        $result['heart'] = $heart['counter'];
        $result['smile'] = $smile['counter'];
        $result['angry'] = $angry['counter'];
        $result['cry'] = $cry['counter'];
        $result['scared'] = $scared['counter'];
    }
    else{
        die(json_encode($result));
    }

}
else{
    die(json_encode($result));
}
die(json_encode($result));
?>