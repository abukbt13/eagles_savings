<?php
include '../connection.php';
session_start();


?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body style="background-size: cover;background-color: white;height: 90vh;">
<?php
include '../includes/header.php';
?>
<div class="row d-flex align-items-center justify-content-center">

    <div  style="width: 23rem;" class="form bg-white pt-5 mt-4 mb-3 rounded">

            <h2 class="text-primary" style="text-align: center;">Verify account</h2>
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
         <form method="post" action="../processor.php" >
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Enter OTP you received</label>
                        <input type="number" name="otp" class="form-control" >
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" name="verify" class="btn w-100 btn-primary">Verify </button>
                    </div>
        </form>
            </div>

    </div>
</div>
</div>
</body>
</html>
