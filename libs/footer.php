    <?php
    if(!defined("IN_SITE")) die("The request not found");
    ?>
    </div>
    <footer>
        <div class="footer-content">
            <div class="footer-layout">
                <h2 class="title">Theo dõi chúng tôi</h2>
                <div class="follows">
                    <div class="follows-item">
                        <a href="https://www.facebook.com/">Facebook</a>
                        <a href="https://www.instagram.com/">Instagram</a>
                        <a href="https://twitter.com/">Twitter</a>
                        <a href="https://www.youtube.com/">Youtube</a>
                    </div>
                </div>
            </div>
            <!-- footer layout -->
            <div class="footer-layout">
                <h2 class="title">Sơ đồ</h2>
                <div class="follows">
                    <div class="follows-item">
                        <a href="">Về chúng tôi</a>
                        <a href="">Chính sách</a>
                        <a href="">Giấy phép</a>
                        <a href="">Trợ giúp</a>
                    </div>
                </div>
            </div>
            <!-- footer layout -->
        </div>
        <br>
        <div class="center">
            Bản quyền thuộc về HHD
            <br>
            Copyright &copy; 2020
            <div class="chuky">
                <p>Design by</p><img src="<?php echo homeurl(); ?>images/duy.png"/>
            </div>
        </div>
    </footer>
    <div class="scrollup">
        <div class="scroll-circle">
            <i class="fas fa-angle-up"></i>
        </div>
    </div>
    <input type="hidden" id="home" value="<?php echo $homeurl; ?>"/>
    <div class="img-fb" id="clickfb">
        <img src="<?php echo homeurl();?>icon/feedback.png" />
    </div>
    <script type="text/javascript">
    var home_url = $("#home").val();
    </script>
    <script src="<?php echo homeurl();?>js/app.js"></script>
    <script src="<?php echo homeurl();?>js/glide.min.js"></script>
    <script src="<?php echo homeurl();?>send-feedback.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            $(window).scroll(function () {
                if ($(this).scrollTop() > 100) {
                    $('.scrollup').fadeIn();
                } else {
                    $('.scrollup').fadeOut();
                }
            });

            $('.scrollup').click(function () {
                $("html, body").animate({ scrollTop: 0 }, 800);
                return false;
            });

        });
    </script>
</body>
</html>
