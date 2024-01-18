<?php
session_start();

include '../includes/session.php';
if ($_SESSION['role'] != 1) {
    header('Location: ../user/index.php');
    exit(); // It's a good practice to include exit() after header() to ensure no further code execution after redirection
}
$last_name = $_SESSION['last_name'] ;
$first_name = $_SESSION['first_name'] ;
include '../connection.php';
if(isset($_POST["update_savings"])) {
    $amount = $_POST['amount'];
    $savings_user_id = $_POST['user_id'];
    $date = $_POST['date'];
    $weekNumber = date('W', strtotime($date));
    $find_ifSaved = "SELECT * FROM savings WHERE user_id = $savings_user_id AND week = $weekNumber";
    $result = mysqli_query($conn, $find_ifSaved); // Make sure to replace $your_db_connection with your actual database connection variable

    $exist_saving = mysqli_num_rows($result);

    if ($exist_saving > 0) {
        $_SESSION['status'] = 'Savings already done, please update savings';
        $_SESSION['savings_user_id'] = $savings_user_id;
        $_SESSION['week'] = $weekNumber;
        header('Location: update_savings.php');
        exit(); // It's good practice to include exit() after header() to ensure no further code execution after redirection
    }
    else{
        $save = "insert into savings(amount,actual,user_id,week,date) values('$amount','$amount','$savings_user_id','$weekNumber','$date')";
        $res = mysqli_query($conn, $save);
        if($res){
            $_SESSION['status'] = 'Successfully saved ';
            header('Location:index.php');
        }
        else{
            $_SESSION['status'] = 'Error saving the records';
            header('Location:index.php');
            die();
        }
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
    <title>All savings</title>
    <link rel="shortcut icon" href="../images/eagle.jpg">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<?php
include "../includes/header.php";
?>

    <?php
    if(isset($_SESSION['status'])){
        ?>
        <div>
            <p class="text-white bg-danger btn-success p-2"><?php echo $_SESSION['status']; ?> ?</p>
        </div>
        <?php
        unset($_SESSION['status']);
    }
    ?>
    <div class="contents  d-md-flex d-lg-flex">
        <?php include 'sidebar.php'?>

        <div  style="" class="main">
            <div  class="main_content">
                <h2 class="text-uppercase">savings</h2>
                <p>  <?php
                    $sql = "SELECT SUM(actual) AS total_amount FROM savings";
                    $res = mysqli_query($conn, $sql);
                    // Fetch the result
                    $row = mysqli_fetch_assoc($res);
                    $totalAmount = $row["total_amount"];
                    if($totalAmount>0){
                        // Output the total amount
                        echo "Total savings: " . $totalAmount;
                    }
                    else{
                        echo "You have not saved anything ";
                    }
                    ?></p>
                <a href="savings.php" class="btn btn-primary">More ...</a>
            </div>
            <div class="main_content">
                <h2 class="text-uppercase">Loan</h2>
                <p><?php
                    $sql = "SELECT SUM(loan_amount) AS total_amount FROM loans";
                    $res = mysqli_query($conn, $sql);
                    // Fetch the result
                    $row = mysqli_fetch_assoc($res);
                    $totalAmount = $row["total_amount"];
                    if($totalAmount>0){
                        // Output the total amount
                        echo "Total Loans: " . $totalAmount;
                    }
                    else{
                        echo "You have not saved anything ";
                    }
                    ?>
                </p>
                <button class="btn btn-primary">More ...</button>
            </div>

        </div>

    </div>
    <div id="loan" class="loan  rounded">
        <button type="button" onclick="closeBtn()" class="btn-close float-end" aria-label="Close"></button>

        <form action="index.php" method="post">
            <h2 class="text-primary" style="text-align: center;">Savings Records</h2>


            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Member Name</label>
                <select name="user_id" id="" class="form-control">
                    <?php $users="select * from users";
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
                <input type="number" min="1" class="form-control" name="amount">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Date</label>
                <input type="date" min="1" class="form-control" name="date">
            </div>


            <button type="submit" name="update_savings" class="btn btn-primary w-100">Add Saving</button>

        </form>
    </div>

    <script src="../js/admin.js"></script>
    </body>
</html>
