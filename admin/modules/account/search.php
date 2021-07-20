<?php
if(!defined("IN_SITE")) die("The request not found");
if($rights < 9){
    exit;
}
?>
<div class="panel-title"><h3>Tìm kiếm người dùng</h3></div>
<div class="row">
    <div class="col-6 col-sm-6" style="margin-top:10px">
        <a href="" class="button bg-danger"><i class="fas fa-print"></i> In</a>
    </div>
</div>
<div class="timkiem">
    <input type="text" id="name" placeholder="Nhập username hoặc tên người dùng" />
    <button type="submit" id="btn"><i class="fas fa-search"></i></button>
</div>
<div class="row">
    <div class="col-12 col-m-12">
        <div class="card">
            <div class="card-header"><h3>Danh sách người dùng</h3></div>
            <div class="card-content">
                <table class="table-re">
                    <tr>
                        <th>Avatar</th>
                        <th>Username</th>
                        <th>Họ tên</th>
                        <th>Giới tính</th>
                        <th>Năm sinh</th>
                        <th>Chức vụ</th>
                        <th>Thao tác</th>
                    </tr>
                    <tbody id="result">
                       
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#btn").on('click',function(){
            var s_name = $("#name").val();
            if(s_name != ""){
                $("#result").html("<tr><td colspan='7' class='center'><img src='<?php echo homeurl();?>icon/load.gif' style='width:100px;'></td></tr>");
                $.ajax({
                    url : 'modules/account/search-js.php',
                    type: 'GET',
                    dataType: "text",
                    data : {
                        sname : s_name
                    },
                    success : function(data){
                        $("#result").empty();
                        $("#result").append(data);
                    },
                    error : function(){
                        alert("Lỗi khi get dữ liệu");
                    }
                });
            }
        });
    });
</script>