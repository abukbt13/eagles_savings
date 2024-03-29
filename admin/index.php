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
            <p class="text-white text-uppercase bg-primary p-2"><?php echo $_SESSION['status']; ?>,<?php echo $last_name ?>!</p>
        </div>
        <?php
        unset($_SESSION['status']);
    }
    ?>
<style>
    .reports{
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content:center;
        background-color:darkorange;
        border: 1px solid;
        margin:  10px 10px 10px 10px;
    }
</style>
    <div class="contents  d-md-flex d-lg-flex">
        <?php include 'sidebar.php'?>

        <div  style="">
            <div class="d-flex">
                <div style="background-color: #20c997;padding: 1rem;"  class="main_content">
                    <h2 class="text-uppercase text-primary">savings</h2>
                    <p>  <?php
                        $sql = "SELECT SUM(actual) AS total_amount FROM savings";
                        $res = mysqli_query($conn, $sql);
                        // Fetch the result
                        $row = mysqli_fetch_assoc($res);
                        $totalsavings = $row["total_amount"];
                        if($totalsavings>0){
                            // Output the total amount
                            echo "Total savings:  . <span style='color: dodgerblue;'>$totalsavings</span>";
                        }
                        else{
                            echo "You have not saved anything ";
                        }
                        ?></p>
                    <a href="savings.php" class="btn btn-primary">More ...</a>
                </div>
                <div style="background-color: darkorange;padding: 1rem;" class="main_content">
                    <h2 class="text-uppercase">Loan</h2>
                    <p><?php
                        $sql = "SELECT SUM(loan_amount) AS total_amount FROM loans";
                        $res = mysqli_query($conn, $sql);
                        // Fetch the result
                        $row = mysqli_fetch_assoc($res);
                        $totalloans = $row["total_amount"];
                        if($totalloans>0){
                            // Output the total amount
                            echo "Total Loans:   . <span style='color: white;'>$totalloans</span>";

                        }
                        else{
                            echo "You have not saved anything ";
                        }
                        ?>
                    </p>
                    <a href="loans.php" class="btn btn-primary">More ...</a>
                </div>
                <div  class="main_content bg-primary p-2">
                    <h5 class="text-uppercase">Paid Loans</h5>
                    <p><?php
                        $sql = "SELECT SUM(paid_amount) AS total_amount FROM loans";
                        $res = mysqli_query($conn, $sql);
                        // Fetch the result
                        $row = mysqli_fetch_assoc($res);
                        $paidloans = $row["total_amount"];
                        if($paidloans>0){
                            // Output the total amount
                            echo "Total paid Loans: " ;
                            echo "<h5 class='text-primary text-white'>$paidloans</h5>";
                        }
                        else{
                            echo "You have not saved anything ";
                        }
                        echo "<br>";
                        echo "Unpaid loans :";
                        $unpaidloan = $totalloans-$paidloans;
                        echo "<h5 class='text-primary text-white'>$unpaidloan</h5>";
                        ?>
                    </p>

                </div>
                <div style="background-color: #20c997;padding: 1rem;" class="main_content">

                        <?php
                        $sql = "SELECT SUM(amount) AS total_amount FROM groups_money";
                        $res = mysqli_query($conn, $sql);
                        // Fetch the result
                        $row = mysqli_fetch_assoc($res);
                        $groupsmoney = $row["total_amount"];
                        if($groupsmoney>0){
                            // Output the total amount
                            echo "<h5>Groups Money</h5>";
                            echo "<p class='text-primary'>=KSH. $groupsmoney</p>";
                        }
                        else{
                            echo "You have not saved anything ";
                        }

                        $sql1 = "SELECT SUM(amount) AS total_amount FROM groups_expenditure";
                        $res1 = mysqli_query($conn, $sql1);
                        // Fetch the result
                        $row1 = mysqli_fetch_assoc($res1);
                        $expenditure = $row1["total_amount"];


                        echo "Expenditure: ";
                        echo "<p class='text-primary'>=KSH. $expenditure</p>";

                        // Assuming you have a variable $totalBudget holding the total budget amount
                        $balance_groupmoney = $groupsmoney - $expenditure;
                        echo "Balance: KSH. ";
                        echo "<span class='text-primary'>$balance_groupmoney</span>";

                        ?>

                </div>
            </div>
            <div style="font-size: 23px;" class="bg-secondary text-white text-uppercase p-3">
                Expected Bank balance Amount
                <span class="float-end  p-1">
                     ksh.
                      <?php
                      $total_all_balance=$totalsavings+$balance_groupmoney-$unpaidloan;
                      echo $total_all_balance;
                      ?>
                </span>

            </div>
     <div class="reports">
        <div class="p-4">
            <h4 class="text-uppercase text-center">Reports</h4>
            <div class="" role="group" aria-label="Basic mixed styles example">
                <a href="reports/savings.php" type="button" class="btn btn-primary">Savings</a>
                <a href="reports/groups_money.php" type="button" class="btn btn-success">Groups money</a>
                <a href="reports/loans.php" type="button" class="btn btn-info mx-2">Loans</a>
                <a href="reports/loans_payment.php" type="button" class="btn btn-success">Loan Payments</a>
            </div>
        </div>
     </div>
     <div class="table-responsive">
                <table class="table  border table-bordered table-striped">
                    <thead>
                    <tr>
                        <th colspan="7" class=""><div class=" d-flex align-items-center justify-content-between">
                                Latest  savings records <a href="report.php" class="btn btn-primary">Generate report</a>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $savings = "SELECT * FROM savings JOIN users ON savings.user_id = users.id order by savings.savings_id  desc limit 10";
                    $savingsrun = mysqli_query($conn, $savings);
                    $id = 1;
                    $total = 0;

                    while ($saves = mysqli_fetch_assoc($savingsrun)) {
                        ?>
                        <tr>
                            <th><?php echo $id++; ?></th>
                            <th><?php echo $saves['first_name'] ?></th>
                            <th><?php echo $saves['last_name'] ?></th>
                            <th><?php echo $saves['amount'] ?></th>
                            <th><?php echo $saves['date'] ?></th>

                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                    </tbody>

                </table>
            </div>

        </div>

    </div>


    <script src="../js/admin.js"></script>
    </body>
</html>
