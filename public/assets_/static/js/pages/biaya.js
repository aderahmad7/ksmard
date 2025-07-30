const hargaMinyakEl = document.getElementById('hargaMinyak');
const hargaIntiEl = document.getElementById('hargaInti');
const pajakMinyakEl = document.getElementById('pajakMinyak');
const pajakIntiEl = document.getElementById('pajakInti');
const pemasaranMinyakEl = document.getElementById('pemasaranMinyak');
const pemasaranIntiEl = document.getElementById('pemasaranInti');
const hargaBersihMinyakEl = document.getElementById('hargaBersihMinyak');
const hargaBersihIntiEl = document.getElementById('hargaBersihInti');
const pengangkutanMinyakEl = document.getElementById('pengangkutanMinyak');
const pengangkutanIntiEl = document.getElementById('pengangkutanInti');
const hargaMinyakPabrikEl = document.getElementById('hargaMinyakPabrik');
const hargaIntiPabrikEl = document.getElementById('hargaIntiPabrik');
const rendemenMinyakEl = document.getElementById('rendemenMinyak');
const rendemenIntiEl = document.getElementById('rendemenInti');
const hargaTBSMinyakEl = document.getElementById('hargaTBSMinyak');
const hargaTBSIntiEl = document.getElementById('hargaTBSInti');
const persentaseMinyakEl = document.getElementById('persentaseMinyak');
const persentaseIntiEl = document.getElementById('persentaseInti');
const hargaTBSRataMinyakEl = document.getElementById('hargaTBSRataMinyak');
const hargaTBSRataIntiEl = document.getElementById('hargaTBSRataInti');
const hargaTBSRataTandanEl = document.getElementById('hargaTBSRataTandan');
const biayaPengolahanEl = document.getElementById('biayaPengolahan');
const penyusutanEl = document.getElementById('penyusutan');
const TBSTimbanganPabrikEl = document.getElementById('TBSTimbanganPabrik');
const biayaOPLEl = document.getElementById('biayaOPL')
const nilaiTBSEl = document.getElementById('nilaiTBS');


const monthSelect = document.getElementById('monthSelect');
const yearSelect = document.getElementById('yearSelect');

dataTBS = {
    1: [
        {
            2023: [
                {
                    hargaMinyak: '11.005,00',
                    hargaInti: '4.850,00',
                    pajakMinyak: '-',
                    pajakInti: '-',
                    pemasaranMinyak: '-',
                    pemasaranInti: '-',
                    pengangkutanMinyak: '292,00',
                    pengangkutanInti: '292,00',
                    rendemenMinyak: '21,02%',
                    rendemenInti: '3,56%',
                    persentaseMinyak: '100%',
                    persentaseInti: '100%',
                    biayaPengolahan: '94,75',
                    penyusutan: '38,86'
                },
            ],
            2024: [
                {
                    hargaMinyak: '11.883,71',
                    hargaInti: '5.000,00',
                    pajakMinyak: '-',
                    pajakInti: '-',
                    pemasaranMinyak: '-',
                    pemasaranInti: '-',
                    pengangkutanMinyak: '292,00',
                    pengangkutanInti: '292,00',
                    rendemenMinyak: '20,45%',
                    rendemenInti: '3,40%',
                    persentaseMinyak: '100%',
                    persentaseInti: '100%',
                    biayaPengolahan: '150,21',
                    penyusutan: '40,15'
                }
            ]
        },
    ],
    2: [
        {
            2023: [
                {
                hargaMinyak: '10.500,00',
                hargaInti: '4.700,00',
                pajakMinyak: '-',
                pajakInti: '-',
                pemasaranMinyak: '-',
                pemasaranInti: '-',
                pengangkutanMinyak: '292,00',
                pengangkutanInti: '292,00',
                rendemenMinyak: '22,00%',
                rendemenInti: '3,75%',
                persentaseMinyak: '98%',
                persentaseInti: '97%',
                biayaPengolahan: '92,00',
                penyusutan: '38,84'
                },
            ],
            2024: [
                {
                hargaMinyak: '11.950,50',
                hargaInti: '5.100,00',
                pajakMinyak: '-',
                pajakInti: '-',
                pemasaranMinyak: '-',
                pemasaranInti: '-',
                pengangkutanMinyak: '292,00',
                pengangkutanInti: '292,00',
                rendemenMinyak: '21,50%',
                rendemenInti: '3,60%',
                persentaseMinyak: '99%',
                persentaseInti: '98%',
                biayaPengolahan: '152,54',
                penyusutan: '40,98'
                }
            ]
        }
    ]
}

