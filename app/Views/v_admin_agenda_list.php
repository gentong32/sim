<?php
$nama_bulan_panjang = ["Januari", "Pebruari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember"];
?>

<?= $this->extend('layout/layout_admin') ?>

<?= $this->section('style') ?>
<style>
    .judul {
        font-size: 24px;
        margin: 20px 0;
    }

    .jenis {
        margin-bottom: 40px;
        font-size: 14px;
        border: #288AA4 solid 1px;
        border-radius: 10px;
        padding: 15px;
    }

    .sub-judul {
        font-size: 16px;
        font-weight: bold;
        margin: 10px 0;
        margin-bottom: 0px;
    }

    .agenda {
        width: 100%;
        max-width: 600px;
        border: 0.5px solid gray;
        border-collapse: collapse;
        text-align: left;
        margin-bottom: 20px;
    }

    .agenda td {
        padding: 6px 6px;
        border: 1px solid #ccc;
        vertical-align: top !important;
        /* border-bottom: 1px solid #ccc; */
    }

    .agenda th {
        text-align: center;
        padding: 8px 6px;
        border: 1px solid #ccc;
        /* border-bottom: 1px solid #ccc; */
    }

    .tbkembali {
        display: inline-block;
        padding: 0px 0px;
        margin-top: 5px;
        margin-bottom: 0px;
        font-size: 14px;
        color: #fff;
        background-color: #41B55C;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
        width: 100px;
    }

    .edit,
    .ok {
        display: inline-block;
        padding: 5px 5px;
        margin-top: 5px;
        font-size: 14px;
        color: #fff;
        background-color: #41B55C;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .delete,
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

    .edit[disabled],
    .delete[disabled] {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .tbpilihan {
        display: inline-block;
        padding: 6px 6px;
        margin-top: 10px;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        background-color: #288AA4;
        border: none;
        border-radius: 2px;
        cursor: pointer;
        height: 35px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .aksi {
        margin-right: 5px;
    }

    button {
        height: 25px;
        margin-bottom: 2px;
    }

    .infosub {
        color: red;
        font-style: italic;
        font-size: 14px;
    }

    .uppercase-input {
        text-transform: uppercase;
    }

    .info {
        color: green;
        font-style: italic;
        font-size: 12px;
        max-width: 600px;
    }

    .opsi2 {
        width: 200px;
    }

    table {
        font-size: 14px;
    }

    table th {
        text-align: center;
    }

    table td:nth-child(1) {
        text-align: right;
        padding-right: 10px;
    }

    .select2-dropdown .select2-results__option {
        font-size: 14px;
    }

    @media screen and (max-width: 768px) {

        .edit,
        .ok,
        .delete,
        .batal {
            font-size: 12px;
        }

        .content {
            padding: 5px;
        }

        table {
            font-size: 12px;
        }

        .opsi2 {
            width: 100px;
        }

        .select2-dropdown .select2-results__option {
            font-size: 12px;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<div>
    <h2>Agenda Kalender Pendidikan</h2>

    <div class="jenis">
        <?php if ($jmldatakalender == 0) { ?>
            Belum tersedia agenda dan kalender pendidikan saat ini.<br><br>
        <?php } else { ?>

            <table class="agenda" id="iagenda">
                <tr>
                    <th style="width: 10px !important;">No</th>
                    <th style="width: 50px;">Tanggal</th>
                    <th style="width: 60%">Agenda</th>
                </tr>
                <?php
                $baris = 1;
                foreach ($datakalender as $datarow) {
                    $tgl = intval(substr($datarow['date'], 8, 2));
                    $bln = $nama_bulan_panjang[intval(substr($datarow['date'], 5, 2)) - 1];
                    $thn = substr($datarow['date'], 0, 4);
                    $tanggal = $tgl . " " . $bln . " " . $thn;
                    echo "<tr><td>" . $baris++ . "</td>";
                    echo "<td>" . $tanggal . "</td>";
                    echo "<td>" . $datarow['title'] . "</td></tr>";
                }
                ?>
            </table>

        <?php } ?>


        <button class="tbkembali" onclick="kembali()">Kembali</button>
    </div>


</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    function kembali() {
        window.open('<?= base_url("admin/agenda") ?>', '_self');
    }
</script>
<?= $this->endSection() ?>