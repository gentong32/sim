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
}
