<?php
define('IN_SITE',true);
require_once('../libs/core.php');
$article = new Article($id);
if($article->flag == false){
    redirect(homeurl());
}
$title = $article->title;
require_once('../libs/header.php');
?>
<div class="fit">
    <div class="col-duy-8">
        <div class="article">
            <div class="article-thumbnail">
                <img src="<?php echo homeurl().$article->thumbnail;?>" />
            </div>
            <div class="article-title">
               <h1><?php echo $article->title; ?></h1>
            </div>
            <div class="article-infor">
                <a href="" class="category-name"><?php echo $article->categoryName; ?></a>
                <span class="times"><?php echo $article->created_at; ?></span><span class="times">- Xem : <?php echo $article->view; ?></span>
                <p>bởi <a href="<?php echo homeurl();?>user/?id=<?php echo $article->author;?>"><?php echo $article->author();?></a></p>
            </div>
            <!-- infor -->
            <div class="article-content"><?php echo html_entity_decode($article->description); ?></div>
            <!-- content post -->
            <div class="article-tags">
                
                <?php
                $tags = explode(",",$article->tags);
                foreach($tags as $tag){
                    $tag = str_replace("&quot;","",$tag);
                    echo '<a href="'.$homeurl.'article/tag.php?tag='.($tag).'" class="tags">'.($tag).'</a>';
                }
                ?>
            </div>
            <!-- tags -->
            <div class="feeling">
                <h2>Bài viết này thế nào ?</h2>
                <div class="flex" id="loadCamxuc">
                    <div class="feeling-item" data-id="heart">
                        <span class="feeling-icon">
                            <img src="<?php echo homeurl();?>icon/heart.svg" alt="" title="Thích quá đi">
                        </span>
                        <span class="feeling-number" id="heart"><?php echo $article->react_heart;?></span>
                    </div>
                    <!-- feeling item -->
                    <div class="feeling-item" data-id="smile">
                        <span class="feeling-icon">
                            <img src="<?php echo homeurl();?>icon/smile.svg" alt="" title="Cười ỉa">
                        </span>
                        <span class="feeling-number" id="smile"><?php echo $article->react_happy;?></span>
                    </div>
                    <!-- feeling item -->
                    <div class="feeling-item" data-id="angry">
                        <span class="feeling-icon">
                            <img src="<?php echo homeurl();?>icon/angry.svg" alt="" title="Đang sắp điên">
                        </span>
                        <span class="feeling-number" id="angry"><?php echo $article->react_angry;?></span>
                    </div>
                    <!-- feeling item -->
                    <div class="feeling-item" data-id="cry">
                        <span class="feeling-icon">
                            <img src="<?php echo homeurl();?>icon/sad.svg" alt="" title="Muốn khóc ghê">
                        </span>
                        <span class="feeling-number" id="cry"><?php echo $article->react_cry;?></span>
                    </div>
                    <!-- feeling item -->
                    <div class="feeling-item" data-id="scared">
                        <span class="feeling-icon">
                            <img src="<?php echo homeurl();?>icon/omg.svg" alt="" title="Dễ sợ chưa">
                        </span>
                        <span class="feeling-number" id="scared"><?php echo $article->react_scared;?></span>
                    </div>
                    <!-- feeling item -->
                </div>
                <!-- flex div -->
            </div>
            <!-- feeling of user -->
            <div class="article-share">
                <h2>Chia sẻ bài viết trên</h2>
                <a href="http://www.facebook.com/sharer/sharer.php?u=@Request.Url.OriginalString&t=@Model.name" target="_blank" title="Share on Facebook" class="item-share">
                    <i class="fab fa-facebook-f"></i>FACEBOOK
                </a>
                <a href="http://www.twitter.com/intent/tweet?url=@Request.Url.OriginalString&via=TWITTER_HANDLE_HERE&text=@Model.name" target="_blank" class="item-share"><i class="fab fa-twitter"></i> TWITTER</a>
                <a href="http://plus.google.com/share?url=@Request.Url.OriginalString" target="_blank" class="item-share"><i class="fas fa-phone"></i>ZALO</a>
                <a href="http://plus.google.com/share?url=@Request.Url.OriginalString" target="_blank" class="item-share"><i class="fab fa-google-plus-g"></i>GOOGLE+</a>
            </div>
            <!-- article share -->
            <div class="chat-box">
                <h2 class="title-highlight">Bình luận</h2>
                <?php if(!$user_id){?>
                    <div class="warning">
                        Vui lòng đăng nhập để tham gia cuộc trò chuyện này <br />
                        <a href="<?php echo homeurl();?>login.php">Click vào đây để đăng nhập</a>
                    </div>
                <?php
                }
                else
                {
                ?>
                    <form action="#" method="POST" id="form_cmt">
                        <div class="your-comment">
                            <div class="chat-avatar">
                                <a href=""><img src="<?php echo homeurl().$datauser['avatar'];?>" alt=""></a>
                            </div>
                            <div class="chat-text">
                                <textarea name="message" id="message" rows="5" placeholder="Để lại bình luận của bạn" required></textarea>
                                <?php echo csrf::create_token();?>
                                <input type="submit" name="post" value="Gửi" class="btn-chat">
                            </div>
                        </div>
                    </form>
                    <!-- your comment -->
                <?php } ?>
                <div class="data-chat" id="chat">
                    <?php
                    $rows = $article->getComments();
                    if($rows)
                    {
                        foreach($rows as $item){
                            $user = new account($item['user_id']);
                            ?>
                            <div class="chat-post" id="cmt<?php echo $item['cmt_id'];?>">
                                <div class="chat-post-img">
                                    <a href="<?php echo account::urlAccount($item['user_id']);?>"><img src="<?php echo homeurl().$user->avatar;?>" alt=""></a>
                                </div>
                                <div class="chat-post-content">
                                    <div class="user-chat">
                                        <a href="<?php echo account::urlAccount($item['user_id']);?>"><b style="color:#013481;font-size:11pt"><?php echo $user->username;?></b></a>
                                        <p class="times">cách đây <?php echo thoigian($item['created_at']);?></p>
                                        <p class="control">
                                            <?php
                                            if($rights == 9 || $user_id == $item['user_id'])
                                            {
                                                ?>
                                                <a href="" title="Xóa" data-cid="<?php echo $item['cmt_id'];?>" class="delete-cmt"><i class="fas fa-times"></i></a>
                                                <a href="" title="Báo cáo" data-cid="<?php echo $item['cmt_id'];?>" class="report-cmt"><i class="fas fa-flag"></i></a>
                                                <?php
                                            }
                                            ?>
                                        </p>
                                    </div>
                                    <div class="user-comment">
                                        <?php echo $item['message'];?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }   
                    }
                        ?>
                </div>
               
                <?php
                if($article->comment > 10)
                {
                    ?>
                    <div class="center"><a id="load-more" class="load-more">Xem thêm</a></div>
                    <?php
                }
                else if($user_id && $article->comment == 0){
                    ?>
                    <div class="empty">Trở thành người đầu tiên bình luận bài viết này.</div>
                    <?php
                }
                ?>
                <!-- data chat -->
            </div>
            <!-- chat box div -->
        </div>
    </div>
    <!-- col duy 8 -->
    <div class="col-duy-4">
        <h2 class="title-highlight">
            bài viết Liên quan
        </h2>
        <div class="list">
        <?php
        $rand = $article->randomArticle();
        if($rand){
            foreach($rand as $item)
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
                    </div>
                </div>
                <!-- wrapper -->
                <?php
            }
        }
        ?>
        </div>
        <!-- list -->
    </div>
    <!-- col duy 4 -->
