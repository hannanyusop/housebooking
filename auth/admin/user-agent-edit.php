
<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_admin.php') ?>
<?php
    if(isset($_GET['id'])){

        $cust_q = $db->query("SELECT * FROM agents WHERE id=$_GET[id] AND deleted_at IS NULL");
        $cust = $cust_q->fetch_assoc();

        if(!$cust){
            echo "<script>alert('Agent not exist!');window.location='user-agent-index.php'</script>";
        }

        if(isset($_POST['name'])){


            $check_q = $db->query("SELECT * FROM agents WHERE email='$_POST[email]' AND id <> $_GET[id]");
            $check = $check_q->fetch_assoc();

            if($check) {
                echo "<script>alert('Email already exist!');window.location='user-agent-edit.php?id=$_GET[id]'</script>";
            }

            $name = strtoupper($_POST['name']);

            if (!$db->query("UPDATE agents SET name='$name', email = '$_POST[email]', phone_number = '$_POST[phone_number]' WHERE id=$_GET[id]")) {
                echo "Error: Inserting user data." . $db->error; exit();
            }else{

                echo "<script>alert('Agent information updated!');window.location='user-agent-index.php'</script>";
            }

        }
    }else{
        echo "<script>alert('Error : missing parameter!');window.location='user-agent-index.php'</script>";
    }
?>
<?php include('layout/head.php'); ?>

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
                            <div class="card-header">
                                <h5>Edit Agent</h5>
                            </div>
                            <div class="card-body">
                                <form class="theme-form" method="post">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="name">Name</label>
                                        <input class="form-control text-uppercase" name="name" id="name" value="<?=$cust['name']?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="email">Email</label>
                                        <input class="form-control col-md-6" type="email" name="email" id="email" value="<?=$cust['email'] ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="phone_number">Phone Number</label>
                                        <input class="form-control text-uppercase col-md-6" type="text" name="phone_number" id="phone_number" value="<?=$cust['phone_number'] ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <a href="user-agent-index.php" class="btn btn-secondary" data-original-title="" title="">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('layout/footer.php'); ?>
    </div>
</div>
</body>

<?= include('layout/script.php'); ?>
</html>