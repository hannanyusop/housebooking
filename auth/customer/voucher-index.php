<!DOCTYPE html>
<html lang="en">
<?php include_once('../permission_customer.php') ?>
<?php include('layout/head.php'); ?>
<?php
$result = $db->query("SELECT * FROM vouchers WHERE is_deleted=0");
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
                    <h1>Coupon List</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                        <div class="breadcrumb-item"><a href="#">Voucher</a></div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <?php while($voucher = $result->fetch_assoc()){ ;?>
                            <div class="col-md-4">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <img src="<?= $voucher['image'] ?>" class="img-fluid" style="height: 200px;">
                                        <p>
                                            <h5><?= $voucher['name'] ?></h5>
                                            <h5>
                                                <?= displayPoint($voucher['cost']) ?><br>
                                                <small><?=$voucher['balance'] ?> Left</small>
                                            </h5>
                                        </p>

                                        <a href="" class="btn btn-success btn-round btn-icon icon-left">
                                            <i class="fas fa-dollar-sign"></i>
                                            Redeem
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
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