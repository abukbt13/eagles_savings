<?php
session_start();
include '../connection.php';
if ($_SESSION['role'] != 1) {
    header('Location: ../user/index.php');
    exit(); // It's a good practice to include exit() after header() to ensure no further code execution after redirection
}

if (!isset($_SESSION['user_id'])) {
    session_start();
    $_SESSION['status'] = 'lOGIN TO VIEW THIS PAGE';
    header('Location: ../auth/login.php');
}

if(isset($_POST["addSavings"])) {
    $amount = $_POST['amount'];
    $savings_user_id = $_POST['user_id'];
    $date = $_POST['date'];
    $actual_saved=0.995*$amount;
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
    <title>users </title>
    <link rel="shortcut icon" href="../images/eagle.jpeg">
    <link rel="stylesheet" href="../css/style.css">
</head>
<?php
include "../includes/header.php";
?>
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
        <button class="d-md-none d-lg-none d-sm-block" style="color: blue;border:none;padding-right:0.5rem;margin:0.6rem;font-size: 23px;" onclick="sideBar()">
            <i  class="fa fa-list" aria-hidden="true">
            </i>
        </button>
        <div id="sidebar" class="d-none sidebar_side p-4 d-md-block d-lg-block">

            <h1 class="mb-1 border-bottom">Dashboard</h1>
            <hr>
            <a href="index.php" class="text-uppercase   text-decoration-none"><p>Home</p></a>
            <a href="users.php" class="text-uppercase nav-link active  text-decoration-none"><p>Users</p></a>
            <a href="savings.php" class="text-uppercase  text-decoration-none"><p>savings</p></a>
            <a href="loans.php" class="text-uppercase  text-decoration-none"><p>Loans</p></a>
            <a href="loan_applications.php" class="text-uppercase  text-decoration-none"><p>Loan Applications</p></a>
            <a href="messages.php" class="text-uppercase  text-decoration-none"><p>Messages</p></a>
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
                    <th scope="col">Phone</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $savings = "SELECT * FROM  users";
                $savingsrun = mysqli_query($conn, $savings);
                $id = 1;
                $total = 0;

                while ($saves = mysqli_fetch_assoc($savingsrun)) {
                    ?>
                    <tr>
                        <th><?php echo $id++; ?></th>
                        <th><?php echo $saves['first_name'] ?></th>
                        <th><?php echo $saves['last_name'] ?></th>
                        <th><?php echo $saves['phone'] ?></th>
                        <th>
                            <form action="user_info.php" method="post">
                                <input hidden value="<?php echo $saves['id'] ?>" name="user_id" type="number">
                                <input type="submit" name="user" class="btn btn-primary" value="view">
                            </form>
                            </a>
                        </th>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
                </tbody>

            </table>
        </div>

    </div>


    <script src="../js/admin.js"></script>
    </body>
</html>
