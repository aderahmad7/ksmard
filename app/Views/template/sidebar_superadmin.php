<?php
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
            <li class="<?= (current_url() == base_url("superadmin/beranda") ? "mm-active" : "") ?>"><a href="<?= base_url("superadmin/beranda") ?>" aria-expanded="false">
                    <i class="fas fa-home"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li class="<?= (current_url() == base_url("superadmin/dinas") ? "mm-active" : "") ?>"><a href="<?= base_url("superadmin/dinas") ?>" aria-expanded="false">
                    <i class="fas fa-user-tie"></i>
                    <span class="nav-text">Dinas</span>
                </a>
            </li>
            <li class="<?= ($sg2 == "pengolahan" || $sg2 == "pemasaran" || $sg2 == "pengangkutan" || $sg2 == "penyusutan" || $sg2 == "biayatidaklangsung" ? "mm-show" : "") ?>">
                <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fas fa-th-list"></i>
                    <span class="nav-text">Kategori</span>
                </a>
                <ul aria-expanded="false">
                    <li class="<?= (current_url() == base_url("superadmin/dinassetting") ? "mm-active" : "") ?>"><a
                            href="<?= base_url("superadmin/dinassetting") ?>">Persentase Dinas</a></li>
                    <li class="<?= (current_url() == base_url("superadmin/produksi") ? "mm-active" : "") ?>"><a
                            href="<?= base_url("superadmin/produksi") ?>">Produksi</a></li>
                    <li class="<?= (current_url() == base_url("superadmin/pemasaran") ? "mm-active" : "") ?>"><a
                            href="<?= base_url("superadmin/pemasaran") ?>">Pemasaran</a></li>
                    <li class="<?= (current_url() == base_url("superadmin/pengolahan") ? "mm-active" : "") ?>"><a
                            href="<?= base_url("superadmin/pengolahan") ?>">Pengolahan</a></li>
                    <li class="<?= (current_url() == base_url("superadmin/penyusutan") ? "mm-active" : "") ?>"><a
                            href="<?= base_url("superadmin/penyusutan") ?>">Penyusutan</a></li>
                    <li class="<?= (current_url() == base_url("superadmin/biayatl") ? "mm-active" : "") ?>"><a
                            href="<?= base_url("superadmin/biayatl") ?>">Biaya Tidak Langsung</a></li>
                    <li class="<?= (current_url() == base_url("superadmin/laporan") ? "mm-active" : "") ?>"><a
                            href="<?= base_url("superadmin/laporan") ?>">Laporan</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!--**********************************
            Sidebar end
        ***********************************-->