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
				<h4 class="card-title col-sm-6">Penjualan</h4>
				<div class="d-flex align-items-center mb-3 col-4 col-lg-3" style="gap: 5px;">
					<?php echo form_dropdown('indkKode', $periode, (isset($_SESSION['periode_set']) ? $_SESSION['periode_set'] : ''), 'id="indkKode" class="form-select   form-control wide"'); ?>
					<!-- <button class="btn btn-primary">
						<i class="fa fa-filter"></i>
					</button> -->
					<button onclick="reloadDatatable()" class="btn btn-primary" type="button" id="btn-filter-periode"><i class="fa fa-filter" data-feather="filter"></i></button>
				</div>
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
										<th width="1%"></th>
										<th width="1%">NO</th>
										<th width="30%">Uraian Penjualan</th>
										<th width="10%">Jenis TBS</th>
										<th width="10%">Jenis Penjualan</th>
										<th width="5%">Harga</th>
										<th width="5%">Volume</th>
										<th width="10%">Total</th>
										<th width="0%">No. Kontrak</th>
										<th width="0%">Pembeli</th>
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
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Modal title</h5>
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
							<small class="fw-semibold">Uraian Penjualan</small>
							<span class="help"></span>
							<div class="controls">
								<?php echo form_input('jualUraian', '', 'id="jualUraian" class="form-control"'); ?>

							</div>
						</div>
						<div class="form-group col-lg-6 col-md-6 mb-3">
							<small class="fw-semibold">Jenis Penjualan</small>
							<span class="help"></span>
							<div class="controls">
								<?php echo form_dropdown('jualIsEkspor', $katJual, '', 'id="jualIsEkspor" class="form-select   form-control wide"'); ?>

							</div>
						</div>
						<div class="form-group col-lg-6 col-md-6 mb-3">
							<small class="fw-semibold">Jenis TBS</small>
							<span class="help"></span>
							<div class="controls">
								<?php echo form_dropdown('jualTbsKode', $katTbs, '', 'id="jualTbsKode" class="form-select   form-control wide"'); ?>

							</div>
						</div>
						<div class="form-group col-lg-12 col-md-6 mb-3">
							<small class="fw-semibold">Harga Satuan</small>
							<span class="help"></span>
							<div class="controls">
								<?php echo form_input('jualHarga', '', 'id="jualHarga" style="text-align:right;" class="form-control"'); ?>

							</div>
						</div>
						<div class="form-group col-lg-12 col-md-6 mb-3">
							<small class="fw-semibold">Volume</small>
							<span class="help"></span>
							<div class="controls">
								<?php echo form_input('jualVolume', '', 'id="jualVolume" style="text-align:right;" class="form-control"'); ?>

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
	<div class="modal fade" id="modal-upload">
		<div class="modal-dialog" role="document">
			<div class="modal-header">
				<h5 id="modal-title">
					Upload Kontrak
				</h5>
			</div>
			<div class="modal-body">
				<input type="hidden" name="pindokKode" id="pindokKode">
				<div class="mb-3">
					<label class="form-label" for="formFile">File upload</label>
					<input class="form-control" type="file" id="file" name="file">
				</div>
			</div>
			<div class="modal-footer">
				<button id="btn-simpan-dokumen" class="btn btn-primary modalbtn" onclick="simpanDokumen();">
					Upload
				</button>
				<button id="btn-batal-dokumen" data-bs-dismiss="modal" class="btn modalbtn">Batal</button>
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
						targets: [8, 9],
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
						data: 'jualNoKontrak'
					},
					{
						data: 'jualPembeli'
					},
					{
						data: 'jualKode',
						searchable: false,
						orderable: false,
						render: function(data, type, row) {
							var edit = '<a data-id="' + data + '" style="margin :0px 1px 0px 0px ;" onclick="edit($(this));return false;" href="#" title="Ubah" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>';
							var hapus = '<a data-id="' + data + '" style="margin :0px 0px 0px 0px ;" data-bs-backdrop="static" data-bs-toggle="modal" data-bs-target="#modal-hapus" onclick="return setModalHapus($(this),\'' + data + '\');" href="#" title="Hapus" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a> ';
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
      <div class="p-3 border bg-light rounded">
          <div class="row align-items-center">
            <div class="col-md-9 col-sm-12">
              <table width="100%">
			  	<tr>
					<td  width="20%"><b>Nomor Kontrak</b></td>
					<td width="70%"><b>Pembeli</b></td>
					<td width="10%"><b>File Kontrak</b></td>
				</tr>
				<tr>
					<td>` + d.jualNoKontrak + `</td>
					<td>` + d.jualPembeli + `</td>
					<td><a href="" class="btn btn-sm btn-outline-primary" target="_blank">Unduh</a></td>
				</tr>
			  </table>
            </div>
			
            <div class="col-md-3 col-sm-12 text-md-end text-sm-start mt-2 mt-md-0">
              <button class="btn btn-primary btn-sm" onclick="setModalUpload();">Upload Kontrak</button>
            </div>
          </div>
        </div>
    `);
		}



		$('#btn-filter-periode').click(function() {
			reloadDatatable();
		});

		function reloadDatatable() {
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

						$("#kode").val(response.data.jualKode);
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
			var data = $("#form-simpan").serializeArray();
			data.push({
				name: "jualIndkKode",
				value: $("#indkKode").val()
			});
			$(".form-control").removeClass("invalid")
			$("#kode").val('');
			$.ajax({
				url: "<?php echo site_url("pks/penjualan/simpan"); ?>",
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