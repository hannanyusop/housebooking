
<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_admin.php') ?>
<?php
    $result = $db->query("SELECT * FROM vouchers WHERE is_deleted=0");

    if(isset($_GET['delete'])){

        $voucher_id = $_GET['delete'];
        $voucher_q = $db->query("SELECT * FROM vouchers WHERE id=$voucher_id");
        $voucher = $voucher_q->fetch_assoc();

        if(!$voucher){
            echo "<script>alert('Voucher not exist!');window.location='voucher-index.php'</script>";
        }

        #if any voucher_claims apply function deleted
        $apply_q = $db->query("SELECT * FROM voucher_claims WHERE voucher_id=$voucher_id");
        $count_apply = $apply_q->num_rows;

        if($count_apply > 0){
            $db->query("UPDATE vouchers SET is_deleted = 1 WHERE id=$voucher_id");
        }else{
            $db->query("DELETE FROM vouchers WHERE id=$voucher_id");
        }

        echo "<script>alert('Voucher successfully deleted!');window.location='voucher-index.php'</script>";
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
                                    <li class="breadcrumb-item">Voucher</li>
                                </ol>
                            </div>
                        </div>
                        <div class="col">
                            <div class="bookmark pull-right">
                                <ul>
                                    <li><a href="voucher-create.php" class="btn btn-info text-white"><i class="fa fa-plus mr-1"></i> Create</a> </li>
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
                                            <th>Image</th>
                                            <th>Quantity</th>
                                            <th>Valid Until</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php while($data = $result->fetch_assoc()){ ;?>
                                            <tr>
                                                <td><?= $data['id']; ?></td>
                                                <td><?= strLimit($data['name'], 20); ?></td>
                                                <td><img src="<?= $data['image']?>" width="40px"></td>
                                                <td><?= $data['balance']. "/". $data['quantity']; ?></td>
                                                <td><?= getBadgeVoucherStatus($data['status']) ?></td>
                                                <td>
                                                    <a href="voucher-view.php?id=<?= $data['id']; ?>" class="btn btn-success btn-xs">View</a>
                                                    <a href="voucher-edit.php?id=<?= $data['id']; ?>" class="btn btn-info btn-xs">Edit</a>
                                                    <a href="voucher-index.php?delete=<?= $data['id']; ?>" onclick="return confirm('Are you sure want to delete this voucher?')" class="btn btn-danger btn-xs">Delete</a>
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
</html>