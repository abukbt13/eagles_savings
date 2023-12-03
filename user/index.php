<?php
session_start();
include '../connection.php';
if (!isset($_SESSION['user_id'])) {
    session_start();
    $_SESSION['status'] = 'lOGIN TO VIEW THIS PAGE';
    header('Location:../auth/login.php');
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
    <link rel="shortcut icon" href="../images/eagle1.webp">
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
        .main{
            display: grid;grid-template-columns: 1fr 1fr 1fr;
        }
        .main_content{
            border: 1px solid pink;
            margin: 0.4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
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
            <i  class="fa fa-list" aria-hidden="true">
            </i>
        </button>
        <div id="sidebar" class="d-none px-4 d-md-block d-lg-block">

<!--            <div class="float-end">-->
<!--                <i  class="fa fa-list" aria-hidden="true">-->
<!--                </i>-->
<!--            </div>-->
            <h5 class="mb-1 border-bottom text-center">Dashboard</h5>
            <a href="index.php" class="text-uppercase nav-link active text-decoration-none"><p>Home</p></a>

            <a href="my_savings.php" class="text-uppercase  text-decoration-none"><p>My savings</p></a>

            <a href="my_loans.php" class="text-uppercase text-decoration-none"><p>My loans</p></a>
            <a href="my_messages.php" class="text-uppercase  text-decoration-none"><p>Messages</p></a>
        </div>

        <div  style="" class="main">
            <div  class="main_content">
                <h2 class="text-uppercase">savings</h2>
                <p>
                    <?php
                    $sql = "SELECT SUM(actual) AS total_amount FROM savings where user_id = $user_id";
                    $res = mysqli_query($conn, $sql);
                    // Fetch the result
                    $row = mysqli_fetch_assoc($res);
                    $totalAmount = $row["total_amount"];
                    if($totalAmount>0){
                        // Output the total amount
                        echo "Total Amount: " . $totalAmount;
                    }
                    else{
                        echo "You have not saved anything ";
                    }
                    ?>
                </p>
                <button class="btn btn-primary">More ...</button>
            </div>
            <div class="main_content">
                <h2 class="text-uppercase">Loan</h2>
                <p> <?php
                    $sql = "SELECT SUM(amount) AS total_amount FROM loans where user_id = $user_id";
                    $res = mysqli_query($conn, $sql);


                    // Fetch the result
                    $row = mysqli_fetch_assoc($res);
                    $totalAmount = $row["total_amount"];
                    if($totalAmount>0){
                        // Output the total amount
                        echo "Total Amount: " . $totalAmount;
                    }
                    else{
                        echo "You dont have any existing loan or paid loan";
                    }
                    ?>
                </p>
                <button class="btn btn-primary">More ...</button>
            </div>

        </div>

    </div>

    </body>


    <script src="../js/admin.js">

    </script>
</html>
