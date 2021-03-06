<!DOCTYPE html>
<html lang="en">
<?php include_once('../permission_agent.php') ?>
<?php
if(isset($_GET['house_id'])){
    $house_id = $_GET['house_id'];

    $house_q = $db->query("SELECT * FROM houses WHERE id=$house_id");
    $house = $house_q->fetch_assoc();

    $project_q = $db->query("SELECT * FROM projects WHERE id='$house[project_id]'");
    $project = $project_q->fetch_assoc();

    if(!$house){
        echo "<script>alert('House not exist!');window.location='project-index.php'</script>";
    }

    $customers = $db->query("SELECT * FROM customers");

    if(isset($_POST['customer_id'])){

        $code = rand(11111,99999);

        $customer_q = $db->query("SELECT * FROM customers WHERE id='$_POST[customer_id]'");
        $customer = $customer_q->fetch_assoc();

        $booking = "INSERT INTO bookings (house_id,agent_id,customer_id,status,code,point_gain, remark, created_at) VALUES ('$house[id]', $user_id, '$_POST[customer_id]', 0, '$code', 0, '$_POST[remark]', NOW())";
        if (!$db->query($booking)) {
            echo "Error: " . $booking . "<br>" . $db->error; exit();
        }else{

            $body = "Hye $customer[name],<br><br>
            <p>Please use this code to approve project</p>
            <p>CODE: $code</p>
            <p>PROJECT : $project[name]</p>
            <p>LOT : $house[name]</p>

            <br><br>
            <small>
                <i>This email was generated automatically by system. Don't reply this email
                    <br>For inquiry please call our Customer Service 06-425635654543</i>
            </small>";

            sendEmail($customer['email'], "BOOKING CODE", $body);
            $last_id = $db->insert_id;

            #set current booking id to this house to prevent from duplicate booking
            $db->query("UPDATE houses SET current_booking_id=$last_id WHERE id=$house[id]");

            echo "<script>alert('New project successfully created!');window.location='booking-view.php?id=".$last_id."'</script>";
        }
    }

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
                    <h5>Create Booking Request</h5>
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
                                        <div class="form-group row">
                                            <label for="customer_id" class="col-sm-3 col-form-label">Customer</label>
                                            <div class="col-sm-9">
                                                <div class="input-group mb-3">
                                                    <select class="form-control" id="customer_id" name="customer_id">
                                                        <option value="null">-- Select Customer --</option>
                                                        <?php while($customer = $customers->fetch_assoc()){ ;?>
                                                            <option value="<?=$customer['id']?>">
                                                                <?=$customer['name']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="button" onclick="getDetail()">Get Details</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="alert alert-danger throw_danger"></div>
                                        </div>
                                        <div id="customer-details">
                                            <div class="form-group row">
                                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                                <div class="col-sm-9">
                                                    <p class="font-weight-bold" id="email">nan_s96@yahoo.com</p>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="phone_number" class="col-sm-3 col-form-label">Phone Number</label>
                                                <div class="col-sm-9">
                                                    <p class="font-weight-bold" id="phone_number">0105960586</p>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="remark" class="col-sm-3 col-form-label">Remark</label>
                                                <div class="col-sm-9">
                                                    <textarea rows="5" class="form-control" name="remark"><?= (isset($_POST['remark']))?$_POST['remark'] : "" ?> </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-success btn-lg btn-block" id="submit">Send Booking Request To Customer</button>
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
<script type="text/javascript">

    submit = $("#submit");
    customer_details = $("#customer-details");
    customer_id = $("#customer_id");
    email = $("#email");
    phone_number = $("#phone_number");
    throw_danger = $(".throw_danger").hide();

    $(function (){
        start();
    });

    function start(){
        customer_details.hide();
        submit.hide();
    }

    function getDetail(){


        var postForm = {
            'customer_id'     : customer_id.val()
        };

        $.ajax({
            url: "ajax-search-employee-detail.php",
            type: "post",
            data      : postForm,
            dataType  : 'json',
            success   : function(data) {
                console.log(data);
                if (!data.success) {
                    start();
                    throw_danger.text(data.message).show();
                }
                else {

                    throw_danger.hide();
                    customer_details.show();
                    submit.show();
                    email.text(data.details.email);
                    phone_number.text(data.details.phone_number);
                }
            }
        })
    }
</script>
</body>
</html>