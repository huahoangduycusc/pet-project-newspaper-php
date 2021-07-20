<?php
class Notification{
    static function createNoti($id){
        global $datauser;
        $message = "<a href='".Article::rewriteUrl($id)."'>".$datauser['nickname']." vừa đăng 1 bài viết mới</a>";
        $table = "notifications";
        $ppFollow = Follow::getListFollow();
        foreach($ppFollow as $row){
            $data = array(
                'noti_user' => $row['follow_from'],
                'noti_msg' => $message,
                'noti_date' => time()
            );
            return db_insert($table,$data);
        }
    }
    // my noti
    static function getMyNoti(){
        global $user_id;
        global $start;
        global $limit;
        $sql = "SELECT `noti_msg`,`noti_date`,`noti_seen` FROM `notifications`
        WHERE `noti_user` = '{$user_id}'
        ORDER BY `noti_id` DESC LIMIT $start,$limit";
        $rows = db_get_list($sql);
        return $rows;
    }

    // check my noti
    static function checkMynoti(){
        global $user_id;
        $table = "notifications";
        db_update($table,array('noti_seen' => 1),array('noti_user' => $user_id));
    }
}
?>