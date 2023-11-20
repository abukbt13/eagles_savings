<?php
session_start();
include 'connection.php';
if (!isset($_SESSION['user_id'])) {
    session_start();
    $_SESSION['status'] = 'lOGIN TO VIEW THIS PAGE';
    header('Location:login.php');
}
$user_id= $_SESSION['user_id'];
$last_name = $_SESSION['last_name'] ;
$first_name = $_SESSION['first_name'] ;
include "header.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link rel="shortcut icon" href="/img.jpg">
    <link rel="stylesheet" href="css/style.css">
</head>
<div>
    <style>
        .contents{
            display: flex;
        }
        .sidebar{
            width: 13rem;
            height: 100vh;
        }
    </style>

    <div class="contents">
        <div class="sidebar px-2 bg-light">

            <h4 class="mb-1 text-uppercase" id="offcanvasExampleLabel">MY Dashboard</h4>
            <hr>

            <h4><?php echo $first_name; echo " "; echo $last_name ;?></h4>
            <button class="btn btn-sm btn-secondary">Edit your profile</button>
            <hr>

            <a href="#" class="text-uppercase"><p>My savings</p></a>
            <a href="#" class="text-uppercase"><p>My loans</p></a>
            <a href="#" class="text-uppercase"><p>Events</p></a>
            <a href="applyloan.php" class="text-uppercase"><p>Apply loan</p></a>
        </div>
        <div class="data">
            <table class="table border table-bordered table-striped">
                <thead>
                <tr>
                    <th colspan="4" class="text-center">All savings</th>
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
                }
                ?>

                </tbody>

            </table>
        </div>
    </div>

    </body>
</html>
