<?php
if(!defined("IN_SITE")) die("The request not found");
if($rights < 9){
    exit;
}
switch($do){
    case 'delete':
        if(Comment::delete($id) == true){
            $message = "<div class='success'>Xóa bình luận thành công !</div>";
        }
        else{
            $message = "<div class='error'>Xảy ra lỗi khi xóa !</div>";
        }
        break;
        exit;
}
?>
<div class="panel-title"><h3>Bình luận vi phạm</h3></div>
<?php
if(isset($message))
{
    ?>
    <div class="center"><?php echo $message;?></div>
    <?php
}
?>
<div class="col-4 col-sm-4" style="margin-top:10px">
<a href="?m=comment&a=index" class="button bg-primary"><i class="fas fa-undo"></i> Quay lại</a>
</div>
<div class="row">
    <div class="col-12 col-m-12">
        <div class="card">
            <div class="card-header"><h3>Danh sách bình luận vi phạm</h3></div>
            <div class="card-content">
                <table class="table-re">
                    <tr>
                        <th>Thời gian</th>
                        <th>Người gửi</th>
                        <th>Nội dung</th>
                        <th>Chủ đề</th>
                        <th>Báo cáo</th>
                        <th>Thao tác</th>
                    </tr>
                    <tbody>
                        <?php
                        $list = Comment::getListReport();
                        foreach($list as $item)
                        {
                            ?>
                            <tr>
                            
                                <td><?php echo date("H:m:s d-m-Y",$item['created_at']);?></td>
                                <td><a href="<?php echo account::urlAccount($item['user_id']);?>"><?php echo account::getName($item['user_id']);?></a></td>
                                <td><?php echo $item['message'];?></td>
                                <td><a href="<?php echo Article::rewriteUrl($item['article_id']); ?>"><?php echo $item['article_name'];?></a></td>
                                <td><?php echo $item['report'];?> lượt</td>
                                <td>
                                    <a href="?m=comment&a=report&do=delete&id=<?php echo $item['cmt_id'];?>" class="btn-circle bg-danger" onclick="if (! confirm('Continue?')) { return false; }"><i class="fas fa-times"></i></a>
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
        $demtrang = db_count_query("SELECT `cmt_id` FROM `comment` WHERE `report` > 0");
        $config = [
            'total' => $demtrang,
            'querys' => $id,
            'limit' => $limit,
            'url' => 'admin/?m=comment&a=report'
        ];
        $page1 = new Pagination($config);
        if($demtrang > $limit)
        {
            echo'<div><center><ul class="pagination">'.$page1->getPagination().'</ul></center></div>';
        }
        ?>
    </div>
</div>