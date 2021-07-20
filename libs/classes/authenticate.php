<?php
class authenticate{
    public static $user_id = false;
    public static $get_user = array();
    public static $rights = false;

    function __construct(){
        $this->authorize();
    }
    // login
    private function authorize(){
        $user_id = false;
        if(isset($_SESSION['uid'])){
            $user_id = $_SESSION['uid'];
        }
        if($user_id){
            $sql = "SELECT * FROM `account` WHERE `id` = '$user_id' LIMIT 1";
            if(db_get_row($sql)){
                $row = db_get_row($sql);
                self::$user_id = $row['id'];
                self::$get_user = $row;
                self::$rights = $row['role'];
            }
        }
        else{
            $this->user_unset();
        }
    }
    // unset
    private function user_unset(){
        self::$user_id = false;
        self::$get_user = false;
        self::$rights = false;
        unset($_SESSION['uid']);
    }
}
?>