<!DOCTYPE html>
<html lang="en">
<?php include_once('../permission_agent.php') ?>
<?php include('layout/head.php'); ?>
<?php
$result = $db->query("SELECT vc.id as vcid,v.id as vid,name,code,claim_at,vc.cost FROM voucher_claims as vc LEFT JOIN vouchers as v ON v.id=vc.voucher_id WHERE agent_id=$user_id");

$count = $result->num_rows;
$no = 1;
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
                        <div class="col-lg-6 col-md-4 col-sm-12">
                            <div class="card card-statistic-2">
                                <div class="card-stats">
                                    <div class="card-stats-title">Voucher Statistics</div>
                                    <div class="card-stats-items">
                                        <div class="card-stats-item">
                                            <div class="card-stats-item-count"><?= $count ?></div>
                                            <div class="card-stats-item-label">Redeemed Voucher</div>
                                        </div>
                                        <div class="card-stats-item">
                                            <div class="card-stats-item-count"><?=displayPoint($point_balance) ?></div>
                                            <div class="card-stats-item-label">Balance Point</div>
                                        </div>
                                        <div class="card-stats-item">
                                            <div class="card-stats-item-count"><?=displayPoint($point_balance) ?></div>
                                            <div class="card-stats-item-label">Total Point</div>
                                        </div>
                                    </div>

                                    <br>
                                </div>
                            </div>
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
                                                <th scope="row"><?= $no ?></th>
                                                <td class="text-uppercase"><?= $ticket['name']?></td>
                                                <td><?= $ticket['code'] ?></td>
                                                <td><?= $ticket['claim_at'] ?></td>
                                                <td><?=displayPoint($ticket['cost'] )?></td>
                                                <td><a href="voucher-view.php?id=<?=$ticket['vcid'] ?>" class="btn btn-sm btn-success">View</a> </td>
                                            </tr>
                                        <?php $no++; } ?>
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