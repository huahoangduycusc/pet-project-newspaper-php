// show more comment
var skip = 10;
var flag = false;
$(document).ready(function () {
    $('#getMore').click(function (e) {
        e.preventDefault();
        if (flag == true) {
            return false;
        }
        flag = true;
        $('#getMore').html("Loading..");
        $.ajax({
            url: 'load_more_article.php',
            type: 'post',
            cache: false,
            dataType: "text",
            data: {
                skip: skip
            },
            success: function (data) {
                skip += skip;
                if (data == "") {
                    //alert("Hết dữ liệu");
                    $('#getMore').fadeOut();
                }
                //alert(cmt);
                $('#article').append(data);
                $('#getMore').html("Load more");
                flag = false;
            }
        });
    });
});