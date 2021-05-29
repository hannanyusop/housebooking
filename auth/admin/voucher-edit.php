
<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_admin.php') ?>
<?php
if(isset($_GET['id'])){

    $voucher_id = $_GET['id'];

    $voucher_q = $db->query("SELECT * FROM vouchers WHERE id=$voucher_id");
    $voucher = $voucher_q->fetch_assoc();

    if(!$voucher){
        echo "<script>alert('Voucher not exist!');window.location='voucher-index.php'</script>";
    }

    if(isset($_POST['name'])){


        $image = $voucher['image'];

        if($_FILES["image"]["name"] != ""){

            $target_dir = "../../assets/uploads/voucher/";
            $temp = explode(".", $_FILES["image"]["name"]);
            $rename = round(microtime(true)) . '.' . end($temp);
            $image = $target_dir.$rename;

            #check if file more than 10MB
            if($_FILES['image']['size'] > 10000000){
                echo "<script>alert('Ops! Exceed file limit.(10MB)');window.location='voucher-create.php';</script>";

                exit();
            }

            try{
                move_uploaded_file($_FILES["image"]["tmp_name"], $image);
            }catch (Exception $e){
                var_dump($e);exit();
            }
        }

        $name = $_POST['name']; $cost = $_POST['cost'];

        $valid_till = date('Y-m-d', strtotime($_POST['valid_till']));
        $status = ($_POST['status'] == 1)? 1 : 0;

        $query = "UPDATE vouchers SET name='$name',image = '$image', valid_till='$valid_till', cost='$cost',status='$status' WHERE id=$voucher_id";

        if (!$db->query($query)) {
            echo "Error: " . $query . "<br>" . $db->error; exit();
        }else{
            echo "<script>alert('Voucher successfully updated!');window.location='voucher-index.php'</script>";
        }
    }

}else{
    echo "<script>alert('Invalid parameter!');window.location='voucher-index.php';</script>";
}
?>
<?php include('layout/head.php'); ?>

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
                                    <li class="breadcrumb-item"><a href="voucher-index.php">Voucher</a></li>
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
                                <form class="theme-form" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="name">Name</label>
                                        <input class="form-control" name="name" id="name" value="<?= $voucher['name'] ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="valid_till">Valid Until</label>
                                        <input class="datepicker-here form-control col-md-6" id="valid_till" name="valid_till" value="<?= $voucher['valid_till'] ?>" type="text" data-language="en">
                                    </div>


                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="image">Image</label>
                                        <input class="form-control col-md-6" type="file" name="image" id="image">

                                        <img src="<?= $voucher['image'] ?>" width="70px" alt="<?= $voucher['name'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="cost">Cost</label>
                                        <input class="form-control col-md-6" id="cost" value="<?= $voucher['cost'] ?>" name="cost" type="number" min="0">
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label pt-0" for="status">Status</label>
                                        <select name="status" id="status" class="form-control col-md-3" required>
                                            <?php foreach (getVoucherStatus() as $key => $status){ ?>
                                                <option value="<?= $key ?>" <?= ($voucher['status'] == $key)? "selected" : "" ?>><?= $status ?></option>
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
        </div>
        <?php include('layout/footer.php'); ?>
    </div>
</div>
</body>
<?= include('layout/script.php'); ?>
</html>