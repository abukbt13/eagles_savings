<?php
session_start();

include '../includes/session.php';
if ($_SESSION['role'] != 1) {
    header('Location: ../user/index.php');
    exit(); // It's a good practice to include exit() after header() to ensure no further code execution after redirection
}
$last_name = $_SESSION['last_name'] ;
$first_name = $_SESSION['first_name'] ;
include '../connection.php';
if(isset($_POST["payment"])) {
    $amount = $_POST['amount'];
    $source = $_POST['source'];
    $from_who = $_POST['from_who'];
    $date = $_POST['date'];

        $save = "insert into groups_money(amount,source,from_who,date) values('$amount','$source','$from_who','$date')";
        $res = mysqli_query($conn, $save);
        if($res){
            $_SESSION['status'] = 'Payment recorded successfully';
            header('Location:groupsmoney.php');
        }
        else{
            $_SESSION['status'] = 'Error saving the records';
            header('Location:groupsmoney.php');
            die();
        }

}
if(isset($_POST["expenditure"])) {
    $activity = $_POST['activity'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $referee= $_POST['referee'];
    $date = $_POST['date'];

        $save1 = "insert into groups_expenditure(activity,description,amount,referee,date) values('$activity','$description','$amount','$referee','$date')";
        $res1 = mysqli_query($conn, $save1);
        if($res1){
            $_SESSION['status'] = 'Expenditure recorded successfully';
            header('Location:groupsmoney.php');
        }
        else{
            $_SESSION['status'] = 'Error saving the records';
            header('Location:groupsmoney.php');
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
    <title>Groups money</title>
    <link rel="shortcut icon" href="../images/eagle.jpeg">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/main.js"></script>
</head>
<?php
include "../includes/header.php";
?>

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
    <?php include 'sidebar.php'?>

   <div class="">
       <div  style="" class="">
           <div  class="">
               <h2 class="text-uppercase">Groups worth</h2>
               <p>  <?php
                   $sql = "SELECT SUM(amount) AS total_amount FROM groups_money";
                   $res = mysqli_query($conn, $sql);
                   // Fetch the result
                   $row = mysqli_fetch_assoc($res);
                   $totalAmount = $row["total_amount"];
                   if($totalAmount>0){
                       // Output the total amount
                       echo "Groups worth at the moment: " . $totalAmount;
                   }
                   else{
                       echo "There is no money at the moment";
                   }
                   ?>
               </p>

           </div>

       </div>

       <div class="table-responsive">
           <table class="table  border table-bordered table-striped">

               <tr>
                   <td colspan="6">
                           <h2 class="">Groups Flow of money</h2>
                       <button class="btn btn-primary float-end" onclick="showForm()">Add Group money</button>
                   </td>
               </tr>

               <tr>
                   <td scope="col">#</td>
                   <td scope="col">Source</td>
                   <td scope="col">Amount</td>
                   <td scope="col">From Who</td>
                   <td scope="col">Date</td>
               </tr>


               <?php
               $week = date('W');
               $savings = "SELECT * FROM groups_money  order by id  desc";
               $savingsrun = mysqli_query($conn, $savings);
               $id = 1;
               $total = 0;

               while ($saves = mysqli_fetch_assoc($savingsrun)) {
                   ?>
                   <tr>
                       <td><?php echo $id++; ?></td>
                       <td><?php echo $saves['source'] ?></td>
                       <td><?php echo $saves['amount'] ?></td>
                       <td><?php echo $saves['from_who'] ?></td>
                       <td><?php echo $saves['date'] ?></td>

                   </tr>
                   <?php
                   $total += $saves['amount']; // Add the amount to the total
               }
               ?>
               <tr>
                   <td colspan="8"><h2>Total Group Worth <span class="float-end"><?php echo $total; ?></span></h2></td>
               </tr>

           </table>
           <table class="table  border table-bordered table-striped">

               <tr>
                   <td colspan="6">
                           <h2 class="">Groups Expenditure</h2>
                       <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModal">Group Expenditure</button>
                   </td>
               </tr>

               <tr>
                   <td scope="col">#</td>
                   <td scope="col">Activity</td>
                   <td scope="col">Description</td>
                   <td scope="col">Amount</td>
                   <td scope="col">Transacted By</td>
                   <td scope="col">Date</td>
               </tr>


               <?php
               $week = date('W');
               $savings = "SELECT * FROM groups_expenditure  order by id  desc";
               $savingsrun = mysqli_query($conn, $savings);
               $id = 1;
               $total = 0;

               while ($saves = mysqli_fetch_assoc($savingsrun)) {
                   ?>
                   <tr>
                       <td><?php echo $id++; ?></td>
                       <td><?php echo $saves['activity'] ?></td>
                       <td><?php echo $saves['description'] ?></td>
                       <td><?php echo $saves['amount'] ?></td>
                       <td><?php echo $saves['referee'] ?></td>
                       <td><?php echo $saves['date'] ?></td>

                   </tr>
                   <?php
                   $total += $saves['amount']; // Add the amount to the total
               }
               ?>
               <tr>
                   <td colspan="8"><h2>Total Group Worth <span class="float-end"><?php echo $total; ?></span></h2></td>
               </tr>

           </table>
       </div>
   </div>

</div>
<div id="loan" class="loan  rounded">
    <button type="button" onclick="closeBtn()" class="btn-close float-end" aria-label="Close"></button>

        <form action="groupsmoney.php" method="post">
            <h2 class="text-primary" style="text-align: center;">Groups Money</h2>


            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Source of Money</label>
                <select name="source" id="" class="form-control">
                    <option value="Interest">Interest</option>
                    <option value="Registration fees">Registration fees</option>
                    <option value="Business profit">Business profit</option>
                    <option value="Other sources">Other sources</option>
                </select> <label for="exampleInputEmail1" class="form-label">Received from</label>
                <select name="from_who" id="" class="form-control">
                    <option value="groups_business">Groups Business</option>
                    <?php $users="select * from users";
                    $usersrun=mysqli_query($conn,$users);

                    while($allUsers=mysqli_fetch_assoc($usersrun)) {
                        ?>
                        <option value="<?php echo $allUsers['first_name'];echo " ";echo $allUsers['last_name'] ?>"><?php echo $allUsers['first_name']; echo" "; echo $allUsers['last_name']; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Amount in Shillings</label>
                <input type="number" min="1" required class="form-control" name="amount">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Date</label>
                <input type="date" required class="form-control" name="date">
            </div>


            <button type="submit" name="payment" class="btn btn-primary w-100">Record Payment</button>

        </form>
    </div>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Group Expenditure</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="groupsmoney.php" method="post">

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Groups Activity involved</label>
                        <input name="activity" id="" class="form-control" placeholder="shop construction">
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Description</label>
                        <textarea name="description" id="" class="form-control" rows="5"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Amount</label>
                        <input type="number"  required class="form-control" name="amount">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Confirmed By</label>
                        <input type="text"  required class="form-control" name="referee">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Date Of transaction</label>
                        <input type="date" required class="form-control" name="date">
                    </div>


                    <button type="submit" name="expenditure" class="btn btn-primary w-100">Record Expenditure</button>

                </form>
            </div>

        </div>
    </div>
</div>

<script src="../js/admin.js"></script>
</body>
</html>
