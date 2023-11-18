<?php
session_start();
$last_name = $_SESSION['last_name'] ;
$first_name = $_SESSION['first_name'] ;
include 'connection.php';
if (!isset($_SESSION['user_id'])) {
    session_start();
    $_SESSION['status'] = 'lOGIN TO VIEW THIS PAGE';
    header('Location:login.php');
}

if(isset($_POST["savings"])) {
$amount = $_POST['amount'];
$user_id = $_POST['user_id'];
    $date = date('d-m-y');
    $weekNumber = date('W');


        $save = "insert into savings(amount,user_id,week,date) values('$amount','$user_id','$weekNumber','$date')";
        $res = mysqli_query($conn, $save);
        if($res){
            $_SESSION['status'] = 'Successfully saved ';
            header('Location:admin.php');
        }

}

include "header.php";
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
<div>
    <style>
        .contents{
            display: flex;
        }
        .sidebar{
            width: 13rem;
            height: 100vh;
        }
        .loan{
            position: absolute;
            top: 5rem;
            left: 15rem;
            background: grey;
            z-index: 0.2;
            padding: 2rem;
            display: none;
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
    <div class="contents">
        <div class="sidebar px-2 bg-light">

            <h5 class="mb-1" id="offcanvasExampleLabel">Admin Dashboard</h5>

            <img style="border-radius: 50%;" src="eagle.jpeg" width="90" height="90" alt="">
            <h4><?php echo $first_name; echo " "; echo $last_name; ?></h4><br>
            <button class="btn btn-sm btn-secondary">Edit</button>
            <hr>

            <a href="#" class="text-uppercase"><p>All savings</p></a>
            <a href="#" class="text-uppercase"><p>All loans</p></a>
            <a href="#" class="text-uppercase"><p>Events</p></a>
            <a href="applyloan.php" class="text-uppercase"><p>Loan Applications</p></a>
        </div>
        <div class="data">
            <table class="table border table-bordered table-striped">
                <thead>
                <tr>
                    <th colspan="6" class=""><div class=" d-flex align-items-center justify-content-between">
                            All savings
                            <button class="btn btn-primary float-end"onclick="showForm()" >Add savings</button>
                        </div> </th>
                </tr>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Savings</th>
                    <th scope="col">Date</th>
                    <th scope="col">Operation</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $savings="SELECT * FROM savings JOIN users ON savings.user_id = users.id";
                $savingsrun=mysqli_query($conn,$savings);

                while($saves=mysqli_fetch_assoc($savingsrun)) {
                ?>
                <tr>
                    <th><?php echo $saves['id']?></th>
                    <th><?php echo $saves['first_name']?></th>
                    <th><?php echo $saves['last_name']?></th>
                    <th><?php echo $saves['amount']?></th>
                    <th><?php echo $saves['date']?></th>
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


        <div  style="width: 23rem;" id="loan" class="loan  rounded">
            <button type="button" onclick="closeBtn()" class="btn-close float-end" aria-label="Close"></button>

            <form action="admin.php" method="post">
                <h2 class="text-primary" style="text-align: center;">Savings Records</h2>


                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Member Name</label>
                    <select name="user_id" id="" class="form-control">
                        <?php $users="select * from users";
                        $usersrun=mysqli_query($conn,$users);

                        while($allUsers=mysqli_fetch_assoc($usersrun)) {
                        ?>
                        <option value="<?php echo $allUsers['id']; ?>"><?php echo $allUsers['first_name']; echo" "; echo $allUsers['first_name']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Amount in Shillings</label>
                    <input type="number" min="1" class="form-control" name="amount">
                </div>


                <button type="submit" name="savings" class="btn btn-primary w-100">Add Saving</button>

            </form>
        </div>
    <script type="application/javascript">
        const loan = document.getElementById('loan')
        const close = document.getElementById('close')
        function showForm() {
            loan.style.display = 'block';
        }
        function closeBtn() {
            loan.style.display = 'none';
        }

    </script>
</html>
