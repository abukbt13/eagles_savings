<?php

session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
</head>
<body>
<?php
include '../includes/header.php';
?>

<style>
    .main{
        width: 15rem;
        background-color: rgb(123,22,222);
        padding: 2rem;
    }
    .main_content{
        display: grid;
        justify-content: center;
        align-items: center;
        width: 100vw;
        height: 100vh;
    }
</style>
<p>  <?php
    if(isset($_SESSION['status'])){
    ?>
<div>
    <h2><?php echo $_SESSION['status']; ?></h2>
</div>
<?php
unset($_SESSION['status']);
}
?>
</p>
<div class="main_content"><div class="row d-flex align-items-center justify-content-center">

        <div  style="width: 23rem;" class="form bg-white pt-5 mt-4 mb-3 rounded">

            <h2 class="text-primary" style="text-align: center;">Change Password</h2>
            <?php
            if(isset($_SESSION['status'])){
                ?>
                <div>
                    <p style="background-color:#ecfc05; " class="p-2"><?php echo $_SESSION['status']; ?> ?</p>
                </div>
                <?php
                unset($_SESSION['status']);
            }
            ?>
            <div class="p-4 pb-5">
                <form method="post" action="auth_processor.php" >
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Enter Your Email</label>
                        <input type="email" name="email" class="form-control" >
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" name="reset_password" class="btn w-100 btn-primary">Verify </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
</div>

</body>
</html>
<html>