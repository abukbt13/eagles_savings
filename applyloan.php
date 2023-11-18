<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Apply loan</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
include 'header.php'
?>
<div class="row d-flex align-items-center justify-content-center">

    <div  style="width: 23rem;" class="p-5 mb-5 bg-white pt-5 mt-4 mb-3 rounded">
        <form action="processor.php" method="post">
            <h2 class="text-primary" style="text-align: center;">Apply Loan</h2>
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

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Amount</label>
                <input type="number" name="amount" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Type of loan</label>
                <select name="type_of_loan" id="" class="form-control">
                    <option value="long_loan">Long term Loan</option>
                    <option value="short_loan">Short term Loan</option>
                    <option value="emergency_loan">Emergency loan</option>
                </select>
            </div>


            <button type="submit" name="register" class="btn btn-primary w-100">Apply Now </button>

        </form>
    </div>
</div>
</div>
</body>
</html>