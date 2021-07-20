<?php
define('IN_SITE',true);
require_once('../libs/core.php');
require_once('../libs/header.php');
?>

<div class="fit">
        <div class="back-category">
        <img src="<?php echo homeurl();?>images/category.jpg" alt="">
            <div class="category-title">
                <div class="category-title-header">
                    <p>Explore</p>
                   <h1>Blog</h1>
                </div>
            </div>
        </div>
    </div>
    <section class="blog">
        <div class="list-blog" id="article">
            <?php include('list.php');?>
        </div>
        <!-- list blog -->
        <?php
        if (Blog::countPost() > 3)
        {
            ?>
            <div class="load-bg">
                <a href="" id="getMore" class="load_more_bg">Load more</a>
            </div>
        <?php
        }
        if(Blog::countPost() == 0){
            echo'<div class="fit empty">Blog chưa có bất kỳ bài đăng nào!</div>';
        }
        ?>
    </section>
    <input type="hidden" value="<?php echo Blog::countPost();?>">
<!-- section blog -->
<?php
require_once('../libs/footer.php');
?>