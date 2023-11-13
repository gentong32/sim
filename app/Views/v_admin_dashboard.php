<?= $this->extend('layout/layout_admin') ?>

<?= $this->section('style') ?>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
        margin: left;
        background-color: #f9f9f9;
    }

    th,
    td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        vertical-align: top;
    }

    tr>td:first-child {
        width: 70px;
    }

    tr>td:nth-child(2) {
        width: 5px;
    }

    .center-text {
        text-align: center;
    }

    .cardcontainer {
        display: flex;
        justify-content: left;
        align-items: flex-start;
        margin: 0;
    }

    .card {
        text-align: center;
        padding: 20px;
        border-radius: 10px;
        width: 120px;
        margin: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card h4 {
        padding: 0;
        margin: 0;
    }

    .card p {
        margin: 0;
        margin-top: 5px;
        font-size: 20px;
    }

    .tbupdate {
        display: inline-block;
        padding: 5px 5px;
        margin-top: 0px;
        margin-right: 5px;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        background-color: #F7A45B;
        border: none;
        border-radius: 2px;
        cursor: pointer;
        height: 30px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .guru {
        /* background-color: #3498db; */
        color: #222;
        border: 0.5px solid #000;
    }

    .siswa {
        /* background-color: #e74c3c; */
        color: #222;
        border: 0.5px solid #000;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<h2>Informasi Sekolah</h2>
<h2><?= $sekolah['nama'] ?></h2>
<table>
    <tr>
        <td>NPSN</td>
        <td>:</td>
        <td><?= $sekolah['npsn'] ?></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td><?= ($sekolah['npsn'] != "") ? $sekolah['alamat'] . "<br>" . $sekolah['kelurahan'] . "," . $sekolah['kecamatan'] . "," . $sekolah['kota'] . "<br>" . $sekolah['propinsi'] : "" ?></td>
    </tr>
    <tr>
        <td>Email</td>
        <td>:</td>
        <td><?= $sekolah['email'] ?></td>
    </tr>
    <tr>
        <td>Telp</td>
        <td>:</td>
        <td><?= $sekolah['telp'] ?></td>
    </tr>
</table>
<h3>Tahun Ajaran <?= $tahun_ajaran ?></h3>
<button class="tbupdate" onclick="edit_sekolah()">Update Data Sekolah</button>
<div class="cardcontainer">
    <div class="card guru">
        <h4>Jumlah Guru</h4>
        <p><?= $info['jumlah_guru'] ?></p>
    </div>
    <div class="card siswa">
        <h4>Jumlah Siswa</h4>
        <p><?= $info['jumlah_siswa'] ?></p>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    function edit_sekolah() {
        window.open("<?= base_url('admin/edit_sekolah') ?>", "_self");
    }
</script>
<?= $this->endSection() ?>