<!DOCTYPE html>
<html lang="en">
<?php include_once('../permission_agent.php') ?>
<?php include('layout/head.php'); ?>
<?php
$result = $db->query("SELECT * FROM vouchers WHERE is_deleted=0");

if(isset($_GET['redeem'])){

    $voucher_id = $_GET['redeem'];
    $voucher_q = $db->query("SELECT * FROM vouchers WHERE id=$voucher_id");
    $voucher = $voucher_q->fetch_assoc();

    if(!$voucher){
        echo "<script>alert('Voucher not exist!');window.location='voucher-index.php'</script>";
    }

    $not_claim_q = $db->query("SELECT * FROM voucher_claims WHERE voucher_id='$voucher_id' AND agent_id IS NULL");
    $not_claims_count = $not_claim_q->num_rows;

    if($not_claims_count <= 0){
        echo "<script>alert('Voucher fully redeemed!');window.location='voucher-index.php'</script>";
    }else{

        if($point_balance < $voucher['cost']){
            echo "<script>alert('Not enough balance!');window.location='voucher-index.php'</script>";
            dd('stop');
        }

        $ticket_q = $db->query("SELECT * FROM voucher_claims WHERE voucher_id='$voucher_id' AND agent_id IS NULL");
        $ticket = $ticket_q->fetch_assoc();

        $ticket_id = $ticket['id'];

        $new_balance = $point_balance-$voucher['cost'];
        $update_ticket = $db->query("UPDATE voucher_claims SET agent_id=$user_id,claim_at=NOW(),cost=$voucher[cost] WHERE id=$ticket_id");
        $update_user = $db->query("UPDATE agents SET point=$new_balance WHERE id=$user_id");

        echo "<script>alert('Redeemtion successfully!');window.location='voucher-index.php'</script>";


    }
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
                    <div class="row text-center">
                        <div class="col-md-12 text-center mb-4">
                            <h4 class="text-danger"><i class="fa fa-fire fa-1x "></i> Our Hot Deals</h4>
                            <h6 class="text-success">Point Balance : <?=displayPoint($point_balance) ?></h6>
                        </div>
                    </div>
                    <div class="row">
                        <?php while($voucher = $result->fetch_assoc()){ ;?>
                            <?php
                            $not_claim_q = $db->query("SELECT * FROM voucher_claims WHERE voucher_id='$voucher[id]' AND agent_id IS NULL");
                            $not_claims_count = $not_claim_q->num_rows;
                            ?>
                            <div class="col-md-4">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <img src="<?= $voucher['image'] ?>" class="img-fluid" style="height: 200px;">
                                        <p>
                                        <h5><?= $voucher['name'] ?></h5>
                                        <h5>
                                            <?= displayPoint($voucher['cost']) ?><br>
                                            <small><?=$not_claims_count ?> Left</small>
                                        </h5>
                                        </p>

                                        <?php if($not_claims_count <= 0){ ?>
                                            <a href="" class="btn btn-danger btn-round btn-icon icon-left disabled">
                                                <i class="fas fa-dollar-sign"></i>
                                                Fully Redeemed
                                            </a>
                                        <?php }else{ ?>
                                            <a onclick="return confirm('Are you sure want to redeem this voucher?')" href="voucher-index.php?redeem=<?= $voucher['id']?>" class="btn btn-success btn-round btn-icon icon-left <?= ($point_balance < $voucher['cost'])? "disabled" : "" ?>">
                                                <i class="fas fa-dollar-sign"></i>
                                                Redeem
                                            </a>
                                        <?php } ?>
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