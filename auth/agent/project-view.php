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
<!--                        <div class="col-xl-3 xl-40">-->
<!--                            <div class="card">-->
<!--                                <div class="card-body">-->
<!--                                    <div class="form-group">-->
<!--                                        <label>Text</label>-->
<!--                                        <input type="text" class="form-control" autocomplete="off">-->
<!--                                    </div>-->
<!--                                    <div class="form-group">-->
<!--                                        <label class="d-block">Status</label>-->
<!--                                        <div class="form-check">-->
<!--                                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" checked="">-->
<!--                                            <label class="form-check-label" for="exampleRadios1">-->
<!--                                                Radio 1-->
<!--                                            </label>-->
<!--                                        </div>-->
<!--                                        <div class="form-check">-->
<!--                                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" checked="">-->
<!--                                            <label class="form-check-label" for="exampleRadios2">-->
<!--                                                Radio 2-->
<!--                                            </label>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="form-group">-->
<!--                                        <label>Price</label>-->
<!--                                        <input type="range" class="form-control">-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="card-footer text-right">-->
<!--                                    <button class="btn btn-primary mr-1" type="submit">Submit</button>-->
<!--                                    <button class="btn btn-secondary" type="reset">Reset</button>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
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
<!--                                    <nav aria-label="Page navigation example">-->
<!--                                        <ul class="pagination pagination-primary">-->
<!--                                            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>-->
<!--                                            <li class="page-item active"><a class="page-link" href="#">1</a></li>-->
<!--                                            <li class="page-item"><a class="page-link" href="#">2</a></li>-->
<!--                                            <li class="page-item"><a class="page-link" href="#">3</a></li>-->
<!--                                            <li class="page-item"><a class="page-link" href="#">Next</a></li>-->
<!--                                        </ul>-->
<!--                                    </nav>-->
                                </div>
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