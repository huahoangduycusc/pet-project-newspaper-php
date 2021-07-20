<?php
define('IN_SITE',true);
require_once('../libs/core.php');
$textl = "Bảng xếp hạng bài viết HOT";
require_once('../libs/header.php');
?>
<div class="fit">
    <div class="back-category">
    <img src="<?php echo homeurl();?>images/category.jpg" alt="">
        <div class="category-title">
            <div class="category-title-header">
                <p>Khám phá</p>
                <h1>Bảng xếp hạng</h1>
            </div>
        </div>
    </div>
</div>
<section class="spotlight">
    <div class="fit">
        <div class="col-duy-4">
            <h2 class="title-highlight">HOT hôm nay</h2>
            <div class="list">
                <?php
                foreach (Article::mostView() as $item)
                {
                    ?>
                    <div class="wrapper">
                        <div class="wrapper-thumbnail">
                            <a href="<?php echo Article::rewriteUrl($item['article_id']);?>"><img src="<?php echo homeurl().$item['thumbnail'];?>" alt=""></a>
                        </div>
                        <div class="wrapper-infor">
                            <a href="" class="category-name"><?php echo $item['categoryName'];?></a>
                            <span class="times"><?php echo $item['created_at'];?></span>
                            <h2 class="title">
                                <a href="<?php echo Article::rewriteUrl($item['article_id']);?>"><?php echo $item['article_name'];?></a>
                            </h2>
                            <p><i class="fas fa-eye"></i> Xem <?php echo $item['view'];?></p>
                        </div>
                    </div>
                <!-- wrapper -->
                <?php } ?>
            </div>
            <!-- list -->
            <h2 class="title-highlight">Hot trong tuần</h2>
            <div class="list">
                <?php
                foreach (Article::mostViewInWeek() as $item)
                {
                    ?>
                    <div class="wrapper">
                        <div class="wrapper-thumbnail">
                            <a href="<?php echo Article::rewriteUrl($item['article_id']);?>"><img src="<?php echo homeurl().$item['thumbnail'];?>" alt=""></a>
                        </div>
                        <div class="wrapper-infor">
                            <a href="" class="category-name"><?php echo $item['categoryName'];?></a>
                            <span class="times"><?php echo $item['created_at'];?></span>
                            <h2 class="title">
                                <a href="<?php echo Article::rewriteUrl($item['article_id']);?>"><?php echo $item['article_name'];?></a>
                            </h2>
                            <p><i class="fas fa-eye"></i> Xem <?php echo $item['view'];?></p>
                        </div>
                    </div>
                <!-- wrapper -->
                <?php } ?>
            </div>
            <!-- list -->
        </div>
        <!-- col duy 4 -->
        <div class="col-duy-8">
        <h2 class="title-highlight">Hot trong tháng</h2>
            <div class="list">
                <?php
                foreach (Article::mostViewInMonth() as $item)
                {
                    ?>
                    <div class="wrapper">
                        <div class="wrapper-thumbnail">
                            <a href="<?php echo Article::rewriteUrl($item['article_id']);?>"><img src="<?php echo homeurl().$item['thumbnail'];?>" alt=""></a>
                        </div>
                        <div class="wrapper-infor">
                            <a href="" class="category-name"><?php echo $item['categoryName'];?></a>
                            <span class="times"><?php echo $item['created_at'];?></span>
                            <h2 class="title">
                                <a href="<?php echo Article::rewriteUrl($item['article_id']);?>"><?php echo $item['article_name'];?></a>
                            </h2>
                            <p><i class="fas fa-eye"></i> Xem <?php echo $item['view'];?></p>
                        </div>
                    </div>
                <!-- wrapper -->
                <?php } ?>
            </div>
            <!-- list -->
        </div>
        <!-- col duy 8 -->
    </div>
</section>
<?php
require_once('../libs/footer.php');
?>