
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

    }else{
        echo "<script>alert('Error : missing parameter!');window.location='project-index.php'</script>";
    }
?>
<?php include('layout/head.php'); ?>

<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<body main-theme-layout="main-theme-layout-1">

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
                                    <li class="breadcrumb-item">House</li>
                                    <li class="breadcrumb-item">Insert</li>
                                </ol>
                            </div>
                        </div>
                        <div class="col">

                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <a href="project-manage.php?id=<?=$project_id?>" class="btn btn-dark text-white"><i class="fa fa-caret-left mr-1"></i> Back</a>
                </div>
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="font-weight-bold">Add House</h5>
                                <form class="theme-form" method="post" action="project-insert-house.php?id=<?= $project_id?>" enctype="multipart/form-data">
                                    <input class="form-control" id="add_house" name="add_house" type="hidden" value="true">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="name">Name</label>
                                        <input class="form-control" id="name" name="name" type="text" required>
                                        <small class="form-text text-muted" id="nameHelp"></small>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="description">Description</label>
                                        <textarea class="form-control" name="description" rows="5" id="description" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="type">Type</label>
                                        <select name="type" id="type" class="form-control" required>
                                            <?php foreach (getHouseType() as $key => $type){ ?>
                                                <option value="<?= $key ?>"><?= $type ?></option>
                                            <?php } ?>
                                        </select>
                                        <small class="form-text text-muted" id="nameHelp"></small>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="price">Price</label>
                                        <input class="form-control" id="price" name="price" type="text" value="0.00" step="0.01" required>
                                        <small class="form-text text-muted" id="helpPrice"></small>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="sqft">Area (Sq ft)</label>
                                        <input class="form-control" id="sqft" name="sqft" type="number" value="1" min="1" step="1" required>
                                        <small class="form-text text-muted" id="sqft"></small>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="room">Total Room</label>
                                        <input class="form-control" id="room" name="room" type="number" value="1" min="0" step="1" required>
                                        <small class="form-text text-muted" id="room"></small>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="bath_room">Total Bath Room</label>
                                        <input class="form-control" id="bath_room" name="bath_room" type="number" value="1" min="0" step="1" required>
                                        <small class="form-text text-muted" id="room"></small>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="garage">Total Garage</label>
                                        <input class="form-control" id="garage" name="garage" type="number" value="1" min="0" step="1" required>
                                        <small class="form-text text-muted" id="garage"></small>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="point">Point</label>
                                        <input class="form-control" id="price" name="point" type="text" value="0" required>
                                        <small class="form-text text-muted" id="helpPoint"></small>
                                    </div>

<!--                                    <div class="form-group">-->
<!--                                        <label for="file">Images</label>-->
<!--                                        <input type="file" name="image[]" multiple>-->
<!--                                    </div>-->

                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit">Add</button>
                                    </div>
                                </form>
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
    const inputElement = document.querySelector('input[type=file]');
    const pond = FilePond.create(inputElement);
</script>
</html>