dataHarga = {
    1: [
        {
            2023: [
                {
                    hargaMinyakSawit: '11055',
                    volumePenjualanMinyak: '500000',
                    hargaIntiSawit: '4850',
                    volumePenjualanInti: '300000',
                },
            ],
            2024: [
                {
                    hargaMinyakSawit: '11883.71',
                    volumePenjualanMinyak: '500000',
                    hargaIntiSawit: '5000',
                    volumePenjualanInti: '300000',
                }
            ]
        }
    ],
    2: [
        {
            2023: [
                {
                    hargaMinyakSawit: '10500',
                    volumePenjualanMinyak: '480000',
                    hargaIntiSawit: '4700',
                    volumePenjualanInti: '280000',
                },
            ],
            2024: [
                {
                    hargaMinyakSawit: '11950.50',
                    volumePenjualanMinyak: '520000',
                    hargaIntiSawit: '5100',
                    volumePenjualanInti: '310000',
                }
            ],
        }
    ]
}

dataBiayaPengolahan = {
    1:[
        {
            2023: [
                {
                    biayaPengolahan: '1140166076',
                    TBSDiolah: '12033323',
                }
            ], 
            2024: [
                {
                    biayaPengolahan: '1740166076',
                    TBSDiolah: '11585144',
                }
            ]
        }
    ],
    2: [
        {
            2023: [
                {
                    biayaPengolahan: '1150000000',
                    TBSDiolah: '12500000',
                }
            ],
            2024: [
                {
                    biayaPengolahan: '1800000000',
                    TBSDiolah: '11800000',
                }
            ],
        }
    ]
}

dataPenyusutan = {
    1: [
        {
            2023:[
                {
                    biayaPenyusutan: '467562276',
                    TBSDiolah: '12033323',
                }
            ],
            2024: [
                {
                    biayaPenyusutan: '497762276',
                    TBSDiolah: '12033323',
                }
            ]
        }
    ],
    2: [
        {
            2023: [
                {
                    biayaPenyusutan: '470000000',
                    TBSDiolah: '12100000',
                }
            ],
            2024: [
                {
                    biayaPenyusutan: '500000000',
                    TBSDiolah: '12200000',
                }
            ],
        }
    ]
}


function updateTable() {
    const selectedMonth = monthSelect.value;
    const selectedYear = yearSelect.value;
    const monthDataTBS = dataTBS[selectedMonth][0][selectedYear][0];
    const monthDataHarga = dataHarga[selectedMonth][0][selectedYear][0];
    const monthDataPengolahan = dataBiayaPengolahan[selectedMonth][0][selectedYear][0];
    const monthDataPenyusutan = dataPenyusutan[selectedMonth][0][selectedYear][0];

    document.querySelectorAll('.hargaMinyak').forEach(row => {
        row.value = monthDataHarga.hargaMinyakSawit;
    });
    document.querySelectorAll('.hargaInti').forEach(row => {
        row.value = monthDataHarga.hargaIntiSawit;
    })

    document.querySelector('.biayaPengolahan').value = monthDataPengolahan.biayaPengolahan;
    document.querySelector('.tbsPengolahan').value = monthDataPengolahan.TBSDiolah;
    document.querySelector('.biayaPenyusutan').value = monthDataPenyusutan.biayaPenyusutan;
    document.querySelector('.tbsPenyusutan').value = monthDataPenyusutan.TBSDiolah;




    console.log(monthDataTBS.hargaMinyak);
    hargaMinyakEl.textContent = monthDataTBS.hargaMinyak;
    hargaIntiEl.textContent = monthDataTBS.hargaInti;
    pajakMinyakEl.textContent = monthDataTBS.pajakMinyak;
    pajakIntiEl.textContent = monthDataTBS.pajakInti;
    pemasaranMinyakEl.textContent = monthDataTBS.pemasaranMinyak;
    pemasaranIntiEl.textContent = monthDataTBS.pemasaranInti;
    pengangkutanMinyakEl.textContent = monthDataTBS.pengangkutanMinyak;
    pengangkutanIntiEl.textContent = monthDataTBS.pengangkutanInti;
    rendemenMinyakEl.textContent = monthDataTBS.rendemenMinyak;
    rendemenIntiEl.textContent = monthDataTBS.rendemenInti;
    persentaseMinyakEl.textContent = monthDataTBS.persentaseMinyak;
    persentaseIntiEl.textContent = monthDataTBS.persentaseInti;
    biayaPengolahanEl.textContent = monthDataTBS.biayaPengolahan;
    penyusutanEl.textContent = monthDataTBS.penyusutan;
    updateTBS();
}

