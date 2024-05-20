<?= $this->extend('layout/layout_default') ?>

<?= $this->section('style') ?>
<style>
    :root {
        --ukf: 12px;
    }

    #data-table_wrapper {
        width: 100%;
        max-width: 600px;
        margin: auto;
    }

    table td:nth-child(3) {
        width: 50%;
    }

    .tbok {
        display: inline;
        padding: 5px 5px;
        margin-top: 10px;
        font-size: 14px;
        color: #fff;
        background-color: darkolivegreen;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
        width: 120px;
    }

    .ok {
        display: inline-block;
        padding: 5px 5px;
        margin-top: 5px;
        font-size: 14px;
        color: #fff;
        background-color: green;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

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

    .rekap {
        display: inline-block;
        padding: 5px 5px;
        margin-top: 5px;
        font-size: 14px;
        color: #fff;
        background-color: #4e5d84;
        border: 0.5px solid #293358;
        border-radius: 1px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .info {
        margin-top: 10px;
        color: darkgreen;
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
        max-width: 400px;
        width: 95%;
        z-index: 9999;
        display: none;
    }

    .bawah {
        display: flex;
        justify-content: space-between;
        width: 100%;
        max-width: 600px;
        margin: auto;
    }

    #pilsemester {
        margin-top: 10px;
        font-size: 16px;
    }
</style>
<link rel="stylesheet" href="<?= base_url() ?>css/s_pribadi.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<h3>Kelas
    <select class="pilkelas" name="daftarrombel" id="daftarrombel">
        <?php
        $indeks = 0;
        foreach ($daftarkelaswali as $row) :
            $indeks++;
            $selected = "";
            if ($pilidx == $indeks) {
                $selected = "selected";
            }
        ?>
            <option <?= $selected ?> value="<?= $indeks ?>"><?= $row['nama_rombel'] ?></option>
        <?php endforeach ?>
    </select>
    <br>
    <select name="pilsemester" id="pilsemester">
        <option <?= ($pilihsemester == "midganjil") ? "selected" : "" ?> value="midganjil">TENGAH SEMESTER GANJIL</option>
        <option <?= ($pilihsemester == "raporganjil") ? "selected" : "" ?> value="raporganjil">AKHIR SEMESTER GANJIL</option>
        <option <?= ($pilihsemester == "midgenap") ? "selected" : "" ?> value="midgenap">TENGAH SEMESTER GENAP</option>
        <option <?= ($pilihsemester == "raporgenap") ? "selected" : "" ?> value="raporgenap">AKHIR SEMESTER GENAP</option>
    </select>
</h3>


<div class="daftar">
    <table id="data-table" class="display nowrap">
        <thead>
            <tr>
                <th>No</th>
                <th class='none'>NIS</th>
                <th>Nama</th>
                <th class="none">Jenis Kelamin</th>
                <th class="none">Alamat</th>
                <th class="none">No. Telp</th>
                <th>K<sup>1</sup></th>
                <th>K<sup>2</sup></th>
                <th>K<sup>3</sup></th>
                <th>K<sup>4</sup></th>
            </tr>
        </thead>
        <tbody>
            <!-- Data -->
        </tbody>
    </table>


    <div class="bawah">
        <div id="keterangan" style="margin-left: 10px;">
            <label style="margin-left: -7px !important;">Keterangan:</label><br>
            <label>K<sup>1</sup>: Kelakuan</label><br>
            <label>K<sup>2</sup>: Kerajinan</label><br>
            <label>K<sup>3</sup>: Kerapian</label><br>
            <label>K<sup>4</sup>: Kebersihan</label>
            <br>
            <!-- <i> *) Jika semua hadir tidak perlu dilakukan penyimpanan</i> -->
        </div>
        <div id="tb_update" style="display: none;"><button class="tbok">Update Data</button></div>
        <div id="info_update" class="info" style="display: none;">Data Tersimpan</div>
    </div>

</div>

<?= $this->endSection(); ?>


