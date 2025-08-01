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
						<button onclick="return setModalSalesReport();" type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal-sales-report"><i class="fa fa-file"></i> Ringkasan</button>
					</div>
				</h4>
				<div class="d-flex align-items-center mb-3 col-4 col-lg-3" style="gap: 5px;">
					<?php echo form_dropdown('indkKode', $periode, (isset($_SESSION['periode_set']) ? $_SESSION['periode_set'] : ''), 'id="indkKode" class="nice-select default-select form-control wide"'); ?>
					<!-- <button class="btn btn-primary">
						<i class="fa fa-filter"></i>
					</button> -->
					<button class="btn btn-primary" type="button" id="btn-filter-periode"><i class="fa fa-filter" data-feather="filter"></i></button>
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
										<th width="1%">NO</th>
										<th width="20%">Uraian Pajak</th>
										<th width="10%">Jenis TBS</th>
										<th width="10%">Jenis Penjualan</th>
										<th width="10%">Volume</th>
										<th width="30%">Total</th>
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
					<h5 class="modal-title">Input Pajak</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal">
					</button>
				</div>
				<div class="modal-body">
					<?php
					$katJual = getKategoriPenjualan();
					$katTbs = getKategoriTbs();
					?>
					<?php echo form_open(current_url(), array('id' => "form-simpan", 'class' => 'form-horizontal col-lg-12 col-md-12 col-xs-12')); ?>
					<div class="row">
						<input type="hidden" name="kode" id="kode">
						<div class="form-group col-lg-12 col-md-6 mb-3">
							<small class="fw-semibold">Uraian Pajak</small>
							<span class="help"></span>
							<div class="controls">
								<?php echo form_input('pjkUraian', '', 'id="pjkUraian" class="form-control"'); ?>

							</div>
						</div>
						<div class="form-group col-lg-6 col-md-6 mb-3">
							<small class="fw-semibold">Jenis Penjualan</small>
							<span class="help"></span>
							<div class="controls">
								<?php echo form_dropdown('pjkIsEkspor', $katJual, '', 'id="pjkIsEkspor" class="nice-select default-select form-control wide"'); ?>

							</div>
						</div>
						<div class="form-group col-lg-6 col-md-6 mb-3">
							<small class="fw-semibold">Jenis TBS</small>
							<span class="help"></span>
							<div class="controls">
								<?php echo form_dropdown('pjkTbsKode', $katTbs, '', 'id="pjkTbsKode" class="nice-select default-select form-control wide"'); ?>

							</div>
						</div>
						<div class="form-group col-lg-12 col-md-6 mb-3">
							<small class="fw-semibold">Volume</small>
							<span class="help"></span>
							<div class="controls">
								<?php echo form_input('pjkVolume', '', 'id="pjkVolume" style="text-align:right;" class="form-control"'); ?>

							</div>
						</div>
						<div class="form-group col-lg-12 col-md-6 mb-3">
							<small class="fw-semibold">Total Pajak</small>
							<span class="help"></span>
							<div class="controls">
								<?php echo form_input('pjkTotal', '', 'id="pjkTotal" style="text-align:right;" class="form-control"'); ?>

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
	<div class="modal fade" id="modal-sales-report">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">Laporan Pajak</div>
				<div class="modal-body">
					<h4>Laporan Pajak CPO</h4>
					<ul class="list-group mb-3">
						
						<li class="list-group-item d-flex justify-content-between lh-condensed">
							<div>
								<h6 class="my-0">Pajak Lokal (Rp/Kg)</h6>
								<small class="text-muted">Biaya pajak CPO</small>
							</div>
							<span class="text-muted" id="rekap-cpo-lokal">0</span>
						</li>
						<li class="list-group-item d-flex justify-content-between lh-condensed">
							<div>
								<h6 class="my-0">Pajak Ekspor (Rp/Kg)</h6>
								<small class="text-muted">Biaya pajak CPO</small>
							</div>
							<span class="text-muted" id="rekap-cpo-ekspor">0</span>
						</li>
                                            
                    </ul>
					<h4>Laporan Pajak KERNEL</h4>
					<ul class="list-group mb-3">
						<li class="list-group-item d-flex justify-content-between lh-condensed">
							<div>
								<h6 class="my-0">Pajak Lokal (Rp/Kg)</h6>
								<small class="text-muted">Biaya pajak Kernel</small>
							</div>
							<span class="text-muted" id="rekap-inti-lokal">0</span>
						</li>
						<li class="list-group-item d-flex justify-content-between lh-condensed">
							<div>
								<h6 class="my-0">Pajak Ekspor (Rp/Kg)</h6>
								<small class="text-muted">Biaya pajak Kernel</small>
							</div>
							<span class="text-muted" id="rekap-inti-ekspor">0</span>
						</li>
                                            
                    </ul>
					
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
					url: '<?php echo site_url('pks/pajak/grid'); ?>',
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
						"targets": [5]
					},
				],
				columns: [

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
						data: 'pjkUraian'
					},
					{
						data: 'pjkTbsKode'
					},
					{
						data: 'pjkIsEkspor',
						name: "pjkIsEkspor",
						render: function(data, type, row) {
							return (data == 0 ? "LOKAL" : "EKSPOR");
						}
					},
					{
						data: 'pjkVolume',
						render: function(data, type, row) {
							return (data != null ? formatRibuan(data) : 0);
						}
					},
					{
						data: 'pjkTotal',
						render: function(data, type, row) {
							return formatRupiahV3(data);
						}
					},

					{
						data: 'pjkKode',
						searchable: false,
						orderable: false,
						render: function(data, type, row) {
							var edit = '<a data-id="' + data + '" style="margin :0px 0px 0px 0px ;" onclick="edit($(this));return false;" href="#" title="Ubah" class="btn btn-primary shadow btn-xs sharp"><i class="fas fa-pencil-alt"></i></a>';
							var hapus = '<a data-id="' + data + '" style="margin :0px 0px 0px 0px ;" data-bs-backdrop="static" data-bs-toggle="modal" data-bs-target="#modal-hapus" onclick="return setModalHapus($(this),\'' + data + '\');" href="#" title="Hapus" class="btn btn-primary shadow btn-xs sharp"><i class="fa fa-trash"></i></a> ';
							if (row.indkStatus=="draft")
								return "<div class='d-flex'>"+edit + hapus+"</div>";
							else if (row.indkStatus=="revisi"){
								if (row.pjkKomentar!=null){
									var komen = '<a data-id="' + data + '" style="margin :0px 0px 0px 0px ;" data-bs-backdrop="static" data-bs-toggle="modal" data-bs-target="#modal-komentar" onclick="return setModalKomentar($(this),\'' + row.pjkKomentar + '\');" href="#" title="Komentar" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-comment"></i></a> ';
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
		var harga = document.getElementById('pjkTotal');
		harga.addEventListener('keyup', function(e) {
			harga.value = formatRibuan(this.value, 'Rp ');
		});
		var vol = document.getElementById('pjkVolume');
		vol.addEventListener('keyup', function(e) {
			vol.value = formatRibuan(this.value);
		});



		// Formatting function for row details - modify as you need
		function format(d) {
			// `d` is the original data object for the row
			return (
				'<dl>' +
				'<dt>No. Kontrak:</dt>' +
				'<dd>' +
				d.jualNoKontrak +
				'</dd>' +
				'<dt>Pembeli:</dt>' +
				'<dd>' +
				d.jualPembeli +
				'</dd>' +
				'<dt>File Kontrak:</dt>' +
				'<dd>And any further details here (images etc)...</dd>' +
				'</dl>'
			);
		}



		$('#btn-filter-periode').on('click', function () {
			reloadDatatable();
			getPeriode();
		});
		getPeriode();

		function reloadDatatable() {
			oTable.ajax.reload(null, false);
		}

		function setModalKomentar(dom, x) {
			$("#divKomentar").html(x);
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

		function setModalSalesReport() {

			$.ajax({
				url: "<?php echo base_url('pks/pajak/rekap'); ?>",
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
						$("#rekap-cpo-ekspor").html(formatRibuan(response.data.cpo_ekspor));
						$("#rekap-cpo-lokal").html(formatRibuan(response.data.cpo_lokal));
						$("#rekap-inti-ekspor").html(formatRibuan(response.data.inti_ekspor));
						$("#rekap-inti-lokal").html(formatRibuan(response.data.inti_lokal));
						
					}
				}
			});
		}
		function getPeriode() {

			$.ajax({
				url: "<?php echo base_url('pks/pajak/periode'); ?>",
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

		function hapus() {
			var id = id_delete;
			$.ajax({
				url: "<?php echo base_url('pks/pajak/hapus'); ?>",
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
				url: "<?php echo base_url('pks/pajak/edit'); ?>",
				data: {
					pjkKode: id
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
						$('#pjkKatTbs [value="' + response.data.pjkKatTbs + '"]').prop("selected", true);
						$('#pjkIsEkspor [value="' + response.data.pjkIsEkspor + '"]').prop("selected", true);
						$("#pjkUraian").val(response.data.pjkUraian);
						$("#pjkTotal").val(formatRupiahV3(response.data.pjkTotal));
						$("#pjkVolume").val(formatRibuan(response.data.pjkVolume));

						$("#kode").val(response.data.pjkKode);
						$(".fa-spinner").hide();
						$("#btn-simpan").removeAttr("disabled");
					} else {
						$("#modal-form .form-body").html(response.pesan);
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
			$("#modal-form #modal-title").html("Pajak");
		}

		$(document).delegate('.simpan', 'click', function(e) {
			e.preventDefault();
			var data = $("#form-simpan").serializeArray();
			data.push({
				name: "pjkIndkKode",
				value: $("#indkKode").val()
			});
			$(".form-control").removeClass("invalid")
			$("#kode").val('');
			$.ajax({
				url: "<?php echo site_url("pks/pajak/simpan"); ?>",
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