
<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_admin.php') ?>
<?php
    if(isset($_GET['id'])){

        $house_id = $_GET['id'];

        $house_q = $db->query("SELECT * FROM houses WHERE id=$house_id");
        $house = $house_q->fetch_assoc();

        $brochure_q = $db->query("SELECT * FROM house_images WHERE house_id=$house_id");

        if(!$house){
            echo "<script>alert('Project not exist!');window.location='project-index.php'</script>";
        }

        if(isset($_POST['insert'])){

            $files = $_FILES['file']['name'];
            $count = count($files);

            $start = 0;
            foreach ($files as $key => $file){

                $target_dir = "../../assets/uploads/house/";

                //Directory does not exist, so lets create it.
                if(!is_dir($target_dir)){
                    mkdir($target_dir, 0755);
                }

                $temp = explode(".", $_FILES["file"]["name"][$start]);
                $rename = $start.round(microtime(true)) . '.' . end($temp);
                $file_location = $target_dir.$rename;

                #check if file more than 10MB
                if($_FILES['file']['size'][$start] > 10000000){
                    echo "<script>alert('Ops! Exceed file limit.(10MB)');window.location='house-insert-image.php?id=$house_id';</script>";
                    exit();
                }

                try{
                    move_uploaded_file($_FILES["file"]["tmp_name"][$start], $file_location);
                    $db->query("INSERT INTO house_images (house_id,url) VALUES($house_id,'$file_location')");

                    echo "<script>alert('$count image(s) inserted');window.location='house-insert-image.php?id=$house_id';</script>";

                }catch (Exception $e){
                    var_dump($e);exit();
                }

                $start++;
            }
        }

        if(isset($_GET['delete'])){

            $brochure_q = $db->query("SELECT * FROM house_images WHERE id='$_GET[delete]' AND house_id=$house_id");
            $brochure = $brochure_q->fetch_assoc();

            if(!$brochure){
                echo "<script>alert('House not exist!');window.location='house-insert-image.php?id=$house_id'</script>";
            }

            #delete file
            unlink($brochure['url']);

            #delete query
            if (!$db->query("DELETE FROM house_images WHERE id=$_GET[delete]")) {
                echo "Error: ". $db->error; exit();
            }else{
                echo "<script>alert('House successfully deleted!');window.location='house-insert-image.php?id=$house_id'</script>";
            }
        }

    }else{
        echo "<script>alert('Error : missing parameter!');window.location='project-index.php'</script>";
    }