monthSelect.addEventListener('change', updateTable)
yearSelect.addEventListener('change', updateTable)


const getDataModal = function(idModal, idInput, element) {
    const modal = document.getElementById(`${idModal}`);
    const input = document.getElementById(`${idInput}`);
    modal.addEventListener('show.bs.modal', () => {
        const valueInput = element.textContent.replace(/\./g, '').replace(',', '.');
        element.value = parseFloat(valueInput);
    })
}

function updateData(inputID, element, dataKey) {
    let nilai = 0;
    const input = document.getElementById(`${inputID}`);
    nilai += parseFloat(input.value);
    dataTBS[monthSelect.value][0][yearSelect.value][0][dataKey] = nilai.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    element.textContent = nilai.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    updateTBS();
}

function updateDataPersen(inputID, element, dataKey) {
    let nilai = 0;
    const input = document.getElementById(`${inputID}`);
    nilai += parseFloat(input.value);
    dataTBS[monthSelect.value][0][yearSelect.value][0][dataKey] = `${nilai}%`;
    element.textContent = `${nilai}%`;
    updateTBS();
}

// Modal Pajak Minyak
getDataModal('pajakMinyakModal', 'pajakMinyakID', pajakMinyakEl);
const updatePajakMinyak = () => updateData('pajakMinyakID', pajakMinyakEl, 'pajakMinyak');


// Modal Pajak Inti
getDataModal('pajakIntiModal', 'pajakIntiID', pajakIntiEl);
const updatePajakInti = () => updateData('pajakIntiID', pajakIntiEl, 'pajakInti');

// Modal Pemasaran Minyak
getDataModal('pemasaranMinyakModal', 'pemasaranMinyakID', pemasaranMinyakEl);
const updatePemasaranMinyak = () => updateData('pemasaranMinyakID', pemasaranMinyakEl, 'pemasaranMinyak');

// Modal Pemasaran Inti
getDataModal('pemasaranIntiModal', 'pemasaranIntiID', pemasaranIntiEl);
const updatePemasaranInti = () => updateData('pemasaranIntiID', pemasaranIntiEl, 'pemasaranInti');

// Modal Rendemen Minyak
getDataModal('rendemenMinyakModal', 'rendemenMinyakID', rendemenMinyakEl);
const updateRendemenMinyak = () => updateDataPersen('rendemenMinyakID', rendemenMinyakEl, 'rendemenMinyak');

// Modal Rendemen Inti
getDataModal('rendemenIntiModal', 'rendemenIntiID', rendemenIntiEl);
const updateRendemenInti = () => updateDataPersen('rendemenIntiID', rendemenIntiEl, 'rendemenInti');

// Modal Persentase Minyak
getDataModal('persentaseMinyakModal', 'persentaseMinyakID', persentaseMinyakEl);
const updatePersentaseMinyak = () => updateDataPersen('persentaseMinyakID', persentaseMinyakEl, 'persentaseMinyak');

// Modal Persentase Inti
getDataModal('persentaseIntiModal', 'persentaseIntiID', persentaseIntiEl);
const updatePersentaseInti = () => updateDataPersen('persentaseIntiID', persentaseIntiEl, 'persentaseInti');



function hitungHargaMinyak () {
    let totalVolume = 0;
    let totalPenjualan = 0;
    let hargaFOB = 0;

    document.querySelectorAll('#tabelHargaMinyak tbody tr').forEach(row => {
        const harga = parseFloat(row.querySelector('.hargaMinyak').value);
        const volume = parseFloat(row.querySelector('.volumeMinyak').value);
        const total = harga * volume;
        row.querySelector('.total').textContent = total;
        totalVolume += volume
        totalPenjualan += total;
    })

    hargaFOB = totalPenjualan / totalVolume;
    hargaMinyakEl.textContent = hargaFOB.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    dataTBS[monthSelect.value][0][yearSelect.value][0].hargaMinyak = hargaFOB.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    updateTBS();
}

function hitungHargaInti () {
    let totalVolume = 0;
    let totalPenjualan = 0;
    let hargaFOB = 0;

    document.querySelectorAll('#tabelHargaInti tbody tr').forEach(row => {
        const harga = parseFloat(row.querySelector('.hargaInti').value);
        const volume = parseFloat(row.querySelector('.volumeInti').value);
        const total = harga * volume;
        row.querySelector('.total').textContent = total;
        totalVolume += volume
        totalPenjualan += total;
    })

    hargaFOB = totalPenjualan / totalVolume;
    console.log(hargaFOB);
    hargaIntiEl.textContent = hargaFOB.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    dataTBS[monthSelect.value][0][yearSelect.value][0].hargaInti = hargaFOB.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    updateTBS();
}

