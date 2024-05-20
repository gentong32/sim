<?php

namespace App\Controllers;

use App\Models\M_user;
use App\Models\M_sekolah;

class Agenda extends BaseController
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
        $id_rombel = "";
        $nama_rombel = "";

        if (session()->get('sebagai') == "guru") {
            $kelaspilihan = $this->request->getVar('kelas');
            $idx = substr($kelaspilihan, 1, 1);
            $data_saya = $this->M_user->get_data_guru($id_user);
            $nuptk = $data_saya->nuptk;
            $sebagai = substr($kelaspilihan, 0, 1);
            if ($sebagai == "w") {
                $daftarkelaswali = $this->M_user->cekwalikelas($nuptk, $id_sekolah);
                $id_rombel = $daftarkelaswali[($idx) - 1]['id'];
                $nama_rombel = $daftarkelaswali[$idx - 1]['nama_rombel'];
            } else if ($sebagai == "g") {
                $daftarkelasajar = $this->M_user->cekajarkelas($nuptk, $id_sekolah);
                $id_rombel = $daftarkelasajar[($idx) - 1]['id'];
                $nama_rombel = $daftarkelasajar[$idx - 1]['nama_rombel'];
            }
        } else if (session()->get('sebagai') == "siswa") {
            $data_saya = $this->M_user->getDataSiswa($id_user, tahun_ajaran());
            $kelas = $data_saya['kelas'];
            $nama_rombel = $data_saya['nama_rombel'];
            $getidrombel = $this->M_sekolah->get_id_rombel($id_sekolah, $kelas, $nama_rombel);
            $id_rombel = $getidrombel['id'];
            $kelaspilihan = $id_rombel;
        }
        $datakalender = $this->M_sekolah->getAgendaKelas($id_sekolah, $id_rombel);

        $pesan = session()->getFlashdata('pesan');
        $data['pesan'] = $pesan;
        $data['id_user'] = $id_user;
        $judul_submenu = "Agenda Kelas " . $nama_rombel;
        $data['valkelas'] = $kelaspilihan;
        $data['datakalender'] = json_encode($datakalender);
        $data['judul_submenu'] = $judul_submenu;
        $data['submenu'] = true;
        $data['menutitle'] = 'Agenda';
        $data['ikon'] = 'kalender';
        $data['id_rombel'] = $id_rombel;
        return view('v_agenda', $data);
    }

    public function list_agenda()
    {
        if (!khusususer())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $tahun_sekarang = date("Y");
        $id_user = session()->get('id_user');
        $datakalender = $this->M_sekolah->getAgendaAll($id_sekolah, $id_user, $tahun_sekarang);
        $data['sekolah'] = $datasekolah;
        $data['tahun_ajaran'] = tahun_ajaran('lengkap');
        $data['nama_user'] = session()->get('nama_user');
        $data['datakalender'] = $datakalender;
        $data['jmldatakalender'] = sizeof($datakalender);

        return view('v_agenda_list', $data);
    }

    public function simpan_agenda_kelas()
    {
        if (!khusususer())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $id_user = session()->get('id_user');

        $tanggal = $this->request->getVar('tanggal');
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $agenda = $this->request->getVar('iagenda');
        $addedit = $this->request->getVar('addedit');
        $kelaspilihan = $this->request->getVar('valkelas');

        if (session()->get('sebagai') == "siswa") {
            $id_rombel = $kelaspilihan;
            $jenisagenda = "5";
        } else {
            $idx = substr($kelaspilihan, 1, 1);
            $data_saya = $this->M_user->get_data_guru($id_user);
            $nuptk = $data_saya->nuptk;
            $sebagai = substr($kelaspilihan, 0, 1);
            if ($sebagai == "w") {
                $daftarkelaswali = $this->M_user->cekwalikelas($nuptk, $id_sekolah);
                $id_rombel = $daftarkelaswali[($idx) - 1]['id'];
                $jenisagenda = "3";
            } else if ($sebagai == "g") {
                $daftarkelasajar = $this->M_user->cekajarkelas($nuptk, $id_sekolah);
                $id_rombel = $daftarkelasajar[($idx) - 1]['id'];
                $jenisagenda = "4";
            }
        }

        session()->setFlashdata('pesan', $bulan . "-" . $tahun);

        $tanggalnya = $tahun . "-" . (intval($bulan) + 1) . "-" . $tanggal;

        if ($addedit == "add")
            $this->M_sekolah->tambah_agenda_kelas($id_sekolah, $tanggalnya, $agenda, $jenisagenda, $id_rombel, $id_user);
        else
            $this->M_sekolah->update_agenda_kelas($id_sekolah, $tanggalnya, $agenda, $jenisagenda, $id_rombel, $id_user);

        return redirect()->to(base_url() . 'agenda?kelas=' . $kelaspilihan);
    }

    public function hapus_agenda_kelas()
    {
        if (!khusususer())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $id_user = session()->get('id_user');

        $tanggal = $this->request->getVar('tanggal');
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $kelaspilihan = $this->request->getVar('valkelas');

        if (session()->get('sebagai') == "siswa") {
            $id_rombel = $kelaspilihan;
        } else {
            $idx = substr($kelaspilihan, 1, 1);
            $data_saya = $this->M_user->get_data_guru($id_user);
            $nuptk = $data_saya->nuptk;
            $daftarkelaswali = $this->M_user->cekwalikelas($nuptk, $id_sekolah);
            $id_rombel = $daftarkelaswali[($idx) - 1]['id'];
        }

        session()->setFlashdata('pesan', $bulan . "-" . $tahun);

        $tanggalnya = $tahun . "-" . (intval($bulan) + 1) . "-" . $tanggal;

        $this->M_sekolah->hapus_agenda_kelas($id_sekolah, $tanggalnya, $id_rombel, $id_user);

        return redirect()->to(base_url() . 'agenda?kelas=' . $kelaspilihan);
    }
}
