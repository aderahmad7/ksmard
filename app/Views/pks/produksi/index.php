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
				<h4 class="card-title col-sm-6">Produksi</h4>
				<div class="d-flex align-items-center mb-3 col-4 col-lg-3" style="gap: 5px;">
					<?php echo form_dropdown('indkKode', $periode, (isset($_SESSION['periode_set']) ? $_SESSION['periode_set'] : ''), 'id="indkKode" class="form-select   form-control wide"'); ?>
					<!-- <button class="btn btn-primary">
						<i class="fa fa-filter"></i>
					</button> -->
					<button onclick="reloadDatatable()" class="btn btn-primary" type="button" id="btn-filter-periode"><i class="fa fa-filter" data-feather="filter"></i></button>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 grid-margin stretch-card">
					<div class="card">
						<div class="card-body">
							<div class="d-flex justify-content-between align-items-center">
								<div class="text-muted float-start">
									<div class="input-group w-px-350">
										<h4>Jenis Produksi</h4>
									</div>
								</div>
								<div class="text-muted float-end">
									<div class="input-group w-px-350">
										<button class="btn btn-outline-primary" onclick="return setModalSimpan();" type="button" id="btn-add"><i class="bx bx-plus"></i> Buat Baru</button>
									</div>
								</div>
							</div>
							<table class="table " id="table-grid">
								<thead>
									<tr>
										<th width="1%">NO</th>
										<th width="64%">Jenis Produksi</th>
										<th width="20%">Volume</th>
										<th width="15%">AKSI</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
				<div class="col-md-6 grid-margin stretch-card">
					<div class="card">
						<div class="card-body">

							<div class="d-flex justify-content-between align-items-center">
								<div class="text-muted float-start">
									<div class="input-group w-px-350">
										<h4>Hasil Produksi</h4>
									</div>
								</div>
								<div class="text-muted float-end">
									<div class="input-group w-px-350">
										<button class="btn btn-outline-primary" onclick="return setModalSimpanHasil();" type="button" id="btn-add"><i class="bx bx-plus"></i> Buat Baru</button>
									</div>
								</div>
							</div>
							<table class="table " id="table-grid-hasil">
								<thead>
									<tr>
										<th width="1%">NO</th>
										<th width="64%">Hasil Produksi</th>
										<th width="20%">Volume</th>
										<th width="15%">AKSI</th>
									</tr>
								</thead>
							</table>
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
					<?php
					$katProduksi = getKategoriProduksi();
					?>
					<?php echo form_open(current_url(), array('id' => "form-simpan", 'class' => 'form-horizontal col-lg-12 col-md-12 col-xs-12')); ?>
					<div class="row">
						<input type="hidden" name="kode" id="kode">

						<div class="form-group col-lg-12 col-md-12 mb-3">
							<small class="fw-semibold">Jenis Produksi</small>
							<span class="help"></span>
							<div class="controls">
								<?php echo form_dropdown('prodJenisProduksi', $katProduksi, '', 'id="prodJenisProduksi" class="form-select   form-control wide"'); ?>
							</div>
						</div>

						<div class="form-group col-lg-12 col-md-6 mb-3">
							<small class="fw-semibold">Volume</small>
							<span class="help"></span>
							<div class="controls">
								<?php echo form_input('prodVolume', '', 'id="prodVolume" style="text-align:right;" class="form-control"'); ?>
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
	<div class="modal fade" id="modal-form-hasil">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 id="modal-title">Periode</h5>
				</div>
				<div class="modal-body">
					<?php
					$katTbs = getKategoriTbs();
					?>
					<?php echo form_open(current_url(), array('id' => "form-simpan-hasil", 'class' => 'form-horizontal col-lg-12 col-md-12 col-xs-12')); ?>
					<div class="row">
						<input type="hidden" name="kodehasil" id="kodehasil">

						<div class="form-group col-lg-12 col-md-12 mb-3">
							<small class="fw-semibold">Jenis Hasil</small>
							<span class="help"></span>
							<div class="controls">
								<?php echo form_dropdown('hasilJenisHasil', $katTbs, '', 'id="hasilJenisHasil" class="form-select   form-control wide"'); ?>
							</div>
						</div>

						<div class="form-group col-lg-12 col-md-6 mb-3">
							<small class="fw-semibold">Volume</small>
							<span class="help"></span>
							<div class="controls">
								<?php echo form_input('hasilVolume', '', 'id="hasilVolume" style="text-align:right;" class="form-control"'); ?>
							</div>
						</div>
					</div>
					<?php echo form_close(); ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Batal</button>
					<button type="button" id="btn-simpan" class="btn btn-primary simpan-hasil">Simpan</button>
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
	<div class="modal fade" id="modal-hapus-hasil">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">Hapus Pengguna</div>
				<div class="modal-body">
					Apakah anda yakin menghapus <span hidden="true" id="id-delete"></span>?
				</div>
				<div class="modal-footer">
					<button id="btn-hapus-hasil" class="btn btn-primary" onclick="hapus_hasil();">
						<span class="fa fa-spinner fa-spin"></span> <i class="fa fa-trash" aria-hidden="true"></i> Hapus
					</button>
					<button id="btn-batal-hasil" data-bs-dismiss="modal" class="btn">Batal</button>
				</div>
			</div>
		</div>
	</div>

	<?= $this->endSection() ?>

	<?= $this->section('scripts') ?>
	<script>
		var oTable;
		var oTable2;
		var bulanArray = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
		$(document).ready(function() {
			oTable = $('#table-grid').DataTable({
				processing: true,
				responsive: true,
				serverSide: true,
				pagingType: 'numbers',
				ajax: {
					url: '<?php echo site_url('pks/produksi/grid'); ?>',
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
						"targets": [2]
					}
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
						data: 'prodJenisProduksi'
					},

					{
						data: 'prodVolume',
						render: function(data, type, row) {
							return formatRibuan(data);
						}
					},

					{
						data: 'prodKode',
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
			oTable2 = $('#table-grid-hasil').DataTable({
				processing: true,
				responsive: true,
				serverSide: true,
				pagingType: 'numbers',
				ajax: {
					url: '<?php echo site_url('pks/hasil/grid'); ?>',
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
						"targets": [2]
					}
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
						data: 'hasilJenisHasil'
					},

					{
						data: 'hasilVolume',
						render: function(data, type, row) {
							return formatRibuan(data);
						}
					},

					{
						data: 'hasilKode',
						searchable: false,
						orderable: false,
						render: function(data, type, row) {
							var edit = '<a data-id="' + data + '" style="margin :0px 1px 0px 0px ;" onclick="edit_hasil($(this));return false;" href="#" title="Ubah" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>';
							var hapus = '<a data-id="' + data + '" style="margin :0px 0px 0px 0px ;" data-bs-backdrop="static" data-bs-toggle="modal" data-bs-target="#modal-hapus-hasil" onclick="return setModalHapusHasil($(this),\'' + data + '\');" href="#" title="Hapus" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a> ';
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




		var volume = document.getElementById('prodVolume');
		volume.addEventListener('keyup', function(e) {
			volume.value = formatRibuan(this.value);
		});

		var volume_hasil = document.getElementById('hasilVolume');
		volume_hasil.addEventListener('keyup', function(e) {
			volume_hasil.value = formatRibuan(this.value);
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



		$('#btn-filter-periode').click(function() {
			reloadDatatable();
			reloadDatatableHasil();
		});

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
			console.log('x' + x)
			var id = dom.data('id');
			console.log(id);
			id_delete_hasil = id;
			console.log(id_delete_hasil);
			$(".fa-spinner").hide();
			$("#btn-hapus-hasil").show();
			$("#btn-batal-hasil").html("Batal");
			$("#modal-hapus-hasil .modal-header").html("Hapus");
			$("#modal-hapus-hasil .modal-body").html("Anda yakin menghapus \"<span id='id_delete_hasil'></span>\"?");
			$("#id_delete_hasil").html(x);
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
			var id = id_delete_hasil;
			console.log(id)
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

			$.ajax({
				url: "<?php echo base_url('pks/produksi/edit'); ?>",
				data: {
					prodKode: id
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
						console.log(response.data);
						$('#prodJenisProduksi [value="' + response.data.prodJenisProduksi + '"]').prop("selected", true);

						$("#prodVolume").val(formatRibuan(response.data.prodVolume));

						$("#kode").val(response.data.prodKode);
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
			$("#modal-form #modal-title").html("Jenis Produksi");
		}

		function setModalSimpanHasil() {
			$("#kode").val('');
			$("#form-simpan-hasil input").val('');
			$("#modal-form-hasil").modal('show');
			$("#modal-form-hasil .modal-body").show();
			$("#btn-simpan-hasil").show();
			$("#modal-form-hasil #modal-title").html("Hasil Produksi");
		}

		$(document).delegate('.simpan', 'click', function(e) {
			e.preventDefault();
			var data = $("#form-simpan").serializeArray();
			data.push({
				name: "prodIndkKode",
				value: $("#indkKode").val()
			});
			$(".form-control").removeClass("invalid")
			$("#kodehasil").val('');
			$.ajax({
				url: "<?php echo site_url("pks/produksi/simpan"); ?>",
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
						$("#modal-form").modal('hide');
						reloadDatatable();
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

					if (data.simpan) {
						reloadDatatableHasil();
						msg("success", data.pesan);
						$("#modal-form-hasil").modal('hide');
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