
<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_admin.php') ?>
<?php
    $result = $db->query("SELECT * FROM agents WHERE deleted_at IS NOT NULL");

    if(isset($_GET['restore'])){

        $agent_id = $_GET['restore'];

        $update_customer ="UPDATE agents SET deleted_at=NULL WHERE id=$agent_id";

        if (!$db->query($update_customer)) {
            echo "Error: " . $update_customer . "<br>" . $db->error; exit();
        }else{
            echo "<script>alert('Agent successfully restored!');window.location='user-agent-deleted.php'</script>";
        }
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
                                    <li class="breadcrumb-item">Deleted</li>
                                </ol>
                            </div>
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
                                            <th>Rank</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Status</th>
                                            <th>Point</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php while($data = $result->fetch_assoc()){ ;?>
                                            <tr>
                                                <td><?= $data['id']; ?></td>
                                                <td><?= strLimit($data['name'], 20); ?></td>
                                                <td><?= strtoupper($data['rank']) ?></td>
                                                <td><?= $data['email']; ?></td>
                                                <td><?= $data['phone_number']; ?></td>
                                                <td><?= ($data['is_active'] == 0)? "<span class='badge badge-dark'>Inactive</span>" : "<span class='badge badge-success'>Active</span>"; ?></td>
                                                <td><?= getPointFormat($data['point']) ?></td>
                                                <td>
                                                    <a href="user-agent-deleted.php?restore=<?= $data['id']; ?>" onclick="return confirm('Are you sure want to restore this agent?')" class="btn btn-warning btn-xs" title="">Restore</a>
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

<?php include('layout/script.php'); ?>
<!-- Mirrored from laravel.pixelstrap.com/endless/sample-page by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 03 Nov 2020 07:18:47 GMT -->
</html>