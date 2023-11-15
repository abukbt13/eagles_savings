<?php
session_start();
include 'connection.php';
if (isset($_SESSION['uid'])) {
    session_start();
    $_SESSION['status'] = 'lOGIN TO VIEW THIS PAGE';
    header('Location:signin.php');
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
    <title>Dashboard</title>
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
    </style>

<div class="contents">
    <div class="sidebar px-2 bg-light">

        <h5 class="mb-1" id="offcanvasExampleLabel">Dashboard</h5>

            <img style="border-radius: 50%;" src="eagle.jpeg" width="90" height="90" alt="">
            <span><?php echo $_SESSION['username'];?></span><br>
        <button class="btn btn-sm btn-secondary">Edit</button>
        <hr>

        <a href="#" class="text-uppercase"><p>My savings</p></a>
        <a href="#" class="text-uppercase"><p>My loans</p></a>
        <a href="#" class="text-uppercase"><p>Events</p></a>
    </div>
    <div class="data">
        <table class="table border table-bordered table-striped">
            <thead>
            <tr>
                <th colspan="4" class="text-center">All savings</th>
            </tr>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Full Name</th>
                <th scope="col">Phone Number</th>
                <th scope="col">Savings</th>
            </tr>
            </thead>
            <tbody>

            <tr>
                <th>2</th>
                <th scope="row">Abraham Kibet</th>
                <td>0728548760</td>
                <td>6789</td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td colspan="2">Larry the Bird</td>
                <td>@twitter</td>
            </tr>
            </tbody>

        </table>
    </div>
</div>

</body>
</html>
