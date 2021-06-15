<?php

require_once '../env.php';


#generate password
//dd(password_hash("secret", PASSWORD_BCRYPT));

if(isset($_POST['email']) && isset($_POST['password'])){

    $email = $_POST['email']; $password = $_POST['password'];


    #customer
    $result = $db->query("SELECT * FROM customers WHERE email='$email'");
    $customer = $result->fetch_assoc();

    if($customer){

        if (password_verify($password, $customer['password'])) {

            if(is_null($customer['approved_at'])){
                header('Location:customer/not-verified.php');
            }

            $_SESSION['auth'] = [
                'user_id' => (int)$customer['id'],
                'name' => $customer['name'],
                'role' => 'customer'
            ];

            if(isset($_SESSION['book'])){
                header('Location:customer/booking.php');
                die();
            }
            
            header('Location:customer/index.php');

        }else{
            echo "<script>alert('Invalid Password!');window.location='login.php'</script>";
        }
    }

    #agent
    $result = $db->query("SELECT * FROM agents WHERE email='$email'");
    $agent = $result->fetch_assoc();

    if($agent){

        if (password_verify($password, $agent['password'])) {

            $_SESSION['auth'] = [
                'user_id' => (int)$agent['id'],
                'name' => $agent['name'],
                'role' => 'agent'
            ];

            header('Location:agent/booking-index.php');

        }else{
            echo "<script>alert('Invalid Password!');window.location='login.php'</script>";
        }
    }

    #admin
    $result = $db->query("SELECT * FROM admin WHERE email='$email'");
    $admin = $result->fetch_assoc();

    if($admin){

        if (password_verify($password, $admin['password'])) {

            $_SESSION['auth'] = [
                'user_id' => (int)$admin['id'],
                'name' => $admin['name'],
                'role' => 'admin'
            ];

            header('Location:admin/index.php');

        }else{
            echo "<script>alert('Invalid Password!');window.location='login.php'</script>";
        }
    }

    echo "<script>alert('Email not found!');window.location='login.php'</script>";

}else{
    header('Location:login.php');
}
?>