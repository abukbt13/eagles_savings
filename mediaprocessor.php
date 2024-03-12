<?php
session_start();
include 'connection.php';
$user_id = $_SESSION['user_id'];
if(!isset($_SESSION['user_id'])){
    $_SESSION['status'] ='Login first to perform this action';
    header('Location: auth/login.php');
    exit();
}


if(isset($_POST["updateFeed"])) {
    if (!$_SESSION['user_id']) {
        $_SESSION['status'] = 'Login first to upload feedback';
        header('Location: media.php');
        exit(); // It's a good practice to include exit() after header() to ensure no further code execution after redirection
    }

    $feed_id = $_POST["feed_id"];
    $feed = $_POST["feed"];
    $originalpicture = $_POST["originalpicture"];
    $picture= $_FILES['picture']['name'];
    $picture_tmp = $_FILES['picture']['tmp_name'];
    $picture_name = rand(0,100).$picture;
    $filepath = "Feeds/$originalpicture";

    if ($feed == ""){
        $_SESSION['status'] = 'All fields are required';
        header('Location: media.php');
        exit();
    }
    if(empty($picture)){
        $savefeed = "update  feeds set feed ='$feed' where user_id='$user_id' and feed_id='$feed_id'";
        $savefeedrun = mysqli_query($conn, $savefeed);
        if ($savefeedrun){
            $_SESSION['status'] = 'Feed Updated successfully';
            header("location:media.php");
            die();
        }
    }
    else {

        $savefeed = "update  feeds set feed ='$feed', picture = '$picture_name' where user_id='$user_id' and feed_id='$feed_id'";
        $savefeedrun = mysqli_query($conn, $savefeed);
        if ($savefeedrun){
            unlink($filepath);
            move_uploaded_file($picture_tmp,"Feeds/". $picture_name);
            $_SESSION['status'] = 'Feed Updated successfully';
            header("location:media.php");
            die();
        }
    }
}



