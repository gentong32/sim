<?= $this->extend('layout/layout_default') ?>

<?= $this->section('style') ?>
<style>
    :root {
        --ukf: 12px;
    }


    table td:nth-child(3) {
        width: 50%;
    }

    .tbok {
        display: inline;
        padding: 5px 5px;
        margin-top: 10px;
        font-size: 14px;
        color: #fff;
        background-color: darkolivegreen;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
        width: 120px;
    }

    .ok {
        display: inline-block;
        padding: 5px 5px;
        margin-top: 5px;
        font-size: 14px;
        color: #fff;
        background-color: green;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .batal {
        display: inline-block;
        padding: 5px 5px;
        margin-top: 5px;
        font-size: 14px;
        color: #fff;
        background-color: #A43728;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .tgpresensi {
        font-size: 16px;
        margin-bottom: 10px;
    }

    @media screen and (min-width: 600px) {}

    @media screen and (max-width: 380px) {}

    @media screen and (max-width: 599px) {}
</style>
<link rel="stylesheet" href="<?= base_url() ?>css/s_presensi.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<div class='tgpresensi'><b>Rekap Absensi Semester <?= $semester ?></b><br>
    <small> per <?= tanggal_sekarang()['panjang'] ?></small><br>
    <button class="ok" onclick="getsemester(1)">Semester 1</button>
    <button class="ok" onclick="getsemester(2)">Semester 2</button>
</div>

<div class="daftar">
    <table id="datapresensi" class="display wrap">
        <thead>
            <tr>
                <th>No.</th>
                <th class='none'>NIS</th>
                <th>Nama</th>
                <th>I</th>
                <th>S</th>
                <th>A</th>
                <th>Detil</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data -->
        </tbody>
    </table>


    <div class="bawah">
        <div id="keterangan" style="margin-left: 10px;">
            <label style="margin-left: -7px !important;">Keterangan:</label><br>
            <label>I: Total Ijin</label><br>
            <label>S: Total Sakit</label><br>
            <label>A: Total Tanpa Keterangan</label>
            <br>
            <!-- <i> *) Jika semua hadir tidak perlu dilakukan penyimpanan</i> -->
        </div>
        <div id="tb_update"><button onclick="kembali()" class="tbok">Kembali</button></div>
    </div>

</div>

<?= $this->endSection(); ?>


<?= $this->section('script') ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script>
    loaddata();

    function loaddata() {
        var rekappresensi = <?php echo json_encode($rekappresensi); ?>;
        var table = $('#datapresensi').DataTable({
            language: {
                url: '/js/id.json',
            },
            "aLengthMenu": [
                [15, -1],
                [15, "All"]
            ],
            responsive: true,
            columnDefs: [{
                    responsivePriority: 1,
                    targets: 0
                },
                {
                    responsivePriority: 3,
                    targets: -1
                },
                {
                    responsivePriority: 2,
                    targets: 2
                }
            ],
        });

        rekappresensi.forEach(function(data, index) {
            table.row.add([
                (index + 1),
                data.nis,
                data.nama,
                data.jml_ijin,
                data.jml_sakit,
                data.jml_alpha, "<button onclick='detilabsensi(" + data.nis +
                ")'>Lihat</button>"
            ]).draw(false);
        });
    }

    function kembali() {
        window.open("<?= base_url('presensi/?kelas=') . $kelaspilihan; ?>", "_self");
    }

    function detilabsensi(nis) {
        window.open("<?= base_url('absensi/siswa?kelas=') . $kelaspilihan; ?>" + "&nis=" + nis, "_self ");
    }

    function getsemester(smst) {
        if (smst == 2)
            window.open("<?= base_url('presensi_rekap/?kelas=') . $kelaspilihan; ?>&semester=2", "_self")
        else
            window.open("<?= base_url('presensi_rekap/?kelas=') . $kelaspilihan; ?>&semester=1", "_self");
    }
</script>

<?= $this->endSection(); ?>