<!DOCTYPE html>
<?php include('include/header.php'); ?>
<body>
<?php include('include/topbar.php')?>
<?php

$name = ''; $type = [];
$in_type = '';
if(isset($_GET['name'])){

    $name = $_GET['name'];
    $in_type = $location = "";

    if(isset($_GET['type']) && $_GET['type'] != ""){
        $type = $_GET['type'];
        $in_type = "AND type=$type";

//        $in_type = "AND type IN(".implode(",",$type).")";

    }

    if(isset($_GET['location']) && $_GET['location'] != ""){
        $location = $_GET['location'];
        $location = "AND state='$location'";

//        $in_type = "AND type IN(".implode(",",$type).")";

    }
    $houses_q = $db->query("SELECT *,h.id house_id,h.name as house_name,h.type house_type FROM houses h LEFT JOIN projects p ON p.id=h.project_id WHERE h.name LIKE '%$name%' $in_type AND current_booking_id IS NULL $location");

}else{
    $houses_q = $db->query("SELECT *,h.id house_id,h.name as house_name,h.type house_type FROM houses h LEFT JOIN projects p ON p.id=h.project_id WHERE current_booking_id IS NULL");
}
?>


<div class="slider-area">
    <div class="slider">
        <div id="bg-slider" class="owl-carousel owl-theme">
            <div class="item"><img src="garo/assets/img/slide1/slider-image-4.jpg" alt="GTA V"></div>
        </div>
    </div>
    <div class="container slider-content">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12">
                <h2>property Searching Just Got So Easy</h2>
                <div class="search-form wow pulse" data-wow-delay="0.8s">

                    <form class=" form-inline">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Key word" value="<?= $_GET['name'] ?? '' ?>">
                        </div>
                        <div class="form-group">
                            <select id="type" name="type" class="selectpicker" data-live-search="true" data-live-search-style="begins" title="Select House Type">
                                <option value="">All</option>
                                <?php foreach (getHouseType() as $key => $name_type){ ?>
                                    <option value="<?= $key?>" <?= (isset($_GET['type']) == $key)? "selected" : "" ?>><?= $name_type ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <select id="location" name="location" class="selectpicker" data-live-search="true" data-live-search-style="begins" title="Select Location">
                                <option value="">All</option>
                                <?php foreach (stateList() as $state){ ?>
                                    <option value="<?=$state?>" <?= (isset($_GET['location']) == $state)? "selected" : "" ?>><?= $state ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <button class="btn search-btn" type="submit"><i class="fa fa-search"></i></button>
                        <a class="text" href="index.php">Reset</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- property area -->
<div class="content-area recent-property" style="padding-bottom: 60px; background-color: rgb(252, 252, 252);">
    <div class="container">
        <div class="row">
            <div class="col-md-12  padding-top-40 properties-page">
                <div class="col-md-12 ">
                    <div class="col-xs-10 page-subheader sorting pl0">
                    </div>

                    <div class="col-xs-2 layout-switcher">
                        <a class="layout-list" href="javascript:void(0);"> <i class="fa fa-th-list"></i>  </a>
                        <a class="layout-grid active" href="javascript:void(0);"> <i class="fa fa-th"></i> </a>
                    </div><!--/ .layout-switcher-->
                </div>

                <div class="col-md-12 ">
                    <div id="list-type" class="proerty-th">

                        <?php while($house = $houses_q->fetch_assoc()){ ;?>
                            <?php
                                $brochure_q = $db->query("SELECT * FROM house_images WHERE house_id=$house[house_id] LIMIT 1");
                                $brochure = $brochure_q->fetch_assoc();

                                $project_q = $db->query("SELECT * FROM projects WHERE id='$house[house_id]'");
                                $project   = $project_q->fetch_assoc();

                                $image = 'garo/assets/img/demo/property-3.jpg';
                                if($brochure){
                                    $image = $brochure['url'];
                                }

                            ?>
                        <div class="col-sm-6 col-md-3 p0">
                            <div class="box-two proerty-item">
                                <div class="item-thumb">
                                    <a href="view.php?id=<?= $house['house_id'] ?>" ><img src="<?= $image ?>" alt=""></a>
                                </div>

                                <div class="item-entry overflow">
                                    <h5>
                                        <a href="view.php?id=<?= $house['house_id'] ?>"><?= $house['name'] ?></a><br>
                                        <small><?= getHouseType($house['house_type']) ?></small>
                                    </h5>
                                    <div class="dot-hr"></div>
                                    <span class="pull-left"><b> Area :</b> <?= $house['sqft'] ?> sqft</span>
                                    <span class="proerty-price pull-right"> <?= displayPrice( $house['price'] )?></span>
                                    <div class="property-icon">
                                        <span class="font-weight-bold"><i class="fa fa-bed"></i> <?= $house['room'] ?></span>
                                        <span><i class="fa fa-home"></i> <?= $house['bath_room'] ?></span>
                                        <span><i class="fa fa-car"></i> <?= $house['garage'] ?></span>
                                    </div>

                                    <small>State : <?= $house['state'] ??  "" ?></small>
                                </div>


                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Footer area-->
<?php include('include/footer.php'); ?>
</body>
</html>