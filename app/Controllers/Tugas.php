<?php

namespace App\Controllers;

use App\Models\M_user;
use App\Models\M_sekolah;

class Tugas extends BaseController
{
    function __construct()
    {
        $this->M_user = new M_user();
        $this->M_sekolah = new M_sekolah();
    }

    public function index()
    {
        if (!khusususer())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $id_user = session()->get('id_user');

        $kelaspilihan = $this->request->getVar('kelas');
        $idx = substr($kelaspilihan, 1, 1);
        $data_saya = $this->M_user->get_data_guru($id_user);
        $nuptk = $data_saya->nuptk;
        $daftarkelasajar = $this->M_user->cekajarkelas($nuptk, $id_sekolah);
        $id_mapel = $daftarkelasajar[($idx) - 1]['id_mapel'];
        $kelas = $daftarkelasajar[($idx) - 1]['kelas'];
        $nama_mapel = $daftarkelasajar[($idx) - 1]['nama_mapel'];
        $nama_rombel = $daftarkelasajar[$idx - 1]['nama_rombel'];
        $id_guru_mapel = $daftarkelasajar[($idx) - 1]['id_guru_mapel'];
        $daftartugas = $this->M_sekolah->get_tptugas($id_guru_mapel, tahun_ajaran());
        $id_guru = $daftarkelasajar[($idx) - 1]['id_guru'];
        $daftartp = $this->M_sekolah->getTP($id_guru, $id_mapel, $kelas, tahun_ajaran());
        $datakalender = $this->M_sekolah->getAgenda($id_sekolah);

        $pesan = session()->getFlashdata('pesan');
        $data['pesan'] = $pesan;
        $data['id_user'] = $id_user;
        $data['id_guru_mapel'] = $id_guru_mapel;
        $judul_submenu = "Tugas / Tes";
        $data['valkelas'] = $kelaspilihan;
        $data['kelas'] = $kelas;
        $data['id_mapel'] = $id_mapel;
        $data['nama_rombel'] = $nama_rombel;
        $data['nama_mapel'] = $nama_mapel;
        $data['daftar_tp'] = $daftartp;
        $data['daftar_tugas'] = $daftartugas;
        $data['judul_submenu'] = $judul_submenu;
        $data['datakalender'] = json_encode($datakalender);
        $data['submenu'] = true;
        $data['menutitle'] = 'TP';
        $data['ikon'] = 'tugas';
        $data['daftarkelasajar'] = $daftarkelasajar;
        $data['pilidx'] = $idx;

        return view('v_tugas_tes', $data);
    }

    public function simpan_tugas()
    {
        if (!khusususer())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $dataTP = json_decode(file_get_contents('php://input'), true);

        $tanggaltugas = $dataTP['tanggaltugas'];
        $namatugas = $dataTP['namatugas'];
        $daftartp = $dataTP['pilihantp'];
        $id_guru_mapel = $dataTP['id_guru_mapel'];

        $data1['id_guru_mapel'] = $id_guru_mapel;
        $data1['nama_tugas'] = $namatugas;
        $data1['tahun_ajaran'] = tahun_ajaran();
        $data1['tanggal_tugas'] = $tanggaltugas;
        $insert = $this->M_sekolah->insert_tugas($data1);
        $lastInsertedID = $insert;

        foreach ($daftartp as $tpterpilih) {
            $data2['id_tugas'] = $lastInsertedID;
            $data2['id_tp'] = $tpterpilih;
            $this->M_sekolah->insert_tugas_tp($data2);
        }

        $response = ['message' => "OK"];
        return $this->response->setJSON($response);
    }

