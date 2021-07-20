<?php
if(!defined("IN_SITE")) die("The request not found");
?>
<script src="<?php echo homeurl();?>js/tag/dist/jQuery.tagify.min.js"></script>
<link rel="stylesheet" href="<?php echo homeurl();?>js/tag/dist/tagify.css" type="text/css">
<style>
    #previewImg{
        width: 300px;
        margin: 0 auto;
        display: block;
    }
</style>
<div class="panel-title"><h3>Tạo chủ đề mới</h3></div>
<div class="row">
    <div class="col-12">
        <form method="POST" enctype="multipart/form-data" autocomplete="off">
        <?php
        if(isset($_POST['create'])){
            $title = input_post('title');
            $description = input_post('description');
            $category = input_post('category');
            $status = input_post('status');
            $ghim = input_post('ghim');
            $tags = input_post('tags');
            $tags =  str_replace(array('[',']','"','value','{','}',':'),"",$tags);
            $extension = array("jpeg","jpg","png");
            if($_FILES['thumbnail']['name'] != ''){
                $path = $_FILES['thumbnail']['name'];
                $ext = pathinfo($path,PATHINFO_EXTENSION);
                if(in_array($ext,$extension)){
                    $filename = 'images/thumbnail/'.time().'.'.$ext;
                    move_uploaded_file($_FILES['thumbnail']['tmp_name'],"../".$filename);
                    $data = array(
                        'category_id' => $category,
                        'article_name' => $title,
                        'description' => $description,
                        'thumbnail' => $filename,
                        'view' => 0,
                        'tags' => $tags,
                        'status' => $status,
                        'ghim' => $ghim,
                        'user_id' => $user_id,
                        'created_at' => date('Y-m-d H:m:s')
                    );
                    if(db_insert('article',$data)){
                        $rid = db_get_insert_id();
                        /// create notification to people are following me
                        Notification::createNoti($rid);
                        echo'<div class="success">Tạo chủ đề mới thành công <a href="'.homeurl('article/index.php?id='.$rid).'"><b>'.$title.'</b></a></div>';
                    }
                    else{
                        echo '<div class="error">Có lỗi xảy ra khi tạo chủ đề này.</div>';
                    }
                }
            }
        }
        ?>
            <div class="box-input">
                <p>Title : </p>
                <input type="text" name="title" class="form-control" required autocomplete="off">
            </div>
            <div class="box-input">
                <p>Description : </p>
                <textarea name="description" id="description" class="form-control" rows="5" required></textarea>
            </div>
            <div class="box-input">
                <p>Thumbnail : </p>
                <input type="file" name="thumbnail" class="form-control" onchange="previewFile();" required>
            </div>
            <div class="form-group">
                <img id="previewImg" src="" alt="Thumbnail" class="preview-img">
            </div>
            <div class="box-input">
                <p>Chuyên mục : </p>
                <select class="form-control" name="category">
                <?php
                $category = Category::getList();
                foreach($category as $item)
                {
                    ?>
                    <option value="<?php echo $item['categoryId'];?>"><?php echo $item['categoryName'];?></option>
                    <?php
                }
                ?>
                </select>
            </div>
            <div class="box-input">
                <p>Thẻ : </p>
                <input type="text" name="tags" class="form-control" value='kpop,tdm' required>
            </div>
            <div class="box-input">
                <p>Trạng thái : </p>
                <select class="form-control" name="status">
                    <option value="0">Chưa kiểm duyệt</option>
                    <option value="1" selected>Đã kiểm duyệt</option>
                </select>
            </div>
            <div class="box-input">
                <p>Quyền ưu tiên : </p>
                <div class="list-radio">
                    <p><input type="radio" name="ghim" value="0" checked>Chủ đề thường</p>
                    <p><input type="radio" name="ghim" value="1">Chủ đề thịnh hành</p>
                    <p><input type="radio" name="ghim" value="2">Chủ đề quan trọng</p>
                </div>
            </div>
            <!-- end input -->
            <div class="box-input">
                <div class="center">
                    <button type="submit" class="btn btn-create" name="create">Tạo mới</button>
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
<script>
    function previewFile(input){
        var file = $("input[type=file]").get(0).files[0];
 
        if(file){
            var reader = new FileReader();
 
            reader.onload = function(){
                $("#previewImg").attr("src", reader.result);
            }
 
            reader.readAsDataURL(file);
        }
    }
</script>