<?php
if(!defined("IN_SITE")) die("The request not found");
$category = new Category($id);
if(!$category){
    exit;
}
?>
<script src="<?php echo homeurl();?>js/tag/dist/jQuery.tagify.min.js"></script>
<link rel="stylesheet" href="<?php echo homeurl();?>js/tag/dist/tagify.css" type="text/css">
<div class="panel-title"><h3>Chỉnh sửa chuyên mục</h3></div>
<div class="row">
    <div class="col-12">
        <form method="POST">
        <?php
        if(isset($_POST['update'])){
            $title = input_post('categoryTitle');
            $status = input_post('status');
            $data = array(
                'categoryName' => $title,
                'status' => $status
            );
            if(db_update('category',$data,array('categoryId' => $id))){
                echo'<div class="success">Cập nhật dữ liệu mới thành công !</div>';
            }
            else{
                echo 'Xảy ra lỗi khi cập nhật dữ liệu !';
            }
        }
        ?>
            <div class="box-input">
                <p>Tiêu đề : </p>
                <input type="text" name="categoryTitle" class="form-control" value="<?php echo $category->categoryName;?>" required>
            </div>
            <div class="box-input">
                <p>Trạng thái : </p>
                <select class="form-control" name="status">
                    <option value="0" <?php echo ($category->status == 0) ? 'selected' : '';?>>Hoạt động</option>
                    <option value="1" <?php echo ($category->status == 1) ? 'selected' : '';?>>Bảo trì</option>
                </select>
            </div>
            <!-- end input -->
            <div class="box-input">
                <div class="center">
                    <button type="submit" class="btn btn-create" name="update">Cập nhật</button>
                </div>
            </div>
        </form>
    </div>
    <a href="?m=category&a=index" class="back">Trở lại danh sách</a>
    <!-- end col 12 -->
</div>