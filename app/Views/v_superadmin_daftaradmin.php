<?= $this->extend('layout/layout_superadmin') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<style>
    .judul {
        font-size: 24px;
        margin: 20px 0;
    }

    .kelas {
        margin-bottom: 40px;
        font-size: 14px;
        border: #288AA4 solid 1px;
        border-radius: 10px;
        padding: 15px;
        width: 95%;
    }

    .sub-judul {
        font-size: 16px;
        font-weight: bold;
        margin: 10px 0;
        margin-bottom: 0px;
    }

    .dafadmin {
        width: 100%;
        border: 0.5px solid gray;
        text-align: left !important;
        margin-bottom: 20px;
    }

    div.dataTables_wrapper div.dataTables_filter {
        margin-bottom: 10px;
        /* Sesuaikan dengan jarak yang diinginkan */
    }

    tr.child td {
        text-align: left !important;
        /* Jarak dari kiri */
    }

    .dafadmin td {
        padding: 3px 3px;
        border: 1px solid #ccc;
        /* border-bottom: 1px solid #ccc; */
    }

    .dafadmin th {
        text-align: center;
        padding: 8px 6px;
        border: 1px solid #ccc;
        /* border-bottom: 1px solid #ccc; */
    }

    .dafadmin th:nth-child(2) {
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
    <h2>Daftar Admin</h2>

    <div class="kelas">
        <table class="dafadmin" id="idafadmin">
            <thead>
                <tr>
                    <th style="width: 30px;">No</th>
                    <th>Nama Admin</th>
                    <th>Jenjang</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th class="none">Nama Sekolah</th>
                    <th class="none">Alamat Rumah</th>
                    <th class="none">HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

        <button class="tbtambah" onclick="tambahdafadmin()">Tambah Admin</button>
    </div>


</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script>
    function tambahdafadmin() {
        window.open('<?= base_url() . "superadmin/tambah_admin" ?>', '_self');
    }

    function editadmin(idadmin) {
        window.open('<?= base_url() . "superadmin/edit_admin/" ?>' + idadmin, '_self');
    }

    function resetpass(idadmin) {
        if (confirm('Ini mau di reset passwordnya menjadi default admin123?'))
            window.open('<?= base_url() . "superadmin/reset_admin_pass/" ?>' + idadmin, '_self');
    }

    function hapusadmin(button, id_admin) {
        if (confirm("Yakin mau menghapus rombel ini?")) {
            var row = button.parentElement.parentElement;
            var url = '<?= base_url() . "superadmin/hapus_admin" ?>';
            var data = {
                id_admin: id_admin,
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
                    console.log('Response:', data);
                    row.remove();
                })
                .then()
                .catch(error => console.error('Error:', error));

        }
    }

    var dataadmin = <?php echo json_encode($daftar_admin); ?>;
    var table = $('#idafadmin').DataTable({
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

    dataadmin.forEach(function(admin, index) {
        if (admin.status_sekolah == 0 || admin.status_sekolah == null) {
            nama_status = '<span style="color:red">Non Aktif</span>'
        } else if (admin.status_sekolah == 1) {
            nama_status = '<span style="color:black">Trial</span>';
        } else if (admin.status_sekolah == 2) {
            nama_status = '<span style="color:green"><b>Aktif</b></span>';
        }
        table.row.add([
            (index + 1),
            admin.nama,
            admin.jenjang,
            admin.email,
            nama_status,
            admin.nama_sekolah,
            admin.alamat,
            admin.telp,
            '<button class="editButton" onclick="editadmin(`' + admin.id_user + '`)">Edit</button> <button class="deleteButton" data-id="' + index + '" onclick="hapusadmin(this, `' + admin.id_user + '`)">Hapus</button> <button class="resetButton" onclick="resetpass(`' + admin.id_user + '`)">Reset</button>'
        ]).draw(false);
    });
</script>
<?= $this->endSection() ?>