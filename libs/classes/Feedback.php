<?php
class Feedback{
    // get row
    static function getRow($id){
        $id = Generic::secure($id);
        $sql = "SELECT`email`,`title`,`created_at`,`message` FROM `feedback` WHERE `fb_id` = '{$id}'";
        $row = db_get_row($sql);
        if($row){
            db_update('feedback',$data = array('seen' => '1'),array('fb_id' => $id));
        }
        return $row;
    }
    // get list
    static function getList($type = 0){
        global $start;
        global $limit;
        $sql = "";
        if($type == 0){
            $sql = "SELECT `fb_id`,`email`,`title`,`created_at`,`seen` FROM `feedback` ORDER BY 
        `fb_id` DESC LIMIT $start,$limit";
        }
        else if($type == 1){
            $sql = "SELECT `fb_id`,`email`,`title`,`created_at`,`seen` FROM `feedback` WHERE `seen` = '0' ORDER BY 
        `fb_id` DESC LIMIT $start,$limit";
        }
        else{
            $sql = "SELECT `fb_id`,`email`,`title`,`created_at`,`seen` FROM `feedback` WHERE `seen` = '1' ORDER BY 
        `fb_id` DESC LIMIT $start,$limit";
        }
        $rows = db_get_list($sql);
        return $rows;
    }
    // send feedback
    static function send($config = []){
        $table = 'feedback';
        $data = array(
            'email' => $config['email'],
            'title' => $config['title'],
            'message' => $config['message'],
            'created_at' => date("Y-m-d H:m:s"),
            'seen' => '0'
        );
        return db_insert($table,$data);
    }
    // delete
    static function delete($id){
        $id = Generic::secure($id);
        $sql = "DELETE FROM `feedback` WHERE `fb_id` = '{$id}'";
        return db_execute($sql);
    }
}
?>