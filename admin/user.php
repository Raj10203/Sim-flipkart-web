<?php
require_once '../classes/Authentication.php';

use Classes\Authentication;

Authentication::requireSuperAdmin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap4.css">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- SweetAlert2 Dark Theme -->
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-minimal@4/minimal.css" rel="stylesheet">

    <!-- Add your meta tags here for responsiveness, SEO, and performance -->

    <!-- Custom Font Faces -->
    <link href="/admin/assets/css/font-face.css" rel="stylesheet" media="all">

    <!-- Font Awesome (Version 4 & 5 for compatibility) -->
    <link href="/admin/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="/admin/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">

    <!-- Material Design Icons -->
    <link href="/admin/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap Core CSS -->
    <link href="/admin/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS Files -->
    <link href="/admin/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="/admin/vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="/admin/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="/admin/vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="/admin/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="/admin/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- DataTables Extensions -->
    <link href="https://cdn.datatables.net/buttons/3.2.2/css/buttons.bootstrap5.min.css" rel="stylesheet"
        integrity="sha384-DJhypeLg79qWALC844KORuTtaJcH45J+36wNgzj4d1Kv1vt2PtRuV2eVmdkVmf/U" crossorigin="anonymous" />

    <link href="https://cdn.datatables.net/select/3.0.0/css/select.bootstrap5.min.css" rel="stylesheet"
        integrity="sha384-TlxQ7BelG5MWHP/TbW8dDV3/3kwuo6rinsUsoQdbLGPvurwx/DA2Z49RVLIOxVrG" crossorigin="anonymous" />

    <!-- Main Theme CSS -->
    <link href="/admin/assets/css/theme.css" rel="stylesheet" media="all">
</head>

<body>
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <?php require_once('./includes/headerMobile.php') ?>

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <?php require_once('./includes/headerDesktop.php'); ?>
            <!-- HEADER DESKTOP-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div id="select-container" class="d-flex">
                            <div id="roleDropdown" class="dropdown">
                                <button class="btn btn-light dropdown-toggle" type="button"
                                    id="roleListDropdownButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    Select Categories
                                </button>
                                <ul class="dropdown-menu light-dropdown" aria-labelledby="roleListDropdownButton"
                                    id="roleList">
                                </ul>
                            </div>
                        </div>
                        <table id="myTable" class="table table-striped table-light" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <th>Created at</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once('./includes/scripts.php') ?>

    <script src="/admin/assets/js/users.js"></script>
</body>

</html>