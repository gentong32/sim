<?= $this->extend('layout/layout_kelas_off') ?>

<?= $this->section('style') ?>
<style>
    :root {
        --ukf: 12px;
    }
</style>
<link rel="stylesheet" href="<?= base_url() ?>css/s_tugas.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<?= $this->endSection() ?>

<?= $this->section('konten') ?>

<div class="daftar">
    <table id="data-table" class="display nowrap">
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Hasil Tugas</th>
                <th>Nilai</th>
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
            ['1', '10010329', 'Jhon Doe', '<span style="color:darkgreen; font-weight:bold">Sudah Mengumpulkan</span>', '<button>Lihat</button>', '100'],
            ['2', '10023232', 'Jane Tarzan', '<span style="color:darkgreen; font-weight:bold">Sudah Mengumpulkan</span>', '<button>Lihat</button>', '95'],
            ['3', '10023236', 'Doraemon', '<span style="color:darkgreen; font-weight:bold">Sudah Mengumpulkan</span>', '<button>Lihat</button>', '100'],
            ['4', '10023238', 'Ksatria Baja Hitam', '<span style="color:darkred; font-weight:bold">Belum Mengumpulkan</span>', '', ''],
            ['5', '10023239', 'Batman', '<span style="color:darkgreen; font-weight:bold">Sudah Mengumpulkan</span>', '<button>Lihat</button>', '-'],
            ['6', '10023252', 'Spiderman', '<span style="color:darkred; font-weight:bold">Belum Mengumpulkan</span>', '', '', ],
        ];

        var table = $('#data-table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
            },
            "aLengthMenu": [
                [15, -1],
                [15, "All"]
            ],
            data: dataSet,
            responsive: true,
            columnDefs: [{
                    responsivePriority: 1,
                    targets: 2
                },
                {
                    responsivePriority: 3,
                    targets: 3
                },
                {
                    responsivePriority: 2,
                    targets: -2
                }
            ],
        });
    });
</script>


<?= $this->endSection(); ?>