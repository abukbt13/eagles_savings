<?php
include '../connection.php';

$sql="SELECT * FROM savings";
$sqlrun=mysqli_query($conn,$sql);
$rows = mysqli_fetch_all($sqlrun, MYSQLI_ASSOC);

// reference the Dompdf namespace
require_once '../vendor/autoload.php';



use Dompdf\Dompdf;

$html = '<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Savings Report</title>
    <link rel="shortcut icon" href="images/eagle.jpg">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<style>
td,th{
border: 2px solid #ddd;
}
</style>
    <div style="background: #7C125; padding-left: 4rem;">
        <div class="tems">

        <h2 style="text-align: center;">
            All savings
        </h2>
        
        <table style="border-collapse: collapse; border: 2px solid #6AE512">
            <thead>
            <tr>
                <th>#</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
        ';


foreach ($rows as $row) {
    $html .= '<tr>
            <td>' . $row['id'] . '</td>
            <td>' . $row['amount'] . '</td>
            <td>' . $row['date'] . '</td>
</tr>';
}
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
$dompdf->stream('savings.pdf', array('Attachment' => 0));



