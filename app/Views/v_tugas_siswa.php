<?= $this->extend('layout/layout_siswa') ?>

<?= $this->section('style') ?>
<style>
    :root {
        --ukf: 12px;
        --lebar: 850px;
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

    table td:nth-child(4) {
        width: 350px;

    }

    table td:nth-child(3) {
        width: 320px;
    }

    table td:nth-child(2) {
        width: 110px;
    }

    .kontener {
        margin: auto;
        width: 100%;
        max-width: var(--lebar);
        margin-top: 20px;
    }
</style>

<link rel="stylesheet" href="<?= base_url() ?>css/s_presensi.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<?= $this->endSection() ?>


<?= $this->section('konten') ?>

<div class="kontener">
    <?php if (sizeof($daftar_tugas) > 0) : ?>
        <div class="daftar">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Mata Pelajaran</th>
                        <th>Tugas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $baris = 0;
                    foreach ($daftar_tugas as $row) {
                        $baris++;
                        echo "<tr><td>" . $baris . "</td>\n";
                        echo "<td>" . ubahtanggaldb($row['tanggal_tugas']) . "</td>\n";
                        echo "<td>" . $row['nama_mapel'] . "</td>\n";
                        echo "<td>" . $row['nama_tugas'] . "</td></tr>\n";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php else :
        echo "<h2>BELUM ADA TUGAS BARU</h2>";
    endif;
    ?>
</div>
<?= $this->endSection(); ?>