<?php
if(!defined("IN_SITE")) die("The request not found");
if($rights < 9){
    exit;
}
?>
<div class="panel-title"><h3>Danh sách người dùng bị khóa</h3></div>
<div class="row">
    <div class="col-4 col-sm-4" style="margin-top:10px">
        <a href="?m=account&a=index" class="button bg-primary"><i class="fas fa-undo"></i> Quay lại</a>
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
                        <th>Tài khoản</th>
                        <th>Người khóa</th>
                        <th>Thời hạn</th>
                        <th>Lý do</th>
                        <th>Thao tác</th>
                    </tr>
                    <tbody>
                        <?php
                        $list = account::getListBan();
                        foreach($list as $item)
                        {
                            ?>
                            <tr>
                                <td><a href="<?php echo account::urlAccount($item['ban_user']);?>"><?php echo account::getName($item['ban_user']);?></a></td>
                                <td><a href="<?php echo account::urlAccount($item['ban_author']);?>"><?php echo account::getName($item['ban_author']);?></a></td>
                                <td><?php echo date("H:i:s d-m-Y", $item['ban_time']);?></td>
                                <td><?php echo $item['ban_message'];?></td>
                                <td>
                                    <a href="?m=account&a=edit&id=<?php echo $item['ban_id'];?>" class="btn-circle bg-warning"><i class="fas fa-pen"></i></a>
                                    <a href="?m=account&a=index&id=<?php echo $item['ban_msg'];?>&do=delete" class="btn-circle bg-danger" onclick="if (! confirm('Continue?')) { return false; }"><i class="fas fa-times"></i></a>
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
            $demtrang = db_count('account_ban','ban_id');
            $config = [
                'total' => $demtrang,
                'querys' => $id,
                'limit' => $limit,
                'url' => 'admin/?m=account&a=ban'
            ];
            $page1 = new Pagination($config);
            if($demtrang > $limit)
            {
                echo'<div><center><ul class="pagination">'.$page1->getPagination().'</ul></center></div>';
            }
        ?>
    </div>
</div>