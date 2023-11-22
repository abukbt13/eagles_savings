<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'header.php';?>
<div class="row d-flex align-items-center justify-content-center">

    <div  style="width: 23rem;" class="p-5 mb-5 bg-white pt-5 mt-4 mb-3 rounded">
        <form action="processor.php" method="post">
            <h2 class="text-primary" style="text-align: center;">Register Here</h2>
            <?php
            if(isset($_SESSION['status'])){
                ?>
                <div>
                    <p class="text-white bg-danger btn-danger p-2"><?php echo $_SESSION['status']; ?> ?</p>
                </div>
                <?php
                unset($_SESSION['status']);
            }
            ?>
            <p class="text-center text-uppercase" >Already have an account? <a  href="login.php">Click here</a></p>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">First Name</label>
                <input type="text" name="fname" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Last Name</label>
                <input type="text" name="lname" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Phone number</label>
                <input type="number" name="phone" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Confirm Password</label>
                <input type="password" name="password2" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>


            <button type="submit" name="register" class="btn btn-primary w-100">Signup </button>

        </form>
    </div>
</div>
</body>
</html>