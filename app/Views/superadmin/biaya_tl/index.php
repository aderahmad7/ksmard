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
</style>
<div class="page-content">
    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">
            <div class="mb-3">
                <h4 class="card-title col-sm-6">Periode</h4>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <button onclick="return setModalSimpan();" type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal-form"><i class="fa fa-plus"></i> Buat Baru</button>
                        <div class="d-flex align-items-center col-lg-3" style="gap: 5px;">
                            <input type="text" class="form-control input-default" placeholder="Cari...">
                            <button class="btn btn-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="table-grid" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="1%">NO</th>
                                        <th width="90%">KATEGORI BIAYA TAK LANGSUNG</th>
                                        <th width="9%">AKSI</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /# card -->
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-form">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo form_open(current_url(), array('id' => "form-simpan", 'class' => 'form-horizontal col-lg-12 col-md-12 col-xs-12')); ?>
                    <div class="row">
                        <input type="hidden" name="katbiayKode" id="katbiayKode">

                        <div class="form-group col-lg-12 col-md-12 mb-3">
                            <small class="fw-semibold">Nama Kategori</small>
                            <span class="help"></span>
                            <div class="controls">
                                <?php echo form_input('katbiayNama', '', 'id="katbiayNama" class="form-control"'); ?>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="btn-simpan" class="btn btn-primary simpan">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-hapus">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">Hapus Data</div>
                <div class="modal-body">
                    Apakah anda yakin menghapus <span hidden="true" id="id-delete"></span>?
                </div>
                <div class="modal-footer">
                    <button id="btn-hapus" class="btn btn-primary" onclick="hapus();">
                        <span class="fa fa-spinner fa-spin"></span> <i class="fa fa-trash" aria-hidden="true"></i> Hapus
                    </button>
                    <button id="btn-batal" data-bs-dismiss="modal" class="btn">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <?= $this->endSection() ?>

    <?= $this->section('scripts') ?>
    <script>
        var oTable;
        $(document).ready(function() {
            oTable = $('#table-grid').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                pagingType: 'numbers',
                ajax: {
                    url: '<?php echo site_url('superadmin/biayatl/grid'); ?>',
                },

                lengthChange: false,
                dom: '<"top">lrt<"bottom"p>',
                columns: [{
                        data: null,
                        render: function(data, type, full, meta) {
                            var length = meta.settings._iDisplayStart;
                            return meta.row + length + 1;
                        },
                        searchable: false,
                        orderable: false,
                        width: "17px"
                    },
                    {
                        data: 'katbiayNama',
                    },

                    {
                        data: null,
                        searchable: false,
                        orderable: false,
                        render: function(data, type, row) {
                            console.log(row);
                            const katbiayKode = row.katbiayKode;

                            var edit = '<a data-id="' + katbiayKode + '" style="margin :0px 1px 0px 0px ;" onclick="edit($(this));return false;" href="#" title="Ubah" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>';
                            var hapus = '<a data-id="' + katbiayKode + '" style="margin :0px 0px 0px 0px ;" data-bs-backdrop="static" data-bs-toggle="modal" data-bs-target="#modal-hapus" onclick="return setModalHapus($(this),\'' + katbiayKode + '\');" href="#" title="Hapus" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a> ';
                            return edit + hapus;
                        }
                    },
                ]
            });

            // Add event listener for opening and closing details
            oTable.on('click', 'td.dt-control', function(e) {
                let tr = e.target.closest('tr');
                let row = oTable.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                } else {
                    // Open this row
                    row.child(format(row.data())).show();
                }
            });
        });

        function reloadDatatable() {
            oTable.ajax.reload(null, false);
        }

        function setModalSimpan() {
            $("#katbiayKode").val('');
            $("#form-simpan input").val('');
            $("#form-simpan select").val('');
            $("#modal-form").modal('show');
            $("#modal-form .modal-body").show();
            $("#btn-simpan").show();
            $("#modal-form .modal-title").html("Tambah Kategori Pemasaran");
        }

        function edit(obj) {
            var id = obj.data('id');

            $.ajax({
                url: "<?php echo base_url('superadmin/biayatl/edit'); ?>",
                data: {
                    katbiayKode: id
                },
                type: "POST",
                dataType: 'JSON',
                beforeSend: function() {
                    $("#modal-form").modal('show');
                    $("#modal-form .modal-body").show();
                    $("#btn-simpan").show();
                    $("#btn-batal-simpan").html("Tutup");
                    $(".box-msg").hide();
                    $("#modal-form .modal-title").html("Edit Kategori Biaya Tak Langsung");
                    $(".fa-spinner").show();
                    $("#btn-simpan").attr("disabled", true);
                },
                success: function(response) {
                    console.log(response);

                    if (response.edit) {
                        // Isi field sesuai data kategori pemasaran
                        $("#katbiayKode").val(response.data.katbiayKode);
                        $("#katbiayNama").val(response.data.katbiayNama);

                        $(".fa-spinner").hide();
                        $("#btn-simpan").removeAttr("disabled");
                    } else {
                        $("#modal-form .form-body").html(response.pesan);
                    }
                }
            });
        }

        function setModalHapus(dom, x) {
            console.log(dom.data());
            var id = dom.data('id');
            id_delete = id;
            $(".fa-spinner").hide();
            $("#btn-hapus").show();
            $("#btn-batal").html("Batal");
            $("#modal-hapus .modal-header").html("Hapus Kategori Biaya Tak Langsung");
            $("#modal-hapus .modal-body").html("Anda yakin menghapus kategori biaya tak langsung \"<span id='id-delete'></span>\"?");
            $("#id-delete").html(x);
        }

        function hapus() {
            var id = id_delete;
            $.ajax({
                url: "<?php echo base_url('superadmin/biayatl/hapus'); ?>",
                data: {
                    'id': id
                },
                type: "POST",
                dataType: 'JSON',
                beforeSend: function() {
                    $(".fa-spinner").show();
                    $("#btn-hapus").attr("disabled", true);
                    $("#btn-batal").attr("disabled", true);
                },
                success: function(data) {
                    $(".fa-spinner").hide();
                    $("#btn-hapus").removeAttr("disabled");
                    $("#btn-batal").removeAttr("disabled");
                    $("#modal-hapus").modal('hide');
                    if (data.hapus) {
                        reloadDatatable();
                        msg("success", data.pesan);
                    } else {
                        msg("error", data.pesan);
                    }
                },
            });
        }

        $(document).delegate('.simpan', 'click', function(e) {
            e.preventDefault();
            var data = $("#form-simpan").serializeArray();
            $(".form-control").removeClass("invalid")
            $.ajax({
                url: "<?php echo site_url("superadmin/biayatl/simpan"); ?>",
                data: data,
                type: "POST",
                dataType: "JSON",
                beforeSend: function() {
                    $(".fa-spinner").show();
                    $(".error").remove();
                    $("#btn-simpan").attr("disabled", true);
                    $("#btn-batal").attr("disabled", true);
                },
                success: function(data) {
                    $(".fa-spinner").hide();
                    $("#btn-simpan").removeAttr("disabled");
                    $("#btn-batal").removeAttr("disabled");

                    console.log(data);

                    if (data.simpan) {
                        $("#modal-form").modal('hide');
                        reloadDatatable();
                        msg("success", data.pesan);
                    } else {
                        if (!data.validasi) {
                            console.log('masuk validasi')
                            $("#pesan-error").show();
                            $.each(data.pesan, function(index, value) {
                                $('#' + index).after('<div class="error" style="color:red">' + value + '</div>');
                                $('#' + index).addClass('invalid');
                                console.log('My array has at position ' + index + ', this value: ' + value);
                            });
                        } else {
                            $("#modal-form").modal('hide');
                            msg("error", data.pesan);
                        }
                    }
                }
            });
        });
    </script>
    <?= $this->endSection() ?>