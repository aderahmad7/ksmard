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
			<div class="d-flex align-items-center justify-content-between mb-3">
				<h4 class="card-title col-sm-6">
					<div class="input-group">
						<button onclick="return setModalSimpan();" type="button" class="btn btn-outline-primary btn-add" data-bs-toggle="modal" data-bs-target="#modal-form"><i class="fa fa-plus"></i> Buat Baru</button>
						<button onclick="return setModalSalesReport();" type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal-sales-report"><i class="fa fa-file"></i> Sales Report</button>
					</div>
				</h4>
				<div class="d-flex align-items-center mb-3 col-4 col-lg-3" style="gap: 5px;">
					<?php echo form_dropdown('indkKode', $periode, (isset($_SESSION['periode_set']) ? $_SESSION['periode_set'] : ''), 'id="indkKode" class="nice-select default-select form-control wide"'); ?>
					<!-- <button class="btn btn-primary">
						<i class="fa fa-filter"></i>
					</button> -->
					<button  class="btn btn-primary" type="button" id="btn-filter-periode"><i class="fa fa-filter" data-feather="filter"></i></button>
				</div>
			</div>
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<div id="divStatusLapor">
							
						</div>
						<div class="d-flex align-items-center col-lg-3" style="gap: 5px;">
							<div class="input-group mb-3">
								<input type="text" class="form-control input-default" placeholder="Cari...">
								<button class="btn btn-primary">
									<i class="fa fa-search"></i>
								</button>
							</div>
						</div>
					</div>
					<div class="card-body">
						
						<div class="table-responsive">
							<table class="table" id="table-grid" style="width: 100%;">
								<thead>
									<tr>
										<th width="1%"></th>
										<th width="1%">NO</th>
										<th width="30%">Uraian Penjualan</th>
										<th width="10%">Jenis TBS</th>
										<th width="10%">Jenis Penjualan</th>
										<th width="5%">Harga</th>
										<th width="5%">Volume</th>
										<th width="10%">Total</th>
										<th width="10%">AKSI</th>
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
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Input Penjualan</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal">
					</button>
				</div>
				<div class="modal-body">
					<?php
					$katJual = getKategoriPenjualan();
					$katTbs = getKategoriTbs();
					$katFileJual = getTipeFileJual();
					?>
					<?php echo form_open(current_url(), array('id' => "form-simpan", 'class' => 'form-horizontal col-lg-12 col-md-12 col-xs-12')); ?>
					<div class="row">
						<input type="hidden" name="kode" id="kode">
						<div class="form-group col-lg-6 col-md-12 mb-3">
							<div class="form-group col-lg-12 col-md-12 mb-3">
								<small class="fw-semibold">Uraian Penjualan</small>
								<span class="help"></span>
								<div class="controls">
									<?php echo form_input('jualUraian', '', 'id="jualUraian" class="form-control"'); ?>

								</div>
							</div>
							<div class="form-group col-lg-12 col-md-12">
								<small class="fw-semibold">Jenis Penjualan</small>
								<span class="help"></span>
								<div class="controls">
									<?php echo form_dropdown('jualIsEkspor', $katJual, '', 'id="jualIsEkspor" class="nice-select default-select form-control wide mb-3"'); ?>

								</div>
							</div>
							<div class="form-group col-lg-12 col-md-12">
								<small class="fw-semibold">Jenis TBS</small>
								<span class="help"></span>
								<div class="controls">
									<?php echo form_dropdown('jualTbsKode', $katTbs, '', 'id="jualTbsKode" class="nice-select default-select form-control wide mb-3"'); ?>

								</div>
							</div>
							<div class="form-group col-lg-12 col-md-12 mb-3">
								<small class="fw-semibold">Harga Satuan</small>
								<span class="help"></span>
								<div class="controls">
									<?php echo form_input('jualHarga', '', 'id="jualHarga" style="text-align:right;" class="form-control"'); ?>

								</div>
							</div>
							<div class="form-group col-lg-12 col-md-12 mb-3">
								<small class="fw-semibold">Volume (kg)</small>
								<span class="help"></span>
								<div class="controls">
									<?php echo form_input('jualVolume', '', 'id="jualVolume" style="text-align:right;" class="form-control"'); ?>

								</div>
							</div>
						</div>
						<div class="form-group col-lg-6 col-md-12 mb-3">
							<div class="form-group col-lg-12 col-md-12 mb-3">
								<small class="fw-semibold">Tipe Penjualan</small>
								<span class="help"></span>
								<div class="controls">
									<?php echo form_dropdown('jualFileTipe', $katFileJual, '', 'id="jualFileTipe" class="nice-select default-select form-control wide mb-3"'); ?>

								</div>
							</div>
							<div class="form-group col-lg-12 col-md-12 mb-3">
								<small class="fw-semibold">Nomor Kontrak/Dokumen</small>
								<span class="help"></span>
								<div class="controls">
									<?php echo form_input('jualNoDokumen', '', 'id="jualNoDokumen" style="" class="form-control"'); ?>

								</div>
							</div>
							<div class="form-group col-lg-12 col-md-12 mb-3">
								<small class="fw-semibold">Tanggal Pengiriman</small>
								<span class="help"></span>
								<div class="controls">
									<input type="date" name="jualTanggal" id="jualTanggal" class="form-control"/>

								</div>
							</div>
							<div class="form-group col-lg-12 col-md-12 mb-3">
								<small class="fw-semibold">Nama Pembeli</small>
								<span class="help"></span>
								<div class="controls">
									<?php echo form_input('jualPembeli', '', 'id="jualPembeli" style="" class="form-control"'); ?>

								</div>
							</div>
							<div class="form-group col-lg-12 col-md-12 mb-3">
								<small class="fw-semibold">File (pdf/image)</small>
								<span class="help"></span>
								<div class="controls">
									<?php echo form_upload('jualFile', '', 'id="jualFile" style="text-align:right;" class="form-control"'); ?>

								</div>
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
				<div class="modal-header">Hapus Pengguna</div>
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
	<div class="modal fade" id="modal-sales-report">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">Laporan Penjualan</div>
				<div class="modal-body">
					<h4>Laporan Penjualan CPO Lokal</h4>
					<ul class="list-group mb-3">
						<li class="list-group-item d-flex justify-content-between lh-condensed">
							<div>
								<h6 class="my-0">Total Penjualan CPO</h6>
								<small class="text-muted" >Jumlah (Rp) dari seluruh penjualan CPO</small>
							</div>
							<span class="text-muted" id="rekap-cpo-lokal-total">0</span>
						</li>
						<li class="list-group-item d-flex justify-content-between lh-condensed">
							<div>
								<h6 class="my-0">FOB CPO</h6>
								<small class="text-muted">Harga Rp/Kg dari rerata penjualan CPO</small>
							</div>
							<span class="text-muted" id="rekap-cpo-lokal-fob">0</span>
						</li>
                                            
                    </ul>
					<h4>Laporan Penjualan KERNEL Lokal</h4>
					<ul class="list-group mb-3">
						<li class="list-group-item d-flex justify-content-between lh-condensed">
							<div>
								<h6 class="my-0">Total Penjualan KERNEL</h6>
								<small class="text-muted">Jumlah (Rp) dari seluruh penjualan KERNEL</small>
							</div>
							<span class="text-muted" id="rekap-inti-lokal-total">0</span>
						</li>
						<li class="list-group-item d-flex justify-content-between lh-condensed">
							<div>
								<h6 class="my-0">FOB KERNEL</h6>
								<small class="text-muted">Harga Rp/Kg dari rerata penjualan KERNEL</small>
							</div>
							<span class="text-muted" id="rekap-inti-lokal-fob">0</span>
						</li>
                                            
                    </ul>
					<h4>Laporan Penjualan CPO Ekspor</h4>
					<ul class="list-group mb-3">
						<li class="list-group-item d-flex justify-content-between lh-condensed">
							<div>
								<h6 class="my-0">Total Penjualan CPO</h6>
								<small class="text-muted">Jumlah (Rp) dari seluruh penjualan CPO</small>
							</div>
							<span class="text-muted" id="rekap-cpo-ekspor-total">0</span>
						</li>
						<li class="list-group-item d-flex justify-content-between lh-condensed">
							<div>
								<h6 class="my-0">FOB CPO</h6>
								<small class="text-muted">Harga Rp/Kg dari rerata penjualan CPO</small>
							</div>
							<span class="text-muted" id="rekap-cpo-ekspor-fob">0</span>
						</li>
                                            
                    </ul>
					<h4>Laporan Penjualan KERNEL Ekspor</h4>
					<ul class="list-group mb-3">
						<li class="list-group-item d-flex justify-content-between lh-condensed">
							<div>
								<h6 class="my-0">Total Penjualan KERNEL</h6>
								<small class="text-muted">Jumlah (Rp) dari seluruh penjualan KERNEL</small>
							</div>
							<span class="text-muted" id="rekap-inti-ekspor-total">0</span>
						</li>
						<li class="list-group-item d-flex justify-content-between lh-condensed">
							<div>
								<h6 class="my-0">FOB KERNEL</h6>
								<small class="text-muted">Harga Rp/Kg dari rerata penjualan KERNEL</small>
							</div>
							<span class="text-muted" id="rekap-inti-ekspor-fob">0</span>
						</li>
                                            
                    </ul>
				</div>
				<div class="modal-footer">
					
					<button id="btn-batal" data-bs-dismiss="modal" class="btn">Batal</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal-viewer-file">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">File</div>
				<div class="modal-body">
					<div id="fileViewerContent" class="text-center">
					<!-- Preview file akan ditampilkan di sini -->
					</div>
				</div>
				<div class="modal-footer">
					
					<button id="btn-batal" data-bs-dismiss="modal" class="btn">Batal</button>
				</div>
			</div>
			
			
		</div>
	</div>
	<div class="modal fade" id="modal-komentar">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">Komentar</div>
				<div class="modal-body">
					Komentar :
					<div id="divKomentar">
					<!-- Preview file akan ditampilkan di sini -->
					</div>
				</div>
				<div class="modal-footer">
					
					<button id="btn-batal" data-bs-dismiss="modal" class="btn">Batal</button>
				</div>
			</div>
			
			
		</div>
	</div>

	<?= $this->endSection() ?>

	<?= $this->section('scripts') ?>
	<script>
		var oTable;
		var bulanArray = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
		$(document).ready(function() {
			oTable = $('#table-grid').DataTable({
				processing: true,
				responsive: true,
				serverSide: true,
				pagingType: 'numbers',
				ajax: {
					url: '<?php echo site_url('pks/penjualan/grid'); ?>',
					data: function(d) {
						d.periode = $('#indkKode').val();
					}
				},

				lengthChange: false,
				dom: '<"top">lrt<"bottom"p>',

				columnDefs: [{
						"className": "dt-tengah",
						"targets": [1]
					},
					{
						"className": "dt-right",
						"targets": [6, 7, 5]
					},
					{
						targets: [],
						visible: false
					}
				],
				columns: [{
						className: 'dt-control',
						orderable: false,
						data: null,
						defaultContent: ''
					},
					{
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
						data: 'jualUraian'
					},
					{
						data: 'jualTbsKode'
					},
					{
						data: 'jualIsEkspor',
						name: "jualIsEkspor",
						render: function(data, type, row) {
							return (data == 0 ? "LOKAL" : "EKSPOR");
						}
					},
					{
						data: 'jualHarga',
						render: function(data, type, row) {
							return formatRupiahV3(data);
						}
					},
					{
						data: 'jualVolume',
						render: function(data, type, row) {
							return formatRibuan(data);
						}
					},
					{
						data: 'jualTotal',
						render: function(data, type, row) {
							return formatRupiahV3(data);
						}
					},
					
					{
						data: 'jualKode',
						searchable: false,
						orderable: false,
						render: function(data, type, row) {
							var edit = '<a data-id="' + data + '" style="margin :0px 0px 0px 0px ;" onclick="edit($(this));return false;" href="#" title="Ubah" class="btn btn-primary shadow btn-xs sharp"><i class="fas fa-pencil-alt"></i></a>';
							var hapus = '<a data-id="' + data + '" style="margin :0px 0px 0px 0px ;" data-bs-backdrop="static" data-bs-toggle="modal" data-bs-target="#modal-hapus" onclick="return setModalHapus($(this),\'' + data + '\');" href="#" title="Hapus" class="btn btn-primary shadow btn-xs sharp"><i class="fa fa-trash"></i></a> ';
							if (row.indkStatus=="draft")
								return "<div class='d-flex'>"+edit + hapus+"</div>";
							else if (row.indkStatus=="revisi"){
								if (row.jualKomentar!=null){
									var komen = '<a data-id="' + data + '" style="margin :0px 0px 0px 0px ;" data-bs-backdrop="static" data-bs-toggle="modal" data-bs-target="#modal-komentar" onclick="return setModalKomentar($(this),\'' + row.jualKomentar + '\');" href="#" title="Komentar" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-comment"></i></a> ';
									return "<div class='d-flex'>"+komen + edit + hapus+"</div>";
								} else 
								return "<div class='d-flex'>"+edit + hapus+"</div>";
							} else if (row.indkStatus=="divalidasi"){
								var valid = '<i class="fa fa-check" style="color:green"></i> ';
								return valid; 
								
							} else
								return "";
							
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

		// // Fungsi untuk format angka menjadi format Rupiah
		function formatRupiahV3(angka) {
			return new Intl.NumberFormat('id-ID', {
				style: 'currency',
				currency: 'IDR'
			}).format(angka);
		}

		/* Dengan Rupiah */
		var harga = document.getElementById('jualHarga');
		harga.addEventListener('keyup', function(e) {
			harga.value = formatRibuan(this.value, 'Rp ');
		});

		var volume = document.getElementById('jualVolume');
		volume.addEventListener('keyup', function(e) {
			volume.value = formatRibuan(this.value);
			console.log(volume.value);
		});








		// Formatting function for row details - modify as you need
		function format(d) {
			// `d` is the original data object for the row
			return (`
      <div class="p-3 border  rounded">
          <div class="row align-items-center">
            <div class="col-md-8 col-sm-8">
              	<ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between lh-condensed"><div>Jenis Penjualan:</div><div>`+d.jualFileTipe+`</div></li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed"><div>No. Kontrak/Dokumen:</div><div>`+d.jualNoDokumen+`</div></li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed"><div>Tanggal:</div><div>`+d.jualTanggal+`</div></li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed"><div>Pembeli:</div><div>`+d.jualPembeli+`</div></li>
            	</ul>
            </div>
			
            <div class="col-md-3 col-sm-12 text-md-end text-sm-start mt-2 mt-md-0">
              <button class="btn btn-primary btn-sm" onclick="openViewer(this.dataset.file);" data-file="`+d.jualFile+`">Lihat Kontrak/Dokumen</button>
            </div>
          </div>
        </div>
    `);
		}

		function openViewer(filename) {
    const ext = filename.split('.').pop().toLowerCase();
    const basePath = '<?=base_url();?>/uploads/'; // Ganti path sesuai folder penyimpanan
    const fullUrl = basePath + filename;

    let content = '';

    if (ext === 'pdf') {
      content = `<iframe src="${fullUrl}" width="100%" height="500px" style="border:none;"></iframe>`;
    } else if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
      content = `<img src="${fullUrl}" style="max-width:100%; max-height:500px;" alt="Gambar">`;
    } else {
      content = `<p class="text-danger">Format file tidak didukung untuk ditampilkan langsung.</p>`;
    }

    document.getElementById('fileViewerContent').innerHTML = content;

    // Tampilkan modal
    const modal = new bootstrap.Modal(document.getElementById('modal-viewer-file'));
    modal.show();
  }



		$('#btn-filter-periode').on('click', function () {
			reloadDatatable();
			getPeriode();
		});
		getPeriode();

		function reloadDatatable() {
			console.log("Reloading DataTable");
			oTable.ajax.reload(null, false);
			
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
		function setModalKomentar(dom, x) {
			$("#divKomentar").html(x);
		}



		function hapus() {
			var id = id_delete;
			$.ajax({
				url: "<?php echo base_url('pks/penjualan/hapus'); ?>",
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

		function edit(obj) {
			var id = obj.data('id');

			$.ajax({
				url: "<?php echo base_url('pks/penjualan/edit'); ?>",
				data: {
					jualKode: id
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
						$('#jualKatTbs [value="' + response.data.jualKatTbs + '"]').prop("selected", true);
						$('#jualIsEkspor [value="' + response.data.jualIsEkspor + '"]').prop("selected", true);
						$("#jualUraian").val(response.data.jualUraian);
						$("#jualHarga").val(formatRupiahV3(response.data.jualHarga));
						$("#jualVolume").val(formatRibuan(response.data.jualVolume));
						$("#jualPembeli").val(response.data.jualPembeli);
						$("#jualNoDokumen").val(response.data.jualNoDokumen);
						$("#jualTanggal").val(response.data.jualTanggal);
						$('#jualFileTipe [value="' + response.data.jualFileTipe + '"]').prop("selected", true);
						$("#kode").val(response.data.jualKode);
						$(".fa-spinner").hide();
						$("#btn-simpan").removeAttr("disabled");
					} else {
						$("#modal-form .form-body").html(response.pesan);
					}
				}
			});
		}

		function setModalSalesReport() {

			$.ajax({
				url: "<?php echo base_url('pks/penjualan/rekap'); ?>",
				data: {
					periode: $("#indkKode").val()
				},
				type: "POST",
				dataType: 'JSON',
				beforeSend: function() {
					$("#modal-sales-report").modal('show');
					
				},
				success: function(response) {
					if (response.rekap) {
						$("#rekap-cpo-lokal-total").html(formatRibuan(response.data.cpo_lokal_total));
						$("#rekap-cpo-lokal-fob").html(formatRibuan(response.data.cpo_lokal_fob));
						$("#rekap-inti-lokal-total").html(formatRibuan(response.data.inti_lokal_total));
						$("#rekap-inti-lokal-fob").html(formatRibuan(response.data.inti_lokal_fob));

						$("#rekap-cpo-ekspor-total").html(formatRibuan(response.data.cpo_ekspor_total));
						$("#rekap-cpo-ekspor-fob").html(formatRibuan(response.data.cpo_ekspor_fob));
						$("#rekap-inti-ekspor-total").html(formatRibuan(response.data.inti_ekspor_total));
						$("#rekap-inti-ekspor-fob").html(formatRibuan(response.data.inti_ekspor_fob));
					}
				}
			});
		}
		function getPeriode() {

			$.ajax({
				url: "<?php echo base_url('pks/penjualan/periode'); ?>",
				data: {
					periode: $("#indkKode").val()
				},
				type: "POST",
				dataType: 'JSON',
				success: function(response) {
					console.log(response)
					if (response.status) {
						if (response.input)
							$(".btn-add").show(); else
							$(".btn-add").hide();
						$("#divStatusLapor").html('Status Pelaporan : <b>'+response.data.indkStatus+'</b>');
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

		function setModalUpload() {
			$("#modal-upload").modal('show');
			$("#modal-upload .modal-body").show();
			$("#btn-simpan").show();
			$("#modal-upload #modal-title").html("Upload Kontrak");
		}

		$(document).delegate('.simpan', 'click', function(e) {
			e.preventDefault();
			var dataSerial = $("#form-simpan").serializeArray();
			
			var form_data = new FormData();
			form_data.append("jualIndkKode", $("#indkKode").val());
			form_data.append("jualFile", $('#jualFile')[0].files[0]);
			dataSerial.forEach((item, index) => {
				form_data.append(item['name'], item['value']);
			});
			//console.log(dataSerial);
			// for (var pair of form_data.entries()){
			// console.log(pair[0]+' : '+pair[1]);
			// }
			$(".form-control").removeClass("invalid");
			$("#kode").val('');
			$.ajax({
				url: "<?php echo site_url("pks/penjualan/simpan"); ?>",
				type : 'POST',
				processData: false,
				contentType: false,
				data : form_data,
				dataType:'json',
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
						reloadDatatable();
						msg("success", data.pesan);
						$("#modal-form").modal("hide");
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
	<?= $this->endSection() ?>