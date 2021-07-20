<?php
if(!defined("IN_SITE")) die("The request not found");
$baiviet = db_count('article','article_id');
$account = db_count('account','id');
$blog = db_count('blog','blog_id');
$category = db_count('category','categoryId');
$comment = db_count('comment','cmt_id');
$feedback = db_count('feedback','fb_id');
?>
<div class="row">
    <div class="col-3 col-m-6 col-sm-6">
        <div class="counter bg-primary">
            <p><i class="fas fa-tasks"></i></p>
            <h3><?php echo $baiviet;?></h3>
            <p>Bài viết</p>
        </div>
    </div>
    <div class="col-3 col-m-6 col-sm-6">
        <div class="counter bg-warning">
            <p><i class="fas fa-spinner"></i></p>
            <h3><?php echo $account;?></h3>
            <p>Người dùng</p>
        </div>
    </div>
    <div class="col-3 col-m-6 col-sm-6">
        <div class="counter bg-success">
            <p><i class="fas fa-check-circle"></i></p>
            <h3><?php echo $blog;?></h3>
            <p>Blog</p>
        </div>
    </div>
    <div class="col-3 col-m-6 col-sm-6">
        <div class="counter bg-danger">
            <p><i class="fas fa-bug"></i></p>
            <h3><?php echo $category;?></h3>
            <p>Chuyên mục</p>
        </div>
    </div>
    <div class="col-3 col-m-6 col-sm-6">
        <div class="counter bg-green">
            <p><i class="fas fa-bug"></i></p>
            <h3><?php echo $comment;?></h3>
            <p>Bình luận</p>
        </div>
    </div>
    <div class="col-3 col-m-6 col-sm-6">
        <div class="counter bg-pink">
            <p><i class="fas fa-bug"></i></p>
            <h3><?php echo $feedback;?></h3>
            <p>Feedback</p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-m-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3>Thống kê lượt xem</h3>
            </div>
            <div class="card-content">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
</div>
<!-- import script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<?php
$label = array();
$view = array();
foreach(Article::chartInYear() as $l){
    $label[] = $l['date'];
    $view[] = $l['view'];
}
?>
<script>
    const successColor = '#6ab04c';
    const dangerColor = '#eb4d4b';
    var ctx = document.getElementById('myChart')
    ctx.height = 500
    ctx.width = 500
    var data = {
        labels: <?php echo json_encode($label);?>,
        datasets: [{
            fill: false,
            label: 'Lượt đọc',
            borderColor: successColor,
            hoverBackgroundColor: '#ff5159',
            hoverBorderColor: 'red',
            data: <?php echo json_encode($view);?>,
            borderWidth: 2,
            lineTension: 0,
        }]
    }

    var lineChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: {
            maintainAspectRatio: false,
            bezierCurve: false,
        }
    });
</script>