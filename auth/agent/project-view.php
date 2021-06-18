<!DOCTYPE html>
<html lang="en">
<?php include_once('../permission_agent.php') ?>
<?php
if(isset($_GET['id'])){
    $project_id = $_GET['id'];

    $project_q = $db->query("SELECT * FROM projects WHERE id=$project_id");
    $project = $project_q->fetch_assoc();

    $houses = $db->query("SELECT * FROM houses where project_id = $project_id");


    if(!$project){
        echo "<script>alert('Project not exist!');window.location='project-index.php'</script>";
    }

    $q_available_house = $db->query("SELECT * FROM houses WHERE current_booking_id = null AND  project_id=$project[id]");

    $ttl_available_house = $q_available_house->num_rows;

    $q_total_house = $db->query("SELECT * FROM houses WHERE project_id=$project[id]");

    $ttl_total_house = $q_total_house->num_rows;

    $q_max_price = $db->query("SELECT * FROM houses WHERE project_id=$project[id] ORDER BY price DESC");
    $get_max_price = $q_max_price->fetch_assoc();
    $max_price = $min_price = 0;

    if($get_max_price){

        $max_price = $get_max_price['price'];

        $q_min_price = $db->query("SELECT * FROM houses WHERE project_id=$project[id] ORDER BY price ASC");
        $get_min_price = $q_min_price->fetch_assoc();
        $min_price = $get_min_price['price'];
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
                    <h4>Project : <?= $project['name'] ?></h4>
                </div>

                <div class="section-body">
                    <div class="row">
                        <?php if($houses->num_rows == 0){ ?>
                            <span class="alert alert-warning col-md-12">
                                No house found for this project!<br><br>

                                <a href="project-index.php" class="btn btn-dark">Back</a>
                            </span>
                        <?php }else{ ?>
                        <div class="col-xl-12 xl-60">
                            <div class="row">
                                <?php while($house = $houses->fetch_assoc()){ ;?>
                                    <div class="col-xl-6 xl-100">
                                        <div class="card">
                                            <div class="job-search">
                                                <div class="card-body">
                                                    <div class="media-body">
                                                        <h6 class="f-w-600"><a href="#"><?= $house['name'] ?></a>
                                                            <?php if(is_null($house['current_booking_id'])){ ?>
                                                                <span class="badge badge-success pull-right">Available</span>
                                                            <?php }else{ ?>
                                                                <span class="badge badge-dark pull-right">Booked</span>
                                                            <?php } ?>
                                                        </h6>
                                                    </div>
                                                    <div class="m-2">
                                                        Type : <br>
                                                        Price : <?= displayPrice($house['price'])?><br>
                                                        Point Reward : <?= $house['point'] ?>
                                                    </div>

                                                    <p>
                                                        Description :<br>
                                                        <small c class="font-weight-bold"><?= $house['description'] ?></small>
                                                    </p>

                                                    <div class="mt-4 text-center">
                                                        <?php if(is_null($house['current_booking_id'])){ ?>
                                                            <a href="project-booking-create.php?house_id=<?= $house['id'] ?>" class="btn btn-success">Add To Booking List</a>
                                                        <?php }else{ ?>
                                                            <a href="booking-review.php?id=<?=$house['current_booking_id'] ?>" class="btn btn-info">Review Booking</a>
                                                        <?php } ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="col-sm-12">
                                <div class="job-pagination">
                                </div>
                            </div>
                        </div>
                        <?php } ?>
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