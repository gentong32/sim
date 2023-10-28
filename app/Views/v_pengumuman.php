<?= $this->extend('layout/layout_default') ?>

<?= $this->section('style') ?>
<style>
    :root {
        --ukf: 12px;
    }

    /* Gaya CSS untuk kalender */
    .calendar {
        font-family: Arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    .calendar th,
    .calendar td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: center;
    }

    .calendar th {
        background-color: #f2f2f2;
    }

    .calendar td:hover {
        background-color: #f9f9f9;
    }

    .today {
        color: blue;
        /* Ganti dengan warna yang diinginkan */
        font-weight: bold;
        /* Opsional: Tambahkan tebal pada teks tanggal hari ini */
    }

    /* Gaya CSS untuk acara */
    .event {
        font-size: 10px;
        margin-top: 2px;
        text-align: center;
        white-space: nowrap;
    }

    .meeting {
        background-color: lightblue;
        /* Ganti dengan warna yang diinginkan */
    }

    .training {
        background-color: lightgreen;
        /* Ganti dengan warna yang diinginkan */
    }

    .exam {
        background-color: lightcoral;
        /* Ganti dengan warna yang diinginkan */
    }

    /* Gaya CSS untuk sel tanggal dengan acara */
    .has-event {
        cursor: pointer;
    }

    /* Gaya CSS untuk daftar acara */
    /* Gaya CSS untuk daftar acara */
    .event-list {
        flex: 1;
        overflow: hidden;
    }

    #agenda {
        padding-left: 10px;
        text-align: left;
        background-color: #356fae;
        color: aliceblue;
        padding: 10px;
    }

    #agenda>div {
        margin-bottom: 10px;
        /* Jarak antara entri agenda */
    }


    .tanggalan {
        display: flex;
        margin-left: 15px;
        margin-right: 15px;
        flex-wrap: wrap;
        font-size: 14px;
    }

    .calendar-container {
        flex: 1;
        /* Jarak antara kalender dan tabel */
    }

    /* Gaya CSS untuk daftar acara */
    .event-list {
        flex: 1;
        overflow: hidden;
        /* Menyembunyikan garis vertikal yang melebihi lebar */
    }

    .event-table {
        width: 100%;
        border-collapse: collapse;
        border-left: 1px solid #ccc;
        border-right: 1px solid #ccc;
        /* Menghapus garis vertikal di antara sel-sel */
    }

    .event-table th,
    .event-table td {
        text-align: left;
        padding: 8px;
        border-bottom: 1px solid #ccc;
        /* Menyisakan garis horizontal */
    }

    .event-table th {
        background-color: #f2f2f2;
    }


    @media screen and (min-width: 600px) {

        /* Tampilan untuk perangkat dengan lebar layar minimal 600px (laptop) */
        .event-list {
            float: right;
            margin-top: 0;
            max-width: 300px;
            margin-left: 15px;
            margin-top: 0px;
            /* Lebar maksimum daftar acara */
        }

        .tanggalan {
            margin-right: 15px;
        }
    }

    @media screen and (max-width: 380px) {
        .tanggalan {
            font-size: 12px;
        }

        .tanggalan {
            flex-direction: column;
        }

        .event-list {
            order: 3;
            max-width: 100%;

            /* Mengubah urutan tampilan di bawah kalender */
        }

        .calendar-container {
            order: 2;
            /* Mengubah urutan tampilan di atas daftar acara */
            margin-bottom: 20px;
            /* Memberi jarak di antara kalender dan daftar acara */
        }

        .calendar-title {
            order: 1;
            /* Mengubah urutan tampilan judul kalender */
        }
    }

    @media screen and (max-width: 599px) {
        .tanggalan {
            flex-direction: column;
        }

        .event-list {
            margin-top: 20px;
        }

    }
</style>

<?= $this->endSection() ?>

<?= $this->section('konten') ?>

<h2 class="calendar-title">PENGUMUMAN</h2>
<div class="tanggalan">
    <div class="event-list">
        <div id="agenda">
            <!-- Daftar acara akan ditambahkan oleh JavaScript -->
        </div>
    </div>
</div>

