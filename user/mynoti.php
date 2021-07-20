<?php
error_reporting(0);
define('IN_SITE',true);
require_once('../libs/core.php');
if(!$user_id){
    redirect(homeurl());
}
require_once('../libs/header.php');
?>
<div class="fit">
    <div class="col-duy-8">
        <h2 class="title-highlight">Thông báo của bạn</h2>
        <div class="list-noti">
            <?php
            foreach(Notification::getMyNoti() as $noti)
            {
                ?>
                <div class="list-noti-item">
                    <?php echo $noti['noti_msg'];?>
                    <p class="times-right">cách đây <?php echo thoigian($noti['noti_date'])?></p>
                </div>
            <?php
            }
            Notification::checkMynoti();
            if(count(Notification::getMyNoti()) == 0){
                echo '<div class="empty">Bạn chưa có thông báo nào</div>';
            }
            ?>
        </div>
    </div>
</div>
<?php
require_once('../libs/footer.php');
?>