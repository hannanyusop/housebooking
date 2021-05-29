
<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_admin.php') ?>
<?php

    if(isset($_GET['id'])){

        $id = $_GET['id'];

        $admin_q = $db->query("SELECT * FROM admin WHERE id=$id");
        $admin = $admin_q->fetch_assoc();

        if(!$admin){
            echo "<script>alert('Invalid admin data!');window.location='user-admin-index.php'</script>";
        }


        if(isset($_POST['name'])){

            $check_email_q = $db->query("SELECT * FROM admin WHERE email='$_POST[email]' AND id!=$id");
            $check_email   = $check_email_q->fetch_assoc();

            if($check_email){
                echo "<script>alert('Email already used!');window.location='user-admin-edit.php?id=$id'</script>";
            }

            $update = "UPDATE admin SET email='$_POST[email]', name='$_POST[name]' WHERE id=$id";

            if (!$db->query($update)) {
                echo "Error: " . $update . "<br>" . $db->error; exit();
            }else{
                echo "<script>alert('Admin successfully updated!');window.location='user-admin-index.php'</script>";
            }
        }

    }else{
        echo "<script>alert('Invalid url!');window.location='user-admin-index.php'</script>";
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
                                    <li class="breadcrumb-item active"><a href="user-agent-index.php">Admin</a> </li>
                                    <li class="breadcrumb-item">Edit</li>
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
                                        <input class="form-control" name="name" id="name" value="<?= $admin['name'] ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="email">Email</label>
                                        <input class="form-control col-md-6" type="email" name="email" id="email" value="<?= $admin['email'] ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <a href="user-admin-index.php" class="btn btn-secondary">Cancel</a>
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