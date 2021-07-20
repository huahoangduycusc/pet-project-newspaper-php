<?php
sleep(1);
define('IN_SITE',true);
$rootpath = '../../../';
require_once('../../../libs/core.php');
if($rights < 9){
    exit;
}
$name = isset($_GET['sname']) ? htmlspecialchars($_GET['sname']) : false;
if($name){
    $out = "";
    $list = account::searchAccount($name);
    foreach($list as $item){
        $out .= '<tr>
        <td class="td-avatar">
        <a href="'.account::urlAccount($item['id']).'"><img src="'.homeurl().$item['avatar'].'"></a></td>
        <td><a href="'.homeurl().'user/?id='.$item['id'].'">'.$item['username'].'</a></td>
        <td>'.$item['fullname'].'</td>
        <td>'.account::gender($item['gender']).'</td>
        <td>'.$item['birthday'].'</td>
        <td>'.account::nameRole($item['role']).'</td>
        <td>
            <a href="?m=account&a=edit&id='.$item['id'].'" class="btn-circle bg-warning"><i class="fas fa-pen"></i></a>
            <a href="?m=account&a=index&id='.$item['id'].'&do=delete" class="btn-circle bg-danger" ><i class="fas fa-times"></i></a>
        </td>
    </tr>';
    }
    echo $out;
}
?>