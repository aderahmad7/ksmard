<?= $this->extend('template/body.php') ?>

<?= $this->section('content') ?>

<!-- Content -->
<style>
	th { font-size: 11pt; }
	td { font-size: 10pt; }
</style>
<div class="page-content">
	<nav class="page-breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#">Home</a></li>
			
		</ol>
	</nav>

	<div class="row">
		<div class="col-md-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
			  <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
          <div>
            <h4 class="mb-3 mb-md-0">
                Indeks K
			 </h4>
          </div>
          <div class="d-flex align-items-center flex-wrap text-nowrap">
            
		  	<div class="btn-group" role="group" aria-label="First group">
			  		<button onclick="return setModalFilter(0);" href="#" class="btn btn-40h btn-addroot btn-outline-primary btn-filter">
						<i class="bx bx-filter-alt"></i>
					</button>
					
					
					
					<a href="<?= base_url('peminjaman/form');?>"  class="btn btn-primary btn-sm btn-icon-text">
						<i class="btn-icon-prepend" data-feather="plus"></i> Tambah
					</a>
			</div>
          </div>
        </div>
					<div class="text-muted float-end">
					<div class="input-group w-px-350">
							<select class="form-select" id="field-status" name="field-status" onchange="filter_status();">
								<option value="">Semua Status</option>
								<option value="kirim">Ajuan Baru</option>
								<option value="periksa">Sedang Diperiksa</option>
								<option value="terima">Terima</option>
								<option value="tolak">Tolak</option>
							</select>
						</div>
						<div class="input-group w-px-350">
							<input type="text" id="field-cari" class="form-control item-input" placeholder="Cari" aria-describedby="defaultFormControlHelp">
							<button class="btn btn-outline-primary btn-add" type="button" id="btn-cari"><i class="bx bx-search"></i></button>
						</div>
					</div>
					<form method="post" id="selectedForm" action="<?php echo site_url("master_alat/download_qrcode_selected");?>" class="add-new-post">
                        </form> 
			  		<table class="table " id="table-grid">
						<thead>
							<tr>
								<th width="1%">NO</th>
								<th width="39%">Periode Pelaporan</th>
								<th width="10%">Indeks K</th>
								<th width="5%">AKSI</th>
							</tr>
						</thead>
					</table>
              </div>
            </div>
		</div>
	</div>

</div>

<?= $this->endSection() ?>