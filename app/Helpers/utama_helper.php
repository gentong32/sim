<?php

function khusussuperadmin()
{
    if (session()->get('sebagai') == "superadmin") {
        return true;
    } else {
        return false;
    }
}

function khususadmin()
{
    if (session()->get('sebagai') == "admin") {
        return true;
    } else {
        return false;
    }
}

function khusususer()
{
    if (session()->get('loggedIn')) {
        return true;
    } else {
        return false;
    }
}

function tanggal_sekarang()
{
    $nama_bulan_panjang = ["Januari", "Pebruari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember"];
    $nama_bulan_pendek = ["Jan", "Peb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agt", "Sep", "Okt", "Nop", "Des"];

    $tanggal = new DateTime();
    $strtanggal = $tanggal->format("d-m-Y-H-i-s");
    $ambiltanggal = explode("-", $strtanggal);
    $tgl = $ambiltanggal[0];
    $bln = $ambiltanggal[1];
    $thn = $ambiltanggal[2];

    $data['panjang'] = $tgl . " " . $nama_bulan_panjang[$bln - 1] . " " . $thn;
    $data['pendek'] = $tgl . " " . $nama_bulan_pendek[$bln - 1] . " " . $thn;

    return $data;
}

function format_tanggal($strtanggal)
{
    $nama_bulan_panjang = ["Januari", "Pebruari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember"];
    $nama_bulan_pendek = ["Jan", "Peb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agt", "Sep", "Okt", "Nop", "Des"];

    $tanggal = new DateTime($strtanggal);
    $strtanggal = $tanggal->format("Y/m/d");
    $ambiltanggal = explode("/", $strtanggal);
    $tgl = $ambiltanggal[2];
    $bln = $ambiltanggal[1];
    $thn = $ambiltanggal[0];

    $data['panjang'] = intval($tgl) . " " . $nama_bulan_panjang[$bln - 1] . " " . $thn;
    $data['pendek'] = intval($tgl) . " " . $nama_bulan_pendek[$bln - 1] . " " . $thn;

    return $data;
}

function tahun_ajaran($opsi = null)
{
    // $tanggal = new DateTime("2023-06-01 00:00:00");
    $tanggal = new DateTime();
    $strtanggal = $tanggal->format("d-n-Y-H-i-s");
    $ambiltanggal = explode("-", $strtanggal);
    $bln = $ambiltanggal[1];
    $thn = $ambiltanggal[2];

    if ($opsi == "lengkap") {
        if ($bln >= 7)
            $tahunajaran = $thn . "/" . ($thn + 1);
        else
            $tahunajaran = ($thn - 1) . "/" . $thn;
    } else {
        if ($bln >= 7)
            $tahunajaran = $thn;
        else
            $tahunajaran = ($thn - 1);
    }


    return $tahunajaran;
}

function bulan_sekarang()
{
    // $tanggal = new DateTime("2023-06-01 00:00:00");
    $tanggal = new DateTime();
    $bulan = $tanggal->format("n");
    return $bulan;
}

function tahun_sekarang()
{
    // $tanggal = new DateTime("2023-06-01 00:00:00");
    $tanggal = new DateTime();
    $tahun = $tanggal->format("Y");

    return $tahun;
}

function fase($kelas)
{
    if ($kelas == "TK" || $kelas == "KB" || $kelas == "1" || $kelas == "2")
        return "a";
    else if ($kelas == "3" || $kelas == "4")
        return "b";
    else if ($kelas == "5" || $kelas == "6")
        return "c";
    else if ($kelas == "7" || $kelas == "8" || $kelas == "9")
        return "d";
    else if ($kelas == "10")
        return "e";
    else if ($kelas == "11" || $kelas == "12")
        return "e";
}

function kelasdarijenjang($jenjang)
{
    if ($jenjang == "SD") {
        $data = ["1", "2", "3", "4", "5", "6"];
    } else if ($jenjang == "SMP") {
        $data = ["7", "8", "9"];
    } else if ($jenjang == "SMA") {
        $data = ["10", "11", "12"];
    }
    return $data;
}
