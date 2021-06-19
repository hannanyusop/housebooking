
<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_admin.php') ?>
<?php include('layout/head.php'); ?>

<body main-theme-layout="main-theme-layout-1">
<?php
$data = [];
$month = 1; $year = date('Y');
do{
    $query = $db->query("SELECT * from bookings WHERE  YEAR(created_at) = $year AND MONTH(created_at) = $month");

    $count = $query->num_rows;
    $data[] = $count;
    $month++;
}while($month <= 12);

$month = 1;
$success = [];
do{
    $query = $db->query("SELECT * from bookings WHERE YEAR(created_at) = $year AND MONTH(created_at) = $month AND status =3");

    $count = $query->num_rows;
    $success[] = $count;
    $month++;
}while($month <= 12);

?>
<?php

$customer_q = $db->query("SELECT * FROM customers");
$customer = $customer_q->num_rows;

$agent_q = $db->query("SELECT * FROM agents");
$agent = $agent_q->num_rows;

$house_q = $db->query("SELECT * FROM houses");
$house = $house_q->num_rows;

$booking_q = $db->query("SELECT * FROM bookings");
$booking = $booking_q->num_rows;

$booking_approve_q = $db->query("SELECT * FROM bookings WHERE status = 3");
$booking_approve = $booking_approve_q->num_rows;

$project_q = $db->query("SELECT * FROM projects");
$project= $project_q->num_rows;

$active_agent_q = $db->query("SELECT sum(id) as active FROM bookings GROUP by agent_id");
$active_agent   = $active_agent_q->num_rows;

$active_customer_q = $db->query("SELECT sum(id) as active FROM bookings GROUP by customer_id");
$active_customer   = $active_customer_q->num_rows;


$top_agent_q = $db->query("SELECT * FROM agents order by rank DESC LIMIT 5");


?>

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
                                <h3>Dashboard</h3>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php"><i data-feather="home"></i></a></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="row">
                        <div class="col-xl-3 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="media">
                                        <h5 class="mb-0">Registered Customer</h5>
                                    </div>
                                    <div class="project-widgets text-center">
                                        <h1 class="font-primary counter"><?= $customer?></h1>
                                        <h6 class="mb-0">Customers</h6>
                                    </div>
                                </div>
                                <div class="card-footer project-footer">
                                    <h6 class="mb-0">Active: <span class="counter"><?= $active_customer ?></span></h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="media">
                                        <h5 class="mb-0">Total Agent</h5>
                                    </div>
                                    <div class="project-widgets text-center">
                                        <h1 class="font-primary counter"><?= $agent ?></h1>
                                        <h6 class="mb-0">Agents</h6>
                                    </div>
                                </div>
                                <div class="card-footer project-footer">
                                    <h6 class="mb-0">Active: <span class="counter"><?= $active_agent ?></span></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="media">
                                        <h5 class="mb-0">Booking Created</h5>
                                    </div>
                                    <div class="project-widgets text-center">
                                        <h1 class="font-primary counter"><?= $booking ?></h1>
                                        <h6 class="mb-0">Bookings</h6>
                                    </div>
                                </div>
                                <div class="card-footer project-footer">
                                    <h6 class="mb-0">Confirmed Booking: <span class="counter"><?= $booking_approve ?></span></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="media">
                                        <h5 class="mb-0">Total Property </h5>
                                    </div>
                                    <div class="project-widgets text-center">
                                        <h1 class="font-primary counter"><?= $house ?></h1>
                                        <h6 class="mb-0">Properties</h6>
                                    </div>
                                </div>
                                <div class="card-footer project-footer">
                                    <h6 class="mb-0">Total Project: <span class="counter"><?= $project ?> </span></h6>
                                </div>
                            </div>
                        </div>

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

                        <div class="col-xl-7">
                            <div class="card height-equal" style="min-height: auto;">
                                <div class="card-header card-header-border">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <h5>Top Agent</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="new-users">
                                        <?php while($top_agent = $top_agent_q->fetch_assoc()){ ;?>
                                            <div class="media">
                                                <img class="rounded-circle image-radius m-r-15" src="<?= generateUIAvatar($top_agent['name']) ?>">
                                                <div class="media-body">
                                                    <h6 class="mb-0 f-w-700"><?= $top_agent['name'] ?></h6>
                                                    <p>Approved Booking : <?=$top_agent['rank'] ?></p>


                                                </div>
                                                <span class="pull-right">
                                                 <?= getRank($top_agent['rank']) ?>
                                            </span>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
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
</html>