<?php
session_start();

include '../connection.php';

include '../includes/session.php';

if ($_SESSION['role'] != 1) {
    header('Location: ../user/index.php');
    exit(); // It's a good practice to include exit() after header() to ensure no further code execution after redirection
}

$last_name = $_SESSION['last_name'] ;
$first_name = $_SESSION['first_name'] ;

if(isset($_POST["addSavings"])) {
    $amount = $_POST['amount'];
    $savings_user_id = $_POST['user_id'];
    $date = $_POST['date'];
    $actual_saved=$amount;
    $weekNumber = date('W', strtotime($date));
    $find_ifSaved = "SELECT * FROM savings WHERE user_id = $savings_user_id AND week = $weekNumber";
    $result = mysqli_query($conn, $find_ifSaved); // Make sure to replace $your_db_connection with your actual database connection variable

    $exist_saving = mysqli_num_rows($result);

//    if ($exist_saving > 0) {
//        $_SESSION['status'] = 'Savings already done, please update savings';
//        $_SESSION['savings_user_id'] = $savings_user_id;
//        $_SESSION['week'] = $weekNumber;
//        header('Location: update_savings.php');
//        exit(); // It's good practice to include exit() after header() to ensure no further code execution after redirection
//    }
//    else{
        $save = "insert into savings(amount,actual,user_id,week,date) values('$amount','$actual_saved','$savings_user_id','$weekNumber','$date')";
        $res = mysqli_query($conn, $save);
        if($res){

            $_SESSION['status'] = 'Successfully saved ';
            header('Location:savings.php');
            die();
        }
        else{
            $_SESSION['status'] = 'Error saving the records';
            die();
        }
//    }
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
    <link rel="shortcut icon" href="../images/eagle.jpg">
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
            <table class="table  border table-bordered table-striped">
                <thead>
                <tr>
                    <th colspan="9" class=""><div class=" d-flex align-items-center justify-content-between">
                            This savings
                            <button class="btn btn-primary float-end" onclick="showForm()">Add savings</button>
                        </div> </th>
                </tr>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Savings</th>
                    <th scope="col">Actual savings</th>
                    <th scope="col">Date</th>
                    <th scope="col">Week</th>
                    <th colspan="1" scope="col">Operations</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $week = date('W');
                $savings = "SELECT * FROM savings JOIN users ON savings.user_id = users.id order by savings.savings_id  desc";
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
                        <th><?php echo $saves['actual'] ?></th>
                        <th><?php echo $saves['date'] ?></th>
                        <th><?php echo $saves['week'] ?></th>
                        <th>
                            <form action="user_info.php" method="post">
                                <input hidden value="<?php echo $saves['user_id'] ?>" name="user_id" type="number">
                                <input type="submit" name="user" class="btn btn-primary" value="view">
                            </form>
                        </th>
                    </tr>
                    <?php
                    $total += $saves['amount']; // Add the amount to the total
                }
                ?>
                <tr>
                    <td colspan="8"><h2>Total savings <span class="float-end"><?php echo $total; ?></span></h2></td>
                </tr>
                </tbody>
                </tbody>

            </table>
        </div>

    </div>
    <div id="loan" class="loan  rounded">

        <form action="savings.php" method="post">
            <h2 class="text-primary" style="text-align: center;">Savings Records</h2>
            <button onclick="closeBtn()" class="float-end">&times;</button>

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
                <input type="number" min="1" required class="form-control" name="amount">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Date</label>
                <input type="date" min="1" required class="form-control" name="date">
            </div>


            <button type="submit" name="addSavings" class="btn btn-primary w-100">Add Saving</button>

        </form>
    </div>

    <script src="../js/admin.js"></script>
    </body>
</html>
