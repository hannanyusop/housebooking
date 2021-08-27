<!DOCTYPE html>
<html lang="en">
<?php include_once('../permission_agent.php') ?>
<?php
if(isset($_GET['id'])){

    $booking_id = $_GET['id'];
    $booking_q = $db->query("SELECT * FROM bookings WHERE id='$booking_id' AND agent_id = $user_id");
    $booking = $booking_q->fetch_assoc();

    if(!$booking){
        echo "<script>alert('Booking not exist!');window.location='booking-index.php'</script>";
        exit();
    }

    if(isset($_GET['cancel'])){

        #set current booking to null
        $db->query("UPDATE houses SET current_booking_id=null WHERE id=$booking[house_id]");

        $db->query("DELETE FROM bookings WHERE id='$booking_id'");
        echo "<script>alert('Booking deleted!');window.location='booking-index.php'</script>";
        exit();

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

}else{
    echo "<script>alert('Error : missing parameter!');window.location='project-index.php'</script>";
}
?>
<?php include('layout/head.php'); ?>
<body>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <?php include('layout/top-bar.php') ?>
        <?php include('layout/side-bar.php'); ?>

        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h6>Booking View</h6>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
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
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Point Reward</label>
                                            <div class="col-sm-9">
                                                <p class="font-weight-bold"><?= $house['point'] ?></p>
                                            </div>
                                        </div>

                                        <hr>Customer Details

                                        <div id="customer-details">
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-3 col-form-label">Name</label>
                                                <div class="col-sm-9">
                                                    <p class="font-weight-bold" id="name"><?= $customer['name']?></p>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                                <div class="col-sm-9">
                                                    <p class="font-weight-bold" id="email"><?= $customer['email']?></p>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="phone_number" class="col-sm-3 col-form-label">Phone Number</label>
                                                <div class="col-sm-9">
                                                    <p class="font-weight-bold" id="phone_number"><?= $customer['phone_number']?></p>
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

                                            <div class="form-group row">
                                                <label for="code" class="col-sm-3 col-form-label">Security Code</label>
                                                <div class="col-sm-9">
                                                    <p class="font-weight-bold font-secondary" id="code"><?= $booking['code']?></p>
                                                    <small id="passwordHelpBlock" class="form-text text-muted">
                                                        Share this security code to your client for booking approval
                                                    </small>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="booking_status" class="col-sm-3 col-form-label">Booking Status</label>
                                                <div class="col-sm-9">
                                                    <p class="font-weight-bold" id="booking_status"><?= getBadgeBookingStatus($booking['status']) ?></p>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="booking_status" class="col-sm-3 col-form-label">Reward Gain</label>
                                                <div class="col-sm-9">
                                                    <p class="font-weight-bold" id="booking_status"><?= $booking['point_gain'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if(!is_null($booking['receipt'])){ ?>
                                        <div class="form-group row" id="code_div">
                                            <label for="receipt" class="col-sm-3 col-form-label">Booking Fee Receipt</label>
                                            <div class="col-sm-9">
                                                <embed src="<?= $booking['receipt'] ?>"><br>

                                                <a class="btn btn-info btn-sm" href="<?= $booking['receipt'] ?>" download> <span><i class="fa fa-download"></i> Download</span></a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="card-footer">
                                        <a href="booking-index.php" class="btn btn-info btn-lg">Back</a>
                                        <?php if($booking['status'] == 0){ ?>
                                        <a href="booking-view.php?id=<?= $booking_id ?>&cancel=true" onclick="return confirm('Are you sure want cancel and delete this booking?')" class="btn btn-danger btn-lg float-right" id="submit">Cancel Booking</a>
                                        <?php } ?>
                                    </div>
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
</body>
</html>