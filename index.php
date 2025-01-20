<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warbook</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            z-index: 2;
            position: relative;
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            color: #fff;
        }

        p {
            font-size: 1.5rem;
            margin-bottom: 30px;
            color: #fff;
        }

        .btn {
            font-size: 1.25rem;
            padding: 15px 30px;
            margin: 10px;
            transition: all 0.3s ease;
            color: #fff;
            border: none;
        }

        .btn:hover {
            transform: scale(1.05);
        }

        .btn-success:hover {
            background-color: #28a745;
        }

        .btn-primary:hover {
            background-color: #007bff;
        }

        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('public/images/ketoprak.jpg');
            background-size: cover;
            background-position: center;
            filter: blur(8px);
            z-index: 1;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7));
            z-index: 1;
        }

        .welcome-text {
            font-weight: bold;
            font-size: 4rem;
            color: white;
            z-index: 2;
            position: relative;
        }
    </style>
</head>
<body>
    <div class="background"></div>
    <div class="overlay"></div>
    <div class="container">
        <h1 class="welcome-text">Welcome to Warbook!</h1>
        <p>Have you booked yet?</p>
        <a href="validate.php" class="btn btn-success">Yes, I have a booking</a>
        <a href="booking.php" class="btn btn-primary">No, I need to book</a>
    </div>
</body>
</html>
