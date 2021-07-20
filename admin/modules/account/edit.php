<?php
if(!defined("IN_SITE")) die("The request not found");
$account = new account($id);
?>
<div class="panel-title">
    <h3>Chỉnh sửa tài khoản</h3>
</div>
<div class="row">
    <div class="col-12">
        <form method="POST" enctype="multipart/form-data">
            <?php
        if(isset($_POST['update'])){
            $fullname = input_post('fullname');
            $gender = input_post('gender');
            $birthday = input_post('birthday');
            $address = input_post('address');
            $nickname = input_post('nickname');
            $email = input_post('email');
            $role = input_post('role');
            $extension = array("jpeg","jpg","png");
            $data = array(
                'fullname' => $fullname,
                'gender' => $gender,
                'birthday' => $birthday,
                'address' => $address,
                'nickname' => $nickname,
                'email' => $email,
                'role' => $role
            );
            $extension = array("jpeg","jpg","png");
            if($_FILES['avatar']['name'] != ''){
                $path = $_FILES['avatar']['name'];
                $ext = pathinfo($path,PATHINFO_EXTENSION);
                if(in_array($ext,$extension)){
                    $filename = '../images/profile/'.time().'.'.$ext;
                    move_uploaded_file($_FILES['avatar']['tmp_name'],$filename);
                    $data = array_merge($data,array('avatar' => "images/profile/".time().".$ext"));
                }
            }
            $where = array('id' => $id);
            if(db_update('account',$data,$where)){
                echo'<div class="success">Cập nhật dữ liệu mới thành công</div>';
            }
            else{
                echo '<div class="error">Có lỗi xảy ra khi cập nhật.</div>';
            }
            $account = new account($id);
        }
        ?>
            <div class="center">
                <img src="<?php echo homeurl().$account->avatar;?>" class="avatar-circle">
            </div>
            <div class="box-input">
                <p>Nick Name</p>
                <div>
                    <input type="text" name="nickname" value="<?php echo $account->nickname;?>" class="form-control"
                        required>
                </div>
            </div>
            <div class="box-input">
                <p>Họ tên : </p>
                <input type="text" name="fullname" class="form-control" value="<?php echo $account->fullname;?>"
                    required>
            </div>
            <div class="box-input">
                <p>Email</p>
                <div>
                    <input type="email" name="email" value="<?php echo $account->email;?>" class="form-control"
                        required>
                </div>
            </div>
            <div class="box-input">
                <p>Giới tính</p>
                <div>
                    <select name="gender" class="form-control">
                        <option value="0" <?php echo ($account->gender == 'Nam' ? 'selected' : '');?>> Nam</option>
                        <option value="1" <?php echo ($account->gender == 'Nữ' ? 'selected' : '');?>> Nữ</option>
                    </select>
                </div>
            </div>
            <div class="box-input">
                <p>Ngày sinh</p>
                <div>
                    <input type="date" name="birthday" value="<?php echo date('Y-m-d',strtotime($account->birthday));?>"
                        class="form-control" required>
                </div>
            </div>
            <div class="box-input">
                <p>Địa chỉ</p>
                <div>
                    <textarea class="form-control" rows="5" name="address"><?php echo $account->address; ?></textarea>
                </div>
            </div>
            <div class="box-input">
                Ảnh đại diện
                <div>
                    <input type="file" name="avatar" class="form-control">
                </div>
            </div>
            <div class="box-input">
                <p>Chức vụ</p>
                <div>
                    <select name="role" class="form-control">
                        <option value="0" <?php echo ($account->rights == 0 ? 'selected': '');?>>Thành viên</option>
                        <option value="1" <?php echo ($account->rights == 1 ? 'selected': '');?>>Nhà báo</option>
                        <option value="2" <?php echo ($account->rights == 2 ? 'selected': '');?>>Cộng tác viên</option>
                        <option value="3" <?php echo ($account->rights == 3 ? 'selected': '');?>>Tổng biên tập</option>
                        <option value="9" <?php echo ($account->rights == 9 ? 'selected': '');?>>Quản trị viên</option>
                    </select>
                </div>
            </div>
            <!-- end input -->
            <div class="box-input">
                <div class="center">
                    <button type="submit" class="btn btn-create" name="update">Cập nhật</button>
                </div>
            </div>
        </form>
    </div>
    <a href="?m=account&a=index" class="back">Trở lại danh sách</a>
    <!-- end col 12 -->
</div>
<!-- end row -->