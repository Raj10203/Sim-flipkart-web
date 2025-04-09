
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flipkart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="/admin/assets/css/theme.css" rel="stylesheet" media="all">
    <link rel="stylesheet" href="./assets/css/flipkart-web.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.min.css">
</head>

<body>
    <!-- Navbar -->
    <?php include_once './includes/header.php' ?>
    <!-- fors bar for catagory -->
    <section id="body-part-1">
        <div class="container-fluid ">
            <div class="d-flex bg-white p1-placeholder">
                <div class="p1-item ">
                    <a href="#">
                        <img src="https://rukminim2.flixcart.com/flap/64/64/image/29327f40e9c4d26b.png?q=100"
                            class="img-fluid" alt="">
                        <div class="d-flex justify-content-center">
                            <span>Grocery</span>
                        </div>
                    </a>
                </div>
                <div class="p1-item ">
                    <a href="#">
                        <img src="https://rukminim2.flixcart.com/flap/64/64/image/22fddf3c7da4c4f4.png?q=100"
                            class="img-fluid" alt="">
                        <div class="d-flex justify-content-center">
                            <span>Mobile</span>
                        </div>
                    </a>
                </div>
                <div class="p1-item " id="Fashion-a">
                    <div class="dropdown">
                        <a href="#" class="fashion-dw">
                            <img src="https://rukminim2.flixcart.com/fk-p-flap/64/64/image/0d75b34f7d8fbcb3.png?q=100"
                                class="img-fluid" alt="" />
                            <div class="d-flex justify-content-center">
                                <span> Fashion
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-caret-down-fill" viewBox="0 0 16 16" id="Fashion-down-arrow">
                                        <path
                                            d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                                    </svg>
                                </span>
                            </div>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Login</a></li>
                            <li><a class="dropdown-item" href="#">Register</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </div>
                </div>
                <div class="p1-item ">
                    <a href="#">
                        <img src="https://rukminim2.flixcart.com/flap/64/64/image/69c6589653afdb9a.png?q=100"
                            class="img-fluid" alt="">
                        <div class="d-flex justify-content-center">
                            <span>Electronic</span>
                        </div>
                    </a>
                </div>
                <div class="p1-item ">
                    <a href="#">
                        <img src="https://rukminim2.flixcart.com/flap/64/64/image/ab7e2b022a4587dd.jpg?q=100"
                            class="img-fluid" alt="">
                        <div class="d-flex justify-content-center">
                            <span>Home & Furniture</span>
                        </div>
                    </a>
                </div>
                <div class="p1-item ">
                    <a href="#">
                        <img src="https://rukminim2.flixcart.com/fk-p-flap/64/64/image/0139228b2f7eb413.jpg?q=100"
                            class="img-fluid" alt="">
                        <div class="d-flex justify-content-center">
                            <span>Appliances</span>
                        </div>
                    </a>
                </div>
                <div class="p1-item ">
                    <a href="#">
                        <img src="https://rukminim2.flixcart.com/flap/64/64/image/71050627a56b4693.png?q=100"
                            class="img-fluid" alt="">
                        <div class="d-flex justify-content-center">
                            <span>Flight Booking</span>
                        </div>
                    </a>
                </div>
                <div class="p1-item ">
                    <a href="#">
                        <img src="https://rukminim2.flixcart.com/flap/64/64/image/dff3f7adcf3a90c6.png?q=100"
                            class="img-fluid" alt="">
                        <div class="d-flex justify-content-center">
                            <span>beauty, Toys & More</span>
                        </div>
                    </a>
                </div>
                <div class="p1-item ">
                    <a href="#">
                        <img src="https://rukminim2.flixcart.com/fk-p-flap/64/64/image/05d708653beff580.png?q=100"
                            class="img-fluid" alt="">
                        <div class="d-flex justify-content-center">
                            <span>Two Wheelers</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- Slider of current sale -->
    <section id="body-part-2">
        <div class="container-fluid py-2">
            <div class="bg-white p2-placeholder">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                            class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                            aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active" data-bs-interval="4000">
                            <a href="#">
                                <img src="https://rukminim2.flixcart.com/fk-p-flap/1620/270/image/ae33e00a9d467576.jpg?q=20"
                                    class="d-block w-100" alt="...">
                            </a>
                        </div>
                        <div class="carousel-item" data-bs-interval="4000">
                            <a href="#">
                                <img src="https://rukminim2.flixcart.com/fk-p-flap/1620/270/image/9600dc6f546d1164.jpeg?q=20"
                                    class="d-block w-100" alt="...">
                            </a>
                        </div>
                        <div class="carousel-item" data-bs-interval="4000">
                            <a href="#">
                                <img src="https://rukminim2.flixcart.com/fk-p-flap/1620/270/image/7f3cde58a30f6024.jpg?q=20"
                                    class="d-block w-100" alt="...">
                            </a>
                        </div>
                    </div>
                    <button class="carousel-control-prev justify-content-start" type="button"
                        data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-caret-left carousel-control-prev-icon" viewBox="0 0 16 16">
                            <path d="M10 12.796V3.204L4.519 8zm-.659.753-5.48-4.796a1 1 0 0 1 
                                0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753" />
                        </svg>
                        <span aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next justify-content-end" type="button"
                        data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-caret-right carousel-control-prev-icon" viewBox="0 0 16 16">
                            <path d="M6 12.796V3.204L11.481 8zm.659.753 5.48-4.796a1 1 0 0 
                                0 0-1.506L6.66 2.451C6.011 1.885 5 2.345 5 3.204v9.592a1 1 0 0 0 1.659.753" />
                        </svg>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <!-- Product with advertise -->
    <section id="body-part-3">
        <div class="container-fluid d-flex mt-2">
            <div class="p3-perent   ">
                <div class="p3-header p-2">
                    <h2>Best Of Electronics</h2>
                    <div>
                        <a class="btn btn-secondary" href="#item-1"> prev</a>
                        <a class="btn btn-secondary" href="#item-5"> next</a>
                    </div>
                </div>
                <div class="d-flex p3-placeholder">
                    <div class="item-p3" id="item-1">
                        <div class="card">
                            <img src="https://rukminim2.flixcart.com/image/170/170/xif0q/smartwatch/5/v/s/-original-imagxrhetgfuebnn.jpeg?q=90"
                                loading="lazy" alt="Image" class="header-image"
                                srcset="https://rukminim2.flixcart.com/image/80/80/xif0q/smartwatch/5/v/s/-original-imagxrhetgfuebnn.jpeg?q=80 1x,
                                https://rukminim2.flixcart.com/image/160/160/xif0q/smartwatch/5/v/s/-original-imagxrhetgfuebnn.jpeg?q=60 2x, ">
                            <div class="card-body">
                                <div class="p3-item-dis">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque,
                                    inventore.</div>
                                <div class="p3-item-price fw-bold ">From ₹1200</div>
                            </div>
                            <div class="dn3">
                                <svg width="16" height="16" fill="none" viewBox="0 0 17 17" style="margin-right: 8px;">
                                    <path d="m6.627 3.749 5 5-5 5" stroke="#111112" stroke-width="1.2"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="item-p3">
                        <div class="card">
                            <img src="https://rukminim2.flixcart.com/image/170/170/l58iaa80/headphone/k/z/m/nord-buds-ce-oneplus-original-imagfyk4hyvgg6ze.jpeg?q=90"
                                loading="lazy" alt="Image"
                                srcset="https://rukminim2.flixcart.com/image/80/80/l58iaa80/headphone/k/z/m/nord-buds-ce-oneplus-original-imagfyk4hyvgg6ze.jpeg?q=80 1x,
                                https://rukminim2.flixcart.com/image/160/160/l58iaa80/headphone/k/z/m/nord-buds-ce-oneplus-original-imagfyk4hyvgg6ze.jpeg?q=60 2x, "
                                class="header-image">
                            <div class="card-body">
                                <div class="p3-item-dis">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque,
                                    inventore.</div>
                                <div class="p3-item-price fw-bold ">From ₹1200</div>
                            </div>
                            <div class="dn3">
                                <svg width="16" height="16" fill="none" viewBox="0 0 17 17" style="margin-right: 8px;">
                                    <path d="m6.627 3.749 5 5-5 5" stroke="#111112" stroke-width="1.2"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="item-p3">
                        <div class="card">
                            <img src="https://rukminim2.flixcart.com/image/170/170/kcf4lu80/speaker/mobile-tablet-speaker/h/u/f/srs-xb23-sony-original-imaftk66vjxp86h5.jpeg?q=90"
                                loading="lazy" alt="Image"
                                srcset="https://rukminim2.flixcart.com/image/80/80/kcf4lu80/speaker/mobile-tablet-speaker/h/u/f/srs-xb23-sony-original-imaftk66vjxp86h5.jpeg?q=80
                                1x, https://rukminim2.flixcart.com/image/160/160/kcf4lu80/speaker/mobile-tablet-speaker/h/u/f/srs-xb23-sony-original-imaftk66vjxp86h5.jpeg?q=60 2x, "
                                class="header-image">
                            <div class="card-body">
                                <div class="p3-item-dis">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque,
                                    inventore.</div>
                                <div class="p3-item-price fw-bold ">From ₹1200</div>
                            </div>
                            <div class="dn3">
                                <svg width="16" height="16" fill="none" viewBox="0 0 17 17" style="margin-right: 8px;">
                                    <path d="m6.627 3.749 5 5-5 5" stroke="#111112" stroke-width="1.2"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="item-p3">
                        <div class="card">
                            <img src="https://rukminim2.flixcart.com/image/170/170/kz1lle80/smartwatch/m/f/q/-original-imagb54tb6fpurze.jpeg?q=90"
                                loading="lazy" alt="Image"
                                srcset="https://rukminim2.flixcart.com/image/80/80/kz1lle80/smartwatch/m/f/q/-original-imagb54tb6fpurze.jpeg?q=80 
                                1x, https://rukminim2.flixcart.com/image/160/160/kz1lle80/smartwatch/m/f/q/-original-imagb54tb6fpurze.jpeg?q=60 2x, "
                                class="header-image">
                            <div class="card-body">
                                <div class="p3-item-dis">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque,
                                    inventore.</div>
                                <div class="p3-item-price fw-bold ">From ₹1200</div>
                            </div>
                            <div class="dn3">
                                <svg width="16" height="16" fill="none" viewBox="0 0 17 17" style="margin-right: 8px;">
                                    <path d="m6.627 3.749 5 5-5 5" stroke="#111112" stroke-width="1.2"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="item-p3">
                        <div class="card">
                            <img src="https://rukminim2.flixcart.com/image/170/170/xif0q/projector/q/7/6/i9-pro-10-ei9027-led-projector-egate-original-imah5e3bggu5qcgp.jpeg?q=90"
                                loading="lazy" alt="Image"
                                srcset="https://rukminim2.flixcart.com/image/80/80/xif0q/projector/q/7/6/i9-pro-10-ei9027-led-projector-egate-original-imah5e3bggu5qcgp.jpeg?q=80 
                                1x, https://rukminim2.flixcart.com/image/160/160/xif0q/projector/q/7/6/i9-pro-10-ei9027-led-projector-egate-original-imah5e3bggu5qcgp.jpeg?q=60 2x, "
                                class="header-image">
                            <div class="card-body">
                                <div class="p3-item-dis">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque,
                                    inventore.</div>
                                <div class="p3-item-price fw-bold ">From ₹1200</div>
                            </div>
                            <div class="dn3">
                                <svg width="16" height="16" fill="none" viewBox="0 0 17 17" style="margin-right: 8px;">
                                    <path d="m6.627 3.749 5 5-5 5" stroke="#111112" stroke-width="1.2"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="item-p3" id="item-5">
                        <div class="card">
                            <img src="https://rukminim2.flixcart.com/image/170/170/krwec280/role-play-toy/z/f/w/kids-camera-mini-rechargeable-and-shockproof-camera-creative-diy-original-imag5h7gdjzrvzdr.jpeg?q=90"
                                loading="lazy" alt="Image"
                                srcset="https://rukminim2.flixcart.com/image/80/80/krwec280/role-play-toy/z/f/w/kids-camera-mini-rechargeable-and-shockproof-camera-creative-diy-original-imag5h7gdjzrvzdr.jpeg?q=80 
                                1x, https://rukminim2.flixcart.com/image/160/160/krwec280/role-play-toy/z/f/w/kids-camera-mini-rechargeable-and-shockproof-camera-creative-diy-original-imag5h7gdjzrvzdr.jpeg?q=60 2x, "
                                class="header-image">
                            <div class="card-body">
                                <div class="p3-item-dis">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque,
                                    inventore.</div>
                                <div class="p3-item-price fw-bold ">From ₹1200</div>
                            </div>
                            <div class="dn3">
                                <svg width="16" height="16" fill="none" viewBox="0 0 17 17" style="margin-right: 8px;">
                                    <path d="m6.627 3.749 5 5-5 5" stroke="#111112" stroke-width="1.2"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="advertise">
                <img src="https://rukminim2.flixcart.com/fk-p-flap/530/810/image/d5d599c240c9b2ea.jpeg?q=20" alt="">
            </div>
        </div>
    </section>
    <!-- Product without advertise -->

    <!-- Footer -->
    <footer id="footer">
        <div class="container-fluid w-100">
            <div class="footer-pp">
                <div class="footer-perent">
                    <div class="footer-child">
                        <div class="footer-title">
                            About
                        </div>
                        <div class="footer-body">
                            <a href="#">Contact us</a>
                            <a href="#">About Us</a>
                            <a href="#">Career</a>
                            <a href="#">Flipkart Stories</a>
                            <a href="#">Press</a>
                        </div>
                    </div>
                    <div class="footer-child">
                        <div class="footer-title">
                            Group Companies
                        </div>
                        <div class="footer-body">
                            <a href="#">Myntra </a>
                            <a href="#">Cleartrip</a>
                            <a href="#">Shopsy</a>
                        </div>
                    </div>
                    <div class="footer-child">
                        <div class="footer-title">
                            help
                        </div>
                        <div class="footer-body">
                            <a href="#">Contact us</a>
                            <a href="#">About Us</a>
                            <a href="#">Career</a>
                            <a href="#">Flipkart Stories</a>
                            <a href="#">Press</a>
                        </div>
                    </div>
                    <div class="footer-child">
                        <div class="footer-title">
                            Consumer Policy
                        </div>
                        <div class="footer-body">
                            <a href="#">Censelation & Returns</a>
                            <a href="#">Terms of Use</a>
                            <a href="#">Security</a>
                            <a href="#">Sitemap</a>
                            <a href="#">EPR Compilance</a>
                        </div>
                    </div>
                    <div class="d-flex ps-5 fb">
                        <div class="footer-child ">
                            <div class="footer-address ">
                                <div class="footer-title">

                                    <span>Mail Us:</span>
                                </div>
                                <div class="footer-body">
                                    <span>Flipkart Internet Private Limited, </span>
                                    <span> Buildings Alyssa, Begonia & </span>
                                    <span> Clove Embassy Tech Village, </span>
                                    <span> Outer Ring Road, Devarabeesanahalli Village, </span>
                                    <span> Bengaluru, 560103, </span>
                                    <span> Bengaluru, 560103</span>
                                    <span> Karnataka, India</span>
                                </div>
                            </div>
                            <div class="footer-Social">
                                <div class="footer-title">
                                    <span> Social:</span>
                                </div>

                                <div class="footer-icons">
                                    <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjUiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNSAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly
                                        93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEyLjkzMzEgMjFDMTcuOTAzNyAyMSAyMS45MzMxIDE2Ljk3MDYgMjEuOTMzMSAxMkMyMS45MzMxIDcuMDI5NDQgMTcu
                                        OTAzNyAzIDEyLjkzMzEgM0M3Ljk2MjU0IDMgMy45MzMxMSA3LjAyOTQ0IDMuOTMzMTEgMTJDMy45MzMxMSAxNi45NzA2IDcuOTYyNTQgMjEgMTIuOTMzMSAyMVoiIHN0cm9rZT0
                                        id2hpdGUiIHN0cm9rZS13aWR0aD0iMS41IiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPHBhdGggZD0iTTE2LjY4MzEgOC4yNUgxN
                                        S4xODMxQzE0LjU4NjQgOC4yNSAxNC4wMTQxIDguNDg3MDUgMTMuNTkyMSA4LjkwOTAxQzEzLjE3MDIgOS4zMzA5NyAxMi45MzMxIDkuOTAzMjYgMTIuOTMzMSAxMC41VjIxIiBz
                                        dHJva2U9IndoaXRlIiBzdHJva2Utd2lkdGg9IjEuNSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGQ9Ik05LjkzMzExIDE
                                        zLjVIMTUuOTMzMSIgc3Ryb2tlPSJ3aGl0ZSIgc3Ryb2tlLXdpZHRoPSIxLjUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8L3N2Zz4K"
                                        alt="Facebook" width="24" height="24">
                                    <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly
                                        93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGcgY2xpcC1wYXRoPSJ1cmwoI2NsaXAwXzE4M18yMCkiPgo8cGF0aCBkPSJNMTMuNTQzNiAxMC42MTc5TDIwLjA5NzEgM0gxOC41NDQx
                                        TDEyLjg1MzcgOS42MTQ0OEw4LjMwODg3IDNIMy4wNjY4OUw5LjkzOTY0IDEzLjAwMjNMMy4wNjY4OSAyMC45OTA4SDQuNjE5OTRMMTAuNjI5MSAxNC4wMDU2TDE1LjQyODggMj
                                        AuOTkwOEgyMC42NzA4TDEzLjU0MzIgMTAuNjE3OUgxMy41NDM2Wk0xMS40MTY1IDEzLjA5MDRMMTAuNzIwMiAxMi4wOTQ0TDUuMTc5NTMgNC4xNjkxMUg3LjU2NDkxTDEyLjAz
                                        NjMgMTAuNTY1MUwxMi43MzI2IDExLjU2MTFMMTguNTQ0OCAxOS44NzQ4SDE2LjE1OTVMMTEuNDE2NSAxMy4wOTA4VjEzLjA5MDRaIiBmaWxsPSJ3aGl0ZSIvPgo8L2c+CjxkZW
                                        ZzPgo8Y2xpcFBhdGggaWQ9ImNsaXAwXzE4M18yMCI+CjxyZWN0IHg9IjMuMDY2ODkiIHk9IjMiIHdpZHRoPSIxNy42MDM5IiBoZWlnaHQ9IjE4IiByeD0iMC4yIiBmaWxsPSJ3
                                        aGl0ZSIvPgo8L2NsaXBQYXRoPgo8L2RlZnM+Cjwvc3ZnPgo=" alt="Twitter" width="24"
                                        height="24">
                                    <img src="https://static-assets-web.flixcart.com/batman-returns/batman-returns/p/images/YoutubeLogo-8425c4.svg"
                                        alt="YouTube" width="24" height="24">
                                </div>
                            </div>
                        </div>
                        <div class="footer-child">
                            <div class="footer-title">
                                Registered Office Address
                            </div>
                            <div class="footer-body">
                                <span>Flipkart Internet Private Limited, </span>
                                <span> Buildings Alyssa, Begonia &</span>
                                <span> Clove Embassy Tech Village, </span>
                                <span> Outer Ring Road, Devarabeesanahalli Village, </span>
                                <span> Bengaluru, 560103, </span>
                                <span> Karnataka, India </span>
                                <p> Telephone:
                                    <a href="tel:044-45614700">044-45614700</a> /
                                    <a href="tel:044-67415800">044-67415800</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-brand">
                    <div class="fb-item">
                        <i class="fa-solid fa-shop"></i>
                        <span> Become a Seller</span>
                    </div>
                    <div class="fb-item">
                        <i class="fa-solid fa-user"></i>
                        <span> Help Center</span>
                    </div>
                    <div class="fb-item">
                        <i class="fa-solid fa-envelope"></i>
                        <span> Gmail </span>
                    </div>
                    <div class="fb-item">
                        <i class="fa-solid fa-gift"></i>
                        <span> Gift Center</span>
                    </div>
                    <div class="fb-item">
                        <img src="https://static-assets-web.flixcart.com/batman-returns/batman-returns/p/images/payment-method-c454fb.svg"
                            alt="Payment methods" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="./assets/js/flipkart.js"></script>
</body>

</html>