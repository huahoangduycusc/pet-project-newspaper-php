<?php
class Category{
    public $categoryId;
    public $categoryName;
    public $status;
    public $flag = false;
    public $count; // count article in this category
    function __construct($id){
        $this->categoryId = $id;
        $this->getInfo();
        $this->countArticles();
    }
    // get info about category
    public function getInfo(){
        $sql = "SELECT `categoryId`, `categoryName`,`status` FROM `category` WHERE `categoryId` = '".$this->categoryId."' LIMIT 1";
        $row = db_get_row($sql);
        // if there is or are rows
        if($row){
            $this->categoryId = $row['categoryId'];
            $this->categoryName = $row['categoryName'];
            $this->status = $row['status'];
            $this->flag = true;
        }
        // else
        else{
            $this->flag = false;
        }
    }
    // count article
    public function countArticles(){
        $sql = "SELECT COUNT(`article_id`) as counter FROM `article` WHERE `category_id` = '".$this->categoryId."' AND `status` = '1'";
        $row = db_get_row($sql);
        if($row){
            $this->count = $row['counter'];
        }
    }
    // get list of category
    public static function getList($type = 0){
        global $limit;
        global $start;
        $sql = "";
        if($type == 0){
            $sql = "SELECT `categoryId`, `categoryName`,`status` FROM `category` ORDER BY `categoryId` desc limit $limit";
        }
        else{
            $sql = "SELECT `categoryId`, `categoryName`,`status` FROM `category` WHERE `status` = '0' ORDER BY `categoryId` desc limit $limit";
        }
        $rows = db_get_list($sql);
        return $rows;
    }
    // get article of category
    public function getArticles(){
        global $limit;
        $sql = "SELECT `article_id`,`article_name`,`thumbnail`,`created_at` FROM `article` WHERE `category_id` = '".$this->categoryId."' AND `status` = '1' ORDER BY `article_id` DESC LIMIT $limit";
        $rows = db_get_list($sql);
        return $rows;
    }
    // delete category
    public static function delete($id){
        $exist = "SELECT `categoryId` FROM `category` WHERE `categoryId` = '{$id}'";
        $row = db_get_row($exist);
        if($row){
            $countArticle = db_count('article','article_id',array('category_id' => $id));
            if($countArticle == 0){
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
        else{
            return false;
        }
    }
    // url category
    static function rewriteUrl($id_cate){
        $out = '';
        $sql = "SELECT `categoryId`,`categoryName` FROM `category` WHERE `categoryId` = '{$id_cate}' LIMIT 1";
        $row = db_get_row($sql);
        if($row){
            $out .= homeurl().'category/index.php?id='.$row['categoryId'];
        }
        return $out;
    }
    
}
?>