<?php
session_start();

if (isset($_SESSION['booking_code'])) {
    $booking_code = $_SESSION['booking_code'];
} else {
    echo "No booking code found. Please book a seat first.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Order</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            padding: 20px;
            text-align: center;
        }

        h2 {
            margin-bottom: 40px;
        }

        .row {
            display: flex;
            justify-content: center;
            align-items: stretch;
            gap: 30px;
            margin: 0;
        }

        .card-wrapper {
            flex: 0 0 300px;
            max-width: 300px;
            margin: 0;
        }

        .card {
            height: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.3);
        }

        .card-img-top {
            border-radius: 10px 10px 0 0;
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            padding: 15px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .card-text {
            font-size: 1rem;
            margin-bottom: 15px;
        }

        .d-flex {
            align-items: center;
            justify-content: space-between;
        }

        .btn-outline-secondary {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background-color: #007bff;
            color: white;
        }

        .btn-primary {
            font-size: 1.25rem;
            padding: 15px 30px;
            margin-top: 30px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: scale(1.05);
        }

        @media (max-width: 992px) {
            .row {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Menu Makanan Warbook</h2>
        
        <form id="orderForm" action="process_order.php" method="POST">
            <input type="hidden" name="ref_code" value="<?php echo $booking_code; ?>">
            <div class="row">
                <div class="card-wrapper">
                    <div class="card">
                        <img src="public/images/ketoprak.jpg" class="card-img-top" alt="Ketoprak">
                        <div class="card-body">
                            <h5 class="card-title">Ketoprak Top</h5>
                            <p class="card-text">Ketoprak lejat dan bergiji well</p>
                            <p class="card-text"><strong>Price: $10</strong></p>
                            <div class="d-flex">
                                <button type="button" class="btn btn-outline-secondary" id="minus-ketoprak">-</button>
                                <input type="number" name="ketoprak_quantity" id="ketoprak-quantity" class="form-control mx-2" value="0" min="0" readonly style="width: 60px;">
                                <button type="button" class="btn btn-outline-secondary" id="plus-ketoprak">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-wrapper">
                    <div class="card">
                        <img src="public/images/seblak.jpg" class="card-img-top" alt="Seblak">
                        <div class="card-body">
                            <h5 class="card-title">Seblak Jelek</h5>
                            <p class="card-text">Seblak dengan Garam dan Madu</p>
                            <p class="card-text"><strong>Price: $8</strong></p>
                            <div class="d-flex">
                                <button type="button" class="btn btn-outline-secondary" id="minus-seblak">-</button>
                                <input type="number" name="seblak_quantity" id="seblak-quantity" class="form-control mx-2" value="0" min="0" readonly style="width: 60px;">
                                <button type="button" class="btn btn-outline-secondary" id="plus-seblak">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-wrapper">
                    <div class="card">
                        <img src="public/images/nyemek.jpg" class="card-img-top" alt="Nyemek">
                        <div class="card-body">
                            <h5 class="card-title">Mie Nyemeg Bangladesh</h5>
                            <p class="card-text">Mie diinjak dengan kaki</p>
                            <p class="card-text"><strong>Price: $12</strong></p>
                            <div class="d-flex">
                                <button type="button" class="btn btn-outline-secondary" id="minus-nyemek">-</button>
                                <input type="number" name="nyemek_quantity" id="nyemek-quantity" class="form-control mx-2" value="0" min="0" readonly style="width: 60px;">
                                <button type="button" class="btn btn-outline-secondary" id="plus-nyemek">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Place Order</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('plus-ketoprak').addEventListener('click', function() {
            var quantity = document.getElementById('ketoprak-quantity');
            quantity.value = parseInt(quantity.value) + 1;
        });

        document.getElementById('minus-ketoprak').addEventListener('click', function() {
            var quantity = document.getElementById('ketoprak-quantity');
            if (quantity.value > 0) {
                quantity.value = parseInt(quantity.value) - 1;
            }
        });

        document.getElementById('plus-seblak').addEventListener('click', function() {
            var quantity = document.getElementById('seblak-quantity');
            quantity.value = parseInt(quantity.value) + 1;
        });

        document.getElementById('minus-seblak').addEventListener('click', function() {
            var quantity = document.getElementById('seblak-quantity');
            if (quantity.value > 0) {
                quantity.value = parseInt(quantity.value) - 1;
            }
        });

        document.getElementById('plus-nyemek').addEventListener('click', function() {
            var quantity = document.getElementById('nyemek-quantity');
            quantity.value = parseInt(quantity.value) + 1;
        });

        document.getElementById('minus-nyemek').addEventListener('click', function() {
            var quantity = document.getElementById('nyemek-quantity');
            if (quantity.value > 0) {
                quantity.value = parseInt(quantity.value) - 1;
            }
        });

        document.getElementById('orderForm').addEventListener('submit', function(event) {
            var ketoprakQuantity = parseInt(document.getElementById('ketoprak-quantity').value);
            var seblakQuantity = parseInt(document.getElementById('seblak-quantity').value);
            var nyemekQuantity = parseInt(document.getElementById('nyemek-quantity').value);

            if (ketoprakQuantity === 0 && seblakQuantity === 0 && nyemekQuantity === 0) {
                event.preventDefault();
                alert('Please select at least one item.');
            }
        });
    </script>
</body>
</html>