</div>
<section class="similar">
    <input type="hidden" id="data_user" value="<?php echo $user_id;?>">
    <input type="hidden" id="article" value="<?php echo $id; ?>">
    <div class="fit">
        <h2 class="title-highlight">Cùng chuyên mục</h2>
        <div class="similar-list">
            <?php
            $similar = $article->similarArticle();
            if($similar){
                foreach($similar as $item)
                {
                    ?>
                    <div class="similar-list-item">
                        <div class="similar-img">
                            <a href="<?php echo Article::rewriteUrl($item['article_id']);?>"><img src="<?php echo homeurl().$item['thumbnail'];?>" alt=""></a>
                        </div>
                        <div class="similar-infor">
                            <a href="" class="category-name"><?php echo $item['categoryName'];?></a>
                            <span class="times"><?php echo $item['created_at'];?></span>
                            <h2 class="title">
                               <a href="<?php echo Article::rewriteUrl($item['article_id']);?>"><?php echo $item['article_name'];?></a>
                            </h2>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
    <!-- fit fiv 1280 -->
</section>
<!-- end section -->
<?php
require_once('../article/spotlight.php');
require_once('../libs/footer.php');
?>

<script src="reaction.js"></script>
<script src="post.js"></script>
<script src="curd.js"></script>
<script src="load_more_post.js"></script>