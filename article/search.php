<?php
define('IN_SITE',true);
require_once('../libs/core.php');
$title = "Tìm kiếm";
require_once('../libs/header.php');
$s = isset($_GET['s']) ? htmlspecialchars($_GET['s']) : '';
?>
<div class="fit">
    <div class="back-category">
    <img src="<?php echo homeurl();?>images/category.jpg" alt="">
        <div class="category-title">
            <div class="category-title-header">
                <p>Khám phá</p>
                <h1>Tìm kiếm</h1>
            </div>
        </div>
    </div>
</div>
<section class="bg-category fit">
    <div class="list-article" id="article">
        <?php
        foreach(Article::searchByTitle($s) as $row){
        ?>
        <div class="list-article-item">
            <div class="list-article-img">
                <a href="<?php echo homeurl();?>article/?id=<?php echo $row['article_id'];?>"><img src="<?php echo homeurl().$row['thumbnail'];?>" alt=""></a>
            </div>
            <div class="list-article-infor">
                <div class="list-article-col-8">
                    <a href="<?php echo homeurl();?>article/?id=<?php echo $row['article_id'];?>"><?php echo $row['article_name'];?></a>
                </div>
                <div class="list-article-col-4">
                    <span><?php echo $row['created_at'];?></span>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
    <!-- list article -->
    <?php
    $count = Article::countSearch($s);
    if($count > 10)
    {
        ?>
        <div class="load-bg"><a href="" id="getMore" data-art="<?php echo $id;?>" class="load_more_bg">Load more</a></div>
        <?php
    }
    else if($count == 0){
        ?>
        <div class="empty">Không tìm thấy dữ liệu nào phù hợp !</div>
        <?php
    }
    ?>
</section>
<?php
require_once('../libs/footer.php');
?>
<script>
var skip = 10;
var flag = false;
$(document).ready(function () {
    $('#getMore').click(function (e) {
        if(flag == true){
            return false;
        }
        flag = true;
        e.preventDefault();
        $('#getMore').html("Loading..");
        $.ajax({
            url: 'load_more_search.php',
            type: 'GET',
            dataType: "text",
            data: {
                s: <?php echo json_encode($s);?>,
                skip: skip
            },
            success: function (data) {
                skip += skip;
                if (data == "") {
                    //alert("Hết dữ liệu");
                    $('#getMore').fadeOut();
                }
                $('#article').append(data);
                $('#getMore').html("Load more");
                flag = false;
            }
        });
    });
});
</script>