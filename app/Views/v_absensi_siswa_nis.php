<?= $this->extend('layout/layout_default') ?>

<?= $this->section('style') ?>
<style>
    :root {
        --ukf: 12px;
        --lebar: 450px;
    }

    .pilihan {
        font-weight: bold;
        line-height: 25px;
        text-align: left;
        margin: auto;
        margin-bottom: 20px;
        width: 100%;
        max-width: var(--lebar);
    }

    .daftar {
        margin-top: 0px !important;
        padding: 0px !important;
        border: none !important;
        width: 100% !important;
        max-width: var(--lebar) !important;
    }

    .daftar table {
        border-collapse: collapse;
        width: 100%;
    }

    .daftar tr td {
        border: 1px solid black;
        padding: 5px;
    }

    .daftar tr th {
        border: 1px solid black;
        padding: 5px;
    }

    table td {
        text-align: left;
        vertical-align: top;
    }

    table td:nth-child(1) {
        width: 40px;
        text-align: center;
    }

    table td:nth-child(2) {
        width: 110px;
    }

    table td:nth-child(3) {
        width: 150px;
    }


    .kontener {
        margin: auto;
        width: 100%;
        max-width: var(--lebar);
        margin-top: 20px;
    }

    .pilihan h2 {
        text-align: center;
        border: 1px solid black;
        padding: 10px;
    }
</style>

<link rel="stylesheet" href="<?= base_url() ?>css/s_presensi.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<?= $this->endSection() ?>


<?= $this->section('konten') ?>

<?php
$txtstatus = [
    'I' => 'Ijin',
    'S' => 'Sakit',
    'A' => 'Tanpa Keterangan'
];
?>

<div class="kontener">
    <div class="pilihan">
        SEMESTER:<br>
        <select class="pilkelas" name="pilsemester" id="pilsemester">
            <option <?= ($semester == "raporganjil") ? "selected" : "" ?> value="raporganjil">Semester Ganjil</option>
            <option <?= ($semester == "raporgenap") ? "selected" : "" ?> value="raporgenap">Semester Genap</option>
        </select>
    </div>
    <?php if (sizeof($daftar_absensi) > 0) : ?>
        <div class="daftar">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $baris = 0;
                    foreach ($daftar_absensi as $row) {
                        $baris++;
                        echo "<tr><td>" . $baris . "</td>\n";
                        echo "<td>" . ubahtanggaldb($row['tanggal']) . "</td>\n";
                        echo "<td>" . $txtstatus[$row['status']] . "</td></tr>\n";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php else :
        echo "<div class='pilihan'><h2>TIDAK DITEMUKAN DATA KETIDAKHADIRAN<br>(SELALU HADIR DI KELAS)</h2></div>";
    endif;
    ?>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script') ?>
<script>
    document.getElementById('pilsemester').addEventListener('change', function() {
        updateURL();
    });

    function updateURL() {
        semester = document.getElementById('pilsemester').value;
        window.open("<?= base_url() . 'absensi/siswa?kelas=' . $kelasterpilih . '&nis=' . $nisterpilih ?>&semester=" + semester, "_self");
    }
</script>

<?= $this->endSection(); ?>