<?= $this->extend('layout/layout_superadmin') ?>

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
        width: 200px;
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

    .admin {
        background-color: orange;
        color: #222;
        border: 0.5px solid #000;
    }

    .uang {
        background-color: greenyellow;
        color: #222;
        border: 0.5px solid #000;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<h2>Informasi Umum</h2>
<h3><?= $tanggal ?></h3>
<div class="cardcontainer">
    <div class="card admin">
        <h4>Jumlah Admin</h4>
        <p><?= $jumlah_admin ?></p>
    </div>
    <div class="card uang">
        <h4>Income</h4>
        <p>Rp 0, -</p>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>

<?= $this->endSection() ?>