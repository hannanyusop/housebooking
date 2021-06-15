<?php

include_once 'env.php';

if(isset($_GET['id']) && isset($_GET['agent'])){

    $house_id = $_GET['id'];
    $agent_id = $_GET['agent'];

    $house_q = $db->query("SELECT * FROM houses WHERE id=$house_id");
    $house = $house_q->fetch_assoc();

    $agent_q = $db->query("SELECT * FROM agents WHERE id=$agent_id");
    $agent = $agent_q->fetch_assoc();

    #redirect back if data not found
    if(!$house || !$agent){
        echo "<script>alert('Invalid data!');window.location='index.php'</script>";
    }

    #set session to store url
    $_SESSION['book'] = [
            'house_id' => $house_id,
            'agent_id' => $agent_id
    ];

    #check if has logged in user
    if(isset($_SESSION['auth'])){

        #if session auth found . check role
        if($_SESSION['auth']['role'] == "customer"){
            echo "<script>window.location='auth/customer/booking.php'</script>";
        }else{
            #force logout and redirect to login page
            unset($_SESSION['auth']);
        }
    }

    echo "<script>alert('Please login to continue booking process!');window.location='auth/login.php'</script>";

}
?>