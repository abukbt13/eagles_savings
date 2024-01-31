<?php
session_start();
include '../connection.php';
$user_id= $_SESSION['user_id'];
$sql="SELECT * FROM savings JOIN users ON savings.user_id = users.id order by savings.savings_id  desc";
$sqlrun=mysqli_query($conn,$sql);
$rows = mysqli_fetch_all($sqlrun, MYSQLI_ASSOC);

// reference the Dompdf namespace
require_once '../vendor/autoload.php';



use Dompdf\Dompdf;
$total = 0;
$html = '<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Savings report</title>
    <link rel="shortcut icon" href="../images/eagle.jpg">
//    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<style>
td,th{
text-align: left;
font-size: 37px;
border: 2px solid #ddd;
}
</style>

        <div class="tems">

        <h2 style="text-align: center;text-transform: uppercase;color: #0d6efd;">
            Savings Report
        </h2>
        
        <table style="border-collapse: collapse; border: 2px solid #6AE512;width: 100%;">
            <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
        ';


foreach ($rows as $row) {
    $html .= '<tr>
              <td>' . $row['id'] . '</td>
              <td>' . $row['first_name'] . '</td>
            <td>' . $row['last_name'] . '</td>
            <td>ksh.' . $row['amount'] . '</td>
            <td>' . $row['date'] . '</td>
</tr>';
    $total += $row['amount'];
}
$html .='<tr>
<td colspan="5"><p>Total Savings <span style="float: right;padding: 1rem;margin-right:1rem;background-color: #20c997;">Ksh ::'.$total.'</span></p></td>
</tr>';

$html .= '</tbody>
        </table>
        </div>
    </div>
</body>
</html>';
// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream('my savings.pdf', array('Attachment' => 0));



