<!DOCTYPE html>
<html lang="en">
<?php include_once('../permission_agent.php') ?>
<?php include('layout/head.php'); ?>
<?php
    $user_q = $db->query("SELECT * FROM agents WHERE id=$user_id");
    $user = $user_q->fetch_assoc();

    if(isset($_POST['email'])){

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Ops! invalid email!');window.location='profile-update.php '</script>";
            exit();
        }

        $customer_q = $db->query("SELECT * FROM customers WHERE email='$_POST[email]'");
        $customer = $customer_q->fetch_assoc();

        $agent_q = $db->query("SELECT * FROM agents WHERE email='$_POST[email]' AND id !=$user_id");
        $agent = $agent_q->fetch_assoc();

        $admin_q = $db->query("SELECT * FROM admin WHERE email='$_POST[email]'");
        $admin = $admin_q->fetch_assoc();

        if($customer || $agent || $admin){
            echo "<script>alert('Email already exist!');window.location='profile-update.php'</script>";
            exit();
        }

        $name = strtoupper($_POST['name']);
        $update = $db->query("UPDATE agents SET email='$_POST[email]', phone_number='$_POST[phone_number]',name='$name' WHERE id=$user_id");
        if(!$update){
            dd($db->error);
        }

        echo "<script>alert('Information updated!');window.location='profile-update.php'</script>";
    }

    if(isset($_POST['password'])){

        $x = $_POST['password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if (!password_verify($x, $user['password'])) {
            echo "<script>alert('Incorrect old password!');window.location='profile-update.php'</script>";
            exit();
        }

        if($new_password != $confirm_password){
            echo "<script>alert('Confirm password not match!');window.location='profile-update.php'</script>";
            exit();
        }

        if($x == $new_password){
            echo "<script>alert('Do not use old password!');window.location='profile-update.php'</script>";
            exit();
        }

        $hash_pass = password_hash($new_password, PASSWORD_BCRYPT);
        $update = $db->query("UPDATE agents SET password='$hash_pass' WHERE id=$user_id");
        if(!$update){
            dd($db->error);
        }

        echo "<script>alert('Password updated!');window.location='profile-update.php'</script>";
    }
?>

<body class="layout-3">
<div id="app">
    <div class="main-wrapper container">
        <div class="navbar-bg"></div>
        <?php include('layout/top-bar.php') ?>

        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>My Profile</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="index.php">Dashboard</a></div>
                        <div class="breadcrumb-item">My Profile</div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="col-12 offset-md-2 offset-lg-2 col-md-8 col-lg-8">
                        <form method="post" class="card">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="name" class="form-control text-uppercase" id="name" value="<?= $user['name'] ?>" placeholder="Full Name" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" name="email" class="form-control" id="email" value="<?= $user['email'] ?>" placeholder="Email" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="phone_number" class="col-sm-3 col-form-label">Phone Number</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="phone_number" class="form-control" id="phone_number" value="<?= $user['phone_number'] ?>" placeholder="Phone Number" required>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" name="info">Update Information</button>
                            </div>
                        </form>

                        <form method="post" class="card">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="password" class="col-sm-3 col-form-label">Password</label>
                                    <div class="col-sm-9">
                                        <input name="password" type="password" class="form-control" id="password" placeholder="Password" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="new_password" class="col-sm-3 col-form-label">New Password</label>
                                    <div class="col-sm-9">
                                        <input name="new_password" type="password" class="form-control" minlength="5" id="new_password" placeholder="New Password" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="confirm_password" class="col-sm-3 col-form-label">Confirm Password</label>
                                    <div class="col-sm-9">
                                        <input name="confirm_password" type="password" class="form-control" minlength="5" id="confirm_password" placeholder="Confirm Password" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" name="update_password">Update Password</button>
                            </div>
                        </form>

                    </div>
                </div>
            </section>
        </div>
        <?php include('layout/footer.php'); ?>
    </div>
</div>

<?php include('layout/script.php'); ?>
</body>
</html>