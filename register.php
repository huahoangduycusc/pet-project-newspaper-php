<?php
define('IN_SITE','TRUE');
$rootpath = '';
require_once('libs/core.php');
if($user_id){
    redirect(homeurl());
}
$error = array();
if(isset($_POST['register'])){
    $regex = "/[^a-zA-Z0-9]+/";
    $username = input_post('username');
    $password = input_post('password');
    $fullname = input_post('fullname');
    $email = input_post('email');
    $gender = input_post('gender');
    $username = addslashes($username);
    $password = addslashes($password);
    $fullname = addslashes($fullname);
    $email = addslashes($email);
    $gender = abs(intval($gender));
    // check username
    if(empty($username)){
        $error['result'] = 'Bạn chưa nhập tên đăng nhập';
    }
    if(empty($password)){
        $error['result'] = 'Bạn chưa nhập mật khẩu';
    }
    if(empty($fullname)){
        $error['result'] = 'Bạn chưa nhập họ tên';
    }
    if(empty($email)){
        $error['result'] = 'Bạn chưa nhập email';
    }
    if(preg_match($regex,$username)){
        $error['result'] = 'Tên tài khoản không hợp lệ, phải là chữ cái hoặc số và không chứa ký tự đặc biệt.';
    }
    if(isset($email) && filter_var($email,FILTER_VALIDATE_EMAIL) == false){
        $error['result'] = 'Địa chỉ email không hợp lệ !';
    }
    if(!$error){
        $user = db_user_get_by_username($username);
        // if empty
        if(!empty($user)){
            $error['result'] = 'Tên tài khoản đã được đăng ký, vui lòng sử dụng tên khác !';
        }
        $emailCheck = db_get_email($email);
        if($emailCheck != 0){
            $error['result'] = 'Email này đã được đăng ký cho 1 tài khoản khác.';
        }
        // if no error
        if(!$error){
            $data = array(
                'id' => null,
                'username' => $username,
                'password' => password_hash($password,PASSWORD_DEFAULT),
                'email' => $email,
                'fullname' => $fullname,
                'nickname' => $username,
                'gender' => $gender,
                'birthday' => '1970/01/01',
                'address' => '',
                'phone' => '',
                'favourite' => '',
                'post' => '0',
                'role' => '0',
                'avatar' => 'images/profile/default.png',
                'timeJoin' => date("Y/m/d H:m:s"),
                'activities' => 0
            );
            if(db_insert('account',$data)){ 
                $_SESSION['uid'] = db_get_insert_id();
                redirect(homeurl());
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    <link rel="stylesheet" href="<?php echo homeurl();?>/theme/login.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="icon" href="~/icon/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="~/icon/apple-touch-icon.png" />
</head>
<body>
    <div class="container">
        <div class="login_form">
            <h2>Đăng ký <?php echo $user_id?></h2>
            <form action="?" method="POST">
                <?php
                if($error){
                    showError($error,'result');
                }
                ?>
                <div class="input_box">
                    <input type="text" name="username" value="<?php echo input_post('username');?>">
                    <div class="placeholder">Username:</div>
                </div>
                <!-- input -->
                <div class="input_box">
                    <input type="password" name="password" value="<?php echo input_post('password')?>">
                    <div class="placeholder">Password</div>
                </div>
                <!-- input -->
                <div class="input_box">
                    <input type="text" name="fullname" value="<?php echo input_post('fullname');?>">
                    <div class="placeholder">Fullname</div>
                </div>
                <!-- input -->
                <div class="input_box">
                    <input type="email" name="email" value="<?php echo input_post('email');?>">
                    <div class="placeholder">Email</div>
                </div>
                <!-- input -->
                <div class="input_box">
                    <p>Gender</p>
                    <input type="radio" name="gender" id="gender" value="0" checked>Nam
                    <input type="radio" name="gender" id="gender" value="1">Nữ
                </div>
                <?php csrf::create_token(); ?>
                <!-- input -->
                <div class="input_box">
                    <input type="submit" name="register" value="Đăng ký" class="btn-submit">
                </div>
                <!-- input -->
                <div class="guest green">
                    <p> Bạn đã có tài khoản ?</p><a href="<?php echo homeurl();?>login.php">Đăng nhập</a>
                </div>
                <!-- guest -->
                <div class="goback">
                    <a href="<?php echo homeurl();?>">Back</a>
                </div>
                <!-- goback -->
            </form>
        </div>
    </div>
    <div class="feedback-container">
        <div class="feedback-fixed">
            <div class="feedback-title">Forgot password</div>
            <div class="feedback-msg">
                <p id="json"></p>
            </div>
            <div class="feedback-txt">
                <p>Username</p>
                <input type="text" name="user" id="user" placeholder="Username" required>
            </div>
            <div class="feedback-txt">
                <p>Email</p>
                <input type="email" name="email" id="email" placeholder="Email" required>
            </div>
            <div class="feedback-submit">
                <button type="submit" id="btn_send"><i class="fas fa-paper-plane"></i></button>
            </div>
            <a href="" class="close"><i class="fas fa-times"></i></a>
        </div>
        <div class="sign-owner">
            <p>Design by</p>
            <img src="" alt="">
        </div>
    </div>
    <script>
        var click = document.querySelector(".forgot");
        var feedback = document.querySelector(".feedback-container");
        click.addEventListener('click', (e) => {
            e.preventDefault();
            $('#json').html('');
            feedback.classList.toggle("actives");
        });
        var fb = document.querySelector(".feedback-fixed");
        feedback.addEventListener('click', function (e) {
            var div = e.target;
            if (div.classList.contains('feedback-container')) {
                feedback.classList.remove("actives");
            }
        });
        var fb_close = document.querySelector('.close');
        if (fb_close) {
            fb_close.addEventListener('click', function (e) {
                e.preventDefault();
                feedback.classList.remove("actives");
            });
        }
    </script>
    <script>
        var flag = false; // tránh click nhiều lần
        $('#form_submit').submit(function () {
            $('#json').html('');
            if (flag == true) {
                alert('Please, waiting a moment after the system handling'); // wait
            }
            flag = true;
            $('#btn_send').html('Sending ...');
            var username = $('#user').val(); // get username
            var email = $('#email').val(); // get email
            //alert("Bạn vừa click");
            $.ajax({
                url: '/Email/Index',
                type: 'post',
                cache: false,
                data: {
                    user: username,
                    email: email
                },
                success: function (result) { // success
                    if (result.msg != "") { // error
                        $('#json').css('color', 'red');
                        $('#json').html(result.msg);
                    }
                    if (result.success != "") { // success
                        $('#json').css('color', 'green');
                        $('#json').html(result.success);
                    }
                    flag = false;
                    $('#btn_send').html('<i class="fas fa-paper-plane"></i>');
                },
                error: function () {
                    alert("Process handle occur error, please try it again !"); // error
                }
            });
            return false;
        });
    </script>
</body>
</html>