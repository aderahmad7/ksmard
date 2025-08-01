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
	<div class="content-body" style="padding-top:0;">
		<!-- row -->
		<div class="container-fluid" class="mt-0">
			
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
										<th width="10%">Periode Bulan</th>
										<th width="10%">Periode Tahun</th>
										<th width="10%">Indeks K (%)</th>
										<th width="20%">Tanggal Penetapan</th>
										<th width="10%">Publish</th>
										<th width="19%">AKSI</th>
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
					<h5 class="modal-title">Input Periode</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal">
					</button>
				</div>
				<div class="modal-body">
					<?php
					$bulan = getMonth();
					$tahun = getYear();
					?>
					<?php echo form_open(current_url(), array('id' => "form-simpan", 'class' => 'form-horizontal col-lg-12 col-md-12 col-xs-12')); ?>
					<div class="row">

						<input type="hidden" name="kode" id="kode">

						<div class="form-group col-lg-6 col-md-6 mb-3">
							<small class="fw-semibold">Periode Bulan</small>
							<span class="help"></span>
							<div class="controls">
								<?php echo form_dropdown('kprovPeriodeBulan', $bulan, '', 'id="kprovPeriodeBulan" class="nice-select default-select form-control wide"'); ?>

							</div>
						</div>
						<div class="form-group col-lg-6 col-md-6 mb-3">
							<small class="fw-semibold">Periode Tahun</small>
							<span class="help"></span>
							<div class="controls">
								<?php echo form_dropdown('kprovPeriodeTahun', $tahun, '', 'id="kprovPeriodeTahun" class="nice-select default-select form-control wide"'); ?>

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
	<div class="modal fade" id="modal-indeks">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Input Indeks K Provinsi</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal">
					</button>
				</div>
				<div class="modal-body">
					
					<?php echo form_open(current_url(), array('id' => "form-simpan-indeks", 'class' => 'form-horizontal col-lg-12 col-md-12 col-xs-12')); ?>
					<div class="row">

						<input type="hidden" name="kode_periode" id="kode_periode">

						<div class="form-group col-lg-12 col-md-12 mb-3">
							<small class="fw-semibold">Indeks K Provinsi</small>
							<span class="help"></span>
							<div class="controls">
								<?php echo form_input('kprovIndeksK', '', 'id="kprovIndeksK" class="form-control"'); ?>

							</div>
						</div>
						<div class="form-group col-lg-6 col-md-6 mb-3">
							<small class="fw-semibold">Tanggal Penetapan</small>
							<span class="help"></span>
							<div class="controls">
								<input type="date" name="kprovTanggalPenetapan" id="kprovTanggalPenetapan" class="form-control"/>

							</div>
						</div>
						<div class="form-group col-lg-6 col-md-6 mb-3">
							<small class="fw-semibold">Dipublish?</small>
							<span class="help"></span>
							<div class="controls">
								<?php echo form_dropdown('kprovIsPublish', [""=>"Pilih salah satu",0=>"Tidak Dipublish",1=>"Dipublish"], '', 'id="kprovIsPublish" class="default-select form-control wide"'); ?>

							</div>
						</div>
					</div>
					<?php echo form_close(); ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Batal</button>
					<button type="button" id="btn-simpan-indeks" class="btn btn-primary simpan-indeks">Simpan</button>
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
		const statusLabel = {
			1: '<span class="badge bg-success">Dipublish</span>',
			0: ''
		};
		$(document).ready(function() {
			oTable = $('#table-grid').dataTable({
				processing: true,
				responsive: true,
				serverSide: true,
				scrollX: false,
				bAutoWidth: false,
				pagingType: 'numbers',
				ajax: '<?php echo site_url('dinas/periode/grid'); ?>',
				
				dom: '<"top">lrt<"bottom"p>',
				columnDefs: [{
					"className": "dt-tengah",
					"targets": [1]
				}],
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
						data: 'kprovPeriodeBulan',
						render: function(data, type, row) {
							return bulanArray[data - 1];
						}
					},
					{
						data: 'kprovPeriodeTahun'
					},
					{
						data: 'kprovIndeksK'
					},
					{
						data: 'kprovTanggalPenetapan'
					},
					{
						data: 'kprovIsPublish',
						render: function(data, type, row) {
							return statusLabel[data];

						}
					},
					{
						data: 'kprovKode',
						searchable: false,
						orderable: false,
						render: function(data, type, row) {
							console.log(row);
							var edit = '<a data-id="' + data + '" style="margin :0px 1px 0px 0px ;" onclick="edit($(this));return false;" href="#" title="Ubah" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>';
							var hapus = '<a data-id="' + data + '" style="margin :0px 0px 0px 0px ;" data-bs-backdrop="static" data-bs-toggle="modal" data-bs-target="#modal-hapus" onclick="return setModalHapus($(this),\'' + data + '\');" href="#" title="Hapus" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a> ';
							var indeks = '<a data-id="' + data + '" style="margin :0px 0px 0px 0px ;" data-bs-backdrop="static" data-bs-toggle="modal" data-bs-target="#modal-indeks" onclick="return setModalIndeks($(this),\'' + data + '\');" href="#" title="Update Indeks K" class="btn btn-primary shadow btn-xs sharp">K K</a> ';
							
							return indeks+edit + hapus;
						}
					},
				]
			});
		});

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
				url: "<?php echo base_url('dinas/periode/hapus'); ?>",
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
						oTable.fnDraw();
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
				url: "<?php echo base_url('dinas/periode/edit'); ?>",
				data: {
					kprovKode: id
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
						$('#kprovPeriodeBulan [value="' + response.data.kprovPeriodeBulan + '"]').prop("selected", true);
						$('#kprovPeriodeTahun [value="' + response.data.kprovPeriodeTahun + '"]').prop("selected", true);


						$("#kode").val(response.data.kprovKode);
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
			$("#modal-form").modal('show');
			$("#modal-form .modal-body").show();
			$("#btn-simpan").show();
			$("#modal-form #modal-title").html("Periode");

		}
		function setModalIndeks(obj) {
			$("#kode_periode").val('');
			$("#modal-indeks").modal('show');
			$("#modal-indeks .modal-body").show();
			$("#btn-simpan-indeks").show();
			$("#modal-indeks #modal-title").html("Update Indeks K");
			var id = obj.data('id');

			$.ajax({
				url: "<?php echo base_url('dinas/periode/edit'); ?>",
				data: {
					kprovKode: id
				},
				type: "POST",
				dataType: 'JSON',
				beforeSend: function() {
					
				},
				success: function(response) {
					if (response.edit) {
						$('#kprovIndeksK').val(response.data.kprovIndeksK);
						$('#kprovTanggalPenetapan').val(response.data.kprovTanggalPenetapan);
						$('#kprovIsPublish').val(response.data.kprovIsPublish); // set value ke "2"
						$('#kprovIsPublish').niceSelect('update'); // update tampilan Nice Select
						//$('#kprovIsPublish [value="' + response.data.kprovIsPublish + '"]').prop("selected", true);


						$("#kode_periode").val(response.data.kprovKode);
						$(".fa-spinner").hide();
						$("#btn-simpan-indeks").removeAttr("disabled");
					} else {
						$("#modal-form-indeks .form-body").html(response.pesan);
					}
				}
			});
		}

		$(document).delegate('.simpan', 'click', function(e) {
			e.preventDefault();
			var data = $("#form-simpan").serialize();
			$(".form-control").removeClass("invalid")
			
			$.ajax({
				url: "<?php echo site_url("dinas/periode/simpan"); ?>",
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
						$("#modal-form").modal("hide");
						oTable.fnDraw();
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
		$(document).delegate('.simpan-indeks', 'click', function(e) {
			e.preventDefault();
			var data = $("#form-simpan-indeks").serialize();
			$(".form-control").removeClass("invalid")
			
			$.ajax({
				url: "<?php echo site_url("dinas/periode/simpan_indeks_k"); ?>",
				data: data,
				type: "POST",
				dataType: "JSON",
				beforeSend: function() {
					$(".fa-spinner").show();
					$(".error").remove();
					$("#btn-simpan-indeks").attr("disabled", true);
					$("#btn-batal").attr("disabled", true);
				},
				success: function(data) {
					$(".fa-spinner").hide();
					$("#btn-simpan-indeks").removeAttr("disabled");
					$("#btn-batal").removeAttr("disabled");
					if (data.simpan) {
						$("#modal-indeks").modal("hide");
						oTable.fnDraw();
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
	<?= $this->endSection() ?>