<?php


session_start();
//require_once('vendor/autoload.php');


#call al class
//$generator = new Picqer\Barcode\BarcodeGeneratorHTML();
//$barCodePNG = new Picqer\Barcode\BarcodeGeneratorPNG();


#for error reporting
//error_reporting(0);
require_once('vendor/autoload.php');

#database
include_once 'config/db_config.php';

#include helper.php
include_once "config/helper.php";

$GLOBALS['APP_NAME'] = 'HOUSE BOOKING SYSTEM';
$GLOBALS['SHORT NAME'] = 'HBS';

#PHP Mailer
$GLOBALS['smtp_username'] = 'ecenterprinting@yahoo.com';
$GLOBALS['smtp_password'] = 'idwfwfybfmqgkgfc';
$GLOBALS['smtp_host'] = 'smtp.mail.yahoo.com';
$GLOBALS['admin_email'] = 'ecenterprinting@yahoo.com';

#go to this link https://temp-mail.org/en/ and get temp email for testing

$GLOBALS['email_test'] = 'muzer@zetmail.com';
$GLOBALS['env'] = 'development'; # 'production' / 'development'
$GLOBALS['email_debug'] = true; # true / false

$GLOBALS['xampp_macos'] = true;
$GLOBALS['send_email'] = true;

?>