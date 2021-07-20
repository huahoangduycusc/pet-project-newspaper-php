// show more comment
var cmt = 5;
var skip = 5;
var flag = false;
$(document).ready(function () {
    $('#getMore').click(function (e) {
        let user = $(this).data("user");
        e.preventDefault();
        if (flag == true) {
            return false;
        }
        flag = true;
        $('#getMore').html("Loading..");
        $.ajax({
            url: 'load_more_post.php',
            type: 'post',
            cache: false,
            dataType: "text",
            data: {
                id: user,
                skip: cmt
            },
            success: function (data) {
                cmt += skip;
                if (data == "") {
                    //alert("Hết dữ liệu");
                    $('#getMore').fadeOut();
                }
                //alert(cmt);
                $('#cmt').append(data);
                $('#getMore').html("Load more");
                flag = false;
            }
        });
    });
});
// show interface 
var click = document.querySelector(".block-user");
var feedback = document.querySelector(".feedback-container");
if (click) {
    click.addEventListener('click', (e) => {
        e.preventDefault();
        $('#json').html('');
        feedback.classList.toggle("actives");
    });
}
// var fb = document.querySelector(".feedback-fixed");
if(feedback){
    feedback.addEventListener('click', function (e) {
        var div = e.target;
        if (div.classList.contains('feedback-container')) {
            feedback.classList.remove("actives");
        }
    });
}
var fb_close = document.querySelector('.close');
if (fb_close) {
    fb_close.addEventListener('click', function (e) {
        e.preventDefault();
        feedback.classList.remove("actives");
    });
}