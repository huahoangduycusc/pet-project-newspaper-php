<?php
sleep(1);
define('IN_SITE',true);
require_once('../libs/core.php');
$id = isset($_POST['id']) ? abs(intval($_POST['id'])) : false;
$skip = isset($_POST['skip']) ? abs(intval($_POST['skip'])) : false;
$out = '';
if($id && $skip){
    $sql = "SELECT `message`,a.`created_at`,a.`article_id`,a.`user_id`,b.`article_name` 
    FROM `comment` a JOIN `article` b
    ON a.`article_id` = b.`article_id`
    WHERE a.`user_id` = '$id'
    ORDER BY `cmt_id` DESC LIMIT $skip,5";
    $rows = db_get_list($sql);
    if($rows){
        foreach($rows as $item)
        {
            $account = new account($id);
            $out .= ' <div class="comment-line">
            <h2><a href="'.Article::rewriteUrl($item['article_id']).'">'.$item['article_name'].'</a></h2>
            <div class="comment-full">
                <div class="comment-avatar">
                    <img src="'.$account->getAvatar().'" alt="@item.name">
                </div>
                <div class="comment-profile">
                    <p>
                        '.account::role($id).'
                       <span class="times"><i>cách đây '.thoigian($item['created_at']).'</i></span>
                    </p>
                    <p class="msg">'.$item['message'].'</p>
                    <a href="'.Article::rewriteUrl($item['article_id']).'"><i class="fas fa-eye"></i> View post</a>
                </div>
            </div>
        </div>';
        }
        echo $out;
    }
}
?>