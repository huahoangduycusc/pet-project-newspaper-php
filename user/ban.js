// submit block
$(document).ready(function () {
    $('#btnBan').submit(function () {
        var user = $('#user').val();
        var date = $("#date").val();
        var type = $("input[name='type']:checked").val();
        var lydo = $('#lydo').val();
        $.ajax({
            url: 'block.php',
            type: 'post',
            cache: false,
            dataType: 'json',
            data: {
                user: user,
                date: date,
                type: type,
                lydo: lydo,
            },
            success: function (result) {
                feedback.classList.remove("actives");
                if (result != null) {
                    if(result.data == "success"){
                        Swal.fire({
                            icon: 'success',
                            title: 'Khóa thành công',
                            text: 'Tài khoản đã bị khóa và không thể truy cập trong thời gian chỉ định !',
                          });
                    }
                    else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: 'Xảy ra lỗi khi khóa tài khoản này !',
                          });
                    }
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi đường truyền',
                    text: 'Xảy ra lỗi khi khóa tài khoản này !',
                  });
            }

        });
        return false;
    });
});