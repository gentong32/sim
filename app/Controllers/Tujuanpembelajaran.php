<?php

namespace App\Controllers;

use App\Models\M_user;
use App\Models\M_sekolah;

class Tujuanpembelajaran extends BaseController
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
        $jenis = substr($kelaspilihan, 0, 1);
        $idx = substr($kelaspilihan, 1, 1);
        $data_saya = $this->M_user->get_data_guru($id_user);
        $nuptk = $data_saya->nuptk;

        $pesan = session()->getFlashdata('pesan');
        $data['pesan'] = $pesan;
        $data['id_user'] = $id_user;
        $judul_submenu = "Tujuan Pembelajaran";
        $data['valkelas'] = $kelaspilihan;

        $data['judul_submenu'] = $judul_submenu;
        $data['submenu'] = true;
        $data['menutitle'] = 'TP';
        $data['ikon'] = 'tp';

        if ($jenis == "g") {
            $daftarkelasajar = $this->M_user->cekajarkelas($nuptk, $id_sekolah);
            $id_mapel = $daftarkelasajar[($idx) - 1]['id_mapel'];
            $kelas = $daftarkelasajar[($idx) - 1]['kelas'];
            $nama_mapel = $daftarkelasajar[($idx) - 1]['nama_mapel'];
            $id_guru = $daftarkelasajar[($idx) - 1]['id_guru'];
            $daftartp = $this->M_sekolah->getTP($id_guru, $id_mapel, $kelas, tahun_ajaran());
            $data['daftarkelasajar'] = $daftarkelasajar;
            $data['pilidx'] = $idx;
            $data['kelas'] = $kelas;
            $data['id_mapel'] = $id_mapel;
            $data['nama_mapel'] = $nama_mapel;
            $data['daftartp'] = $daftartp;
            return view('v_tujuan_pembelajaran', $data);
        } else {
            $id_sekolah = session()->get('id_sekolah');
            $daftarwaliekskul = $this->M_user->cekwaliekskul($nuptk, $id_sekolah, tahun_ajaran());
            $id_ekskul = $daftarwaliekskul[($idx) - 1]['id_ekskul'];
            $nama_ekskul = $daftarwaliekskul[($idx) - 1]['nama_ekskul'];
            $namakelaspilihan = $this->request->getVar('n_kelas');
            $daftarkelas_sekolah = $this->M_sekolah->get_daftar_kelas($id_sekolah, tahun_ajaran());
            if (!isset($namakelaspilihan)) {
                $namakelaspilihan = $daftarkelas_sekolah[0]['kelas'];
            }
            $daftartp = $this->M_sekolah->getTP_Ekskul($id_ekskul, $namakelaspilihan);
            $data['daftar_kelas'] = $daftarkelas_sekolah;
            $data['kelas'] = $namakelaspilihan;
            $data['daftartp'] = $daftartp;
            $data['nama_ekskul'] = $nama_ekskul;
            return view('v_tujuan_pembelajaran_ekskul', $data);
        }

        // echo var_dump($daftartp);



    }

    public function simpan_tj_pem()
    {
        if (!khusususer())
            return redirect()->to("/");

        $id_user = session()->get('id_user');
        $id_sekolah = session()->get('id_sekolah');
        $dataMapel = json_decode(file_get_contents('php://input'), true);
        $data_saya = $this->M_user->get_data_guru($id_user);
        $nuptk = $data_saya->nuptk;
        $daftarkelasajar = $this->M_user->cekajarkelas($nuptk, $id_sekolah);
        $kelaspilihan = $dataMapel['valkelas'];
        $idx = substr($kelaspilihan, 1, 1);
        $id_mapel = $daftarkelasajar[($idx) - 1]['id_mapel'];
        $kelas = $daftarkelasajar[($idx) - 1]['kelas'];

        $id_guru = $daftarkelasajar[($idx) - 1]['id_guru'];

        $data = array();
        $data['id_guru'] = $id_guru;
        $data['id_mapel'] = $id_mapel;
        $data['kelas'] = $kelas;
        $data['tahun_ajaran'] = tahun_ajaran();
        $data['tujuan_pembelajaran'] = htmlspecialchars($dataMapel['tj_pem'], ENT_QUOTES, 'UTF-8');

        $simpandata = $this->M_sekolah->tambah_tp($data);

        if ($simpandata)
            $response = ['pesan' => "Berhasil"];
        else
            $response = ['pesan' => "Gagal Menyimpan"];

        return $this->response->setJSON($response);
    }

    public function update_tj_pem()
    {
        if (!khusususer())
            return redirect()->to("/");

        $id_user = session()->get('id_user');
        $id_sekolah = session()->get('id_sekolah');
        $dataMapel = json_decode(file_get_contents('php://input'), true);
        $data_saya = $this->M_user->get_data_guru($id_user);
        $nuptk = $data_saya->nuptk;
        $daftarkelasajar = $this->M_user->cekajarkelas($nuptk, $id_sekolah);
        $kelaspilihan = $dataMapel['valkelas'];
        $idx = substr($kelaspilihan, 1, 1);
        $id_mapel = $daftarkelasajar[($idx) - 1]['id_mapel'];
        $kelas = $daftarkelasajar[($idx) - 1]['kelas'];

        $id_guru = $daftarkelasajar[($idx) - 1]['id_guru'];

        $data = array();
        $data['tujuan_pembelajaran'] = htmlspecialchars($dataMapel['tj_pem'], ENT_QUOTES, 'UTF-8');
        $datawhere['id_guru'] = $id_guru;
        $datawhere['id_mapel'] = $id_mapel;
        $datawhere['kelas'] = $kelas;
        $datawhere['tahun_ajaran'] = tahun_ajaran();
        $datawhere['tujuan_pembelajaran'] = htmlspecialchars($dataMapel['tj_pemlama'], ENT_QUOTES, 'UTF-8');

        $simpandata = $this->M_sekolah->update_tp($data, $datawhere);

        if ($simpandata)
            $response = ['pesan' => "Berhasil"];
        else
            $response = ['pesan' => "Gagal Menyimpan"];

        return $this->response->setJSON($response);
    }

    public function hapus_tj_pem()
    {
        if (!khusususer())
            return redirect()->to("/");

        $id_user = session()->get('id_user');
        $id_sekolah = session()->get('id_sekolah');
        $dataMapel = json_decode(file_get_contents('php://input'), true);
        $data_saya = $this->M_user->get_data_guru($id_user);
        $nuptk = $data_saya->nuptk;
        $daftarkelasajar = $this->M_user->cekajarkelas($nuptk, $id_sekolah);
        $kelaspilihan = $dataMapel['valkelas'];
        $idx = substr($kelaspilihan, 1, 1);
        $id_mapel = $daftarkelasajar[($idx) - 1]['id_mapel'];
        $kelas = $daftarkelasajar[($idx) - 1]['kelas'];

        $id_guru = $daftarkelasajar[($idx) - 1]['id_guru'];

        $datawhere = array();
        $datawhere['tujuan_pembelajaran'] = $dataMapel['tj_pem'];
        $datawhere['id_guru'] = $id_guru;
        $datawhere['id_mapel'] = $id_mapel;
        $datawhere['kelas'] = $kelas;
        $datawhere['tahun_ajaran'] = tahun_ajaran();

        $hapusdata = $this->M_sekolah->hapus_tp($datawhere);

        if ($hapusdata)
            $response = ['pesan' => "Berhasil"];
        else
            $response = ['pesan' => "Gagal Menghapus"];

        return $this->response->setJSON($response);
    }

    public function simpan_tj_pem_eks()
    {
        if (!khusususer())
            return redirect()->to("/");

        $id_user = session()->get('id_user');

        $dataMapel = json_decode(file_get_contents('php://input'), true);
        $data_saya = $this->M_user->get_data_guru($id_user);
        $nuptk = $data_saya->nuptk;

        $kelaspilihan = $dataMapel['valkelas'];
        $idx = substr($kelaspilihan, 1, 1);

        $id_sekolah = session()->get('id_sekolah');
        $daftarwaliekskul = $this->M_user->cekwaliekskul($nuptk, $id_sekolah, tahun_ajaran());
        $id_ekskul = $daftarwaliekskul[($idx) - 1]['id_ekskul'];
        $kelas = $dataMapel['kelasdipilih'];

        $data = array();
        $data['id_ekskul'] = $id_ekskul;
        $data['kelas'] = $kelas;
        $data['tujuan_pembelajaran'] = htmlspecialchars($dataMapel['tj_pem'], ENT_QUOTES, 'UTF-8');

        $simpandata = $this->M_sekolah->tambah_tp_eks($data);

        if ($simpandata)
            $response = ['pesan' => "Berhasil"];
        else
            $response = ['pesan' => "Gagal Menyimpan"];

        return $this->response->setJSON($response);
    }

    public function update_tj_pem_eks()
    {
        if (!khusususer())
            return redirect()->to("/");

        $id_user = session()->get('id_user');

        $dataMapel = json_decode(file_get_contents('php://input'), true);
        $data_saya = $this->M_user->get_data_guru($id_user);
        $nuptk = $data_saya->nuptk;

        $kelaspilihan = $dataMapel['valkelas'];
        $idx = substr($kelaspilihan, 1, 1);

        $id_sekolah = session()->get('id_sekolah');
        $daftarwaliekskul = $this->M_user->cekwaliekskul($nuptk, $id_sekolah, tahun_ajaran());
        $id_ekskul = $daftarwaliekskul[($idx) - 1]['id_ekskul'];
        $kelas = $dataMapel['kelasdipilih'];

        $data = array();
        $datawhere['id_ekskul'] = $id_ekskul;
        $datawhere['kelas'] = $kelas;
        $datawhere['tujuan_pembelajaran'] = $dataMapel['tj_pemlama'];
        $data['tujuan_pembelajaran'] = htmlspecialchars($dataMapel['tj_pem'], ENT_QUOTES, 'UTF-8');

        $simpandata = $this->M_sekolah->update_tp_eks($data, $datawhere);

        if ($simpandata)
            $response = ['pesan' => "Berhasil"];
        else
            $response = ['pesan' => "Gagal Menyimpan"];

        return $this->response->setJSON($response);
    }

    public function hapus_tj_pem_eks()
    {
        if (!khusususer())
            return redirect()->to("/");

        $id_user = session()->get('id_user');

        $dataMapel = json_decode(file_get_contents('php://input'), true);
        $data_saya = $this->M_user->get_data_guru($id_user);
        $nuptk = $data_saya->nuptk;

        $kelaspilihan = $dataMapel['valkelas'];
        $idx = substr($kelaspilihan, 1, 1);

        $id_sekolah = session()->get('id_sekolah');
        $daftarwaliekskul = $this->M_user->cekwaliekskul($nuptk, $id_sekolah, tahun_ajaran());
        $id_ekskul = $daftarwaliekskul[($idx) - 1]['id_ekskul'];
        $kelas = $dataMapel['kelasdipilih'];

        $datawhere['id_ekskul'] = $id_ekskul;
        $datawhere['kelas'] = $kelas;
        $datawhere['tujuan_pembelajaran'] = htmlspecialchars($dataMapel['tj_pem'], ENT_QUOTES, 'UTF-8');

        $hapusdata = $this->M_sekolah->hapus_tp_eks($datawhere);

        if ($hapusdata)
            $response = ['pesan' => "Berhasil"];
        else
            $response = ['pesan' => "Gagal Menghapus"];

        return $this->response->setJSON($response);
    }
}
