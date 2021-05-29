<?php

require_once '../env.php';


    if(isset($_POST['email'])){


        #check if email is unique
        if(isset($_POST['email'])){

            #check if mail is valid
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                echo "<script>alert('Ops! invalid password!');window.location='register.php '</script>";
                exit();
            }

            $customer_q = $db->query("SELECT * FROM customers WHERE email='$_POST[email]'");
            $customer = $customer_q->fetch_assoc();

            $agent_q = $db->query("SELECT * FROM agents WHERE email='$_POST[email]'");
            $agent = $agent_q->fetch_assoc();

            $admin_q = $db->query("SELECT * FROM admin WHERE email='$_POST[email]'");
            $admin = $admin_q->fetch_assoc();


            if($customer || $agent || $admin){
                echo "<script>alert('Email already exist!');window.location='register.php'</script>";
            }
        }

        if($_POST['password'] != $_POST['confirm_password']){
            echo "<script>alert('Password not match!');window.location='register.php'</script>";
        }

        $name = strtoupper($_POST['name']);

        $hash_pass = password_hash($_POST['password'], PASSWORD_BCRYPT);

        if (!$db->query("INSERT INTO customers (email, password, name, phone_number) VALUES ('$_POST[email]', '$hash_pass', '$name','$_POST[phone]')")) {
            echo "Error: Inserting user data." . $db->error; exit();
        }else{


            echo "<script>window.location='register-success.php?email=".$_POST['email']."'</script>";
            #add customer account


            $body = "Hello $name,<br><br>
            <p>This email has been registered to $GLOBALS[APP_NAME].<br>Password: $_POST[password]<br><br>Please change this password to keep your account safe.
             If you not request this, please call Customer Service 06-425635654543 or drop an email at help@ecp.my</p>

            <br><br>
            <small>
                <i>This email was generated automatically by system. Don't reply this email
                    <br>For inquiry please call our Customer Service 06-425635654543</i>
            </small>
            <br><br>
            <small>
                <i>'To give customers the most compelling printing experience possible' <br>-(Managing Director & Founder)</i>
                <br>
            </small>";


            sendEmail($_POST['email'], "Activate $GLOBALS[APP_NAME] Account", $body);
            echo "<script>alert('Your account successfully registered! We have send activation link to your email');window.location='login.php '</script>";
        }

    }

?>