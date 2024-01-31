<?php
session_start();
include '../connection.php';

include '../includes/session.php';
$user_id= $_SESSION['user_id'];
$last_name = $_SESSION['last_name'] ;
$first_name = $_SESSION['first_name'] ;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    <link rel="shortcut icon" href="../images/eagle.jpg">
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
            <i  class="fa fa-align-left" aria-hidden="true">
            </i>
        </button>
        <div id="sidebar" class="d-none px-4 d-md-block d-lg-block">
            <h5 class="mb-1 border-bottom text-center">Dashboard</h5>
            <a href="index.php" class="text-uppercase  text-decoration-none"><p>Home</p></a>

            <a href="my_savings.php" class="text-uppercase nav-link active text-decoration-none"><p>My savings</p></a>

            <a href="my_loans.php" class="text-uppercase text-decoration-none"><p>My loans</p></a>
            <a href="my_messages.php" class="text-uppercase  text-decoration-none"><p>Messages</p></a>
        </div>


        <div class="table-responsive">
            <table class="table border table-bordered table-striped">
                <thead>
                <tr>
                    <th colspan="5" class="">My savings</th>
                </tr>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Date saved</th>
                    <th scope="col">Week of savings</th>
                    <th scope="col">Operations</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $savings="SELECT * FROM savings JOIN users ON savings.user_id = users.id where user_id=$user_id";
                $savingsrun=mysqli_query($conn,$savings);
                $id=1;
                $total = 0;
                while($saves=mysqli_fetch_assoc($savingsrun)) {
                    ?>
                    <tr>
                        <th><?php echo $id++ ?></th>
                        <th ><?php echo $saves['amount'] ?></th>
                        <td><?php echo $saves['date'] ?></td>
                        <td><?php echo $saves['week'] ?></td>
                        <td><button class="btn btn-success">query</button></td>
                    </tr>
                    <?php
                    $total += $saves['amount']; // Add the amount to the total
                }
                ?>
                <tr>
                    <td colspan="8"><h2>Total savings <span class="float-end"><?php echo $total; ?></span></h2></td>
                </tr>
                </tbody>

            </table>
        </div>

    </div>

    </body>


    <script src="../js/admin.js">

    </script>
</html>
