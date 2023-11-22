<?php
session_start();
include 'header.php';
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>

<body style="background-size: cover;background-color: white;height: 90vh;">
<div class="row d-flex align-items-center justify-content-center">

    <div  style="width: 23rem;" class="form bg-white pt-5 mt-4 mb-3 rounded">
        <form action="processor.php" method="post">
            <h2 class="text-primary" style="text-align: center;">Login Here</h2>
            <?php
            if(isset($_SESSION['status'])){
                ?>
                <div>
                    <p class="text-danger btn-danger p-2"><?php echo $_SESSION['status']; ?> ?</p>
                </div>
                <?php
                unset($_SESSION['status']);
            }
            ?>
            <div class="p-4 pb-5">
                <form method="post" action="processor.php">
                    <p>Dont have an Account?<a class="" href="register.php">Register</a></p>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                    </div>
                    <p>Don't remember password? <a class="" href="forgetpassword.php">Reset</a></p>

                    <div class="d-flex justify-content-between">
                        <button type="submit" name="login" class="btn w-100 btn-primary">Login</button>
                    </div>
                </form>
            </div>
    </div>
</div>
</div>
</body>
</html>
