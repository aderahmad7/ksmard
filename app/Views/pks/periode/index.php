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
										<th width="30%">Indeks K (%)</th>
										<th width="30%">Status Kirim</th>
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
					<h5 class="modal-title">Modal title</h5>
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
						<input type="hidden" name="indkPksKode" id="indkPksKode" value="<?php echo $kodePKS; ?>">
						<input type="hidden" name="indkDinasKode" id="indkDinasKode" value="<?php echo $kodeDinas; ?>">

						<div class="form-group col-lg-6 col-md-6 mb-3">
							<small class="fw-semibold">Periode Bulan</small>
							<span class="help"></span>
							<div class="controls">
								<?php echo form_dropdown('indkPeriodeBulan', $bulan, '', 'id="indkPeriodeBulan" class="nice-select default-select form-control wide"'); ?>

							</div>
						</div>
						<div class="form-group col-lg-6 col-md-6 mb-3">
							<small class="fw-semibold">Periode Tahun</small>
							<span class="help"></span>
							<div class="controls">
								<?php echo form_dropdown('indkPeriodeTahun', $tahun, '', 'id="indkPeriodeTahun" class="nice-select default-select form-control wide"'); ?>

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

	<?= $this->endSection() ?>

	<?= $this->section('scripts') ?>
	<script>
		var oTable;
		var bulanArray = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
		const statusLabel = {
			draft: '<span class="badge badge-dark">Draft</span>',
			dikirim: '<span class="badge bg-warning text-dark">Dikirim</span>',
			divalidasi: '<span class="badge bg-success">Divalidasi</span>',
			revisi: '<span class="badge bg-danger">Revisi</span>'
		};
		$(document).ready(function() {
			oTable = $('#table-grid').dataTable({
				processing: true,
				responsive: true,
				serverSide: true,
				scrollX: false,
				bAutoWidth: false,
				pagingType: 'numbers',
				ajax: '<?php echo site_url('pks/periode/grid'); ?>',
				fixedHeader: true,
				"language": {
					"lengthMenu": 'Tampilkan <select class="chosen-select form-select drop_select">' +
						'<option value="10">10</option>' +
						'<option value="20">25</option>' +
						'<option value="50">50</option>' +
						'<option value="150">150</option>' +
						'<option value="-1">Semua</option>' +
						'</select> data'
				},
				lengthMenu: [
					[10, 25, 50, 150, -1],
					[10, 25, 50, 150, 'All'],
				],
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
						data: 'indkPeriodeBulan',
						render: function(data, type, row) {
							return bulanArray[data - 1];
						}
					},
					{
						data: 'indkPeriodeTahun'
					},
					{
						data: 'indkIndeksK'
					},
					{
						data: 'indkStatus',
						render: function(data, type, row) {
							return statusLabel[data];

						}
					},
					{
						data: 'indkKode',
						searchable: false,
						orderable: false,
						render: function(data, type, row) {
							console.log(row);
							var edit = '<a data-id="' + data + '" style="margin :0px 1px 0px 0px ;" onclick="edit($(this));return false;" href="#" title="Ubah" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>';
							var lihat = `<a style="margin :0px 1px 0px 0px ;" href="<?php echo site_url('pks/pelaporan/index'); ?>/${data}" target="_blank" title="Lihat" class="btn btn-dark shadow btn-xs sharp me-1"><i class="fas fa-eye"></i></a>`;
							var hapus = '<a data-id="' + data + '" style="margin :0px 0px 0px 0px ;" data-bs-backdrop="static" data-bs-toggle="modal" data-bs-target="#modal-hapus" onclick="return setModalHapus($(this),\'' + data + '\');" href="#" title="Hapus" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a> ';
							if (row['indkStatus'] == 'draft') {
								return edit + hapus;
							}
							return edit + hapus + lihat;
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
				url: "<?php echo base_url('pks/periode/hapus'); ?>",
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
				url: "<?php echo base_url('pks/periode/edit'); ?>",
				data: {
					indkKode: id
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
						$('#indkPeriodeBulan [value="' + response.data.indkPeriodeBulan + '"]').prop("selected", true);
						$('#indkPeriodeTahun [value="' + response.data.indkPeriodeTahun + '"]').prop("selected", true);


						$("#kode").val(response.data.indkKode);
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

		$(document).delegate('.simpan', 'click', function(e) {
			e.preventDefault();
			var data = $("#form-simpan").serialize();
			$(".form-control").removeClass("invalid")
			$("#kode").val('');
			$.ajax({
				url: "<?php echo site_url("pks/periode/simpan"); ?>",
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