<?php
if(!defined('IN_SITE')) die("The request not found");
$myNotification = db_count('notifications','noti_id',array('noti_seen' => '0','noti_user' => $user_id));
$mymess = Mail::myMesssage();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title;?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo homeurl();?>theme/glide.core.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo homeurl();?>theme/glide.theme.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo homeurl();?>theme/style.css" type="text/css">
    <script src="<?php echo homeurl();?>js/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="<?php echo homeurl();?>js/sweetalert2.min.css"/>
    <link rel="icon" href="~/icon/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="~/icon/apple-touch-icon.png" />
</head>
<body>
    <header>
        <div class="nav-container">
            <div class="logo">
                <a href="<?php echo homeurl();?>"><img src="<?php echo homeurl(); ?>/images/logo.png" alt=""></a>
            </div>
            <div class="menu">
                <i class="fas fa-bars"></i>
            </div>
            <nav>
                <div class="logo-nav">
                    <a href=""><img src="<?php echo homeurl(); ?>/images/logo.png" alt=""></a>
                </div>
                <ul class="nav-list">
                    <li class="mini-search">
                        <form>
                            <div class="mini-search-container">
                                <input type="text" name="s" id="s" placeholder="Bạn đang tìm gì?">
                                <button type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </li>
                    <li class="nav-item" id="parent-menu">
                        <a>Chuyên mục <i class="fas fa-angle-right"></i></a>
                        <ul class="sub-menu" id="smenu">
                            <?php
                            $cate = Category::getList(1);
                            foreach($cate as $item){
                                ?>
                                <li><a href="<?php echo homeurl();?>category/?id=<?php echo $item['categoryId'];?>"><?php echo $item['categoryName'];?></a></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo homeurl();?>/blog">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo homeurl();?>/article/top.php">BXH</a>
                    </li>
                    <li class="nav-item">
                        <a href="">K-POP</a>
                    </li>
                </ul>
            </nav>
            <!-- navigition -->
            <div class="search">
                <form action="<?php echo homeurl();?>article/search.php" method="GET">
                     <div class="search-container">
                        <input type="text" name="s" id="s" placeholder="Bạn đang tìm gì ?">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
            <!-- search div -->
            <div class="function">
                <i class="fas fa-user dropdown-toggle"></i>
                <div class="guess">
                    <div class="guess-container">
                        <?php
                        if(!$user_id)
                        {
                            ?>
                            <div class="guess-item">
                                <a href="<?php echo homeurl();?>login.php"><i class="fas fa-sign-in-alt"></i> Đăng nhập</a>
                            </div>
                            <div class="guess-item">
                                <a href="<?php echo homeurl();?>register.php"><i class="fas fa-user-plus"></i> Đăng ký</a>
                            </div>
                            <?php
                        }
                        else
                        {
                        ?>
                            <div class="guess-item">
                                <a href="<?php echo homeurl();?>admin" target="_blank"><i class="fas fa-cog"></i> Quản trị</a>
                            </div>
                            <div class="guess-item">
                                <a href="<?php echo homeurl();?>user/?id=<?php echo $user_id;?>"><i class="fas fa-user-cog"></i> Hồ sơ</a>
                            </div>
                            <div class="guess-item">
                                <a href="<?php echo homeurl();?>user/mynoti.php"><i class="fas fa-bell"></i> Thông báo <?php echo ($myNotification > 0) ? ' <span class="noti">'.$myNotification.'</span>' : ''; ?></a>
                            </div>
                            <div class="guess-item">
                                <a href="<?php echo homeurl();?>mail/list.php"><i class="fas fa-envelope"></i> Tin nhắn <?php echo ($mymess > 0) ? ' <span class="noti">'.$mymess.'</span>' : ''; ?></a>
                            </div>
                            <div class="guess-item">
                                <a href="<?php echo homeurl();?>logout.php"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="overlay">
            <i class="fas fa-times"></i>
        </div>

        <div class="phanhoi-container">
            <form method="POST" class="phanhoi-form" id="send_fb">
                <div class="phanhoi-title">
                    <img src="<?php echo homeurl();?>/icon/fb.png" alt="">
                </div>
                <div class="phanhoi-bg">
                    <div class="phanhoi-box">
                        <input type="email" name="email" id="emailf" placeholder="Email" required>
                    </div>
                    <div class="phanhoi-box">
                        <input type="text" name="title" id="titlef" placeholder="Title" required>
                    </div>
                    <div class="phanhoi-box">
                        <textarea rows="7" placeholder="Message" name="message" id="msgf" required></textarea>
                    </div>
                    <div class="phanhoi-box">
                        <button type="submit">Gửi</button>
                        <a class="close-phanhoi">Đóng</a>
                    </div>
                </div>
            </form>
        </div>
        <!-- phan hoi container -->
    </header>
    <!-- header -->
    <div class="body-content">
