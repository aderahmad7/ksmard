<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>K Smardx</title>

    <link rel="shortcut icon" href="<?= base_url() ?>assets/compiled/svg/Logo.svg" type="image/x-icon" />
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="<?= base_url() ?>assets/compiled/css/app.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/compiled/css/ksmard2.css" />
</head>

<body>
    <div id="app">

        <!-- Start Sidebar -->
        <?= $this->include('layouts/sidebar-company'); ?>
        <!-- End Sidebar -->

        <!-- Start Header -->
        <header class="bg-white d-flex align-items-center h-100">

            <div class="header-content d-flex align-items-center w-100">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <div class="d-flex align-items-center">
                        <a href="#" class="burger-btn d-block d-xl-none">
                            <i class="bi bi-justify fs-3 d-flex align-items-center me-4 ksmard-nactive"></i>
                        </a>
                        <h4 class="mb-0 ksmard-active fw-bold"><?= $title; ?></h4>
                    </div>
                    <div class="content-right">
                        <div class="header-logo">
                            <a href="index.html">
                                <img src="assets/compiled/svg/Logo.svg" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <input type="text" placeholder="Search" class="field-search" />
            </div>
        </header>
        <!-- End Header -->

        <!-- Start Main -->
        <div id="main">
            <?= $this->renderSection('content-company') ?>
        </div>
        <!-- End Main -->

    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="<?= base_url() ?>assets/compiled/js/app.js"></script>

    <!-- Need: Apexcharts -->
    <script src="<?= base_url() ?>assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script src="<?= base_url() ?>assets/static/js/pages/dashboard.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <!-- Need: Apexcharts -->
    <script src="<?= base_url() ?>assets/static/js/pages/biaya.js"></script>
</body>

</html>