<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validate Booking</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }

        .card-container {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 50%;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 30px;
            box-sizing: border-box;
            z-index: 2;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .card {
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 30px;
        }

        h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 30px;
        }

        .form-label {
            font-size: 1.1rem;
        }

        .btn {
            font-size: 1.25rem;
            padding: 15px 30px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: scale(1.05);
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn-success {
            background-color: #28a745;
        }

        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('public/images/nyemek.jpg');
            background-size: cover;
            background-position: center;
            filter: blur(8px);
            z-index: 1;
            border-radius: 10px;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7));
            border-radius: 10px;
            z-index: 1;
        }

        .booking-title {
            font-weight: bold;
            font-size: 2rem;
            color: black;
            z-index: 2;
            position: relative;
        }

        .btn-back {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 1.1rem;
            padding: 10px 20px;
            z-index: 3;
            transition: background-color 0.3s ease;
        }
    </style>
</head>
<body>
    <div class="background"></div>
    <div class="overlay"></div>

    <a href="index.php" class="btn btn-back">Back</a>

    <div class="card-container">
        <div class="card">
            <h2 class="booking-title">Enter Your Booking Reference</h2>
            <form action="validate.php" method="POST" class="text-center">
                <div class="mb-3">
                    <input type="text" name="ref_code" class="form-control" placeholder="Enter your booking code" required>
                </div>
                <button type="submit" name="validate" class="btn btn-success w-100">Validate</button>
            </form>

            <?php
            if (isset($_POST['validate'])) {
                $ref_code = $_POST['ref_code'];

                try {
                    $sql = "SELECT * FROM bookings WHERE ref_code = :ref_code";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([':ref_code' => $ref_code]);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($result) {
                        header("Location: order.php");
                        exit;
                    } else {
                        echo "<p class='text-danger text-center mt-3'>Invalid booking code. Please try again.</p>";
                    }
                } catch (PDOException $e) {
                    echo "<p class='text-danger text-center mt-3'>Error: " . $e->getMessage() . "</p>";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
