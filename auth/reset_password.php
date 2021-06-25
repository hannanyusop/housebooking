<!DOCTYPE html>
<html lang="en">
<?php include('layout/head.php'); ?>
<?php

if(isset($_POST['reset'])){

    $email = $_POST['email'];
    #customer
    $result = $db->query("SELECT * FROM customers WHERE email='$email'");
    $customer = $result->fetch_assoc();

    $token = sha1(mt_rand(1, 90000) . 'SALT');

    $body = "Hye $email,<br><br>
            <p>Please click this <a href='$_SERVER[HTTP_HOST]/auth/reset.php?token=$token'>link</a> to reset password  or<br>
            copy this if link not working <b>$_SERVER[HTTP_HOST]/auth/reset.php?token=$token</b>
            
            <br><br>
            </p>";
    if($customer){

        $db->query("UPDATE customers SET forget_token='$token' WHERE email='$email'");
        sendEmail($_POST['email'], "Reset Password", $body);
        echo "<script>alert('We\'ve sent reset password link.Please check your inbox and follow the instruction.');window.location='login.php'</script>";

    }

    #agent
    $result = $db->query("SELECT * FROM agents WHERE email='$email'");
    $agent = $result->fetch_assoc();

    if($agent){

        $db->query("UPDATE agents SET forget_token='$token' WHERE email='$email'");
        sendEmail($_POST['email'], "Reset Password", $body);
        echo "<script>alert('We\'ve sent reset password link.Please check your inbox and follow the instruction.');window.location='login.php'</script>";

    }

    #admin
    $result = $db->query("SELECT * FROM admin WHERE email='$email'");
    $admin = $result->fetch_assoc();

    if($admin){

        $db->query("UPDATE adminSET forget_token='$token' WHERE email='$email'");
        sendEmail($_POST['email'], "Reset Password", $body);
        echo "<script>alert('We\'ve sent reset password link.Please check your inbox and follow the instruction.');window.location='login.php'</script>";

    }

    echo "<script>alert('Email not found!');window.location='reset_password.php'</script>";
}
?>

  <body main-theme-layout="main-theme-layout-1">
    <div class="page-wrapper">
        <div class="authentication-main">
          <div class="row">
            <div class="col-md-12">
              <div class="auth-innerright">
                <div class="authentication-box">
                  <div class="text-center"><img width="200px" src="../assets/images/endless-logo.png" alt=""></div>
                  <div class="card mt-4">
                    <div class="card-body">
                      <div class="text-center">
                        <h4>Reset Password</h4>
                        <h6>Enter your Email to Reset your password. </h6>
                      </div>
                      <form class="theme-form" method="post">
                        <div class="form-group">
                          <label class="col-form-label pt-0" for="email">Email</label>
                          <input class="form-control" type="email" name="email" id="email">
                        </div>
                        <div class="form-group form-row mt-3 mb-0">
                          <button class="btn btn-warning btn-block" type="submit" name="reset">Send Link to Email</button>
                        </div>

                          <div class="form-row text-center text">
                              <div class="col-sm-12">
                                  <div class="mt-2 m-l-20">Already remember?<a class="btn-link font-weight-bold text-warning" href="login.php">Login</a></div>
                              </div>
                          </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </body>
<?= include('layout/script.php') ?>
<!-- Plugin used-->
</html>