?>
<?php include('layout/head.php'); ?>
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
                                    <li class="breadcrumb-item">Insert Brochure</li>
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
                    <a href="project-manage.php?id=<?=$house_id?>" class="btn btn-dark text-white"><i class="fa fa-caret-left mr-1"></i> Back</a>
                </div>
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="my-gallery card-body row" itemscope="" data-pswp-uid="1">

                                    <?php while($brochure = $brochure_q->fetch_assoc()){ ;?>
                                        <figure class="col-xl-3 col-md-4 col-6" itemprop="associatedMedia" itemscope="">
                                            <a href="house-insert-image.php?id=<?=$house_id?>&delete=<?=$brochure['id']?>" onclick="return confirm('Are you sure want to remove this brochure?')" class="btn btn-danger btn-sm btn-round"><i class="fa fa-trash"></i> </a>
                                            <a href="<?= $brochure['url'] ?>" itemprop="contentUrl" data-size="1600x950" data-original-title="" title="">
                                                <img class="img-thumbnail" src="<?= $brochure['url'] ?>" itemprop="thumbnail" alt="Image description" data-original-title="" title="">
                                            </a>
                                        </figure>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="file-loading">
                                        <input id="kv-explorer" type="file" name="image[]" multiple>
                                    </div>
                                    <br>
                                    <div class="file-loading">
                                        <input id="file-0a" class="file" type="file" name="file[]" data-theme="fas" multiple>
                                    </div>
                                    <br>

                                    <div class="d-flex">
                                        <div class="p-2">
                                            <a href="project-manage.php?id=<?= $house['project_id'] ?>" type="reset" class="btn btn-dark">Back</a>
                                        </div>
                                        <div class="ml-auto p-2">
                                            <button type="submit" class="btn btn-primary" name="insert">Add Brochure</button>
                                        </div>
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
<!-- Plugin used-->
<script>
    $('#file-fr').fileinput({
        theme: 'fas',
        language: 'fr',
        uploadUrl: '#',
        allowedFileExtensions: ['jpg', 'png', 'gif']
    });
    $('#file-es').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        allowedFileExtensions: ['jpg', 'png', 'gif']
    });
    $("#file-0").fileinput({
        theme: 'fas',
        uploadUrl: '#'
    }).on('filepreupload', function(event, data, previewId, index) {
        alert('The description entered is:\n\n' + ($('#description').val() || ' NULL'));
    });
    $("#file-1").fileinput({
        theme: 'fas',
        uploadUrl: '#', // you must set a valid URL here else you will get an error
        allowedFileExtensions: ['jpg', 'png', 'gif'],
        overwriteInitial: false,
        maxFileSize: 1000,
        maxFilesNum: 10,
        //allowedFileTypes: ['image', 'video', 'flash'],
        slugCallback: function (filename) {
            return filename.replace('(', '_').replace(']', '_');
        }
    });

    $("#file-3").fileinput({
        theme: 'fas',
        showUpload: false,
        showCaption: false,
        browseClass: "btn btn-primary btn-lg",
        fileType: "any",
        previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
        overwriteInitial: false,
        initialPreviewAsData: true,
        initialPreview: [
            "http://lorempixel.com/1920/1080/transport/1",
            "http://lorempixel.com/1920/1080/transport/2",
            "http://lorempixel.com/1920/1080/transport/3"
        ],
        initialPreviewConfig: [
            {caption: "transport-1.jpg", size: 329892, width: "120px", url: "{$url}", key: 1},
            {caption: "transport-2.jpg", size: 872378, width: "120px", url: "{$url}", key: 2},
            {caption: "transport-3.jpg", size: 632762, width: "120px", url: "{$url}", key: 3}
        ]
    });
    $("#file-4").fileinput({
        theme: 'fas',
        uploadExtraData: {kvId: '10'}
    });
    $(".btn-warning").on('click', function () {
        var $el = $("#file-4");
        if ($el.attr('disabled')) {
            $el.fileinput('enable');
        } else {
            $el.fileinput('disable');
        }
    });
    $(".btn-info").on('click', function () {
        $("#file-4").fileinput('refresh', {previewClass: 'bg-info'});
    });

    $(document).ready(function () {
        $("#test-upload").fileinput({
            'theme': 'fas',
            'showPreview': false,
            'allowedFileExtensions': ['jpg', 'png', 'gif'],
            'elErrorContainer': '#errorBlock'
        });
        $("#kv-explorer").fileinput({
            'theme': 'explorer-fas',
            'uploadUrl': '#',
            overwriteInitial: false,
            initialPreviewAsData: true,
            initialPreview: [
                "http://lorempixel.com/1920/1080/nature/1",
                "http://lorempixel.com/1920/1080/nature/2",
                "http://lorempixel.com/1920/1080/nature/3"
            ],
            initialPreviewConfig: [
                {caption: "nature-1.jpg", size: 329892, width: "120px", url: "{$url}", key: 1},
                {caption: "nature-2.jpg", size: 872378, width: "120px", url: "{$url}", key: 2},
                {caption: "nature-3.jpg", size: 632762, width: "120px", url: "{$url}", key: 3}
            ]
        });
        /*
         $("#test-upload").on('fileloaded', function(event, file, previewId, index) {
         alert('i = ' + index + ', id = ' + previewId + ', file = ' + file.name);
         });
         */
    });
</script>
</html>