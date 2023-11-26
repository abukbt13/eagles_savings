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
    <title>Loans</title>
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
            <a href="all_loans.php" class="text-uppercase nav-link nav-active  text-decoration-none"><p>all loans</p></a>
            <a href="loan_applications.php" class="text-uppercase text-decoration-none"><p>Loan Applications</p></a>
            <h2>Inquiries</h2>
            <a href="view_messages.php" class="text-uppercase  text-decoration-none"><p>View Messages</p></a>

        </div>


        <div class="table-responsive">
            <table class="table  border table-bordered table-striped">
                <thead>
                <tr>
                    <th colspan="7" class=""><div class=" d-flex align-items-center justify-content-between">
                            <h2>Loans</h2>
                            <button class="btn btn-primary float-end" onclick="showForm()">Add Loan</button>
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
                $savings="SELECT * FROM loans JOIN users ON loans.user_id = users.id";
                $savingsrun=mysqli_query($conn,$savings);
                $id=1;
                while($saves=mysqli_fetch_assoc($savingsrun)) {
                    ?>
                    <tr>
                        <th><?php echo $id++; ?></th>
                        <th><?php echo $saves['first_name']?></th>
                        <th><?php echo $saves['last_name']?></th>
                        <th><?php echo $saves['amount']?></th>
                        <th><?php echo $saves['date_borrowed']?></th>
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

        <form action="all_loans.php" method="post">
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
                <label for="exampleInputEmail1" class="form-label">Loan Amount in KSH</label>
                <input type="number" min="1" class="form-control" name="amount">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Date</label>
                <input type="date"  class="form-control" name="date">
            </div>
            <button type="submit" name="add_loan" class="btn btn-primary w-100">Add Loan</button>

        </form>
    </div>
    <script src="admin.js">

    </script>
</html>
