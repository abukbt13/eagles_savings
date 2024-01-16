<?php
session_start();

include '../connection.php';

include '../includes/session.php';

if ($_SESSION['role'] != 1) {
    header('Location: ../user/index.php');
    exit(); // It's a good practice to include exit() after header() to ensure no further code execution after redirection
}
//global $saving_id;
if(isset($_GET['id']) && isset($_GET['editinfo'])){
    $saving_id = $_GET['id'];
    $edit_info = $_GET['editinfo'];
}


if(isset($_POST["update_savings"])) {
    $id=$_POST["id"];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $update_save = "update savings set date='$date',amount='$amount' where savings_id=$id";
    $result = mysqli_query($conn, $update_save); // Make sure to replace $your_db_connection with your actual database connection variable
    if($result){
        $_SESSION['status'] = 'Updated successfully';
        header('Location:users.php');
        die();
    }{
        $_SESSION['status'] = 'something went wrong try again';
        header('Location:users.php');
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
    <title>Savings</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="shortcut icon" href="../images/eagle.jpeg">
    <link rel="stylesheet" href="../css/style.css">
</head>
<?php
include "../includes/header.php";
?>
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
<div class="contents  d-md-flex d-lg-flex">
    <?php include 'sidebar.php' ?>
    <div class="table-responsive">

        <h2 class="text-primary" style="text-align: center;"> Edit Record</h2>
        <form action="edit_savings.php" method="post">

          <?php  $savings = "SELECT * FROM savings  where savings_id= '$saving_id' ";
            $savingsrun = mysqli_query($conn, $savings);



            while ($saves = mysqli_fetch_assoc($savingsrun)) {
            ?>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Amount in Shillings</label>
                    <input type="number" min="1" value="<?php echo $saves['amount'] ?>" required class="form-control" name="amount">
                    <input type="number" hidden min="1" value="<?php echo $saving_id?>" required class="form-control" name="id">
                </div>

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Date</label>
                    <input type="date"  required class="form-control" value="<?php echo $saves['date'] ?>" name="date">
                </div>
            <?php
            }
                ?>





            <button type="submit" name="update_savings" class="btn btn-primary w-100">Update Saving</button>

        </form>
    </div>

</div>


<script src="../js/admin.js"></script>
</body>
</html>
