var seeFb = document.querySelectorAll(".bg-warning");
seeFb.forEach(item => {
    item.addEventListener('click',(e) => {
        e.preventDefault();
        var id = item.getAttribute("data-id");
        $.ajax({
            url : 'modules/feedback/view-ajax.php',
            type: 'get',
            dataType: 'json',
            cache: false,
            data : {
                id : id
            },
            success : function(data){
                Swal.fire(
                    data.title,
                    data.message,
                    'info'
                );
            },
            error : function(){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!'
                });
            }
        });
    });
});