<!DOCTYPE html>
<html lang="en">
<?php include_once('../permission_agent.php') ?>
<?php include('layout/head.php'); ?>
<?php
$result = $db->query("SELECT * FROM voucher_claims as vc LEFT JOIN vouchers as v ON v.id=vc.voucher_id WHERE agent_id=$user_id");

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
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Code</th>
                                            <th scope="col">Redeemed On</th>
                                            <th scope="col">Cost</th>
                                            <th scope="col"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php while ($ticket = $result->fetch_assoc()){ ?>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td class="text-uppercase"><?= $ticket['name']?></td>
                                                <td><?= $ticket['code'] ?></td>
                                                <td><?= $ticket['claim_at'] ?></td>
                                                <td><?=displayPoint($ticket['cost'] )?></td>
                                                <td><a href="" class="btn btn-sm btn-success">View</a> </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
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