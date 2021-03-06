<?php

include_once 'db_config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function dd($var){

    var_dump($var); exit();
}

function getEmailDomain($email){

    $parts = explode("@",$email);
    return $parts[1];
}

function getHouseType($type = null){

    $types = [
        1 => 'Single Family House',
        2 => 'Apartment',
        3 => 'Bungalow',
        4 => 'Cabin',
        5 => 'Carriage/Coach House',
        6 => 'Chalet'
    ];

    return (isset($type))? $types[$type] : $types;
}

function getPointFormat($pts){

    return $pts. " pts";
}

function getProjectStatus($status = null){

    $statuses = [
        0 => 'Pending',
        1 => 'On going',
        2 => 'Finished',
        3 => 'Cancelled',
    ];

    return (isset($status))? $statuses[$status] : $statuses;
}

function getBadgeProjectStatus($status = null){

    $statuses = [
        0 => "<span class='badge badge-warning'>Pending</span>",
        1 => "<span class='badge badge-success'>On going</span>",
        2 => "<span class='badge badge-info'>Finished</span>",
        3 => "<span class='badge badge-dark'>Cancelled</span>",
    ];

    return (isset($status))? $statuses[$status] : $statuses;
}

function getBookingStatus($status = null){

    $statuses = [
        0 => 'Waiting For Approval From Customer',
        1 => 'Pending Booking Fee',
        2 => 'Wait For Payment Approval',
        3 => 'Approved',
        4 => 'Rejected By Customer',
        5 => 'Payment Rejected'
    ];

    return (isset($status))? $statuses[$status] : $statuses;
}

function getBadgeBookingStatus($status = null){

    $statuses = [
        0 => "<span class='badge badge-warning'>Waiting For Approval From Customer</span>",
        1 => "<span class='badge badge-info'>Pending Booking Fee</span>",
        2 => "<span class='badge badge-info'>Wait For Payment Approval</span>",
        3 => "<span class='badge badge-success'>Approved</span>",
        4 => "<span class='badge badge-dark'>Rejected By Customer</span>",
        5 => "<span class='badge badge-dark'>Payment Rejected</span>",
    ];

    return (isset($status))? $statuses[$status] : $statuses;
}

function getVoucherStatus($status = null){

    $statuses = [
        0 => 'Inactive',
        1 => 'Active',
    ];

    return (isset($status))? $statuses[$status] : $statuses;
}

function getBadgeVoucherStatus($status = null){

    $statuses = [
        0 => "<span class='badge badge-dark'>Inactive</span>",
        1 => "<span class='badge badge-success'>Active</span>",
    ];

    return (isset($status))? $statuses[$status] : $statuses;
}

function checkDir($directoryName){

    if(!is_dir($directoryName)){
        //Directory does not exist, so lets create it.
        mkdir($directoryName, 0755);
    }
}

function generateUIAvatar($name){
    return "https://ui-avatars.com/api/?background=0b96b5&color=fff&name=".$name;
}

function getRank($rank){


    if($rank == 0){
        return "<i class='fas fa-star'></i><i class='fas fa-star'></i><i class='fas fa-star'></i><i class='fas fa-star'></i><i class='fas fa-star'></i>";
    }else if($rank <= 1){
        return "<i class='fas fa-star text-warning'></i><i class='fas fa-star'></i><i class='fas fa-star'></i><i class='fas fa-star'></i><i class='fas fa-star'></i>";
    }elseif ($rank > 1 && $rank < 9){
        return "<i class='fas fa-star text-warning'></i><i class='fas fa-star text-warning'></i><i class='fas fa-star'></i><i class='fas fa-star'></i><i class='fas fa-star'></i>";
    }elseif ($rank >= 9 && $rank < 16){
        return "<i class='fas fa-star text-warning'></i><i class='fas fa-star text-warning'></i><i class='fas fa-star text-warning'></i><i class='fas fa-star'></i><i class='fas fa-star'></i>";
    }elseif ($rank >= 16 && $rank < 25){
        return "<i class='fas fa-star text-warning'></i><i class='fas fa-star text-warning'></i><i class='fas fa-star text-warning'></i><i class='fas fa-star text-warning'></i><i class='fas fa-star'></i>";
    }else{
        return "<i class='fas fa-star text-warning'></i><i class='fas fa-star text-warning'></i><i class='fas fa-star text-warning'></i><i class='fas fa-star text-warning'></i><i class='fas fa-star text-warning'></i>";
    }

}

function getStar(){

    return "<i class='ion ion-ios-star'></i>";
}
function getBackendRole($role_id = null){

    $roles = [
        1 => 'MANAGER',
        2 => 'STAFF',
    ];

    if(is_null($role_id)){
        return $roles;
    }

    return $roles[$role_id];
}

function getOption($name, $default = ''){

    $option_q = $GLOBALS['db']->query("SELECT * FROM options WHERE name='$name'");
    $option = $option_q->fetch_assoc();

    if(!$option){
        return $default;
    }

    return $option['value'];

}

