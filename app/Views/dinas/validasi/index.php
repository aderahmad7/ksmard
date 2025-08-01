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
		<div class="container-fluid">
			<div class="d-flex align-items-right justify-content-between mb-3">
				<h4 class="card-title col-sm-6 label-periode">
					
				</h4>
				<div class="d-flex align-items-center mb-3 col-4 col-lg-3" style="gap: 5px;">
					<?php echo form_dropdown('kprovKode', $periode, (isset($_SESSION['periode_set']) ? $_SESSION['periode_set'] : ''), 'id="kprovKode" class="nice-select default-select form-control wide"'); ?>
					<!-- <button class="btn btn-primary">
						<i class="fa fa-filter"></i>
					</button> -->
					<button  class="btn btn-primary" type="button" id="btn-filter-periode" onclick="filter();"><i class="fa fa-filter" data-feather="filter"></i></button>
				</div>
			</div>

			<div class="row" id="div_list_perusahaan">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <div class="alert alert-primary alert-dismissible fade show">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
                                            </button>
                                            <div class="media">
                                                <div class="media-body">
                                                    <h5 class="mt-1 mb-1">Informasi</h5>
                                                    <p class="mb-0">Untuk memulai proses validasi, pilih periode dan tekan tombol <i class="fa fa-filter"></i></p>
                                                </div>
                                            </div>
                                        </div>
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
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
	var oTable;
	var oTable2;
	var bulanArray = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
	const statusLabel = {
			1: 'bg-primary',
			2: 'bg-danger',
			3: 'bg-success',
			4: 'bg-light',
		};
	const statusIcon = {
			1: 'fa-envelope',
			2: 'fa-commenting',
			3: 'fa-check',
			4: '',
		};
	function card(bg,icon,pks,data){
		return '<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">'+
					'<div class="widget-stat card '+bg+'">'+
							'<div class="card-body p-4">'+
								'<div class="media">'+
									'<span class="me-3">'+
										'<i class="fa '+icon+'"></i>'+
									'</span>'+
									'<div class="media-body text-white text-end">'+
										'<p class="mb-1">'+pks+'</p>'+
										'<h3 class="text-white"> '+data+'</h3>'+
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>'+
                '</div>';
	}
	

	

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
	function card(bg,icon,pks,data,nourut,id){
		var box = '<div class="widget-stat card '+bg+'">'+
							'<div class="card-body p-4">'+
								'<div class="media">'+
									'<span class="me-3">'+
										'<i class="fa '+icon+'"></i>'+
									'</span>'+
									'<div class="media-body text-white text-end">'+
										'<p class="mb-1">'+pks+'</p>'+
										'<h3 class="text-white"> '+data+'</h3>'+
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>';
			if (nourut!=4){
				box = '<a href="<?=base_url();?>dinas/validasi/detail/'+id+'">'+box+'</a>';
			}
		return '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">'+
					box+
                '</div>';
	}
	function filter() {
		$.ajax({
			url: "<?php echo site_url("dinas/validasi/listPerusahaan"); ?>",
			data: {periode:$("#kprovKode").val()},
			type: "POST",
			dataType: "JSON",
			beforeSend: function() {
				$(".fa-spinner").show();
				$(".error").remove();
				$("#btn-simpan").attr("disabled", true);
				$("#btn-batal").attr("disabled", true);
			},
			success: function(response) {
				$("#div_list_perusahaan").html('');
				if (response.status) {
					$(".label-periode").html("Indeks K Perusahaan Bulan "+$("#kprovKode option:selected").text());
					response.data.forEach(function(number, index) {
						//console.log(number)
						var bg=statusLabel[number["nourut"]];
						var icon=statusIcon[number["nourut"]];
						var pks=number["pksNama"];
						var data=number["indkIndeksK"]==null?0:number["indkIndeksK"]+"%";
						//var link = number["indkIndeksK"]==null?card(bg,icon,pks,data):'<a href="<?=base_url();?>dinas/validasi/detail/'+number["indkKode"]+'">'+card(bg,icon,pks,data)+'</a>';
						//$("#div_list_perusahaan").append();
						var $card = $(card(bg,icon,pks,data,number["nourut"],number["indkKode"])).hide();
						$("#div_list_perusahaan").append($card);
						$card.fadeIn(800); // atau slideDown(300);

					});
				} else {
					$("#div_list_perusahaan").html('<div class="alert alert-light solid alert-dismissible fade show">'+
                                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">'+
                                    '</button>'+
                                    '<strong>Error!</strong> Message Sending failed.'+
                                '</div>');
				}
			}
		});
	};

</script>

<?= $this->endSection() ?>