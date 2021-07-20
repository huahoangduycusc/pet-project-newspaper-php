<?php
class Article{
    public $id;
    public $title;
    public $description;
    public $view;
    public $author;
    public $categoryId;
    public $categoryName;
    public $created_at;
    public $thumbnail;
    public $status;
    public $ghim;
    public $tags;
    public $comment = 0;
    public $heart;
    public $happy;
    public $angry;
    public $cry;
    public $scared;
    public $flag = false; // neu bai viet khong ton tai
    public $react_heart;
    public $react_happy;
    public $react_angry;
    public $react_cry;
    public $react_scared;

    // constructor
    function __construct($id){
        $this->id = $id;
        $this->statistic();
        $this->getInfo();
        $this->getCategory();
        $this->addView();
        $this->reaction();
        $this->countComment();
    }
    // statistic view of new day
    private function statistic(){
        $date = date("Y-m-d");
        $sql = "SELECT `stt_id`,`view` FROM `statistic` WHERE `article_id` = '".$this->id."' AND `created_at` = '$date' LIMIT 1";
        $row = db_get_row($sql);
        if($row){ // neu ton tai
            $sql2 = "UPDATE `statistic` SET `view` = `view` + '1' WHERE `stt_id` = '".$row['stt_id']."' LIMIT 1";
            db_execute($sql2);
        }
        else{ // neu khong
            $table = 'statistic';
            $data = array(
                'stt_id' => null,
                'article_id' => $this->id,
                'view' => 1,
                'created_at' => $date
            );
            db_insert($table,$data);
        }
    }

