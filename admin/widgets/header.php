<?php
if(!defined("IN_SITE")) die("The request not found");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control Panel</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo homeurl()?>theme/admin.css" type="text/css">
    <script src="<?php echo homeurl();?>js/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="<?php echo homeurl();?>js/sweetalert2.min.css"/>
</head>
<body class="overlay-scrollbar sidebar-expand">
    <!-- Navbar -->
    <div class="navbar">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-bars" onclick="collapseSidebar();"></i>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo homeurl();?>"><img src="<?php echo homeurl();?>images/logo.png" class="logo" alt=""></a>
            </li>
        </ul>
        <!-- nav right -->
        <ul class="navbar-nav nav-right">
            <li class="nav-item avt-wrapper">
                <div class="avatar dropdown">
                    <img src="<?php echo homeurl().$datauser['avatar'];?>" alt="" class="dropdown-toggle" data-toggle="user-menu">
                    <ul id="user-menu" class="dropdown-menu">
                        <li class="dropdown-menu-item">
                            <a href="" class="dropdown-menu-link">
                                <div>
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <span>Profile</span>
                            </a>
                        </li>
                        <li class="dropdown-menu-item">
                            <a href="<?php echo homeurl();?>logout.php" class="dropdown-menu-link">
                                <div>
                                    <i class="fas fa-sign-out-alt"></i>
                                </div>
                                <span>Log out</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
        <!-- end navbar right -->
    </div>
    <!-- end navbar -->
    <!-- Side bar -->
    <div class="sidebar">
        <ul class="sidebar-nav">
            <li class="sidebar-nav-item">
                <a href="?m=common&a=dashbroad" class="sidebar-nav-link <?php echo ($m == "common" && $a == "dashbroad") ? 'active' : '';?>">
                    <div>
                        <i class="fa fa-tachometer-alt"></i>
                    </div>
                    <span>Thống kê chung</span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="?m=category&a=index" class="sidebar-nav-link <?php echo ($m == "category" && $a == "index") ? 'active' : '';?>">
                    <div>
                        <i class="fas fa-book"></i>
                    </div>
                    <span>Chuyên mục</span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="?m=article&a=index" class="sidebar-nav-link <?php echo ($m == "article" && $a == "index") ? 'active' : '';?>">
                    <div>
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <span>Bài viết</span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="?m=blog&a=index" class="sidebar-nav-link <?php echo ($m == "blog" && $a == "index") ? 'active' : '';?>">
                    <div>
                        <i class="fab fa-blogger-b"></i>
                    </div>
                    <span>Blog</span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="?m=account&a=index" class="sidebar-nav-link <?php echo ($m == "account" && $a == "index") ? 'active' : '';?>">
                    <div>
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <span>Người dùng</span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="?m=account&a=search" class="sidebar-nav-link <?php echo ($m == "account" && $a == "search") ? 'active' : '';?>">
                    <div>
                        <i class="fas fa-search"></i>
                    </div>
                    <span>Tìm kiếm người dùng</span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="?m=feedback&a=index" class="sidebar-nav-link <?php echo ($m == "feedback" && $a == "index") ? 'active' : '';?>">
                    <div>
                        <i class="fas fa-recycle"></i>
                    </div>
                    <span>Feedback</span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="?m=comment&a=index" class="sidebar-nav-link <?php echo ($m == "comment" && $a == "index") ? 'active' : '';?>">
                    <div>
                        <i class="fas fa-comment"></i>
                    </div>
                    <span>Bình luận</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- End sidebar -->
    <!-- Main content -->
    <div class="wrapper">
