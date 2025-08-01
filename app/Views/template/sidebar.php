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
      <span class="brand-sub-title">GRKS BPDPKS 2025</span>
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
      <li class="<?= (current_url() == base_url("pks/beranda") ? "mm-active" : "") ?>"><a href="<?= base_url("pks/beranda") ?>" aria-expanded="false">
          <i class="fas fa-home"></i>
          <span class="nav-text">Dashboard</span>
        </a>
      </li>
      <li class="<?= ($sg2 == "periode" || $sg2 == "pelaporan" ? "mm-show" : "") ?>"><a class="has-arrow " href="javascript:void()" aria-expanded="false">
          <i class="fas fa-chart-line"></i>
          <span class="nav-text">Pelaporan</span>
        </a>
        <ul aria-expanded="false">
          <li class="<?= (current_url() == base_url("pks/periode") ? "mm-active" : "") ?>"><a href="<?= base_url("pks/periode") ?>">Periode</a></li>
          <li class="<?= (current_url() == base_url("pks/pelaporan") ? "mm-active" : "") ?>"><a href="<?= base_url("pks/pelaporan") ?>">Pelaporan Indeks K</a></li>
        </ul>
      </li>
      <li class="<?= ($sg2 == "produksi" || $sg2 == "penjualan" || $sg2 == "pajak" ? "mm-show" : "") ?>"><a class="has-arrow " href="javascript:void()" aria-expanded="false">
          <i class="fas fa-tags"></i>
          <span class="nav-text">Penjualan</span>
        </a>
        <ul aria-expanded="false">
          <li class="<?= (current_url() == base_url("pks/produksi") ? "mm-active" : "") ?>"><a href="<?= base_url("pks/produksi") ?>">Produksi</a></li>
          <li class="<?= (current_url() == base_url("pks/penjualan") ? "mm-active" : "") ?>"><a href="<?= base_url("pks/penjualan") ?>">Penjualan</a></li>
          <li class="<?= (current_url() == base_url("pks/pajak") ? "mm-active" : "") ?>"><a href="<?= base_url("pks/pajak") ?>">Pajak</a></li>
        </ul>
      </li>
      <li class="<?= ($sg2 == "pengolahan" || $sg2 == "pemasaran" || $sg2 == "pengangkutan" || $sg2 == "penyusutan" || $sg2 == "biayatidaklangsung" ? "mm-show" : "") ?>"><a class="has-arrow " href="javascript:void()" aria-expanded="false">
          <i class="fas fa-money-bill-wave"></i>
          <span class="nav-text">Biaya-Biaya</span>
        </a>
        <ul aria-expanded="false">
          <li class="<?= (current_url() == base_url("pks/pengolahan") ? "mm-active" : "") ?>"><a href="<?= base_url("pks/pengolahan") ?>">Pengolahan</a></li>
          <li class="<?= (current_url() == base_url("pks/pemasaran") ? "mm-active" : "") ?>"><a href="<?= base_url("pks/pemasaran") ?>">Pemasaran</a></li>
          <li class="<?= (current_url() == base_url("pks/pengangkutan") ? "mm-active" : "") ?>"><a href="<?= base_url("pks/pengangkutan") ?>">Pengangkutan</a></li>
          <li class="<?= (current_url() == base_url("pks/penyusutan") ? "mm-active" : "") ?>"><a href="<?= base_url("pks/penyusutan") ?>">Penyusutan</a></li>
          <li class="<?= (current_url() == base_url("pks/operasional") ? "mm-active" : "") ?>"><a href="<?= base_url("pks/biayatidaklangsung") ?>">Operasional Tidak Langsung</a></li>
        </ul>
      </li>
    </ul>
  </div>
</div>
<!--**********************************
            Sidebar end
        ***********************************-->