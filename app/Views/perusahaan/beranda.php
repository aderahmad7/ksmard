<?= $this->extend('layouts/template-company.php') ?>

<?= $this->section('content-company') ?>

<div class="page-content">
    <section class="row">
        <div class="col-12">
            <div class="row">
                <div class="card-100 col-4">
                    <div class="card-header">
                        <h4 class="ksmard-nactive">Index K -
                            Bulan ini</h4>
                    </div>
                    <div class="card-index-top card-100 d-flex justify-content-between">
                        <div class="card-title">
                            <h6 class="text-white">Nilai K</h6>
                        </div>
                        <div class="card-value align-self-center">
                            <h1 class="text-white">92,32%</h1>
                        </div>
                    </div>
                    <div class="card-index-bottom card-100 d-flex justify-content-between">
                        <div class="card-title">
                            <h6 class="text-white">Nilai
                                TBS</h6>
                        </div>
                        <div class="card-value align-self-center">
                            <h3 class="text-white">2.384,13</h4>
                        </div>
                    </div>
                </div>
                <div class="card-100 col-4">
                    <div class="card-header">
                        <h4 class="ksmard-nactive">Biaya</h4>
                    </div>
                    <div class="card-biaya card-100 d-flex justify-content-between bg-white flex-column">
                        <div class="card-biaya-content">
                            <h6 class="ksmard-active-secondary mb-0">Harga
                                TBS</h6>
                            <h5 class="ksmard-active">281,33</h5>
                        </div>
                        <div class="card-biaya-content">
                            <h6 class="ksmard-active-secondary mb-0">Nilai
                                TBS Timbangan Pabrik</h6>
                            <h5 class="ksmard-active">2.661,78</h5>
                        </div>
                        <div class="card-biaya-content">
                            <h6 class="ksmard-active-secondary mb-0">Biaya
                                Operasional</h6>
                            <div class="operasional-value d-flex justify-content-between">
                                <h5 class="ksmard-active">2.661,78</h5>
                                <h5 class="ksmard-active">1,58%</h5>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-header">
                <h4 class="ksmard-nactive">Riwayat Index K</h4>
            </div>
            <div class="row">
                <div class="col-8 card-100">
                    <div class="card">
                        <div class="card-body">
                            <div id="chart-profile-visit"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection() ?>