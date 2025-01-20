<?php
session_start();

if (isset($_POST['code'])) {
    $_SESSION['booking_code'] = $_POST['code'];
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'No booking code provided.']);
}
?>