    public function hapus_tugas()
    {
        if (!khusususer())
            return redirect()->to("/");

        $id_user = session()->get('id_user');
        $id_sekolah = session()->get('id_sekolah');
        $dataTugas = json_decode(file_get_contents('php://input'), true);
        $id_tugas = $dataTugas['id_tugas'];

        $kelaspilihan = $dataTugas['valkelas'];
        $data_saya = $this->M_user->get_data_guru($id_user);
        $nuptk = $data_saya->nuptk;
        $daftarkelasajar = $this->M_user->cekajarkelas($nuptk, $id_sekolah);
        $idx = substr($kelaspilihan, 1, 1);
        $id_guru_mapel = $daftarkelasajar[($idx) - 1]['id_guru_mapel'];

        $datawhere = array();
        $datawhere['id'] = $id_tugas;
        $datawhere['id_guru_mapel'] = $id_guru_mapel;

        $hapusdata = $this->M_sekolah->hapus_tugas($datawhere);

        if ($hapusdata)
            $response = ['pesan' => "Berhasil"];
        else
            $response = ['pesan' => "Gagal Menghapus"];

        return $this->response->setJSON($response);
    }

    public function tugas_siswa()
    {
        if (session()->get('sebagai') != "siswa")
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $id_user = session()->get('id_user');
        $mapelterpilih = $this->request->getVar('mapel');
        $semesterterpilih = $this->request->getVar('semester');

        $data_saya = $this->M_user->getDataSiswa($id_user, tahun_ajaran());

        $kelas = $data_saya['kelas'];
        $nisn = $data_saya['nisn'];
        $agama = $data_saya['agama'];
        $nama_rombel = $data_saya['nama_rombel'];
        $getidrombel = $this->M_sekolah->get_id_rombel($id_sekolah, $kelas, $nama_rombel);
        $id_rombel = $getidrombel['id'];
        $sub_kelas = $getidrombel['sub_kelas'];

        $id_sekolah = session()->get('id_sekolah');
        $infosekolah = $this->M_sekolah->getInfoSekolah($id_sekolah, tahun_ajaran());

        $awgj = $infosekolah['tgl_awal_ganjil'];
        $mdgj = $infosekolah['tgl_mid_ganjil'];
        $akgj = $infosekolah['tgl_rapor_ganjil'];
        $awgn = $infosekolah['tgl_awal_genap'];
        $mdgn = $infosekolah['tgl_mid_genap'];
        $akgn = $infosekolah['tgl_rapor_genap'];

        if (!isset($semesterterpilih)) {
            $tg_sekarang = date("Y-m-d");
            if ($tg_sekarang <= $akgn)
                $semesterterpilih = "raporgenap";
            if ($tg_sekarang <= $mdgn)
                $semesterterpilih = "midgenap";
            if ($tg_sekarang <= $akgj)
                $semesterterpilih = "raporganjil";
            if ($tg_sekarang <= $mdgj)
                $semesterterpilih = "midganjil";
        }

        if ($semesterterpilih == "midganjil") {
            $tglawal = $awgj;
            $tglakhir = $mdgj;
            $judulsemester = "TENGAH SEMESTER GANJIL";
            $suffiks = "_mid_ganjil";
            $nsemester = 1;
        } else if ($semesterterpilih == "raporganjil") {
            $tglawal = $awgj; //$mdgj;
            $tglakhir = $akgj;
            $judulsemester = "AKHIR SEMESTER GANJIL";
            $suffiks = "_akhir_ganjil";
            $nsemester = 1;
        } else if ($semesterterpilih == "midgenap") {
            $tglawal = $awgn;
            $tglakhir = $mdgn;
            $judulsemester = "TENGAH SEMESTER GENAP";
            $suffiks = "_mid_genap";
            $nsemester = 2;
        } else if ($semesterterpilih == "raporgenap") {
            $tglawal = $awgn; //$mdgn;
            $tglakhir = $akgn;
            $judulsemester = "AKHIR SEMESTER GENAP";
            $suffiks = "_akhir_genap";
            $nsemester = 2;
        }

        $tglsekarang = date('Y-m-d');

        $get_daftar_tugas = $this->M_user->get_tugas_kelas($id_rombel, $tglsekarang);

        $judul_submenu = "&nbsp;Tugas";

        $data['judul_submenu'] = $judul_submenu;
        $data['submenu'] = true;
        $data['menutitle'] = 'TP';
        $data['ikon'] = 'tugas';
        $data['kelas'] = $kelas;
        $data['rombel'] = $nama_rombel;
        $data['mapel'] = $mapelterpilih;
        $data['semester'] = $semesterterpilih;
        $data['daftar_tugas'] = $get_daftar_tugas;

        return view('v_tugas_siswa', $data);
    }
}
