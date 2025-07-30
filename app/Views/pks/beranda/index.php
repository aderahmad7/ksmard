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
<div class="content-body">
	<!-- row -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-xl-12">
				<div class="row">
					<div class="col-xl-12">
						<div class="row">
							<div class="col-xl-8 col-sm-6">
								<div class="card">
									<div class="card-header">
										<h4 class="card-title">Riwayat Indeks K Perusahaan</h4>
									</div>
									<div class="card-body">
										<canvas id="barChart_1"></canvas>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-sm-6">
								<div class="card">
									<div class="card-header">
										<h4 class="card-title">Indeks K Provinsi</h4>
									</div>
									<div class="card-body">
										<div id="redial"></div>
										<div class="mt-4 text-center">
											<h4 class="fs-20 font-w700">Indeks K</h4>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?= $this->endSection() ?>