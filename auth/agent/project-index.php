<!DOCTYPE html>
<html lang="en">
<?php include_once('../permission_agent.php') ?>
<?php
$result = $db->query("SELECT * FROM projects");

$project_count = $result->num_rows;
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
                    <h1>Project List</h1>
                </div>

                <div class="section-body">
                    <div class="row">
                        <?php while($project = $result->fetch_assoc()){ ;?>
                        <?php
                        $q_project_brochures = $db->query("SELECT * FROM project_brochures WHERE project_id=$project[id]");
                        $project_brochures = $q_project_brochures->fetch_assoc();

                        $brochures = $db->query("SELECT * FROM project_brochures where project_id = $project[id]");

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
                        <div class="col-md-6">
                            <div class="card profile-widget">
                                <div class="profile-widget-description">
                                    <div class="profile-widget-name"><?= $project['name'] ?></div>
                                </div>
                                <div class="profile-widget-header">
                                    <div class="profile-widget-items">
                                        <div class="profile-widget-item">
                                            <div class="profile-widget-item-label">Status</div>
                                            <div class="profile-widget-item-value">
                                                <?= getBadgeProjectStatus($project['status']) ?>
                                            </div>
                                        </div>
                                        <div class="profile-widget-item">
                                            <div class="profile-widget-item-label">Total Unit Offered</div>
                                            <div class="profile-widget-item-value"><?= $ttl_total_house ?></div>
                                        </div>
                                        <div class="profile-widget-item">
                                            <div class="profile-widget-item-label">Available Unit</div>
                                            <div class="profile-widget-item-value"><?= $ttl_available_house ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile-widget-description">
                                    <ul>
                                        <li>Range Price : (<?= displayPrice($min_price) ?> - <?= displayPrice($max_price) ?>)</li>
                                        <li>Project Duration : <?= $project['start']. " to ". $project['end']; ?></li>
                                        <li>Project Location : <?= $project['location_name'] ?></li>
                                    </ul>

                                    <div class="gallery gallery-md">
                                        <?php while($brochure = $brochures->fetch_assoc()){ ;?>
                                            <div class="gallery-item" data-image="<?= $brochure['file_location'] ?>" data-title="<?= $brochure['file_location'] ?>" href="<?= $brochure['file_location'] ?>" title="Image 1" style="background-image: url(&quot;<?= $brochure['file_location'] ?>&quot;);"></div>
                                        <?php } ?>
                                    </div>
                                    <div class="card-footer text-center">
                                        <a href="project-view.php?id=<?= $project['id'] ?>" class="btn btn-primary btn-round">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </section>
        </div>
        <?php include('layout/footer.php'); ?>
    </div>
</div>
<?php include('layout/script.php'); ?>
</body>
</html>