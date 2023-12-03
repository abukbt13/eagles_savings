<?php
session_start();
if(isset($_SESSION['user_id'])){

    session_destroy();
    session_start();
    $_SESSION['login'] = 'You have logout of the system';
}
header("location:login.php");


?>
