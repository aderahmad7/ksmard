<?= $this->extend('template/template-company.php') ?>

<?= $this->section('content-company') ?>

<div class="page-content">
    <section class="row">
        <div class="col-12">

            <div class="select-Date d-flex gap-5">
                <div class="pilih-bulan">
                    <span class="me-2">Pilih Bulan : </span>
                    <select id="monthSelect" class="mb-5 text-white bg-ksmard-active p-2 border-0 rounded-2">
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <!-- Tambahkan opsi untuk bulan lainnya -->
                    </select>
                </div>
                <div class="pilih-tahun">
                    <span class="me-2">Pilih Tahun : </span>
                    <select id="yearSelect" class="mb-5 text-white bg-ksmard-active p-2 border-0 rounded-2">
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <!-- Tambahkan opsi untuk bulan lainnya -->
                    </select>
                </div>
            </div>
            <div class="row d-flex container-biaya">
                <div class="col-9 container-table table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Uraian</th>
                                <th colspan="2">Minyak Sawit
                                    (Rp)</th>
                                <th colspan="2">Inti Sawit
                                    (Rp)</th>
                                <th rowspan="2">Tandan Buah
                                    Segar</th>
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
                                <td></td>
                                <td>
                                    <div class="d-flex tabel-title justify-content-between align-items-center">
                                        <div id="hargaMinyak">11.055,00</div><button type="button" class="btn block"
                                            data-bs-toggle="modal" data-bs-target="#hargaMinyakModal">
                                            <ion-icon name="create"
                                                class="icon-edit d-flex align-items-center justify-content-center"></ion-icon>
                                        </button>
                                    </div>
                                    <div class="modal fade" id="hargaMinyakModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Data
                                                        Harga
                                                        Minyak
                                                        Sawit
                                                    </h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-bordered" id="tabelHargaMinyak">
                                                        <thead>
                                                            <td>No</td>
                                                            <td>Nomor</td>
                                                            <td>Tanggal</td>
                                                            <td>Harga
                                                                Minyak
                                                                Sawit</td>
                                                            <td>Volume
                                                                Penjualan</td>
                                                            <td>Total
                                                                Penjualan</td>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>xx</td>
                                                                <td>xx</td>
                                                                <td>Rp
                                                                    <input type="number" value="11055"
                                                                        class="border-0 hargaMinyak"
                                                                        onchange="hargaTotalMinyak()">
                                                                </td>
                                                                <td><input type="number" value="500000"
                                                                        class="border-0 volumeMinyak"
                                                                        onchange="hargaTotalMinyak()"></td>
                                                                <td class="total">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>2</td>
                                                                <td>xx</td>
                                                                <td>xx</td>
                                                                <td>Rp
                                                                    <input type="number" value="11055"
                                                                        class="border-0 hargaMinyak"
                                                                        onchange="hargaTotalMinyak()">
                                                                </td>
                                                                <td><input type="number" value="500000"
                                                                        class="border-0 volumeMinyak"
                                                                        onchange="hargaTotalMinyak()"></td>
                                                                <td class="total">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>3</td>
                                                                <td>xx</td>
                                                                <td>xx</td>
                                                                <td>Rp
                                                                    <input type="number" value="11055"
                                                                        class="border-0 hargaMinyak"
                                                                        onchange="hargaTotalMinyak()">
                                                                </td>
                                                                <td><input type="number" value="500000"
                                                                        class="border-0 volumeMinyak"
                                                                        onchange="hargaTotalMinyak()"></td>
                                                                <td class="total">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>4</td>
                                                                <td>xx</td>
                                                                <td>xx</td>
                                                                <td>Rp
                                                                    <input type="number" value="11055"
                                                                        class="border-0 hargaMinyak"
                                                                        onchange="hargaTotalMinyak()">
                                                                </td>
                                                                <td><input type="number" value="500000"
                                                                        class="border-0 volumeMinyak"
                                                                        onchange="hargaTotalMinyak()"></td>
                                                                <td class="total">0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>5</td>
                                                                <td>xx</td>
                                                                <td>xx</td>
                                                                <td>Rp
                                                                    <input type="number" value="11055"
                                                                        class="border-0 hargaMinyak"
                                                                        onchange="hargaTotalMinyak()">
                                                                </td>
                                                                <td><input type="number" value="500000"
                                                                        class="border-0 volumeMinyak"
                                                                        onchange="hargaTotalMinyak()"></td>
                                                                <td class="total">0</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
                                                        <i class="bx bx-x"></i>
                                                        <span>Batal</span>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-submit text-white bg-ksmard-active ms-1"
                                                        data-bs-dismiss="modal" onclick="hitungHargaMinyak()">
                                                        <i class="bx bx-check"></i>
                                                        <span>Submit</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td></td>
                                <td>
                                    <div class="d-flex tabel-title justify-content-between align-items-center">
                                        <div id="hargaInti">4.850,00</div><button type="button" class="btn block"
                                            data-bs-toggle="modal" data-bs-target="#hargaIntiModal">
                                            <ion-icon name="create"
                                                class="icon-edit d-flex align-items-center justify-content-center"></ion-icon>
                                        </button>
                                    </div>
                                    <div class="modal fade" id="hargaIntiModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Data
                                                        Harga
                                                        Inti
                                                        Sawit
                                                    </h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-bordered" id="tabelHargaInti">
                                                        <thead>
                                                            <td>No</td>
                                                            <td>Nomor</td>
                                                            <td>Tanggal</td>
                                                            <td>Harga
                                                                Inti
                                                                Sawit</td>
                                                            <td>Volume
                                                                Penjualan</td>
                                                            <td>Total
                                                                Penjualan</td>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>xx</td>
                                                                <td>xx</td>
                                                                <td>Rp
                                                                    <input type="number" value="4850"
                                                                        class="border-0 hargaInti"
                                                                        onchange="hargaTotalInti()">
                                                                </td>
                                                                <td><input type="number" value="300000"
                                                                        class="border-0 volumeInti"
                                                                        onchange="hargaTotalInti()"></td>
                                                                <td class="total">0</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
                                                        <i class="bx bx-x "></i>
                                                        <span>Batal</span>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-submit text-white bg-ksmard-active ms-1"
                                                        data-bs-dismiss="modal" onclick="hitungHargaInti()">
                                                        <i class="bx bx-check "></i>
                                                        <span>Submit</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Pajak</td>
                                <td></td>
                                <td>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div id="pajakMinyak">-</div><button type="button" class="btn block"
                                            data-bs-toggle="modal" data-bs-target="#pajakMinyakModal">
                                            <ion-icon name="create"
                                                class="icon-edit d-flex align-items-center justify-content-center"></ion-icon>
                                        </button>
                                    </div>
                                    <div class="modal fade" id="pajakMinyakModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Input
                                                        Pajak
                                                        Minyak
                                                        Sawit
                                                    </h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <div
                                                    class="modal-body d-flex justify-content-center align-items-center gap-2">
                                                    <label for="pajakMinyakID">Pajak
                                                        Minyak
                                                        Sawit :
                                                    </label>
                                                    <input type="number" id="pajakMinyakID" name="pajakMinyak">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
                                                        <i class="bx bx-x"></i>
                                                        <span>Batal</span>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-submit text-white bg-ksmard-active ms-1"
                                                        data-bs-dismiss="modal" onclick="updatePajakMinyak()">
                                                        <i class="bx bx-check "></i>
                                                        <span>Submit</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td></td>
                                <td>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div id="pajakInti">-</div><button type="button" class="btn block"
                                            data-bs-toggle="modal" data-bs-target="#pajakIntiModal">
                                            <ion-icon name="create"
                                                class="icon-edit d-flex align-items-center justify-content-center"></ion-icon>
                                        </button>
                                    </div>
                                    <div class="modal fade" id="pajakIntiModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Input
                                                        Pajak
                                                        Inti
                                                        Sawit
                                                    </h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <div
                                                    class="modal-body d-flex justify-content-center align-items-center gap-2">
                                                    <label for="pajakIntiID">Pajak
                                                        Inti
                                                        Sawit :
                                                    </label>
                                                    <input type="number" id="pajakIntiID" name="pajakInti">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
                                                        <i class="bx bx-x "></i>
                                                        <span>Batal</span>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-submit text-white bg-ksmard-active ms-1"
                                                        data-bs-dismiss="modal" onclick="updatePajakInti()">
                                                        <i class="bx bx-check "></i>
                                                        <span>Submit</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Pemasaran</td>
                                <td></td>
                                <td>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div id="pemasaranMinyak">-</div><button type="button" class="btn block"
                                            data-bs-toggle="modal" data-bs-target="#pemasaranMinyakModal">
                                            <ion-icon name="create"
                                                class="icon-edit d-flex align-items-center justify-content-center"></ion-icon>
                                        </button>
                                    </div>
                                    <div class="modal fade" id="pemasaranMinyakModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Input
                                                        Pemasaran
                                                        Minyak
                                                        Sawit
                                                    </h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <div
                                                    class="modal-body d-flex justify-content-center align-items-center gap-2">
                                                    <label for="pemasaranMinyakID">Pemasaran
                                                        Minyak
                                                        Sawit :
                                                    </label>
                                                    <input type="number" id="pemasaranMinyakID" name="pemasaranMinyak">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
                                                        <i class="bx bx-x "></i>
                                                        <span>Batal</span>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-submit text-white bg-ksmard-active ms-1"
                                                        data-bs-dismiss="modal" onclick="updatePemasaranMinyak()">
                                                        <i class="bx bx-check "></i>
                                                        <span>Submit</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td></td>
                                <td>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div id="pemasaranInti">-</div><button type="button" class="btn block"
                                            data-bs-toggle="modal" data-bs-target="#pemasaranIntiModal">
                                            <ion-icon name="create"
                                                class="icon-edit d-flex align-items-center justify-content-center"></ion-icon>
                                        </button>
                                    </div>
                                    <div class="modal fade" id="pemasaranIntiModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Input
                                                        Pemasaran
                                                        Inti
                                                        Sawit
                                                    </h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <div
                                                    class="modal-body d-flex justify-content-center align-items-center gap-2">
                                                    <label for="pemasaranIntiID">Pemasaran
                                                        Inti
                                                        Sawit :
                                                    </label>
                                                    <input type="number" id="pemasaranIntiID" name="pemasaranMinyak">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
                                                        <i class="bx bx-x "></i>
                                                        <span>Batal</span>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-submit text-white bg-ksmard-active ms-1"
                                                        data-bs-dismiss="modal" onclick="updatePemasaranInti()">
                                                        <i class="bx bx-check "></i>
                                                        <span>Submit</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Harga (FOB) Bersih</td>
                                <td></td>
                                <td id="hargaBersihMinyak">0</td>
                                <td></td>
                                <td id="hargaBersihInti">0</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Pengangkutan ke
                                    Pelabuhan</td>
                                <td></td>
                                <td>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div id="pengangkutanMinyak">292,00</div><button type="button" class="btn block"
                                            data-bs-toggle="modal" data-bs-target="#pengangkutanMinyakModal"><ion-icon
                                                name="create"
                                                class="icon-edit d-flex align-items-center justify-content-center"></ion-icon></button>
                                    </div>
                                    <div class="modal fade" id="pengangkutanMinyakModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Data
                                                        Pengangkutan
                                                        ke
                                                        Pelabuhan
                                                    </h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-bordered" id="tabelPengangkutanMinyak">
                                                        <thead>
                                                            <td>No</td>
                                                            <td>Tanggal</td>
                                                            <td>Volume</td>
                                                            <td>Biaya</td>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>xx</td>
                                                                <td>Rp
                                                                    <input type="number" value="730000000"
                                                                        class="border-0 volume">
                                                                </td>
                                                                <td>Rp
                                                                    <input type="number" value="2500000"
                                                                        class="border-0 biaya">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>2</td>
                                                                <td>xx</td>
                                                                <td>Rp
                                                                    <input type="number" value="730000000"
                                                                        class="border-0 volume">
                                                                </td>
                                                                <td>Rp
                                                                    <input type="number" value="2500000"
                                                                        class="border-0 biaya">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
                                                        <i class="bx bx-x "></i>
                                                        <span>Batal</span>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-submit text-white bg-ksmard-active ms-1"
                                                        data-bs-dismiss="modal" onclick="hitungPengangkutanMinyak()">
                                                        <i class="bx bx-check "></i>
                                                        <span>Submit</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td></td>
                                <td>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div id="pengangkutanInti">292,00</div><button type="button" class="btn block"
                                            data-bs-toggle="modal" data-bs-target="#pengangkutanIntiModal"><ion-icon
                                                name="create"
                                                class="icon-edit d-flex align-items-center justify-content-center"></ion-icon></button>
                                    </div>
                                    <div class="modal fade" id="pengangkutanIntiModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Data
                                                        Pengangkutan
                                                        ke
                                                        Pelabuhan
                                                    </h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-bordered" id="tabelPengangkutanInti">
                                                        <thead>
                                                            <td>No</td>
                                                            <td>Tanggal</td>
                                                            <td>Volume</td>
                                                            <td>Biaya</td>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>xx</td>
                                                                <td>Rp
                                                                    <input type="number" value="730000000"
                                                                        class="border-0 volume">
                                                                </td>
                                                                <td>Rp
                                                                    <input type="number" value="2500000"
                                                                        class="border-0 biaya">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>2</td>
                                                                <td>xx</td>
                                                                <td>Rp
                                                                    <input type="number" value="730000000"
                                                                        class="border-0 volume">
                                                                </td>
                                                                <td>Rp
                                                                    <input type="number" value="2500000"
                                                                        class="border-0 biaya">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
                                                        <i class="bx bx-x "></i>
                                                        <span>Batal</span>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-submit text-white bg-ksmard-active ms-1"
                                                        data-bs-dismiss="modal" onclick="hitungPengangkutanInti()">
                                                        <i class="bx bx-check "></i>
                                                        <span>Submit</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Harga Bersih Pabrik/Tangki
                                    Pabrik</td>
                                <td></td>
                                <td id="hargaMinyakPabrik">0</td>
                                <td></td>
                                <td id="hargaIntiPabrik">0</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Rendemen</td>
                                <td></td>
                                <td>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div id="rendemenMinyak">21,02%</div><button type="button" class="btn block"
                                            data-bs-toggle="modal" data-bs-target="#rendemenMinyakModal">
                                            <ion-icon name="create"
                                                class="icon-edit d-flex align-items-center justify-content-center"></ion-icon>
                                        </button>
                                    </div>
                                    <div class="modal fade" id="rendemenMinyakModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Input
                                                        Rendemen
                                                        Minyak
                                                        Sawit
                                                    </h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <div
                                                    class="modal-body d-flex justify-content-center align-items-center gap-2">
                                                    <label for="rendemenMinyakID">Rendemen
                                                        Minyak
                                                        Sawit :
                                                    </label>
                                                    <input type="number" id="rendemenMinyakID" name="rendemenMinyak">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
                                                        <i class="bx bx-x "></i>
                                                        <span>Batal</span>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-submit text-white bg-ksmard-active ms-1"
                                                        data-bs-dismiss="modal" onclick="updateRendemenMinyak()">
                                                        <i class="bx bx-check "></i>
                                                        <span>Submit</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td></td>
                                <td>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div id="rendemenInti">3,56%</div><button type="button" class="btn block"
                                            data-bs-toggle="modal" data-bs-target="#rendemenIntiModal">
                                            <ion-icon name="create"
                                                class="icon-edit d-flex align-items-center justify-content-center"></ion-icon>
                                        </button>
                                    </div>
                                    <div class="modal fade" id="rendemenIntiModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Input
                                                        Rendemen
                                                        Inti
                                                        Sawit
                                                    </h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <div
                                                    class="modal-body d-flex justify-content-center align-items-center gap-2">
                                                    <label for="rendemenIntiID">Rendemen
                                                        Inti
                                                        Sawit :
                                                    </label>
                                                    <input type="number" id="rendemenIntiID" name="rendemenInti">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
                                                        <i class="bx bx-x "></i>
                                                        <span>Batal</span>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-submit text-white bg-ksmard-active ms-1"
                                                        data-bs-dismiss="modal" onclick="updateRendemenInti()">
                                                        <i class="bx bx-check "></i>
                                                        <span>Submit</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>Harga TBS</td>
                                <td></td>
                                <td id="hargaTBSMinyak">0</td>
                                <td></td>
                                <td id="hargaTBSInti">0</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>Persentase Volume
                                    Penjualan</td>
                                <td></td>
                                <td>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div id="persentaseMinyak">100%</div><button type="button" class="btn block"
                                            data-bs-toggle="modal" data-bs-target="#persentaseMinyakModal">
                                            <ion-icon name="create"
                                                class="icon-edit d-flex align-items-center justify-content-center"></ion-icon>
                                        </button>
                                    </div>
                                    <div class="modal fade" id="persentaseMinyakModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Input
                                                        Persentase
                                                        Volume
                                                        Penjualan
                                                        Minyak
                                                        Sawit
                                                    </h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <div
                                                    class="modal-body d-flex justify-content-center align-items-center gap-2">
                                                    <label for="persentaseMinyakID">Persentase
                                                        Volume
                                                        Penjualan
                                                        Minyak
                                                        Sawit :
                                                    </label>
                                                    <input type="number" id="persentaseMinyakID"
                                                        name="persentaseMinyak">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
                                                        <i class="bx bx-x "></i>
                                                        <span>Batal</span>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-submit text-white bg-ksmard-active ms-1"
                                                        data-bs-dismiss="modal" onclick="updatePersentaseMinyak()">
                                                        <i class="bx bx-check "></i>
                                                        <span>Submit</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td></td>
                                <td>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div id="persentaseInti">100%</div><button type="button" class="btn block"
                                            data-bs-toggle="modal" data-bs-target="#persentaseIntiModal">
                                            <ion-icon name="create"
                                                class="icon-edit d-flex align-items-center justify-content-center"></ion-icon>
                                        </button>
                                    </div>
                                    <div class="modal fade" id="persentaseIntiModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Input
                                                        Persentase
                                                        Volume
                                                        Penjualan
                                                        Inti
                                                        Sawit
                                                    </h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <div
                                                    class="modal-body d-flex justify-content-center align-items-center gap-2">
                                                    <label for="persentaseIntiID">Persentase
                                                        Volume
                                                        Penjualan
                                                        Inti
                                                        Sawit :
                                                    </label>
                                                    <input type="number" id="persentaseIntiID" name="persentaseInti">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
                                                        <i class="bx bx-x "></i>
                                                        <span>Batal</span>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-submit text-white bg-ksmard-active ms-1"
                                                        data-bs-dismiss="modal" onclick="updatePersentaseInti()">
                                                        <i class="bx bx-check "></i>
                                                        <span>Submit</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>Harga TBS Rata-rata Ex
                                    Pabrik</td>
                                <td></td>
                                <td id="hargaTBSRataMinyak">0</td>
                                <td></td>
                                <td id="hargaTBSRataInti">0</td>
                                <td id="hargaTBSRataTandan">0</td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td>Biaya Pengolahan</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="d-flex tabel-title justify-content-between align-items-center">
                                        <div id="biayaPengolahan">94,75</div><button type="button" class="btn block"
                                            data-bs-toggle="modal" data-bs-target="#biayaPengolahanModal">
                                            <ion-icon name="create"
                                                class="icon-edit d-flex align-items-center justify-content-center"></ion-icon>
                                        </button>
                                    </div>
                                    <div class="modal fade" id="biayaPengolahanModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Data
                                                        Biaya
                                                        Pengolahan
                                                    </h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-bordered" id="tabelBiayaPengolahan">
                                                        <thead>
                                                            <td>No</td>
                                                            <td>Tanggal</td>
                                                            <td>Biaya
                                                                Pengolahan</td>
                                                            <td>TBS
                                                                Diolah</td>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>xx</td>
                                                                <td>Rp
                                                                    <input type="number" value="1140166076"
                                                                        class="border-0 biayaPengolahan">
                                                                </td>
                                                                <td>Rp
                                                                    <input type="number" value="12033323"
                                                                        class="border-0 tbsPengolahan">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
                                                        <i class="bx bx-x "></i>
                                                        <span>Batal</span>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-submit text-white bg-ksmard-active ms-1"
                                                        data-bs-dismiss="modal" onclick="hitungBiayaPengolahan()">
                                                        <i class="bx bx-check "></i>
                                                        <span>Submit</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td>Penyusutan</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div id="penyusutan">38,86</div><button type="button" class="btn block"
                                            data-bs-toggle="modal" data-bs-target="#penyusutanModal">
                                            <ion-icon name="create"
                                                class="icon-edit d-flex align-items-center justify-content-center"></ion-icon>
                                        </button>
                                    </div>
                                    <div class="modal fade" id="penyusutanModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Data
                                                        Penyusutan
                                                    </h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-bordered" id="tabelPenyusutan">
                                                        <thead>
                                                            <td>No</td>
                                                            <td>Tanggal</td>
                                                            <td>Biaya
                                                                Pengolahan</td>
                                                            <td>TBS
                                                                Diolah</td>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>xx</td>
                                                                <td>Rp
                                                                    <input type="number" value="467562276"
                                                                        class="border-0 biayaPenyusutan">
                                                                </td>
                                                                <td>Rp
                                                                    <input type="number" value="12033323"
                                                                        class="border-0 tbsPenyusutan">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
                                                        <i class="bx bx-x "></i>
                                                        <span>Batal</span>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-submit text-white bg-ksmard-active ms-1"
                                                        data-bs-dismiss="modal" onclick="hitungPenyusutan()">
                                                        <i class="bx bx-check"></i>
                                                        <span>Submit</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>13</td>
                                <td>Nilai TBS di Timbangan
                                    Pabrik</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id="TBSTimbanganPabrik">0</td>
                            </tr>
                            <tr>
                                <td>14</td>
                                <td>Biaya Operasinal Tidak
                                    Langsung</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id="biayaOPL">0</td>
                            </tr>
                            <tr>
                                <td>15</td>
                                <td>Nilai TBS Pabrik</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id="nilaiTBS">0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-3 d-flex justify-content-center card-biaya-container">
                    <div class="w-100 d-flex flex-column align-items-center">
                        <div class="w-100 index-title d-flex align-items-center justify-content-center">
                            <h5 class="text-white text-center mb-0">Index
                                K</h5>
                        </div>
                        <div class="index-value d-flex justify-content-center align-items-center">
                            <h1 class="text-white" id="nilaiIndex">0%</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection() ?>