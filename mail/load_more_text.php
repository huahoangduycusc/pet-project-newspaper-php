<?php
sleep(1);
define('IN_SITE',true);
require_once('../libs/core.php');
$out = '';
$start = abs(intval($_POST['skip']));
$id = abs(intval($_POST['id']));
$rows = Mail::getListMessage($id);
if($rows){
    foreach (Mail::getListMessage($id) as $item)
    {
        if ($item['from_user'] == $user_id)
        {
            $out .= '<div class="mail-from">
                <div class="mail-avatar">
                    <a href="'.account::urlAccount($item['from_user']).'">
                        <img src="'.homeurl().$item['avatar'].'" alt="">
                    </a>
                </div>
                <!-- mail avatar -->
                <div class="mail-content">
                    <div class="mail-msg">
                        <p><a href="'.account::urlAccount($item['from_user']).'"><b>'.account::getName($item['from_user']).'</b></a></p>
                        '.$item['content'].'
                    </div>
                    <div class="mail-times">
                        '.thoigian($item['created_at']).'
                    </div>
                </div>
            </div>';
            }
        else
        {
            $out.= '<div class="mail-to">
                <div class="mail-content">
                    <div class="mail-msg">
                        <p><a href="'.account::urlAccount($item['from_user']).'"><b>'.account::getName($item['from_user']).'</b></a></p>
                        '.$item['content'].'
                    </div>
                    <div class="mail-times">
                    '.thoigian($item['created_at']).'
                    </div>
                </div>
                <div class="mail-avatar">
                    <a href="'.account::urlAccount($item['from_user']).'">
                        <img src="'.homeurl().$item['avatar'].'" alt="">
                    </a>
                </div>
                <!-- mail avatar -->
            </div>';
        }
    }
    echo $out;
}
?>