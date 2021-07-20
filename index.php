<?php
define('IN_SITE',true);
$rootpath = '';
require_once('libs/core.php');
require_once('libs/header.php');
?>
<div class="fit">
    <div class="col-duy-8">
    <?php
    $pin = Article::pin();
    if($pin)
    {
    ?>
        <div class="article-trend">
            <div class="article-trend-thumb">
                <a href="<?php echo Article::rewriteUrl($pin['article_id']);?>"><img src="<?php echo homeurl().$pin['thumbnail'];?>" alt=""></a>
            </div>
            <div class="article-trend-info">
                <h2 class="title">
                    <a href="<?php echo Article::rewriteUrl($pin['article_id']);?>"><?php echo $pin['article_name'];?></a>
                </h2>
                <a href="" class="category-name"><?php echo $pin['categoryName'];?></a>
                <span class="times"><?php echo $pin['created_at'];?></span>
            </div>
        </div>
    <?php } ?>
        <!-- trend -->
    </div>
    <!-- col 8 -->
    <div class="col-duy-4">
        <h2 class="title-highlight">
            <a href="#">Trending <i class="fas fa-angle-right"></i></a>
        </h2>
        <div class="list">
        <?php
        $trend = Article::trending();
        if($trend)
        {
            foreach($trend as $item)
            {
        ?>
            <div class="wrapper">
                <div class="wrapper-thumbnail">
                    <a href="<?php echo Article::rewriteUrl($item['article_id']);?>"><img src="<?php echo homeurl().$item['thumbnail'];?>" alt="img"></a>
                </div>
                <div class="wrapper-infor">
                    <a href="" class="category-name"><?php echo $item['categoryName'];?></a>
                    <span class="times"><?php echo $item['created_at'];?></span>
                    <h2 class="title"><a href="<?php echo Article::rewriteUrl($item['article_id']);?>"><?php echo $item['article_name'];?></a></h2>
                </div>
            </div>
        <?php
            }
        }
        ?>
            <!-- wrapper -->
        </div>
        <!-- list -->
    </div>
    <!-- col 4 -->
</div>
<!-- fit 1200 -->
<section class="lasted">
    <div class="fit">
        <h2 class="title-highlight"><a href="#">Tin mới nhất</a></h2>
        <div class="images glide">
            <div class="glide__track" data-glide-el="track">
                <?php 
                $latest = Article::latestArticle();
                if ($latest)
                {?>
                    <ul class="glide__slides">
                        <?php
                        foreach ($latest as $val)
                        {
                        ?>
                        <li class="glide__slide">
                            <a href="<?php echo Article::rewriteUrl($val['article_id']);?>"><img src="<?php echo homeurl().$val['thumbnail'];?>" alt=""></a>
                            <a href="" class="category-name"><?php echo $val['categoryName'];?></a>
                            <span class="times"><?php echo $val['created_at'];?></span>
                            <h2 class="title"><a href="<?php echo Article::rewriteUrl($val['article_id']);?>"><?php echo $val['article_name'];?></a></h2>
                        </li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </div>
            <div class="glide__arrows" data-glide-el="controls">
                <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i class="fas fa-arrow-left"></i></button>
                <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i class="fas fa-arrow-right"></i></button>
            </div>
        </div>
    </div>
</section>
<!-- end section news -->
<section class="watch">
    <div class="fit">
        <h2 class="title-highlight"><a href="">TV SHOW</a></h2>
            <div class="list-topic">
                <?php
                $tv = Article::tvShow();
                if($tv)
                {
                    foreach($tv as $item)
                    {
                        ?>
                        <div class="list-topic-item">
                            <div class="topic-item-thumbnail">
                                <a href="<?php echo Article::rewriteUrl($item['article_id']);?>"><img src="<?php echo homeurl().$item['thumbnail'];?>" alt=""></a>
                            </div>
                            <div class="topic-item-infor">
                                <a href="" class="category-name"><?php echo $item['categoryName'];?></a>
                                <span class="times"><?php echo $item['created_at'];?></span>
                                <h2 class="title"><a href="<?php echo Article::rewriteUrl($item['article_id']);?>"><?php echo $item['article_name'];?></a></h2>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
                <!-- list topic item -->
            </div>
     </div>
</section>
<!-- end section watch -->
<?php
require_once('article/spotlight.php');
?>
<section class="bg-white">
    <div class="fit">
        <h2 class="title-highlight">Blog</h2>
    </div>
    <section class="blog">
        <div class="list-blog">
            <?php include('blog/list.php');?>
        </div>
        <!-- list blog -->
    </section>
</section>
<!-- end section blog -->
<?php
require_once('libs/footer.php');
?>
<script>
new Glide(".images",{
    type: 'carousel',
    perView: 4,
    focusAt: 'center',
    gap : 40,
    breakpoints: {
        1200:{
            perView : 3
        },
        800:{
            perView : 2
        },
        600:{
            perView : 1
        }
    }
}).mount();
</script>