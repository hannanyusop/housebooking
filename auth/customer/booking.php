<!DOCTYPE html>
<html lang="en">
<?php include_once('../permission_customer.php') ?>
<?php include('layout/head.php'); ?>
<?php
$result = $db->query("SELECT * FROM projects");

$project_count = $result->num_rows;

if(isset($_SESSION['book'])){

    #check if user still have pending booking
    $pending_q = $db->query("SELECT * FROM bookings WHERE status=1 AND customer_id=$user_id");

    if($pending_q->num_rows > 0){

        #delete booking session
        unset($_SESSION['book']);
        echo "<script>alert('You not allowed to make new booking. Please complete/cancel previous booking first!');window.location='booking-index.php'</script>";
    }

    $session = $_SESSION['book'];
    $house_q = $db->query("SELECT * FROM houses WHERE id=$session[house_id] AND current_booking_id IS NULL");
    $house = $house_q->fetch_assoc();

    if(!$house){
        echo "<script>alert('Invalid house!');window.location='booking-index.php'</script>";
    }

    $customer_q = $db->query("SELECT * FROM customers WHERE id=$user_id");
    $customer = $customer_q->fetch_assoc();

    $agent_q = $db->query("SELECT * FROM agents WHERE id=$session[agent_id]");
    $agent = $agent_q->fetch_assoc();

    $project_q = $db->query("SELECT * FROM projects WHERE id='$house[project_id]'");
    $project = $project_q->fetch_assoc();

    if(isset($_POST['submit'])){

        #delete session booking;
        unset($_SESSION['book']);

        $code = rand(11111,99999);

        $booking = "INSERT INTO bookings (house_id,agent_id,customer_id,status,code,point_gain, remark, created_at, created_by_customer) VALUES ('$house[id]', $agent[id], '$user_id', 1, '$code', 0, '', NOW(), 1)";
        if (!$db->query($booking)) {
            echo "Error: " . $booking . "<br>" . $db->error; exit();
        }else{

            #set current booking id to this house to prevent from duplicate booking
            $db->query("UPDATE houses SET current_booking_id=$db->insert_id WHERE id=$house[id]");

            $body = "Hye $agent[name],<br><br>
            <p>New Booking Request From</p>
            <p>Name: $customer[name]</p>
            <p>Email : $customer[email]</p>
            <hr><br>
            <h5>House Information</h5>
            <p>Project : $project[name]</p>
            <p>House : $house[name]</p>
           

            <br><br>
            <small>Please login to get full booking detail</small>";

            sendEmail($agent['email'], "BOOKING REQUEST", $body);
            echo "<script>alert('New project successfully created!');window.location='booking-index.php'</script>";
        }
    }



}else{
    echo "<script>window.location='index.php'</script>";
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
                    <h1>Project List</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="index.php">Dashboard</a></div>
                        <div class="breadcrumb-item">Project List</div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <form method="post">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">House</label>
                                            <div class="col-sm-9">
                                                <p class="font-weight-bold"><?=$house['name']?></p>
                                            </div>
                                        </div>
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

                                        <hr>
                                        <h5>Agent Info</h5>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Name</label>
                                            <div class="col-sm-9">
                                                <p class="font-weight-bold"><?=$agent['name']?></p>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Email</label>
                                            <div class="col-sm-9">
                                                <p class="font-weight-bold"><?=$agent['email']?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" name="submit" class="btn btn-success btn-lg btn-block" id="submit">Send Booking Request To Agent</button>
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