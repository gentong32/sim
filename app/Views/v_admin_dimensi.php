<?= $this->extend('layout/layout_admin') ?>

<?= $this->section('style') ?>
<style>
    .cprojek ol {
        border: 0.5px solid green;
        background-color: gainsboro;
        padding: 7px 25px;
        margin-bottom: 8px;
    }

    .cdimensi {
        margin-top: 5px;
        border-top: 1px solid gray;
        border-bottom: 1px solid gray;
        padding: 3px;
        padding-left: 20px;
    }

    .celemen ul {
        padding: 0;
        margin: 0;
        padding-left: 35px;
    }

    .celemen li {
        margin-top: 0px;

        padding-top: 5px;
        line-height: 20px;
    }

    select {
        margin-bottom: 5px;
        font-size: 16px;
        padding: 6px;
        border: 1px solid #ccc;
        border-radius: 4px;
        /* width: 100%; */
        box-sizing: border-box;
    }

    .button {
        display: inline-block;
        padding: 10px 10px;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        background-color: #4caf50;
        /* Warna Hijau */
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .button2 {
        display: inline-block;
        padding: 8px 10px;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        background-color: #4caf50;
        /* Warna Hijau */
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<h2 class="judul">Dimensi Penilaian Projek P5</h2>
<div class="konten">
    <label for="dimensi"><b>KELAS:</b></label>
    <select name="kelas" id="kelas">
        <?php
        foreach ($daftar_kelas as $row) {
            $selected = "";
            if ($row == $kelas)
                $selected = "selected";
            echo "<option " . $selected . " value='" . $row . "'>" . $row . "</option>";
        }
        ?>
    </select> <button class="button" id="tb_terapkan" style="display:none" onclick="terapkan()">Terapkan</button>
</div>
<?php
$baris = 0;
$prev = ['', '', '']; // Penyimpanan nilai sebelumnya
foreach ($dimensi_projek as $row) {

    if ($row['nama_projek'] != $prev[0]) {
        $baris++;
        $prev[0] = $row['nama_projek'];
        echo "<div class='cprojek'>
                <ol start=" . $baris . ">
                    <li>" . $row['nama_projek'] . " <button class='button2' id='tb_terapkan' onclick='terapkan_penilaian(`" . $row['id_projek'] . "`)'>Dimensi Penilaian</button></li>
                </ol>
              </div>";
    }
    if ($row['dimensi'] != $prev[1]) {
        $prev[1] = $row['dimensi'];
        if ($row['dimensi'] != null)
            echo "<div class='cdimensi'>" . $row['dimensi'] . "</div>";
    }
    if ($row['sub_elemen'] != null)
        echo "<div class='celemen'>
            <ul>
                <li><span>" . $row['sub_elemen'] . "</span><br>
                    " . $row['fase_' . $fase] . "
                </li>
            </ul>
          </div>";
}

if ($baris == 0)
    echo "<br><br><span style='color: red;'><i><b>Silakan tambahkan projek untuk kelas ini terlebih dahulu</b></i></span>"
?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    var selectedKelas;
    document.getElementById('kelas').addEventListener('change', function() {
        selectedKelas = this.value;
        document.getElementById('tb_terapkan').style.display = "inline";
    });

    function terapkan() {
        window.open("<?= base_url() . 'admin/dimensi/' ?>" + selectedKelas, "_self");
    }

    function terapkan_penilaian(id_projek) {
        window.open("<?= base_url() . 'admin/dimensi_penilaian/' ?>" + id_projek, "_self");
    }
</script>

<?= $this->endSection() ?>