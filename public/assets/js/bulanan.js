$(document).ready(function () {
    $('#bulananTable').DataTable({
        "pageLength": 25,
        "ordering": false,
        "language": {
            "search": "FILTER KREATOR:",
            "zeroRecords": "DATA TIDAK DITEMUKAN",
            "info": "MENAMPILKAN _PAGE_ DARI _PAGES_ OPERASI",
            "infoEmpty": "ARSIP KOSONG"
        }
    });
});
