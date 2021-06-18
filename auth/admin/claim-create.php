
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

    $rand = randomPassword();

    if(isset($_POST['code'])){

        $code = strtoupper($_POST['code']);

        $claim_q = $db->query("SELECT * FROM voucher_claims WHERE code='$code'");
        $claim = $claim_q->fetch_assoc();

        if($claim){
            echo "<script>alert('Code already exist!');window.location='voucher-view.php?id=$voucher_id'</script>";
        }

        $query = "INSERT INTO voucher_claims (voucher_id, code) VALUES ($voucher_id, '$code')";

        if (!$db->query($query)) {
            echo "Error: " . $query . "<br>" . $db->error; exit();
        }else{
            echo "<script>alert('New voucher claim successfully inserted!');window.location='voucher-view.php?id=$voucher_id'</script>";
        }
    }

}else{
    echo "<script>alert('Invalid url!');window.location='voucher-index.php'</script>";
}
?>
<?= include('layout/head.php'); ?>

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
                                    <li class="breadcrumb-item">Voucher</li>
                                    <li class="breadcrumb-item"><?= $voucher['name'] ?></li>
                                    <li class="breadcrumb-item">Claim</li>
                                    <li class="breadcrumb-item">Create</li>

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
                                <form class="theme-form" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="code">Code</label>
                                        <input class="form-control text-uppercase" value="<?= $rand ?>" name="code" id="code" required>
                                    </div>

                                    <div class="form-group">
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <a href="project-index.php" class="btn btn-secondary" data-original-title="" title="">Cancel</a>
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
        <?php include('layout/footer.php'); ?>
        <!-- footer end-->
    </div>
    <!-- Page Body End-->
</div>
<!-- latest jquery-->

</body>

<?php include('layout/script.php'); ?>
</html>