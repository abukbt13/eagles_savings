<?php
session_start();
$last_name = $_SESSION['last_name'] ;
$first_name = $_SESSION['first_name'] ;
include '../connection.php';
if ($_SESSION['role'] != 1) {
    header('Location: dashboard.php');
    exit(); // It's a good practice to include exit() after header() to ensure no further code execution after redirection
}

if (!isset($_SESSION['user_id'])) {
    session_start();
    $_SESSION['status'] = 'lOGIN TO VIEW THIS PAGE';
    header('Location:login.php');
}

if(isset($_POST["add_loan"])) {
    $amount = $_POST['amount'];
    $savings_user_id = $_POST['user_id'];
    $date = $_POST['date'];
    $weekNumber = date('W', strtotime($date));
    $save = "insert into loans(amount,user_id,week,date_borrowed) values('$amount','$savings_user_id','$weekNumber','$date')";
    $res = mysqli_query($conn, $save);
    if($res){
        $_SESSION['status'] = 'Loan added successfully';
        header('Location:all_loans.php');
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
    <title>messages</title>
    <link rel="shortcut icon" href="/img.jpg">
    <link rel="stylesheet" href="../../css/style.css">
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

            <a href="index.php" class="text-uppercase   text-decoration-none"><p>Home</p></a>
            <a href="users.php" class="text-uppercase   text-decoration-none"><p>Users</p></a>
            <a href="savings.php" class="text-uppercase  text-decoration-none"><p>savings</p></a>
            <a href="loans.php" class="text-uppercase  text-decoration-none"><p>Loans</p></a>
            <a href="groupsmoney.php" class="text-uppercase  text-decoration-none"><p>Groups Money</p></a>
            <a href="loan_applications.php" class="text-uppercase  text-decoration-none"><p>Loan Applications</p></a>
            <a href="messages.php" class="text-uppercase nav-link nav-active  text-decoration-none"><p>Messages</p></a>
        </div>


        <div class="table-responsive">
            <table class="table  border table-bordered table-striped">
                <thead>
                <tr>
                    <th colspan="7" class=""><div class=" d-flex align-items-center justify-content-between">
                            <h2>Messages</h2>

                        </div> </th>
                </tr>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Message</th>
                    <th scope="col">Date</th>
                    <th scope="col">Operation</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $week=date('W');
                $savings="SELECT * FROM messages JOIN users ON messages.user_id = users.id";
                $savingsrun=mysqli_query($conn,$savings);
                $id=1;
                while($saves=mysqli_fetch_assoc($savingsrun)) {
                    ?>
                    <tr>
                        <th><?php echo $id++; ?></th>
                        <th><?php echo $saves['first_name']?></th>
                        <th><?php echo $saves['last_name']?></th><th>
                            <p><?php echo implode(' ', array_slice(str_word_count($saves['message'], 1), 0, 10));echo "....."; ?></p>
                        </th>

                        <th><?php echo $saves['date']?></th>

                        <th scope="col">
                            <button class="btn btn-primary float-end">view</button>
                        </th>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>

            </table>
        </div>

    </div>

    </body>


    <script src="../../js/admin.js">
    </script>
</html>
