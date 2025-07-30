<?= $this->extend('layouts/template-dinas.php') ?>

<?= $this->section('content-dinas') ?>

<!-- Content -->
<style>
    th {
        font-size: 11pt;
    }

    td {
        font-size: 10pt;
    }
</style>
<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>

        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                        <div>
                            <h4 class="mb-3 mb-md-0">
                                Dinas
                            </h4>
                        </div>
                        <div class="d-flex align-items-center flex-wrap text-nowrap">

                            <div class="btn-group" role="group" aria-label="First group">
                                <!-- <button onclick="return setModalFilter(0);" href="#" class="btn btn-40h btn-addroot btn-outline-primary btn-filter">
						<i class="bx bx-filter-alt"></i>
					</button>
					 -->


                                <a href="#" onclick="return setModalSimpan();" class="btn btn-primary btn-sm btn-icon-text">
                                    <i class="btn-icon-prepend" data-feather="plus"></i> Buat Dinas
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="text-muted float-end">

                        <div class="input-group w-px-350">
                            <input type="text" id="field-cari" class="form-control item-input" placeholder="Cari" aria-describedby="defaultFormControlHelp">
                            <button class="btn btn-outline-primary btn-add" type="button" id="btn-cari"><i class="bx bx-search"></i></button>
                        </div>
                    </div>
                    <form method="post" id="selectedForm" action="<?php echo site_url("master_alat/download_qrcode_selected"); ?>" class="add-new-post">
                    </form>
                    <table class="table " id="table-grid">
                        <thead>
                            <tr>
                                <th width="1%">NO</th>
                                <th width="30%">NAMA</th>
                                <th width="30%">USERNAME</th>
                                <th width="9%">AKSI</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal-form" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modal-title">Dinas</h5>
            </div>
            <div class="modal-body">
                <?php echo form_open(current_url(), array('id' => "form-simpan", 'class' => 'form-horizontal col-lg-12 col-md-12 col-xs-12')); ?>
                <div class="row">
                    <input type="hidden" name="kode" id="kode">

                    <div class="form-group col-lg-12 col-md-12 mb-3">
                        <small class="fw-semibold">Nama</small>
                        <span class="help"></span>
                        <div class="controls">
                            <?php echo form_input('accNama', '', 'id="accNama" class="form-control"'); ?>
                        </div>
                    </div>

                    <div class="form-group col-lg-12 col-md-12 mb-3">
                        <small class="fw-semibold">Username</small>
                        <span class="help"></span>
                        <div class="controls">
                            <?php echo form_input('accUsername', '', 'id="accUsername" class="form-control"'); ?>
                        </div>
                    </div>

                    <div class="form-group col-lg-12 col-md-12 mb-3">
                        <small class="fw-semibold">Password</small>
                        <span class="help"></span>
                        <div class="controls">
                            <?php echo form_input('accPassword', '', 'id="accPassword" class="form-control"'); ?>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="modal-footer">
                <button id="btn-simpan" class="btn btn-primary simpan">
                    <span class="fa fa-spinner fa-spin"></span> <span class="fa fa-floppy-o"></span> Simpan
                </button>
                <button id="btn-batal-simpan" data-bs-dismiss="modal" class="btn modalbtn">Batal</button>
            </div>
        </div>
    </div>
</div>

<script>
    function setModalSimpan() {
        $("#kode").val('');
        $("#form-simpan input").val('');
        $("#modal-form").modal('show');
        $("#modal-form .modal-body").show();
        $("#btn-simpan").show();
        $("#modal-form #modal-title").html("Dinas");
    }
</script>

<?= $this->endSection() ?>