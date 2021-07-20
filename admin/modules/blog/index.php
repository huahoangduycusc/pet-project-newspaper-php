<?php
if(!defined("IN_SITE")) die("The request not found");
if($rights < 9){
    exit;
}
switch($do){
    case 'delete':
        if(Blog::delete($id) == true){
            $message = "<div class='success'>Xóa blog thành công !</div>";
        }
        else{
            $message = "<div class='error'>Xảy ra lỗi khi xóa !</div>";
        }
        break;
        exit;
}
?>
<div class="panel-title"><h3>Blog</h3></div>
<div class="row">
    <div class="col-6 col-sm-6" style="margin-top:10px">
        <a href="?m=blog&a=create" class="button"><i class="fas fa-plus"></i> Tạo mới</a>
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
            <div class="card-header"><h3>Danh sách blog</h3></div>
            <div class="card-content">
                <table class="table-re">
                    <tr>
                        <th>Ảnh đại diện</th>
                        <th>Tiêu đề</th>
                        <th>Tác giả</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                    <tbody>
                        <?php
                        $list = Blog::getList();
                        foreach($list as $item)
                        {
                            ?>
                            <tr>
                                <td style="width:120px;">
                                <a href="<?php echo Blog::rewriteUrl($item['blog_id']);?>"><img src="<?php echo homeurl().$item['thumbnail'];?>" style="width:100%" /></a></td>
                                <td style="width:30%">
                                    <a href="<?php echo Blog::rewriteUrl($item['blog_id']);?>"><?php echo $item['blog_title'];?></a>
                                </td>
                                <td><a href="<?php echo homeurl();?>user/?id=<?php echo $item['user_id'];?>"><?php echo $item['username'];?></a></td>
                                <td><?php echo ($item['blog_status'] == 0) ? '<font color="green">Đang hoạt động</font>' : '<font color="red">Bảo trì</font>';?></td>
                                <td><?php echo date("H:m:s d-m-Y",$item['created_at']);?></td>
                                <td>
                                    <a href="?m=blog&a=edit&id=<?php echo $item['blog_id'];?>" class="btn-circle bg-warning"><i class="fas fa-pen"></i></a>
                                    <a href="?m=blog&a=index&id=<?php echo $item['blog_id'];?>&do=delete" class="btn-circle bg-danger" onclick="if (! confirm('Continue?')) { return false; }"><i class="fas fa-times"></i></a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- @Html.PagedListPager(Model, page => Url.Action("List", "Article", new { page })) -->
    </div>
</div>