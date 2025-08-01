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
			<div class="d-flex align-items-right justify-content-between mb-3">
				<div class="card-title">
					<div class="input-group">
						<?php echo form_dropdown('indkKode', $periode, $selected, 'id="indkKode" class="form-select   form-control wide"'); ?>
					
						<button onclick="getRekap()" class="btn btn-primary" type="button" id="btn-filter-periode"><i class="fa fa-filter" data-feather="filter"></i> Hitung Indeks K</button>
					</div>
				</div>
				<div id="div-btn-send" style="gap: 5px;">
					
						
					
				</div>
			</div>

			<div class="row">

				<div class="col-xl-3 col-md-6">
					<div class="card ">
						<div class="card-body">
                                <div>
									<span class="d-block fs-16">Harga TBS Pabrik</span>
									<h4 class="fs-24 font-w700 tbs_pabrik">-</h4>
								</div>
                        </div>
						
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card ">
						<div class="card-body">
                                <div>
									<span class="d-block fs-16">INDEKS K</span>
									<h4 class="fs-24 font-w700 indeks_k">-</h4>
								</div>
                        </div>
					</div>
				</div>


			



				<div class="col-md-12 grid-margin stretch-card">
					<div class="card">
						<div class="card-body">
							<table class="table table-hover text-center">
								<thead>
									<tr>
										<th rowspan="2" valign="middle">No</th>
										<th rowspan="2" valign="middle">Uraian</th>
										<th colspan="2">Minyak Sawit (Rp)</th>
										<th colspan="2">Inti Sawit (Rp)</th>
										<th rowspan="2" valign="middle">TBS</th>
										<th rowspan="2" valign="middle" class="kolom-revisi-header">AKSI</th>
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
										<td class="kolom-revisi-data" id="komentar_1"></td>
									</tr>
									<tr>
										<td>2</td>
										<td>Pajak</td>
										<td id="pajak-cpo-ekspor"></td>
										<td id="pajak-cpo-lokal"></td>
										<td id="pajak-inti-ekspor"></td>
										<td id="pajak-inti-lokal"></td>
										<td></td>
										<td class="kolom-revisi-data" id="komentar_2"></td>
									</tr>
									<tr>
										<td>3</td>
										<td>Pemasaran</td>
										<td id="pemasaran-cpo-ekspor"></td>
										<td id="pemasaran-cpo-lokal"></td>
										<td id="pemasaran-inti-ekspor"></td>
										<td id="pemasaran-inti-lokal"></td>
										<td></td>
										<td class="kolom-revisi-data" id="komentar_3"></td>
									</tr>
									<tr>
										<td>4</td>
										<td>Harga (FOB) Bersih</td>
										<td id="fob-bersih-cpo-ekspor"></td>
										<td id="fob-bersih-cpo-lokal"></td>
										<td id="fob-bersih-inti-ekspor"></td>
										<td id="fob-bersih-inti-lokal"></td>
										<td></td>
										<td class="kolom-revisi-data" id="komentar_4"></td>
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
										<td class="kolom-revisi-data" id="komentar_5"></td>
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
										<td class="kolom-revisi-data" id="komentar_6"></td>
									</tr>
									<tr>
										<td>7</td>
										<td>Rendemen</td>
										<td id="rendemen-cpo-ekspor"></td>
										<td id="rendemen-cpo-lokal"></td>
										<td id="rendemen-inti-ekspor"></td>
										<td id="rendemen-inti-lokal"></td>
										<td></td>
										<td class="kolom-revisi-data" id="komentar_7"></td>
									</tr>
									<tr>
										<td>8</td>
										<td>Harga TBS</td>
										<td id="harga_tbs-cpo-ekspor"></td>
										<td id="harga_tbs-cpo-lokal"></td>
										<td id="harga_tbs-inti-ekspor"></td>
										<td id="harga_tbs-inti-lokal"></td>
										<td></td>
										<td class="kolom-revisi-data" id="komentar_8"></td>
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
										<td class="kolom-revisi-data" id="komentar_9"></td>
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
										<td class="kolom-revisi-data" id="komentar_10"></td>
									</tr>
									<tr>
										<td>11</td>
										<td>Biaya Pengolahan</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td id="pengolahan"></td>
										<td class="kolom-revisi-data" id="komentar_11"></td>
									</tr>
									<tr>
										<td>12</td>
										<td>Penyusutan</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td id="penyusutan"></td>
										<td class="kolom-revisi-data" id="komentar_12"></td>
									</tr>
									<tr>
										<td>13</td>
										<td>Nilai TBS di Timbangan
											Pabrik</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td id="harga_timbangan">0</td>
										<td class="kolom-revisi-data" id="komentar_13"></td>
									</tr>
									<tr>
										<td>14</td>
										<td>Biaya Operasinal Tidak
											Langsung</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td id="biaya_tl">0</td>
										<td class="kolom-revisi-data" id="komentar_14"></td>
									</tr>
									<tr>
										<td>15</td>
										<td>Nilai TBS Pabrik</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td id="tbs_pabrik">0</td>
										<td class="kolom-revisi-data" id="komentar_15"></td>
									</tr>
								</tbody>
							</table>
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

	function boldIfValue(val, formattedVal) {
		return val > 0 ? `<b>${formattedVal}</b>` : formattedVal;
	}

	function getRekap() {
		$.ajax({
			url: "<?php echo base_url('pks/pelaporan/rekap'); ?>",
			data: {
				'periode': $('#indkKode').val()
			},
			type: "POST",
			dataType: 'JSON',
			beforeSend: function() {},
			success: function(res) {

				if (res.rekap) {

					// Format and insert values into DOM
					$("#fob-cpo-ekspor").html(boldIfValue(res.data.fob.cpo_ekspor, formatRupiahV3(res.data.fob.cpo_ekspor, 2)));
					$("#fob-cpo-lokal").html(boldIfValue(res.data.fob.cpo_lokal, formatRupiahV3(res.data.fob.cpo_lokal, 2)));
					$("#fob-inti-ekspor").html(boldIfValue(res.data.fob.inti_ekspor, formatRupiahV3(res.data.fob.inti_ekspor, 2)));
					$("#fob-inti-lokal").html(boldIfValue(res.data.fob.inti_lokal, formatRupiahV3(res.data.fob.inti_lokal, 2)));

					$("#pajak-cpo-ekspor").html(boldIfValue(res.data.pajak.cpo_ekspor, formatRupiahV3(res.data.pajak.cpo_ekspor, 2)));
					$("#pajak-cpo-lokal").html(boldIfValue(res.data.pajak.cpo_lokal, formatRupiahV3(res.data.pajak.cpo_lokal, 2)));
					$("#pajak-inti-ekspor").html(boldIfValue(res.data.pajak.inti_ekspor, formatRupiahV3(res.data.pajak.inti_ekspor, 2)));
					$("#pajak-inti-lokal").html(boldIfValue(res.data.pajak.inti_lokal, formatRupiahV3(res.data.pajak.inti_lokal, 2)));

					$("#pemasaran-cpo-ekspor").html(boldIfValue(res.data.pemasaran.cpo_ekspor, formatRupiahV3(res.data.pemasaran.cpo_ekspor, 2)));
					$("#pemasaran-cpo-lokal").html(boldIfValue(res.data.pemasaran.cpo_lokal, formatRupiahV3(res.data.pemasaran.cpo_lokal, 2)));
					$("#pemasaran-inti-ekspor").html(boldIfValue(res.data.pemasaran.inti_ekspor, formatRupiahV3(res.data.pemasaran.inti_ekspor, 2)));
					$("#pemasaran-inti-lokal").html(boldIfValue(res.data.pemasaran.inti_lokal, formatRupiahV3(res.data.pemasaran.inti_lokal, 2)));

					$("#fob-bersih-cpo-ekspor").html(boldIfValue(res.data.fob_bersih.cpo_ekspor, formatRupiahV3(res.data.fob_bersih.cpo_ekspor, 2)));
					$("#fob-bersih-cpo-lokal").html(boldIfValue(res.data.fob_bersih.cpo_lokal, formatRupiahV3(res.data.fob_bersih.cpo_lokal, 2)));
					$("#fob-bersih-inti-ekspor").html(boldIfValue(res.data.fob_bersih.inti_ekspor, formatRupiahV3(res.data.fob_bersih.inti_ekspor, 2)));
					$("#fob-bersih-inti-lokal").html(boldIfValue(res.data.fob_bersih.inti_lokal, formatRupiahV3(res.data.fob_bersih.inti_lokal, 2)));

					$("#angkut-cpo-ekspor").html(boldIfValue(res.data.angkut.cpo_ekspor, formatRupiahV3(res.data.angkut.cpo_ekspor, 2)));
					$("#angkut-cpo-lokal").html(boldIfValue(res.data.angkut.cpo_lokal, formatRupiahV3(res.data.angkut.cpo_lokal, 2)));
					$("#angkut-inti-ekspor").html(boldIfValue(res.data.angkut.inti_ekspor, formatRupiahV3(res.data.angkut.inti_ekspor, 2)));
					$("#angkut-inti-lokal").html(boldIfValue(res.data.angkut.inti_lokal, formatRupiahV3(res.data.angkut.inti_lokal, 2)));

					$("#harga_bersih-cpo-ekspor").html(boldIfValue(res.data.harga_bersih.cpo_ekspor, formatRupiahV3(res.data.harga_bersih.cpo_ekspor, 2)));
					$("#harga_bersih-cpo-lokal").html(boldIfValue(res.data.harga_bersih.cpo_lokal, formatRupiahV3(res.data.harga_bersih.cpo_lokal, 2)));
					$("#harga_bersih-inti-ekspor").html(boldIfValue(res.data.harga_bersih.inti_ekspor, formatRupiahV3(res.data.harga_bersih.inti_ekspor, 2)));
					$("#harga_bersih-inti-lokal").html(boldIfValue(res.data.harga_bersih.inti_lokal, formatRupiahV3(res.data.harga_bersih.inti_lokal, 2)));

					$("#rendemen-cpo-ekspor").html(boldIfValue(res.data.rendemen.cpo_ekspor, res.data.rendemen.cpo_ekspor + " %"));
					$("#rendemen-cpo-lokal").html(boldIfValue(res.data.rendemen.cpo_lokal, res.data.rendemen.cpo_lokal + " %"));
					$("#rendemen-inti-ekspor").html(boldIfValue(res.data.rendemen.inti_ekspor, res.data.rendemen.inti_ekspor + " %"));
					$("#rendemen-inti-lokal").html(boldIfValue(res.data.rendemen.inti_lokal, res.data.rendemen.inti_lokal + " %"));

					$("#harga_tbs-cpo-ekspor").html(boldIfValue(res.data.harga_tbs.cpo_ekspor, formatRupiahV3(res.data.harga_tbs.cpo_ekspor, 2)));
					$("#harga_tbs-cpo-lokal").html(boldIfValue(res.data.harga_tbs.cpo_lokal, formatRupiahV3(res.data.harga_tbs.cpo_lokal, 2)));
					$("#harga_tbs-inti-ekspor").html(boldIfValue(res.data.harga_tbs.inti_ekspor, formatRupiahV3(res.data.harga_tbs.inti_ekspor, 2)));
					$("#harga_tbs-inti-lokal").html(boldIfValue(res.data.harga_tbs.inti_lokal, formatRupiahV3(res.data.harga_tbs.inti_lokal, 2)));

					$("#vol_jual-cpo-ekspor").html(boldIfValue(res.data.vol_jual.cpo_ekspor, res.data.vol_jual.cpo_ekspor + " %"));
					$("#vol_jual-cpo-lokal").html(boldIfValue(res.data.vol_jual.cpo_lokal, res.data.vol_jual.cpo_lokal + " %"));
					$("#vol_jual-inti-ekspor").html(boldIfValue(res.data.vol_jual.inti_ekspor, res.data.vol_jual.inti_ekspor + " %"));
					$("#vol_jual-inti-lokal").html(boldIfValue(res.data.vol_jual.inti_lokal, res.data.vol_jual.inti_lokal + " %"));

					$("#expabrik-cpo-ekspor").html(boldIfValue(res.data.expabrik.cpo_ekspor, formatRupiahV3(res.data.expabrik.cpo_ekspor, 2)));
					$("#expabrik-cpo-lokal").html(boldIfValue(res.data.expabrik.cpo_lokal, formatRupiahV3(res.data.expabrik.cpo_lokal, 2)));
					$("#expabrik-inti-ekspor").html(boldIfValue(res.data.expabrik.inti_ekspor, formatRupiahV3(res.data.expabrik.inti_ekspor, 2)));
					$("#expabrik-inti-lokal").html(boldIfValue(res.data.expabrik.inti_lokal, formatRupiahV3(res.data.expabrik.inti_lokal, 2)));
					$("#expabrik-total").html(boldIfValue(res.data.expabrik.total, formatRupiahV3(res.data.expabrik.total, 2)));

					$("#pengolahan").html(boldIfValue(res.data.pengolahan, formatRupiahV3(res.data.pengolahan, 2)));
					$("#penyusutan").html(boldIfValue(res.data.penyusutan, formatRupiahV3(res.data.penyusutan, 2)));
					$("#harga_timbangan").html(boldIfValue(res.data.harga_timbangan, formatRupiahV3(res.data.harga_timbangan, 2)));
					$("#biaya_tl").html(boldIfValue(res.data.biayatl, formatRupiahV3(res.data.biayatl, 2)) + " (" + res.data.biayatl_label + ")");
					$("#tbs_pabrik").html(boldIfValue(res.data.harga_tbs_pabrik, formatRupiahV3(res.data.harga_tbs_pabrik, 2)));
					$(".tbs_pabrik").html(boldIfValue(res.data.harga_tbs_pabrik, formatRupiah(res.data.harga_tbs_pabrik, 2)));
					$(".indeks_k").html(boldIfValue(res.data.indeks_k, formatRupiahV3(res.data.indeks_k, 2) + "%"));
					//msg("success", data.pesan);
					if (res.periode.indkStatus=="dikirim" || res.periode.indkStatus=="divalidasi"){
						if (res.periode.indkStatus=="dikirim")
							$("#div-btn-send").html('<div class="alert alert-light solid alert-square"><i class="fa fa-paper-plane" data-feather="paper-plane"> Sedang Dikirim</div>');
						else
							$("#div-btn-send").html('<div class="alert alert-success solid fade show"><i class="fa fa-check" data-feather="check"></i> Divalidasi Dinas</div>');
						$("#div-btn-send").prop("disabled",true);
					} else {
						if (res.periode.indkStatus=="draft")
							$("#div-btn-send").html('<button class="btn btn-primary float-right p-3" type="button" id="btn-send" onclick="send()"><i class="fa fa-paper-plane" data-feather="paper-plane"></i> Kirim Ke Dinas</button>');
						else	
							$("#div-btn-send").html('<button class="btn btn-primary float-right p-3" type="button" id="btn-send" onclick="send()"><i class="fa fa-paper-plane" data-feather="paper-plane"></i> Kirim Ke Dinas (Revisi)</button>');
					}

					//komentar
					$(".kolom-revisi-header").hide();
					$(".kolom-revisi-data").hide();
					$(".kolom-revisi-data").html('');
					if (res.periode.indkStatus=="revisi"){
						$(".kolom-revisi-header").show();
						$(".kolom-revisi-data").show();
						res.komentar.forEach(function(val, index) {
							if (val.kmtStatus=="ditolak"){
								var komen = '<a data-id="' + val.kmtLapKode + '" style="margin :0px 0px 0px 0px ;" data-bs-backdrop="static" data-bs-toggle="modal" data-bs-target="#modal-komentar" onclick="return setModalKomentar($(this),\'' + val.kmtKomen + '\');" href="#" title="Komentar" class="btn btn-primary shadow btn-xs sharp"><i class="fa fa-comment"></i></a> ';
								$("#komentar_"+val.kmtLapKode).html(komen);
							}
						});
					}

					// Tampilkan SweetAlert2
					Swal.fire({
						title: 'Informasi Harga TBS dan Indeks K',
						html: `
							<div style="display: flex; justify-content: space-around; gap: 20px;">
							<div style="
								background: #e0f7fa;
								padding: 20px;
								border-radius: 15px;
								width: 55%;
								text-align: center;
								box-shadow: 0 2px 8px rgba(0,0,0,0.1);
							">
								<p style="font-size: 1.2em; margin-bottom: 10px;">Harga TBS</p>
								<h2 style="margin: 0;">${formatRupiah(res.data.harga_tbs_pabrik,2)}</h2>
							</div>
							<div style="
								background: #fce4ec;
								padding: 20px;
								border-radius: 15px;
								width: 35%;
								text-align: center;
								box-shadow: 0 2px 8px rgba(0,0,0,0.1);
							">
								<p style="font-size: 1.2em; margin-bottom: 10px;">Indeks K</p>
								<h2 style="margin: 0;">${formatRupiahV3(res.data.indeks_k,2)+"%"}</h2>
							</div>
							</div>
						`,
						icon: 'info',
						confirmButtonText: 'Tutup'
					});

				
				} else {
					//msg("error", data.pesan);
				}
			},
		});
	};
	function setModalKomentar(dom, x) {
			$("#divKomentar").html(x);
	}

	function send() {
		Swal.fire({
			title: 'Apakah Anda yakin?',
			text: "Data akan dikirim dan tidak dapat diubah!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Ya, kirim!',
			cancelButtonText: 'Batal',
			reverseButtons: true
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: "<?= base_url('pks/pelaporan/kirim') ?>",
					data: {
						'periode': $('#indkKode').val()
					},
					type: "POST",
					dataType: 'JSON',
					success: function(res) {
						if (res.kirim) {
							console.log(res);
							$("#div-btn-send").html('<div class="alert alert-light solid alert-square"><i class="fa fa-paper-plane" data-feather="paper-plane"> Sedang Dikirim</div>');
							Swal.fire(
								'Terkirim!',
								'Data Anda telah berhasil dikirim.',
								'success'
							);
						} else {
							Swal.fire(
								'Gagal!',
								'Data Anda gagal dikirim.',
								'error'
							);
						}
					},
					error: function(res) {
						console.log(res);
					}
				})
			} else if (result.dismiss === Swal.DismissReason.cancel) {
				// Jika dibatalkan
				Swal.fire(
					'Dibatalkan',
					'Data Anda tidak jadi dikirim.',
					'info'
				);
			}
		});
	};

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
				$("#modal-form").modal('hide');
				if (data.simpan) {
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