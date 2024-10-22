<?php

// errors(1);

// Load TCPDF library
require_once(__DIR__ . '/../../../controllers/TCpdf/tecnickcom/tcpdf/tcpdf.php');

$currentUser = App::getUser();

// Check if the wedding ID is set
if (isset($_REQUEST['id']) && $currentUser['userID']) {
    $weddingID = $_REQUEST['id'];

    controller("Payment");
    $payment = new Payment();

    controller("Wedding");
    $wedding = new Wedding();

    $getPayment = $payment->getPaymentByID($weddingID, $currentUser['userID']);
    $weddingData = $wedding->getWedding($_REQUEST['id'], $_REQUEST['lang']);
    $template = $weddingData['template'];
    $themeName = ucwords(explode("_", $template)[2]);
    $themeDetails = json_decode(file_get_contents('themes/' . $template . '/manifest.json'), true);
    $themePrice = $themeDetails['themePrice'];

    // Initialize TCPDF
    $pdf = new TCPDF();
    // Add a page
    $pdf->AddPage();

    // Set default font
    $pdf->SetFont('dejavusans', '', 12);


    // Create the HTML content for the invoice
    $html = '
     <style>

        .text-end {
            text-align: right;
        }
      
    </style>
        <br><br>
        <h2 style="text-align:center;">eSubhalekha.com</h2>
        <h3 style="text-align:center;">Invoice</h3> <br><br>
        <table border="1" cellpadding="8">
            <tr>
                <td>
                    <b>Invoice ID: </b> ' . $getPayment['paymentID'] . '<br><br>
                    <b>Paid At:</b> ' . $getPayment['paidAt'] . '<br><br>
                    <b>Wedding ID:</b> ' . $getPayment['weddingID'] . ' - '.$_REQUEST['lang'] . '<br>
                </td>
                <td>
                    <b>Name:</b> ' . $currentUser['name'] . '<br><br>
                    <b>Email:</b> ' . $currentUser['email'] . '<br><br>
                    <b>Phone:</b> ' . $currentUser['phone'] . '<br>
                </td>
            </tr>
        </table>
        <br>
        <h4>Details of Payment</h4>
        <table border="1" cellpadding="8">


             <tbody>
                <tr>
                    <td class="text-end">Wedding Theme</td>
                    <td class="text-end">'.$themeName.'</td>
                </tr>
             </tbody>

           <tfoot>
            <tr>
                <td class="text-end"><strong>Total</strong></td>
                <td class="text-end" style="font-size:14px;">'. $themePrice.' &#8377; </td>
            </tr>
            </tfoot>
        </table>
    ';

    // Output the HTML content to PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Output the PDF (force download)
    $pdf->Output('wedding_invoice_' . $weddingID . '.pdf', 'I');

} else {
    echo "Invalid request.";
    return;
}
?>
