function formatUangTanpaRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
}

function generateNomorUrut(urut) {
    const now = new Date();
    const tanggal = String(now.getDate()).padStart(2, '0');
    const bulan = String(now.getMonth() + 1).padStart(2, '0'); // Januari = 0
    const tahun = String(now.getFullYear());

    return `${tanggal}${bulan}${tahun}-${String(urut).padStart(3, '0')}`;
}

function generateNoUrutDateMonth(urut) {
    const now = new Date();
    const tanggal = String(now.getDate()).padStart(2, '0');
    const bulan = String(now.getMonth() + 1).padStart(2, '0'); // Januari = 0
    const tahun = String(now.getFullYear());
    const urutt = parseInt(urut);
    return `${tahun}${bulan}${String(urutt+1).padStart(3, '0')}`;
}
const now = new Date();
const tanggal = String(now.getDate()).padStart(2, '0');
const bulan = String(now.getMonth() + 1).padStart(2, '0'); // Januari = 0
const tahun = String(now.getFullYear());

function resultFormatAngka(lokalString) {
    // Langkah 1: Hilangkan pemisah ribuan (titik)
    const tanpaTitik = lokalString.replace(/\./g, "");

    // Langkah 2: Ganti koma dengan titik sebagai desimal
    const denganTitikDesimal = tanpaTitik.replace(",", ".");

    // Langkah 3: Konversi ke number
    return parseFloat(denganTitikDesimal);
}

function formatAngkaView(angka) {
    const formatID = new Intl.NumberFormat('id-ID', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });

    return formatID.format(angka);

}

function generateNewId(latestId) {
    if (!latestId) return 'BR-001';

    const [prefix, number] = latestId.split('-');
    const newNumber = String(parseInt(number, 10) + 1).padStart(3, '0');
    if (newNumber >= 999) {
        return 'erorr'
    }
    return `${prefix}-${newNumber}`;
}

function generateNewId_BRJ(latestId) {
    if (!latestId) return 'FG-001';

    const [prefix, number] = latestId.split('-');
    const newNumber = String(parseInt(number, 10) + 1).padStart(3, '0');
    if (newNumber >= 999) {
        return 'erorr'
    }
    return `${prefix}-${newNumber}`;
}

function generateNewId_sup(lastId) {
    if (!lastId) return 'S001';
    const prefix = lastId.match(/[A-Z]+/)[0]; // Extract letters
    const number = parseInt(lastId.match(/\d+/)[0]); // Extract number
    const newNumber = number + 1;
    return prefix + String(newNumber).padStart(3, '0');
}

function generateNewId_cus(lastId) {
    if (!lastId) return 'C001';
    const prefix = lastId.match(/[A-Z]+/)[0]; // Extract letters
    const number = parseInt(lastId.match(/\d+/)[0]); // Extract number
    const newNumber = number + 1;
    return prefix + String(newNumber).padStart(3, '0');
}

function generateNewId_rls_sup(latestId) {
    if (!latestId) return 'RLS-001';

    const [prefix, number] = latestId.split('-');
    const newNumber = String(parseInt(number, 10) + 1).padStart(3, '0');
    if (newNumber >= 999) {
        return 'erorr'
    }
    return `${prefix}-${newNumber}`;
}

function generateNewId_rls_RBC(latestId) {
    if (!latestId) return 'RBC-001';

    const [prefix, number] = latestId.split('-');
    const newNumber = String(parseInt(number, 10) + 1).padStart(3, '0');
    if (newNumber >= 999) {
        return 'erorr'
    }
    return `${prefix}-${newNumber}`;
}

function generateNewId_Satuan(lastId) {
    if (!lastId) return '01';
    // /const prefix = lastId.match(0)[0]; / / Extract letters
    const number = parseInt(lastId); // Extract number
    const newNumber = number + 1;
    return String(newNumber).padStart(2, '0');
}

function generateNewId_Jenis(lastId) {
    if (!lastId) return '01';
    // /const prefix = lastId.match(0)[0]; / / Extract letters
    const number = parseInt(lastId); // Extract number
    const newNumber = number + 1;
    return String(newNumber).padStart(2, '0');
}

function generateNewId_JenisBRJ(lastId) {
    if (!lastId) return '01';
    // /const prefix = lastId.match(0)[0]; / / Extract letters
    const number = parseInt(lastId); // Extract number
    const newNumber = number + 1;
    return String(newNumber).padStart(2, '0');
}

function generateNewId_Supplier(lastId) {
    if (!lastId) return '001';
    // /const prefix = lastId.match(0)[0]; / / Extract letters
    const number = parseInt(lastId); // Extract number
    const newNumber = number + 1;
    return String(newNumber).padStart(3, '0');
}

function generateNewId_Customer(lastId) {
    if (!lastId) return '001';
    // /const prefix = lastId.match(0)[0]; / / Extract letters
    const number = parseInt(lastId); // Extract number
    const newNumber = number + 1;
    return String(newNumber).padStart(3, '0');
}

function autoFormatNPWP(NPWPString) {
    try {
        var cleaned = ("" + NPWPString).replace(/\D/g, "");
        var match = cleaned.match(/(\d{0,2})?(\d{0,3})?(\d{0,3})?(\d{0,1})?(\d{0,3})?(\d{0,3})$/);
        return [
            match[1],
            match[2] ? "." : "",
            match[2],
            match[3] ? "." : "",
            match[3],
            match[4] ? "." : "",
            match[4],
            match[5] ? "-" : "",
            match[5],
            match[6] ? "." : "",
            match[6]
        ].join("")

    } catch (err) {
        return "";
    }
}