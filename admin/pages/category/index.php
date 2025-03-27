<?php
include('../../conf/authenticate_user.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap4.css">

<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<!-- SweetAlert2 Dark Theme -->
<link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">

<!-- Meta Tags (Required) -->
<!-- Add your meta tags here for responsiveness, SEO, and performance -->

<!-- Page Title -->
<title>Dashboard</title>

<!-- Custom Font Faces -->
<link href="/admin/css/font-face.css" rel="stylesheet" media="all">

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
<link href="/admin/css/theme.css" rel="stylesheet" media="all">

</head>

<body>
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="index.html">
                            <img src="/admin/images/icon/logo.png" alt="CoolAdmin" />
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        <li class="has-sub">
                            <a href="../">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                        </li>
                        <li>
                            <a href="../products/">
                                <i class="fas fa-chart-bar"></i>Product</a>
                        </li>
                        <li class="active">
                            <a href="#">
                                <i class="fas fa-table"></i>Category</a>
                        </li>
                        <li>
                            <a href="../users/">
                                <i class="fas fa-user"></i>Users</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="#">
                    <img src="/admin/images/icon/logo.png" alt="Cool Admin" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li class="has-sub">
                            <a href="../">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                        </li>
                        <li>
                            <a href="../products/">
                                <i class="fas fa-chart-bar"></i>Product</a>
                        </li>
                        <li class="active">
                            <a href="#">
                                <i class="fas fa-table"></i>Category</a>
                        </li>
                        <li>
                            <a href="../users/">
                                <i class="fas fa-user"></i>Users</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <?php
            include_once('../layout/header.php')
                ?>

            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="notifications">
                        </div>
                        <!-- PAGE CONTAINER-->
                        <table id="myTable" class="table table-striped table-light nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Models -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Category</h5>
                    
                </div>
                <div class="modal-body">
                    <form action="#" id="addCategoryForm" method="post">
                        <input name="cateforyId" type="hidden" id="categoryId" value="1">
                        <div class="mb-3">
                            <label for="categoryName" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="categoryName" name="categoryName"
                                placeholder="Category Name" required maxlength="30" />
                        </div>
                        <div class="mb-3">
                            <label for="categoryDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="categoryDescription" placeholder="Description ..."
                                name="categoryDescription" maxlength="200" required></textarea>
                        </div>
                        <input type="submit" class="btn event btn-primary" id="formSubmit" data-type="add-submit"
                            name="formSubmit" />
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Edit Models -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Category</h5>
                   
                </div>
                <div class="modal-body">
                    <form action="#" id="editCategoryForm" method="post">
                        <input name="categoryId" type="hidden" id="categoryId" value="1">
                        <div class="mb-3">
                            <label for="editCategoryName" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="editCategoryName" name="categoryName"
                                placeholder="Category Name" required maxlength="30" />
                        </div>
                        <div class="mb-3">
                            <label for="editCategoryDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="editCategoryDescription" placeholder="Description ..."
                                name="categoryDescription" maxlength="200" required></textarea>
                        </div>
                        <input type="submit" class="btn event btn-primary" id="editFormSubmit" data-type="add-submit"
                            name="editFormSubmit" />
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery (Required for most plugins) -->
    <script src="/admin/vendor/jquery-3.2.1.min.js"></script>

    <!-- Bootstrap JS (Includes Popper.js for tooltips & popovers) -->
    <script src="/admin/vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="/admin/vendor/bootstrap-4.1/bootstrap.min.js"></script>

    <!-- Vendor JS Plugins -->
    <script src="/admin/vendor/slick/slick.min.js"></script> <!-- Slick Slider -->
    <script src="/admin/vendor/wow/wow.min.js"></script> <!-- WOW.js for animations -->
    <script src="/admin/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js"></script> <!-- Progress Bars -->
    <script src="/admin/vendor/counter-up/jquery.waypoints.min.js"></script> <!-- Counter Animations -->
    <script src="/admin/vendor/counter-up/jquery.counterup.min.js"></script> <!-- Counter -->
    <script src="/admin/vendor/circle-progress/circle-progress.min.js"></script> <!-- Circle Progress -->
    <script src="/admin/vendor/perfect-scrollbar/perfect-scrollbar.js"></script> <!-- Scrollbar Styling -->
    <script src="/admin/vendor/chartjs/Chart.bundle.min.js"></script> <!-- Chart.js for charts -->
    <script src="/admin/vendor/select2/select2.min.js"></script> <!-- Select2 for better dropdowns -->

    <!-- Main JavaScript -->
    <script src="/admin/js/main.js"></script>

    <!-- Latest jQuery (Ensures compatibility with newer plugins) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Bootstrap 5 Bundle (Includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <!-- SweetAlert2 (For better alerts & confirmations) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- DataTables & Export Plugins -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"
        integrity="sha384-+mbV2IY1Zk/X1p/nWllGySJSUN8uMs+gUAN10Or95UBH0fpj6GfKgPmgC5EXieXG"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"
        integrity="sha384-VFQrHzqBh5qiJIU0uGU5CIW3+OWpdGGJM9LBnGbuIH2mkICcFZ7lPd/AAtI7SNf7"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"
        integrity="sha384-/RlQG9uf0M2vcTw3CX7fbqgbj/h8wKxw7C3zu9/GxcBPRKOEcESxaxufwRXqzq6n"
        crossorigin="anonymous"></script>

    <!-- DataTables Core -->
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"
        integrity="sha384-AenwROccLjIcbIsJuEZmrLlBzwrhvO94q+wm9RwETq4Kkqv9npFR2qbpdMhsehX3"
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.min.js"
        integrity="sha384-G85lmdZCo2WkHaZ8U1ZceHekzKcg37sFrs4St2+u/r2UtfvSDQmQrkMsEx4Cgv/W"
        crossorigin="anonymous"></script>

    <!-- DataTables Buttons (Export Features) -->
    <script src="https://cdn.datatables.net/buttons/3.2.2/js/dataTables.buttons.min.js"
        integrity="sha384-DmaAfo+/+UjRKHPidNNswlNqd9ybuE6yx9zKHyMY+vYy9SZhQEu4nauMVgwSx4Z/"
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.bootstrap5.min.js"
        integrity="sha384-BdedgzbgcQH1hGtNWLD56fSa7LYUCzyRMuDzgr5+9etd1/W7eT0kHDrsADMmx60k"
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.colVis.min.js"
        integrity="sha384-LC8PmH0Tdjy6c1Hesl75hUSKQuoIo3PCAr3svr0xJ4y90sNaTEMLK5n68Fl5VBqB"
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.html5.min.js"
        integrity="sha384-+E6fb8f66UPOVDHKlEc1cfguF7DOTQQ70LNUnlbtywZiyoyQWqtrMjfTnWyBlN/Y"
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.print.min.js"
        integrity="sha384-FvTRywo5HrkPlBKFrm2tT8aKxIcI/VU819roC/K/8UrVwrl4XsF3RKRKiCAKWNly"
        crossorigin="anonymous"></script>

    <!-- DataTables Select Plugin -->
    <script src="https://cdn.datatables.net/select/3.0.0/js/dataTables.select.min.js"
        integrity="sha384-Y/112jU1UJsyj7J/WhficUVfFZTLF2TgmBuDHBvJmYS8f+dGaz3ZNKxgwcg4YgP9"
        crossorigin="anonymous"></script>

    <!-- Custom JavaScript -->
    <script src="/admin/js/category.js"></script>

</body>

</html>