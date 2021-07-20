<?php
define('IN_SITE',true);
require_once('../libs/core.php');
if(blog::checkExists($id) == false){
    redirect(homeurl());
}
require_once('../libs/header.php');
$blog = new Blog($id);
?>
<section class="blog">
    <div class="blog-container">
        <div class="blog-header">
            <a href="<?php echo homeurl();?>">Home</a> <i class="fas fa-angle-right"></i> <a href="<?php echo homeurl();?>blog">Blog</a> <i class="fas fa-angle-right"></i>
           <?php echo $blog->blog_title;?>
        </div>
    </div>
    <!-- blog header -->
    <div class="blog-thumbnail">
        <div class="blog-img">
            <img src="<?php echo homeurl().$blog->thumbnail;?>" alt="">
        </div>
        <div class="blog-title">
            <h2><?php echo $blog->blog_title;?></h2>
            <p class="blog-time">
                <?php echo thoigian($blog->created_at);?>
            </p>
            <div class="blog-share">
                <a href="http://www.facebook.com/sharer/sharer.php?u=@Request.Url.OriginalString&t=@Model.title"><i class="fab fa-facebook-f"></i></a>
                <a href="http://www.twitter.com/intent/tweet?url=@Request.Url.OriginalString&via=TWITTER_HANDLE_HERE&text=@Model.title"><i class="fab fa-twitter"></i></a>
                <a href="http://plus.google.com/share?url=@Request.Url.OriginalString"><i class="fab fa-google-plus-g"></i></a>
            </div>
        </div>
        <!-- blog title -->
    </div>
    <!-- blog thumn -->
    <div class="blog-body">
        <table class="blog-table">
            <tr>
                <td class="blog-author">
                    <a href="">
                        <img src="<?php echo homeurl().$blog->auAvatar;?>" alt="">
                    </a>
                    <div class="blog-post">
                       Bài: <?php echo $blog->auPost;?>
                    </div>
                </td>
                <td class="blog-right">
                    <div class="blog-author">
                        <a href="<?php echo homeurl();?>/user/?id=<?php echo $blog->user_id;?>"><?php echo account::role($blog->user_id);?></a>
                    </div>
                    <div class="blog-body-msg">
                       <?php echo html_entity_decode($blog->blog_msg);?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</section>
<?php
require_once('../libs/footer.php');
?>