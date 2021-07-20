$(document).ready(function () {
    $('#send_fb').submit(function () {
        var emailf = $('#emailf').val();
        var tieudef = $('#titlef').val();
        var msgf = $('#msgf').val();
        $.ajax({
            url: home_url+'sendfb.php',
            type: 'post',
            cache: false,
            dataType: 'json',
            data: {
                email: emailf,
                title: tieudef,
                message: msgf
            },
            success: function (result) {
                $('.phanhoi-container').removeClass('actives-phanhoi');
                $('#emailf').val('');
                $('#titlef').val('');
                $('#msgf').val('');
                if(result.msg == "error"){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                      });
                }
                else if(result.msg == "success"){
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Yêu cầu của bạn đã được gửi đi thành công !',
                      });
                }
            },
            error: function () {
                alert("There are something wrong?");
            }
        });
        return false;
    });
});
