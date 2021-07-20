<?php
if(!defined("IN_SITE")) die("The request not found");
if($rights < 9){
    exit;
}
switch($do){
    case 'delete':
        if(category::delete($id) == true){
            $message = "<div class='success'>Xóa chuyên mục thành công !</div>";
        }
        else{
            $message = "<div class='error'>Xảy ra lỗi khi xóa vì chuyên mục có thể chứa các bài viết hoặc không tồn tại!</div>";
        }
        break;
        exit;
}
?>
<div class="panel-title"><h3>Chuyên mục</h3></div>
<div class="row">
    <div class="col-6 col-sm-6" style="margin-top:10px">
        <a href="?m=category&a=create" class="button"><i class="fas fa-plus"></i> Tạo mới</a>
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
            <div class="card-header"><h3>Danh sách chuyên mục</h3></div>
            <div class="card-content">
                <table class="table-re">
                    <tr>
                        <th>Tên</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                    <tbody>
                        <?php
                        $list = Category::getList();
                        foreach($list as $item)
                        {
                            ?>
                            <tr>
                            
                                <td><?php echo $item['categoryName'];?></td>
                                <td><?php echo ($item['status'] == 0) ? '<font color="green">Đang hoạt động</font>' : '<font color="red">Bảo trì</font>';?></td>
                                <td>
                                    <a href="?m=category&a=edit&id=<?php echo $item['categoryId'];?>" class="btn-circle bg-warning"><i class="fas fa-pen"></i></a>
                                    <a href="?m=category&a=index&do=delete&id=<?php echo $item['categoryId'];?>" class="btn-circle bg-danger" onclick="if (! confirm('Continue?')) { return false; }"><i class="fas fa-times"></i></a>
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