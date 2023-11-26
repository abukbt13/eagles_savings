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
    <link rel="stylesheet" href="css/style.css">
</head>
<?php
include "header.php";
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
        <button onclick="sideBar()" class="btn btn-primary d-block d-md-none d-lg-none">Show Sidebar</button>
        <div id="sidebar" class="d-none px-4 d-md-block d-lg-block">
            <h5 class="mb-1">Dashboard</h5>
            <hr>
            <h2>Savings</h2>
            <a href="dashboard.php" class="text-uppercase text-decoration-none"><p>This weeks</p></a>
            <a href="all_my_savings.php" class="text-uppercase nav-link active text-decoration-none"><p>all_my_savings</p></a>
            <h2>Loans</h2>
            <a href="myloans.php" class="text-uppercase text-decoration-none"><p>My loans</p></a>
            <a href="applyloan.php" class="text-uppercase text-decoration-none"><p>Apply loan</p></a>
            <h2>Loans</h2>
            <a href="myloans.php" class="text-uppercase text-decoration-none"><p>My loans</p></a>
            <a href="applyloan.php" class="text-uppercase text-decoration-none"><p>Apply loan</p></a>
        </div>


        <div class="table-responsive">
            <table class="table border table-bordered table-striped">
                <thead>
                <tr>
                    <th colspan="5" class="text-center">All savings</th>
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


    <script src="admin.js">

    </script>
</html>
