<?php
session_start();
include '../connection.php';
if (!isset($_SESSION['user_id'])) {
    session_start();
    $_SESSION['status'] = 'lOGIN TO VIEW THIS PAGE';
    header('Location:login.php');
}
$savings_user_id = $_SESSION['savings_user_id'];
$weekNumber = $_SESSION['week'];
$saver = "select * from savings  where user_id = $savings_user_id and week = $weekNumber";
$saverrun = mysqli_query($conn, $saver);

$initial_amount=mysqli_fetch_array($saverrun);

$old_amount=$initial_amount['amount'];


if(isset($_POST["update_savings"])) {
    $new_amount = $_POST['new_amount'];
    $date = date('d-m-y');
    $actual_amount=$new_amount+$old_amount;
    $actual=0.995*$actual_amount;

    $update_saving = "update savings set amount = $actual_amount,actual =$actual, date='$date' where user_id= $savings_user_id and week = $weekNumber";
    $update_savingrun = mysqli_query($conn, $update_saving);
    if($update_savingrun){
        $_SESSION['status'] = 'Successfully Updated saved ';
        header('Location:savings.php');
        die();
    }
    else{
        $_SESSION['status'] = 'Error saving the records';
        header('Location:savings.php');
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
    <title>Update savings</title>
    <link rel="shortcut icon" href="/img.jpg">
    <link rel="stylesheet" href="../css/style.css">
</head>
<?php include "../includes/header.php";?>
<div>
    <style>
        .contents{
            width: 100vw;
        }

    </style>
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
    <div class="contents d-flex align-items-center justify-content-center">
        <div  style="width: 23rem;" id="loan" class="loan  rounded">

            <form action="update_savings.php" method="post">
                <h2 class="text-primary" style="text-align: center;">Update Savings Records</h2>


                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Member nbnbName</label>
                    <select name="user_id" id="" class="form-control">
                        <?php $users="select * from users where id = $savings_user_id";
                        $usersrun=mysqli_query($conn,$users);

                        while($allUsers=mysqli_fetch_assoc($usersrun)) {
                            ?>
                            <option value="<?php echo $allUsers['id']; ?>"><?php echo $allUsers['first_name']; echo" "; echo $allUsers['last_name']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Amount in Shillings</label>
                    <input type="number" min="1" class="form-control" name="new_amount">
                </div>


                <button type="submit" name="update_savings" class="btn btn-primary w-100">Add Saving</button>

            </form>
        </div>

    </div>

    </body>


    <script type="application/javascript">
        // const loan = document.getElementById('loan')
        // const close = document.getElementById('close')
        // function showForm() {
        //     loan.style.display = 'block';
        // }
        // function closeBtn() {
        //     loan.style.display = 'none';
        // }

    </script>
</html>
