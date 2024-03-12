<?php
session_start();
include 'connection.php';

$id = $_GET['id'];

//$user = $_SESSION['user_id'];

$getFeed = "select * from feeds where  feed_id ='$id'";
$getFeedrun = mysqli_query($conn, $getFeed);
$feeds = mysqli_fetch_all($getFeedrun, MYSQLI_ASSOC);
//var_dump($feeds);
//
foreach ($feeds as $feed) {
    $user_id = $feed['user_id'];
    $user_feed = $feed['feed'];
    $picture = $feed['picture'];
}



if(isset($_GET['action'])){
    $action  = $_GET['action'];
    $id  = $_GET['id'];
}

if(isset($_GET['action'])){
    if(!isset($_SESSION['user_id'])){
        $_SESSION['status'] ='Login first to perform this action';
        header('Location: auth/login.php');
        die();
    }
    $delete = "delete from feeds where feed_id = '$id' and user_id = '$user_id'";
    $deleterun = mysqli_query($conn, $delete);
    if ($deleterun){
        $_SESSION['status'] = 'Feed deleted successfully';
        header("location:media.php");
        die();
    }
    else{
        $_SESSION['status'] = 'You can only delete a feed you posted';
        header('Location: media.php');
        exit();
    }
}


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Eagles Media</title>
    <link rel="shortcut icon" href="images/eagle.jpg">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<style>

</style>
<?php include 'includes/header.php' ?>

<div  class="main">
    <?php
    if(isset($_SESSION['status'])){
        ?>
        <div>
            <p class="text-white text-uppercase bg-success p-2"><?php echo $_SESSION['status']; ?></p>
        </div>
        <?php
        unset($_SESSION['status']);
    }
    ?>
    <div class="border-bottom pb-1">

        <div class="container mt-2">
            <form action="mediaprocessor.php" method="post" enctype="multipart/form-data">
                <div class="">
                    <input type="number" name="feed_id" hidden value="<?php echo $id ?>">
                        <label for="feed">Feed</label>
                        <textarea name="feed" required rows="4" class="form-control"><?php echo $user_feed ?></textarea>

                        <p class="mt-1">Picture</p>
                    <img src="Feeds/<?php echo $picture ?>" height="400" width="400"  alt="">
                    <input type="text" hidden name="originalpicture" value="<?php echo $picture ?>">
                    <p >Upload new picture</p>
                        <input type="file"  name="picture" class="form-control" placeholder="Upload your favorite picture">
                      <div class="mt-2 mb-4">
                          <button type="submit" name="updateFeed"  class="btn me-4 btn-primary" >Update feed</button>
                          <a href="edit_media.php?id=<?php echo $id ?>&action=deleteFeedback" type="submit" name="deleteFeedback" onclick="confirm('Are you sure you want to delete this post')" class="btn mx-4 bg-danger btn-primary" >Delete</a>
                      </div>

                </div>

            </form>

        </div>
    </div>
</div>
<style>
    .pics{
        width: 100%;
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
    }
</style>
</body>
</html>