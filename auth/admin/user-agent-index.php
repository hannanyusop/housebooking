
<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_admin.php') ?>
<?php
    $result = $db->query("SELECT * FROM agents WHERE deleted_at IS NULL");

    if(isset($_GET['delete'])){

        $agent_id = $_GET['delete'];

        $update_customer ="UPDATE agents SET deleted_at=NOW() WHERE id=$agent_id";

        if (!$db->query($update_customer)) {
            echo "Error: " . $update_customer . "<br>" . $db->error; exit();
        }else{
            echo "<script>alert('Agent successfully deleted!');window.location='user-agent-index.php'</script>";
        }
    }
?>
<?php include('layout/head.php'); ?>

<body main-theme-layout="main-theme-layout-1">

<!-- Loader ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper">
    <?= include('layout/top-bar.php') ?>
    <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <?= include('layout/side-bar.php'); ?>

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
                                    <li class="breadcrumb-item">Agent</li>
                                </ol>
                            </div>
                        </div>
                        <div class="col">
                            <div class="bookmark pull-right">
                                <ul>
                                    <li><a href="user-agent-create.php" class="btn btn-info text-white"><i class="fa fa-plus mr-1"></i> Add New</a> </li>
                                    <li><a href="user-agent-deleted.php" class="btn btn-dark text-white"><i class="fa fa-trash-o mr-1"></i> Deleted List</a> </li>
                                </ul>
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
                                                    <a href="user-agent-edit.php?id=<?= $data['id']; ?>" class="btn btn-info btn-xs"  title="">Edit</a>
                                                    <a href="user-agent-index.php?delete=<?= $data['id']; ?>" onclick="return confirm('Are you sure want to soft delete this agent?')" class="btn btn-danger btn-xs" title="">Delete</a>
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