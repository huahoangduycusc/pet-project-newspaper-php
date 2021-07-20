<?php
error_reporting(0);
define('IN_SITE',true);
require_once('../libs/core.php');
if(!$user_id){
    redirect(homeurl());
}
require_once('../libs/header.php');
$account = new account($id);
if($account->flag == false){
    redirect(homeurl());
}
$getMyfl = db_count('account_follow','follow_id',array('follow_to' => $id));
?>
<div class="profile">
    <div class="fit">
        <div class="profile-avatar">
            <img src="<?php echo homeurl();?><?php echo $account->avatar;?>" alt="">
            <p>Có <b><?php echo $getMyfl;?></b> người theo dõi</p>
        </div>
        <div class="profile-infor">
            <h2 style="color:#013481;font-size:12pt"><?php echo $account->username;?></h2>
            <p><i class="fas fa-map-marker"></i> <?php echo $account->address;?></p>
            <p><i class="fas fa-comment"></i> <?php echo $account->post;?> Post</p>
            <p><i class="fas fa-venus-mars"></i> <?php echo $account->gender;?></p>
            <p><i class="fas fa-phone"></i> <?php echo $account->phone;?></p>
        </div>
        <div class="profile-setting">
                <?php
                if($user_id != $id){
                    $out = "";
                    if(Follow::checkIsFollow($id)){
                        $out = "Bỏ theo dõi";
                    }
                    else{
                        $out = "Theo dõi";
                    }
                    echo '<a href="follow.php?id='.$id.'" class="btn-setting"><i class="fas fa-plus"></i> '.$out.'</a>';
                }
                ?>
                <?php
                if($user_id == $id || $rights == 9){
                    ?>
                    <a href="<?php echo homeurl();?>user/setting.php?id=<?php echo $id;?>" class="btn-setting"><i class="fas fa-cog"></i> Thiết lập</a>
                    <?php
                }
                ?>
                <?php
                if($user_id == $id)
                {
                    echo'<a href="changep.php" class="btn-setting"><i class="fas fa-exchange-alt"></i> Đổi mật khẩu</a>';
                }
                ?>
                <?php
                if($user_id != $id){
                    echo'<a href="'.$homeurl.'mail/?id='.$id.'" class="btn-setting"><i class="fas fa-envelope"></i> Nhắn tin</a>';
                }
                ?>
                <?php
                if($user_id != $id && $rights == 9){
                    echo'<a href="" class="btn-setting block-user"><i class="fas fa-user-lock"></i> Khóa</a>';
                }
                ?>
        </div>
    </div>
</div>
<!-- profile div -->
<section class="profile-line">
    <div class="fit">
        <div class="col-duy-4">
            <div class="profile-start">
                <p><i class="far fa-clock"></i> Gia nhập: <?php echo $account->timeJoin;?></p>
                <p><i class="fas fa-calendar-alt"></i> Sinh nhật: <?php echo $account->birthday;?></p>
                <p><i class="fas fa-candy-cane"></i> Sở thích: <?php echo $account->favourite;?></p>
                <p><i class="fas fa-search"></i> 
                <a href="my-article.php?id=<?php echo $id;?>">Bài viết đã đăng</a></p>
            </div>
        </div>
        <!-- col duy 4 -->
        <div class="col-duy-8">
            <div class="list-comment" id="cmt">
            <?php
            $cmt = $account->getComments();
            if($cmt)
            {
                foreach($cmt as $item)
                {
                    ?>
                    <div class="comment-line">
                    <h2><a href="<?php echo Article::rewriteUrl($item['article_id']);?>"><?php echo $item['article_name'];?></a></h2>
                    <div class="comment-full">
                        <div class="comment-avatar">
                            <img src="<?php echo $account->getAvatar(); ?>" alt="@item.name">
                        </div>
                        <div class="comment-profile">
                            <p>
                                <?php echo account::role($id);?>
                               <span class="times"><i>cách đây <?php echo thoigian($item['created_at']);?></i></span>
                            </p>
                            <p class="msg"><?php echo $item['message']; ?></p>
                            <a href="<?php echo Article::rewriteUrl($item['article_id']);?>"><i class="fas fa-eye"></i> View post</a>
                        </div>
                    </div>
                </div>
            <?php
                }
            }
            ?>
            </div>
            <!-- list comment -->
            <?php
            if($account->cmt > 10)
            {
            ?>
            <div class="load-bg">
                <a href="" id="getMore" data-user="<?php echo $id;?>" class="load_more_bg">Load more</a>
            </div>
            <?php
            }
            else if($account->cmt == 0)
            {
            ?>
            <div class="empty">Hiện chưa có bất kỳ bình luận nào của <b><?php echo $account->username;?></b></div>
            <?php
            }
            ?>
        </div>
        <!-- col duy 8 -->
    </div>
</section>
<input type="hidden" id="user" value="<?php echo $id;?>">
<div class="feedback-container">
    <div class="feedback-fixed">
        <div class="feedback-title">KHÓA tài khoản</div>
       <form method="POST" id="btnBan">
            <div class="feedback-txt">
                <p>Lý do</p>
                <input type="text" name="lydo" id="lydo" placeholder="Lý do" required>
            </div>
            <div class="feedback-txt">
                <p>Thời hạn</p>
                <div class="input-ban"><input type="number" size="10" min="1" id="date"></div>
                <div class="list-option">
                    <span><input type="radio" value="1" name="type" checked> Ngày</span>
                    <span><input type="radio" value="2" name="type"> Tháng</span>
                    <span><input type="radio" value="3" name="type"> Năm</span>
                </div>
            </div>
            <div class="feedback-submit">
                <button type="submit" id="btn_send">Xác nhận</button>
            </div>
        </form>
        <a class="close"><i class="fas fa-times"></i></a>
    </div>
    <div class="sign-owner">
        <p>Design by</p>
        <img src="<?php echo homeurl();?>images/duy.png" alt="">
    </div>
</div>
<script src="ban.js"></script>
<script src="app.js"></script>
<?php
require_once('../libs/footer.php');
?>