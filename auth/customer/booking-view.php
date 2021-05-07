<!DOCTYPE html>
<html lang="en">
<?php include_once('../permission_customer.php') ?>
<?php include('layout/head.php'); ?>
<?php
if(isset($_GET['id'])){

    $booking_id = $_GET['id'];
    $booking_q = $db->query("SELECT * FROM bookings WHERE id='$booking_id' AND customer_id = $user_id");
    $booking = $booking_q->fetch_assoc();

    if(!$booking){
        echo "<script>alert('Booking not exist!');window.location='booking-index.php'</script>";
    }

    $house_id = $booking['house_id'];

    $house_q = $db->query("SELECT * FROM houses WHERE id=$house_id");
    $house = $house_q->fetch_assoc();

    $project_q = $db->query("SELECT * FROM projects WHERE id='$house[project_id]'");
    $project = $project_q->fetch_assoc();

    if(!$house){
        echo "<script>alert('House not exist!');window.location='project-index.php'</script>";
    }


    $customer_q = $db->query("SELECT * FROM customers WHERE id='$booking[customer_id]]'");
    $customer = $customer_q->fetch_assoc();

    $agent_q = $db->query("SELECT * FROM agents WHERE id='$booking[agent_id]'");
    $agent = $agent_q->fetch_assoc();

}else{
    echo "<script>alert('Error : missing parameter!');window.location='project-index.php'</script>";
}
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
                    <h1>View Booking</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="booking-index.php">Booking</a></div>
                        <div class="breadcrumb-item">#<?= $booking['id']?></div>
                        <div class="breadcrumb-item">View</div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <form method="post">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Project</label>
                                            <div class="col-sm-9">
                                                <p class="font-weight-bold"><?=$project['name']?></p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Type</label>
                                            <div class="col-sm-9">
                                                <p class="font-weight-bold"><?=getHouseType($house['type']) ?></p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Price</label>
                                            <div class="col-sm-9">
                                                <p class="font-weight-bold"><?= displayPrice($house['price'])?></p>
                                            </div>
                                        </div>
                                        
                                        <hr>Agent Details

                                        <div id="customer-details">
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-3 col-form-label">Name</label>
                                                <div class="col-sm-9">
                                                    <p class="font-weight-bold" id="name"><?= $agent['name']?></p>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                                <div class="col-sm-9">
                                                    <p class="font-weight-bold" id="email"><?= $agent['email']?></p>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="phone_number" class="col-sm-3 col-form-label">Phone Number</label>
                                                <div class="col-sm-9">
                                                    <p class="font-weight-bold" id="phone_number"><?= $agent['phone_number']?></p>
                                                </div>
                                            </div>

                                            <hr>Booking Details

                                            <div class="form-group row">
                                                <label for="remark" class="col-sm-3 col-form-label">Created At</label>
                                                <div class="col-sm-9">
                                                    <p><?= $booking['created_at'] ?> </p>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="remark" class="col-sm-3 col-form-label">Remark</label>
                                                <div class="col-sm-9">
                                                    <p><?= $booking['remark'] ?> </p>
                                                </div>
                                            </div>

                                            <?php if($booking['status'] == 0){ ?>

                                            <div class="form-group row">
                                                <label for="booking_status" class="col-sm-3 col-form-label">Booking Status</label>
                                                <div class="col-sm-9">
                                                    <p class="font-weight-bold" id="booking_status"><?= getBadgeBookingStatus($booking['status']) ?></p>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="code" class="col-sm-3 col-form-label">Approval Status</label>
                                                <div class="col-sm-9">
                                                    <div class="form-group">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" id="approve" name="approval" value="approve" checked>
                                                            <label class="form-check-label" for="approve">Approve</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" id="reject" name="approval" value="reject">
                                                            <label class="form-check-label" for="reject">Reject</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row" id="code_div">
                                                <label for="code" class="col-sm-3 col-form-label">Approval Code</label>
                                                <div class="col-sm-9">
                                                    <input name="code" id="code" class="form-control">
                                                    <small id="passwordHelpBlock" class="form-text text-muted">
                                                        Approval code was sent to your email.
                                                    </small>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-success btn-lg btn-block" id="submit">Submit Approval</button>
                                    </div>
                                    <?php } ?>
                                </div>
                            </form>
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
    $('input[type=radio][name=approval]').change(function() {
        if (this.value == 'approve') {
            $("#code_div").show();
        }
        else if (this.value == 'reject') {
            $("#code_div").hide();
        }
    });
</script>
</body>
</html>