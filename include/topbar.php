<div id="preloader">
    <div id="status">&nbsp;</div>
</div>

<nav class="navbar navbar-default ">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"><img src="../assets/images/logo.png" alt="" width="180"></a>
        </div>
        <div class="collapse navbar-collapse yamm" id="navigation">
            <div class="button navbar-right">
                <button class="btn btn-primary wow bounceInRight login" onclick=" window.location='index.php'">Home</button>
                <?php if(isset($_SESSION['auth'])){ ?>
                    <button class="btn btn-primary wow bounceInRight login" onclick=" window.location='auth/dashboard.php'">Dashboard</button>
                    <button class="btn btn-outline-info wow fadeInRight" onclick=" window.location='auth/logout.php'" data-wow-delay="0.5s">Logout</button>
                    Hi, <?= $_SESSION['auth']['name']; ?>
                <?php }else{ ?>
                    <button class="btn btn-primary wow bounceInRight login" onclick=" window.location='auth/login.php'">Login</button>
                <?php } ?>

            </div>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>