<?php
define('IN_SITE','TRUE');
$rootpath = '';
require_once('libs/core.php');
if($user_id){
    redirect(homeurl());
}
$error = array();
if(isset($_POST['login'])){
    $username = input_post('username');
    $password = input_post('password');
    $username = addslashes($username);
    $password = addslashes($password);
    $token = input_post('token');
    // check username
    if(empty($username)){
        $error['result'] = 'Bạn chưa nhập tên đăng nhập';
    }
    if(empty($password)){
        $error['result'] = 'Bạn chưa nhập mật khẩu';
    }
    if(!csrf::validate_token($token)){
        $error['result'] = 'The request is not valid';
    }
    if(!$error){
        $user = db_user_get_by_username($username);
        // if empty
        if(empty($user)){
            $error['result'] = 'Tên đăng nhập hoặc mật khẩu không chính xác !';
        }
        else if(password_verify($password,$user['password']) == false){
            $error['result'] = 'Tên đăng nhập hoặc mật khẩu không chính xác !';
        }
        else if($user){
            $ban = db_ban_user($user['id']);
            if($ban && $ban['ban_time'] > time()){
                $ban_to = date("H:i:s d-m-Y", $ban['ban_time']);
                $error['result'] = 'Đăng nhập không thành công<br/>';
                $error['result'] .= 'Tài khoản của bạn đã bị khóa đến:<br/> '.$ban_to;
                $error['result'] .= '<br/>Lý do: '.$ban['ban_message'];
            }
        }
        // if no error
        if(!$error){
            $_SESSION['uid'] = $user['id'];
            redirect(homeurl());
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
            <h2>Đăng nhập <?php echo $user_id?></h2>
            <form action="?" method="POST">
                <?php
                if($error){
                    showError($error,'result');
                }
                ?>
                <div class="input_box">
                    <input type="text" name="username">
                    <div class="placeholder">Username:</div>
                </div>
                <!-- input -->
                <div class="input_box">
                    <input type="password" name="password">
                    <div class="placeholder">Password</div>
                </div>
                <!-- input -->
                <div class="input_box">
                    <input type="submit" name="login" value="Đăng nhập" class="btn-submit">
                </div>
                <!-- input -->
                <div class="guest">
                    <p> Bạn chưa có tài khoản ? <a href="<?php echo homeurl();?>register.php" class="a">Đăng ký</a></p> 
                    <a href="" class="forgot">Quên mật khẩu?</a>
                </div>
                <?php csrf::create_token(); ?>
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
               <span>Nhập vào Email đã xác thực của bạn, chúng tôi sẽ gửi 1 email thay đổi mật khẩu mới tới địa chỉ này.</span>
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
            <img src="<?php echo homeurl();?>images/duy.png" alt="">
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