<!DOCTYPE html>
<html lang="en">

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
  <title>Workload Project Management</title>

  <!-- FAVICONS ICON -->
  <link rel="shortcut icon" type="image/png" href="images/favicon.png" />
  <link href="<?= base_url() ?>assets/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/preloader.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets__/vendors/sweetalert2/sweetalert2.min.css">
  <!-- <link rel="stylesheet" href="<?= base_url(); ?>assets__/vendors/datatables.net-bs5/dataTables.bootstrap5.css"> -->
</head>

<body>

  <!--*******************
        Preloader start
    ********************-->
  <div class="preloader text-center"><img class="img-loader" src="<?= site_url(); ?>assets/images/svg/logo.svg" alt="Logo ULM" width="200px">
    <div class="cont-type">
      <div class="typewriter">
        <h1>Grant Sawit 2025</h1>
      </div>
    </div>
  </div>
  <!--*******************
        Preloader end
    ********************-->

  <!--**********************************
        Main wrapper start
    ***********************************-->
  <div id="main-wrapper">



    <!--**********************************
            Header start
        ***********************************-->
    <div class="header border-bottom">
      <div class="header-content">
        <nav class="navbar navbar-expand">
          <div class="collapse navbar-collapse justify-content-between">
            <div class="header-left">
              <div class="dashboard_bar">
                Dashboard
              </div>
            </div>
            <ul class="navbar-nav header-right">
              <li class="nav-item dropdown header-profile">
                <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                  <img src="<?= base_url(); ?>assets/images/user.jpg" width="20" alt="" />
                  <div class="header-info ms-3">
                    <span class="fs-18 font-w500 mb-2">Franklin Jr.</span>
                    <small class="fs-12 font-w400">demo@gmail.com</small>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                  <a href="#" class="dropdown-item ai-icon">
                    <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                      <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span class="ms-2">Profile </span>
                  </a>
                  <a href="#" class="dropdown-item ai-icon">
                    <svg id="icon-inbox" xmlns="http://www.w3.org/2000/svg" class="text-success" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                      <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    <span class="ms-2">Inbox </span>
                  </a>
                  <a href="<?= site_url('logout'); ?>" class="dropdown-item ai-icon">
                    <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                      <polyline points="16 17 21 12 16 7"></polyline>
                      <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span class="ms-2">Logout </span>
                  </a>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </div>
    <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

    <?php 
      $role = session()->get('role');

      if ($role == 'superadmin') {
        echo include('sidebar_superadmin.php');
      } elseif ($role == 'dinas') {
        echo include('sidebar_dinas.php');
      } else {
        echo include('sidebar.php');
      }
    ?>

    <!--**********************************
            Content body start
        ***********************************-->
    <?= $this->renderSection('content') ?>
    <!--**********************************
            Content body end
        ***********************************-->




    <!--**********************************
            Footer start
        ***********************************-->
    <div class="footer">
      <div class="copyright">
        <p>Copyright © Designed &amp; Developed by <a href="https://dexignlab.com/" target="_blank">DexignLab</a> 2022</p>
      </div>
    </div>
    <!--**********************************
            Footer end
        ***********************************-->

    <!--**********************************
           Support ticket button start
        ***********************************-->

    <!--**********************************
           Support ticket button end
        ***********************************-->


  </div>
  <!--**********************************
        Main wrapper end
    ***********************************-->

  <!--**********************************
        Scripts
    ***********************************-->
  <!-- Required vendors -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="<?= base_url() ?>assets/vendor/global/global.min.js ?>"></script>
  <script src="<?= base_url() ?>assets/vendor/chart.js/Chart.bundle.min.js"></script>

  <script src="<?= base_url() ?>assets/vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>

  <script src="<?= base_url() ?>assets/vendor/apexchart/apexchart.js"></script>
  <script src="<?= base_url() ?>assets/vendor/chart.js/Chart.bundle.min.js"></script>

  <script src="<?= base_url() ?>assets/js/plugins-init/chartjs-init.js"></script>

  <!-- datatable -->
  <!-- <script src="<?= base_url() ?>assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url() ?>assets/js/plugins-init/datatables.init.js"></script> -->

  <!-- Chart piety plugin files -->
  <script src="<?= base_url() ?>assets/vendor/peity/jquery.peity.min.js"></script>
  <!-- Dashboard 1 -->
  <script src="<?= base_url() ?>assets/js/dashboard/dashboard-1.js"></script>


  <script src="<?= base_url() ?>assets/js/dlabnav-init.js"></script>

  <!-- <script src="<?php echo base_url(); ?>assets__/vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="<?php echo base_url(); ?>assets__/vendors/datatables.net-bs5/dataTables.bootstrap5.js"></script>
  <script src="<?php echo base_url(); ?>assets__/js/template.js"></script>
  <script src="<?php echo base_url(); ?>assets__/js/data-table.js"></script> -->
  <script src="<?php echo base_url(); ?>assets__/vendors/sweetalert2/sweetalert2.min.js"></script>
  <script src="<?php echo base_url(); ?>assets__/js/init_ksmard.js"></script>
  <script src="<?= base_url() ?>assets/js/custom.min.js"></script>

  <script>
    function msg(type, msg) {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
      });

      Toast.fire({
        icon: type,
        title: msg
      })
    }
    $(".preloader").delay(1000).fadeOut('slow');
    $('.marquee').marquee({
      direction: 'left'
    });
    // START - JS SLIDING APP NAME //
    window.requestAnimationFrame = (function() {
      return window.requestAnimationFrame ||
        window.webkitRequestAnimationFrame ||
        window.mozRequestAnimationFrame ||
        function(callback) {
          window.setTimeout(callback, 1000 / 60);
        };
    })();
    var speed = 5000;
    (function currencySlide() {
      var currencyPairWidth = $('.slideItem:first-child').outerWidth();
      $(".slideContainer").animate({
        marginLeft: -currencyPairWidth
      }, speed, 'linear', function() {
        $(this).css({
          marginLeft: 0
        }).find("li:last").after($(this).find("li:first"));
      });
      requestAnimationFrame(currencySlide);
    })();
    // END - JS SLIDING APP NAME //
  </script>


  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

  <?= $this->renderSection('scripts') ?>

  <div class="content-backdrop fade"></div>
  </div>
  <!-- Content wrapper -->
  </div>
  <!-- / Layout page -->
  </div>

  <!-- Overlay -->
  <div class="layout-overlay layout-menu-toggle"></div>
  </div>
</body>

</html>