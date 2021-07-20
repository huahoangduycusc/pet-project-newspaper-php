<?php
class Comment{
    // get list
    static function getList(){
        global $start;
        global $limit;
        $sql = "SELECT `cmt_id`,`message`,c.`created_at`,c.`article_id`,a.`article_name`,c.`user_id`,`report`
        FROM `comment` c JOIN `article` a ON c.`article_id` = a.`article_id` ORDER BY `cmt_id` DESC LIMIT $start,$limit";
        return db_get_list($sql);
    }
    // get list comment report
    static function getListReport(){
        global $start;
        global $limit;
        $sql = "SELECT `cmt_id`,`message`,c.`created_at`,c.`article_id`,a.`article_name`,c.`user_id`,`report`
        FROM `comment` c JOIN `article` a ON c.`article_id` = a.`article_id` 
        WHERE `report` > 0 
        ORDER BY `report` DESC LIMIT $start,$limit";
        return db_get_list($sql);
    }
    // delete comment
    static function delete($id){
        $id = abs(intval($id));
        $sql = "DELETE FROM `comment` WHERE `cmt_id` = '{$id}'";
        return db_execute($sql);
    }
}
?>