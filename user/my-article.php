<?php
error_reporting(0);
define('IN_SITE',true);
require_once('../libs/core.php');
if(!$user_id){
    redirect(homeurl());
}
$account = new account($id);
if($account->flag == false){
    redirect(homeurl());
}
require_once('../libs/header.php');
?>
<div class="fit">
    <div class="back-category">
        <img src="<?php echo homeurl();?>images/category.jpg" alt="">
        <div class="category-title">
            <div class="category-title-header">
                <p>Khám phá</p>
                <h1><?php echo $account->nickname;?></h1>
            </div>
        </div>
    </div>
</div>

<section class="bg-category fit">
    <div class="list-article" id="article">
        <?php
        $list = Article::myArticle($id);
        foreach($list as $row)
        {
            ?>
            <div class="list-article-item">
            <div class="list-article-img">
                <a href="<?php echo Article::rewriteUrl($row['article_id']);?>"><img src="<?php echo homeurl();?>images/thumbnail/1.jpg" alt=""></a>
            </div>
            <div class="list-article-infor">
                <div class="list-article-col-8">
                    <a href="<?php echo Article::rewriteUrl($row['article_id']);?>"><?php echo $row['article_name'];?></a>
                </div>
                <div class="list-article-col-4">
                    <span><?php echo $row['created_at'];?></span>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
    <!-- list article -->
    <?php
    if (count($list) > 10)
    {
        echo'<div class="load-bg">
            <a href="" id="getMore" class="load_more_bg">Load more</a>
        </div>';
    }
    else if(count($list) == 0)
    {
        echo'<div class="empty"><b>'.$account->nickname.'</b> chưa có bài viết nào được đăng tải !</div>';
    }
    ?>
</section>
<script src="load-more-article.js"></script>
<?php
require_once('../libs/footer.php');
?>