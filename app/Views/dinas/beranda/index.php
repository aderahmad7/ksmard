<?= $this->extend('template/body.php') ?>
<?= $this->section('content') ?>

<!-- Content -->
<style>
    th {
        font-size: 11pt;
    }

    td {
        font-size: 10pt;
    }

    .card-body.dinas {
        position: relative;
        background-color: #10CE23;
        border-radius: 10px;
        padding: 20px;
        color: white;
        text-align: center;
        font-family: Arial, sans-serif;
        height: 150px;
        /* Adjust as needed */
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .title {
        font-size: 18px;
        font-weight: 700;

    }

    .title-wrapper {
        border-radius: 10px;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        background-color: #13BF24;
        z-index: 1;
        padding: 15px;
    }

    .title-wrapper.down {
        background-color: #EC2020 !important;
    }

    .percentage {
        font-size: 40px;
        font-weight: 700;
    }

    .percentage-wrapper {
        margin-top: 60px;
        margin-bottom: 20px;
    }

    .card-body.dinas.down {
        background-color: #E34F4F !important;
    }

    .bi-justify {
        color: #ADADAD !important;
    }

    @media (max-width: 1199px) {
        .content-search {
            width: 100%;
            margin-top: 10px;
            margin-left: 0;
        }

        #main {
            margin-top: 70px;

        }

        .ksmard-active {
            display: none;
        }
    }
</style>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h4 class="card-title col-sm-6">Indeks K Perusahaan</h4>
            <div class="d-flex align-items-center mb-3 col-4 col-lg-3" style="gap: 5px;">
                <?php echo form_dropdown('indkKode', $periode, (isset($_SESSION['periode_set']) ? $_SESSION['periode_set'] : ''), 'id="indkKode" class="form-select   form-control wide"'); ?>
                <!-- <button class="btn btn-primary">
						<i class="fa fa-filter"></i>
					</button> -->
                <button onclick="getPerusahaan()" class="btn btn-primary" type="button" id="btn-filter-periode"><i class="fa fa-filter" data-feather="filter"></i></button>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="company">
                            <div class="row" id="data-perusahaan">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function getPerusahaan() {
        $.ajax({
            url: "<?php echo base_url('dinas/beranda/perusahaan'); ?>",
            data: {
                'periode': $('#indkKode').val(),
            },
            type: "POST",
            dataType: 'JSON',
            beforeSend: function() {},
            success: function(data) {
                console.log(data)
                let html = '';

                if (data.length === 0) {
                    html = `
                        <div class="col-12 mt-3">
                            <div class="alert alert-danger text-center" role="alert">
                                Tidak ada data perusahaan yang tersedia.
                            </div>
                        </div>`;
                } else {
                    data.forEach(function(item) {
                        console.log(item.semua_diterima)
                        html += `
                            <a href="<?php echo base_url('dinas/beranda/data_perusahaan/'); ?>${item.indkKode}" class="col-sm-12 col-lg-4">
                                <div class="card">
                                    <div class="card-body dinas ${item.semua_diterima ? '' : 'down'}">
                                        <div class="title-wrapper ${item.semua_diterima ? '' : 'down'}"">
                                            <div class="title">${item.pksNama}</div>
                                        </div>
                                        <div class="percentage-wrapper">
                                            <div class="percentage">${parseFloat(item.indkIndeksK).toLocaleString('id-ID', {minimumFractionDigits: 2})} %</div>
                                        </div>
                                    </div>
                                </div>
                            </a>`;
                    });
                }
                $('#data-perusahaan').html(html);
            },
            error: function(data) {
                console.log(data);
            }
        });

        console.log('beranda');
    };

    $(document).ready(function() {
        getPerusahaan();
    });
</script>
<?= $this->endSection() ?>