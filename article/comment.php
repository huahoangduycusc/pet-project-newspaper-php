<?php
define('IN_SITE',true);
require_once('../libs/core.php');
$error = array();
switch($do){
    case 'post':
    sleep(1);
    if(!$user_id){
        die();
    }
    $msg = input_post('message');
    $token = input_post('token');
    if(!csrf::validate_token($token)){
        $error['invalid'] = "Bad request";
    }
    if(empty($msg)){
        $error['msg'] = 'Empty message';
    }
    if(!$error){
        $sql = "SELECT `article_id` FROM `article` WHERE `article_id` = '{$id}'";
        $row = db_get_row($sql);
        if(!$row){
            $error['dne'] = 'This article does not exists';
        }
    }
    if(!$error){
        $table = 'comment';
        $data = array(
            'cmt_id' => NULL,
            'message' => $msg,
            'created_at' => time(),
            'article_id' => $id,
            'user_id' => $user_id,
            'report' => 0
        );
        db_insert($table,$data);
        die(json_encode($error));
    }
    else{
        die(json_encode($error));
    }
    break;
    exit;
    case 'load':
        $sql = "SELECT * FROM `comment` WHERE `article_id` = '$id' ORDER BY `cmt_id` DESC LIMIT 10";
        $rows = db_get_list($sql);
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
                        <a href="comment.php?do=delete&id=<?php echo $item['cmt_id']; ?>&aid=<?php echo $id;?>" title="Xóa" data-cid="<?php echo $item['cmt_id'];?>" class="delete-cmt"><i class="fas fa-times"></i></a>
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
            <!-- chat post content -->
        </div>
        <?php
        }
    break;
    exit;
    case 'del':
        $id = isset($_GET['id']) ? abs(intval($_GET['id'])) : false;
        $result = array();
        if(!$user_id){
            die();
        }
        $sql = "SELECT `cmt_id` FROM `comment` WHERE `cmt_id` = '{$id}' AND `user_id` = '{$user_id}'";
        $row = db_get_row($sql);
        if($row){
            $dsql = "DELETE FROM `comment` WHERE `cmt_id` = '".$row['cmt_id']."'";
            if(db_execute($dsql)){
                $result['alert'] = 'ok';
            }
            else{
                $result['alert'] = 'not oke';
            }
        }
        else{
            $result['alert'] = 'error';
        }
        die(json_encode($result));
    break;
    exit;
    case 'delete':
        $id = isset($_GET['id']) ? abs(intval($_GET['id'])) : false;
        $aid = isset($_GET['aid']) ? abs(intval($_GET['aid'])) : false;
        $result = array();
        if(!$user_id){
            redirect(homeurl());
        }
        $sql = "SELECT `cmt_id` FROM `comment` WHERE `cmt_id` = '{$id}' AND `user_id` = '{$user_id}'";
        $row = db_get_row($sql);
        if($row){
            $dsql = "DELETE FROM `comment` WHERE `cmt_id` = '".$row['cmt_id']."'";
            if(db_execute($dsql)){
                redirect(Article::rewriteUrl($aid));
            }
            else{
                redirect(homeurl());
            }
        }
        else{
            redirect(homeurl());
        }
    break;
    exit;
    case 'report':
        $report = array();
        $id = isset($_GET['id']) ? abs(intval($_GET['id'])) : false;
        $sql = "SELECT `cmt_id` FROM `comment` WHERE `cmt_id` = '{$id}'";
        $row = db_get_row($sql);
        if($row){
            $sql = "UPDATE `comment` SET `report` = `report` + '1' WHERE `cmt_id` = '{$id}' LIMIT 1";
            if(db_execute($sql)){
                $report['msg'] = "success";
            }
            else{
                $report['msg'] = "error";
            }
        }
        else{
            $report['msg'] = "error";
        }
        die(json_encode($report));
        exit;
        break;
    case 'more':
        sleep(1);
        $id = isset($_GET['id']) ? abs(intval($_GET['id'])) : false;
        $skip = isset($_GET['skip']) ? abs(intval($_GET['skip'])) : false;
        $out = '';
        if($id && $skip){
            $sql = "SELECT `cmt_id`,`message`,`created_at`,`user_id` FROM `comment` WHERE `article_id` = '$id' ORDER BY `cmt_id` DESC LIMIT $skip,10";
            $rows = db_get_list($sql);
            if($rows)
            {
                foreach($rows as $item)
                {
                    $user = new account($item['user_id']);
                    $out .= '<div class="chat-post" id="cmt'.$item['cmt_id'].'">
                    <div class="chat-post-img">
                        <a href="'.account::urlAccount($item['user_id']).'"><img src="'.homeurl().$user->avatar.'" alt=""></a>
                    </div>
                    <div class="chat-post-content">
                        <div class="user-chat">
                            <a href="'.account::urlAccount($item['user_id']).'"><b style="color:#013481;font-size:11pt">'.$user->nickname.'</b></a>
                            <p class="times">cách đây '.thoigian($item['created_at']).'</p>
                            <p class="control">
                                '.(($rights == 9 || $user_id == $item['user_id']) ? '<a href="" title="Xóa" data-cid="'.$item['cmt_id'].'" class="delete-cmt"><i class="fas fa-times"></i></a>' : '').'
                                <a href="" title="Báo cáo" data-cid="'.$item['cmt_id'].'" class="report-cmt"><i class="fas fa-flag"></i></a>
                            </p>
                        </div>
                        <div class="user-comment">'.$item['message'].'</div>
                    </div>
                </div>';
                }
            }
            echo $out;
        }
    break;
    exit;
}
?>