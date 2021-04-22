<?php

    $GLOBALS['db'] = $db = new mysqli("localhost", "root", "", "booking_house");

    if($db->connect_error){
        header('Location: ../error.php');
    }

?>