
<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_agent.php') ?>
<?php
    $result = $db->query("SELECT * FROM projects");

    $project_count = $result->num_rows;
?>
<?php include('layout/head.php'); ?>

<body main-theme-layout="main-theme-layout-1">

<div class="page-wrapper">
    <?php include('layout/top-bar.php') ?>
    <div class="page-body-wrapper">
        <?php include('layout/side-bar.php'); ?>

        <div class="page-body">
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col">
                            <div class="page-header-left">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Project</li>
                                </ol>
                            </div>
                        </div>
                        <div class="col">
                            <div class="bookmark pull-right">
                                <ul>
                                    <li><a href="project-create.php" class="btn btn-info text-white"><i class="fa fa-plus mr-1"></i> Create</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid product-wrapper">
                <div class="product-grid">
                    <div class="feature-products">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <form method="get">
                                    <div class="form-group m-0">
                                        <input class="form-control" name="search" type="search" placeholder="Search.." value="<?= (isset($_GET['search']))? $_GET['search'] : "" ?>"><i class="fa fa-search"></i>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="product-wrapper-grid">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-center">Showing Project 1 - <?= $project_count ?> Results</p>
                            </div>
                        </div>
                        <div class="row">
                            <?php while($project = $result->fetch_assoc()){ ;?>
                                <?php
                                $q_project_brochures = $db->query("SELECT * FROM project_brochures WHERE project_id=$project[id]");
                                $project_brochures = $q_project_brochures->fetch_assoc();

                                $image = "https://via.placeholder.com/150";
                                if($project_brochures){
                                    $image = $project_brochures['file_location'];
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

                                ?>

                                <div class="col-xl-3 col-sm-6 xl-4">
                                <div class="card">
                                    <div class="product-box">
                                        <div class="product-img"><img class="img-fluid" src="<?= $image ?>" alt="">
                                            <div class="product-hover">
                                                <ul>
                                                    <li>
                                                        <button class="btn" type="button" data-toggle="modal" data-target="#exampleModalCenter23"><i class="icon-eye"></i></button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="exampleModalCenter23" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter23" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <div class="product-box row">
                                                            <div class="product-img col-md-6"><img class="img-fluid" src="<?= $image ?>" alt=""></div>
                                                            <div class="product-details col-md-6 text-left">
                                                                <h4><?= $project['name'] ?></h4>
                                                                <div class="product-price">

                                                                    <small>(<?= displayPrice($min_price) ?> - <?= displayPrice($max_price) ?>)</small>
                                                                </div>
                                                                <div class="">
                                                                    <h6>Project Duration : <?= $project['start']. " to ". $project['end']; ?></h6>
                                                                    <h6>Project Location : <?= $project['location_name'] ?></h6>
                                                                    <h6>Total Unit Offered : <?= $ttl_total_house ?></h6>
                                                                    <h6>Available Unit : <?= $ttl_available_house ?></h6>
                                                                </div>
                                                                <a href="project-view.php?id=<?= $project['id'] ?>" class="btn btn-primary" type="button">View Unit</a>

                                                            </div>
                                                        </div>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×                                                                                                                        </span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-details">
                                            <h4><?= $project['name'] ?></h4>
                                            <p><?= $project['location_name'] ?></p>
                                            <div class="product-price">
                                                <h6><?=$ttl_available_house ?> Available Unit(s)<br>
                                                    <small>(<?= displayPrice($min_price) ?> - <?= displayPrice($max_price) ?>)</small>
                                                </h6>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('layout/footer.php'); ?>
    </div>
</div>
</body>
<?php include('layout/script.php'); ?>
</html>