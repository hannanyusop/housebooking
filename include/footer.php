<div class="footer-area">

    <div class="footer-copy text-center">
        <div class="container">
            <div class="row">
                <div class="pull-left">
                    <span><a href="#"><?= $GLOBALS['APP_NAME'] ?></a> 2021  </span>
                </div>
                <div class="bottom-menu pull-right">
                    <ul>
                        <li><a class="wow fadeInUp animated" href="index.php" data-wow-delay="0.2s">Home</a></li>
                        <li><a class="wow fadeInUp animated" href="auth/login.php" data-wow-delay="0.3s">Login</a></li>
                        <li><a class="wow fadeInUp animated" href="auth/register.php" data-wow-delay="0.4s">Register</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="../garo/assets/js/modernizr-2.6.2.min.js"></script>
<script src="../garo/assets/js/jquery-1.10.2.min.js"></script>
<script src="../garo/bootstrap/js/bootstrap.min.js"></script>
<script src="../garo/assets/js/bootstrap-select.min.js"></script>
<script src="../garo/assets/js/bootstrap-hover-dropdown.js"></script>
<script src="../garo/assets/js/easypiechart.min.js"></script>
<script src="../garo/assets/js/jquery.easypiechart.min.js"></script>
<script src="../garo/assets/js/owl.carousel.min.js"></script>
<script src="../garo/assets/js/wow.js"></script>
<script src="../garo/assets/js/icheck.min.js"></script>
<script src="../garo/assets/js/price-range.js"></script>
<script type="text/javascript" src="../garo/assets/js/lightslider.min.js"></script>
<script src="../garo/assets/js/main.js"></script>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>

<script>
    $(document).ready(function () {

        $('#image-gallery').lightSlider({
            gallery: true,
            item: 1,
            thumbItem: 9,
            slideMargin: 0,
            speed: 500,
            auto: true,
            loop: true,
            onSliderLoad: function () {
                $('#image-gallery').removeClass('cS-hidden');
            }
        });
    });
</script>