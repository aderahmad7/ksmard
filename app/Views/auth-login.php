<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Workload : Workload Project Management Admin  Bootstrap 5 Template" />
    <meta property="og:title" content="Workload : Workload Project Management Admin  Bootstrap 5 Template" />
    <meta property="og:description" content="Workload : Workload Project Management Admin  Bootstrap 5 Template" />
    <meta property="og:image" content="https:/workload.dexignlab.com/xhtml/social-image.png" />
    <meta name="format-detection" content="telephone=no">

    <!-- PAGE TITLE HERE -->
    <title>Login K-Smard Admin Dashboard</title>

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="images/favicon.png" />
    <link href="<?= base_url(); ?>assets/css/style.css ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url(); ?>assets__/vendors/sweetalert2/sweetalert2.min.css">

</head>

<body class="vh-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div class="text-center mb-3">
                                        <a href="#"><img src="<?= base_url(); ?>assets/images/svg/Logo.svg ?>" alt="" width="120"></a>
                                    </div>
                                    <h4 class="text-center mb-4">Sign in your account</h4>
                                    <form method="post" action="<?= base_url('login/cek') ?>">
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Username</strong></label>
                                            <input type="text" name="username" class="form-control <?= session('validation') && session('validation')->hasError('username') ? 'is-invalid' : '' ?>" value="<?= old('username') ?>">
                                            <?php if (session('validation') && session('validation')->hasError('username')): ?>
                                                <div class="invalid-feedback">
                                                    <?= session('validation')->getError('username') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <input type="password" name="password" class="form-control <?= session('validation') && session('validation')->hasError('password') ? 'is-invalid' : '' ?>">
                                            <?php if (session('validation') && session('validation')->hasError('password')): ?>
                                                <div class="invalid-feedback">
                                                    <?= session('validation')->getError('password') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="row d-flex justify-content-between mt-4 mb-2">
                                            <div class="mb-3">
                                                <div class="form-check custom-checkbox ms-1">
                                                    <input type="checkbox" class="form-check-input" id="basic_checkbox_1">
                                                    <label class="form-check-label" for="basic_checkbox_1">Remember my preference</label>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <a href="page-forgot-password.html">Forgot Password?</a>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Sign Me In</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="./vendor/global/global.min.js"></script>
    <script src="./js/custom.min.js"></script>
    <script src="./js/dlabnav-init.js"></script>
    <script src="<?php echo base_url(); ?>assets__/vendors/sweetalert2/sweetalert2.min.js"></script>

    <?php if (session()->getFlashdata('error')): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: '<?= session()->getFlashdata('error'); ?>',
                didOpen: () => {
                    document.body.classList.remove('swal2-height-auto');
                }
            });
        </script>
    <?php endif; ?> <?php if (session()->getFlashdata('success')): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                html: '<?= session()->getFlashdata('success'); ?>',
                didOpen: () => {
                    document.body.classList.remove('swal2-height-auto');
                }
            });
        </script>
    <?php endif; ?>

</body>

</html>