<?= $this->extend('layout/layout_admin') ?>

<?= $this->section('style') ?>
<style>
    .btn-unduh {
        background-color: #1676a8;
        color: #fff;
        padding: 5px;
        margin-bottom: 10px;
        border: 0.5px solid black;
        border-radius: 5px;
    }

    .btn-kembali {
        background-color: #e28743;
        color: #fff;
        padding: 4px;
        margin-bottom: 10px;
        border: 0.5px solid black;
        border-radius: 3px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<h3>Petunjuk Untuk Impor Data</h3>
<p>Untuk mengambil data Guru, data Siswa, atau data Staf dapat dilakukan dengan cara impor file excel sesuai format. </p>
<p>Untuk data <b>Guru</b> dan data <b>Staf</b>, jika mengimpor data, maka akan <b>menghapus</b> semua data guru dan staf saat ini terlebih dahulu baru kemudian memasukkan data baru yang ada di file excel.</p>
<p>Khusus untuk data <b>Siswa</b>, akan <b>menghapus</b> data siswa di <b>tahun ajaran</b> dan <b>kelas</b> yang sesuai dengan data yang diberikan di dalam file excel. Jadi misal ingin menambah data penerimaan siswa baru, yang diberikan di dalam file excel hanya daftar siswa baru saja. <b>Kecuali</b> untuk sekolah yang <b>belum</b> memasukkan semua data siswa ke dalam sistem, silakan ditulis daftar semua siswa yang ada di sekolah.</p>
<p>Silakan unduh contoh format berikut ini. </p>
<button class="btn-unduh" onclick="unduhguru()">Format Data Guru</button><br>
<button class="btn-unduh" onclick="unduhsiswa()">Format Data Siswa</button><br>
<button class="btn-unduh" onclick="unduhstaf()">Format Data Staf</button><br><br>
<button class="btn-kembali" onclick="kembali()">Kembali</button><br>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    function kembali() {
        window.open("<?= base_url() ?>admin/user", "_self");
    }

    function unduhguru() {
        window.open("<?= base_url() ?>admin/unduh_data_guru", "_self");
    }

    function unduhsiswa() {
        window.open("<?= base_url() ?>admin/unduh_data_siswa", "_self");
    }

    function unduhstaf() {
        window.open("<?= base_url() ?>admin/unduh_data_staf", "_self");
    }
</script>
<?= $this->endSection() ?>