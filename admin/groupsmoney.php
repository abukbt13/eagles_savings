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
                   <button class="btn btn-primary float-end" onclick="showForm()">Add Group money</button>
               </p>

           </div>

       </div>

       <div class="table-responsive">
           <table class="table  border table-bordered table-striped">
               <thead>
               <tr>
                   <th colspan="9" class="">
                           <p>Groups source of money</p>
                   </th>
               </tr>
               <tr>
                   <th scope="col">#</th>
                   <th scope="col">Source</th>
                   <th scope="col">Amount</th>
                   <th scope="col">From Who</th>
                   <th scope="col">Date</th>
               </tr>
               </thead>
               <tbody>
               <?php
               $week = date('W');
               $savings = "SELECT * FROM groups_money  order by id  desc";
               $savingsrun = mysqli_query($conn, $savings);
               $id = 1;
               $total = 0;

               while ($saves = mysqli_fetch_assoc($savingsrun)) {
                   ?>
                   <tr>
                       <th><?php echo $id++; ?></th>
                       <th><?php echo $saves['source'] ?></th>
                       <th><?php echo $saves['amount'] ?></th>
                       <th><?php echo $saves['from_who'] ?></th>
                       <th><?php echo $saves['date'] ?></th>

                   </tr>
                   <?php
                   $total += $saves['amount']; // Add the amount to the total
               }
               ?>
               <tr>
                   <td colspan="8"><h2>Total Group Worth <span class="float-end"><?php echo $total; ?></span></h2></td>
               </tr>
               </tbody>
               </tbody>

           </table>
       </div>
   </div>

</div>
<div id="loan" class="loan  rounded">
    <button type="button" onclick="closeBtn()" class="btn-close float-end" aria-label="Close"></button>

    <form action="groupsmoney.php" method="post">
        <h2 class="text-primary" style="text-align: center;">Savings Records</h2>


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
                    <option value="<?php echo $allUsers['id']; ?>"><?php echo $allUsers['first_name']; echo" "; echo $allUsers['last_name']; ?></option>
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

<script src="../js/admin.js"></script>
</body>
</html>
