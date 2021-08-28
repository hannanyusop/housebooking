
<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_admin.php') ?>
<?php include('layout/head.php'); ?>

<body main-theme-layout="main-theme-layout-1">
<?php

$projects_q = $db->query("SELECT * FROM projects");

$project = null;
if(isset($_GET['id'])){

    $project_q = $db->query("SELECT * FROM projects WHERE id=$_GET[id]");
    $project   = $project_q->fetch_assoc();

    if($project){

        $house_q = $db->query("SELECT * FROM houses WHERE project_id=$project[id]");
        $house   = $house_q->num_rows;

        $pending_q = $db->query("SELECT * FROM houses h LEFT JOIN bookings b ON b.id=h.current_booking_id WHERE project_id=$project[id] AND current_booking_id IS NOT NULL AND status IN (0,1,2)");
        $pending   = $pending_q->num_rows;

        $statuses = [
            3 => 'Approved',
            0 => 'Waiting For Approval From Customer',
            1 => 'Pending Booking Fee',
            2 => 'Wait For Payment Approval',
        ];

        $available_q = $db->query("SELECT * FROM houses WHERE current_booking_id IS NULL AND project_id=$project[id]");
        $pie['Available'] = $available_q->num_rows;
        foreach ($statuses as $key => $status){
            $q = $db->query("SELECT * FROM houses h LEFT JOIN bookings b ON b.id=h.current_booking_id WHERE project_id=$project[id] AND current_booking_id IS NOT NULL AND status=$key");
            $pie[$status] = $q->num_rows;
        }

    }

}
?>

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
                                <h3>Report By Project</h3>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php"><i data-feather="home"></i></a></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">

                <div class="card">
                    <div class="card-body">
                        <form class="theme-form" method="get">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <select class="form-control" name="id">
                                        <option> --- Select Project --- </option>
                                        <?php while($projects = $projects_q->fetch_assoc()){ ;?>
                                            <option value="<?= $projects['id'] ?>" <?= (isset($_GET['id']) && $_GET['id'] == $projects['id'])? "selected" : "" ?>><?= $projects['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <button type="submit" class="btn btn-primary">Generate Report</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>

                <?php if($project){ ?>
                <div class="row">
                    <div class="col-6 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <p class="text-center">Property  Statistics For <?= $project['name'] ?></p>
                                <canvas id="oilChart" width="600" height="400"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="project-widgets text-center">
                                            <h1 class="font-primary counter"><?= $house ?></h1>
                                            <h6 class="mb-0">Total Property</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php foreach ($pie as $k => $v){ ?>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="project-widgets text-center">
                                                <h1 class="font-primary counter"><?= $v ?></h1>
                                                <h6 class="mb-0"><?= $k ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
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

    <?php if($project){ ?>

    var oilCanvas = document.getElementById("oilChart");

    Chart.defaults.global.defaultFontFamily = "Lato";
    Chart.defaults.global.defaultFontSize = 18;

    var oilData = {
        labels: [
            "Available",
            "Pending Booking Fee",
            "Wait For Payment Approval",
            "Approved",
            "Waiting For Approval From Customer"
        ],
        datasets: [
            {
                data: <?= json_encode(array_values($pie)) ?>,
                backgroundColor: [
                    "#FF6384",
                    "#63FF84",
                    "#84FF63",
                    "#8463FF",
                    "#6384FF"
                ]
            }]
    };

    var pieChart = new Chart(oilCanvas, {
        type: 'pie',
        data: oilData
    });

    <?php } ?>

</script>
</html>