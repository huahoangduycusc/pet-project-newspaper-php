<?php
if(!defined("IN_SITE")) die("The request not found");
$article = new Article($id);
if(!$article){
    exit;
}
?>
<script src="<?php echo homeurl();?>js/tag/dist/jQuery.tagify.min.js"></script>
<link rel="stylesheet" href="<?php echo homeurl();?>js/tag/dist/tagify.css" type="text/css">
<div class="panel-title"><h3>Chỉnh sửa chủ đề</h3></div>
<div class="row">
    <div class="col-12">
        <form method="POST" enctype="multipart/form-data">
        <?php
        if(isset($_POST['update'])){
            $title = input_post('title');
            $description = input_post('description');
            $category = input_post('category');
            $status = input_post('status');
            $ghim = input_post('ghim');
            $tags = input_post('tags');
            $tags =  str_replace(array('[',']','"','value','{','}',':'),"",$tags);
            $data = array(
                'category_id' => $category,
                'article_name' => $title,
                'description' => $description,
                'tags' => $tags,
                'status' => $status,
                'ghim' => $ghim,
                'user_id' => $user_id,
                'created_at' => date('Y-m-d H:m:s')
            );
            $extension = array("jpeg","jpg","png");
            if($_FILES['thumbnail']['name'] != ''){
                $path = $_FILES['thumbnail']['name'];
                $ext = pathinfo($path,PATHINFO_EXTENSION);
                if(in_array($ext,$extension)){
                    $filename = '../images/thumbnail/'.time().'.'.$ext;
                    move_uploaded_file($_FILES['thumbnail']['tmp_name'],$filename);
                    $data = array_merge($data,array('thumbnail' => "images/thumbnail/".time().".$ext"));
                }
            }
            $where = array('article_id' => $id);
            if(db_update('article',$data,$where)){
                echo'<div class="success">Cập nhật dữ liệu mới thành công <a href="'.homeurl('article/index.php?id='.$id).'"><b>'.$title.'</b></a></div>';
            }
            else{
                echo '<div class="error">Có lỗi xảy ra khi cập nhật chủ đề này.</div>';
            }
        }
        ?>
            <div class="center">
                <img src="<?php echo homeurl().$article->thumbnail;?>" style="width: 200px;">
            </div>
            <div class="box-input">
                <p>Title : </p>
                <input type="text" name="title" class="form-control" value="<?php echo $article->title;?>" required>
            </div>
            <div class="box-input">
                <p>Description : </p>
                <textarea name="description" class="form-control" rows="5" required><?php echo $article->description;?></textarea>
            </div>
            <div class="box-input">
                <p>Thumbnail : </p>
                <input type="file" name="thumbnail" class="form-control">
            </div>
            <div class="box-input">
                <p>Category : </p>
                <select class="form-control" name="category">
                <?php
                $category = Category::getList();
                foreach($category as $item)
                {
                    ?>
                    <option value="<?php echo $item['categoryId'];?>" <?php echo ($article->categoryId == $item['categoryId']) ? 'selected' : ''; ?>><?php echo $item['categoryName'];?></option>
                    <?php
                }
                ?>
                </select>
            </div>
            <div class="box-input">
                <p>Tags : </p>
                <input type="text" name="tags" class="form-control" value="<?php echo $article->tags;?>" required>
            </div>
            <div class="box-input">
                <p>Status : </p>
                <select class="form-control" name="status">
                    <option value="0" <?php echo ($article->status == 0) ? 'selected' : '';?>>Chưa kiểm duyệt</option>
                    <option value="1" <?php echo ($article->status == 1) ? 'selected' : '';?>>Đã kiểm duyệt</option>
                </select>
            </div>
            <div class="box-input">
                <p>Quyền ưu tiên : </p>
                <div class="list-radio">
                    <p><input type="radio" name="ghim" value="0" <?php echo ($article->ghim == 0) ? 'checked' : '';?>>Chủ đề thường</p>
                    <p><input type="radio" name="ghim" value="1" <?php echo ($article->ghim == 1) ? 'checked' : '';?>>Chủ đề thịnh hành</p>
                    <p><input type="radio" name="ghim" value="2" <?php echo ($article->ghim == 2) ? 'checked' : '';?>>Chủ đề quan trọng</p>
                </div>
            </div>
            <!-- end input -->
            <div class="box-input">
                <div class="center">
                    <button type="submit" class="btn btn-create" name="update">Cập nhật</button>
                </div>
            </div>
        </form>
    </div>
    <a href="?m=article&a=index" class="back">Trở lại danh sách</a>
    <!-- end col 12 -->
</div>
<!-- end row -->
<script src="<?php echo homeurl();?>/js/ckeditor/ckeditor.js"></script>
<script src="<?php echo homeurl();?>/js/ckfinder/ckfinder.js"></script>
<script>
    CKEDITOR.replace('description');
    // jQuery
    $('[name=tags]').tagify();

    // Vanilla JavaScript
    var input = document.querySelector('input[name=tags]'),
    tagify = new Tagify( input );
    $('[name=tags]').tagify({duplicates : false});
</script>