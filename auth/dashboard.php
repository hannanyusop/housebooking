<?php

require_once '../env.php';


if(isset($_SESSION['auth'])){

    $session = $_SESSION['auth'];

    if($session['role'] == 'admin'){

        header('Location:admin/index.php');
    }elseif($session['role'] == 'agent'){

        header('Location:agent/booking-index.php');
    }else{
        if(isset($_SESSION['book'])){
            header('Location:customer/booking.php');
        }

        header('Location:customer/index.php');
    }
}else{
    header('Location:login.php');
}