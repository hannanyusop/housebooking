
<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_agent.php') ?>
<?php include('layout/head.php'); ?>
<?php
if(isset($_GET['id'])){
    $project_id = $_GET['id'];

    $project_q = $db->query("SELECT * FROM projects WHERE id=$project_id");
    $project = $project_q->fetch_assoc();

    $houses = $db->query("SELECT * FROM houses where project_id = $project_id");

    $brochures = $db->query("SELECT * FROM project_brochures where project_id = $project_id");

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
<body main-theme-layout="main-theme-layout-1">

<!-- Loader ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper">
    <?php include('layout/top-bar.php') ?>
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
                                    <li class="breadcrumb-item"><a href="project-index.php">Project</a> </li>
                                    <li class="breadcrumb-item"><?=$project['name']?></li>
                                </ol>
                            </div>
                        </div>
                        <div class="col">
                            <div class="bookmark pull-right">
                                <ul>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="card">
                    <div class="row product-page-main">
                        <div class="col-xl-4">
                            <div class="product-slider owl-carousel owl-theme" id="sync1">
                                <?php while($brochure = $brochures->fetch_assoc()){ ;?>
                                    <div class="item"><img src="<?= $brochure['file_location'] ?>" alt=""></div>
                                <?php } ?>
                            </div>
                            <div class="owl-carousel owl-theme" id="sync2">
                                <?php while($b2 = $brochures->fetch_assoc()){ ;?>
                                    <div class="item"><img src="<?= $b2['file_location'] ?>" alt=""></div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-xl-8">
                            <div class="product-page-details">
                                <h5><?= $project['name'] ?></h5>
                                <div class="d-flex">
                                    <span>(250 review)</span>
                                </div>
                            </div>
                            <hr>
                            <div class="product-price digits">
                                <small>(<?= displayPrice($min_price) ?> - <?= displayPrice($max_price) ?>)</small>
                            </div>
                            <hr>
                            <div>
                                <table class="product-page-width">
                                    <tbody>
                                    <tr>
                                        <td>Project Duration :</td>
                                        <td><?= $project['start']. " to ". $project['end']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Project Location :</td>
                                        <td class="in-stock"><?= $project['location_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Unit Offered :</td>
                                        <td class="in-stock"><?= $ttl_total_house ?></td>
                                    </tr>
                                    <tr>
                                        <td>Available Unit :</td>
                                        <td class="in-stock"><?= $ttl_available_house ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-3 xl-40">
                        <div class="default-according style-1 faq-accordion job-accordion" id="accordionoc">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link pl-0" data-toggle="collapse" data-target="#collapseicon" aria-expanded="true" aria-controls="collapseicon">Filter</button>
                                            </h5>
                                        </div>
                                        <div class="collapse show" id="collapseicon" aria-labelledby="collapseicon" data-parent="#accordion">
                                            <div class="card-body filter-cards-view animate-chk">
                                                <div class="job-filter">
                                                    <div class="faq-form">
                                                        <input class="form-control" type="text" placeholder="Search.."><i class="search-icon" data-feather="search"></i>
                                                    </div>
                                                </div>
                                                <div class="job-filter">
                                                    <div class="faq-form">
                                                        <input class="form-control" type="text" placeholder="location.."><i class="search-icon" data-feather="map-pin"></i>
                                                    </div>
                                                </div>
                                                <div class="checkbox-animated">
                                                    <label class="d-block" for="chk-ani5">
                                                        <input class="checkbox_animated" id="chk-ani5" type="checkbox">Commission (25)
                                                    </label>
                                                </div>
                                                <button class="btn btn-primary text-center" type="button">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9 xl-60">
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
                                                Type : <?=getHouseType($house['type']) ?><br>
                                                Price : <?= displayPrice($house['price'])?><br>
                                                Point Reward : <?= $house['point'] ?>
                                            </div>

                                            <div class="mt-4 text-center">
                                                <?php if(is_null($house['current_booking_id'])){ ?>
                                                    <a href="" class="btn btn-success">Add To Booking List</a>
                                                <?php }else{ ?>
                                                    <a href="" class="btn btn-info">Review Booking</a>
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
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination pagination-primary">
                                            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                        </ul>
                                    </nav>
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

<?php include('layout/script.php'); ?>
<!-- Mirrored from laravel.pixelstrap.com/endless/sample-page by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 03 Nov 2020 07:18:47 GMT -->
</html>