<?= $this->endSection(); ?>


<?= $this->section('script') ?>
<script>
    const events = [{
            date: new Date(2023, 8, 17),
            title: "Upacara Bendera",
            type: "meeting"
        },
        {
            date: new Date(2023, 12, 17),
            title: "Ujian Akhir Semester",
            type: "exam"
        },
        {
            date: new Date(2023, 12, 18),
            title: "Ujian Akhir Semester",
            type: "exam"
        },
        {
            date: new Date(2023, 12, 19),
            title: "Ujian Akhir Semester",
            type: "exam"
        },
        {
            date: new Date(2023, 12, 20),
            title: "Ujian Akhir Semester",
            type: "exam"
        },
        {
            date: new Date(2023, 12, 21),
            title: "Ujian Akhir Semester",
            type: "exam"
        },
    ];

    function createCalendar(year, month) {
        displayEventList(year, month);
    }

    function getColorForEventType(type) {
        switch (type) {
            case 'meeting':
                return 'lightblue'; // Ganti dengan warna yang diinginkan
            case 'training':
                return 'lightgreen'; // Ganti dengan warna yang diinginkan
            case 'exam':
                return 'lightcoral'; // Ganti dengan warna yang diinginkan
            default:
                return 'white'; // Warna default
        }
    }

    // Tambahkan fungsi untuk mendapatkan nama bulan
    function getMonthName(month) {
        const months = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];
        return months[month];
    }

    function getMonthShortName(month) {
        const months = [
            "Jan", "Peb", "Mar", "Apr", "Mei", "Jun",
            "Jul", "Ags", "Sep", "Okt", "Nop", "Des"
        ];
        return months[month];
    }

    // Fungsi untuk menggabungkan acara berurutan dengan tipe yang sama
    function combineConsecutiveEvents(events) {
        const combinedEvents = [];

        let currentEvent = null;
        for (const event of events) {
            if (currentEvent && event.type === currentEvent.type &&
                event.date.getTime() - currentEvent.endDate.getTime() === 24 * 60 * 60 * 1000) {
                // Jika acara sekarang adalah tipe yang sama dan berurutan dengan acara sebelumnya
                currentEvent.endDate = event.date; // Perbarui tanggal berakhir dari acara sekarang
            } else {
                if (currentEvent) {
                    // Jika ada acara sekarang yang perlu ditambahkan
                    combinedEvents.push(currentEvent);
                }
                currentEvent = {
                    title: event.title,
                    type: event.type,
                    date: event.date,
                    endDate: event.date, // Inisialisasi tanggal berakhir dengan tanggal saat ini
                };
            }
        }

        if (currentEvent) {
            combinedEvents.push(currentEvent);
        }

        return combinedEvents;
    }

    // ...

    function displayEventList(year, month) {
        const agendaDiv = document.getElementById('agenda');
        agendaDiv.innerHTML = '';

        // Temukan semua acara pada bulan yang dimaksud
        const eventsInMonth = events.filter(event =>
            event.date.getFullYear() === year);

        const combinedEvents = combineConsecutiveEvents(eventsInMonth);

        combinedEvents.forEach((event, index) => {
            const row = document.createElement('tr');
            var tanggalrange = event.date.getDate() + " - " + event.endDate.getDate();
            if (event.date.getDate() == event.endDate.getDate())
                tanggalrange = event.date.getDate();
            const entryDiv = document.createElement('div');
            entryDiv.innerHTML = `
            <div>${tanggalrange} ${getMonthName(event.date.getMonth())} ${event.date.getFullYear()}</div>
            <div>${event.title}</div>
        `;
            agendaDiv.appendChild(entryDiv);
        });
    }



    document.addEventListener('DOMContentLoaded', function() {
        // Panggil fungsi createCalendar dengan tahun dan bulan tertentu
        const bulan = 9;
        const tahun = 2023;
        createCalendar(tahun, (bulan - 1)); // 2023 adalah tahun dan 8 adalah indeks bulan (0 untuk Januari, 1 untuk Februari, dll.)

        // Tampilkan judul bulan dan tahun
    });
</script>


<?= $this->endSection(); ?>