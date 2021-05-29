
<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_admin.php') ?>
<?php
    if(isset($_POST['name'])){

        $password = password_hash("secret", PASSWORD_BCRYPT);

        $agents = "INSERT INTO agents (is_active, email, password, name, phone_number, rank) 
VALUES (1, '$_POST[email]', '$password', '$_POST[name]', '$_POST[phone_number]', 0)";
        if (!$db->query($agents)) {
            echo "Error: " . $agents . "<br>" . $db->error; exit();
        }else{
            echo "<script>alert('New agent successfully created!');window.location='user-agent-index.php'</script>";
        }
    }
?>
<?= include('layout/head.php'); ?>

<body main-theme-layout="main-theme-layout-1">

<!-- Loader ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper">
    <?php include('layout/top-bar.php') ?>
    <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <?php include('layout/side-bar.php'); ?>

        <div class="page-body">
            <!-- breadcrumb  Start -->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col">
                            <div class="page-header-left">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">User Management</li>
                                    <li class="breadcrumb-item active"><a href="user-agent-index.php">Agent</a> </li>
                                        <li class="breadcrumb-item">Add</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-8 offset-md-2">
                        <div class="card">
                            <div class="card-body">
                                <form class="theme-form" method="post">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="name">Name</label>
                                        <input class="form-control text-uppercase" name="name" id="name" data-original-title="" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="email">Email</label>
                                        <input class="form-control text-uppercase col-md-6" type="email" name="email" id="email" data-original-title="" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="phone_number">Phone Number</label>
                                        <input class="form-control text-uppercase col-md-6" type="text" name="phone_number" id="phone_number" data-original-title="" required>
                                    </div>

                                    <div class="form-group">
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <a href="data-inventory.php" class="btn btn-secondary" data-original-title="" title="">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        <?= include('layout/footer.php'); ?>
        <!-- footer end-->
    </div>
    <!-- Page Body End-->
</div>
<!-- latest jquery-->

</body>

<?= include('layout/script.php'); ?>
<!-- Mirrored from laravel.pixelstrap.com/endless/sample-page by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 03 Nov 2020 07:18:47 GMT -->
</html>