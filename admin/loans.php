    <?php
    session_start();
    include '../connection.php';

    include '../includes/session.php';
    if ($_SESSION['role'] != 1) {
        header('Location: dashboard.php');
        exit(); // It's a good practice to include exit() after header() to ensure no further code execution after redirection
    }
    if(isset($_POST["addLoan"])) {
        $amount = $_POST['amount'];
        $savings_user_id = $_POST['user_id'];
        $date = $_POST['date'];
        $loan_type=$_POST['loan_type'];
        $transaction_cost=$_POST['transaction_cost'];
        if($loan_type == 'emergency') {
            $interest = 0.04*$amount;
        }
        else if($loan_type == 'short_term'){
            $interest = 0.08*$amount;
        }
        else {
            $interest = 0.08*$amount;
        }

        $total = $amount+$interest+$transaction_cost;

        $weekNumber = date('W', strtotime($date));
        $time=time();
        $save = "insert into loans(user_id,loan_amount,interest,transaction_cost,total,paid_amount,balance,week,date_borrowed,loan_type,loan_id) values('$savings_user_id','$amount',$interest,$transaction_cost,$total,0,$amount,'$weekNumber','$date','$loan_type',$time)";
        $res = mysqli_query($conn, $save);
        if($res){
            $_SESSION['status'] = 'Loan added successfully';
            header('Location:loans.php');

        }
    }
    if(isset($_POST["payloan"])) {
        $amount = $_POST['amount'];
        $loan_id = $_POST['loan_id'];
        $date = $_POST['date'];

        $loan = "select *  from loans where loan_id = $loan_id";
        $res = mysqli_query($conn, $loan);
        $loan_details = mysqli_fetch_all($res, MYSQLI_ASSOC);
        //the password was correct
        foreach ($loan_details as $loan_detail) {
            $theloan = $loan_detail['loan_amount'];
            $paid_amount = $loan_detail['paid_amount'];
            $balance = $loan_detail['balance'];
            $user_id = $loan_detail['id'];
        }
        $total_paid=$paid_amount+$amount;
        $total_balance=$theloan-$total_paid;
        $payloan = "update loans set paid_amount = $total_paid, balance = $total_balance where loan_id=$loan_id";
        $payloanrun=mysqli_query($conn, $payloan);
        if($payloanrun){
            $loan = "insert into loans_payment(user_id,loan_id,amount,balance,date) values('$user_id','$loan_id',$amount,$total_balance,'$date')";
            $loanrun = mysqli_query($conn, $loan);
            if($loanrun){
                session_start();
                $_SESSION['status'] = 'Loan added successfully';
                header('Location:loans.php');
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
            .payloan{
                width: 23rem;
                position: absolute;
                top: 5rem;
                left: 5rem;
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
                <a href="loans.php" class="text-uppercase nav-link nav-active  text-decoration-none"><p>Loans</p></a>
                <a href="groupsmoney.php" class="text-uppercase  text-decoration-none"><p>Groups Money</p></a>
                <a href="loan_applications.php" class="text-uppercase  text-decoration-none"><p>Loan Applications</p></a>
                <a href="messages.php" class="text-uppercase  text-decoration-none"><p>Messages</p></a>
            </div>


            <div class="table-responsive">
                <table class="table  border table-bordered table-striped">
                    <thead>
                    <tr>
                        <th colspan="7" class=""><div class=" d-flex align-items-center justify-content-between">
                                <h2>Loans</h2>
                                <button class="btn btn-primary float-end" onclick="showForm()">Add Loan</button>|
                                <button class="btn btn-primary float-end" onclick="PayForm()">Pay Loan</button>
                            </div> </th>
                    </tr>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Loan</th>
                        <th scope="col">Paid Amount</th>
                        <th scope="col">Balance</th>
                        <th scope="col">Operation</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $week=date('W');
                    $savings="SELECT * FROM loans JOIN users ON loans.user_id = users.id where loans.balance != 0 ";
                    $savingsrun=mysqli_query($conn,$savings);
                    $id=1;
                    $total_loan=0;
                    $paid_loan=0;
                    $unpaid_balance=0;
                    while($saves=mysqli_fetch_assoc($savingsrun)) {
                        ?>
                        <tr>
                            <th><?php echo $id++; ?></th>
                            <th><?php echo $saves['first_name']?></th>
                            <th><?php echo $saves['last_name']?></th>
                            <th><?php echo $saves['loan_amount']?></th>
                            <th><?php echo $saves['paid_amount']?></th>
                            <th><?php echo $saves['balance']?></th>

                            <th scope="col"><button class="btn btn-primary float-end">Edit</button></th></td>
                        </tr>
                        <?php
                        $total_loan += $saves['loan_amount'];
                        $paid_loan += $saves['paid_amount'];
                        $unpaid_balance += $saves['balance'];
                    }
                    ?>
                    <tr>
                        <td colspan="6">
                            Total Loan Amount Ksh.
                            <?php
                            echo $total_loan
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            Total Paid Amount Ksh.
                            <?php
                            echo $paid_loan
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            Total Unpaid Amount Ksh.
                            <?php
                            echo $unpaid_balance
                            ?>
                        </td>
                    </tr>
                    </tbody>

                </table>
            </div>

        </div>

        </body>


        <div id="loan" class="loan  rounded">
            <button type="button" onclick="closeBtn()" class="btn-close float-end" aria-label="Close"></button>

            <form action="loans.php" method="post">
                <h2 class="text-primary" style="text-align: center;">Loan Details</h2>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Full Name</label>
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
                    <label for="exampleInputEmail1" class="form-label">Loan Type</label>
                    <select name="loan_type" id="" class="form-control">
                        <option value="emergency">Emergency</option>
                        <option value="short_term">Short term</option>
                        <option value="long_term">Long Term</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Loan Amount in KSH</label>
                    <input type="number" min="1" class="form-control" name="amount">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Date Borrowed</label>
                    <input type="date"  class="form-control" name="date">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Transaction cost</label>
                    <input type="number"  class="form-control" name="transaction_cost">
                </div>
                <button type="submit" name="addLoan" class="btn btn-primary w-100">Add Loan</button>

            </form>
        </div>
        <div id="payloan" class="payloan  rounded">
            <button type="button" onclick="closeForm()" class="btn-close float-end" aria-label="Close"></button>

            <form action="loans.php" method="post">
                <h2 class="text-primary" style="text-align: center;">Loan Payment For</h2>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Full Name</label>
                    <select name="loan_id" id="" class="form-control">
                        <?php $loan_payment="select loan_amount,loan_id,loan_type,first_name,last_name,phone from loans join users on loans.user_id= users.id where loans.loan_amount != loans.paid_amount ";
                        $loan_payment_run=mysqli_query($conn,$loan_payment);

                        while($allloans=mysqli_fetch_assoc($loan_payment_run)) {
                            ?>
                            <option value="<?php echo $allloans['loan_id']; ?>"><?php echo $allloans['first_name']; echo " "; ?><?php echo $allloans['last_name'];echo " "; ?>Phone:<?php echo $allloans['phone']; ?> Type: <?php echo $allloans['loan_type']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label" >Amount</label>
                    <input type="number" min="1" class="form-control" name="amount">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Date Paid</label>
                    <input type="date"  class="form-control" name="date">
                </div>

                <button type="submit" name="payloan" class="btn btn-primary w-100">Pay Loan</button>

            </form>
        </div>
        <script>
            function sideBar(){
                sidebar.classList.toggle('d-none')
            }

            function showForm() {
                loan.classList.toggle('d-block')
            }
            function PayForm() {
                payloan.classList.toggle('d-block')
            }
            function closeBtn(){
                loan.classList.remove('d-block')
            }
            function closeForm(){
                payloan.classList.remove('d-block')
            }

        </script>
    </html>
