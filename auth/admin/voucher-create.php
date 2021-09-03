
<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_admin.php') ?>
<?php
    if(isset($_POST['name'])){


        $target_dir = "../../assets/uploads/voucher/";
        $temp = explode(".", $_FILES["image"]["name"]);
        $rename = round(microtime(true)) . '.' . end($temp);
        $file_location = $target_dir.$rename;

        #check if file more than 10MB
        if($_FILES['image']['size'] > 10000000){
            echo "<script>alert('Ops! Exceed file limit.(10MB)');window.location='voucher-create.php';</script>";

            exit();
        }


        try{
            move_uploaded_file($_FILES["image"]["tmp_name"], $file_location);
        }catch (Exception $e){
            var_dump($e);exit();
        }

        $name = $_POST['name']; $cost = $_POST['cost'];

        $valid_till = date('Y-m-d', strtotime($_POST['valid_till']));
        $status = ($_POST['status'] == 1)? 1 : 0;

        $vouchers = "INSERT INTO vouchers (name, image, valid_till, cost, status) VALUES ('$name', '$file_location', '$valid_till', '$cost', '$status')";

        if (!$db->query($vouchers)) {
            echo "Error: " . $vouchers . "<br>" . $db->error; exit();
        }else{
            echo "<script>alert('New ticket successfully created!');window.location='voucher-index.php'</script>";
        }
    }
?>
<?= include('layout/head.php'); ?>

<body main-theme-layout="main-theme-layout-1">

<div class="page-wrapper">
    <?php include('layout/top-bar.php') ?>
    <div class="page-body-wrapper">
        <?php include('layout/side-bar.php'); ?>

        <div class="page-body">
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col">
                            <div class="page-header-left">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Voucher</li>
                                    <li class="breadcrumb-item">Create Ticket</li>
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
                                <form class="theme-form" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="name">Name</label>
                                        <input class="form-control" name="name" id="name" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="valid_till">Valid Until</label>
                                        <input class="datepicker-here form-control col-md-6" id="valid_till" name="valid_till" type="text" data-language="en">
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="image">Image</label>
                                        <input class="form-control col-md-6" type="file" name="image" id="image"  required>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="cost">Point</label>
                                        <input class="form-control col-md-6" id="cost" value="0" name="cost" type="number" min="0">
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="status">Status</label>
                                        <select name="status" id="status" class="form-control col-md-3" required>
                                            <?php foreach (getVoucherStatus() as $key => $status){ ?>
                                                <option value="<?= $key ?>"><?= $status ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <a href="voucher-index.php" class="btn btn-warning">Cancel</a>
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
</html>