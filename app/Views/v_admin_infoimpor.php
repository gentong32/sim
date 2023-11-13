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
<p>Impor data <b>Guru</b> dan data <b>Staf</b>, akan <b>memperbarui</b> data semua guru dan staf pada <b>tahun ajaran</b> saat ini.</p>
<p>Impor data <b>Siswa</b>, akan <b>memperbarui</b> data siswa di <b>tahun ajaran</b> dan <b>hanya kelas yang sesuai</b> dengan data yang diberikan di dalam file excel. Hal ini dapat digunakan misalnya ingin menambah data penerimaan siswa baru di kelas 10 saja. Untuk sekolah yang <b>belum</b> mempunyai data siswa sama sekali, silakan memasukkan <b>semua</b> siswa dari semua kelas seperti tertulis pada contoh format data siswa.</p>
<p>Format impor data dapat diunduh menggunakan tombol berikut ini, kemudian data diubah sesuai kondisi di sekolah. </p>
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