    // get information of article
    private function getInfo(){
        $sql = "SELECT `article_id`, `article_name`,`description`,`view`,`tags`,`user_id`,`created_at`,`thumbnail`,`category_id`,`status`,`ghim` FROM `article` WHERE `article_id` = '".$this->id."'";
        $row = db_get_row($sql);
        if($row){
            $this->title = $row['article_name'];
            $this->description = $row['description'];
            $this->view = $row['view'];
            $this->author = $row['user_id'];
            $this->created_at = $row['created_at'];
            $this->thumbnail = $row['thumbnail'];
            $this->categoryId = $row['category_id'];
            $this->tags = $row['tags'];
            $this->status = $row['status'];
            $this->ghim = $row['ghim'];
            $this->flag = true;
        }
    }
    // get category of article
    private function getCategory(){
        $sql = "SELECT `categoryName` FROM `category` WHERE `categoryId` = '".$this->categoryId."'";
        $row = db_get_row($sql);
        if($row){
            $this->categoryName = $row['categoryName'];
        }
    }
    // add view 
    private function addView(){
        $sql = "UPDATE `article` SET `view` = `view` + '1' WHERE `article_id` = '".$this->id."' LIMIT 1";
        db_execute($sql);
    }
    // reaction of artilce from viewer
    private function reaction(){
        $heart = db_get_row("SELECT COUNT(`like_id`) as counter FROM `article_like` WHERE `emoji` = 'heart' AND `article_id` = '".$this->id."'");
        $smile = db_get_row("SELECT COUNT(`like_id`) as counter FROM `article_like` WHERE `emoji` = 'smile' AND `article_id` = '".$this->id."'");
        $angry = db_get_row("SELECT COUNT(`like_id`) as counter FROM `article_like` WHERE `emoji` = 'angry' AND `article_id` = '".$this->id."'");
        $cry = db_get_row("SELECT COUNT(`like_id`) as counter FROM `article_like` WHERE `emoji` = 'cry' AND `article_id` = '".$this->id."'");
        $scared = db_get_row("SELECT COUNT(`like_id`) as counter FROM `article_like` WHERE `emoji` = 'scared' AND `article_id` = '".$this->id."'");
        $this->react_heart = $heart['counter'];
        $this->react_happy = $smile['counter'];
        $this->react_angry = $angry['counter'];
        $this->react_cry = $cry['counter'];
        $this->react_scared = $scared['counter'];
    }
    // count comment
    private function countComment(){
        $sql = "SELECT COUNT(`cmt_id`) as counter FROM `comment` WHERE `article_id` = '".$this->id."'";
        $row = db_get_row($sql);
        if($row){
            $this->comment = $row['counter'];
        }
    }
    // latest article
    public static function latestArticle($type = 0){
        global $limit;
        global $start;
        $sql = "";
        if($type == 0){
            $sql = "SELECT `article_id`,`article_name`,`thumbnail`,`created_at`,`view`,b.`categoryName`,a.`status`,c.`username`,c.`id` FROM `article` a 
        join `category` b ON a.`category_id` = b.`categoryId`
        JOIN `account` c ON a.`user_id` = c.`id`
        WHERE a.`status` = '1'
        ORDER BY `article_id` DESC LIMIT $start,$limit";
        }
        else{
            $sql = "SELECT `article_id`,`article_name`,`thumbnail`,`created_at`,`view`,b.`categoryName`,a.`status`,c.`username`,c.`id` FROM `article` a 
        join `category` b ON a.`category_id` = b.`categoryId`
        JOIN `account` c ON a.`user_id` = c.`id`
        ORDER BY `article_id` DESC LIMIT $start,$limit";
        }
        $rows = db_get_list($sql);
        return $rows;
    }
    // most view
    public static function mostView(){
        $date = date("Y-m-d");
        $sql = "SELECT a.`article_id`,`article_name`,`category_id`,`categoryName`,a.`created_at`,`thumbnail`,s.`view` FROM `article` a
        join `category` c on a.`category_id` = c.`categoryId`
        join `statistic` s on a.`article_id` = s.`article_id`
        WHERE s.`created_at` = '$date' AND a.`status` = '1'
        ORDER BY s.`view` DESC LIMIT 8";
        $rows = db_get_list($sql);
        return $rows;
    }
    // spotlight article
    public static function spotlight(){
        $sql = "SELECT a.`article_id`,`article_name`,`category_id`,`categoryName`,a.`created_at`,`thumbnail` FROM `article` a
        join `category` c on a.`category_id` = c.`categoryId`
        WHERE a.`tags` LIKE '%spotlight%' AND a.`status` = '1' ORDER BY a.`created_at` DESC LIMIT 4";
        $rows = db_get_list($sql);
        return $rows;
    }
    // random article
    public function randomArticle(){
        $sql = "SELECT `article_id`,`article_name`,`thumbnail`,`created_at`,`categoryName` FROM `article` a 
        join `category` b ON a.`category_id` = b.`categoryId`
        WHERE a.`status` = '1' AND a.`article_id` != '".$this->id."' ORDER BY rand() LIMIT 4";
        $rows = db_get_list($sql);
        if($rows){
            return $rows;
        }
        else{
            return false;
        }
    }
    // similar article in category
    public function similarArticle(){
        $sql = "SELECT `article_id`,`article_name`,`thumbnail`,`created_at`,`categoryName` FROM `article` a 
        join `category` b ON a.`category_id` = b.`categoryId`
        WHERE a.`category_id` = '".$this->categoryId."' AND a.`article_id` != '".$this->id."'
        AND a.`status` = '1'
        ORDER BY a.`article_id` DESC LIMIT 3";
        $rows = db_get_list($sql);
        if($rows){
            return $rows;
        }
        else{
            return false;
        }
    }
    // pin article
    public static function pin(){
        $sql = "SELECT `article_id`,`article_name`,`thumbnail`,`created_at`,`categoryName` FROM `article` a 
        join `category` b ON a.`category_id` = b.`categoryId`
        WHERE a.`ghim` = '2' AND a.`status` = '1' ORDER BY `article_id` DESC LIMIT 1";
        $row = db_get_row($sql);
        if($row){
            return $row;
        }
        else{
            return false;
        }
    }
    // trending article
    public static function trending(){
        $sql = "SELECT `article_id`,`article_name`,`thumbnail`,`created_at`,`categoryName` FROM `article` a 
        join `category` b ON a.`category_id` = b.`categoryId`
        WHERE a.`ghim` = '1' AND a.`status` = '1' ORDER BY `article_id` DESC LIMIT 4";
        $rows = db_get_list($sql);
        if($rows){
            return $rows;
        }
        else{
            return false;
        }
    }
    // article in tv show category
    public static function tvShow(){
        $sql = "SELECT `article_id`,`article_name`,`thumbnail`,`created_at`,`categoryName` FROM `article` a 
        join `category` b ON a.`category_id` = b.`categoryId`
        WHERE a.`category_id` = '11' ORDER BY `article_id` DESC LIMIT 3";
        $rows = db_get_list($sql);
        if($rows){
            return $rows;
        }
        else{
            return false;
        }
    }
    // author of article
    public function author(){
        $sql = "SELECT `nickname` FROM `account` WHERE `id` = '".$this->author."'";
        $row = db_get_row($sql);
        return $row['nickname'];
    }
    // get comment
    public function getComments(){
        global $limit;
        $sql = "SELECT `cmt_id`,`message`,`created_at`,`user_id` FROM `comment` WHERE `article_id` = '".$this->id."' ORDER BY `cmt_id` DESC LIMIT $limit";
        $rows = db_get_list($sql);
        if($rows){
            return $rows;
        }
        else{
            return false;
        }
    }
    // rewrite url
    public static function rewriteUrl($id){
        $out = '';
        $sql = "SELECT `article_id`,`article_name` FROM `article` WHERE `article_id` = '$id' LIMIT 1";
        $row = db_get_row($sql);
        if($row){
            $out = homeurl().'article/?id='.$row['article_id'];
        }
        return $out;
    }
    // delete article
    public static function delete($id){
        $exist = "SELECT `article_id`,`thumbnail` FROM `article` WHERE `article_id` = '{$id}'";
        $row = db_get_row($exist);
        if($row){
            $sql = "DELETE FROM `article` WHERE `article_id` = '{$id}'";
            $thumb = "../".$row['thumbnail'];
            if(file_exists($thumb))
            {
                unlink('../'.$row['thumbnail']);
            }
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
    // get list of articles most view in week
    public static function mostViewInWeek(){
        $date = date("Y-m-d",strtotime('-7 days'));
        $sql = "SELECT a.`article_id`,`article_name`,`category_id`,`categoryName`,a.`created_at`,`thumbnail`, SUM(s.`view`) as 'view' FROM `article` a
        join `category` c on a.`category_id` = c.`categoryId`
        join `statistic` s on a.`article_id` = s.`article_id`
        WHERE s.`created_at` > '$date' AND a.`status` = '1'
        GROUP BY a.`article_id`
        ORDER BY SUM(s.`view`) DESC LIMIT 5";
        $rows = db_get_list($sql);
        return $rows;
    }
    // get list of article most view in month of current year
    public static function mostViewInMonth(){
        $month = date("m");
        $year = date("Y");
        $sql = "SELECT a.`article_id`,`article_name`,`category_id`,`categoryName`,a.`created_at`,`thumbnail`, SUM(s.`view`) as 'view' FROM `article` a
        join `category` c on a.`category_id` = c.`categoryId`
        join `statistic` s on a.`article_id` = s.`article_id`
        WHERE MONTH(s.`created_at`) = '$month' AND YEAR(s.`created_at`) = '$year' AND a.`status` = '1'
        GROUP BY a.`article_id`
        ORDER BY SUM(s.`view`) DESC LIMIT 5";
        $rows = db_get_list($sql);
        return $rows;
    }
    // search article
    static function searchByTitle($title){
        global $start;
        global $limit;
        $title = Generic::secure($title);
        $sql = "SELECT `article_id`, `article_name`,`view`,`created_at`,`thumbnail`,`category_id` FROM `article` WHERE `article_name` LIKE '%$title%' AND `status` = '1' ORDER BY `article_id` DESC LIMIT $start,$limit";
        return db_get_list($sql);
    }
    
    // count search result
    static function countSearch($title){
        $sql = "SELECT `article_id` FROM `article` 
        WHERE `article_name` LIKE '%$title%'";
        $result = db_count_query($sql);
        return $result;
    }
    // tag of article
    static function tag($tag){
        global $start;
        global $limit;
        $title = Generic::secure($tag);
        $sql = "SELECT `article_id`, `article_name`,`view`,`created_at`,`thumbnail`,`category_id` FROM `article` 
        WHERE `tags` LIKE '%$tag%' ORDER BY `article_id` DESC LIMIT $start,$limit";
        return db_get_list($sql);
    }
    // count tag result
    static function countTag($title){
        $sql = "SELECT `article_id` FROM `article` 
        WHERE `tags` LIKE '%$title%'";
        $result = db_count_query($sql);
        return $result;
    }

    // my article
    static function myArticle($id){
        global $start;
        global $limit;
        $sql = "SELECT `article_id`, `article_name`,`view`,`created_at`,`thumbnail` FROM `article` 
        WHERE `user_id` = '{$id}' AND `status` = '1' ORDER BY `article_id` DESC LIMIT $start,$limit";
        $rows = db_get_list($sql);
        return $rows;
    }

    // statictic 
    static function chartInYear(){
        $year = date("Y");
        $sql = "SELECT `created_at` as 'date', SUM(`view`) as 'view' FROM `statistic`
        WHERE YEAR(`created_at`) = '{$year}'
        GROUP BY `created_at`";
        return db_get_list($sql);
    }
}
// end class
?>

