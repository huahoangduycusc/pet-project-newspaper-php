$(document).ready(function(){
    var flag1 = false;
    $('#form_cmt').submit(function(){
        if(flag1 == true){
            return false;
        }
        flag1 = true;
        var msg = $("#message").val();
        var token = $('#token').val();
        var aid = $('#article').val();
        $('.btn-chat').val('Đang gửi..');
        $.ajax({
            url : 'comment.php?do=post&id='+aid,
            type : 'post',
            dataType: 'text',
            data : {
                message : msg,
                token: token
            },
            success : function(result){
                //alert(result)
                $('.btn-chat').val('Gửi');
                $('#message').val('');
                load_stuff(aid);
                flag1 = false;
                $(".empty").fadeOut(1000);
            },
            error : function(){
                alert("error");
            }
        });
        return false;
    });
    // load comment
    function load_stuff(param){
        $.ajax({
            url : 'comment.php?do=load',
            method: 'GET',
            data : {
                id : param
            },
            success : function(data){
                //alert(data);
                $('#chat').html(data);
            }
        });
    }
});