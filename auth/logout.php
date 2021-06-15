<?php

session_start();
unset($_SESSION['auth']);
echo "<script>alert('Successfully logout!');window.location='login.php'</script>";

?>