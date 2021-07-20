<?php
if(!defined("IN_SITE")) die("The request not found");
$error = array();
?>
<div class="panel-title"><h3>Tạo blog mới</h3></div>
<div class="row">
    <div class="col-12">
        <form method="POST" enctype="multipart/form-data" autocomplete="off">
        <?php
        if(isset($_POST['create'])){
            $titles = input_post('title');
            $description = input_post('description');
            $status = input_post('status');
            $status = abs(intval($status));
            $extension = array("jpeg","jpg","png");
            if(empty($titles)){
                $error['title'] = 'Tiêu đề không được bỏ trống';
            }
            if(empty($description)){
                $error['description'] = 'Nội dung không được bỏ trống';
            }
            if($status < 0 || $status > 1){
                $error['status'] = 'Bạn đang cố gắng phá hủy hệ thống';
            }
            if($_FILES['thumbnail']['name'] == ''){
                $error['thumbnail'] = 'Vui lòng chọn ảnh đại diện';
            }
            if(!$error){
                if($_FILES['thumbnail']['name'] != ''){
                    $path = $_FILES['thumbnail']['name'];
                    $ext = pathinfo($path,PATHINFO_EXTENSION);
                    if(in_array($ext,$extension)){
                        $filename = 'images/blog/'.time().'.'.$ext;
                        move_uploaded_file($_FILES['thumbnail']['tmp_name'],"../".$filename);
                        $data = array(
                            'blog_title' => $titles,
                            'blog_msg' => $description,
                            'user_id' => $user_id,
                            'thumbnail' => $filename,
                            'blog_status' => $status,
                            'created_at' => time()
                        );
                        if(db_insert('blog',$data)){
                            $rid = db_get_insert_id();
                            echo'<div class="success">Tạo blog mới thành công <a href="'.homeurl('blog/index.php?id='.$rid).'"><b>'.$titles.'</b></a></div>';
                        }
                        else{
                            echo '<div class="error">Có lỗi xảy ra khi tạo blog.</div>';
                        }
                    }
                    else{
                        $error['thumbnail'] = 'Ảnh đăng tải không hợp lệ, đuôi ảnh phải là PNG, JPG hoặc JPEG';
                    }
                }
            }
        }
        ?>
            <div class="box-input">
                <p>Title : </p>
                <?php
                if($error){
                    showError($error,'title');
                }
                ?>
                <input type="text" name="title" class="form-control" value="<?php echo isset($titles) ? $titles : '';?>">
            </div>
            <div class="box-input">
                <?php
                if($error){
                    showError($error,'description');
                }
                ?>
                <p>Description : </p>
                <textarea name="description" class="form-control" rows="5"><?php echo isset($description) ? $description : '';?></textarea>
            </div>
            <div class="box-input">
                <?php
                if($error){
                    showError($error,'thumbnail');
                }
                ?>
                <p>Ảnh đại diện : </p>
                <input type="file" name="thumbnail" class="form-control">
            </div>
            <div class="box-input">
                <?php
                if($error){
                    showError($error,'status');
                }
                ?>
                <p>Trạng thái : </p>
                <select class="form-control" name="status">
                    <option value="0">Hiển thị</option>
                    <option value="1">Đã ẩn</option>
                </select>
            </div>
            <!-- end input -->
            <div class="box-input">
                <div class="center">
                    <button type="submit" class="btn btn-create" name="create">Tạo mới</button>
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