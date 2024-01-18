<?php
session_start();
include '../connection.php';

include '../includes/session.php';
$user_id = $_SESSION['user_id'];

if(isset($_POST["apply_loan"])) {
    $loan_type = $_POST['loan_type'];
    $amount = $_POST['amount'];
    $period = $_POST['period'];
    $date = date('y-m-d');
    $save = "insert into loans_applications(loan_type,amount,period,date,user_id) values('$loan_type','$amount','$period','$date',$user_id)";
    $res = mysqli_query($conn, $save);

    if($res){
        $_SESSION['status'] = 'Loan Applied successfully';
        header('Location:my_loans.php');
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
    <link rel="shortcut icon" href="../images/eagle.jpg">
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
            <i  class="fa fa-align-left" aria-hidden="true">
            </i>
        </button>
        <div id="sidebar" class="d-none sidebar_side p-4 d-md-block d-lg-block">

            <h5 class="mb-1 border-bottom text-center">Dashboard</h5>
            <a href="index.php" class="text-uppercase text-decoration-none"><p>Home</p></a>

            <a href="my_savings.php" class="text-uppercase  text-decoration-none"><p>My savings</p></a>

            <a href="my_loans.php" class="text-uppercase nav-link active  text-decoration-none"><p>My loans</p></a>
            <a href="my_messages.php" class="text-uppercase  text-decoration-none"><p>Messages</p></a>
        </div>


        <div class="table-responsive">
            <table class="table  border table-bordered table-striped">
                <thead>
                <tr>
                    <th colspan="7" class=""><div class=" d-flex align-items-center justify-content-between">
                            <h2>My Active Loans</h2>
                        </div>
                    </th>
                </tr>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Loan Amount</th>
                    <th scope="col">Date requested</th>
                    <th scope="col">Interest</th>
                    <th scope="col">Operation</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $savings="SELECT * FROM loans  where user_id = $user_id";
                $savingsrun=mysqli_query($conn,$savings);
                $id=1;
                while($saves=mysqli_fetch_assoc($savingsrun)) {
                    ?>
                    <tr>
                        <th><?php echo $id++; ?></th>
                        <th><?php echo $saves['amount']?></th>
                        <th><?php echo $saves['date_borrowed']?></th>
                        <th><?php echo $saves['interest']?></th>

                        <th scope="col"><button class="btn btn-primary float-end">Edit</button></th></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>

            </table>
        </div>


    </div>
    <div class="table-responsive">
        <table class="table  border table-bordered table-striped">
            <thead>
            <tr>
                <th colspan="7" class=""><div class=" d-flex align-items-center justify-content-between">
                        <h2>Loans Applications</h2>
                        <button class="btn btn-primary float-end" onclick="showForm()">Apply  Loan</button>
                    </div> </th>
            </tr>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Loan Amount</th>
                <th scope="col">Date requested</th>
                <th scope="col">Period in Months</th>
                <th scope="col">Operation</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $savings="SELECT * FROM loans_applications  where user_id = $user_id";
            $savingsrun=mysqli_query($conn,$savings);
            $id=1;
            while($saves=mysqli_fetch_assoc($savingsrun)) {
                ?>
                <tr>
                    <th><?php echo $id++; ?></th>
                    <th><?php echo $saves['amount']?></th>
                    <th><?php echo $saves['date']?></th>
                    <th><?php echo $saves['period']?></th>

                    <th scope="col"><button class="btn btn-primary float-end">Edit</button></th></td>
                </tr>
                <?php
            }
            ?>
            </tbody>

        </table>
    </div>
    </body>


    <div id="loan" class="loan  rounded">
        <button type="button" onclick="closeBtn()" class="btn-close float-end" aria-label="Close"></button>

        <form action="my_loans.php" method="post">
            <h2 class="text-primary" style="text-align: center;">Loan Application</h2>


            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Loan Type</label>
                <select name="loan_type" id="" class="form-control">
                    <option value="emergency">Emergency</option>
                    <option value="short_term">Short_term</option>
                    <option value="long_term">long_term</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Loan Amount in KSH</label>
                <input type="number" min="1" class="form-control" name="amount">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">In Months</label>
                <select name="period" id="" class="form-control">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
            </div>
            <button type="submit" name="apply_loan" class="btn btn-primary w-100">Apply</button>

        </form>
    </div>
    <script src="../../js/admin.js">

    </script>
</html>
