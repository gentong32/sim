<?= $this->extend('layout/layout_siswa') ?>

<?= $this->section('style') ?>
<style>
    :root {
        --ukf: 12px;
        --lebar: 600px;
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

    table td:nth-child(2) {
        width: 50%;
        text-align: left;
    }

    table td:nth-child(4) {
        width: 80px;
    }

    .kontener {
        margin: auto;
        width: 100%;
        max-width: var(--lebar);
    }
</style>

<link rel="stylesheet" href="<?= base_url() ?>css/s_presensi.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<?= $this->endSection() ?>


<?= $this->section('konten') ?>

<div class="kontener">
    <div class="pilihan">
        MATA PELAJARAN:<br>
        <select class="pilkelas" name="pilmapel" id="pilmapel">
            <?php
            foreach ($mapel_sekolah as $row) :
                $selected = "";
                if ($mapel == $row['id']) {
                    $selected = "selected";
                }
            ?>
                <option <?= $selected ?> value="<?= $row['id'] ?>"><?= $row['nama_mapel'] ?></option>
            <?php endforeach ?>
        </select>
        <br>
        SEMESTER:<br>
        <select class="pilkelas" name="pilsemester" id="pilsemester">
            <option <?= ($semester == "midganjil") ? "selected" : "" ?> value="midganjil">Mid Semester Ganjil</option>
            <option <?= ($semester == "raporganjil") ? "selected" : "" ?> value="raporganjil">Akhir Semester Ganjil</option>
            <option <?= ($semester == "midgenap") ? "selected" : "" ?> value="midgenap">Mid Semester Genap</option>
            <option <?= ($semester == "raporgenap") ? "selected" : "" ?> value="raporgenap">Akhir Semester Genap</option>
        </select>
    </div>

    <div class="daftar">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tugas</th>
                    <th>Tanggal</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $baris = 0;
                foreach ($rekap_nilai as $row) {
                    $baris++;
                    echo "<tr><td>" . $baris . "</td>\n";
                    echo "<td>" . $row['nama_tugas'] . "</td>\n";
                    echo "<td>" . ubahtanggaldb($row['tanggal_tugas']) . "</td>\n";
                    echo "<td>" . $row['nilai'] . "</td></tr>\n";
                }
                ?>
            </tbody>
        </table>

    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script') ?>
<script>
    document.getElementById('pilsemester').addEventListener('change', function() {
        updateURL();
    });
    document.getElementById('pilmapel').addEventListener('change', function() {
        updateURL();
    });

    function updateURL() {
        mapel = document.getElementById('pilmapel').value;
        semester = document.getElementById('pilsemester').value;
        window.open("<?= base_url() ?>nilai/saya?mapel=" + mapel + "&semester=" + semester, "_self");
    }
</script>

<?= $this->endSection(); ?>