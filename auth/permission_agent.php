<?php
	require_once '../../env.php';

    if(isset($_SESSION['auth'])){

        if($_SESSION['auth']['role'] != 'agent'){
            session_destroy(); #delete all session
            echo "<script>alert('Access denied!');window.location='../login.php';</script>";
        }

    }else{
        echo "<script>alert('Session ended! Please re-login!');window.location='../login.php';</script>";
    }

    $user_id = $_SESSION['auth']['user_id'];

    $user_q = $db->query("SELECT * FROM agents WHERE id=$user_id");
    $user = $user_q->fetch_assoc();

    $point_balance = $user['point'];

?>