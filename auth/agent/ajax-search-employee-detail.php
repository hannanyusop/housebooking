<?php
    include_once('../permission_agent.php');

    $errors = array(); //To store errors
    $data = array();
    $data['success'] = false;

    if (empty($_POST['customer_id'])) { //Name cannot be empty
        $data['message'] = 'Please select customer.';
    }else{

        if($_POST['customer_id'] == "null"){
            $data['message'] = 'Please select customer.';
        }else{

            $customer_q = $db->query("SELECT * FROM customers WHERE id = '$_POST[customer_id]'");
            $customer = $customer_q->fetch_assoc();

            if(!$customer){
                $data['message'] = 'Customer details not found!';
            }else{
                $data['success'] = true;
                $data['details'] = [
                    'customer_id' => $_POST['customer_id'],
                    'name' => $customer['name'],
                    'email' => $customer['email'],
                    'phone_number' => $customer['phone_number']
                ];
            }

        }
    }

    echo json_encode($data);
?>
