
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


        if(isset($_POST['add_house'])){

            $insert_house = "INSERT INTO houses (project_id, current_booking_id, name, type, price, point) 
VALUES ($project_id, NULL, '$_POST[name]', '$_POST[type]', '$_POST[price]', '$_POST[point]')";

            if (!$db->query($insert_house)) {
                echo "Error: " . $insert_house . "<br>" . $db->error; exit();
            }else{
                echo "<script>alert('New house successfully created!');window.location='project-manage.php?id=$project_id'</script>";
            }
        }

        if(isset($_POST['edit_house'])){

            $house_id = $_POST['house_id'];

            $house_q = $db->query("SELECT * FROM houses WHERE project_id='$_GET[id]' AND id='$house_id'");
            $house = $house_q->fetch_assoc();

            if(!$house){
                echo "<script>alert('House not exist!');window.location='project-manage.php?id=$project_id'</script>";
            }

            $update_house = "UPDATE houses SET name='$_POST[name]', price='$_POST[price]',type='$_POST[type]',point='$_POST[point]' WHERE project_id='$_GET[id]' AND id='$house_id'";

            if (!$db->query($update_house)) {
                echo "Error: " . $update_house . "<br>" . $db->error; exit();
            }else{
                echo "<script>alert('House successfully udpated!');window.location='project-manage.php?id=$project_id'</script>";
            }

        }


        if(isset($_POST['title'])){

            $target_dir = "../../assets/uploads/";
            $temp = explode(".", $_FILES["file"]["name"]);
            $rename = round(microtime(true)) . '.' . end($temp);
            $file_location = $target_dir.$rename;

            #check if file more than 10MB
            if($_FILES['file']['size'] > 10000000){
                echo "<script>alert('Ops! Exceed file limit.(10MB)');window.location='project-manage.php?id=$project_id';</script>";

                exit();
            }


            try{
                move_uploaded_file($_FILES["file"]["tmp_name"], $file_location);
            }catch (Exception $e){
                var_dump($e);exit();
            }

            $insert_b = "INSERT INTO project_brochures (project_id,title,file_location) VALUES ($project_id, '$_POST[title]', '$file_location')";

            if (!$db->query($insert_b)) {
                echo "Error: " . $insert_b . "<br>" . $db->error; exit();
            }else{
                echo "<script>alert('New brochure successfully added!');window.location='project-manage.php?id=$project_id'</script>";
            }
        }

        if(isset($_GET['delete'])){

            $brochure_q = $db->query("SELECT * FROM project_brochures WHERE id='$_GET[delete]'");
            $brochure = $brochure_q->fetch_assoc();

            if(!$brochure){
                echo "<script>alert('Brochure not exist!');window.location='project-manage.php?id=$project_id'</script>";
            }

            if (!$db->query("DELETE FROM project_brochures WHERE id=$_GET[delete]")) {
                echo "Error: ". $db->error; exit();
            }else{
                unlink($brochure['file_location']);
                echo "<script>alert('Brochure successfully deleted!');window.location='project-manage.php?id=$project_id'</script>";
            }
        }
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
<?= include('layout/head.php'); ?>

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
                                    <li class="breadcrumb-item">Manage</li>
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
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <form class="theme-form" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="title">Title</label>
                                        <input class="form-control" id="title" name="title" required>
                                        <small class="form-text text-muted" id="titleHelp"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="file">File</label>
                                        <input class="form-control" type="file" name="file" id="file" accept="image/*">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info">Add Brochure</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="my-gallery card-body row" itemscope="" data-pswp-uid="1">

                                    <?php while($brochure = $brochures->fetch_assoc()){ ;?>
                                        <figure class="col-xl-3 col-md-4 col-6" itemprop="associatedMedia" itemscope="">
                                            <a href="<?= $brochure['file_location'] ?>" itemprop="contentUrl" data-size="1600x950" data-original-title="" title="">
                                                <img class="img-thumbnail" src="<?= $brochure['file_location'] ?>" itemprop="thumbnail" alt="Image description" data-original-title="" title="">
                                            </a>
                                            <p><?= $brochure['title'] ?></p>
                                            <a href="project-manage.php?id=<?=$project_id?>&delete=<?=$brochure['id']?>" onclick="return confirm('Are you sure want to remove this brochure?')" class="btn btn-danger btn-sm btn-round"><i class="fa fa-trash"></i> </a>
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
                                    <div class="col-md-8">
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
                                                        <td class="text-center"><?= (is_null($house['current_booking_id'])) ? " - " : $house['current_booking_id'] ?></td>
                                                        <td>
                                                            <a href="#" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#house<?= $house['id']; ?>">Edit</a>
                                                            <?php if($house['current_booking_id'] == NULL){ ?>
                                                                <a href="project-manage.php?id=<?=$project_id?>&delete_house=<?=$house['id']?>" onclick="return confirm('Are you sure want to delete this house?')" class="btn btn-danger btn-xs" >Delete</a>
                                                            <?php } ?>
                                                            <div class="modal fade" id="house<?= $house['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="house<?= $house['id']; ?>" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <form method="post">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="house"><?= strLimit($house['name'], 20); ?></h5>
                                                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="theme-form">
                                                                                    <input class="form-control" id="edit_house" name="edit_house" type="hidden" value="true">
                                                                                    <div class="form-group">
                                                                                        <label class="col-form-label pt-0" for="name">Name</label>
                                                                                        <input class="form-control" id="name" name="name" type="text" value="<?=$house['name'] ?>" required>
                                                                                        <input type="hidden" name="house_id" value="<?= $house['id']; ?>">
                                                                                        <small class="form-text text-muted" id="nameHelp"></small>
                                                                                    </div>

                                                                                    <div class="form-group">
                                                                                        <label class="col-form-label pt-0" for="type">Type</label>
                                                                                        <select name="type" id="type" class="form-control" required>
                                                                                            <?php foreach (getHouseType() as $key => $type){ ?>
                                                                                                <option value="<?= $key ?>" <?= ($house['type'] == $key)? "selected" : "" ?>><?= $type ?></option>
                                                                                            <?php } ?>
                                                                                        </select>
                                                                                        <small class="form-text text-muted" id="nameHelp"></small>
                                                                                    </div>

                                                                                    <div class="form-group">
                                                                                        <label class="col-form-label pt-0" for="price">Price</label>
                                                                                        <input class="form-control" id="price" name="price" type="text" value="<?= $house['price'] ?>" required>
                                                                                        <small class="form-text text-muted" id="helpPrice"></small>
                                                                                    </div>

                                                                                    <div class="form-group">
                                                                                        <label class="col-form-label pt-0" for="point">Point</label>
                                                                                        <input class="form-control" id="price" name="point" type="text" value="<?= $house['point'] ?>" required>
                                                                                        <small class="form-text text-muted" id="helpPoint"></small>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button class="btn btn-secondary btn-md" type="button" data-dismiss="modal">Close</button>
                                                                                <button class="btn btn-primary btn-md" type="submit">Save changes</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h5 class="font-weight-bold">Add House</h5>
                                        <form class="theme-form" method="post">
                                            <input class="form-control" id="add_house" name="add_house" type="hidden" value="true">
                                            <div class="form-group">
                                                <label class="col-form-label pt-0" for="name">Name</label>
                                                <input class="form-control" id="name" name="name" type="text" required>
                                                <small class="form-text text-muted" id="nameHelp"></small>
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
                                                <input class="form-control" id="price" name="price" type="text" value="0.00" required>
                                                <small class="form-text text-muted" id="helpPrice"></small>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-form-label pt-0" for="point">Point</label>
                                                <input class="form-control" id="price" name="point" type="text" value="0" required>
                                                <small class="form-text text-muted" id="helpPoint"></small>
                                            </div>

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

<?= include('layout/script.php'); ?>
<!-- Mirrored from laravel.pixelstrap.com/endless/sample-page by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 03 Nov 2020 07:18:47 GMT -->
</html>