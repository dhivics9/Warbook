<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';

    if ($name && $email) {
        try {
            $checkSql = "SELECT ref_code FROM bookings WHERE name = :name AND email = :email";
            $stmt = $conn->prepare($checkSql);
            $stmt->execute([':name' => $name, ':email' => $email]);

            $existingBooking = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existingBooking) {
                echo json_encode([
                    'success' => true,
                    'message' => 'You are already registered.',
                    'code' => $existingBooking['ref_code']
                ]);
            } else {
                $ref_code = uniqid('BOOK-');
                $insertSql = "INSERT INTO bookings (name, email, ref_code) VALUES (:name, :email, :ref_code)";
                $stmt = $conn->prepare($insertSql);
                $stmt->execute([':name' => $name, ':email' => $email, ':ref_code' => $ref_code]);

                echo json_encode([
                    'success' => true,
                    'message' => 'Booking successful.',
                    'code' => $ref_code
                ]);
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Name and Email are required.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
