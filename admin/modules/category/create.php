<?php
if(!defined("IN_SITE")) die("The request not found");
?>
<script src="<?php echo homeurl();?>js/tag/dist/jQuery.tagify.min.js"></script>
<link rel="stylesheet" href="<?php echo homeurl();?>js/tag/dist/tagify.css" type="text/css">
<div class="panel-title"><h3>Tạo chuyên mục mới</h3></div>
<div class="row">
    <div class="col-12">
        <form method="POST">
        <?php
        if(isset($_POST['create'])){
            $title = input_post('categoryTitle');
            $status = input_post('status');
            $data = array(
                'categoryName' => $title,
                'status' => $status
            );
            if(db_insert('category',$data)){
                echo'<div class="success">Tạo chuyên mục mới thành công !</div>';
            }
            else{
                echo 'Xảy ra lỗi khi tạo chuyên mục !';
            }
        }
        ?>
            <div class="box-input">
                <p>Tiêu đề : </p>
                <input type="text" name="categoryTitle" class="form-control" required>
            </div>
            <div class="box-input">
                <p>Trạng thái : </p>
                <select class="form-control" name="status">
                    <option value="0">Hoạt động</option>
                    <option value="1">Bảo trì</option>
                </select>
            </div>
            <!-- end input -->
            <div class="box-input">
                <div class="center">
                    <button type="submit" class="btn btn-create" name="create">Create</button>
                </div>
            </div>
        </form>
    </div>
    <a href="?m=category&a=index" class="back">Trở lại danh sách</a>
    <!-- end col 12 -->
</div>