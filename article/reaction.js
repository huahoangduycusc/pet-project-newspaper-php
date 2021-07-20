    let emojil = document.querySelectorAll('.feeling-item');
    let data_user = document.querySelector("#data_user");
    let article = document.querySelector('#article');
    var is_load = false;
    emojil.forEach(item => {
        item.addEventListener('click', function () {
            if (is_load == true) {
                return false;
            }
            is_load = true;
            $("#loadCamxuc").css({opacity: 0.6});
            var value = item.getAttribute("data-id");
            //alert(data_id + " - " + value);
            var num = parseInt(item.children[1].innerHTML);
            if (data_user.value == "") {
                alert("Vui lòng đăng nhập để sử dụng chức năng này !");
                return false;
            }
            else {
                $.ajax({
                    url: 'like.php',
                    type: 'get',
                    cache: false,
                    dataType : 'json',
                    data: {
                        aid: article.value,
                        uid: data_user.value,
                        emoji: value
                    },
                    success: function (data) {
                        //alert(data);
                        if (data != null) {
                            $("#heart").html(data.heart);
                            $("#smile").html(data.smile);
                            $("#angry").html(data.angry);
                            $("#cry").html(data.cry);
                            $("#scared").html(data.scared);
                            //alert(data.heart);
                        }
                        is_load = false;
                        $("#loadCamxuc").css({ opacity: 1 });
                    }
                });
            }
        });
    });