function sendEmail($recipient_email, $title = "", $body){

    $mail = new PHPMailer(true);

    try {
        //Server settings

        if($GLOBALS['email_test']  )

            if($GLOBALS['email_debug']){
//                $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            }

            $mail->isSMTP();

            $mail->Host       = $GLOBALS['smtp_host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $GLOBALS['smtp_username'];
            $mail->Password   = $GLOBALS['smtp_password'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('ecenterprinting@yahoo.com', 'nor-reply');

            if($GLOBALS['env'] == 'development'){
                $mail->addAddress($GLOBALS['email_test']);
            }else{
                $mail->addAddress($recipient_email);
            }

            $mail->isHTML(true);
            $mail->Subject = $title;
            $mail->Body    = $body;
            $mail->send();
            return true;

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function generateResetPasswordKey() {
    $alphabet = 'abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 12; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function generateConfirmationCode() {
    $alphabet = '1234567890987654321234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function getPrintingMode($mode = null){

    $modes = [
        1 => 'Colour',
        2 => 'Black & White'
    ];

    return (is_null($mode))? $modes : $modes[$mode];
}
function getCheckedAddOn($addOnId){

    return (isset($_SESSION['jobs'][$_SESSION['auth']['user_id']]['addOn'][$addOnId]))? 'CHECKED' : '';
}

function insertJobTransaction($job_id, $staff_id, $status, $note){


    $sql = "INSERT INTO job_transaction (job_id,staff_id,status,note) VALUES ($job_id, $staff_id, $status, '$note')";


    if (!$GLOBALS['db']->query($sql)) {
        echo "Error: " . $sql . "<br>" . $GLOBALS['db']->error; exit();
    }

    return true;

}

function getTrackListAccepted(){

    $statuses = [
        1 => 'You created a job.',
        2 => 'Your job has been received.',
        4 => 'Document is ready.',
        5 => 'Document has been picked.'
    ];

    return $statuses;

}

function insertNotification($user_id, $title, $message){

    $sql = "INSERT INTO notifications (user_id,seen,title,messages) VALUES ($user_id, 0, '$title', '$message')";

    if (!$GLOBALS['db']->query($sql)) {
        echo "Error: " . $sql . "<br>" . $GLOBALS['db']->error; exit();
    }
    return true;
}

function getTimeAgo($timestamp){

date_default_timezone_set("Asia/Kuala_Lumpur");
  $time_ago        = strtotime($timestamp);
  $current_time    = time();
  $time_difference = $current_time - $time_ago;
  $seconds         = $time_difference;

  $minutes = round($seconds / 60); // value 60 is seconds
  $hours   = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec
  $days    = round($seconds / 86400); //86400 = 24 * 60 * 60;
  $weeks   = round($seconds / 604800); // 7*24*60*60;
  $months  = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60
  $years   = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60

  if ($seconds <= 60){

      return "Just Now";

  } else if ($minutes <= 60){

      if ($minutes == 1){

          return "one minute ago";

      } else {

          return "$minutes minutes ago";

      }

  } else if ($hours <= 24){

      if ($hours == 1){

          return "an hour ago";

      } else {

          return "$hours hrs ago";

      }

  } else if ($days <= 7){

      if ($days == 1){

          return "yesterday";

      } else {

          return "$days days ago";

      }

  } else if ($weeks <= 4.3){

      if ($weeks == 1){

          return "a week ago";

      } else {

          return "$weeks weeks ago";

      }

  } else if ($months <= 12){

      if ($months == 1){

          return "a month ago";

      } else {

          return "$months months ago";

      }

  } else {

      if ($years == 1){

          return "one year ago";

      } else {

          return "$years years ago";

      }
  }
}

function strLimit($string, $limit = 20){
    return (strlen($string) > $limit)?substr($string, 0, $limit) . '...' : $string ;
}

function displayPrice($price){

    return "RM ".number_format($price, 2);
}

function displayPoint($point){

    return $point." Ptz";
}

if(!function_exists('getAddress')) {

    function getAddress($longitude, $latitude)
    {

        $mapbox = new Mapbox($GLOBALS['mapbox_token']);
//        $longitude = 115.01;
//        $longitude = 4.76;

        $address = "Kampung Pahlawan Jalan Pandaruan, 98700 limbang";
//        $res = $mapbox->geocode($address);

        $res = $mapbox->reverseGeocode($longitude, $latitude);

        if($res->success()){

            $state = null;
            foreach ($res->getData()[0]['context'] as $data){

                if(in_array($data['text'], stateList())){
                    $state = $data['text'];
                }
            }
            return [
                'location_name' => $res->getData()[0]['place_name'],
                'state'         => $state
            ];
        }

        return [
            'location_name' => "Failed to fetch address",
            'state'         => null
        ];
    }
}

if(!function_exists('stateList')){

    function stateList(){

        $states = [
            'Johor' => 'Johor',
            'Kedah' => 'Kedah',
            'Kelantan' => 'Kelantan',
            'Malacca' => 'Malacca',
            'Negeri Sembilan' => 'Negeri Sembilan',
            'Pahang' => 'Pahang',
            'Perak' => 'Perak',
            'Perlis' => 'Perlis',
            'Penang' => 'Penang',
            'Sabah' => 'Sabah',
            'Sarawak' => 'Sarawak',
            'Selangor' => 'Selangor',
            'Terengganu' => 'Terengganu',
            'W.P. Kuala Lumpur' => 'W.P. Kuala Lumpur',
            'W.P. Labuan' => 'W.P. Labuan',
            'W.P. Putrajaya' => 'W.P. Putrajaya',
        ];

        return $states;
    }
}


