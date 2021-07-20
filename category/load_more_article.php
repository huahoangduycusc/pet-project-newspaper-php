<?php
sleep(1);
define('IN_SITE',true);
require_once('../libs/core.php');
$out = '';
$skip = abs(intval($_POST['skip']));
$id =   abs(intval($_POST['id']));
$sql = "SELECT `article_id`,`article_name`,`thumbnail`,`created_at` FROM `article` WHERE `category_id` = '{$id}' ORDER BY `article_id` DESC LIMIT $skip,$limit";
$rows = db_get_list($sql);
if($rows)
{
    foreach($rows as $row)
    {
       $out .= '<div class="list-article-item">
       <div class="list-article-img">
           <a href="'.homeurl().'article/?id='.$row['article_id'].'"><img src="'.homeurl().$row['thumbnail'].'" alt=""></a>
       </div>
       <div class="list-article-infor">
           <div class="list-article-col-8">
               <a href="'.homeurl().'article/?id='.$row['article_id'].'">'.$row['article_name'].'</a>
           </div>
           <div class="list-article-col-4">
               <span>'.$row['created_at'].'</span>
           </div>
       </div>
   </div>';
    }
    echo $out;
}
?>