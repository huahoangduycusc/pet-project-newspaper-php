<?php
if(!defined("IN_SITE")) die("The request not found");
$blog = new Blog($id);
if(!$blog){
    exit;
}
?>
<div class="panel-title"><h3>Chỉnh sửa blog</h3></div>
<div class="row">
    <div class="col-12">
        <form method="POST" enctype="multipart/form-data" autocomplete="off">
        <?php
        if(isset($_POST['update'])){
            $titles = input_post('title');
            $description = input_post('description');
            $status = input_post('status');
            $data = array(
                'blog_title' => $titles,
                'blog_msg' => $description,
                'blog_status' => $status
            );
            $extension = array("jpeg","jpg","png");
            if($_FILES['thumbnail']['name'] != ''){
                $path = $_FILES['thumbnail']['name'];
                $ext = pathinfo($path,PATHINFO_EXTENSION);
                if(in_array($ext,$extension)){
                    $filename = '../images/blog/'.time().'.'.$ext;
                    move_uploaded_file($_FILES['thumbnail']['tmp_name'],$filename);
                    $data = array_merge($data,array('thumbnail' => "images/blog/".time().".$ext"));
                }
            }
            $where = array('blog_id' => $id);
            if(db_update('blog',$data,$where)){
                echo'<div class="success">Cập nhật dữ liệu mới thành công <a href="'.homeurl('article/index.php?id='.$id).'"><b>'.$titles.'</b></a></div>';
            }
            else{
                echo '<div class="error">Có lỗi xảy ra khi cập nhật chủ đề này.</div>';
            }
        }
        ?>
            <div class="center">
                <img src="<?php echo homeurl().$blog->thumbnail;?>" style="width: 200px;">
            </div>
            <div class="box-input">
                <p>Title : </p>
                <input type="text" name="title" class="form-control" value="<?php echo $blog->blog_title;?>" required>
            </div>
            <div class="box-input">
                <p>Description : </p>
                <textarea name="description" class="form-control" rows="5" required><?php echo $blog->blog_msg;?></textarea>
            </div>
            <div class="box-input">
                <p>Thumbnail : </p>
                <input type="file" name="thumbnail" class="form-control">
            </div>
            <div class="box-input">
                <p>Status : </p>
                <select class="form-control" name="status">
                    <option value="0" <?php echo ($blog->status == 0) ? 'selected' : '';?>>Hiển thị</option>
                    <option value="1" <?php echo ($blog->status == 1) ? 'selected' : '';?>>Tạm ẩn</option>
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
    <a href="?m=blog&a=index" class="back">Trở lại danh sách</a>
    <!-- end col 12 -->
</div>
<!-- end row -->
<script src="<?php echo homeurl();?>/js/ckeditor/ckeditor.js"></script>
<script src="<?php echo homeurl();?>/js/ckfinder/ckfinder.js"></script>
<script>
    CKEDITOR.replace('description');
</script>