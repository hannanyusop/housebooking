<?php
include_once('../permission_admin.php');

if(isset($_GET['id'])){
    $project_id = $_GET['id'];

    if(isset($_POST['add_house'])){

        $insert_house = "INSERT INTO houses (project_id, current_booking_id, name, type, price, point,description,sqft,room,bath_room,garage) 
                                VALUES ($project_id, NULL, '$_POST[name]', '$_POST[type]', '$_POST[price]', '$_POST[point]', '$_POST[description]','$_POST[sqft]', '$_POST[room]', '$_POST[bath_room]', '$_POST[garage]')";

        if (!$db->query($insert_house)) {
            echo "Error: " . $insert_house . "<br>" . $db->error; exit();
        }else{

            $house_id = $db->insert_id;

            echo "<script>alert('New house successfully created!');window.location='house-insert-image.php?id=$house_id'</script>";
        }
    }
}

echo "<script>alert('Error : missing parameter!');window.location='project-index.php'</script>";

