<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Eagles Savings</title>
    <link rel="shortcut icon" href="images/eagle.jpeg">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<style>



    .main {
        width: 100%;
        height: 28rem;
        background-image: url('images/eagle1.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center; /* Center the background image both horizontally and vertically */
    }


</style>
<?php include 'includes/header.php' ?>

 <div  class="main d-flex flex-column align-items-center justify-content-center">
   <div class="main-section">
       <h1 style="text-align: center; font-size: 22px; color:white;">Eagles Savings</h1>
       <h5 style="font-size: 22px;center; color: white;text-shadow: white;">Securing your future through savings</h5>
       <div class="d-flex justify-content-center">
           <a href="auth/register.php" style="background: rgb(252, 182, 3)" class="btn text-white bg-primary">Join our community</a></div>
   </div>
 </div>

<?php include 'includes/footer.php' ?>
</body>
</html>