<?php
session_start();
include '../connection.php';
$user_id= $_SESSION['user_id'];
$sql="SELECT * FROM savings where user_id = $user_id";
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
    <title>My savings report</title>
    <link rel="shortcut icon" href="../images/eagle.jpg">
    <link rel="stylesheet" href="../css/style.css">
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
            All My savings
        </h2>
        
        <table style="border-collapse: collapse; border: 2px solid #6AE512;width: 100%;">
            <thead>
            <tr>
                <th>#</th>
                <th>Amount</th>
                <th>Date of saving</th>
                <th>Week of payment</th>
            </tr>
            </thead>
            <tbody>
        ';


foreach ($rows as $row) {
    $html .= '<tr>
            <td>' . $row['savings_id'] . '</td>
            <td>Ksh.' . $row['amount'] . '</td>
            <td>' . $row['date'] . '</td>
            <td>' . $row['week'] . '</td>
</tr>';
    $total += $row['amount'];
}
$html .='<tr>
<td colspan="4"><h2>Total</h2>'.$total.'</td>
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



