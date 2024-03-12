<?php
session_start();
include 'connection.php';

if(isset($_POST["feedback"])) {
    if (!$_SESSION['user_id']) {
        $_SESSION['status'] = 'Login first to upload feedback';
        header('Location: media.php');
        exit(); // It's a good practice to include exit() after header() to ensure no further code execution after redirection
    }

    $user_id =$_SESSION['user_id'];
    $feed = $_POST["feed"];
    $picture= $_FILES['picture']['name'];
    $picture_tmp = $_FILES['picture']['tmp_name'];
    $picture_name = rand(0,100).$picture;
    if ($feed == "" || $picture == "" ){
        $_SESSION['status'] = 'All fields are required';
        header('Location: media.php');
        exit();
    }
    $savefeed = "insert into feeds (feed, picture,user_id) values('$feed','$picture_name','$user_id')";
    $savefeedrun = mysqli_query($conn, $savefeed);
    if ($savefeedrun){
        move_uploaded_file($picture_tmp,"Feeds/". $picture_name);
        $_SESSION['status'] = 'Feed Added successfully';
        header("location:media.php");
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
            <p class="text-white text-uppercase bg-success p-2"><?php echo $_SESSION['status']; ?></p>
        </div>
        <?php
        unset($_SESSION['status']);
    }
    ?>
        <div style="background-color: #4272f5;" class="d-flex justify-content-center align-items-center">
         <div class="">
             <p>Unlocking infinite possibilities through savings and investments </p>
             <p>Share a happy moment with us here <button id="getstarted" class=" btn btn-success">Get started</button></p>
         </div>
        </div>
        <div id="post"  class=" post">
            <button id="close" class="btn float-end btn-danger">close</button>
            <br>
            <br>
            <form action="media.php" method="post" enctype="multipart/form-data">
               <div class="">
                   <div class="mx-2">
                       <label for="feed">Tell us something about eagle or any motivation</label>
                       <textarea name="feed" required rows="4" class="form-control"></textarea>

                   </div>
                   <div class="mx-1 ">
                       <label for="" class="mt-1">Upload Your picture</label>
                       <input type="file" required name="picture" class="form-control" placeholder="Upload your favorite picture">
                       <button type="submit" name="feedback" class="btn my-4  btn-primary" >Post feed</button>

                   </div>
               </div>

            </form>
        </div>

  <div class="pics d-flex align-items-center">
     <div class="exact">
         <?php
         $feeds = "SELECT * FROM feeds JOIN users ON feeds.user_id = users.id order by feeds.user_id  desc";
         $feedsrun = mysqli_query($conn, $feeds);

         while ($saves = mysqli_fetch_assoc($feedsrun)) {
             ?>

                 <div class="card m-1">
                     <img src="/Feeds/<?php echo $saves['picture'];  ?>" class="card-img-top" alt="...">
                     <div class="card-body">
                         <h5 class="card-title"><?php echo $saves['first_name'];  ?> <?php echo $saves['last_name'];  ?></h5>
                         <p class="card-text">
                             <?php echo $saves['feed'] ?>
                         </p>
                         <a href="edit_media.php?id=<?php echo $saves['feed_id'] ?>">More details</a>
                     </div>
                 </div>




             <?php
         }
         ?>
     </div>
  </div>
</div>
<style>
    .post{
        width:35rem;
        position: absolute;
        top: 2rem;
        z-index:1;
        left: 18rem;
        background-color: #4272f5;
        color: white;
        padding: 2rem;
        display: none;
    }
   
    .exact{
        display:grid;
        grid-template-columns: 1fr 1fr 1fr;
    }
    @media (max-width: 576px) {
        /* CSS rules for small devices */
        .exact{
            display:grid;
            grid-template-columns: 1fr;
        }
        .post{
            width: 90vw;
            position: absolute;
            top: 2rem;
            z-index:1;
            left: 0.5rem;
            background-color: #4272f5;
            color: white;
            display: none;
        }
    }
    /*!* Medium devices (landscape phones, tablets) *!*/
    /*@media (min-width: 577px) and (max-width: 768px) {*/
    /*    !* CSS rules for medium devices *!*/
    /*}*/

    /*!* Large devices (laptops, desktops) *!*/
    /*@media (min-width: 769px) {*/
    /*    !* CSS rules for large devices *!*/
    /*}*/

</style>
<script>
    const getstarted = document.getElementById('getstarted');
    const post = document.getElementById('post');
    const close = document.getElementById('close');
    getstarted.addEventListener('click', function(){
        post.style.display = 'block';
    })
    close.addEventListener('click', function(){
        post.style.display = 'none';
    })
</script>
</body>
</html>