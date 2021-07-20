<?php
if(!defined('IN_SITE'))  die("The request not found");
$blogs = Blog::getList(1,3);
$i = 0;
foreach ($blogs as $blog)
{
    if($i%2==0)
    {
    ?>
        <div class="blog-item-even">
        <a href="<?php echo Blog::rewriteUrl($blog['blog_id']);?>">
                <div class="blog-item-thumbnail">
                    <img src="<?php echo homeurl().$blog['thumbnail'];?>" alt="">
                </div>
                <div class="blog-item-info">
                    <h2 class="title"><?php echo $blog['blog_title'];?></h2>
                    <p>Bởi <?php echo $blog['username'];?></p>
                    <span class="last-time"><?php echo thoigian($blog['created_at']);?></span>
                    <div class="duy-tron"></div>
                    <div class="duy-tron-1"></div>
                </div>
            </a>
        </div>   
    <?php
    }
    else
    {
        ?>
            <div class="blog-item-odd">
            <a href="<?php echo Blog::rewriteUrl($blog['blog_id']);?>">
                <div class="blog-item-info">
                    <h2 class="title"><?php echo $blog['blog_title'];?></h2>
                    <p>Bởi <?php echo $blog['username'];?></p>
                    <span class="last-time"><?php echo thoigian($blog['created_at']);?></span>
                    <div class="duy-tron"></div>
                    <div class="duy-tron-1"></div>
                </div>
                <div class="blog-item-thumbnail">
                    <img src="<?php echo homeurl().$blog['thumbnail'];?>" alt="">
                </div>
            </a>
        </div>   
        <?php
    }
    $i++;
}
?>
</div>
<!-- list blog -->