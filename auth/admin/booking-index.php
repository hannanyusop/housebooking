
<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_admin.php') ?>
<?php
$result = $db->query("SELECT * FROM bookings");
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
                                    <li class="breadcrumb-item">Booking Management</li>
                                </ol>
                            </div>
                        </div>
                        <div class="col">
                            <div class="bookmark pull-right">
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
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Project</th>
                                            <th>Type</th>
                                            <th scope="col">Agent Name</th>
                                            <th scope="col">Status</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php while($booking = $result->fetch_assoc()){ ;?>
                                            <?php
                                            $house_id = $booking['house_id'];

                                            $house_q = $db->query("SELECT * FROM houses WHERE id=$house_id");
                                            $house = $house_q->fetch_assoc();

                                            $project_q = $db->query("SELECT * FROM projects WHERE id='$house[project_id]'");
                                            $project = $project_q->fetch_assoc();

                                            $agent_q = $db->query("SELECT * FROM agents WHERE id='$booking[agent_id]'");
                                            $agent = $agent_q->fetch_assoc();
                                            ?>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td><?= $project['name'] ?></td>
                                                <td><?= getHouseType($house['type']) ?></td>
                                                <td><?= $agent['name'] ?></td>
                                                <td><?= getBadgeBookingStatus($booking['status']) ?></td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="booking-view.php?id=<?= $booking['id']?>" class="btn btn-success">View</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php }?>
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

<?= include('layout/script.php'); ?>
<!-- Mirrored from laravel.pixelstrap.com/endless/sample-page by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 03 Nov 2020 07:18:47 GMT -->
</html>