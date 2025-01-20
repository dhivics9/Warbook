<?php
session_start();

if (!isset($_SESSION['order'])) {
    die('No order information found');
}

$order = $_SESSION['order'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            background-color: #f8f9fa;
        }

        .main-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card {
            width: 100%;
            max-width: 700px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #28a745, #218838) !important;
            color: white;
            padding: 25px;
            text-align: center;
            position: relative;
        }

        .card-header h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: 600;
        }

        .card-body {
            padding: 30px;
        }

        .info-group {
            margin-bottom: 25px;
        }

        .info-label {
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 1.1rem;
            color: #212529;
        }

        .items-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .items-list li {
            padding: 12px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .items-list li:last-child {
            border-bottom: none;
        }

        .item-name {
            text-transform: capitalize;
            font-weight: 500;
        }

        .card-footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-home {
            background: linear-gradient(135deg, #6c757d, #5a6268);
            color: white;
        }

        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.4);
            background: linear-gradient(135deg, #5a6268, #495057);
            color: white;
        }

        .btn-download {
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
            color: white;
        }

        .btn-download:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.4);
            background: linear-gradient(135deg, #0a58ca, #084298);
            color: white;
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 10px;
            }
            
            .card-header h1 {
                font-size: 1.5rem;
                padding: 0 30px;
            }

            .card-body {
                padding: 20px;
            }

            .card-footer {
                flex-direction: column;
                gap: 10px;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="card">
            <div class="card-header">
                <h1>Booking Confirmation</h1>
            </div>
            <div class="card-body">
                <div class="info-group">
                    <div class="info-label">Name</div>
                    <div class="info-value"><?php echo htmlspecialchars($order['customer_name']); ?></div>
                </div>

                <div class="info-group">
                    <div class="info-label">Email</div>
                    <div class="info-value"><?php echo htmlspecialchars($order['customer_email']); ?></div>
                </div>

                <div class="info-group">
                    <div class="info-label">Booking Code</div>
                    <div class="info-value"><?php echo htmlspecialchars($order['ref_code']); ?></div>
                </div>

                <div class="info-group">
                    <div class="info-label">Items Ordered</div>
                    <ul class="items-list">
                        <?php foreach ($order['items'] as $item): ?>
                            <?php if ($item['quantity'] > 0): ?>
                                <li>
                                    <span class="item-name"><?php echo htmlspecialchars($item['name']); ?></span>
                                    <span>
                                        Qty: <?php echo htmlspecialchars($item['quantity']); ?> - 
                                        $<?php echo htmlspecialchars(number_format($item['total'], 2)); ?>
                                    </span>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="info-group">
                    <div class="info-label">Total Amount</div>
                    <div class="info-value">$<?php echo htmlspecialchars(number_format($order['total_price'], 2)); ?></div>
                </div>
            </div>
            
            <div class="card-footer">
                <a href="index.php" class="btn btn-home">
                    Back to Home
                </a>
                <a href="generate_pdf.php" target="_blank" class="btn btn-download">
                    Download PDF
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>