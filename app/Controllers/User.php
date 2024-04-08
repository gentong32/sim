<?php

namespace App\Controllers;

use App\Models\M_user;
use App\Models\M_sekolah;

class User extends BaseController
{
    function __construct()
    {
        $this->M_user = new M_user();
        $this->M_sekolah = new M_sekolah();
    }

    public function index(): string
    {
        $infosekolah = array("jumlah_siswa" => 1200, "jumlah_rombel" => 33);
        $data['info'] = $infosekolah;
        return view('v_user_dashboard', $data);
    }

    public function peserta_ekskul()
    {
        if (!khusususer())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $id_user = session()->get('id_user');

        $kelaspilihan = $this->request->getVar('kelas');
        $kelassiswa = $this->request->getVar('swkelas');
        $rombelsiswa = $this->request->getVar('swrombel');
        $data_saya = $this->M_user->get_data_guru($id_user);
        $nuptk = $data_saya->nuptk;
        $wgl = substr($kelaspilihan, 0, 1);
        $idx = substr($kelaspilihan, 1, 1);
        if ($wgl == "e") {
            $daftarwaliekskul = $this->M_user->cekwaliekskul($nuptk, $id_sekolah, tahun_ajaran());
            $id_ekskul = $daftarwaliekskul[($idx) - 1]['id_ekskul'];
            $nama_ekskul = $daftarwaliekskul[($idx) - 1]['nama_ekskul'];
        } else {
            return redirect("home");
        }

        $daftar_kelas = $this->get_daftar_kelas($id_sekolah, tahun_ajaran());
        $tampil = false;
        if ($kelassiswa == null) {
            $tampil = true;
            $kelassiswa = $daftar_kelas[0];
        }


        $daftar_rombel = $this->M_sekolah->get_rombel_sekolah($id_sekolah, tahun_ajaran(), $kelassiswa);

        if ($rombelsiswa == null) {
            $rombelsiswa = $daftar_rombel[0]->nama_rombel;
        }

        $getdaftarsiswa = $this->M_user->getDaftarSiswa($id_sekolah, tahun_ajaran(), $kelassiswa, $rombelsiswa);

        $get_daftar_siswa_ekskul = $this->M_sekolah->get_daftar_siswa_ekskul($id_sekolah, $kelassiswa, $rombelsiswa, tahun_ajaran(), $id_ekskul);




        // $data['sekolah'] = $datasekolah;
        $data['tahun_ajaran'] = tahun_ajaran('lengkap');
        // $data['tahun_mulai'] = $pilihantahun;
        // $data['info'] = $infosekolah;
        $data['nama_user'] = session()->get('nama_user');
        $data['nama_ekskul'] = $nama_ekskul;

        $data['tampil'] = $tampil;
        $data['daftar_kelas'] = $daftar_kelas;
        $data['daftar_rombel'] = $daftar_rombel;
        $data['daftar_peserta_ekskul'] = $get_daftar_siswa_ekskul;
        $data['datasiswa'] = $getdaftarsiswa;
        $data['kelassiswa'] = $kelassiswa;
        $data['rombelsiswa'] = $rombelsiswa;
        $data['kelas_pilihan'] = $kelaspilihan;

        return view('v_peserta_ekskul', $data);
    }

    public function get_daftar_kelas($id_sekolah, $tahun_ajaran)
    {
        $datarombel = $this->M_sekolah->get_rombel_sekolah($id_sekolah, $tahun_ajaran);
        $daftar_kelas = [];
        foreach ($datarombel as $row) {
            if (!in_array($row->kelas, $daftar_kelas)) {
                $daftar_kelas[] = $row->kelas;
            }
        }
        return $daftar_kelas;
    }

    public function get_rombel_kelas($kelas)
    {
        $id_sekolah = session()->get('id_sekolah');
        $datarombel = $this->M_sekolah->get_rombel_sekolah($id_sekolah, tahun_ajaran(), $kelas);

        return json_encode($datarombel);
    }
}
