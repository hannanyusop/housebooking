
<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_admin.php') ?>
<?php
if(isset($_GET['id'])){

    $booking_id = $_GET['id'];
    $booking_q = $db->query("SELECT * FROM bookings WHERE id='$booking_id'");
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

    if(isset($_GET['approve'])){

        if($booking['status'] != 2){
            echo "<script>alert('Invalid action!');window.location='booking-view.php?id=$booking_id'</script>";
        }

        if($_GET['approve'] == 'true'){

            $point = $house['point'];
            $rank = $agent['rank']+1;
            $update = $db->query("UPDATE bookings SET status=3,point_gain=$point WHERE id=$booking_id");
            $db->query("UPDATE houses SET current_booking_id=$booking_id WHERE id=$house[id]");

            $agent_point = $agent['point']+$point;
            $agent_total_point = $agent['total_point']+$point;
            $update_agent = $db->query("UPDATE agents SET total_point=$agent_total_point, point=$agent_point,rank=$rank WHERE id='$agent[id]'");
            echo "<script>alert('Booking approved!');window.location='booking-view.php?id=$booking_id'</script>";
        }else{


            $db->query("UPDATE houses SET current_booking_id=null WHERE id=$house_id");

            $update = $db->query("UPDATE bookings SET status=5 WHERE id=$booking_id");
            echo "<script>alert('Booking rejected!');window.location='booking-view.php?id=$booking_id'</script>";
        }

    }


}else{
    echo "<script>alert('Error : missing parameter!');window.location='project-index.php'</script>";
}
?>
<?php include('layout/head.php'); ?>

<body main-theme-layout="main-theme-layout-1">

<!-- Loader ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper">
    <<?php include('layout/top-bar.php') ?>
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
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="booking-index.php">Booking Management</a> </li>
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

                                    <?php if(!is_null($booking['receipt'])){ ?>
                                        <div class="form-group row" id="code_div">
                                            <label for="receipt" class="col-sm-3 col-form-label">Booking Fee Receipt</label>
                                            <div class="col-sm-9">
                                                <img src="<?= $booking['receipt'] ?>" width="400">
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php if($booking['status'] == 2){ ?>
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <div class="text-center">
                                                <a href="booking-view.php?id=<?= $booking_id ?>&approve=true" class="btn btn-success btn-lg">Approve</a>
                                                <a href="booking-view.php?id=<?= $booking_id ?>&approve=false" class="btn btn-danger btn-lg">Reject</a>
                                            </div>
                                        </div>

                                    </form>
                                    <?php } ?>
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
</html>