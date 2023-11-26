<?php
session_start();
include 'connection.php';
if (!isset($_SESSION['user_id'])) {
    session_start();
    $_SESSION['status'] = 'lOGIN TO VIEW THIS PAGE';
    header('Location:login.php');
}
$last_name = $_SESSION['last_name'] ;
$first_name = $_SESSION['first_name'] ;

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
        $save = "insert into savings(amount,user_id,week,date) values('$amount','$savings_user_id','$weekNumber','$date')";
        $res = mysqli_query($conn, $save);
        if($res){
            $_SESSION['status'] = 'Successfully saved ';
            header('Location:admin.php');
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
            <a href="admin.php" class="text-uppercase text-decoration-none"><p>Home</p></a>
            <a href="all_saving.php" class="text-uppercase   text-decoration-none"><p>All savings</p></a>
            <h3>Loans</h3>
            <a href="all_loans.php" class="text-uppercase text-decoration-none"><p>all loans</p></a>
            <a href="loan_applications.php" class="text-uppercase text-decoration-none"><p>Loan Applications</p></a>
            <h2>Inquiries</h2>
            <a href="view_messages.php" class="text-uppercase nav-link nav-active  text-decoration-none"><p>View Messages</p></a>


        </div>


        <div class="table-responsive">
            <table class="table  border table-bordered table-striped">
                <thead>
                <tr>
                    <th colspan="7" class=""><div class=" d-flex align-items-center justify-content-between">
                            All Messages
                        </div>
                    </th>
                </tr>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">title</th>
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
                while($messages=mysqli_fetch_assoc($savingsrun)) {
                    ?>
                    <tr>
                        <th><?php echo $id++; ?></th>
                        <th><?php echo $messages['first_name']?></th>
                        <th><?php echo $messages['last_name']?></th>
                        <th><?php echo $messages['title']?></th>
                        <th><?php echo $messages['message']?></th>
                        <th><?php echo $messages['date']?></th>

                        <th scope="col"><button class="btn btn-primary float-end">Respond</button></th></td>
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
