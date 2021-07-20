<?php
class Blog{
    public $blog_id;
    public $blog_title;
    public $blog_msg;
    public $thumbnail;
    public $status;
    public $user_id;
    public $author;
    public $auPost;
    public $auAvatar;
    public $created_at;
    // constructor
    function __construct($b_id){
        $this->getInfo($b_id);
    }
    // check if blog id is exitsing ?
    static function checkExists($id){
        $sql = "SELECT `blog_id` FROM `blog` WHERE `blog_id` = '{$id}'";
        if(!db_get_row($sql)){
            return false;
        }
        return true;
    }
    // get infomration of blog via blog id
    function getInfo($blog_id){
        $sql = "SELECT `blog_id`, `blog_title`,`blog_msg`,`user_id`,`thumbnail`,
        `blog_status`,`created_at`,a.`nickname`,a.`avatar`,a.`post`
        FROM `blog` b join `account` a
        ON b.`user_id` = a.`id`
        WHERE `blog_id` = '{$blog_id}' LIMIT 1";
        $row = db_get_row($sql);
        if($row){
            $this->blog_id = $row['blog_id'];
            $this->blog_title = $row['blog_title'];
            $this->thumbnail = $row['thumbnail'];
            $this->blog_msg = $row['blog_msg'];
            $this->user_id = $row['user_id'];
            $this->status = $row['blog_status'];
            $this->created_at = $row['created_at'];
            $this->author = $row['nickname'];
            $this->auPost = $row['post'];
            $this->auAvatar = $row['avatar'];
        }
    }
    // get list blog
    static function getList($type = 0, $row = 0){
        global $limit;
        if($type == 0){ // get all
            $sql = "SELECT `blog_id`, `blog_title`,`blog_msg`,`user_id`,`thumbnail`,`created_at`,b.`username`,`blog_status` 
            FROM `blog` a JOIN `account` b
            ON a.`user_id` = b.`id`
            ORDER BY `blog_id` DESC LIMIT ".(($row == 0) ? $limit : $row)."";
        }
        else if($type == 1){ // hiển thị
            $sql = "SELECT `blog_id`, `blog_title`,`blog_msg`,`user_id`,`thumbnail`,`created_at`,b.`username`,`blog_status` 
            FROM `blog` a JOIN `account` b
            ON a.`user_id` = b.`id`
            WHERE `blog_status` = 0
            ORDER BY `blog_id` DESC LIMIT ".(($row == 0) ? $limit : $row)."";
        }
        else{ // hide
            $sql = "SELECT `blog_id`, `blog_title`,`blog_msg`,`user_id`,`thumbnail`,`created_at`,b.`username`,`blog_status` 
            FROM `blog` a JOIN `account` b
            ON a.`user_id` = b.`id`
            WHERE `blog_status` = 1
            ORDER BY `blog_id` DESC LIMIT ".(($row == 0) ? $limit : $row)."";
        }
        $rows = db_get_list($sql);
        return $rows;
    }
    // url blog
    static function rewriteUrl($id_blog){
        $out = '';
        $sql = "SELECT `blog_id`,`blog_title` FROM `blog` WHERE `blog_id` = '{$id_blog}' LIMIT 1";
        $row = db_get_row($sql);
        if($row){
            $out .= homeurl().'blog/view.php?id='.$row['blog_id'];
        }
        return $out;
    }
    // delete article
    public static function delete($id){
        $exist = "SELECT `blog_id` FROM `blog` WHERE `blog_id` = '{$id}'";
        $row = db_get_row($exist);
        if($row){
            $sql = "DELETE FROM `blog` WHERE `blog_id` = '{$id}'";
            if(db_execute($sql)){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
    // count blog
    public static function countPost($type = 0){
        $count = 0;
        if($type == 0){
            $count = db_count('blog','blog_id');
        }
        else if($type == 1){
            // hiển thị
            $count = db_count('blog','blog_id',array('blog_status' => '0'));
        }
        else if($type ==2){
            // ẩn
            $count = db_count('blog','blog_id',array('blog_status' => '1'));
        }
        return $count;
    }

}
?>