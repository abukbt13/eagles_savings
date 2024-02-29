<?php
session_start();
include 'connection.php';

if(isset($_POST["feedback"])) {
    if (!$_SESSION['user_id']) {
        header('Location: /user/login.php');
        exit(); // It's a good practice to include exit() after header() to ensure no further code execution after redirection
    }
    $user_id =$_SESSION['user_id'];
    $feed = $_POST["feed"];
    $picture= $_FILES['picture']['name'];
    $picture_tmp = $_FILES['picture']['tmp_name'];
    $picture_name = rand(0,100).$picture;

    $savefeed = "insert into feeds (feed, picture,user_id) values('$feed','$picture_name','$user_id')";
    $savefeedrun = mysqli_query($conn, $savefeed);
    if ($savefeedrun){
        move_uploaded_file($picture_tmp,"Feeds/". $picture_name);
        header("location:media.php");
        $_SESSION['status'] = 'Feed Added successfully';
        die();
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
            <p class="text-white text-uppercase bg-primary p-2"><?php echo $_SESSION['status']; ?></p>
        </div>
        <?php
        unset($_SESSION['status']);
    }
    ?>
    <div class="d-flex border-bottom pb-1">
        <div class="mx-5">
            <h2>Eagles Saving Group</h2>
            <p>Unlocking infinite possibilities through savings and investing in projects </p>
        </div>
        <div class="border">
            <form action="media.php" method="post" enctype="multipart/form-data">
               <div class="d-flex">
                   <div class="mx-2">
                       <label for="feed">Tell us something about eagle or any motivation</label>
                       <textarea name="feed" rows="4" class="form-control"></textarea>

                   </div>
                   <div class="mx-1">
                       <label for="" class="mt-1">Upload Your picture</label>
                       <input type="file" name="picture" class="form-control" placeholder="Upload your favorite picture">
                       <button type="submit" name="feedback" class="btn btn-primary" >Post feed</button>

                   </div>
               </div>

            </form>
        </div>
    </div>
  <div class="pics">
      <?php
      $feeds = "SELECT * FROM feeds JOIN users ON feeds.user_id = users.id order by feeds.user_id  desc";
      $feedsrun = mysqli_query($conn, $feeds);


      while ($saves = mysqli_fetch_assoc($feedsrun)) {
          ?>
              <div class="">
                  <div class="card" style="width: 25rem;">
                      <img src="/Feeds/<?php echo $saves['picture'];  ?>" class="card-img-top" alt="...">
                      <div class="card-body">
                          <h5 class="card-title"><?php echo $saves['first_name'];  ?> <?php echo $saves['last_name'];  ?></h5>
                          <p class="card-text">
                              <?php echo $saves['feed'] ?>
                          </p>
                      </div>
                  </div>
              </div>



          <?php
      }
      ?>
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