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
        padding: 10px 10px;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        background-color: darkred;
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
<h2 class="judul">Daftar Mapel Pilihan Kelas <?= $kelas ?><?= $sub_kelas ?></h2>


<table id="myTable" class="display responsive" style="width:100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Mapel Pilihan</th>
            <th>Dinilai</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $baris = 0;
        foreach ($dafmapelpilihan as $row) :
            $baris++;
        ?>
            <tr>
                <td><?= $baris ?></td>
                <td><?= $row['nama_mapel'] ?></td>
                <td><input type="checkbox" <?= ($row['id'] != null) ? "checked" : "" ?> data-kd_mapel="<?= $row['kd_mapel'] ?>"></td>
            </tr>
        <?php
        endforeach
        ?>
    </tbody>
</table>

<br>
<button onclick="batal()" class="button2" id="tbBatal">Batal</button>
<button class="button" id="tbSimpan">Simpan</button>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            responsive: true,
            scrollX: true,
            paging: false,
            lengthChange: false,
            searching: true,
            info: false,
            columnDefs: [{
                targets: 0,
                width: '20px'
            }, {
                targets: 2,
                width: '20px'
            }, {
                targets: [0, 1, 2],
                className: 'vertical-align-top'
            }],
        });
    });

    document.getElementById('tbSimpan').addEventListener('click', function() {
        var selectedCheckboxes = document.querySelectorAll('input[type="checkbox"]:checked');
        var mapelArray = [];

        selectedCheckboxes.forEach(function(checkbox) {
            var sub_elemenValue = checkbox.getAttribute('data-kd_mapel');
            mapelArray.push(sub_elemenValue);
        });

        fetch('<?= base_url() ?>admin/simpan_mapel_pilihan_kelas', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    mapelpilihan: mapelArray,
                    kelas: '<?= $kelas ?>',
                    sub_kelas: '<?= $sub_kelas ?>',
                })
            })
            .then(response => response.json())
            .then(data => {
                // console.log(data);
                window.open("<?= base_url() . 'admin/mapel' ?>", "_self");
            })
            .catch(error => {
                console.error('Gagal menyimpan data:', error);
            });
    });

    function batal() {
        window.open("<?= base_url() . 'admin/mapel' ?>", "_self");
    }
</script>

<?= $this->endSection() ?>