<?php
require_once 'vendor/autoload.php';
session_start();

if (!isset($_SESSION['order'])) {
    die('No order information found');
}

$order = $_SESSION['order'];

$pdf = new TCPDF();
$pdf->AddPage();

$html = "
    <h1>Booking Confirmation</h1>
    <p>Name: " . htmlspecialchars($order['customer_name']) . "</p>
    <p>Email: " . htmlspecialchars($order['customer_email']) . "</p>
    <p>Booking Code: " . htmlspecialchars($order['ref_code']) . "</p>
    <p>Items Ordered:</p>
    <ul>
";

foreach ($order['items'] as $item) {
    $html .= "<li>" . htmlspecialchars($item['name']) . " - Quantity: " . htmlspecialchars($item['quantity']) . " - Total: $" . htmlspecialchars(number_format($item['total'], 2)) . "</li>";
}

$html .= "</ul>";

$pdf->writeHTML($html);

$pdf->Output('booking_confirmation.pdf', 'I');
?>