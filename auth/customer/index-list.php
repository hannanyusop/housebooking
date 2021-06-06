<!DOCTYPE html>
<html lang="en">
<?php include_once('../permission_customer.php') ?>
<?php include('layout/head.php'); ?>
<?php
if(isset($_GET['id'])){
    $project_id = $_GET['id'];

    $project_q = $db->query("SELECT * FROM projects WHERE id=$project_id");
    $project = $project_q->fetch_assoc();

    $name = ''; $type = [];
    $in_type = '';
    if(isset($_POST['name'])){

        $name = $_POST['name'];

        if(isset($_POST['type'])){
            $type = $_POST['type'];
            $in_type = "AND type IN(".implode(",",$type).")";;
        }

//        AND type IN ($in_type)
        $houses = $db->query("SELECT * FROM houses where project_id = $project_id AND name like '%$name%' $in_type");
    }else{
        $houses = $db->query("SELECT * FROM houses where project_id = $project_id");
    }



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
    echo "<script>alert('Error : missing parameter!');window.location='index.php'</script>";
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
                    <h1><?= $project['name'] ?></h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="index.php">Dashboard</a></div>
                        <div class="breadcrumb-item">Project List</div>
                        <div class="breadcrumb-item"><?= $project['name'] ?></div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="section-body">
                        <div class="row">
                            <div class="col-xl-3 xl-40">
                                <form class="card" method="post" action="index-list.php?id=<?= $project_id ?>">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <input name="name" value="<?=$name ?>"  type="text" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label class="d-block">Type</label>

                                            <?php foreach (getHouseType() as $key => $name_type){ ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="type[]" value="<?=$key?>" id="type_<?= $key?>" <?= (in_array($key, $type))? "checked" : "" ?>>
                                                <label class="form-check-label" for="type_<?= $key?>"><?= $name_type ?></label>
                                            </div>
                                            <?php } ?>
                                        </div>
<!--                                        <div class="form-group">-->
<!--                                            <label for="price">Price</label>-->
<!--                                            <input type="range" id="price" name="price" class="form-control"  value="800" min="0" max="1000">-->
<!--                                        </div>-->
                                    </div>
                                    <div class="card-footer text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                        <a href="index-list.php?id=<?= $project_id?>" class="btn btn-secondary" type="reset">Reset</a>
                                    </div>
                                </form>
                            </div>
                            <div class="col-xl-9 xl-60">
                                <div class="row">
                                    <?php if ($houses->num_rows > 0){ ?>
                                    <?php while($house = $houses->fetch_assoc()){ ;?>
                                        <div class="col-12 col-md-4 col-lg-4" >
                                            <div class="pricing">
                                                <div class="pricing-title">
                                                    <?php if(is_null($house['current_booking_id'])){ ?>
                                                        <span class="badge badge-success pull-right">Available</span>
                                                    <?php }else{ ?>
                                                        <span class="badge badge-dark pull-right">Booked</span>
                                                    <?php } ?>
                                                </div>
                                                <div class="pricing-padding">
                                                    <div class="pricing-price">
                                                        <div><?= $house['name'] ?></div>
                                                        <div><?= displayPrice($house['price'])?></div>
                                                    </div>
                                                    <div class="pricing-details">
                                                        <div class="pricing-item">
                                                            <div class="pricing-item-icon"><i class="fas fa-home"></i></div>
                                                            <div class="pricing-item-label"> Type : <?= getHouseType($house['type'])?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php  }
                                    } ?>
                                </div>

<!--                                <div class="col-sm-12">-->
<!--                                    <div class="job-pagination">-->
<!--                                        <nav aria-label="Page navigation example">-->
<!--                                            <ul class="pagination pagination-primary">-->
<!--                                                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>-->
<!--                                                <li class="page-item active"><a class="page-link" href="#">1</a></li>-->
<!--                                                <li class="page-item"><a class="page-link" href="#">2</a></li>-->
<!--                                                <li class="page-item"><a class="page-link" href="#">3</a></li>-->
<!--                                                <li class="page-item"><a class="page-link" href="#">Next</a></li>-->
<!--                                            </ul>-->
<!--                                        </nav>-->
<!--                                    </div>-->
<!--                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
                </div>
        </div>
        <?php include('layout/footer.php'); ?>
    </div>
</div>

<?php include('layout/script.php'); ?>
</body>
</html>