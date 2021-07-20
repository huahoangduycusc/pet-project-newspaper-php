<?php
define('IN_SITE',true);
require_once('../libs/core.php');
$title = "Nhắn tin";
$account = new account($id);
if($id == $user_id){
    return redirect(homeurl());
}
if($account->flag == false){
    return redirect(homeurl());
}
require_once('../libs/header.php');
Mail::seeMail($id);
if(isset($_POST['send'])){
    $error = array();
    $token = input_post('token');
    $msg = input_post('message');
    if(!csrf::validate_token($token)){
        $error['result'] = 'The request is not valid';
    }
    if(empty($msg)){
        $error['result'] = 'Vui lòng nhập vào nội dung';
    }
    if(empty($error)){
        Mail::create($id,$msg);
    }
}
?>
<div class="mail-container">
    <div class="mail-welcome">
        <div class="center"><i class="fas fa-envelope"></i> Bạn đang nhắn tin với <?php echo $account->nickname;?></div>
    </div>
    <div class="mail-form">
        <form method="POST">
            <textarea name="message" id="message" rows="5" class="form-control"></textarea>
            <button type="submit" name="send" value="send message"><i class="fas fa-paper-plane"></i></button>
            <?php echo csrf::create_token();?>
            <input type="hidden" name="to_user" value="<?php echo $id;?>" />
        </form>
    </div>
    <!-- mail form -->
    <div class="mail-list" id="mail">
        <?php
        foreach (Mail::getListMessage($id) as $item)
        {
            if ($item['from_user'] == $user_id)
            {
                ?>
                <div class="mail-from">
                    <div class="mail-avatar">
                        <a href="<?php echo account::urlAccount($item['from_user']);?>">
                            <img src="<?php echo homeurl().$item['avatar'];?>" alt="">
                        </a>
                    </div>
                    <!-- mail avatar -->
                    <div class="mail-content">
                        <div class="mail-msg">
                            <p><a href="<?php echo account::urlAccount($item['from_user']);?>"><b><?php echo account::getName($item['from_user']);?></b></a></p>
                            <?php echo $item['content'];?>
                        </div>
                        <div class="mail-times">
                            <?php echo thoigian($item['created_at']);?>
                        </div>
                    </div>
                </div>
                <!-- mail from -->
            <?php
            }
            else
            {
            ?>
                <div class="mail-to">
                    <div class="mail-content">
                        <div class="mail-msg">
                            <p><a href="<?php echo account::urlAccount($item['from_user']);?>"><b><?php echo account::getName($item['from_user']);?></b></a></p>
                            <?php echo $item['content'];?>
                        </div>
                        <div class="mail-times">
                        <?php echo thoigian($item['created_at']);?>
                        </div>
                    </div>
                    <div class="mail-avatar">
                        <a href="<?php echo account::urlAccount($item['from_user']);?>">
                            <img src="<?php echo homeurl().$item['avatar'];?>" alt="">
                        </a>
                    </div>
                    <!-- mail avatar -->
                </div>
                <!-- mail to -->
            <?php
            }
        }
        ?>
    </div>
</div>
<!-- mail container -->
<?php
$count = db_count_query("SELECT `from_user`, `to_user`, `content`, `created_at`, a.`avatar` FROM `message` m
LEFT JOIN `account` a ON m.`from_user` = a.`id`
WHERE `from_user` = '{$user_id}' AND `to_user` = '{$id}' OR `to_user` = '{$user_id}' AND `from_user` = '{$id}'");
if($count > $limit){
    echo '<div class="load-bg">
    <a href="" id="getMore" class="load_more_bg">Xem thêm</a>
</div>';
}
if($count == 0){
    echo'<div class="fit empty">Chưa có tin nhắn nào!</div>';
}
?>
<script>
let load_more = document.querySelector('#getMore');
var skip = 10;
if(load_more)
    {
        load_more.addEventListener('click',(e) => {
        e.preventDefault();
        load_more.innerHTML = 'Loading ...';
        $.ajax({
            url : 'load_more_text.php',
            type: 'POST',
            dataType: 'text',
            data : {
                id : <?php echo $id;?>,
                skip: skip
            },
            success : function(data){
                $("#mail").append(data);
                if(data == ''){
                    $('#getMore').fadeOut();
                }
                load_more.innerHTML = 'Xem thêm';
                skip += skip;
            },
            error : function(){
                alert("Có lỗi xảy ra khi tải dữ liệu ...");
            }
        })
    });
}
</script>
<?php
require_once('../libs/footer.php');
?>