<?php
if(!defined("IN_SITE")) die("The request not found");
if($rights < 9){
    exit;
}
switch($do){
    case 'delete':
        if(account::delete($id) == true){
            $message = "<div class='success'>Xóa tài khoản thành công !</div>";
        }
        else{
            $message = "<div class='error'>Xảy ra lỗi khi xóa vì dữ liệu liên quan. !</div>";
        }
        break;
        exit;
}
?>
<div class="panel-title"><h3>Danh sách người dùng</h3></div>
<div class="row">
    <div class="col-6 col-sm-6" style="margin-top:10px">
        <a href="?m=account&a=create" class="button"><i class="fas fa-plus"></i> Tạo mới</a>
    </div>
    <div class="col-6 col-sm-6" style="margin-top:10px">
        <a href="" class="button bg-danger"><i class="fas fa-print"></i> In</a>
    </div>
    <div class="col-4 col-sm-4" style="margin-top:10px">
        <a href="?m=account&a=ban" class="button bg-primary"><i class="fas fa-user-lock"></i> Người dùng bị khóa</a>
    </div>
</div>
<?php
if(isset($message))
{
    ?>
    <div class="center"><?php echo $message;?></div>
    <?php
}
?>
<div class="row">
    <div class="col-12 col-m-12">
        <div class="card">
            <div class="card-header"><h3>Danh sách người dùng</h3></div>
            <div class="card-content">
                <table class="table-re">
                    <tr>
                        <th>Avatar</th>
                        <th>Username</th>
                        <th>Họ tên</th>
                        <th>Giới tính</th>
                        <th>Năm sinh</th>
                        <th>Chức vụ</th>
                        <th>Thao tác</th>
                    </tr>
                    <tbody>
                        <?php
                        $list = account::getList();
                        foreach($list as $item)
                        {
                            ?>
                            <tr>
                                <td class="td-avatar">
                                <a href="<?php echo account::urlAccount($item['id']);?>"><img src="<?php echo homeurl().$item['avatar'];?>"></a></td>
                                <td><a href="<?php echo account::urlAccount($item['id']);?>"><?php echo $item['username'];?></a></td>
                                <td><?php echo $item['fullname'];?></td>
                                <td><?php echo account::gender($item['gender']);?></td>
                                <td><?php echo $item['birthday'];?></td>
                                <td><?php echo account::nameRole($item['role']);?></td>
                                <td>
                                    <a href="?m=account&a=edit&id=<?php echo $item['id'];?>" class="btn-circle bg-warning"><i class="fas fa-pen"></i></a>
                                    <a href="?m=account&a=index&id=<?php echo $item['id'];?>&do=delete" class="btn-circle bg-danger" onclick="if (! confirm('Continue?')) { return false; }"><i class="fas fa-times"></i></a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
            $demtrang = db_count('account','id');
            $config = [
                'total' => $demtrang,
                'querys' => $id,
                'limit' => $limit,
                'url' => 'admin/?m=account&a=index'
            ];
            $page1 = new Pagination($config);
            if($demtrang > $limit)
            {
                echo'<div><center><ul class="pagination">'.$page1->getPagination().'</ul></center></div>';
            }
        ?>
    </div>
</div>