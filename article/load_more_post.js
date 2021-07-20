let load_more = document.querySelector('#load-more');
var skip = 10;
if(load_more)
    {
        load_more.addEventListener('click',(e) => {
        e.preventDefault();
        load_more.innerHTML = 'Loading ...';
        var article = document.querySelector('#article');
        $.ajax({
            url : 'comment.php?do=more',
            type: 'get',
            dataType: 'text',
            data : {
                id : article.value,
                skip: skip
            },
            success : function(data){
                //alert(data);
                $(data).insertAfter("#chat");
                if(data == ''){
                    $('#load-more').fadeOut();
                }
                load_more.innerHTML = 'Xem thêm';
                skip += skip;
            },
            error : function(){
                alert("Có lỗi xảy ra khi tải dữ liệu ...");
            }
        })
    });
}