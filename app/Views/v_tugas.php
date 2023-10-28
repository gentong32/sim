<?= $this->extend('layout/layout_default') ?>

<?= $this->section('style') ?>
<style>
    :root {
        --ukf: 12px;
    }
</style>
<link rel="stylesheet" href="css/s_tugas.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<?= $this->endSection() ?>

<?= $this->section('konten') ?>

<div class="daftar">
    <table id="data-table" class="display">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Tugas / Kegiatan</th>
                <th>Tanggal Pengumpulan</th>
                <th>Jenis Pengumpulan</th>
                <th>Jenis Tugas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data akan diisi menggunakan JavaScript -->
        </tbody>
    </table>
</div>

<?= $this->endSection(); ?>


<?= $this->section('script') ?>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script>
    var defaultKelas = '10_1';
    var options = document.querySelector('.options');
    var selectedOption = document.querySelector('.selected-option span');

    function toggleOptions() {
        options.style.display = (options.style.display === 'block') ? 'none' : 'block';
    }

    function selectOption(value) {
        selectedOption.textContent = value;
        selectedOption.dataContent = event.target.dataset.value;
        toggleOptions();
    }

    function appendKelasToLink(menu) {
        var selectedKelas = document.querySelector('.selected-option span').dataContent || defaultKelas;
        var link = document.querySelector('.menu-item a[href="/' + menu + '"]');

        if (selectedKelas) {
            link.href += '?kelas=' + selectedKelas;
        }
    }

    $(document).ready(function() {
        var dataSet = [
            ['11 Sept 2023', 'Membuat Karangan Deskripsi', '18 Sept 2023', 'Online', 'Individu', '<button onclick="window.open(`/tugas/hasil1`,`_self`)">Lihat Hasil</button>'],
            ['13 Sept 2023', 'Praktikum Biologi Percobaan Fotosintesis', '15 Sept 2023', 'Tatap Muka', 'Kelompok', '<button onclick="window.open(`/tugas/hasil2`,`_self`)">Lihat Hasil</button>'],
        ];

        var table = $('#data-table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
            },
            data: dataSet,
            responsive: true,
            columnDefs: [{
                    responsivePriority: 1,
                    targets: 1
                },
                {
                    responsivePriority: 3,
                    targets: 2
                },
                {
                    responsivePriority: 2,
                    targets: -1
                }
            ],
        });
    });
</script>


<?= $this->endSection(); ?>