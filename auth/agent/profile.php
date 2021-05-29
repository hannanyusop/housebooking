<!DOCTYPE html>
<html lang="en">
<?php include_once('../permission_agent.php') ?>
<?php include('layout/head.php'); ?>
<?php
$result = $db->query("SELECT vc.id as vcid,v.id as vid,name,code,claim_at,vc.cost FROM voucher_claims as vc LEFT JOIN vouchers as v ON v.id=vc.voucher_id WHERE agent_id=$user_id");

$count = $result->num_rows;
$no = 1;

$data = [];
$month = 1; $year = date('Y');
do{
    $query = $db->query("SELECT * from bookings WHERE agent_id=$user_id AND YEAR(created_at) = $year AND MONTH(created_at) = $month");

    $count = $query->num_rows;
    $data[] = $count;
    $month++;
}while($month <= 12);

$month = 1;
$success = [];
do{
    $query = $db->query("SELECT * from bookings WHERE agent_id=$user_id AND YEAR(created_at) = $year AND MONTH(created_at) = $month AND status =3");

    $count = $query->num_rows;
    $success[] = $count;
    $month++;
}while($month <= 12);

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
                    <h1>Profile</h1>
                </div>

                <div class="section-body">
                    <div class="d-flex justify-content-center bd-highlight mb-3">
                        <div class="col-lg-12 col-md-4 col-sm-12">
                            <div class="card card-statistic-2">
                                <div class="card-stats">
                                    <div class="card-stats-title">Statistics</div>
                                    <div class="card-stats-items">
                                        <div class="card-stats-item">
                                            <div class="card-stats-item-count"><?= $user['rank'] ?></div>
                                            <div class="card-stats-item-label">Total Booked House</div>
                                        </div>
                                        <div class="card-stats-item">
                                            <div class="card-stats-item-count"><?= getRank($user['rank']) ?></div>
                                            <div class="card-stats-item-label">Rating (<?= $user['rank'] ?> Star)</div>
                                        </div>
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
                        <div class="col-6 col-md-6 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-center">Booking Created Statistics For <?= date('Y') ?></p>
                                    <canvas id="myChart2"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-6 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-center">Approved Booking Statistics For <?= date('Y') ?></p>
                                    <canvas id="success"></canvas>
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
<script type="text/javascript">
    var ctx = document.getElementById("myChart2").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Statistics',
                data: <?= json_encode($data) ?>,
                borderWidth: 2,
                backgroundColor: '#6777ef',
                borderColor: '#6777ef',
                borderWidth: 2.5,
                pointBackgroundColor: '#ffffff',
                pointRadius: 4
            }]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        drawBorder: false,
                        color: '#f2f2f2',
                    },
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }],
                xAxes: [{
                    ticks: {
                        display: false
                    },
                    gridLines: {
                        display: false
                    }
                }]
            },
        }
    });

    var success = document.getElementById("success").getContext('2d');
    new Chart(success, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Statistics',
                data: <?= json_encode($success) ?>,
                borderWidth: 2,
                backgroundColor: '#6777ef',
                borderColor: '#6777ef',
                borderWidth: 2.5,
                pointBackgroundColor: '#ffffff',
                pointRadius: 4
            }]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        drawBorder: false,
                        color: '#f2f2f2',
                    },
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }],
                xAxes: [{
                    ticks: {
                        display: false
                    },
                    gridLines: {
                        display: false
                    }
                }]
            },
        }
    });
</script>
</body>
</html>