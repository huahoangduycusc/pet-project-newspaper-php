<?php
error_reporting(0);
define('IN_SITE',true);
require_once('../libs/core.php');
if(!$user_id){
    redirect(homeurl());
}
require_once('../libs/header.php');
$account = new account($user_id);
$error = array();
if(isset($_POST['change'])){
    $old_pass = input_post('op');
    $new_pass = input_post('np');
    $confirm_pass = input_post('cfp');
    if(empty($old_pass)){
        $error['old'] = "Vui lòng nhập mẩu khẫu cũ ";
    }
    if(empty($new_pass)){
        $error['new'] = "Vui lòng nhập mật khẩu mới";
    }
    if(empty($confirm_pass)){
        $error['confirm'] = 'Vui lòng nhập lại mật khẩu xác nhận';
    }
    if(strlen($new_pass) < 6 || strlen($new_pass) > 20){
        $error['new'] = "Mật khẩu phải dài ít nhất từ 6 đến 20 ký tự";
    }
    if(!empty($new_pass) && $new_pass != $confirm_pass){
        $error['confirm'] = 'Mật khẩu xác nhận không trùng khớp';
    }
    if(empty($error)){
        if(account::changePassword($old_pass,$new_pass)){
            $msg = "Thay đổi mật khẩu mới thành công !";
        }
        else{
            $error['old'] = "Mật khẩu cũ không chính xác !";
        }
    }
}
?>
<div class="profile">
    <div class="fit">
        <div class="profile-avatar">
            <img src="<?php echo homeurl();?><?php echo $account->avatar;?>" alt="">
            <p>Có <b>0</b> người theo dõi</p>
        </div>
        <div class="profile-infor">
            <h2 style="color:#013481;font-size:12pt"><?php echo $account->username;?></h2>
            <p><i class="fas fa-map-marker"></i> <?php echo $account->address;?></p>
            <p><i class="fas fa-comment"></i> <?php echo $account->post;?> Post</p>
            <p><i class="fas fa-venus-mars"></i> <?php echo $account->gender;?></p>
            <p><i class="fas fa-phone"></i> <?php echo $account->phone;?></p>
        </div>
        <?php if ($user_id) {?>
        <div class="profile-setting">
            <a href="<?php echo homeurl();?>user/setting.php?id=<?php echo $user_id; ?>" class="btn-setting"><i class="fas fa-cog"></i> Thiết lập</a>
            <a href="<?php echo homeurl();?>user/changep.php" class="btn-setting"><i class="fas fa-exchange-alt"></i> Đổi mật khẩu</a>
            <a href="<?php echo homeurl();?>user/index.php?id=<?php echo $user_id;?>" class="btn-setting"><i class="fas fa-undo-alt"></i> Trang cá nhân</a>
        </div>
        <?php } ?>
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
                <a href="search.php?id=<?php echo $id;?>">Bài viết đã đăng</a></p>
            </div>
        </div>
        <!-- col duy 4 -->
        <div class="col-duy-8 white-bg">
            <div class="list-comment">
                <h2 class="center">Thay đổi mật khẩu</h2>
                <?php
                if(isset($msg)){
                    echo '<div class="center alert-success">'.$msg.'</div>';
                }
                ?>
                <form method="POST">
                    <div class="form-group">
                        <p>Mật khẩu cũ</p>
                        <input type="password" name="op" id="op" class="form-control" value="<?php echo isset($old_pass) ? $old_pass : '';?>" required />
                        <?php echo showError($error,'old');?>
                    </div>
                    <div class="form-group">
                        <p>Mật khẩu mới</p>
                        <input type="password" name="np" id="np" class="form-control" value="<?php echo isset($new_pass) ? $new_pass : '';?>" required />
                        <?php echo showError($error,'new');?>
                    </div>
                    <div class="form-group">
                        <p>Xác nhận mật khẩu mới</p>
                        <input type="password" name="cfp" id="cfp" class="form-control" value="<?php echo isset($confirm_pass) ? $confirm_pass : '';?>" required />
                        <?php echo showError($error,'confirm');?>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="change" value="Xác nhận" class="btn btn-submit" />
                    </div>
                </form>
            </div>
            <!-- list comment -->
        </div>
        <!-- col duy 8 -->
    </div>
</section>
<?php
require_once('../libs/footer.php');
?>