<?php
require_once '../classes/Authentication.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Classes\Authentication;

Authentication::requireAdmin();
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
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
            <!-- HEADER MOBILE-->

            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div id="select-container" class="d-flex">
                            <div id="categoryDropdown" class="dropdown">
                                <button class="btn btn-light dropdown-toggle" type="button" id="categoryDropdownButton"
                                    data-toggle="dropdown" aria-expanded="false">
                                    Select Categories
                                </button>
                                <ul class="dropdown-menu light-dropdown" aria-labelledby="categoryDropdownButton"
                                    id="categoryList">
                                </ul>
                            </div>
                        </div>
                        <table id="myTable" class="table table-striped table-light nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Image Path</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Discount</th>
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
                    <h5 class="modal-title" id="addModalLabel">Add Product</h5>
                </div>
                <div class="modal-body">
                    <form action="#" id="addProductForm" enctype="multipart/form-data">
                        <input type="hidden" id="addProductId" value="" name="productId">
                        <div class="mb-3">
                            <label for="addProductName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="addProductName" placeholder="Product Name"
                                name="productName" maxlength="30" />
                        </div>
                        <div class="mb-3">
                            <label for="addImage" class="form-label">Image</label>
                            <img src="" class="tableImage d-none" alt="your image" id="showImg">
                            <input type="file" accept="image/*" class="form-control imageInput" id="addImage"
                                name="image" placeholder="Image" />
                            <p id="messageImageSize"></p>
                        </div>
                        <div class="mb-3 form-group">
                            <label for="addCategory">Select Category</label>
                            <select class="form-control select" aria-label="Default select example" id="addCategory"
                                name="category">
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="addPrice" class="form-label">Price</label>
                            <input type="number" class="form-control" id="addPrice" placeholder="Price" step=".01"
                                name="price" max="1000000000000" />
                        </div>
                        <div class="mb-3">
                            <label for="addDiscount" class="form-label">Discount</label>
                            <input type="number" class="form-control" id="addDiscount" placeholder="Discount" step=".01"
                                name="discount" max="100" />
                        </div>
                        <div class="mb-3">
                            <label for="addDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="addDescription" rows="3" placeholder="Description ..."
                                name="description" maxlength="100"></textarea>
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
                    <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                </div>
                <div class="modal-body">
                    <form action="./product.html" id="editProductForm" enctype="multipart/form-data" action="#">
                        <input type="hidden" id="editProductId" value="" data-val="" name="productId">
                        <div class="mb-3">
                            <label for="editProductName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="editProductName" placeholder="Product Name"
                                name="productName" maxlength="30" />
                        </div>
                        <div class="mb-3">
                            <label for="editImage" class="form-label">Image</label>
                            <img src="" class="tableImage" alt="your image" id="previewImage">
                            <input type="file" accept="image/*" class="form-control imageInput" id="editImage"
                                name="image" placeholder="Image" />
                            <p id="messageImageSize"></p>
                        </div>
                        <div class="mb-3 form-group">
                            <label for="editCategory">Select Category</label>
                            <select class="form-control select" aria-label="Default select example" id="editCategory"
                                name="category">
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editPrice" class="form-label">Price</label>
                            <input type="number" class="form-control" id="editPrice" placeholder="Price" step=".01"
                                name="price" max="1000000000000" />
                        </div>
                        <div class="mb-3">
                            <label for="editDiscount" class="form-label">Discount</label>
                            <input type="number" class="form-control" id="editDiscount" placeholder="Discount"
                                step=".01" name="discount" max="100" />
                        </div>
                        <div class="mb-3">
                            <label for="editDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="editDescription" name="description" rows="3"
                                placeholder="Description ..." maxlength="100"></textarea>
                        </div>
                        <input type="submit" class="btn btn-primary event" id="editFormSubmit" name="formSubmit" />
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php require_once('./includes/scripts.php') ?>
    <script src="/admin/assets/js/products.js"></script>
</body>

</html>