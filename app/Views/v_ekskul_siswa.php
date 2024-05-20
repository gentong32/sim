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

    table td {
        text-align: left;
        vertical-align: top;
    }

    table td:nth-child(4) {
        width: 70px;
        text-align: center;
    }

    table td:nth-child(3) {
        width: 100px;
    }

    table td:nth-child(2) {
        width: 110px;
    }

    table td:nth-child(1) {
        width: 30px;
        text-align: center;
    }

    .kontener {
        margin: auto;
        width: 100%;
        max-width: var(--lebar);
        margin-top: 20px;
    }

    h3 {
        text-align: left;
        color: black;
    }

    .tbok {
        display: inline;
        padding: 2px 2px;
        margin-top: 0px;
        font-size: 16px;
        color: #fff;
        background-color: darkolivegreen;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
        width: 60px;
    }
</style>

<link rel="stylesheet" href="<?= base_url() ?>css/s_presensi.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<?= $this->endSection() ?>


<?= $this->section('konten') ?>

<div class="kontener">
    <?php if (sizeof($daftar_ekskul) > 0) : ?>
        <div class="daftar">
            <?php
            $jenis_old = "";
            $jmlbaris = sizeof($daftar_ekskul);
            for ($a = 0; $a < $jmlbaris; $a++) {
                if ($jenis_old != $daftar_ekskul[$a]->jenis) {
                    $baris = 0;
                    $jenis_old = $daftar_ekskul[$a]->jenis;
                    echo "<h3>" . $daftar_ekskul[$a]->jenis . "</h3>"; ?>
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Ekskul</th>
                                <th>Pengampu</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php }

                    $baris++;
                    $tomboldaftar = "<button onclick='ikutekskul(" . $daftar_ekskul[$a]->id . ")' class='tbok'>Ikuti</button>";
                    $cekikut = ($daftar_ekskul[$a]->nisn == null) ? $tomboldaftar : "Aktif";
                    echo "<tr><td>" . $baris . "</td>\n";
                    echo "<td>" . $daftar_ekskul[$a]->nama_ekskul . "</td>\n";
                    echo "<td>" . $daftar_ekskul[$a]->nama . "</td>\n";
                    echo "<td>" . $cekikut . "</td></tr>\n";


                    if (($a < $jmlbaris - 1 && $jenis_old != $daftar_ekskul[$a + 1]->jenis) || $a == $jmlbaris - 1) {
                        ?>
                        </tbody>
                    </table><br>
            <?php }
                } ?>
        </div>
    <?php else :
        echo "<h2>BELUM ADA DAFTAR EKSKUL YANG TERSEDIA</h2>";
    endif;
    ?>
</div>
<?= $this->endSection(); ?>


<?= $this->section('script') ?>
<script>
    function ikutekskul(id) {
        if (confirm("Apakah kamu yakin akan mengikuti ekskul ini? Setelah memilih tidak bisa dibatalkan, kecuali lapor ke guru pengampu ekskul!")) {
            var postData = {
                idekskul: id
            };

            fetch('<?= base_url("simpan_ekskul") ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(postData)
                })
                .then(response => response.json())
                .then(data => {
                    window.location.reload();
                })
                .catch(error => console.error('Gagal menyimpan data:', error));
        } else {
            return false;
        }
    }
</script>
<?= $this->endSection(); ?>