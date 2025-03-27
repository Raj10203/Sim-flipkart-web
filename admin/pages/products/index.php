<?php
include('../../conf/authenticate_user.php');
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
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">

    <!-- Meta Tags (Required) -->
    <!-- Add your meta tags here for responsiveness, SEO, and performance -->

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
                        <a class="logo" href="#">
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
                            <a class="js-arrow" href="/admin/pages/">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                        </li>
                        <li class="active">
                            <a href="#">
                                <i class="fas fa-chart-bar"></i>Product</a>
                        </li>
                        <li>
                            <a href="../category/">
                                <i class="fas fa-table"></i>Category</a>
                        </li>
                        <li>
                            <a href="../users">
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
                        <li>
                            <a href="/admin/pages/">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                        </li>
                        <li class="active">
                            <a href="#">
                                <i class="fas fa-chart-bar"></i>Product</a>
                        </li>
                        <li>
                            <a href="../category/">
                                <i class="fas fa-table"></i>Category</a>
                        </li>
                        <li>
                            <a href="../users">
                                <i class="fas fa-user"></i>Users</a>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <?php include_once('../layout/header.php') ?>
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
                                    <th>Image Path</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Category Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Category</h5>
                </div>
                <div class="modal-body">
                    <form action="#" id="addProductForm" enctype="multipart/form-data">
                        <input type="hidden" id="addProductId" value="" name="addProductId">
                        <div class="mb-3">
                            <label for="addProductName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="addProductName" placeholder="Product Name"
                                name="addProductName" required maxlength="30" />
                        </div>
                        <div class="mb-3">
                            <label for="addImage" class="form-label">Image</label>
                            <img src="" class="tableImage d-none" alt="your image" id="showImg">
                            <input type="file" accept="image/png" class="form-control imageInput" id="addImage" required
                                name="addImage" placeholder="Image" />
                            <p id="messageImageSize"></p>
                        </div>
                        <select class="form-control select" aria-label="Default select example" id="addCategory" name="addCategory">
                            <option value="abc">abc</option>
                        </select>
                        <div class="mb-3">
                            <label for="addPrice" class="form-label">Price</label>
                            <input type="number" class="form-control" id="addPrice" placeholder="Price" required
                                name="addPrice" max="1000000000000" />
                        </div>
                        <div class="mb-3">
                            <label for="addDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="addDescription" rows="3" placeholder="Description ..." name="addDescription"
                                maxlength="100" required></textarea>
                        </div>
                        <input type="submit" class="btn btn-primary event" id="formSubmit" data-type="add-submit"
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
                    <form action="./product.html" id="editProductForm" enctype="multipart/form-data">
                        <input type="hidden" id="editProductId" value="" data-val="" name="editProductId">
                        <div class="mb-3">
                            <label for="editProductName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="editProductName" placeholder="Product Name"
                                name="editProductName" required maxlength="30" />
                        </div>
                        <div class="mb-3">
                            <label for="editImage" class="form-label">Image</label>
                            <img src="" class="tableImage" alt="your image" id="previewImage">
                            <input type="file" accept="image/png" class="form-control imageInput" id="editImage"
                                required name="editImage" placeholder="Image" />
                            <p id="messageImageSize"></p>
                        </div >
                        <div class="mb-3 form-group" >
                            <select class="form-control" aria-label="Default select example" id="editCategory">
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editPrice" class="form-label">Price</label>
                            <input type="number" class="form-control" id="editPrice" placeholder="Price" required
                                name="editPrice" max="1000000000000" />
                        </div>
                        <div class="mb-3">
                            <label for="editDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="editDescription" rows="3" placeholder="Description ..."
                                maxlength="100" required></textarea>
                        </div>
                        <input type="submit" class="btn btn-primary event" id="editFormSubmit" name="formSubmit" />
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include_once('../layout/scripts.php') ?>
    <script src="/admin/js/product.js"></script>
</body>

</html>