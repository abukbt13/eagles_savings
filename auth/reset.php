<?php
session_start();
$email=$_GET['email'];
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
<p>
</p>
<div class="main_content"><div class="row d-flex align-items-center justify-content-center">

        <div  style="width: 23rem;" class="form bg-white pt-5 mt-4 mb-3 rounded">



            <div class="p-4 pb-5">
                <form method="post" action="auth_processor.php" >
                    <?php
                    if(isset($_SESSION['status'])){
                        ?>
                        <div>
                            <h2 style="background-color: yellow;color: black;"><?php echo $_SESSION['status']; ?> !</h2>
                        </div>
                        <?php
                        unset($_SESSION['status']);
                    }
                    ?>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">ENTER OTP RECEIVED IN PHONE</label>
                        <input type="number" name="otp" class="form-control">
                    </div>
                    <p class="text-primary" style="text-align: center;">NOW RESET PASSWORD</p>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Enter new Password</label>
                        <input type="password" name="password" class="form-control" >
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Confirm new Password</label>
                        <input type="password" name="c_password" class="form-control">
                        <input type="email" hidden name="email" class="form-control" value="<?php echo $email?>">
                    </div>


                    <div class="d-flex justify-content-between">
                        <button type="submit" name="reset" class="btn w-100 btn-primary">Reset </button>
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