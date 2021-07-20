<?php
class Follow{
    // check follow
    static function checkIsFollow($id){
        global $user_id;
        $id = Generic::secure($id);
        $int = abs(intval($id));
        $sql = "SELECT `follow_id` FROM `account_follow` WHERE 
        `follow_from` = '{$user_id}' AND `follow_to` = '{$id}' LIMIT 1";
        return db_get_row($sql);
    }
    // create new follow
    static function createFollow($id){
        global $user_id;
        $table = "account_follow";
        $data = array(
            'follow_from' => $user_id,
            'follow_to' => $id
        );
        if(self::checkIsFollow($id)){
            $sql = "DELETE FROM `{$table}` WHERE `follow_from` = '{$user_id}' AND `follow_to` = '{$id}'";
            return db_execute($sql);
        }
        else{
            return db_insert($table,$data);
        }
    }
    // get user follow me
    static function getListFollow(){
        global $user_id;
        $sql = "SELECT `follow_from` FROM `account_follow` WHERE `follow_to` = '{$user_id}'";
        return db_get_list($sql);
    }

}
?>