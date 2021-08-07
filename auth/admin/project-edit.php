
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

        $location = getAddress($_POST['longitude'],$_POST['latitude']);

        $project = "UPDATE projects SET name='$_POST[name]',description='$_POST[description]', location_name = '$location', latitude='$_POST[latitude]', longitude = '$_POST[longitude]', start='$start', end='$end' ,status='$_POST[status]' WHERE id=$project_id";

        if (!$db->query($project)) {
            echo "Error: " . $project . "<br>" . $db->error; exit();
        }else{
            echo "<script>alert('Project successfully updated!');window.location='project-edit.php?id=$project_id'</script>";
        }
    }

}else{

}
?>
<?php include('layout/head.php'); ?>

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
                                        <label class="col-form-label pt-0" for="description">Description</label>
                                        <textarea class="form-control" name="description" rows="5" id="description" required><?= $project['description']?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="date">Project Duration</label>
                                        <input class="datepicker-here form-control digits col-md-6" id="date" name="date" type="text" data-range="true" value="<?= $reformat?>" data-multiple-dates-separator=" - " data-language="en">
                                    </div>

                                    <div class="form-group">
                                        <p>Click this link to get location coordinate <a href="https://www.gps-coordinates.net/" target="_blank">https://www.gps-coordinates.net/</a> </p>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <input class="form-control" name="latitude" id="latitude" placeholder="Latitude" value="<?= $project['latitude']?>" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" name="longitude" id="longitude" placeholder="Longitude" value="<?= $project['longitude']?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="location_name">Location Name</label>
                                        <textarea class="form-control" name="location_name" rows="5" id="location_name" disabled><?= $project['location_name']?></textarea>
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
<script type="text/javascript">
    var mymap = L.map('mapid').setView([51.505, -0.09], 13);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'pk.eyJ1IjoiaGFubmFueXVzb3AiLCJhIjoiY2tzMTY2aXJ4MTd5ajJwbXN2dGV5cnd2MyJ9.iRLoHdCnmKRx385HiL-HkQ'
    }).addTo(mymap);

    var marker = L.marker([51.5, -0.09]).addTo(mymap);

    marker.bindPopup("<b>Hello world!</b><br>I am a popup.").openPopup();
</script>
</html>