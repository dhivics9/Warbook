<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "warbook";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['ref_code'])) {
        $ref_code = $_POST['ref_code'];
    } else {
        echo "Error: Booking reference code is missing.";
        exit;
    }
    if (empty($ref_code)) {
        echo "Error: Booking reference code cannot be empty.";
        exit;
    }
    $ketoprak_quantity = $_POST['ketoprak_quantity'];
    $seblak_quantity = $_POST['seblak_quantity'];
    $nyemek_quantity = $_POST['nyemek_quantity'];

    $ketoprak_price = 10;
    $seblak_price = 8;
    $nyemek_price = 12;

    $total_ketoprak_price = $ketoprak_quantity * $ketoprak_price;
    $total_seblak_price = $seblak_quantity * $seblak_price;
    $total_nyemek_price = $nyemek_quantity * $nyemek_price;

    $total_price = $total_ketoprak_price + $total_seblak_price + $total_nyemek_price;

    $items = [
        ['name' => 'ketoprak', 'quantity' => $ketoprak_quantity, 'price' => $ketoprak_price, 'total' => $total_ketoprak_price],
        ['name' => 'seblak', 'quantity' => $seblak_quantity, 'price' => $seblak_price, 'total' => $total_seblak_price],
        ['name' => 'nyemek', 'quantity' => $nyemek_quantity, 'price' => $nyemek_price, 'total' => $total_nyemek_price]
    ];

    foreach ($items as $item) {
        $sql = "INSERT INTO orders (booking_ref_code, item_name, quantity, price, total, ref_code) VALUES ('$ref_code', '{$item['name']}', '{$item['quantity']}', '{$item['price']}', '{$item['total']}', '$ref_code')";

        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
            exit;
        }
    }

    $customer_sql = "SELECT name, email FROM bookings WHERE ref_code = '$ref_code'";
    $customer_result = $conn->query($customer_sql);

    if ($customer_result->num_rows > 0) {
        $customer = $customer_result->fetch_assoc();
        $customer_name = $customer['name'];
        $customer_email = $customer['email'];
    } else {
        echo "Error: Customer details not found.";
        exit;
    }

    $_SESSION['order'] = [
        'ref_code' => $ref_code,
        'items' => $items,
        'total_price' => $total_price,
        'customer_name' => $customer_name,
        'customer_email' => $customer_email
    ];

    require_once 'vendor/autoload.php';

    \Midtrans\Config::$serverKey = 'SB-Mid-server-Zy2S0U4eVkwA9jzH_tI3WEGT';
    \Midtrans\Config::$isProduction = false;
    \Midtrans\Config::$isSanitized = true;
    \Midtrans\Config::$is3ds = true;

    $params = array(
        'transaction_details' => array(
            'order_id' => rand(),
            'gross_amount' => $total_price,
        ),
        'customer_details' => array(
            'first_name' => $customer_name,
            'last_name' => "",
            'email' => $customer_email,
            'phone' => "",
        ),
    );

    try {
        $snapToken = \Midtrans\Snap::getSnapToken($params);
    } catch (Exception $e) {
        echo "Payment Error: " . $e->getMessage();
        exit;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
            max-width: 800px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
        }

        .card-header {
            border-radius: 15px 15px 0 0 !important;
            background: linear-gradient(135deg, #0d6efd, #0a58ca) !important;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 20px;
        }

        .card-header h3 {
            margin: 0;
            font-weight: 600;
            flex-grow: 1;
            text-align: center;
            padding-right: 80px;
        }

        .card-body {
            padding: 30px;
        }

        .table {
            margin-top: 20px;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .btn-success {
            padding: 12px 30px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #28a745, #218838);
            border: none;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
            background: linear-gradient(135deg, #218838, #1e7e34);
        }

        .back-button {
            color: white;
            padding: 8px 20px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            font-weight: 500;
            min-width: 80px;
        }

        .card-footer {
            background-color: #f8f9fa;
            border-radius: 0 0 15px 15px !important;
            padding: 20px;
        }

        .total-price {
            font-size: 1.3rem;
            color: #0d6efd;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 10px;
            }
            
            .card-header {
                padding: 15px;
            }

            .card-header h3 {
                font-size: 1.2rem;
                padding-right: 0;
            }

            .back-button {
                padding: 6px 12px;
                min-width: 60px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="card">
            <div class="card-header text-white">
                <a href="javascript:history.back()" class="back-button">
                    ← Back
                </a>
                <h3>Order Summary</h3>
            </div>
            <div class="card-body">
                <h4 class="mb-4">Your Order Details</h4>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Item</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>ketoprak</td>
                            <td><?= $ketoprak_quantity ?></td>
                            <td>$<?= number_format($ketoprak_price, 2) ?></td>
                            <td>$<?= number_format($total_ketoprak_price, 2) ?></td>
                        </tr>
                        <tr>
                            <td>seblak</td>
                            <td><?= $seblak_quantity ?></td>
                            <td>$<?= number_format($seblak_price, 2) ?></td>
                            <td>$<?= number_format($total_seblak_price, 2) ?></td>
                        </tr>
                        <tr>
                            <td>nyemek</td>
                            <td><?= $nyemek_quantity ?></td>
                            <td>$<?= number_format($nyemek_price, 2) ?></td>
                            <td>$<?= number_format($total_nyemek_price, 2) ?></td>
                        </tr>
                    </tbody>
                </table>
                <hr>
                <h5 class="text-end total-price">Total Price: $<?= number_format($total_price, 2) ?></h5>
            </div>
            <div class="card-footer text-center">
                <button id="pay-button" class="btn btn-success">Proceed to Payment</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-t-kzh3hHnvYNMIyY"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function(){
            window.snap.pay('<?= $snapToken ?>', {
                onSuccess: function(result){
                    window.location.href = 'result.php';
                },
                onPending: function(result){
                    console.log('Payment pending: ', result);
                },
                onError: function(result){
                    console.log('Payment error: ', result);
                },
                onClose: function(){
                    console.log('Payment popup closed without finishing the payment');
                }
            });
        };
    </script>
</body>
</html>