function hitungPengangkutanMinyak() {
    let totalVolume = 0;
    let totalBiaya = 0;
    let pengangkutanMinyak = 0;

    document.querySelectorAll('#tabelPengangkutanMinyak tbody tr').forEach(row => {
        const volume = parseFloat(row.querySelector('.volume').value);
        const biaya = parseFloat(row.querySelector('.biaya').value);
        totalVolume += volume;
        totalBiaya += biaya;
    })
    pengangkutanMinyak = totalVolume / totalBiaya;
    pengangkutanMinyakEl.textContent = pengangkutanMinyak.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    dataTBS[monthSelect.value][0][yearSelect.value][0].pengangkutanMinyak = pengangkutanMinyak.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    updateTBS();
}

function hitungPengangkutanInti() {
    let totalVolume = 0;
    let totalBiaya = 0;
    let pengangkutanInti = 0;

    document.querySelectorAll('#tabelPengangkutanInti tbody tr').forEach(row => {
        const volume = parseFloat(row.querySelector('.volume').value);
        const biaya = parseFloat(row.querySelector('.biaya').value);
        totalVolume += volume;
        totalBiaya += biaya;
    })
    pengangkutanInti = totalVolume / totalBiaya;
    pengangkutanIntiEl.textContent = pengangkutanInti.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    dataTBS[monthSelect.value][0][yearSelect.value][0].pengangkutanInti = pengangkutanInti.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    updateTBS();
}

function hitungBiayaPengolahan () {
    let totalBiaya = 0;
    let totalTBS = 0;
    let biayaPengolahan = 0;

    document.querySelectorAll('#tabelBiayaPengolahan tbody tr').forEach(row => {
        const biaya = parseFloat(row.querySelector('.biayaPengolahan').value);
        const tbs = parseFloat(row.querySelector('.tbsPengolahan').value);
        totalBiaya += biaya;
        totalTBS += tbs;
    })
    biayaPengolahan = totalBiaya / totalTBS;
    console.log(biayaPengolahan);
    console.log(totalBiaya);
    console.log(totalTBS);
    biayaPengolahanEl.textContent = biayaPengolahan.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    dataTBS[monthSelect.value][0][yearSelect.value][0].biayaPengolahan = biayaPengolahan.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    updateTBS();
}

function hitungPenyusutan () {
    let totalBiaya = 0;
    let totalTBS = 0;
    let penyusutan = 0;

    document.querySelectorAll('#tabelPenyusutan tbody tr').forEach(row => {
        const biaya = parseFloat(row.querySelector('.biayaPenyusutan').value);
        const tbs = parseFloat(row.querySelector('.tbsPenyusutan').value);
        totalBiaya += biaya;
        totalTBS += tbs;
    })
    penyusutan = totalBiaya / totalTBS;
    penyusutanEl.textContent = penyusutan.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    dataTBS[monthSelect.value][0][yearSelect.value][0].penyusutan = penyusutan.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    updateTBS();
}


