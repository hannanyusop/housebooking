
<!DOCTYPE html>
<html lang="en">

<?= include('layout/head.php'); ?>
<body main-theme-layout="main-theme-layout-1">

<!-- Loader ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper">
    <!-- Page Body Start-->
    <div class="container-fluid">
        <!-- sign up page start-->
        <div class="authentication-main">
            <div class="row">
                <div class="col-sm-12 p-0">
                    <div class="auth-innerright">
                        <div class="authentication-box">
                            <div class="text-center"><img src="../assets/images/endless-logo.png" alt=""></div>
                            <div class="card mt-4 p-4">
                                <h4 class="text-center">NEW USER</h4>
                                <h6 class="text-center">Enter your Username and Password For Signup</h6>
                                <form class="theme-form" method="post" action="verify-signup.php">
                                    <div class="form-group">
                                        <label class="col-form-label" for="name">Name</label>
                                        <input class="form-control" id="name" name="name" type="text" placeholder="EX : AMHAD BIN ALI" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="email">Email</label>
                                        <input class="form-control" id="email" name="email" type="text" placeholder="ahmad@example.com" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="phone">Phone Number</label>
                                        <input class="form-control" id="phone" name="phone" type="text" placeholder="0101234567" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="password">Password</label>
                                        <input class="form-control" id="password" name="password" type="password" placeholder="**********" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="confirm_password">Confirm Password</label>
                                        <input class="form-control" id="password" name="confirm_password" type="password" placeholder="**********" required>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-sm-4">
                                            <button class="btn btn-primary" type="submit">Sign Up</button>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="text-left mt-2 m-l-20">Are you already user?  <a class="btn-link text-capitalize" href="login.php">Login</a></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- sign up page ends-->
    </div>
    <!-- Page Body End-->
</div>

<!-- Plugin used-->
</body>

<?= include('layout/script.php'); ?>
</html>