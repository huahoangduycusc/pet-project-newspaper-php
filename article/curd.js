// delete my comment
$(document).on("click", '.delete-cmt', function(event) {
    event.preventDefault();
    var cmt_id = $(this).attr("data-cid");
    var article = document.querySelector('#article');
    $.ajax({
        url : 'comment.php?do=del',
        type: 'get',
        dataType: 'json',
        data : {
            id : cmt_id,
            aid: article.value
        },
        success : function(result){
            //alert(result.alert);
            if(result.alert == "ok"){
                //alert(cmt_id);
                $("#cmt"+cmt_id).fadeOut();
            }
            else{
                alert("Không thể xóa bình luận này...");
            }
        },
        error: function(){
            alert("Có lỗi xảy ra trong quá trình xử lý ...");
        }
    });
});
// report
$(document).on("click",".report-cmt", function(event){
    event.preventDefault();
    Swal.fire({
        title: 'Xác nhận?',
        text: "Bạn có muốn báo cáo bình luận này?",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Thoát',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Có'
      }).then((result) => {
        if (result.isConfirmed) {
            var cmt_id = $(this).attr("data-cid");
            $.ajax({
                url : 'comment.php?do=report',
                type: 'get',
                dataType: 'json',
                data : {
                    id : cmt_id,
                },
                success : function(result){
                    //alert(result.alert);
                    if(result.msg == "success"){
                        Swal.fire(
                            'Thành công!',
                            'Bình luận này đã được báo cáo là vi phạm',
                            'success'
                        );
                    }
                    else{
                        Swal.fire(
                            'Lỗi!',
                            'Không thể báo cáo bình luận này!',
                            'error'
                          );
                    }
                },
                error: function(){
                    Swal.fire(
                        'Xảy ra lỗi!',
                        'Xảy ra lỗi khi tiến hành xử lý yêu cầu này!',
                        'error'
                      );
                }
            });
        }
      });
});