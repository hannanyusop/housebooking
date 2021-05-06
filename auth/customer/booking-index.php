<!DOCTYPE html>
<html lang="en">
<?php include_once('../permission_customer.php') ?>
<?php include('layout/head.php'); ?>
<?php
$result = $db->query("SELECT * FROM bookings WHERE customer_id=$user_id");

$project_count = $result->num_rows;
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
                    <h1>Booking List</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                        <div class="breadcrumb-item"><a href="#">Layout</a></div>
                        <div class="breadcrumb-item">Top Navigation</div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
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
                                            <td><?= getBadgeProjectStatus($booking['status']) ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="booking-view.php?id=<?= $booking['id']?>" class="btn btn-success">View</a>
                                                    <a href="#" class="btn btn-danger">Decline</a>
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
            </section>
        </div>
        <?php include('layout/footer.php'); ?>
    </div>
</div>

<?php include('layout/script.php'); ?>
</body>
</html>