<?php
session_start();
$last_name = $_SESSION['last_name'] ;
$first_name = $_SESSION['first_name'] ;
include 'connection.php';
if ($_SESSION['role'] != 1) {
    header('Location: dashboard.php');
    exit(); // It's a good practice to include exit() after header() to ensure no further code execution after redirection
}

if (!isset($_SESSION['user_id'])) {
    session_start();
    $_SESSION['status'] = 'lOGIN TO VIEW THIS PAGE';
    header('Location:login.php');
}

if(isset($_POST["update_savings"])) {
    $amount = $_POST['amount'];
    $savings_user_id = $_POST['user_id'];
    $date = date('d-m-y');
    $weekNumber = date('W');

    $find_ifSaved = "SELECT * FROM savings WHERE user_id = $savings_user_id AND week = $weekNumber";
    $result = mysqli_query($conn, $find_ifSaved); // Make sure to replace $your_db_connection with your actual database connection variable

    $exist_saving = mysqli_num_rows($result);

    if ($exist_saving > 0) {
        $_SESSION['status'] = 'Savings already done, please update savings';
        $_SESSION['savings_user_id'] = $savings_user_id;
        header('Location: update_savings.php');
        exit(); // It's good practice to include exit() after header() to ensure no further code execution after redirection
    }

    else{
        $save = "insert into savings(amount,user_id,week,date) values('$amount','$savings_user_id','$weekNumber','$date')";
        $res = mysqli_query($conn, $save);
        if($res){
            $_SESSION['status'] = 'Successfully saved ';
            header('Location:dashboardadmin.php');
        }
    }
}

include "header.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    <link rel="shortcut icon" href="/img.jpg">
    <link rel="stylesheet" href="../css/style.css">
</head>
<div>
    <style>
        .sidebar{
            background: yellow;
            display: block;
            position: absolute;
            left: 2rem;
            top: 1rem;
        }

        .loan{
            width: 23rem;
            position: absolute;
            top: 5rem;
            left: 15rem;
            background: grey;
            z-index: 0.2;
            padding: 2rem;
            display: none;
        }
        @media (min-width: 300px) and (max-width: 600px) {
            .loan {
                width: 16rem;
                position: absolute;
                top: 2rem;
                left: 2rem;
                background: grey;
                z-index: 0.2;
                padding: 2rem;
                display: none;
            }
        }
        .sidebar_side a:hover{
            background: ;
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
    <div class="contents  d-md-flex d-lg-flex">
        <button onclick="sideBar()" class="btn btn-primary d-block d-md-none d-lg-none">Show Sidebar</button>
        <div id="sidebar" class="d-none sidebar_side p-4 d-md-block d-lg-block">

            <h1 class="mb-1">Dashboard</h1>
            <hr>
            <h3>Savings</h3>
            <a href="../admin/dashboardadmin.php" class="text-uppercase text-decoration-none"><p>Home</p></a>
            <a href="../savings/all_saving.php" class="text-uppercase   text-decoration-none"><p>All savings</p></a>
            <h3>Loans</h3>
            <a href="../loans/loans/all_loans.php" class="text-uppercase   text-decoration-none"><p>all loans</p></a>
            <a href="loan_application.php" class="text-uppercase  text-decoration-none"><p>Loan Applications</p></a>
            <h2>Events</h2>
            <a href="events.php" class="text-uppercase nav-link nav-active  text-decoration-none"><p>Recent Events</p></a>
            <h3>Plans And Activities</h3>
            <a href="plans.php" class="text-uppercase text-decoration-none"><p>Plans</p></a>
        </div>


        <div class="table-responsive">
            <table class="table  border table-bordered table-striped">
                <thead>
                <tr>
                    <th colspan="7" class=""><div class=" d-flex align-items-center justify-content-between">
                            This savings
                            <button class="btn btn-primary float-end" onclick="showForm()">Add savings</button>
                        </div> </th>
                </tr>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Savings</th>
                    <th scope="col">Date</th>
                    <th scope="col">Week</th>
                    <th scope="col">Operation</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $week=date('W');
                $savings="SELECT * FROM savings JOIN users ON savings.user_id = users.id where week = $week";
                $savingsrun=mysqli_query($conn,$savings);
                $id=1;
                while($saves=mysqli_fetch_assoc($savingsrun)) {
                    ?>
                    <tr>
                        <th><?php echo $id++; ?></th>
                        <th><?php echo $saves['first_name']?></th>
                        <th><?php echo $saves['last_name']?></th>
                        <th><?php echo $saves['amount']?></th>
                        <th><?php echo $saves['date']?></th>
                        <th><?php echo $saves['week']?></th>

                        <th scope="col"><button class="btn btn-primary float-end">Edit</button></th></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>

            </table>
        </div>

    </div>

    </body>


    <div id="loan" class="loan  rounded">
        <button type="button" onclick="closeBtn()" class="btn-close float-end" aria-label="Close"></button>

        <form action="../admin/dashboardadmin.php" method="post">
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


            <button type="submit" name="update_savings" class="btn btn-primary w-100">Add Saving</button>

        </form>
    </div>
    <script src="../js/admin.js">

    </script>
</html>
