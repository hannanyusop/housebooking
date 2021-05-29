
<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_admin.php') ?>
<?php
    if(isset($_GET['activate'])){

        $customer_id = $_GET['activate'];

        $update_customer ="UPDATE customers SET approved_at=NOW() WHERE id=$customer_id";

        if (!$db->query($update_customer)) {
            echo "Error: " . $update_customer . "<br>" . $db->error; exit();
        }else{
            echo "<script>alert('Customer successfully activated!');window.location='user-customer-index.php'</script>";
        }
    }

    if(isset($_GET['deactivate'])){

        $customer_id = $_GET['deactivate'];

        $update_customer ="UPDATE customers SET approved_at=null WHERE id=$customer_id";

        if (!$db->query($update_customer)) {
            echo "Error: " . $update_customer . "<br>" . $db->error; exit();
        }else{
            echo "<script>alert('Customer successfully deactivated!');window.location='user-customer-index.php'</script>";
        }
    }

    if (isset($_GET['reset_password'])){

        $default_password = password_hash("secret", PASSWORD_BCRYPT);

        if (!$db->query("UPDATE customers SET password='$default_password' WHERE id=$_GET[reset_password]")) {
            echo "Error: Updating staff password." . $db->error; exit();
        }else{
            echo "<script>alert('Customer\'s Password has been reset to default. (Default : secret)');window.location='user-customer-index.php'</script>";
        }
    }
    $result = $db->query("SELECT * FROM customers");
?>
<?= include('layout/head.php'); ?>

<body main-theme-layout="main-theme-layout-1">
<div class="page-wrapper">
    <?php include('layout/top-bar.php') ?>
    <div class="page-body-wrapper">
        <?php include('layout/side-bar.php'); ?>
        <div class="page-body">
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col">
                            <div class="page-header-left">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">User Management</li>
                                    <li class="breadcrumb-item">Customer</li>
                                </ol>
                            </div>
                        </div>
                        <div class="col">
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive product-table">
                                    <table class="display table-sm" id="datatable">
                                        <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php while($data = $result->fetch_assoc()){ ;?>
                                            <tr>
                                                <td><?= $data['id']; ?></td>
                                                <td><?= strLimit($data['name'], 20); ?></td>
                                                <td><?= $data['email']; ?></td>
                                                <td><?= $data['phone_number']; ?></td>
                                                <td><?= (is_null($data['approved_at']))? "<span class='badge badge-dark'>Inactive</span>" : "<span class='badge badge-success'>Active</span>"; ?></td>
                                                <td>
                                                    <?php if(is_null($data['approved_at'])){ ?>
                                                        <a href="user-customer-index.php?activate=<?= $data['id']; ?>" class="btn btn-info btn-xs" onclick="return confirm('Are you sure want to activate this user?')">Activate</a>
                                                    <?php }else{ ?>
                                                        <a href="user-customer-edit.php?id=<?= $data['id']; ?>" class="btn btn-success btn-xs" type="button">Edit</a>
                                                        <a href="user-customer-index.php?reset_password=<?= $data['id']; ?>" onclick="return confirm('Are you sure want to reset this customer password using default password?')" class="btn btn-secondary btn-xs" type="button">Reset Password</a>
                                                        <a href="user-customer-index.php?deactivate=<?= $data['id']; ?>" class="btn btn-info btn-xs" onclick="return confirm('Are you sure want to deactivate this user?')">Deactivate</a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
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

<?php include('layout/script.php'); ?>
</html>