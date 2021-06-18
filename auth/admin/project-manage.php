
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

        if(isset($_GET['delete_house'])){

            $brochure_q = $db->query("SELECT * FROM houses WHERE id='$_GET[delete_house]'");
            $brochure = $brochure_q->fetch_assoc();

            if(!$brochure){
                echo "<script>alert('House not exist!');window.location='project-manage.php?id=$project_id'</script>";
            }

            if (!$db->query("DELETE FROM houses WHERE id=$_GET[delete_house]")) {
                echo "Error: ". $db->error; exit();
            }else{
                echo "<script>alert('House successfully deleted!');window.location='project-manage.php?id=$project_id'</script>";
            }
        }


    }else{
        echo "<script>alert('Error : missing parameter!');window.location='project-index.php'</script>";
    }
?>
<?php include('layout/head.php'); ?>

<body main-theme-layout="main-theme-layout-1">

>
<div class="page-wrapper">
    <?php include('layout/top-bar.php') ?>
    <div class="page-body-wrapper">

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
                                    <li class="breadcrumb-item active"><a href="project-index.php">Project Management</a></li>
                                    <li class="breadcrumb-item">Manage</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="project-house-create.php?id=<?= $project_id ?>" class="btn btn-info btn-sm float-right">Insert New House</a>
                                <div class="table-responsive product-table">
                                    <table class="display table-sm" id="datatable">
                                        <thead>
                                        <tr class="text-center">
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Price</th>
                                            <th>Booking Status</th>
                                            <th>Action</th>
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
                                                <td>
                                                    <a href="project-house-edit.php?house_id=<?= $house['id']; ?>" class="btn btn-primary btn-xs">Edit</a>
                                                    <a href="house-insert-image.php?id=<?= $house['id']; ?>" class="btn btn-success btn-xs">Manage Brochure</a>
                                                    <?php if($house['current_booking_id'] == NULL){ ?>
                                                        <a href="project-manage.php?id=<?=$project_id?>&delete_house=<?=$house['id']?>" onclick="return confirm('Are you sure want to delete this house?')" class="btn btn-danger btn-xs" >Delete</a>
                                                    <?php } ?>
                                                </td>
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
        <?php include('layout/footer.php'); ?>
    </div>
</div>

</body>

<?php include('layout/script.php'); ?>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script>
    const inputElement = document.querySelector('#image');
    const pond = FilePond.create(inputElement);
</script>
</html>