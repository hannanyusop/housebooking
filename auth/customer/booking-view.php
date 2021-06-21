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
        echo "<script>alert('Booking not exist!');window.location='booking-index.php'</script>";
    }


    $customer_q = $db->query("SELECT * FROM customers WHERE id='$booking[customer_id]]'");
    $customer = $customer_q->fetch_assoc();

    $agent_q = $db->query("SELECT * FROM agents WHERE id='$booking[agent_id]'");
    $agent = $agent_q->fetch_assoc();

    if(isset($_POST['approval'])){

        if($booking['status'] != 0){
            echo "<script>alert('Invalid action!');window.location='booking-view.php?id=$booking_id'</script>";
        }

        if($_POST['approval'] == 'approve'){

            if($_POST['code'] == ''){
                echo "<script>alert('Please insert approval code!');window.location='booking-view.php?id=$booking_id'</script>";
            }

            if($_POST['code'] != $booking['code']){
                echo "<script>alert('Invalid code!');window.location='booking-view.php?id=$booking_id'</script>";
            }else{

                $update = $db->query("UPDATE bookings SET status=1 WHERE id=$booking_id");
                echo "<script>alert('Booking approved! Please upload you receipt for booking fee.');window.location='booking-view.php?id=$booking_id'</script>";
            }
        }else{

            $update = $db->query("UPDATE bookings SET status=4 WHERE id=$booking_id");

            #set current booking to null
            $db->query("UPDATE houses SET current_booking_id=null WHERE id=$booking[house_id]");

            echo "<script>alert('Booking rejected!');window.location='booking-view.php?id=$booking_id'</script>";
        }

    }

    #status = 1
    if(isset($_FILES['receipt'])){

        $image = $booking['receipt'];

        $target_dir = "../../assets/uploads/receipt/";
        $temp = explode(".", $_FILES["receipt"]["name"]);
        $rename = round(microtime(true)) . '.' . end($temp);
        $image = $target_dir.$rename;

        #check if file more than 10MB
        if($_FILES['receipt']['size'] > 10000000){
            echo "<script>alert('Ops! Exceed file limit.(10MB)');window.location='booking-view.php?id=$booking_id'</script>";
            exit();
        }

        checkDir($target_dir);

        try{
            move_uploaded_file($_FILES["receipt"]["tmp_name"], $image);
        }catch (Exception $e){
            var_dump($e);exit();
        }

        if (!$db->query("UPDATE bookings SET receipt='$image',status=2 WHERE id=$booking_id")) {
            echo "Error:<br>" . $db->error; exit();
        }else{
            echo "<script>alert('Voucher successfully updated!');window.location='booking-index.php'</script>";
        }
    }

}else{
    echo "<script>alert('Error : missing parameter!');window.location='project-index.php'</script>";
}
?>

<body class="layout-3">
<div id="app">
    <div class="main-wrapper container">
        <div class="navbar-bg"></div>
        <?php include('layout/top-bar.php') ?>

        <nav class="navbar navbar-secondary navbar-expand-lg">
            <div class="container">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="booking-index.php" class="nav-link"><span>Dashboard</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="fa fa-caret-right"></i><span>Booking List</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="fa fa-caret-right"></i><span>View</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="fa fa-caret-right"></i><span>#<?= $booking['id']?></span></a>
                    </li>
                </ul>

            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-body">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
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

                                            <div class="form-group row">
                                                <label for="booking_status" class="col-sm-3 col-form-label">Booking Status</label>
                                                <div class="col-sm-9">
                                                    <p class="font-weight-bold" id="booking_status"><?= getBadgeBookingStatus($booking['status']) ?></p>
                                                </div>
                                            </div>
                                            <?php if($booking['status'] == 0){ ?>
                                                <form method="post">

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

                                    </form>
                                    <?php } ?>

                            <?php if($booking['status'] == 1){ ?>
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group row" id="code_div">
                                    <label for="receipt" class="col-sm-3 col-form-label">Booking Fee Receipt</label>
                                    <div class="col-sm-9">
                                        <input type="file" name="receipt" id="receipt" class="form-control"  accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" required>
                                    </div>
                                </div>
                                <?php if($booking['status'] == 1){ ?>
                                    <span class="text text-success font-weight-bold">
                                        Note : Please contact your agent to get bank info &
                                        house information before making any deposit payment.
                                    </span>
                                <?php }else{ ?>
                                    <?php if(!is_null($booking['receipt'])){ ?>
                                        <div class="form-group row" id="code_div">
                                            <label for="receipt" class="col-sm-3 col-form-label">Booking Fee Receipt</label>
                                            <div class="col-sm-9">
                                                <img src="<?= $booking['receipt'] ?>" width="400">
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success btn-lg btn-block" id="submit">Upload Payment Receipt</button>
                    </div>

                    </form>
                    <?php } ?>
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