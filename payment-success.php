<?php
require_once 'classes/Authentication.php';

use Classes\Authentication;

Authentication::requireLogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Payment Successful</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .success-box {
            max-width: 600px;
            margin: 80px auto;
            padding: 40px;
            background: white;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease-in-out;
        }

        .success-icon {
            font-size: 60px;
            color: #28a745;
        }
    </style>
</head>

<body>
    <div class="success-box">
        <div class="success-icon">✔️</div>
        <h2 class="my-3">Payment Successful!</h2>
        <p class="text-muted">Thank you for your purchase. Your payment has been processed successfully.</p>
        <a href="orders.php" class="btn btn-primary mt-4">Go to My Orders</a>
    </div>
</body>

</html>