<?= $this->section('script') ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script>
    fetchNewData();

    function fetchNewData() {
        fetch('<?= base_url("kepribadian/get_data_kepribadian") ?>' + '?kelas=<?= $kelaspilihan ?>&semester=<?= $pilihsemester ?>')
            .then(response => response.json())
            .then(data => {
                updateTable(data);
            })
            .catch(error => console.error('Error:', error));
    }

    function updateTable(newData) {
        var dataSet = [];
        var semester = '<?= $pilihsemester ?>';

        for (var i = 0; i < newData.length; i++) {
            var data = newData[i];

            dataSet.push([i + 1, data.nis, data.nama, data.jenis_kelamin, data.alamat, data.telp, data.kelakuan, data.kerajinan, data.kerapihan, data.kebersihan]);
        }

        $('#data-table').DataTable().destroy();

        $('#data-table').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
            },
            "aLengthMenu": [
                [15, -1],
                [15, "All"]
            ],
            data: dataSet,
            responsive: true,
            columnDefs: [{
                    responsivePriority: 1,
                    targets: 0
                },
                {
                    responsivePriority: 3,
                    targets: 2
                },
                {
                    responsivePriority: 2,
                    targets: -1
                }
            ],
            columns: [{
                    title: 'No'
                }, {
                    title: 'NIS'
                },
                {
                    title: 'Nama',
                },
                {
                    title: 'Jenis Kelamin'
                },
                {
                    title: 'Alamat'
                },
                {
                    title: 'No. Telp'
                },
                {
                    title: 'K<sup>1</sup>',
                    render: function(data, type, row) {
                        return '<select class="so1"><option value="0"></option><option ' + (data === "1" ? 'selected' : '') + ' value="1">K</option><option ' + (data === "2" ? 'selected' : '') + ' value="2">C</option><option ' + (data === "3" ? 'selected' : '') + ' value="3">B</option><option ' + (data === "4" ? 'selected' : '') + ' value="4">SB</option></select>';
                    }
                },
                {
                    title: 'K<sup>2</sup>',
                    render: function(data, type, row) {
                        return '<select class="so2"><option value="0"></option><option ' + (data === "1" ? 'selected' : '') + ' value="1">K</option><option ' + (data === "2" ? 'selected' : '') + ' value="2">C</option><option ' + (data === "3" ? 'selected' : '') + ' value="3">B</option><option ' + (data === "4" ? 'selected' : '') + ' value="4">SB</option></select>';
                    }
                },
                {
                    title: 'K<sup>3</sup>',
                    render: function(data, type, row) {
                        return '<select class="so3"><option value="0"></option><option ' + (data === "1" ? 'selected' : '') + ' value="1">K</option><option ' + (data === "2" ? 'selected' : '') + ' value="2">C</option><option ' + (data === "3" ? 'selected' : '') + ' value="3">B</option><option ' + (data === "4" ? 'selected' : '') + ' value="4">SB</option></select>';
                    }
                },
                {
                    title: 'K<sup>4</sup>',
                    render: function(data, type, row) {
                        return '<select class="so4"><option value="0"></option><option ' + (data === "1" ? 'selected' : '') + ' value="1">K</option><option ' + (data === "2" ? 'selected' : '') + ' value="2">C</option><option ' + (data === "3" ? 'selected' : '') + ' value="3">B</option><option ' + (data === "4" ? 'selected' : '') + ' value="4">SB</option></select>';
                    }
                },
            ]
        });

    }

    document.getElementById('tb_update').addEventListener('click', function() {
        var table = $('#data-table').DataTable();
        var dataToSend = [];

        table.rows().every(function(rowIdx, tableLoop, rowLoop) {
            var data = this.data();
            var NIS = data[1];
            var selectedValues = [];

            // Mengambil nilai dari elemen select di setiap baris
            $(this.node()).find('.so1, .so2, .so3, .so4').each(function() {
                selectedValues.push($(this).val());
            });

            // Menambahkan data ke dalam array dataToSend
            dataToSend.push({
                NIS: NIS,
                kepribadian: selectedValues,
                semester: '<?= $pilihsemester ?>',
            });
        });

        // Melakukan sesuatu dengan dataToSend, misalnya mengirimkan ke server
        // console.log(dataToSend);

        fetch('<?= base_url("kepribadian/simpan_kepribadian") ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(dataToSend)
            })
            .then(response => response.json())
            .then(data => {
                $('#tb_update').hide();
                $('#info_update').show();
                setTimeout(function() {
                    $('#info_update').hide();
                }, 2000);
            })
            .catch(error => console.error('Gagal menyimpan data:', error));
    });

    $(document).on('change', '.so1, .so2, .so3, .so4', function() {
        // var hasValue = $(this).val() != 0;
        $('#tb_update').show();
    });




    document.getElementById('daftarrombel').addEventListener('change', function() {
        nsemester = document.getElementById('semester').value;
        window.open("<?= base_url() . 'kepribadian?kelas=w' ?>" + this.value + "&semester=<?= $pilihsemester ?>", "_self");
    });

    document.getElementById('pilsemester').addEventListener('change', function() {
        nkelas = document.getElementById('daftarrombel').value;
        window.open("<?= base_url() . 'kepribadian?kelas=w' ?>" + nkelas + "&semester=" + this.value, "_self ");
    });
</script>

<?= $this->endSection(); ?>