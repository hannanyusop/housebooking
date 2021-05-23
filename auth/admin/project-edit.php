
<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_admin.php') ?>
<?php

if(isset($_GET['id'])){

    $project_id = $_GET['id'];

    $project_q = $db->query("SELECT * FROM projects WHERE id=$project_id");
    $project = $project_q->fetch_assoc();

    $start =  date('Y/m/d', strtotime($project['start']));
    $end =  date('Y/m/d', strtotime($project['end']));

    $reformat = $start." - ".$end;

    if(!$project){
        echo "<script>alert('Project not exist!');window.location='project-index.php'</script>";
    }

    if(isset($_POST['name'])){

        $dateStr = explode("-", $_POST['date']);

        $start =  date('Y/m/d', strtotime($dateStr[0]));
        $end =  date('Y/m/d', strtotime($dateStr[1]));

        $project = "UPDATE projects SET name='$_POST[name]', location_name = '$_POST[location_name]', start='$start', end='$end' ,status='$_POST[status]'";

        if (!$db->query($project)) {
            echo "Error: " . $project . "<br>" . $db->error; exit();
        }else{
            echo "<script>alert('Project successfully updated!');window.location='project-edit.php?id=$project_id'</script>";
        }
    }

}else{

}
?>
<?= include('layout/head.php'); ?>

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
                                    <li class="breadcrumb-item"><?= $project['name'] ?></li>
                                    <li class="breadcrumb-item">Edit</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-8 offset-md-2">
                        <div class="card">
                            <div class="card-body">
                                <form class="theme-form" method="post">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="name">Name</label>
                                        <input class="form-control" name="name" id="name" value="<?= $project['name']?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="date">Project Duration</label>
                                        <input class="datepicker-here form-control digits col-md-6" id="date" name="date" type="text" data-range="true" value="<?= $reformat?>" data-multiple-dates-separator=" - " data-language="en">
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="location_name">Location Name</label>
                                        <textarea class="form-control text-uppercase" name="location_name" rows="5" id="location_name" required><?= $project['location_name']?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="status">Project Status</label>
                                        <select name="status" id="status" class="form-control col-md-3" required>
                                            <?php foreach (getProjectStatus() as $key => $status){ ?>
                                                <option value="<?= $key ?>" <?= ($project['status'] == $key)? "selected" : "" ?>><?= $status ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                            <a href="project-index.php" class="btn btn-warning">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        <?php include('layout/footer.php'); ?>
        <!-- footer end-->
    </div>
    <!-- Page Body End-->
</div>
<!-- latest jquery-->

</body>

<?php include('layout/script.php'); ?>
</html>