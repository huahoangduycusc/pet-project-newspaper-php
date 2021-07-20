<?php
class account{
    public $id;
    public $username;
    public $fullname;
    public $nickname;
    public $birthday;
    public $address;
    public $email;
    public $post;
    public $favourite;
    public $gender;
    public $avatar;
    public $phone;
    public $timeJoin;
    public $flag = false;
    public $rights;
    public $cmt = 0;
    // constructor
    function __construct($ids){
        $this->id = $ids;
        $this->getInfo();
        $this->countComment();
    }
    // get list
    static function getList(){
        global $start;
        global $limit;
        $sql = "SELECT `id`,`username`,`email`,`fullname`,`gender`,`birthday`,`role`,`avatar` FROM `account`
        ORDER BY `id` DESC LIMIT $start,$limit";
        $rows = db_get_list($sql);
        return $rows;
    }
    // return name of user
    static function getName($id){
        $sql = "SELECT `nickname` FROM `account` WHERE `id` = '{$id}' LIMIT 1";
        $row = db_get_row($sql);
        if($row){
            return $row['nickname'];
        }
        else{
            return "N/A";
        }
    }
    // get information of user
    private function getInfo(){
        $sql = "SELECT `id`,`username`,`email`,`fullname`,`gender`,`birthday`,`role`,`avatar`,`address`,`post`,`favourite`,`nickname`,
        `timeJoin`,`phone` 
        FROM `account` WHERE `id` = '".$this->id."' LIMIT 1";
        $row = db_get_row($sql);
        if($row){
            $this->username = $row['username'];
            $this->fullname = $row['fullname'];
            $this->birthday = $row['birthday'];
            $this->address = $row['address'];
            $this->avatar = $row['avatar'];
            $this->post = $row['post'];
            $this->favourite = $row['favourite'];
            $this->nickname = $row['nickname'];
            $this->email = $row['email'];
            $this->flag = true;
            $this->timeJoin = $row['timeJoin'];
            $this->rights = $row['role'];
            if($row['gender'] == 0)
            {
                $this->gender = "Nam";
            }
            else{
                $this->gender = "Nữ";
            }
            $this->phone = $row['phone'];
        }
    }
    // comment of user
    private function countComment(){
        $sql = "SELECT COUNT(`user_id`) as counter FROM `comment` WHERE `user_id` = '".$this->id."' LIMIT 1";
        $row = db_get_row($sql);
        if($row){
            $this->cmt = $row['counter'];
        }
    }
    // get comment of user
    public function getComments(){
        $sql = "SELECT `message`,a.`created_at`,a.`article_id`,a.`user_id`,b.`article_name` 
        FROM `comment` a JOIN `article` b
        ON a.`article_id` = b.`article_id`
        WHERE a.`user_id` = '".$this->id."'
        ORDER BY `cmt_id` DESC LIMIT 5";
        $rows = db_get_list($sql);
        if($rows){
            return $rows;
        }
        else{
            return false;
        }
    }
    public static function nameRole($role){
        $out = '';
        if ($role == 9)
        {
            $out = '<b style="color:#FF5159;font-size:11pt">Admin</b>';
        }
        else if ($role == 3)
        {
            $out ='<b style="color:green;font-size:11pt">Tổng biên tập</b>';
        }
        else if ($role == 1)
        {
            $out = '<b style="color:DarkOrchid;font-size:11pt">Nhà báo</b>';
        }
        else if ($role == 2)
        {
            $out = '<b style="color:#EA9415;font-size:11pt">Cộng tác viên</b>';
        }
        else if($role == 0)
        {
            $out = '<b style="color:#013481;font-size:11pt">Thành viên</b>';
        }
        return $out;
            
    }
    // role
    public static function role($id){
        $out = '';
        $id = abs(intval($id));
        $sql = "SELECT `role`,`nickname` FROM `account` WHERE `id` = '{$id}' LIMIT 1";
        $row = db_get_row($sql);
        if($row){
            if ($row['role'] == 9)
            {
                $out = '<b style="color:#FF5159;font-size:11pt">'.$row['nickname'].' - Admin</b>';
            }
            else if ($row['role'] == 3)
            {
                $out ='<b style="color:green;font-size:11pt">'.$row['nickname'].' - Tổng biên tập</b>';
            }
            else if ($row['role'] == 1)
            {
                $out = '<b style="color:DarkOrchid;font-size:11pt">'.$row['nickname'].' - Nhà báo</b>';
            }
            else if ($row['role'] == 2)
            {
                $out = '<b style="color:#EA9415;font-size:11pt">'.$row['nickname'].' - Cộng tác viên</b>';
            }
            else if($row['role'] == 0)
            {
                $out = '<b style="color:#013481;font-size:11pt">'.$row['nickname'].'</b>';
            }
        }
        return $out;
    }
    // avatar
    public function getAvatar(){
        $out = '';
        $sql = "SELECT `avatar` FROM `account` WHERE `id` = '".$this->id."' LIMIT 1";
        $row = db_get_row($sql);
        if($row){
            $out = homeurl().$row['avatar'];
        }
        return $out;
    }
    /// link to accont details
    public static function urlAccount($id){
        global $homeurl;
        $out = $homeurl."user/?id=$id";
        return $out;
    }
    // gender
    static function gender($type){
        if($type == 0)
        {
            return "Nam";
        }
        else{
            return "Nữ";
        }
    }
    // change password
    static function changePassword($old_pass,$new_pass){
        global $user_id;
        $table = "account";
        $filter = array('id' => $user_id);
        $newpass = password_hash($new_pass,PASSWORD_DEFAULT);
        $sql = "SELECT `password` FROM `account` WHERE `id` = '{$user_id}' LIMIT 1";
        $row = db_get_row($sql);
        if(password_verify($old_pass,$row['password']) == true){
            $data = array('password' => $newpass);
            return db_update($table,$data,$filter);
        }
        return false;
    }

    // block account
    static function ban($id,$lydo,$times,$type = 1){
        global $user_id;
        $table = "account_ban";
        if($type == 1){
            $times = ($times*3600*24)+time();
        }
        else if($type == 2){
            $times = ($times*3600*24*30)+time();
        }
        else if($type == 3){
            $times = ($times*3600*24*365)+time();
        }
        $data = array(
            'ban_user' => $id,
            'ban_time' => $times,
            'ban_author' => $user_id,
            'ban_message' => $lydo
        );
        return db_insert($table,$data);
    }

    // search account
    static function searchAccount($name){
        $name = Generic::secure($name);
        global $start;
        global $limit;
        $sql = "SELECT `id`,`username`,`email`,`fullname`,`gender`,`birthday`,`role`,`avatar` FROM `account`
        WHERE `username` LIKE '%$name%' OR `fullname` LIKE '%$name%'
        ORDER BY `id` DESC LIMIT $start,$limit";
        $rows = db_get_list($sql);
        return $rows;
    }
    
    // list account ban
    static function getListBan(){
        global $start;
        global $limit;
        $sql = "SELECT `ban_user`,`ban_time`,`ban_author`,`ban_message` FROM `account_ban`
        ORDER BY `ban_id` DESC LIMIT $start,$limit";
        return db_get_list($sql);
    }

    // check if account has article
    static function hasArticle($id){
        $count = db_count('article','article_id',array('user_id' => $id));
        return $count;
    }

    // delete
    static function delete($id){
        $sql = "DELETE FROM `account` WHERE `id` = '{$id}'";
        if(self::hasArticle($id) > 0){
            return false;
        }
        return db_execute($sql);
    }
}
// end class
?>