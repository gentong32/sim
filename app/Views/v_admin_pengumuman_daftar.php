<?= $this->extend('layout/layout_admin') ?>

<?= $this->section('style') ?>
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->
<style>
    .judul {
        font-size: 24px;
        margin: 20px 0;
    }

    .kelas {
        margin-bottom: 40px;
        font-size: 14px;
        border: #288AA4 solid 1px;
        border-radius: 20px;
        padding: 15px;
    }

    .sub-judul {
        font-size: 16px;
        font-weight: bold;
        margin: 10px 0;
        margin-bottom: 0px;
    }

    .cumum {
        width: 100%;
        min-width: 600px;
        border: 0.5px solid gray;
        border-collapse: collapse;
        text-align: left;
        margin-bottom: 20px;
    }

    .cumum td {
        padding: 6px 6px;
        border: 1px solid #ccc;
        vertical-align: top;
        /* border-bottom: 1px solid #ccc; */
    }

    .cumum th {
        text-align: center;
        padding: 8px 6px;
        border: 1px solid #ccc;
        /* border-bottom: 1px solid #ccc; */
    }

    .cumum th:nth-child(2) {
        width: 100px;
    }

    .tbtambah {
        display: inline-block;
        padding: 5px 5px;
        margin-top: 10px;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        background-color: #26BEAE;
        border: none;
        border-radius: 2px;
        cursor: pointer;
        height: 30px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .edit,
    .ok {
        display: inline-block;
        padding: 0px 0px;
        margin-top: 0px;
        margin-bottom: 5px;
        font-size: 14px;
        color: #fff;
        background-color: #41B55C;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
        width: 50px;
    }

    .delete,
    .hapus {
        display: inline-block;
        padding: 0px 0px;
        margin-top: 0px;
        margin-bottom: 5px;
        font-size: 14px;
        color: #fff;
        background-color: #A43728;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
        width: 50px;
    }

    .tbdimensi {
        display: inline-block;
        padding: 0px 0px;
        margin-top: 5px;
        margin-bottom: 0px;
        font-size: 14px;
        color: #fff;
        background-color: #D6a240;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
        width: 90px;
    }

    .tbdimensi[disabled],
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

    .table-responsive {
        overflow-x: auto;
    }

    .table-container {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .copsi {
        width: 200px;
        font-size: 16px;
    }

    .cprojek {
        width: 95%;
        height: 100px;
    }

    .cdeskripsi {
        width: 96%;
        height: 100px;
    }

    #overlayprojek {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9998;
        display: none;
    }

    #formContainer {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
        max-width: 600px;
        width: 95%;
        z-index: 9999;
        display: none;
    }

    label {
        display: block;
        margin-bottom: 0px;
        margin-top: 5px;
        font-size: 14px;
    }



    @media (max-width: 767px) {
        .tbtambah {
            margin-bottom: 10px;
            /* Menambahkan margin bawah pada tombol "Tambah" */
        }

        .table-container {
            margin-top: 20px;
            /* Menambahkan jarak antara tombol dan tabel pada perangkat seluler */
        }

        .copsi {
            width: 180px;
            font-size: 12px;
        }

        .copsie {
            width: 100%;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<div>
    <h2>Daftar Pengumuman</h2>

    <div class="kelas">
        <div class="">
            <button class="btn btn-primary tbtambah" onclick="tambahPengumuman()">Tambah Pengumuman</button>
            <button class="btn btn-primary tbtambah" onclick="lihatPengumuman()">Lihat Pengumuman</button>
        </div>

        <div class="table-container"> <!-- Menambahkan margin top 4 -->
            <div class="table-responsive">
                <table class="table cumum" id="iumum">
                    <tr>
                        <th style="width: 30px;">No</th>
                        <th style="width: 250px;">Judul</th>
                        <th style="width: 100px;">Tanggal Mulai</th>
                        <th style="width: 100px;">Tanggal Selesai</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                    <?php
                    $adapilihan = 0;
                    $daftar_pilihan = [];
                    $nomor = 0;
                    foreach ($daftar_pengumuman as $datarow) {
                        $nomor++;
                        echo "<tr>";
                        echo "<td>" . $nomor . "</td>";
                        echo "<td>" . $datarow['judul'] . "</td>";
                        echo "<td>" . ubahtanggaldb($datarow['tanggal_mulai']) . "</td>";
                        echo "<td>" . ubahtanggaldb($datarow['tanggal_selesai']) . "</td>";
                        echo "<td><button class='edit' onclick='editPengumuman(`" . $datarow['id'] . "`)'>Edit</button> <button class='delete' onclick = 'hapusPengumuman(this,`" . $datarow['id'] . "`)'>Hapus</button></td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>


</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
    function tambahPengumuman() {
        window.open("<?= base_url() ?>pengumuman/baru", "_self");
    }

    function lihatPengumuman() {
        window.open("<?= base_url() ?>pengumuman?i=1", "_self");
    }


    function batalInput() {

    }

    function editPengumuman(id) {
        window.open("<?= base_url() ?>pengumuman/edit/" + id, "_self");
    }

    function hapusPengumuman(baris, id) {
        if (confirm("Yakin mau menghapus mapel ini")) {
            var row = baris.parentElement.parentElement;
            var url = '<?= base_url() . "pengumuman/hapuspengumuman" ?>';
            var data = {
                id_projek: id,
            };

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data),
                })
                .then(response => response.json())
                .then(data => {
                    // row.remove();
                    window.location.reload();
                })
                .then()
                .catch(error => console.error('Error:', error));

        }
    }
</script>
<?= $this->endSection() ?>