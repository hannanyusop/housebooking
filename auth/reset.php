<!DOCTYPE html>
<html lang="en">
<?php
include('layout/head.php');

if(isset($_GET['token'])){

    $token = $_GET['token'];

    $customer_q = $db->query("SELECT * FROM customers WHERE forget_token='$token'");
    $customer = $customer_q->fetch_assoc();

    $admin_q = $db->query("SELECT * FROM admin WHERE forget_token='$token'");
    $admin = $admin_q->fetch_assoc();

    $agent_q = $db->query("SELECT * FROM agents WHERE forget_token='$token'");
    $agent = $agent_q->fetch_assoc();

    if($customer || $agent || $admin){

        if($admin){
            $email = $admin['email'];

            $table = 'admin';
        }elseif ($agent){
            $email = $agent['email'];
            $table = 'agents';

        }else{
            $email = $customer['email'];
            $table = 'customers';

        }

        if(isset($_POST['password'])){

            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];


            if($password != $confirm_password){
                echo "<script>alert('Confirm password not match!');window.location='reset.php?token=$token'</script>";
                exit();
            }

            $hash_pass = password_hash($password, PASSWORD_BCRYPT);
            $update = $db->query("UPDATE $table SET password='$hash_pass',forget_token=NULL WHERE forget_token='$token'");

//            dd("UPDATE $table SET password='$hash_pass',forget_token=null WHERE forget_token=$token");
            if(!$update){
                dd($db->error);
            }

            echo "<script>alert('Password updated! Please login using new password.');window.location='login.php'</script>";
        }

    }else{
        echo "<script>alert('Token not found!');window.location='login.php'</script>";
    }

}else{
    echo "<script>alert('Invalid url parameter!');window.location='login.php'</script>";
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
                                    <h4>Set New Password</h4>
                                </div>
                                <form class="theme-form" method="post">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="email">Email</label>
                                        <input class="form-control" type="email" name="email" value="<?= $email ?>" id="email" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="password">New Password</label>
                                        <input class="form-control" type="password" name="password" id="password" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="confirm_password">Confirm Password</label>
                                        <input class="form-control" type="password" name="confirm_password" id="confirm_password" required>
                                    </div>
                                    <div class="form-group form-row mt-3 mb-0">
                                        <button class="btn btn-warning btn-block" type="submit">Update Password</button>
                                    </div>

                                    <div class="form-row text-center text">
                                        <div class="col-sm-12">
                                            <div class="mt-2 m-l-20">Back to?&nbsp;&nbsp;<a class="btn-link font-weight-bold text-warning" href="login.php">Login</a></div>
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
