<?= $this->extend('layouts/template-company.php') ?>

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
                        <option value="2">Maret</option>
                        <option value="2">April</option>
                        <option value="2">Mei</option>
                        <option value="2">Juni</option>
                        <option value="2">Juli</option>
                        <option value="2">Agustus</option>
                        <option value="2">September</option>
                        <option value="2">November</option>
                        <option value="2">Desember</option>
                        <!-- Tambahkan opsi untuk bulan lainnya -->
                    </select>
                </div>
                <div class="pilih-tahun">
                    <span class="me-2">Pilih Tahun : </span>
                    <select id="yearSelect" class="mb-5 text-white bg-ksmard-active p-2 border-0 rounded-2">
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2024">2025</option>
                        <!-- Tambahkan opsi untuk bulan lainnya -->
                    </select>
                </div>
            </div><button onclick="addRow()" class="btn btn-primary">Tambah Baris</button>
            <div class="row d-flex container-biaya">
                
                <div class="col-9 container-table table-responsive">
                    <table class="table table-bordered"  id="dynamicTable">
                        <thead>
                            
                            <tr>
                                <th>NO</th>
                                <th>URAIAN</th>
                                <th>KATEGORI</th>
                                <th>HARGA</th>
                                <th>JUMLAH</th>
                                <th>TOTAL</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody id="item">
                           
                        </tbody>
                    </table>
                </div>

                <div class="col-3 d-flex justify-content-center card-biaya-container">
                    <div class="w-100 d-flex flex-column align-items-center">
                        <div class="w-100 index-title d-flex align-items-center justify-content-center">
                            <h5 class="text-white text-center mb-0">TOTAL BIAYA</h5>
                        </div>
                        <div class="index-value d-flex justify-content-center align-items-center">
                            <h1 class="text-white" id="grandTotal"></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
        let rowCount = 0;

        function addRow() {
            rowCount++;
            let table = document.getElementById("dynamicTable").getElementsByTagName('tbody')[0];
            let row = table.insertRow();

            row.innerHTML = `
                <td>${rowCount}</td>
                <td><input type="text" name="uraian[]" class="form-control" placeholder="Masukkan Uraian"></td>
                <td>
                    <select name="kategori[]" class="form-control">
                        <option value="Kategori 1">Biaya operasional pabrik</option>
                        <option value="Kategori 2">Upah tenaga kerja </option>
                        <option value="Kategori 3">Biaya depreciation mesin & fasilitas</option>
                    </select>
                </td>
                <td><input type="number" name="harga[]" class="form-control harga" placeholder="0" oninput="formatNumber(this);)"></td>
                <td><input type="number" name="jumlah[]" class="form-control jumlah" placeholder="0" oninput="calculateTotal(this)"></td>
                <td><input type="text" name="total[]" class="form-control total" readonly></td>
                <td><button type="button" class="btn btn-danger remove-btn" onclick="removeRow(this)">Hapus</button></td>
            `;
            updateGrandTotal();
        }

        function formatRibuan(number) {
            return parseFloat(number).toLocaleString("id-ID");
        }

        function formatNumber(element) {
            let value = element.value.replace(/,/g, "");
            if (!isNaN(value) && value !== "") {
                element.value = formatRibuan(value);
            } else {
                element.value = "";
            }
        }

        function calculateTotal(element) {
            let row = element.closest("tr");
            let hargaInput = row.querySelector(".harga");
            let jumlah = row.querySelector(".jumlah").value || 0;
            let totalInput = row.querySelector(".total");

            // Convert harga ke angka (remove formatting)
            let harga = hargaInput.value.replace(/,/g, "") || 0;
            let total = parseFloat(harga) * parseFloat(jumlah);

            // Set nilai total dengan format ribuan
            totalInput.value = formatRibuan(total);

            updateGrandTotal();
        }


        function updateGrandTotal() {
            let totalFields = document.querySelectorAll(".total");
            let grandTotal = 0;

            totalFields.forEach(field => {
                grandTotal += parseFloat(field.value) || 0;
            });

            console.log(grandTotal);

            $("#grandTotal").html(formatRibuan(grandTotal));
        }

        function removeRow(button) {
            let row = button.closest("tr");
            row.remove();
            updateRowNumbers();
        }

        function updateRowNumbers() {
            let table = document.getElementById("dynamicTable").getElementsByTagName('tbody')[0];
            rowCount = 0;
            for (let row of table.rows) {
                rowCount++;
                row.cells[0].textContent = rowCount;
            }
        }
    </script>

<?= $this->endSection() ?>