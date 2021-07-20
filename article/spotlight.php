<?php
if(!defined('IN_SITE')) die('The request not found');
?>
<section class="spotlight">
    <div class="fit">
        <div class="col-duy-4">
            <a href=""><h2 class="title-highlight">hot hôm nay</h2></a>
            <?php 
            $mostView = Article::mostView();
            if($mostView){
            ?>
            <div class="list">
                <?php foreach ($mostView as $val) {?>
                    <div class="wrapper">
                        <div class="wrapper-thumbnail">
                            <a href="<?php echo Article::rewriteUrl($val['article_id']);?>"><img src="<?php echo homeurl().$val['thumbnail'];?>" alt=""></a>
                        </div>
                        <div class="wrapper-infor">
                            <a href="" class="category-name"><?php echo $val['categoryName'];?></a>
                            <span class="times"><?php echo $val['created_at'];?></span>
                            <h2 class="title">
                                <a href="<?php echo Article::rewriteUrl($val['article_id']);?>"><?php echo $val['article_name'];?></a>
                            </h2>
                        </div>
                    </div>
                    <!-- wrapper -->
                <?php } ?>
            </div>
            <?php } ?>
            <!-- list -->
        </div>
        <!-- col duy 4 -->
        <div class="col-duy-8">
        <a href="#"><h2 class="title-highlight">chủ đề Nổi bật</h2></a>
        <div class="list-topic">
            <?php
            $spotlight = Article::spotlight();
            if($spotlight)
            {
                foreach($spotlight as $item)
                {
                    ?>
                    <div class="list-topic-item">
                        <div class="topic-item-thumbnail">
                            <a href="<?php echo Article::rewriteUrl($item['article_id']);?>"><img src="<?php echo homeurl().$item['thumbnail'];?>" alt=""></a>
                        </div>
                        <div class="topic-item-infor">
                            <a href="" class="category-name"><?php echo $item['categoryName'];?></a>
                            <span class="times"><?php echo $item['created_at'];?></span>
                            <h2 class="title">
                                <a href="<?php echo Article::rewriteUrl($item['article_id']);?>"><?php echo $item['article_name'];?></a>
                            </h2>
                        </div>
                    </div>
                    <!-- list topic item -->
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>