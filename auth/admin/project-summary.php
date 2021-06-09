
<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_admin.php') ?>
<?php
    if(isset($_GET['id'])){
        $project_id = $_GET['id'];

        $project_q = $db->query("SELECT * FROM projects WHERE id=$project_id");
        $project = $project_q->fetch_assoc();

        if(!$project){
            echo "<script>alert('Project not exist!');window.location='project-index.php'</script>";
        }

        $houses = $db->query("SELECT * FROM houses where project_id = $project_id");

        $brochures = $db->query("SELECT * FROM project_brochures where project_id = $project_id");

       $first_brochure = $brochures->fetch_row();

       $cover = '../../../assets/images/empty.png';

       if($first_brochure){

       }

        $total_q = $db->query("SELECT * FROM houses WHERE project_id='$project_id'");
        $total = $total_q->num_rows;
        $available_q = $db->query("SELECT * FROM houses WHERE current_booking_id IS NULL AND project_id='$project_id'");
        $available = $available_q->num_rows;


    }else{
        echo "<script>alert('Error : missing parameter!');window.location='project-index.php'</script>";
    }
?>
<?= include('layout/head.php'); ?>

<body main-theme-layout="main-theme-layout-1">

<style type="text/css">
    .user-profile .hovercard .cardheader {
        background: url(<?= $cover ?>);
        background-size: cover;
        background-position: 10%;
        height: 470px;
    }
</style>

<!-- Loader ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper">
    <?= include('layout/top-bar.php') ?>
    <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <?= include('layout/side-bar.php'); ?>

        <div class="page-body">
            <!-- breadcrumb  Start -->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col">
                            <div class="page-header-left">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item active"><a href="index.php">Project Management</a></li>
                                    <li class="breadcrumb-item">Summary</li>
                                </ol>
                            </div>
                        </div>
                        <div class="col">
                            <div class="bookmark pull-right">
                                <ul>
                                    <li><a href="user-admin-create.php" class="btn btn-info text-white"><i class="fa fa-plus mr-1"></i> Create</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">

                <div class="row">
                    <div class="col-xl-4 xl-50 col-sm-6">
                        <div class="card bg-success">
                            <div class="card-body">
                                <div class="media faq-widgets">
                                    <div class="media-body">
                                        <h5>Booked</h5>
                                        <h1><?= $total-$available ?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 xl-50 col-sm-6">
                        <div class="card bg-warning">
                            <div class="card-body">
                                <div class="media faq-widgets">
                                    <div class="media-body">
                                        <h5>Available</h5>
                                        <h1><?= $available ?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 xl-50 col-sm-6">
                        <div class="card bg-info">
                            <div class="card-body">
                                <div class="media faq-widgets">
                                    <div class="media-body">
                                        <h5>Total Houses</h5>
                                        <h1><?= $total ?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="my-gallery card-body row" itemscope="" data-pswp-uid="1">

                                    <?php while($brochure = $brochures->fetch_assoc()){ ;?>
                                        <figure class="col-xl-3 col-md-4 col-6" itemprop="associatedMedia" itemscope="">
                                            <a href="<?= $brochure['file_location'] ?>" itemprop="contentUrl" data-size="1600x950" data-original-title="" title="">
                                                <img class="img-thumbnail" src="<?= $brochure['file_location'] ?>" itemprop="thumbnail" alt="Image description" data-original-title="" title="">
                                            </a>
                                            <p><?= $brochure['title'] ?></p>
                                        </figure>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive product-table">
                                            <table class="display table-sm" id="datatable">
                                                <thead>
                                                <tr class="text-center">
                                                    <th>Id</th>
                                                    <th>Name</th>
                                                    <th>Type</th>
                                                    <th>Price</th>
                                                    <th>Booking Status</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php while($house = $houses->fetch_assoc()){ ;?>
                                                    <tr>
                                                        <td><?= $house['id']; ?></td>
                                                        <td><?= strLimit($house['name'], 20); ?></td>
                                                        <td><?= strLimit(getHouseType($house['type']), 20); ?></td>
                                                        <td><?= displayPrice($house['price']); ?></td>
                                                        <td class="text-center"><?= (is_null($house['current_booking_id'])) ? " - " : "Booked" ?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
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