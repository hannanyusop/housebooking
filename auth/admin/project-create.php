
<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_admin.php') ?>
<?php
    if(isset($_POST['name'])){

        $dateStr = explode("-", $_POST['date']);

        $start =  date('Y/m/d', strtotime($dateStr[0]));
        $end =  date('Y/m/d', strtotime($dateStr[1]));

        $location = getAddress($_POST['longitude'],$_POST['latitude']);


        $project = "INSERT INTO projects (name,location_name,state, latitude,longitude,start,end,status, description) 
VALUES ('$_POST[name]','$location[location_name]','$location[state]', '$_POST[latitude]', '$_POST[longitude]', '$start', '$end', '$_POST[status]', '$_POST[description]')";
        if (!$db->query($project)) {
            echo "Error: " . $project . "<br>" . $db->error; exit();
        }else{
            echo "<script>alert('New project successfully created!');window.location='project-index.php'</script>";
        }
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
                                    <li class="breadcrumb-item">Project</li>
                                    <li class="breadcrumb-item">Create</li>
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
                            <div class="card-header">
                                <h5>New Project</h5>
                            </div>
                            <div class="card-body">
                                <form class="theme-form" method="post">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="name">Name</label>
                                        <input class="form-control" name="name" id="name" data-original-title="" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="description">Description</label>
                                        <textarea class="form-control" name="description" rows="5" id="description" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="date">Project Duration</label>
                                        <input class="datepicker-here form-control digits col-md-6" id="date" name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en">
                                    </div>

                                    <div class="form-group">
                                        <p>Click this link to get location coordinate <a href="https://www.gps-coordinates.net/" target="_blank">https://www.gps-coordinates.net/</a> </p>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <input class="form-control" name="latitude" id="latitude" placeholder="Latitude" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" name="longitude" id="longitude" placeholder="Longitude"  required>
                                        </div>
                                    </div>

<!--                                    <div class="form-group">-->
<!--                                        <label class="col-form-label pt-0" for="location_name">Location Name</label>-->
<!--                                        <textarea class="form-control" name="location_name" rows="5" id="location_name" data-original-title="" required>Location Name example</textarea>-->
<!--                                    </div>-->

                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="status">Project Status</label>
                                        <select name="status" id="status" class="form-control col-md-3" required>
                                            <?php foreach (getProjectStatus() as $key => $status){ ?>
                                                <option value="<?= $key ?>"><?= $status ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <a href="project-index.php" class="btn btn-secondary" data-original-title="" title="">Cancel</a>
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