function updateTBS() {
    const hargaMinyak = hargaMinyakEl.textContent.replace(/\./g, '').replace(',', '.');
    const hargaInti = hargaIntiEl.textContent.replace(/\./g, '').replace(',', '.');
    const pajakMinyak = pajakMinyakEl.textContent.replace(/\./g, '').replace(',', '.').replace('-', 0);
    const pajakInti = pajakIntiEl.textContent.replace(/\./g, '').replace(',', '.').replace('-', 0);
    const pemasaranMinyak = pemasaranMinyakEl.textContent.replace(/\./g, '').replace(',', '.').replace('-', 0);
    const pemasaranInti = pemasaranIntiEl.textContent.replace(/\./g, '').replace(',', '.').replace('-', 0);
    const hargaBersihMinyak = hargaBersihMinyakEl.textContent.replace(/\./g, '').replace(',', '.');
    const hargaBersihInti = hargaBersihIntiEl.textContent.replace(/\./g, '').replace(',', '.');
    const pengangkutanMinyak = pengangkutanMinyakEl.textContent.replace(",", ".");
    const pengangkutanInti = pengangkutanIntiEl.textContent.replace(",", ".");
    const hargaMinyakPabrik = hargaMinyakPabrikEl.textContent.replace(/\./g, '').replace(',', '.');
    const hargaIntiPabrik = hargaIntiPabrikEl.textContent.replace(/\./g, '').replace(',', '.');
    const rendemenMinyak = rendemenMinyakEl.textContent.replace("%", "").replace(",", ".");
    const rendemenInti = rendemenIntiEl.textContent.replace("%", "").replace(",", ".");
    const hargaTBSMinyak = hargaTBSMinyakEl.textContent.replace(/\./g, '').replace(',', '.');
    const hargaTBSInti = hargaTBSIntiEl.textContent.replace(/\./g, '').replace(',', '.');
    const persentaseMinyak = persentaseMinyakEl.textContent.replace('%', '').replace(",", ".");
    const persentaseInti = persentaseIntiEl.textContent.replace('%', '').replace(",", ".");
    const hargaTBSRataMinyak = hargaTBSRataMinyakEl.textContent.replace(/\./g, '').replace(',', '.');
    const hargaTBSRataInti = hargaTBSRataIntiEl.textContent.replace(/\./g, '').replace(',', '.');
    const hargaTBSRataTandan = hargaTBSRataTandanEl.textContent.replace(/\./g, '').replace(',', '.');
    const biayaPengolahan = biayaPengolahanEl.textContent.replace(',', '.');
    const penyusutan = penyusutanEl.textContent.replace(',', '.');
    const TBSTimbanganPabrik = TBSTimbanganPabrikEl.textContent.replace(/\./g, '').replace(',', '.');
    const biayaOPL = biayaOPLEl.textContent.replace(",", ".")
    const nilaiTBS = nilaiTBSEl.textContent.replace(/\./g, '').replace(',', '.');

    // Harga (FOB) Bersih
    const getHargaBersihMinyak = parseFloat(hargaMinyak) - pajakMinyak - pemasaranMinyak;
    const getHargaBersihInti = parseFloat(hargaInti) - pajakInti - pemasaranInti;
    hargaBersihMinyakEl.textContent = getHargaBersihMinyak.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    hargaBersihIntiEl.textContent = getHargaBersihInti.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});

    // Harga Bersih Pabrik / Tangki Pabrik
    const getHargaMinyakPabrik = getHargaBersihMinyak - parseFloat(pengangkutanMinyak);
    const getHargaIntiPabrik = getHargaBersihInti - parseFloat(pengangkutanInti);
    hargaMinyakPabrikEl.textContent = getHargaMinyakPabrik.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    hargaIntiPabrikEl.textContent = getHargaIntiPabrik.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});

    // Harga TBS
    const getHargaTBSMinyak = getHargaMinyakPabrik * rendemenMinyak / 100;
    const getHargaTBSInti = getHargaIntiPabrik * rendemenInti / 100;
    hargaTBSMinyakEl.textContent = getHargaTBSMinyak.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    hargaTBSIntiEl.textContent = getHargaTBSInti.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});

    // Harga TBS Rata-Rata Ex Pabrik
    const getHargaTBSRataMinyak = getHargaTBSMinyak * persentaseMinyak / 100;
    const getHargaTBSRataInti = getHargaTBSInti * persentaseInti / 100;
    const getHargaTBSRataTandan = getHargaTBSRataMinyak + getHargaTBSRataInti;
    hargaTBSRataMinyakEl.textContent = getHargaTBSRataMinyak.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    hargaTBSRataIntiEl.textContent = getHargaTBSRataInti.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    hargaTBSRataTandanEl.textContent = getHargaTBSRataTandan.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});

    // Nilai TBS di Timbanagn Pabrik
    const getTBSTimbanganPabrik = getHargaTBSRataTandan - parseFloat(biayaPengolahan) - parseFloat(penyusutan);
    TBSTimbanganPabrikEl.textContent = getTBSTimbanganPabrik.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});

    // Biaya Operasional Tidak Langsung
    const getBiayaOPL = getTBSTimbanganPabrik * 1.58 / 100;
    biayaOPLEl.textContent = getBiayaOPL.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});

    // Nilai TBS Pabrik
    const getNilaiTBS = getTBSTimbanganPabrik - getBiayaOPL;
    nilaiTBSEl.textContent = getNilaiTBS.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});

    // Get Nilai Index
    const getHargaMinyak = getHargaBersihMinyak * parseFloat(rendemenMinyak) / 100;
    const getHargaInti = getHargaBersihInti * parseFloat(rendemenInti) / 100;
    getNilaiIndex = getNilaiTBS / (getHargaMinyak + getHargaInti) * 100;
    console.log(getNilaiIndex.toFixed(2) + "%");
    let nilaiIndex = document.getElementById('nilaiIndex').textContent = `${getNilaiIndex.toFixed(2)}%`;
}
updateTBS();
hitungHargaMinyak();
hitungHargaInti();


