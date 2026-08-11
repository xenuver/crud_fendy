document.addEventListener('DOMContentLoaded', function() {
    $('#tieringTable').DataTable({
        "pageLength": 25,
        "autoWidth": false,
        "language": {
            "search": "Cari Kreator:",
            "lengthMenu": "Tampilkan _MENU_ data",
            "info": "Menampilkan _PAGE_ dari _PAGES_ peringkat",
            "zeroRecords": "Kreator tidak ditemukan dalam peringkat",
            "infoEmpty": "Papan peringkat kosong",
            "paginate": {
                "previous": "Sebelumnya",
                "next": "Berikutnya"
            }
        }
    });
});
