<?php
$uri = current_url(true);
$sg1 = $uri->getSegment(1);
$sg2 = $uri->getSegment(2);
?>
<nav class="sidebar">
    <div class="sidebar-header">

        <a href="#" style="" class="sidebar-brand">
            K<span>-SMARD</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div clas<?php
                $uri = current_url(true);
                $sg1 = $uri->getSegment(1);
                $sg2 = $uri->getSegment(2);
                ?>
        <!--**********************************
        Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="index.html" class="brand-logo">
                <img src="<?= base_url(); ?>assets/images/svg/logo-huruf.svg" alt="logo ksmard" width="50px">

                <div class="brand-title">
                    <h2 class="">K-Smard</h2>
                </div>
            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="dlabnav">
            <div class="dlabnav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="<?= (current_url() == base_url("dinas/beranda") ? "mm-active" : "") ?>"><a href="<?= base_url("dinas/beranda") ?>" aria-expanded="false">
                            <i class="fas fa-home"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="<?= (current_url() == base_url("dinas/tbs") ? "mm-active" : "") ?>"><a href="<?= base_url("dinas/tbs") ?>" aria-expanded="false">
                            <i class="fas fa-file-alt"></i>
                            <span class="nav-text">TBS</span>
                        </a>
                    </li>
                    <li class="<?= (current_url() == base_url("dinas/pks") ? "mm-active" : "") ?>"><a href="<?= base_url("dinas/pks") ?>" aria-expanded="false">
                            <i class="fas fa-user-tie"></i>
                            <span class="nav-text">PKS</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->s="sidebar-body ps">
        <ul class="nav">
            <li class="nav-item <?= (current_url() == base_url("dinas/beranda") ? "active" : ""); ?>">
                <a href="<?= base_url("dinas/beranda"); ?>" class="nav-link">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">Beranda</span>
                </a>
            </li>

            <li class="nav-item nav-category">Akun</li>

            <li class="nav-item <?= (current_url() == base_url("dinas/pks") ? "active" : ""); ?>">
                <a href="<?= base_url("dinas/pks"); ?>" class="nav-link">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">Pks</span>
                </a>
            </li>
        </ul>
        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps__rail-y" style="top: 0px; right: 0px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
        </div>
    </div>
</nav>