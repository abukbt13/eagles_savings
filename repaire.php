<?php
include '../connection.php';

if(isset($_POST["user"])){
    $user_id = $_POST['user_id'];
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>users details</title>
    <link rel="shortcut icon" href="../images/eagle.jpeg">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<table class="table  border table-bordered table-striped">
    <thead>
    <tr>
        <th colspan="5" class="">
            <div class=" d-flex align-items-center justify-content-between">
                Users savings
            </div>
        </th>
    </tr>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Savings</th>
        <th scope="col">Actual savings</th>
        <th scope="col">Date</th>
        <th scope="col">Week</th>
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
            <th><?php echo $saves['actual'] ?></th>
            <th><?php echo $saves['date'] ?></th>
            <th><?php echo $saves['week'] ?></th>
        </tr>
        <?php
        $total += $saves['amount']; // Add the amount to the total
        $actual += $saves['actual']; // Add the amount to the total
    }
    ?>
    <tr>
        <td colspan="5"><h2>Total savings <span class="float-end"><?php echo $total; ?></span></h2></td>
    </tr>
    <tr>
        <td colspan="5"><h2>Total Actual after 0.005% deduction <span class="float-end"><?php echo $actual; ?></span></h2></td>
    </tr>
    </tbody>
    </tbody>

</table>
</body>
</html>