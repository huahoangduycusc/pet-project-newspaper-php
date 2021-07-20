<?php
class Mail{
    // create contact
    static function create($id,$msg){
        global $user_id;
        $data = array(
            'from_user' => $user_id,
            'to_user' => $id,
            'content' => $msg,
            'created_at' => time(),
            'seen' => 0
        );
        return db_insert('message',$data);
    }

    // get list message
    static function getListMessage($to_user){
        global $user_id;
        global $start;
        global $limit;
        $sql = "SELECT `from_user`, `to_user`, `content`, `created_at`, a.`avatar` FROM `message` m
        LEFT JOIN `account` a ON m.`from_user` = a.`id`
        WHERE `from_user` = '{$user_id}' AND `to_user` = '{$to_user}' OR `to_user` = '{$user_id}' AND `from_user` = '{$to_user}'
        ORDER BY `msg_id` DESC LIMIT $start,$limit";
        return db_get_list($sql);
    }

    // get list contact
    static function getListContact(){
        global $user_id;
        $sql = "SELECT `msg_id`,`to_user`,`from_user`,`content`,`created_at` FROM `message`
        WHERE (`from_user` = '{$user_id}' OR `to_user` = '{$user_id}')
        AND `msg_id` IN (
            SELECT MAX(msg_id)
            FROM message
            GROUP BY LEAST(`to_user`,`from_user`), GREATEST(from_user, to_user))
        GROUP BY LEAST(`to_user`,`from_user`), GREATEST(from_user, to_user)
        ORDER BY `msg_id` DESC";
        return db_get_list($sql);
    }

    // count message contact not seen
    static function countNoseen($to_user){
        global $user_id;
        $sql = "SELECT COUNT(`msg_id`) as 'count' FROM `message`
        WHERE `from_user` = '{$to_user}' AND `to_user` = '{$user_id}' AND `seen` = '0'";
        $row = db_get_row($sql);
        return $row['count'];
    }

    // see mail
    static function seeMail($from_user){
        global $user_id;
        return db_update('message',array('seen' => 1),array('from_user' => $from_user,'to_user' => $user_id));
    }

    // message to me

    static function myMesssage(){
        global $user_id;
        return db_count('message','msg_id',array('to_user' => $user_id,'seen' => '0'));
    }

    // delete message contact
    static function delete($id){
        global $user_id;
        $sql = "DELETE FROM `message` WHERE (`from_user` = '{$user_id}' AND `to_user` = '{$id}') 
        OR (`to_user` = '{$user_id}' AND `from_user` = '{$id}')";
        return db_execute($sql);
    }
}
?>