
<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_admin.php') ?>
<?php

if(isset($_GET['id'])){

    $voucher_id = $_GET['id'];

    $voucher_q = $db->query("SELECT * FROM vouchers WHERE id=$voucher_id");
    $voucher = $voucher_q->fetch_assoc();

    if(!$voucher){
        echo "<script>alert('Voucher not exist!');window.location='voucher-index.php'</script>";
    }


    $claims = $db->query("SELECT * FROM voucher_claims WHERE voucher_id=$voucher_id");


    if(isset($_GET['delete'])){

        $claim_id = $_GET['delete'];

        $voucher_q = $db->query("SELECT * FROM voucher_claims WHERE voucher_id=$claim_id");
        $voucher = $voucher_q->fetch_assoc();

        if(!$voucher){
            echo "<script>alert('Ticket not exist!');window.location='voucher-view.php?id=$voucher_id'</script>";
        }

        $db->query("DELETE FROM voucher_claims WHERE id=$claim_id");

        echo "<script>alert('Voucher successfully deleted!');window.location='voucher-view.php?id=$voucher_id'</script>";
    }

}else{
    echo "<script>alert('Invalid url!');window.location='voucher-index.php'</script>";
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
                                    <li class="breadcrumb-item"><a href="voucher-index.php">Voucher</a> </li>
                                    <li class="breadcrumb-item">View</li>
                                    <li class="breadcrumb-item"><?= $voucher['name']?></li>
                                    <li class="breadcrumb-item">Ticket</li>
                                </ol>
                            </div>
                        </div>
                        <div class="col">
                            <div class="bookmark pull-right">
                                <ul>
                                    <li><a href="claim-create.php?id=<?= $voucher_id ?>" class="btn btn-info text-white"><i class="fa fa-plus mr-1"></i> Add Voucher</a> </li>
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
                                            <th>Code</th>
                                            <th>Status</th>
                                            <th>Redeem By</th>
                                            <th>Redeem On</th>
                                            <th>Cost</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php while($data = $claims->fetch_assoc()){ ;?>
                                            <tr>
                                                <td><?= $data['id']; ?></td>
                                                <td><?= $data['code']?></td>
                                                <td><?= (is_null($data['agent_id']))? "Fully Redeem" : "Available" ?></td>
                                                <td><?= (is_null($data['agent_id']))? $data['agent_id'] : "-" ?></td>
                                                <td><?= (is_null($data['agent_id']))? $data['claim_at'] : "-" ?></td>
                                                <td><?= (is_null($data['agent_id']))? displayPoint($data['cost']) : "-"?></td>
                                                <td>
                                                    <a href="voucher-view.php?id=<?=$voucher_id?>&delete=<?= $data['id']; ?>" onclick="return confirm('Are you sure want to delete this voucher?')" class="btn btn-danger btn-xs">Delete</a>
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