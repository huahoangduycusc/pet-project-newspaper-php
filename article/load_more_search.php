<?php
sleep(1);
define('IN_SITE',true);
require_once('../libs/core.php');
$out = '';
$start = abs(intval($_GET['skip']));
$s = isset($_GET['s']) ? htmlspecialchars($_GET['s']) : '';
$sql = "SELECT `article_id`, `article_name`,`view`,`created_at`,`thumbnail`,`category_id` FROM `article` WHERE `article_name` LIKE '%$s%' AND `status` = '1' ORDER BY `article_id` DESC LIMIT $start,$limit";
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