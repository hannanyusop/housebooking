<!DOCTYPE html>
<html lang="en">
<?php include_once('../permission_agent.php') ?>
<?php include('layout/head.php'); ?>
<?php

if(isset($_GET['id'])){

    $id = $_GET['id'];
    $result = $db->query("SELECT vc.id as vcid,v.id as vid,name,code,claim_at,vc.cost,image,valid_till FROM voucher_claims as vc LEFT JOIN vouchers as v ON v.id=vc.voucher_id WHERE agent_id=$user_id AND vc.id=$id");

    $voucher = $result->fetch_assoc();

    if(!$voucher){
        echo "<script>alert('Voucher not found!');window.location='voucher-my.php'</script>";
    }
}else{
    echo "<script>alert('Invalid url!');window.location='voucher-my.php'</script>";
}
?>
<body>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <?php include('layout/top-bar.php') ?>
        <?php include('layout/side-bar.php'); ?>

        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Vouchers</h1>
                </div>

                <div class="section-body">
                    <div class="d-flex justify-content-center bd-highlight mb-3">
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <img src="<?= $voucher['image'] ?>" class="img-fluid" style="height: 200px;">

                                    <div class="mt-4 mb-4">
                                        <h5><?= $voucher['name'] ?></h5>
                                        <h6>CODE : <?= $voucher['code'] ?></h6>

                                        <p>Claimed On : <?= $voucher['claim_at'] ?></p>
                                        <small>* You need to use this voucher before <?= $voucher['valid_till'] ?></small>
                                    </div>

                                    <a href="voucher-my.php" class="btn btn-info btn-round btn-icon icon-left">
                                        <i class="fas fa-caret-left"></i>
                                        Back
                                    </a>
                                </div>
                            </div>
                        </div>
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