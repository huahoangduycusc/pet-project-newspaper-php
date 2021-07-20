var cmt = 4;
var skip = 4;
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
            url: '/Blog/ShowBlog',
            type: 'get',
            cache: false,
            data: {
                skip: cmt
            },
            success: function (data) {
                cmt += skip;
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