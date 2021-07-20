var cmt = 10;
var skip = 10;
var flag = false;
$(document).ready(function () {
    $('#getMore').click(function (e) {
        if(flag == true){
            return false;
        }
        flag = true;
        var article_id = $(this).data("art");
        e.preventDefault();
        $('#getMore').html("Loading..");
        $.ajax({
            url: 'load_more_article.php',
            type: 'POST',
            dataType: "text",
            data: {
                id: article_id,
                skip: cmt
            },
            success: function (data) {
                alert(data);
                cmt += skip;
                if (data == "") {
                    alert("Hết dữ liệu");
                    $('#getMore').fadeOut();
                }
                $('#article').append(data);
                $('#getMore').html("Load more");
                flag = false;
            }
        });
    });
});