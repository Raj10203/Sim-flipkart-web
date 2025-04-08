<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('location: /');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Register</title>

    <!-- Fontfaces CSS-->
    <link href="/admin/assets/css/font-face.css" rel="stylesheet" media="all">
    <link href="/admin/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="/admin/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="/admin/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="/admin/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->

    <link href="/admin/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="/admin/vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="/admin/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="/admin/vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="/admin/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="/admin/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="/admin/assets/css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                                <img src="/admin/images/icon/logo.png" alt="CoolAdmin">
                            </a>
                        </div>
                        <?php
                        if (isset($_SESSION['invalid-input'])) {
                            echo ' <div class="alert alert-danger" role="alert">' . $_SESSION['invalid-input'] . '  </div>';
                        };
                        ?>
                        <div class="login-form">
                            <form action="authentication/register_user.php" method="post" id="registerForm">
                                <div class="form-group">
                                    <label for="firstName">First Name</label>
                                    <input class="au-input au-input--full" type="text" name="firstName" id="firstName" placeholder="First Name">
                                    <span class="error d-block">
                                        <?= $_SESSION['invalid_input']['firstName'] ?? '' ?>
                                    </span>
                                </div>

                                <div class="form-group">
                                    <label for="lastName">Last Name</label>
                                    <input class="au-input au-input--full" type="text" name="lastName" id="lastName" placeholder="Last Name">
                                    <span class="error d-block">
                                        <?= $_SESSION['invalid_input']['lastName'] ?? '' ?>
                                    </span>
                                </div>

                                <div class="form-group">
                                    <label for="register-email">Email Address</label>
                                    <input class="au-input au-input--full" type="email" name="email" id="register-email" placeholder="Email">
                                    <span class="error d-block">
                                        <?= $_SESSION['invalid_input']['email'] ?? '' ?>
                                    </span>
                                </div>

                                <div class="form-group">
                                    <label for="register-password">Password</label>
                                    <input class="au-input au-input--full" type="password" id="register-password" name="password" placeholder="Password">
                                    <span class="error d-block">
                                        <?= $_SESSION['invalid_input']['password'] ?? '' ?>
                                    </span>
                                </div>

                                <div class="form-group">
                                    <label for="confirmPassword">Confirm Password</label>
                                    <input class="au-input au-input--full" type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password">
                                    <span class="error d-block">
                                        <?= isset($_SESSION['invalid_input']['confirmPassword']) ? htmlspecialchars($_SESSION['invalid_input']['confirmPassword']) : '' ?>
                                    </span>
                                </div>
                                <button class="au-btn au-btn--block au-btn--blue m-b-20" type="submit">Register</button>
                            </form>
                            <div class="register-link">
                                <p>
                                    Already have account?
                                    <a href="login.php">Sign In</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php require_once('./includes/scripts.php') ?>
    <script src="/admin/assets/js/register.js"></script>


</body>

</html>
<!-- end document-->