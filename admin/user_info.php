<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    session_start();
    $_SESSION['status'] = 'lOGIN TO VIEW THIS PAGE';
    header('Location: ../auth/login.php');
}

if ($_SESSION['role'] != 1) {
    header('Location: ../user/index.php');
    exit(); // It's a good practice to include exit() after header() to ensure no further code execution after redirection
}
include '../connection.php';

if(isset($_POST["user"])){
    $user_id = $_POST['user_id'];
}
if (!isset($user_id)) {
    session_start();
    $_SESSION['status'] = 'lOGIN TO VIEW THIS PAGE';
    header('Location: index.php');
}
if(isset($_POST['delete_record'])){
    $id = $_POST['id'];
    $delete="delete from savings where savings_id =$id ";
    $deleterun=mysqli_query($conn,$delete);
    if ($deleterun){
        $_SESSION['status'] = 'Record Deleted successfully';
        header('Location:users.php');
        die();
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
    <title>users information</title>
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
            <a href="users.php" class="text-uppercase   text-decoration-none"><p>Users</p></a>
            <a href="savings.php" class="text-uppercase  text-decoration-none"><p>savings</p></a>
            <a href="loans.php" class="text-uppercase  text-decoration-none"><p>Loans</p></a>
            <a href="loan_applications.php" class="text-uppercase  text-decoration-none"><p>Loan Applications</p></a>
            <a href="messages.php" class="text-uppercase  text-decoration-none"><p>Messages</p></a>
        </div>


        <div  style="" class="main">

            <table class="table  border table-bordered table-striped">
                <thead>
                <tr>
                    <th colspan="7" class="">
                        <div class=" d-flex align-items-center justify-content-between">
                            <P>
                                <b>ABRAHAM S</b> savings
                            </P>
                        </div>
                    </th>
                </tr>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Savings</th>
                    <th scope="col">Date</th>
                    <th scope="col">Week</th>
                    <th COLSPAN="2" scope="col">OPERATIONS</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $week = date('W');
                $savings = "SELECT * FROM savings JOIN users ON savings.user_id = users.id where user_id= $user_id ";
                $savingsrun = mysqli_query($conn, $savings);
                $id = 1;
                $total = 0;
                $actual = 0;


                while ($saves = mysqli_fetch_assoc($savingsrun)) {
                    ?>
                    <tr>
                        <th><?php echo $id++; ?></th>
                        <th><?php echo $saves['amount'] ?></th>
                        <th><?php echo $saves['date'] ?></th>
                        <th><?php echo $saves['week'] ?></th>
                        <th>
                            <a class="btn btn-primary" href="edit_savings.php?id=<?php echo $saves['savings_id']; ?>&editinfo=">Edit info</a>
                        </th>
                        <th>
                            <form action="user_info.php" method="post">
                                <input hidden value="<?php echo $saves['savings_id'] ?>" name="id" type="number">
                                <input type="submit" name="delete_record" class="btn btn-danger" value="DElETE RECORD">
                            </form>
                        </th>
                    </tr>
                    <?php
                    $total += $saves['amount']; // Add the amount to the total
                }
                ?>
                <tr>
                    <td colspan="7"><h2>Total savings <span class="float-end"><?php echo $total; ?></span></h2></td>
                </tr>

                </tbody>
                </tbody>

            </table>

        </div>

    </div>

    <script src="../js/admin.js"></script>
    </body>
</html>
