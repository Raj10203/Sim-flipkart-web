<?php
require_once 'classes/Authentication.php';

use Classes\Authentication;

Authentication::requireUser();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="/admin/assets/css/theme.css" rel="stylesheet" media="all">
    <link rel="stylesheet" href="./assets/css/flipkart-web.css">
</head>

<body>
    <?php require_once 'includes/header.php'; ?>
    <div class=" d-flex align-items-center justify-content-center vh-100 w-100">
        <div class="card text-center border-warning" style="height: max-content;">
            <div class=" card-body">
                <h3 class="card-title text-warning">Permission Not Granted</h3>
                <p class="card-text">You don't have the required permission to access this page.</p>
                <button class="btn btn-outline-warning" onclick="history.back()">Go Back</button>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
</body>

</html>