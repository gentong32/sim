<?= $this->extend('layout/layout_admin') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<style>
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

    .table-responsive {
        width: 97%;
        font-size: 14px;
        overflow: visible;
        margin: auto;
        margin-top: 5px;
        margin-bottom: 20px;
    }

    .container_dimensi {
        border: 0.5px solid #4caf50;
        border-radius: 6px;
        margin-top: 15px;
    }

    .jd_dimensi {
        background-color: rgba(50, 50, 50, 0.1);
        border-top-left-radius: 6px;
        border-top-right-radius: 6px;
        padding: 5px 5px;
    }

    .vertical-align-top {
        vertical-align: top !important;
    }

    @media screen and (max-width: 767px) {
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            font-size: 10px;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<h2 class="judul">Dimensi Penilaian Projek P5</h2>
<div><b><?= $data_projek['nama_projek'] ?></b></div>
<span><?= $data_projek['deskripsi_projek'] ?></span><br>
<span style="color: gray;"><i>[kelas <?= $data_projek['kelas'] ?> / fase <?= fase($data_projek['kelas']) ?>]</i></span>

<?php
$baris = 0;
foreach ($daf_dimensi as $dimensi) :
    $baris++; ?>
    <div class="container_dimensi">
        <div class="jd_dimensi">Dimensi <?= $baris ?>: <?= $daf_dimensi[$baris - 1]['dimensi'] ?></div>
        <div class="table-responsive">
            <table id="myTable<?= $baris ?>" class="display responsive" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Elemen</th>
                        <th>Sub Elemen</th>
                        <th>Capaian Akhir Fase</th>
                        <th>Dinilai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $baris2 = 0;
                    foreach ($daftar_elemen_d[$baris - 1] as $row) :
                        $baris2++;
                    ?>
                        <tr>
                            <td><?= $baris2 ?></td>
                            <td><?= $row['elemen'] ?></td>
                            <td><?= $row['sub_elemen'] ?></td>
                            <td><?= $row['fase_' . fase($data_projek['kelas'])] ?></td>
                            <td><input <?= ($row['id_sub_elemen_pilih'] != null) ? 'checked' : '' ?> type="checkbox" data-sub_elemen="<?= $row['id_sub_elemen'] ?>"></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

    </div>
<?php endforeach ?>
<br>
<button class="button" id="tbSimpan">Simpan</button>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        for (var i = 1; i <= 9; i++) {
            $('#myTable' + i).DataTable({
                responsive: true,
                scrollX: true,
                paging: false,
                lengthChange: false,
                searching: true,
                info: false,
                columnDefs: [{
                    width: '20px',
                    targets: 0
                }, {
                    targets: [0, 1, 2, 3, 4],
                    className: 'vertical-align-top'
                }],
            });
        }
    });

    document.getElementById('tbSimpan').addEventListener('click', function() {
        var selectedCheckboxes = document.querySelectorAll('input[type="checkbox"]:checked');
        var sub_elemenArray = [];

        selectedCheckboxes.forEach(function(checkbox) {
            var sub_elemenValue = checkbox.getAttribute('data-sub_elemen');
            sub_elemenArray.push(sub_elemenValue);
        });

        fetch('<?= base_url() ?>admin/simpan_penilaian/<?= $id_projek ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    sub_elemen: sub_elemenArray
                })
            })
            .then(response => response.json())
            .then(data => {
                window.open("<?= base_url() . 'admin/dimensi/' . $kelas ?>", "_self");
            })
            .catch(error => {
                console.error('Gagal menyimpan data:', error);
            });
    });
</script>

<?= $this->endSection() ?>