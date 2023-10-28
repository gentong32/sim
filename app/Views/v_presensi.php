<?= $this->extend('layout/layout_default') ?>

<?= $this->section('style') ?>
<style>
    :root {
        --ukf: 12px;
    }
</style>
<link rel="stylesheet" href="css/s_presensi.css">
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
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>No. Telp</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data akan diisi menggunakan JavaScript -->
        </tbody>
    </table>

    <div id="keterangan">
        <label>Keterangan:</label><br>
        <label>H: Hadir</label><br>
        <label>I: Ijin</label><br>
        <label>S: Sakit</label><br>
        <label>A: Tanpa Keterangan</label>
    </div>

</div>

<?= $this->endSection(); ?>


<?= $this->section('script') ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            ['1', '10010329', 'Jhon Doe', 'L', '123 Main St', '555-1234', 'H'],
            ['2', '10023232', 'Jane Tarzan', 'P', '456 Oak St', '554-5678', 'H'],
            ['3', '10023236', 'Doraemon', 'L', '789 Jati St', '552-5690', 'S'],
            ['4', '10023238', 'Ksatria Baja Hitam', 'L', '126 Pinus St', '511-5600', 'A'],
            ['5', '10023239', 'Batman', 'L', '44 Rotan St', '215-5612', 'I'],
            ['6', '10023252', 'Spiderman', 'L', '85 Bambu St', '585-5698', 'H'],
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
                    targets: 0
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
            columns: [{
                    title: 'No'
                }, {
                    title: 'NIS'
                },
                {
                    title: 'Nama',
                },
                {
                    title: 'Jenis Kelamin'
                },
                {
                    title: 'Alamat'
                },
                {
                    title: 'No. Telp'
                },
                {
                    title: 'Keterangan',
                    render: function(data, type, row) {
                        return '<input type="radio" name="keterangan_' + row[0] + '" value="H" ' + (data === 'H' ? 'checked' : '') + '>H ' +
                            '<input type="radio" name="keterangan_' + row[0] + '" value="I" ' + (data === 'I' ? 'checked' : '') + '>I ' +
                            '<input type="radio" name="keterangan_' + row[0] + '" value="S" ' + (data === 'S' ? 'checked' : '') + '>S ' +
                            '<input type="radio" name="keterangan_' + row[0] + '" value="A" ' + (data === 'A' ? 'checked' : '') + '>A';
                    }
                }
            ]
        });
    });
</script>


<?= $this->endSection(); ?>