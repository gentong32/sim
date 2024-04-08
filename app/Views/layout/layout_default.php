<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIM Sekolah</title>
    <link rel="stylesheet" href="<?= base_url() ?>css/s_umum.css?v1.1">
    <link rel="stylesheet" href="<?= base_url() ?>css/mystyle.css?v1.1">
    <?= $this->renderSection('style') ?>
    <link rel="icon" href="<?php echo base_url(); ?>images/icon.png" type="image/gif" sizes="16x16">
    <script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
</head>

<body>
    <?php if (!isset($nofooter)) : ?>
        <div class="judul">
            <h1><?php
                $jam = date("H");
                if ($jam >= 5 && $jam < 11) {
                    echo "Selamat Pagi";
                } elseif ($jam >= 11 && $jam < 15) {
                    echo "Selamat Siang";
                } elseif ($jam >= 15 && $jam < 18) {
                    echo "Selamat Sore";
                } else {
                    echo "Selamat Malam";
                }
                ?></h1>
            <h2><?= (session()->get('sex') == "L") ? "Pak" : "Bu" ?> <?= session()->get('nama_user') ?></h2>
            <button onclick="keluar();">Logout</button>
        </div>
    <?php endif ?>

    <?php if (isset($beranda)) : ?>
        <div class="dkelas">
            <table class="table1">
                <thead>
                    <tr>
                        <th width="60%">Wali / Mapel</th>
                        <th width="20%">Kelas</th>
                        <th width="20%">Pilih</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sekaliceked = "checked";
                    $wali = 1;

                    $nama_rombel_processed = array();

                    foreach ($daftarkelaswali as $kelaswali) {
                        // Jika nama_rombel belum diproses, tampilkan baris dengan opsi radio atau dropdown
                        if (!in_array($kelaswali['nama_rombel'], $nama_rombel_processed)) {
                            // Hitung jumlah kelas untuk nama_rombel yang sama
                            $jumlah_kelas = 0;
                            foreach ($daftarkelaswali as $kelaswali_inner) {
                                if ($kelaswali_inner['nama_rombel'] == $kelaswali['nama_rombel']) {
                                    $jumlah_kelas++;
                                }
                            }

                            // Jika jumlah kelas lebih dari 1, tampilkan dropdown
                            if ($jumlah_kelas > 1) {
                                echo "<tr><td>Wali Kelas</td>";
                                echo "<td class='kelaspil'>Pilih</td>";
                                // echo "<td><select class='pilkelas' name='rombel_" . $kelaswali['nama_rombel'] . "'>";
                                // foreach ($daftarkelaswali as $kelaswali_inner) {
                                //     // Jika nama_rombel sama dengan yang sedang diproses
                                //     if ($kelaswali_inner['nama_rombel'] == $kelaswali['nama_rombel']) {
                                //         // Tambahkan opsi untuk nama_rombel ke dropdown
                                //         echo "<option value='" . $kelaswali_inner['nama_rombel'] . "'>" . $kelaswali_inner['nama_rombel'] . "</option>";
                                //     }
                                // }
                                // echo "</select></td>";
                                echo "<td><label class='toggle'>";
                                echo "<input type='radio' name='toggle' value='w" . $wali . "' " . $sekaliceked . ">";
                                echo "<span class='slider'></span>";
                                echo "</label></td></tr>";
                            } else { // Jika jumlah kelas hanya 1, tampilkan sebagai teks biasa dan opsi radio
                                echo "<tr><td>Wali Kelas</td>";
                                echo "<td class='kelaspil'>" . $kelaswali['nama_rombel'] . "</td>";
                                echo "<td><label class='toggle'>";
                                echo "<input type='radio' name='toggle' value='w" . $wali . "' " . $sekaliceked . ">";
                                echo "<span class='slider'></span>";
                                echo "</label></td></tr>";
                            }

                            // Tambahkan nama_rombel ke dalam array nama_rombel_processed
                            $nama_rombel_processed[] = $kelaswali['nama_rombel'];
                        }
                        $sekaliceked = "";
                        $wali++;
                    }


                    $guru = 1;
                    $nama_mapel_processed = array();

                    foreach ($daftarkelasajar as $kelasguru) {
                        if (!in_array($kelasguru['nama_mapel'], $nama_mapel_processed)) {
                            // Hitung jumlah nama_rombel untuk nama_mapel yang sama
                            $jumlah_nama_rombel = 0;
                            foreach ($daftarkelasajar as $kelasguru_inner) {
                                if ($kelasguru_inner['nama_mapel'] == $kelasguru['nama_mapel']) {
                                    $jumlah_nama_rombel++;
                                }
                            }

                            // Jika jumlah nama_rombel lebih dari 1, tampilkan dropdown
                            if ($jumlah_nama_rombel > 1) {
                                echo "<tr><td>" . $kelasguru['nama_mapel'] . "</td>";
                                echo "<td class='kelaspil'>Pilih</td>";
                                // echo "<td><select class='pilkelas' name='rombel_" . $kelasguru['nama_mapel'] . "'>";
                                // foreach ($daftarkelasajar as $kelasguru_inner) {
                                //     // Jika nama_mapel sama dengan yang sedang diproses
                                //     if ($kelasguru_inner['nama_mapel'] == $kelasguru['nama_mapel']) {
                                //         // Tambahkan opsi untuk nama_rombel ke dropdown
                                //         echo "<option value='" . $kelasguru_inner['nama_rombel'] . "'>" . $kelasguru_inner['nama_rombel'] . "</option>";
                                //     }
                                // }
                                // echo "</select></td>";
                                echo "<td><label class='toggle'>";
                                echo "<input type='radio' name='toggle' value='g" . $guru . "' " . $sekaliceked . ">";
                                echo "<span class='slider'></span>";
                                echo "</label></td></tr>";
                            } else { // Jika jumlah nama_rombel hanya 1, tampilkan sebagai teks biasa dan opsi radio
                                echo "<tr><td>" . $kelasguru['nama_mapel'] . "</td>";
                                echo "<td class='kelaspil'>" . $kelasguru['nama_rombel'] . "</td>";
                                echo "<td><label class='toggle'>";
                                echo "<input type='radio' name='toggle' value='g" . $guru . "' " . $sekaliceked . ">";
                                echo "<span class='slider'></span>";
                                echo "</label></td></tr>";
                            }

                            // Tambahkan nama_mapel ke dalam array nama_mapel_processed
                            $nama_mapel_processed[] = $kelasguru['nama_mapel'];
                        }
                        $sekaliceked = "";
                        $guru++;
                    }

                    $gurulain = 1;
                    $mapellain = ["-", "B-K", "P-5"];
                    // Array untuk menyimpan data jenis_mapel yang telah diproses
                    $jenis_mapel_processed = array();

                    foreach ($daftarkelasajarlain as $kelasajarlain) {

                        if (!in_array($kelasajarlain['jenis_mapel'], $jenis_mapel_processed)) {
                            // Hitung jumlah nama_rombel untuk jenis_mapel yang sama
                            $jumlah_nama_rombel = 0;
                            foreach ($daftarkelasajarlain as $kelasajarlain_inner) {
                                if ($kelasajarlain_inner['jenis_mapel'] == $kelasajarlain['jenis_mapel']) {
                                    $jumlah_nama_rombel++;
                                }
                            }

                            // Jika jumlah nama_rombel lebih dari 1, tampilkan dropdown
                            if ($jumlah_nama_rombel > 1) {
                                echo "<tr><td>" . $mapellain[$kelasajarlain['jenis_mapel']] . "</td>";
                                echo "<td class='kelaspil'>Pilih</td>";
                                // echo "<td><select class='pilkelas' name='rombel_" . $kelasajarlain['jenis_mapel'] . "'>";
                                // // Loop melalui daftarkelasajarlain untuk mencari nama_rombel yang sesuai
                                // foreach ($daftarkelasajarlain as $kelasajarlain_inner) {
                                //     // Jika jenis_mapel sama dengan yang sedang diproses
                                //     if ($kelasajarlain_inner['jenis_mapel'] == $kelasajarlain['jenis_mapel']) {
                                //         // Tambahkan opsi untuk nama_rombel ke dropdown
                                //         echo "<option value='" . $kelasajarlain_inner['nama_rombel'] . "'>" . $kelasajarlain_inner['nama_rombel'] . "</option>";
                                //     }
                                // }
                                // echo "</select></td>";
                                echo "<td><label class='toggle'>";
                                echo "<input type='radio' name='toggle' value='l" . $gurulain . "' " . $sekaliceked . ">";
                                echo "<span class='slider'></span>";
                                echo "</label></td></tr>";
                            } else { // Jika jumlah nama_rombel hanya 1, tampilkan sebagai teks biasa dan opsi radio
                                echo "<tr><td>" . $mapellain[$kelasajarlain['jenis_mapel']] . "</td>";
                                echo "<td class='kelaspil'>" . $kelasajarlain['nama_rombel'] . "</td>";
                                echo "<td><label class='toggle'>";
                                echo "<input type='radio' name='toggle' value='l" . $gurulain . "' " . $sekaliceked . ">";
                                echo "<span class='slider'></span>";
                                echo "</label></td></tr>";
                            }

                            // Tambahkan jenis_mapel ke dalam array jenis_mapel_processed
                            $jenis_mapel_processed[] = $kelasajarlain['jenis_mapel'];
                        }
                        $sekaliceked = "";
                        $gurulain++;
                    }


                    $ekskul = 0;
                    foreach ($daftarwaliekskul as $waliekskul) {
                        $ekskul++;
                        echo "<tr><td>Ekskul " . $waliekskul['nama_ekskul'] . "</td><td class='kelaspil'>Semua</td>" .
                            "<td><label class='toggle'>
                            <input type='radio' name='toggle' value='e" . $ekskul . "' " . $sekaliceked . ">
                            <span class='slider'></span>
                        </label></td></tr>";
                        $sekaliceked = "";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php endif ?>

    <?php if (isset($submenu)) : ?>
        <div class="dkelas">
            <div class="back-button">
                <a href="/home"><img src="/assets/back.png" alt="back"></a>
            </div>
            <div class="center">
                <div style="margin-left:0px;"><img src="/assets/<?= $ikon ?>.png" alt="Ikon"></div>
                <div class="judul_menu"><?= $judul_submenu ?></div>
            </div>
        </div>
    <?php endif ?>


    <?= $this->renderSection('konten') ?>

    <?php if (!isset($nofooter)) : ?>
        <div class="alamat">
            <p>&copy; 2023 Sawo 3 Production</p>
        </div>
    <?php endif ?>
</body>

</html>

<script>
    var selectedKelas;
    var awalpil;

    function keluar() {
        window.open('<?= base_url() ?>login/logout', '_self');
    }
</script>
<?= $this->renderSection('script') ?>