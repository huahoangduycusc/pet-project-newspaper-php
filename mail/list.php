<?php
define('IN_SITE',true);
require_once('../libs/core.php');
$title = "Danh sách liên hệ";
if(!$user_id){
    return redirect(homeurl());
}
require_once('../libs/header.php');
?>
<section class="profile-line">
    <div class="fit">
        <!-- col duy 4 -->
        <div class="col-duy-8">
            <h2 class="title-highlight">Hộp thư</h2>
            <div class="list-mail">
                <?php
                foreach (Mail::getListContact() as $ct)
                {
                    if ($ct['from_user'] != $user_id)
                    {
                        $account = new account($ct['from_user']);
                        ?>
                        <div class="list-mail-item">
                            <div class="list-mail-avatar">
                                <a href="<?php echo homeurl()."mail/?id=".$ct['from_user'];?>">
                                    <img src="<?php echo homeurl().$account->avatar;?>" alt="">
                                </a>
                            </div>
                            <div class="list-mail-content">
                                <a href="<?php echo homeurl()."mail/?id=".$ct['from_user'];?>">
                                    <span class="list-mail-user">
                                        <?php echo account::getName($ct['from_user']);?>
                                    </span>
                                    <span class="list-mail-msg">
                                        <?php echo $ct['content'];?>
                                    </span>
                                    <span class="list-mail-times">
                                        <?php echo thoigian($ct['created_at']);?>
                                    </span>
                                </a>
                                <?php
                                $latest = Mail::countNoseen($ct['from_user']);
                                if($latest > 0){
                                    echo '<div class="seen1">'.$latest.'</div>';
                                }
                                ?>
                            </div>
                            <div class="list-mail-setting">
                                <a href="?do=delete&id=<?php echo $ct['from_user'];?>" class="block" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa?');"><i class="fas fa-trash-alt"></i></a>
                            </div>
                        </div>
                        <!-- list mail item -->
                    <?php
                    }
                    if ($ct['to_user'] != $user_id)
                    {
                        $account = new account($ct['from_user']);
                    ?>
                        <div class="list-mail-item">
                            <div class="list-mail-avatar">
                                <a href="<?php echo homeurl()."mail/?id=".$ct['to_user'];?>">
                                    <img src="<?php echo homeurl().$account->avatar;?>" alt="">
                                </a>
                            </div>
                            <div class="list-mail-content">
                                <a href="<?php echo homeurl()."mail/?id=".$ct['to_user'];?>">
                                    <span class="list-mail-user">
                                        <?php echo account::getName($ct['to_user']);?>
                                    </span>
                                    <span class="list-mail-msg">
                                        <?php echo $ct['content'];?>
                                    </span>
                                    <span class="list-mail-times">
                                        Cách đây <?php echo thoigian($ct['created_at']);?>
                                    </span>
                                </a>
                                <?php
                                $latest = Mail::countNoseen($ct['to_user']);
                                if($latest > 0){
                                    echo '<div class="seen1">'.$latest.'</div>';
                                }
                                ?>
                            </div>
                            <div class="list-mail-setting">
                                <a href="?do=delete&id=<?php echo $ct['to_user'];?>" class="block" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa?');"><i class="fas fa-trash-alt"></i></a>
                            </div>
                        </div>
                        <!-- list mail item -->
                    <?php
                    }
                }
                ?>
            </div>
            <!-- list mail -->
            <?php
            if(count(Mail::getListContact()) == 0){
                echo '<div class="empty">Bạn chưa bất kỳ liên lạc nào!</div>';
            }
            ?>
        </div>
        <!-- col duy 8 -->
    </div>
</section>
<?php
require_once('../libs/footer.php');
?>