<?php
define('IN_SITE',true);
require_once('../libs/core.php');
$title = 'Thiết lập thông tin cá nhân';
$account = new account($id);
if($account->flag == false){
    redirect(homeurl());
}
if($rights < 9 && $user_id != $id){
    redirect(homeurl());
}
require_once('../libs/header.php');
?>
<?php
// validate submit form
if(isset($_POST['update'])){
    $fullname = input_post('fullname');
    $gender = input_post('gender');
    $birthday = input_post('birthday');
    $address = input_post('address');
    $phone = input_post('phone');
    $favourite = input_post('favourite');
    $nickname = input_post('nickname');
    $email = input_post('email');
    $role = input_post('role');
    $extension = array("jpeg","jpg","png");
    $data = array(
        'fullname' => $fullname,
        'gender' => $gender,
        'birthday' => $birthday,
        'address' => $address,
        'phone' => $phone,
        'favourite' => $favourite
    );
    // upload new avatar
    if($_FILES['avatar']['name'] != ''){
        $path = $_FILES['avatar']['name'];
        $ext = pathinfo($path,PATHINFO_EXTENSION); // get extension
        if(in_array($ext,$extension)){
            $filename = '../images/profile/'.$id.'.'.$ext;
            move_uploaded_file($_FILES['avatar']['tmp_name'],$filename);
            $data = array_merge($data,array('avatar' => "images/profile/$id.$ext"));
        }
    }
    if($rights == 9){
        $data = array_merge($data,array(
            'nickname' => $nickname,
            'email' => $email,
            'role' => $role
        ));
    }
    $where = array('id' => $id);
    $result = db_update('account',$data,$where);
    //print_r($data);
}
?>
<div class="profile">
    <div class="fit">
        <div class="profile-avatar">
            <img src="<?php echo homeurl().$account->avatar;?>" alt="">
        </div>
        <div class="profile-infor">
            <h2 style="color:#013481;font-size:12pt"><?php echo $account->username; ?></h2>
            <p><i class="fas fa-map-marker"></i> <?php echo $account->address; ?></p>
            <p><i class="fas fa-comment"></i> <?php echo $account->post; ?> bình luận</p>
            <p><i class="fas fa-venus-mars"></i> <?php echo $account->gender; ?></p>
        </div>
        <?php if (($rights == 9) || $user_id == $id) {?>
        <div class="profile-setting">
            <a href="<?php echo homeurl();?>user/setting.php?id=<?php echo $id; ?>" class="btn-setting"><i class="fas fa-cog"></i> Thiết lập</a>
            <a href="<?php echo homeurl();?>user/changep.php" class="btn-setting"><i class="fas fa-exchange-alt"></i> Đổi mật khẩu</a>
            <a href="<?php echo homeurl();?>user/index.php?id=<?php echo $id;?>" class="btn-setting"><i class="fas fa-undo-alt"></i> Trang cá nhân</a>
        </div>
        <?php } ?>
    </div>
</div>
<section class="profile-line">
    <div class="fit">
        <div class="col-duy-4">
            <div class="profile-start">
                <p><i class="far fa-clock"></i> Gia nhập <?php echo $account->timeJoin; ?></p>
                <p><i class="fas fa-calendar-alt"></i> Sinh nhật <?php echo $account->birthday; ?></p>
            </div>
        </div>
        <!-- col duy 4 -->
        <div class="col-duy-8 white-bg">
        <?php
        if(isset($result) && $result)
        {
            echo '<div class="green">Cập nhật thông tin mới thành công !</div>';
        }
        ?>
        <form method="POST" enctype="multipart/form-data">
        <div class="form-horizontal">
        <h2 class="center">Thiết lập thông tin</h2>
            <div class="form-group">
                Họ tên
                <div class="col-md-10">
                    <input type="text" name="fullname" value="<?php echo $account->username;?>" class="form-control" required>
                </div>
            </div>

            <?php if ($rights == 9) {?>
                <div class="form-group">
                    Nick Name
                    <div class="col-md-10">
                        <input type="text" name="nickname" value="<?php echo $account->nickname;?>" class="form-control" required>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                Giới tính
                <div class="col-md-10">
                   <select name="gender" class="form-control">
                        <option value="0" <?php echo ($account->gender == 'Nam' ? 'selected' : '');?>> Nam</option>
                        <option value="1" <?php echo ($account->gender == 'Nữ' ? 'selected' : '');?>> Nữ</option>
                   </select>
                </div>
            </div>

            <div class="form-group">
                Ngày sinh
                <div class="col-md-10">
                    <input type="date" name="birthday" value="<?php echo date('Y-m-d',strtotime($account->birthday));?>" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                Địa chỉ
                <div class="col-md-10">
                    <textarea class="form-control" rows="5" name="address"><?php echo $account->address; ?></textarea>
                </div>
            </div>
            <?php if($rights == 9) {?>
            <div class="form-group">
                Email
                <div class="col-md-10">
                    <input type="email" name="email" value="<?php echo $account->email;?>" class="form-control" required>
                </div>
            </div>
            <?php } ?>
            <div class="form-group">
                Điện thoại
                <div class="col-md-10">
                    <input type="text" name="phone" value="<?php echo $account->phone;?>" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                Sở thích
                <div class="col-md-10">
                    <textarea class="form-control" rows="5" name="favourite"><?php echo $account->favourite; ?></textarea>
                </div>
            </div>

            <div class="form-group">
                Ảnh đại diện
                <div class="col-md-10">
                    <input type="file" name="avatar" class="form-control">
                </div>
            </div>

            <?php if($rights == 9){?>
                <div class="form-group">
                    Chức vụ
                    <div class="col-md-10">
                       <select name="role" class="form-control">
                        <option value="0" <?php echo ($account->rights == 0 ? 'selected': '');?>>Thành viên</option>
                        <option value="1" <?php echo ($account->rights == 1 ? 'selected': '');?>>Nhà báo</option>
                        <option value="2" <?php echo ($account->rights == 2 ? 'selected': '');?>>Cộng tác viên</option>
                        <option value="3" <?php echo ($account->rights == 3 ? 'selected': '');?>>Tổng biên tập</option>
                        <option value="9" <?php echo ($account->rights == 9 ? 'selected': '');?>>Quản trị viên</option>
                       </select>
                    </div>
                </div>
            <?php } ?>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
                    <input type="submit" name="update" value="Cập nhật" class="btn btn-default" />
                </div>
            </div>
        </div>
        </form>
        </div>
        <!-- col duy 8 -->
    </div>
</section>
<?php
require_once('../libs/footer.php');
?>