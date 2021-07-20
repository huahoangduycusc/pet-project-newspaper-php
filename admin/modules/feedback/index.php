<?php
if(!defined("IN_SITE")) die("The request not found");
if($rights < 9){
    exit;
}
switch($do){
    case 'delete':
        if(Feedback::delete($id) == true){
            $message = "<div class='success'>Xóa Feedback thành công !</div>";
        }
        else{
            $message = "<div class='error'>Xảy ra lỗi khi xóa !</div>";
        }
        break;
        exit;
}
?>
<div class="panel-title"><h3>Phản hồi</h3></div>
<div class="row">
    <div class="col-6 col-sm-6" style="margin-top:10px">
        <a href="" class="button bg-danger"><i class="fas fa-print"></i> In</a>
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
            <div class="card-header"><h3>Danh sách feedback</h3></div>
            <div class="card-content">
                <table class="table-re">
                    <tr>
                        <th>Tiêu đề</th>
                        <th>Email</th>
                        <th>Thời gian</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                    <tbody>
                        <?php
                        $list = Feedback::getList();
                        foreach($list as $item)
                        {
                            ?>
                            <tr>
                            
                                <td><?php echo $item['title'];?></td>
                                <td><?php echo $item['email'];?></td>
                                <td><?php echo $item['created_at'];?></td>
                                <td><?php echo ($item['seen'] == 1) ? '<font color="green">Đã xem</font>' : '<font color="red">Chưa xem</font>';?></td>
                                <td>
                                    <a href="" data-id="<?php echo $item['fb_id'];?>" class="btn-circle bg-warning"><i class="fas fa-eye"></i></a>
                                    <a href="?m=feedback&a=index&do=delete&id=<?php echo $item['fb_id'];?>" class="btn-circle bg-danger" onclick="if (! confirm('Continue?')) { return false; }"><i class="fas fa-times"></i></a>
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
            $demtrang = db_count('feedback','fb_id');
            $config = [
                'total' => $demtrang,
                'querys' => $id,
                'limit' => $limit,
                'url' => 'admin/?m=feedback&a=index'
            ];
            $page1 = new Pagination($config);
            if($demtrang > $limit)
            {
                echo'<div><center><ul class="pagination">'.$page1->getPagination().'</ul></center></div>';
            }
        ?>
    </div>
</div>
<script src="<?php echo homeurl();?>admin/modules/feedback/app.js"></script>