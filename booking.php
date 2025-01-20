<?php
include 'config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Seat</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            <h2 class="booking-title">Booking Form</h2>
            <form id="bookingForm">
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter your Email" required>
                </div>
                <button type="button" id="generateCode" class="btn btn-primary w-100">Generate Booking Code</button>
            </form>
            <div id="bookingCodeContainer" class="mt-4" style="display: none;">
                <h4>Your Booking Code:</h4>
                <p id="bookingCode" class="text-success fs-4"></p>
                <a href="order.php" id="orderButton" class="btn btn-success mt-3" style="display: none;">Continue to Food Ordering</a>
            </div>

            <div id="alreadyRegistered" class="alert alert-info mt-4" style="display: none;">
                <strong>You are already registered!</strong> Your booking code is: <span id="existingBookingCode"></span>
                <a href="order.php" id="orderButtonRegistered" class="btn btn-success mt-3">Continue to Food Ordering</a>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#generateCode').click(function () {
                const name = $('#name').val();
                const email = $('#email').val();

                if (name && email) {
                    $.post('generate_booking_code.php', { name: name, email: email }, function (response) {
                        if (response.success) {
                            if (response.message === 'You are already registered.') {
                                $('#existingBookingCode').text(response.code);
                                $('#alreadyRegistered').show();
                                $('#bookingCodeContainer').hide();
                            } else {
                                $('#bookingCode').text(response.code);
                                $('#bookingCodeContainer').show();
                                $('#alreadyRegistered').hide();
                                $('#orderButton').show();
                                $.post('save_booking_code.php', { code: response.code });
                            }
                        } else {
                            alert('Error: ' + response.message);
                        }
                    }, 'json');
                } else {
                    alert('Please enter both name and email.');
                }
            });
        });
    </script>
</body>
</html>
