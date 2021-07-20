<?php
if(!defined("IN_SITE")) die("The request not found");
switch($do){
    case 'delete':
        if(Article::delete($id) == true){
            $message = "<div class='success'>Xóa bài viết thành công !</div>";
        }
        else{
            $message = "<div class='error'>Xảy ra lỗi khi xóa !</div>";
        }
        break;
        exit;
}
?>
<div class="panel-title"><h3>Bài viết</h3></div>
<div class="row">
    <div class="col-6 col-sm-6" style="margin-top:10px">
        <a href="?m=article&a=create" class="button"><i class="fas fa-plus"></i> Tạo mới</a>
    </div>
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
            <div class="card-header"><h3>Danh sách bài viết</h3></div>
            <div class="card-content">
                <table class="table-re">
                    <tr>
                        <th>Ảnh đại diện</th>
                        <th>Tiêu đề</th>
                        <th>Tác giả</th>
                        <th>Lượt xem</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                    <tbody>
                        <?php
                        $list = Article::latestArticle(1);
                        foreach($list as $item)
                        {
                            ?>
                            <tr>
                                <td style="width:120px;">
                                <a href="<?php echo Article::rewriteUrl($item['article_id']);?>"><img src="<?php echo homeurl().$item['thumbnail'];?>" style="width:100%" /></a></td>
                                <td style="width:30%">
                                    <a href="<?php echo Article::rewriteUrl($item['article_id']);?>"><?php echo $item['article_name'];?></a>
                                </td>
                                <td><a href="<?php echo homeurl();?>user/?id=<?php echo $item['id'];?>"><?php echo $item['username'];?></a></td>
                                <td><?php echo $item['view'];?></td>
                                <td>
                                    <?php
                                    if($item['status'] == 0)
                                    {
                                        echo '<font color="red">Chưa duyệt</font>';
                                    }
                                    else if($item['status'] == 1){
                                        echo '<font color="green">Đã duyệt</font>';
                                    }
                                    else if($item['status'] == 2){
                                        echo '<font color="blue">Đã ẩn</font>';
                                    }
                                    ?>
                                </td>
                                <td><?php echo $item['created_at'];?></td>
                                <td>
                                    <a href="?m=article&a=edit&id=<?php echo $item['article_id'];?>" class="btn-circle bg-warning"><i class="fas fa-pen"></i></a>
                                    <a href="?m=article&a=index&id=<?php echo $item['article_id'];?>&do=delete" class="btn-circle bg-danger" onclick="if (! confirm('Continue?')) { return false; }"><i class="fas fa-times"></i></a>
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
            $demtrang = db_count('article','article_id');
            $config = [
                'total' => $demtrang,
                'querys' => $id,
                'limit' => $limit,
                'url' => 'admin/?m=article&a=index'
            ];
            $page1 = new Pagination($config);
            if($demtrang > $limit)
            {
                echo'<div><center><ul class="pagination">'.$page1->getPagination().'</ul></center></div>';
            }
        ?>
    </div>
</div>