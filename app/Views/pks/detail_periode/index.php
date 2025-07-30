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
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h4 class="card-title col-sm-6">Pelaporan Indeks K</h4>

            </div>

            <div class="row">

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border border-primary ">
                        <div class="card-body p-3">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                TBS PABRIK</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 tbs_pabrik"></div>
                        </div>
                    </div>
                </div>


                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border border-primary">
                        <div class="card-body p-3">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                INDEKS K</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 indeks_k"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-striped  align-middle text-center">
                                <thead class="table-primary">
                                    <tr>
                                        <th rowspan="2" valign="middle">No</th>
                                        <th rowspan="2" valign="middle">Uraian</th>
                                        <th colspan="2">Minyak Sawit
                                            (Rp)</th>
                                        <th colspan="2">Inti Sawit
                                            (Rp)</th>
                                        <th rowspan="2" valign="middle">Tandan Buah
                                            Segar</th>
                                        <th rowspan="2" valign="middle">Status</th>
                                        <th rowspan="2" valign="middle">Aksi</th>
                                    </tr>
                                    <tr>
                                        <th>Ekspor</th>
                                        <th>Lokal</th>
                                        <th>Ekspor</th>
                                        <th>Lokal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Harga (FOB)</td>
                                        <td id="fob-cpo-ekspor"></td>
                                        <td id="fob-cpo-lokal"></td>
                                        <td id="fob-inti-ekspor"></td>
                                        <td id="fob-inti-lokal"></td>
                                        <td></td>
                                        <td><span class="badge" id="status-fob"></span></td>
                                        <td><button onclick="edit($(this));return false;" id="btn-komen-fob" class="btn btn-primary shadow btn-xs sharp btn-komen" data-bs-toggle="modal" data-bs-target="#modal-form"><i class="fa fa-comment"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Pajak</td>
                                        <td id="pajak-cpo-ekspor"></td>
                                        <td id="pajak-cpo-lokal"></td>
                                        <td id="pajak-inti-ekspor"></td>
                                        <td id="pajak-inti-lokal"></td>
                                        <td></td>
                                        <td><span class="badge" id="status-pajak"></span></td>
                                        <td><button onclick="edit($(this));return false;" id="btn-komen-pajak" class="btn btn-primary shadow btn-xs sharp btn-komen" data-bs-toggle="modal" data-bs-target="#modal-form"><i class="fa fa-comment"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Pemasaran</td>
                                        <td id="pemasaran-cpo-ekspor"></td>
                                        <td id="pemasaran-cpo-lokal"></td>
                                        <td id="pemasaran-inti-ekspor"></td>
                                        <td id="pemasaran-inti-lokal"></td>
                                        <td></td>
                                        <td><span class="badge" id="status-pemasaran"></span></td>
                                        <td><button onclick="edit($(this));return false;" id="btn-komen-pemasaran" class="btn btn-primary shadow btn-xs sharp btn-komen" data-bs-toggle="modal" data-bs-target="#modal-form"><i class="fa fa-comment"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Harga (FOB) Bersih</td>
                                        <td id="fob-bersih-cpo-ekspor"></td>
                                        <td id="fob-bersih-cpo-lokal"></td>
                                        <td id="fob-bersih-inti-ekspor"></td>
                                        <td id="fob-bersih-inti-lokal"></td>
                                        <td></td>
                                        <td><span class="badge" id="status-fob-bersih"></span></td>
                                        <td><button onclick="edit($(this));return false;" id="btn-komen-fob-bersih" class="btn btn-primary shadow btn-xs sharp btn-komen" data-bs-toggle="modal" data-bs-target="#modal-form"><i class="fa fa-comment"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Pengangkutan ke
                                            Pelabuhan</td>
                                        <td id="angkut-cpo-ekspor"></td>
                                        <td id="angkut-cpo-lokal"></td>
                                        <td id="angkut-inti-ekspor"></td>
                                        <td id="angkut-inti-lokal"></td>
                                        <td></td>
                                        <td><span class="badge" id="status-angkut"></span></td>
                                        <td><button onclick="edit($(this));return false;" id="btn-komen-angkut" class="btn btn-primary shadow btn-xs sharp btn-komen" data-bs-toggle="modal" data-bs-target="#modal-form"><i class="fa fa-comment"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>Harga Bersih Pabrik/Tangki
                                            Pabrik</td>
                                        <td id="harga_bersih-cpo-ekspor"></td>
                                        <td id="harga_bersih-cpo-lokal"></td>
                                        <td id="harga_bersih-inti-ekspor"></td>
                                        <td id="harga_bersih-inti-lokal"></td>
                                        <td></td>
                                        <td><span class="badge" id="status-harga-bersih"></span></td>
                                        <td><button onclick="edit($(this));return false;" id="btn-komen-harga-bersih" class="btn btn-primary shadow btn-xs sharp btn-komen" data-bs-toggle="modal" data-bs-target="#modal-form"><i class="fa fa-comment"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>Rendemen</td>
                                        <td id="rendemen-cpo-ekspor"></td>
                                        <td id="rendemen-cpo-lokal"></td>
                                        <td id="rendemen-inti-ekspor"></td>
                                        <td id="rendemen-inti-lokal"></td>
                                        <td></td>
                                        <td><span class="badge" id="status-rendemen"></span></td>
                                        <td><button onclick="edit($(this));return false;" id="btn-komen-rendemen" class="btn btn-primary shadow btn-xs sharp btn-komen" data-bs-toggle="modal" data-bs-target="#modal-form"><i class="fa fa-comment"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td>Harga TBS</td>
                                        <td id="harga_tbs-cpo-ekspor"></td>
                                        <td id="harga_tbs-cpo-lokal"></td>
                                        <td id="harga_tbs-inti-ekspor"></td>
                                        <td id="harga_tbs-inti-lokal"></td>
                                        <td></td>
                                        <td><span class="badge" id="status-harga-tbs"></span></td>
                                        <td><button onclick="edit($(this));return false;" id="btn-komen-harga-tbs" class="btn btn-primary shadow btn-xs sharp btn-komen" data-bs-toggle="modal" data-bs-target="#modal-form"><i class="fa fa-comment"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td>Persentase Volume
                                            Penjualan</td>
                                        <td id="vol_jual-cpo-ekspor"></td>
                                        <td id="vol_jual-cpo-lokal"></td>
                                        <td id="vol_jual-inti-ekspor"></td>
                                        <td id="vol_jual-inti-lokal"></td>
                                        <td></td>
                                        <td><span class="badge" id="status-vol-jual"></span></td>
                                        <td><button onclick="edit($(this));return false;" id="btn-komen-vol-jual" class="btn btn-primary shadow btn-xs sharp btn-komen" data-bs-toggle="modal" data-bs-target="#modal-form"><i class="fa fa-comment"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>10</td>
                                        <td>Harga TBS Rata-rata Ex
                                            Pabrik</td>
                                        <td id="expabrik-cpo-ekspor"></td>
                                        <td id="expabrik-cpo-lokal"></td>
                                        <td id="expabrik-inti-ekspor"></td>
                                        <td id="expabrik-inti-lokal"></td>
                                        <td id="expabrik-total"></td>
                                        <td><span class="badge" id="status-expabrik"></span></td>
                                        <td><button onclick="edit($(this));return false;" id="btn-komen-expabrik" class="btn btn-primary shadow btn-xs sharp btn-komen" data-bs-toggle="modal" data-bs-target="#modal-form"><i class="fa fa-comment"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>11</td>
                                        <td>Biaya Pengolahan</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td id="pengolahan"></td>
                                        <td></td>
                                        <td><span class="badge" id="status-pengolahan"></span></td>
                                        <td><button onclick="edit($(this));return false;" id="btn-komen-pengolahan" class="btn btn-primary shadow btn-xs sharp btn-komen" data-bs-toggle="modal" data-bs-target="#modal-form"><i class="fa fa-comment"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>12</td>
                                        <td>Penyusutan</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td id="penyusutan"></td>
                                        <td></td>
                                        <td><span class="badge" id="status-penyusutan"></span></td>
                                        <td><button onclick="edit($(this));return false;" id="btn-komen-penyusutan" class="btn btn-primary shadow btn-xs sharp btn-komen" data-bs-toggle="modal" data-bs-target="#modal-form"><i class="fa fa-comment"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>13</td>
                                        <td>Nilai TBS di Timbangan
                                            Pabrik</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td id="harga_timbangan">0</td>
                                        <td></td>
                                        <td><span class="badge" id="status-timbangan"></span></td>
                                        <td><button onclick="edit($(this));return false;" id="btn-komen-timbangan" class="btn btn-primary shadow btn-xs sharp btn-komen" data-bs-toggle="modal" data-bs-target="#modal-form"><i class="fa fa-comment"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>14</td>
                                        <td>Biaya Operasinal Tidak
                                            Langsung</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td id="biaya_tl">0</td>
                                        <td></td>
                                        <td><span class="badge" id="status-biaya_tl"></span></td>
                                        <td><button onclick="edit($(this));return false;" id="btn-komen-biaya_tl" class="btn btn-primary shadow btn-xs sharp btn-komen" data-bs-toggle="modal" data-bs-target="#modal-form"><i class="fa fa-comment"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td>15</td>
                                        <td>Nilai TBS Pabrik</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td id="tbs_pabrik">0</td>
                                        <td></td>
                                        <td><span class="badge" id="status-tbs_pabrik"></span></td>
                                        <td><button onclick="edit($(this));return false;" id="btn-komen-tbs_pabrik" class="btn btn-primary shadow btn-xs sharp btn-komen" data-bs-toggle="modal" data-bs-target="#modal-form"><i class="fa fa-comment"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
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
                    <input type="hidden" name="kmtKode" id="kmtKode">

                    <div class="form-group col-lg-12 col-md-12 mb-3">
                        <small class="fw-semibold">Komentar</small>
                        <span class="help"></span>
                        <div class="controls">
                            <?php echo form_textarea('kmtKomen', '', 'id="kmtKomen" class="form-control" disabled'); ?>
                        </div>
                    </div>

                    <div class="form-group col-lg-12 col-md-12 mb-3">
                        <small class="fw-semibold">Status</small>
                        <span class="help"></span>
                        <div class="controls">
                            <?php echo form_dropdown(
                                'kmtStatus',
                                ['pending' => 'Pending', 'diterima' => 'Diterima', 'ditolak' => 'Ditolak'],
                                '',
                                'id="kmtStatus" class="form-control form-select wide" disabled'
                            ); ?>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    var oTable;
    var oTable2;
    var bulanArray = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

    $(document).ready(function() {
        getRekap();
    });

    function boldIfValue(val, formattedVal) {
        return val > 0 ? `<b>${formattedVal}</b>` : formattedVal;
    }

    function getRekap() {
        let periode = "<?php echo $periode; ?>";

        $.ajax({
            url: "<?php echo base_url('dinas/beranda/rekap'); ?>",
            data: {
                'periode': periode,
            },
            type: "POST",
            dataType: 'JSON',
            beforeSend: function() {},
            success: function(res) {
                console.log(res)

                if (res.rekap) {
                    console.log(res.data.fob.status);
                    // Format and insert values into DOM
                    $("#fob-cpo-ekspor").html(boldIfValue(res.data.fob.cpo_ekspor, formatRupiahV3(res.data.fob.cpo_ekspor, 2)));
                    $("#fob-cpo-lokal").html(boldIfValue(res.data.fob.cpo_lokal, formatRupiahV3(res.data.fob.cpo_lokal, 2)));
                    $("#fob-inti-ekspor").html(boldIfValue(res.data.fob.inti_ekspor, formatRupiahV3(res.data.fob.inti_ekspor, 2)));
                    $("#fob-inti-lokal").html(boldIfValue(res.data.fob.inti_lokal, formatRupiahV3(res.data.fob.inti_lokal, 2)));
                    $("#status-fob").removeClass('badge-primary badge-danger badge-dark').addClass(res.data.fob.status == 'diterima' ? 'badge-primary' : res.data.fob.status == 'ditolak' ? 'badge-danger' : 'badge-dark').html(boldIfValue(res.data.fob.status, res.data.fob.status));
                    $("#btn-komen-fob").attr('data-id', res.data.fob.komen_kode);

                    $("#pajak-cpo-ekspor").html(boldIfValue(res.data.pajak.cpo_ekspor, formatRupiahV3(res.data.pajak.cpo_ekspor, 2)));
                    $("#pajak-cpo-lokal").html(boldIfValue(res.data.pajak.cpo_lokal, formatRupiahV3(res.data.pajak.cpo_lokal, 2)));
                    $("#pajak-inti-ekspor").html(boldIfValue(res.data.pajak.inti_ekspor, formatRupiahV3(res.data.pajak.inti_ekspor, 2)));
                    $("#pajak-inti-lokal").html(boldIfValue(res.data.pajak.inti_lokal, formatRupiahV3(res.data.pajak.inti_lokal, 2)));
                    $("#status-pajak").removeClass('badge-primary badge-danger badge-dark').addClass(res.data.pajak.status == 'diterima' ? 'badge-primary' : res.data.pajak.status == 'ditolak' ? 'badge-danger' : 'badge-dark').html(boldIfValue(res.data.pajak.status, res.data.pajak.status));
                    $("#btn-komen-pajak").attr('data-id', res.data.pajak.komen_kode);

                    $("#pemasaran-cpo-ekspor").html(boldIfValue(res.data.pemasaran.cpo_ekspor, formatRupiahV3(res.data.pemasaran.cpo_ekspor, 2)));
                    $("#pemasaran-cpo-lokal").html(boldIfValue(res.data.pemasaran.cpo_lokal, formatRupiahV3(res.data.pemasaran.cpo_lokal, 2)));
                    $("#pemasaran-inti-ekspor").html(boldIfValue(res.data.pemasaran.inti_ekspor, formatRupiahV3(res.data.pemasaran.inti_ekspor, 2)));
                    $("#pemasaran-inti-lokal").html(boldIfValue(res.data.pemasaran.inti_lokal, formatRupiahV3(res.data.pemasaran.inti_lokal, 2)));
                    $("#status-pemasaran").removeClass('badge-primary badge-danger badge-dark').addClass(res.data.pemasaran.status == 'diterima' ? 'badge-primary' : res.data.pemasaran.status == 'ditolak' ? 'badge-danger' : 'badge-dark').html(boldIfValue(res.data.pemasaran.status, res.data.pemasaran.status));
                    $("#btn-komen-pemasaran").attr('data-id', res.data.pemasaran.komen_kode);

                    $("#fob-bersih-cpo-ekspor").html(boldIfValue(res.data.fob_bersih.cpo_ekspor, formatRupiahV3(res.data.fob_bersih.cpo_ekspor, 2)));
                    $("#fob-bersih-cpo-lokal").html(boldIfValue(res.data.fob_bersih.cpo_lokal, formatRupiahV3(res.data.fob_bersih.cpo_lokal, 2)));
                    $("#fob-bersih-inti-ekspor").html(boldIfValue(res.data.fob_bersih.inti_ekspor, formatRupiahV3(res.data.fob_bersih.inti_ekspor, 2)));
                    $("#fob-bersih-inti-lokal").html(boldIfValue(res.data.fob_bersih.inti_lokal, formatRupiahV3(res.data.fob_bersih.inti_lokal, 2)));
                    $("#status-fob-bersih").removeClass('badge-primary badge-danger badge-dark').addClass(res.data.fob_bersih.status == 'diterima' ? 'badge-primary' : res.data.fob_bersih.status == 'ditolak' ? 'badge-danger' : 'badge-dark').html(boldIfValue(res.data.fob_bersih.status, res.data.fob_bersih.status));
                    $("#btn-komen-fob-bersih").attr('data-id', res.data.fob_bersih.komen_kode);

                    $("#angkut-cpo-ekspor").html(boldIfValue(res.data.angkut.cpo_ekspor, formatRupiahV3(res.data.angkut.cpo_ekspor, 2)));
                    $("#angkut-cpo-lokal").html(boldIfValue(res.data.angkut.cpo_lokal, formatRupiahV3(res.data.angkut.cpo_lokal, 2)));
                    $("#angkut-inti-ekspor").html(boldIfValue(res.data.angkut.inti_ekspor, formatRupiahV3(res.data.angkut.inti_ekspor, 2)));
                    $("#angkut-inti-lokal").html(boldIfValue(res.data.angkut.inti_lokal, formatRupiahV3(res.data.angkut.inti_lokal, 2)));
                    $("#status-angkut").removeClass('badge-primary badge-danger badge-dark').addClass(res.data.angkut.status == 'diterima' ? 'badge-primary' : res.data.angkut.status == 'ditolak' ? 'badge-danger' : 'badge-dark').html(boldIfValue(res.data.angkut.status, res.data.angkut.status));
                    $("#btn-komen-angkut").attr('data-id', res.data.angkut.komen_kode);

                    $("#harga_bersih-cpo-ekspor").html(boldIfValue(res.data.harga_bersih.cpo_ekspor, formatRupiahV3(res.data.harga_bersih.cpo_ekspor, 2)));
                    $("#harga_bersih-cpo-lokal").html(boldIfValue(res.data.harga_bersih.cpo_lokal, formatRupiahV3(res.data.harga_bersih.cpo_lokal, 2)));
                    $("#harga_bersih-inti-ekspor").html(boldIfValue(res.data.harga_bersih.inti_ekspor, formatRupiahV3(res.data.harga_bersih.inti_ekspor, 2)));
                    $("#harga_bersih-inti-lokal").html(boldIfValue(res.data.harga_bersih.inti_lokal, formatRupiahV3(res.data.harga_bersih.inti_lokal, 2)));
                    $("#status-harga-bersih").removeClass('badge-primary badge-danger badge-dark').addClass(res.data.harga_bersih.status == 'diterima' ? 'badge-primary' : res.data.harga_bersih.status == 'ditolak' ? 'badge-danger' : 'badge-dark').html(boldIfValue(res.data.harga_bersih.status, res.data.harga_bersih.status));
                    $("#btn-komen-harga-bersih").attr('data-id', res.data.harga_bersih.komen_kode);

                    $("#rendemen-cpo-ekspor").html(boldIfValue(res.data.rendemen.cpo_ekspor, res.data.rendemen.cpo_ekspor + " %"));
                    $("#rendemen-cpo-lokal").html(boldIfValue(res.data.rendemen.cpo_lokal, res.data.rendemen.cpo_lokal + " %"));
                    $("#rendemen-inti-ekspor").html(boldIfValue(res.data.rendemen.inti_ekspor, res.data.rendemen.inti_ekspor + " %"));
                    $("#rendemen-inti-lokal").html(boldIfValue(res.data.rendemen.inti_lokal, res.data.rendemen.inti_lokal + " %"));
                    $("#status-rendemen").removeClass('badge-primary badge-danger badge-dark').addClass(res.data.rendemen.status == 'diterima' ? 'badge-primary' : res.data.rendemen.status == 'ditolak' ? 'badge-danger' : 'badge-dark').html(boldIfValue(res.data.rendemen.status, res.data.rendemen.status));
                    $("#btn-komen-rendemen").attr('data-id', res.data.rendemen.komen_kode);

                    $("#harga_tbs-cpo-ekspor").html(boldIfValue(res.data.harga_tbs.cpo_ekspor, formatRupiahV3(res.data.harga_tbs.cpo_ekspor, 2)));
                    $("#harga_tbs-cpo-lokal").html(boldIfValue(res.data.harga_tbs.cpo_lokal, formatRupiahV3(res.data.harga_tbs.cpo_lokal, 2)));
                    $("#harga_tbs-inti-ekspor").html(boldIfValue(res.data.harga_tbs.inti_ekspor, formatRupiahV3(res.data.harga_tbs.inti_ekspor, 2)));
                    $("#harga_tbs-inti-lokal").html(boldIfValue(res.data.harga_tbs.inti_lokal, formatRupiahV3(res.data.harga_tbs.inti_lokal, 2)));
                    $("#status-harga-tbs").removeClass('badge-primary badge-danger badge-dark').addClass(res.data.harga_tbs.status == 'diterima' ? 'badge-primary' : res.data.harga_tbs.status == 'ditolak' ? 'badge-danger' : 'badge-dark').html(boldIfValue(res.data.harga_tbs.status, res.data.harga_tbs.status));
                    $("#btn-komen-harga-tbs").attr('data-id', res.data.harga_tbs.komen_kode);

                    $("#vol_jual-cpo-ekspor").html(boldIfValue(res.data.vol_jual.cpo_ekspor, res.data.vol_jual.cpo_ekspor + " %"));
                    $("#vol_jual-cpo-lokal").html(boldIfValue(res.data.vol_jual.cpo_lokal, res.data.vol_jual.cpo_lokal + " %"));
                    $("#vol_jual-inti-ekspor").html(boldIfValue(res.data.vol_jual.inti_ekspor, res.data.vol_jual.inti_ekspor + " %"));
                    $("#vol_jual-inti-lokal").html(boldIfValue(res.data.vol_jual.inti_lokal, res.data.vol_jual.inti_lokal + " %"));
                    $("#status-vol-jual").removeClass('badge-primary badge-danger badge-dark').addClass(res.data.vol_jual.status == 'diterima' ? 'badge-primary' : res.data.vol_jual.status == 'ditolak' ? 'badge-danger' : 'badge-dark').html(boldIfValue(res.data.vol_jual.status, res.data.vol_jual.status));
                    $("#btn-komen-vol-jual").attr('data-id', res.data.vol_jual.komen_kode);

                    $("#expabrik-cpo-ekspor").html(boldIfValue(res.data.expabrik.cpo_ekspor, formatRupiahV3(res.data.expabrik.cpo_ekspor, 2)));
                    $("#expabrik-cpo-lokal").html(boldIfValue(res.data.expabrik.cpo_lokal, formatRupiahV3(res.data.expabrik.cpo_lokal, 2)));
                    $("#expabrik-inti-ekspor").html(boldIfValue(res.data.expabrik.inti_ekspor, formatRupiahV3(res.data.expabrik.inti_ekspor, 2)));
                    $("#expabrik-inti-lokal").html(boldIfValue(res.data.expabrik.inti_lokal, formatRupiahV3(res.data.expabrik.inti_lokal, 2)));
                    $("#expabrik-total").html(boldIfValue(res.data.expabrik.total, formatRupiahV3(res.data.expabrik.total, 2)));
                    $("#status-expabrik").removeClass('badge-primary badge-danger badge-dark').addClass(res.data.expabrik.status == 'diterima' ? 'badge-primary' : res.data.expabrik.status == 'ditolak' ? 'badge-danger' : 'badge-dark').html(boldIfValue(res.data.expabrik.status, res.data.expabrik.status));
                    $("#btn-komen-expabrik").attr('data-id', res.data.expabrik.komen_kode);

                    $("#pengolahan").html(boldIfValue(res.data.pengolahan.total, formatRupiahV3(res.data.pengolahan.total, 2)));
                    $("#status-pengolahan").removeClass('badge-primary badge-danger badge-dark').addClass(res.data.pengolahan.status == 'diterima' ? 'badge-primary' : res.data.pengolahan.status == 'ditolak' ? 'badge-danger' : 'badge-dark').html(boldIfValue(res.data.pengolahan.status, res.data.pengolahan.status));
                    $("#btn-komen-pengolahan").attr('data-id', res.data.pengolahan.komen_kode);

                    $("#penyusutan").html(boldIfValue(res.data.penyusutan.total, formatRupiahV3(res.data.penyusutan.total, 2)));
                    $("#status-penyusutan").removeClass('badge-primary badge-danger badge-dark').addClass(res.data.penyusutan.status == 'diterima' ? 'badge-primary' : res.data.penyusutan.status == 'ditolak' ? 'badge-danger' : 'badge-dark').html(boldIfValue(res.data.penyusutan.status, res.data.penyusutan.status));
                    $("#btn-komen-penyusutan").attr('data-id', res.data.penyusutan.komen_kode);

                    $("#harga_timbangan").html(boldIfValue(res.data.harga_timbangan.total, formatRupiahV3(res.data.harga_timbangan.total, 2)));
                    $("#status-timbangan").removeClass('badge-primary badge-danger badge-dark').addClass(res.data.harga_timbangan.status == 'diterima' ? 'badge-primary' : res.data.harga_timbangan.status == 'ditolak' ? 'badge-danger' : 'badge-dark').html(boldIfValue(res.data.harga_timbangan.status, res.data.harga_timbangan.status));
                    $("#btn-komen-timbangan").attr('data-id', res.data.harga_timbangan.komen_kode);

                    $("#biaya_tl").html(boldIfValue(res.data.biayatl.total, formatRupiahV3(res.data.biayatl.total, 2)) + " (" + res.data.biayatl_label + ")");
                    $("#status-biaya_tl").removeClass('badge-primary badge-danger badge-dark').addClass(res.data.biayatl.status == 'diterima' ? 'badge-primary' : res.data.biayatl.status == 'ditolak' ? 'badge-danger' : 'badge-dark').html(boldIfValue(res.data.biayatl.status, res.data.biayatl.status));
                    $("#btn-komen-biaya_tl").attr('data-id', res.data.biayatl.komen_kode);

                    $("#tbs_pabrik").html(boldIfValue(res.data.harga_tbs_pabrik.total, formatRupiahV3(res.data.harga_tbs_pabrik.total, 2)));
                    $("#status-tbs_pabrik").removeClass('badge-primary badge-danger badge-dark').addClass(res.data.harga_tbs_pabrik.status == 'diterima' ? 'badge-primary' : res.data.harga_tbs_pabrik.status == 'ditolak' ? 'badge-danger' : 'badge-dark').html(boldIfValue(res.data.harga_tbs_pabrik.status, res.data.harga_tbs_pabrik.status));
                    $("#btn-komen-tbs_pabrik").attr('data-id', res.data.harga_tbs_pabrik.komen_kode);

                    $(".tbs_pabrik").html(boldIfValue(res.data.harga_tbs_pabrik.total, formatRupiah(res.data.harga_tbs_pabrik.total, 2)));
                    $(".indeks_k").html(boldIfValue(res.data.indeks_k, formatRupiahV3(res.data.indeks_k, 2) + "%"));
                    //msg("success", data.pesan);
                } else {
                    //msg("error", data.pesan);
                    console.log(data);
                }
            },
        });
    }




    // // Fungsi untuk format angka menjadi format Rupiah
    function formatRupiahV3(angka, frag = null) {
        return new Intl.NumberFormat('id-ID', {
            //style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: frag,
        }).format(angka);
    }

    // // Fungsi untuk format angka menjadi format Rupiah
    function formatRupiah(angka, frag = null) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: frag,
        }).format(angka);
    }




    function reloadDatatable() {
        oTable.ajax.reload(null, false);
    }

    function reloadDatatableHasil() {
        oTable2.ajax.reload(null, false);
    }

    function setModalHapus(dom, x) {
        var id = dom.data('id');
        id_delete = id;
        $(".fa-spinner").hide();
        $("#btn-hapus").show();
        $("#btn-batal").html("Batal");
        $("#modal-hapus .modal-header").html("Hapus");
        $("#modal-hapus .modal-body").html("Anda yakin menghapus \"<span id='id-delete'></span>\"?");
        $("#id-delete").html(x);
    }

    function setModalHapusHasil(dom, x) {
        var id = dom.data('id');
        id_delete = id;
        $(".fa-spinner").hide();
        $("#btn-hapus-hasil").show();
        $("#btn-batal-hasil").html("Batal");
        $("#modal-hapus-hasil .modal-header").html("Hapus");
        $("#modal-hapus-hasil .modal-body").html("Anda yakin menghapus \"<span id='id-delete'></span>\"?");
        $("#id-delete").html(x);
    }

    function hapus() {
        var id = id_delete;
        $.ajax({
            url: "<?php echo base_url('pks/produksi/hapus'); ?>",
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

    function hapus_hasil() {
        var id = id_delete;
        $.ajax({
            url: "<?php echo base_url('pks/hasil/hapus'); ?>",
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
                    reloadDatatableHasil();
                    msg("success", data.pesan);
                } else {
                    msg("error", data.pesan);
                }
            },
        });
    }

    function edit(obj) {
        var id = obj.data('id');
        console.log('edit ' + id);

        $.ajax({
            url: "<?php echo base_url('dinas/beranda/edit'); ?>",
            data: {
                kodeKomen: id
            },
            type: "POST",
            dataType: 'JSON',
            beforeSend: function() {
                $("#modal-form").modal('show');
                $("#modal-form .modal-body").show();
                $("#btn-simpan").show();
                $("#btn-batal-simpan").html("Tutup");
                $(".box-msg").hide();
                $("#modal-form #modal-title").html("Edit");
                $(".fa-spinner").show();
                $("#btn-simpan").attr("disabled", true);
            },
            success: function(response) {
                if (response.edit) {
                    console.log(response.data.kmtStatus);
                    $('#kmtStatus').val(response.data.kmtStatus);

                    $("#kmtKomen").val(response.data.kmtKomen);
                    $("#kmtKode").val(response.data.kmtKode);
                    $(".fa-spinner").hide();
                    $("#btn-simpan").removeAttr("disabled");
                } else {
                    $("#modal-form .form-body").html(response.pesan);
                }
            }
        });
    }

    function edit_hasil(obj) {
        var id = obj.data('id');

        $.ajax({
            url: "<?php echo base_url('pks/hasil/edit'); ?>",
            data: {
                hasilKode: id
            },
            type: "POST",
            dataType: 'JSON',
            beforeSend: function() {
                $("#modal-form-hasil").modal('show');
                $("#modal-form-hasil .modal-body").show();
                $("#btn-simpan-hasil").show();
                $("#btn-batal-simpan-hasil").html("Tutup");
                $(".box-msg").hide();
                $("#modal-form-hasil #modal-title").html("Edit");
                $(".fa-spinner").show();
                $("#btn-simpan-hasil").attr("disabled", true);
            },
            success: function(response) {
                if (response.edit) {
                    $('#hasilJenisHasil [value="' + response.data.hasilJenisHasil + '"]').prop("selected", true);

                    $("#hasilVolume").val(formatRibuan(response.data.hasilVolume));

                    $("#kodehasil").val(response.data.hasilKode);
                    $(".fa-spinner").hide();
                    $("#btn-simpan-hasil").removeAttr("disabled");
                } else {
                    $("#modal-form-hasil .form-body").html(response.pesan);
                }
            }
        });
    }

    $("#field-cari").on('keyup', function(e) {
        var code = e.which;
        if (code == 13) e.preventDefault();
        if (code == 32 || code == 13 || code == 188 || code == 186) {
            oTable.fnFilter($("#field-cari").val());
        }
    });
    $("#btn-cari").click(function() {
        oTable.fnFilter($("#field-cari").val());
    });

    function setModalSimpan() {
        $("#kode").val('');
        $("#form-simpan input").val('');
        $("#modal-form").modal('show');
        $("#modal-form .modal-body").show();
        $("#btn-simpan").show();
        $("#modal-form #modal-title").html("Penjualan");
    }

    function setModalSimpanHasil() {
        $("#kode").val('');
        $("#form-simpan-hasil input").val('');
        $("#modal-form-hasil").modal('show');
        $("#modal-form-hasil .modal-body").show();
        $("#btn-simpan-hasil").show();
        $("#modal-form-hasil #modal-title").html("Penjualan");
    }

    $(document).delegate('.simpan', 'click', function(e) {
        e.preventDefault();
        var data = $("#form-simpan").serializeArray();
        $(".form-control").removeClass("invalid")
        $("#kodehasil").val('');
        $.ajax({
            url: "<?php echo site_url("dinas/beranda/simpan"); ?>",
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
                if (data.simpan) {
                    getRekap();
                    $("#modal-form").modal('hide');
                    msg("success", data.pesan);
                } else {
                    if (!data.validasi) {
                        $("#pesan-error").show();
                        $.each(data.pesan, function(index, value) {
                            $('#' + index).after('<div class="error" style="color:red">' + value + '</div>');
                            $('#' + index).addClass('invalid');
                            console.log('My array has at position ' + index + ', this value: ' + value);
                        });
                    } else {
                        msg("error", data.pesan);
                    }


                }
            }
        });
    });

    $(document).delegate('.simpan-hasil', 'click', function(e) {
        e.preventDefault();
        var data = $("#form-simpan-hasil").serializeArray();
        data.push({
            name: "hasilIndkKode",
            value: $("#indkKode").val()
        });
        $(".form-control").removeClass("invalid")
        $("#kode").val('');
        $.ajax({
            url: "<?php echo site_url("pks/hasil/simpan"); ?>",
            data: data,
            type: "POST",
            dataType: "JSON",
            beforeSend: function() {
                $(".fa-spinner").show();
                $(".error").remove();
                $("#btn-simpan-hasil").attr("disabled", true);
                $("#btn-batal-hasil").attr("disabled", true);
            },
            success: function(data) {
                $(".fa-spinner").hide();
                $("#btn-simpan-hasil").removeAttr("disabled");
                $("#btn-batal-hasil").removeAttr("disabled");
                $("#modal-form-hasil").modal('hide');
                if (data.simpan) {
                    reloadDatatableHasil();
                    msg("success", data.pesan);
                } else {
                    if (!data.validasi) {
                        $("#pesan-error").show();
                        $.each(data.pesan, function(index, value) {
                            $('#' + index).after('<div class="error" style="color:red">' + value + '</div>');
                            $('#' + index).addClass('invalid');
                            console.log('My array has at position ' + index + ', this value: ' + value);
                        });
                    } else {
                        msg("error", data.pesan);
                    }


                }
            }
        });
    });
</script>
<script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>

<?= $this->endSection() ?>