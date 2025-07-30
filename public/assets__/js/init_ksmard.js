function formatRibuan(angka, prefix) {
    angka = angka.toString();

    // Normalisasi: ganti desimal titik ke koma, hanya jika input pakai titik desimal
    if (angka.includes('.') && !angka.includes(',')) {
        // Anggap titik sebagai desimal, bukan ribuan
        const parts = angka.split('.');
        if (parts.length === 2 && parts[1].length <= 2) {
            angka = parts[0] + ',' + parts[1];
        }
    }

    let number_string = angka.replace(/[^,\d]/g, ''),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        const separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;

    return prefix === undefined ? rupiah : (rupiah ? prefix + rupiah : '');
}
