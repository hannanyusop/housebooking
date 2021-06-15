<!DOCTYPE html>

<?php include('include/header.php'); ?>
<body>
<?php include('include/topbar.php')?>
<?php

if(isset($_GET['id'])){
    $house_id = $_GET['id'];
    $house_q = $db->query("SELECT * FROM houses WHERE id=$house_id");
    $house = $house_q->fetch_assoc();

    if(!$house){
        echo "<script>alert('Invalid house!');window.location='index.php'</script>";
    }

    #get random agent by using mysql function 'RAND()'
    $agent_q = $db->query("SELECT * FROM agents ORDER BY RAND() LIMIT 1");
    $agent = $agent_q->fetch_assoc();

}else{
    header('Location:index.php');
}
?>


<!-- End page header -->
<!-- property area -->
<div class="content-area single-property" style="background-color: #FCFCFC;">
    <div class="container">

        <div class="clearfix padding-top-40" >

            <div class="col-md-8 single-property-content prp-style-2">
                <div class="">
                    <div class="row">
                        <div class="light-slide-item">
                            <div class="clearfix">
                                <div class="favorite-and-print">
                                    <a class="printer-icon " href="javascript:window.print()">
                                        <i class="fa fa-print"></i>
                                    </a>
                                </div>

                                <ul id="image-gallery" class="gallery list-unstyled cS-hidden">
                                    <li data-thumb="garo/assets/img/property-1/property1.jpg">
                                        <img src="garo/assets/img/property-1/property1.jpg" />
                                    </li>
                                    <li data-thumb="garo/assets/img/property-1/property2.jpg">
                                        <img src="garo/assets/img/property-1/property3.jpg" />
                                    </li>
                                    <li data-thumb="garo/assets/img/property-1/property3.jpg">
                                        <img src="garo/assets/img/property-1/property3.jpg" />
                                    </li>
                                    <li data-thumb="garo/assets/img/property-1/property4.jpg">
                                        <img src="garo/assets/img/property-1/property4.jpg" />
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="single-property-wrapper">

                        <div class="section">
                            <h4 class="s-property-title">Description</h4>
                            <div class="s-property-content">
                                <?= $house['description']?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 p0">
                <aside class="sidebar sidebar-property blog-asside-right property-style2">
                    <div class="dealer-widget">
                        <div class="dealer-content">
                            <div class="inner-wrapper">
                                <div class="single-property-header">
                                    <h1 class="property-title"><?= $house['name'] ?></h1>
                                    <span class="property-price"><?= displayPrice($house['price']) ?></span>
                                </div>

                                <div class="property-meta entry-meta clearfix ">

                                    <div class="col-xs-4 col-sm-4 col-md-4 p-b-15">
                                                <span class="property-info-icon icon-tag">
                                                    <img src="garo/assets/img/icon/sale-orange.png">
                                                </span>
                                        <span class="property-info-entry">
                                                    <span class="property-info-label">Status</span>
                                                    <span class="property-info-value">For Sale</span>
                                                </span>
                                    </div>

                                    <div class="col-xs-4 col-sm-4 col-md-4 p-b-15">
                                                <span class="property-info icon-area">
                                                    <img src="garo/assets/img/icon/room-orange.png">
                                                </span>
                                        <span class="property-info-entry">
                                                    <span class="property-info-label">Area</span>
                                                    <span class="property-info-value"><?= $house['sqft']?><b class="property-info-unit">Sq Ft</b></span>
                                                </span>
                                    </div>

                                    <div class="col-xs-4 col-sm-4 col-md-4 p-b-15">
                                                <span class="property-info-icon icon-bed">
                                                    <img src="garo/assets/img/icon/bed-orange.png">
                                                </span>
                                        <span class="property-info-entry">
                                                    <span class="property-info-label">Bedrooms</span>
                                                    <span class="property-info-value"><?= $house['room']?></span>
                                                </span>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-4 p-b-15">
                                                <span class="property-info-icon icon-garage">
                                                    <img src="garo/assets/img/icon/shawer-orange.png">
                                                </span>
                                        <span class="property-info-entry">
                                                    <span class="property-info-label">Bathrooms</span>
                                                    <span class="property-info-value"><?= $house['bath_room']?></span>
                                                </span>
                                    </div>

                                    <div class="col-xs-4 col-sm-4 col-md-4 p-b-15">
                                                <span class="property-info-icon icon-garage">
                                                    <img src="garo/assets/img/icon/cars-orange.png">
                                                </span>
                                        <span class="property-info-entry">
                                                    <span class="property-info-label">Garages</span>
                                                    <span class="property-info-value"><?= $house['garage']?></span>
                                                </span>
                                    </div>




                                </div>
                                <div class="dealer-section-space">
                                    <span>Dealer information</span>
                                </div>
                                <div class="clear">
                                    <div class="col-xs-4 col-sm-4 dealer-face">
                                        <a href="">
                                            <img src="<?= $agent['image'] ?>" class="img-circle">
                                        </a>
                                    </div>
                                    <div class="col-xs-8 col-sm-8 ">
                                        <h3 class="dealer-name">
                                            <a href=""><?= $agent['name'] ?></a><br>
                                            <span>Real Estate Agent</span>
                                        </h3>
                                    </div>
                                </div>

                                <div class="clear">
                                    <ul class="dealer-contacts">
                                        <li><i class="pe-7s-map-marker strong"> </i><?= $agent['address'] ?></li>
                                        <li><i class="pe-7s-mail strong"> </i> <?= $agent['email'] ?></li>
                                        <li><i class="pe-7s-call strong"> </i> <?= $agent['point'] ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="book.php?id=<?=$house_id?>&agent=<?=$agent['id']?>" class="btn btn-primary btn-block">Book Now</a>
                </aside>
            </div>

        </div>

    </div>
</div>


<?php include('include/footer.php'); ?>
</body>
</html>