<?php

namespace App\Controllers;

use App\Models\M_user;
use App\Models\M_sekolah;
use Faker\Core\Uuid;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

use CodeIgniter\I18n\Time;

class Admin extends BaseController
{
    // protected $filters = ['ceknpsn' => ['before' => ['index']]];

    function __construct()
    {
        $this->M_user = new M_user();
        $this->M_sekolah = new M_sekolah();
    }

    public function index()
    {
        return redirect()->to('admin/info_sekolah');
    }

    public function info_sekolah()
    {
        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $infosekolah = $this->M_sekolah->getInfoSekolah($id_sekolah, tahun_ajaran());
        $tglsekarang = tanggal_sekarang();
        $getdaftarguru = $this->M_user->getDaftarGuru($id_sekolah, tahun_ajaran());
        $data['jml_guru'] = sizeof($getdaftarguru);
        $data['tanggal'] = $tglsekarang['panjang'];
        $data['tahun_ajaran'] = tahun_ajaran('lengkap');
        $data['sekolah'] = $datasekolah;
        $data['info'] = $infosekolah;
        $data['nama_user'] = session()->get('nama_user');
        return view('v_admin_dashboard', $data);
    }

    public function input_sekolah()
    {
        if (!khususadmin())
            return redirect()->to("/");
        helper('form');
        $tglsekarang = tanggal_sekarang();
        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $dataadmin = $this->M_user->getAdmin(session()->get('id_user'));
        $status_bayar = $this->ceklunas($id_sekolah, tahun_ajaran());
        $data['sekolah'] = $datasekolah;
        $data['admin'] = $dataadmin;
        $data['status_bayar'] = $status_bayar;
        $data['tanggal'] = $tglsekarang['panjang'];
        $data['tahun_ajaran'] = tahun_ajaran('lengkap');
        $data['nama_user'] = session()->get('nama_user');
        return view('v_admin_input_sekolah', $data);
    }

    public function edit_sekolah()
    {
        if (!khususadmin())
            return redirect()->to("/");
        helper('form');
        $tglsekarang = tanggal_sekarang();
        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $dataadmin = $this->M_user->getAdmin(session()->get('id_user'));
        $status_bayar = $this->ceklunas($id_sekolah, tahun_ajaran());
        $data['sekolah'] = $datasekolah;
        $data['admin'] = $dataadmin;
        $data['status_bayar'] = $status_bayar;
        $data['tanggal'] = $tglsekarang['panjang'];
        $data['tahun_ajaran'] = tahun_ajaran('lengkap');
        $data['nama_user'] = session()->get('nama_user');
        return view('v_admin_edit_sekolah', $data);
    }

    public function simpan_sekolah()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $npsn = ($this->request->getVar('npsn'));
        $nama_sekolah = ($this->request->getVar('nama_sekolah'));
        $alamat_sekolah = ($this->request->getVar('alamat_sekolah'));
        $kelurahan = ($this->request->getVar('kelurahan'));
        $kecamatan = ($this->request->getVar('kecamatan'));
        $kota = ($this->request->getVar('kota'));
        $propinsi = ($this->request->getVar('propinsi'));
        $telp_sekolah = ($this->request->getVar('telp_sekolah'));
        $email_sekolah = ($this->request->getVar('email_sekolah'));
        $nama_admin = ($this->request->getVar('nama_admin'));
        $alamat_admin = ($this->request->getVar('alamat_admin'));
        $telp_admin = ($this->request->getVar('telp_admin'));
        $email_admin = ($this->request->getVar('email_admin'));

        if ($npsn == "" || $npsn == null)
            die();

        $id_sekolah = session()->get('id_sekolah');

        $data = [
            'id_sekolah'    => $id_sekolah,
            'npsn'          => htmlspecialchars($npsn),
            'nama'          => htmlspecialchars($nama_sekolah),
            'alamat'        => htmlspecialchars($alamat_sekolah),
            'kelurahan'     => htmlspecialchars($kelurahan),
            'kecamatan'     => htmlspecialchars($kecamatan),
            'kota'          => htmlspecialchars($kota),
            'propinsi'      => htmlspecialchars($propinsi),
            'telp'          => htmlspecialchars($telp_sekolah),
            'email'         => htmlspecialchars($email_sekolah),
        ];


        $this->M_sekolah->update_sekolah($data, $id_sekolah);

        $data2 = [
            'nama'          => htmlspecialchars($nama_admin),
            'alamat'        => htmlspecialchars($alamat_admin),
            'telp'          => htmlspecialchars($telp_admin),
            'email'         => htmlspecialchars($email_admin),
        ];

        $id_admin = session()->get('id_user');
        $this->M_user->update_admin($data2, $id_admin);

        return redirect()->to("/admin");
    }

    public function user()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $infosekolah = $this->M_sekolah->getInfoSekolah($id_sekolah, tahun_ajaran());


        $getdaftarguru = $this->M_user->getDaftarGuru($id_sekolah, tahun_ajaran());
        if (sizeof($getdaftarguru) == 0) {
            $this->M_user->duplikat_guru_tahun_lalu($id_sekolah, tahun_ajaran());
            $getdaftarguru = $this->M_user->getDaftarGuru($id_sekolah, tahun_ajaran());
        }
        $getdaftarsiswa = $this->M_user->getDaftarSiswa($id_sekolah, tahun_ajaran());

        $getdaftarstaf = $this->M_user->getDaftarStaf($id_sekolah, tahun_ajaran());
        $data['sekolah'] = $datasekolah;
        $data['tahun_ajaran'] = tahun_ajaran('lengkap');
        $data['info'] = $infosekolah;
        $data['nama_user'] = session()->get('nama_user');
        $data['kode_acak'] = rand(100000, 999999);
        $data['dataguru'] = $getdaftarguru;
        $data['datasiswa'] = $getdaftarsiswa;
        $data['datastaf'] = $getdaftarstaf;

        return view('v_admin_user', $data);
    }

    public function siswa_kelas($tahun = null, $kelas = null, $rombel = null)
    {
        if (!khususadmin())
            return redirect()->to("/");

        $pilihantahun = tahun_ajaran();
        $id_sekolah = session()->get('id_sekolah');
        if ($tahun != null)
            $pilihantahun = $tahun;

        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $infosekolah = $this->M_sekolah->getInfoSekolah($id_sekolah, $pilihantahun);

        $dataadmin = $this->M_user->get_admin(session()->get('id_user'));
        $id_sekolah = session()->get('id_sekolah');
        $daftar_kelas = $this->get_daftar_kelas($id_sekolah, tahun_ajaran());

        $pilihantahuntujuan = $pilihantahun;
        if (bulan_sekarang() >= 6)
            $pilihantahuntujuan = tahun_sekarang();

        $daftar_kelas_tujuan = $daftar_kelas; //$this->get_daftar_kelas($id_sekolah, $pilihantahuntujuan);

        if ($kelas == null) {
            $kelas = $daftar_kelas[0];
        }
        $daftar_rombel = $this->M_sekolah->get_rombel_sekolah($id_sekolah, $pilihantahun, $kelas);

        $rombel_pertama = "-";
        if ($daftar_rombel)
            $rombel_pertama = $daftar_rombel[0]->nama_rombel;

        $jumlah_rombel_kosong = 0;
        $getdaftarsiswa = $this->M_user->getDaftarSiswa($id_sekolah, $pilihantahun, $kelas, null);
        foreach ($getdaftarsiswa as $baris) {
            if ($baris['nama_rombel'] == "-")
                $jumlah_rombel_kosong++;
        }
        if ($rombel == null) {
            if ($jumlah_rombel_kosong > 0) {
                $rombel = "-";
            } else {
                $rombel = $rombel_pertama;
            }
        }

        $getdaftarsiswa = $this->M_user->getDaftarSiswa($id_sekolah, $pilihantahun, $kelas, $rombel);
        // echo $rombel;
        // echo var_dump($getdaftarsiswa);
        // die();

        $data['sekolah'] = $datasekolah;
        $data['tahun_ajaran'] = tahun_ajaran('lengkap');
        $data['tahun_mulai'] = $pilihantahun;
        $data['info'] = $infosekolah;
        $data['nama_user'] = session()->get('nama_user');

        $data['daftar_kelas'] = $daftar_kelas;
        $data['daftar_kelas_tujuan'] = $daftar_kelas_tujuan;
        $data['daftar_rombel'] = $daftar_rombel;
        $data['jumlah_rombel_kosong'] = $jumlah_rombel_kosong;
        $data['datasiswa'] = $getdaftarsiswa;
        $data['kelas'] = $kelas;
        $data['rombel'] = $rombel;
        $data['tahun_pilihan'] = $tahun;

        return view('v_admin_siswa_kelas', $data);
    }

    public function info_impor()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $data['sekolah'] = $datasekolah;
        $data['nama_user'] = session()->get('nama_user');
        return view('v_admin_infoimpor', $data);
    }

    public function import($kodeacak, $tahun_ajaran, $pengguna)
    {
        if (!khususadmin())
            return redirect()->to("/");

        $filePath = WRITEPATH . "/uploads/fileexcel" . $kodeacak . ".xlsx";

        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();

        $hasilsukses = "sukses";
        $data = [];
        $data2 = [];

        $id_user = session()->get('id_user');
        $id_sekolah = session()->get('id_sekolah');
        $jumlah_user = 0;

        // GURU =====================================================
        if ($pengguna == "G") {
            foreach ($worksheet->getRowIterator(2) as $row) { // Mulai dari baris kedua
                $rowData = [];
                $saveData = [];
                $saveData2 = [];

                $cellIterator = $row->getCellIterator('B', 'H'); // Mulai dari kolom B hingga G

                foreach ($cellIterator as $cell) {
                    $rowData[] = $cell->getValue();
                }

                $uuid = sprintf(
                    '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                    mt_rand(0, 0xffff),
                    mt_rand(0, 0xffff),
                    mt_rand(0, 0xffff),
                    mt_rand(0, 0x0fff) | 0x4000,
                    mt_rand(0, 0x3fff) | 0x8000,
                    mt_rand(0, 0xffff),
                    mt_rand(0, 0xffff),
                    mt_rand(0, 0xffff)
                );
                $rowData[] = $uuid;

                $id_user = session()->get('id_user');

                $saveData['id_guru'] = $rowData[7];
                $saveData['id_uploader'] = $id_user;
                $saveData['nuptk'] = $rowData[0];
                $saveData['nip'] = $rowData[1];
                $saveData['nama'] = $rowData[2];
                $saveData['alamat'] = $rowData[3];
                $saveData['jenis_kelamin'] = $rowData[4];
                $saveData['telp'] = $rowData[5];
                $saveData['email'] = $rowData[6];
                $saveData['token'] = password_hash('123456', PASSWORD_DEFAULT);

                $saveData2['nuptk'] = $rowData[0];
                $saveData2['id_sekolah'] = $id_sekolah;
                $saveData2['tahun_ajaran'] = $tahun_ajaran;

                if ($rowData[0] != "" && $rowData[0] != null) {
                    if (trim($saveData['jenis_kelamin']) != "L" && trim($saveData['jenis_kelamin']) != "P") {
                        $hasilsukses = "gagal";
                        break;
                    }
                    $jumlah_user++;
                    $data[] = $saveData;
                    $data2[] = $saveData2;
                }
            }

            if ($hasilsukses == "sukses") {
                $this->M_user->simpan_daftar_guru($data);
                $this->M_user->delete_daftar_guru_sekolah($id_sekolah, $tahun_ajaran);
                echo ($this->M_user->simpan_daftar_guru_sekolah($data2));
                echo ($this->M_sekolah->update_jumlah_guru($id_sekolah, $tahun_ajaran, $jumlah_user));
            }

            echo $hasilsukses;
        }

        // SISWA =====================================================
        if ($pengguna == "S") {
            $dataadmin = $this->M_user->get_admin(session()->get('id_user'));
            $jenjang = $dataadmin['jenjang'];
            $daftar_kelas = [];
            foreach ($worksheet->getRowIterator(2) as $row) {
                $rowData = [];
                $saveData = [];
                $saveData2 = [];

                $cellIterator = $row->getCellIterator('B', 'L');

                foreach ($cellIterator as $cell) {
                    $rowData[] = $cell->getValue();
                }

                $uuid = sprintf(
                    '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                    mt_rand(0, 0xffff),
                    mt_rand(0, 0xffff),
                    mt_rand(0, 0xffff),
                    mt_rand(0, 0x0fff) | 0x4000,
                    mt_rand(0, 0x3fff) | 0x8000,
                    mt_rand(0, 0xffff),
                    mt_rand(0, 0xffff),
                    mt_rand(0, 0xffff)
                );
                $rowData[] = $uuid;

                $id_user = session()->get('id_user');

                $tanggal_numerik = $rowData[6] - 1;
                $tanggal_database = date('Y/m/d', strtotime('1900-01-00 +' . $tanggal_numerik . ' days'));

                $saveData['id_siswa'] = $rowData[11];
                $saveData['id_uploader'] = $id_user;
                $saveData['nisn'] = $rowData[0];
                $saveData['nama'] = $rowData[2];
                $saveData['alamat'] = $rowData[4];
                $saveData['tempat_lahir'] = $rowData[5];
                $saveData['tanggal_lahir'] = $tanggal_database;
                $saveData['jenis_kelamin'] = $rowData[7];
                $saveData['agama'] = $rowData[8];
                $saveData['telp'] = $rowData[9];
                $saveData['email'] = $rowData[10];
                $saveData['token'] = password_hash('123456', PASSWORD_DEFAULT);

                $saveData2['nisn'] = $rowData[0];
                $saveData2['nis'] = $rowData[1];
                $saveData2['id_sekolah'] = $id_sekolah;
                $saveData2['tahun_ajaran'] = $tahun_ajaran;
                $saveData2['kelas'] = $rowData[3];

                if ($rowData[0] != "" && $rowData[0] != null) {
                    if (trim($saveData['jenis_kelamin']) != "L" && trim($saveData['jenis_kelamin']) != "P") {
                        $hasilsukses = "gagal";
                        break;
                    }
                    if (in_array($rowData[3], kelasdarijenjang($jenjang))) {
                        $data[] = $saveData;
                        $data2[] = $saveData2;
                        if (!in_array($rowData[3], $daftar_kelas)) {
                            $daftar_kelas[] = $rowData[3];
                        }
                    }
                }
            }

            if ($hasilsukses == "sukses") {
                $this->M_user->simpan_daftar_siswa($data);
                $this->M_user->delete_daftar_siswa_sekolah($id_sekolah, $tahun_ajaran, $daftar_kelas);
                $this->M_user->simpan_daftar_siswa_sekolah($data2);
                $getdaftarsiswa = $this->M_user->getDaftarSiswa($id_sekolah, tahun_ajaran());
                $jumlah_user = sizeof($getdaftarsiswa);
                $this->M_sekolah->update_jumlah_siswa($id_sekolah, $tahun_ajaran, $jumlah_user);
            }

            echo $hasilsukses;
        }

        // STAF =====================================================
        if ($pengguna == "T") {

            foreach ($worksheet->getRowIterator(2) as $row) { // Mulai dari baris kedua
                $rowData = [];
                $saveData = [];
                $saveData2 = [];

                $cellIterator = $row->getCellIterator('B', 'F');

                foreach ($cellIterator as $cell) {
                    $rowData[] = $cell->getValue();
                }

                $uuid = sprintf(
                    '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                    mt_rand(0, 0xffff),
                    mt_rand(0, 0xffff),
                    mt_rand(0, 0xffff),
                    mt_rand(0, 0x0fff) | 0x4000,
                    mt_rand(0, 0x3fff) | 0x8000,
                    mt_rand(0, 0xffff),
                    mt_rand(0, 0xffff),
                    mt_rand(0, 0xffff)
                );
                $rowData[] = $uuid;

                $id_user = session()->get('id_user');

                $saveData['id_staf'] = $rowData[5];
                $saveData['id_uploader'] = $id_user;
                $saveData['nama'] = $rowData[0];
                $saveData['alamat'] = $rowData[1];
                $saveData['jenis_kelamin'] = $rowData[2];
                $saveData['telp'] = $rowData[3];
                $saveData['email'] = $rowData[4];
                $saveData['token'] = password_hash('123456', PASSWORD_DEFAULT);

                $saveData2['email'] = $rowData[4];
                $saveData2['id_sekolah'] = $id_sekolah;
                $saveData2['tahun_ajaran'] = $tahun_ajaran;

                if ($rowData[0] != "" && $rowData[0] != null) {
                    if (trim($saveData['jenis_kelamin']) != "L" && trim($saveData['jenis_kelamin']) != "P") {
                        $hasilsukses = "gagal";
                        break;
                    }
                    $jumlah_user++;
                    $data[] = $saveData;
                    $data2[] = $saveData2;
                }
            }

            if ($hasilsukses == "sukses") {
                $this->M_user->simpan_daftar_staf($data);
                $this->M_user->delete_daftar_staf_sekolah($id_sekolah, $tahun_ajaran);
                $this->M_user->simpan_daftar_staf_sekolah($data2);
                $this->M_sekolah->update_jumlah_staf($id_sekolah, $tahun_ajaran, $jumlah_user);
            }

            echo $hasilsukses;
        }
    }

    public function unduh_data_guru()
    {
        $alamatdata = "./assets/template/format_data_guru.xlsx";
        return $this->response->download($alamatdata, null);
    }

    public function unduh_data_siswa()
    {
        $dataadmin = $this->M_user->get_admin(session()->get('id_user'));
        $jenjang = strtolower($dataadmin['jenjang']);
        $alamatdata = "./assets/template/format_data_siswa_" . $jenjang . ".xlsx";
        return $this->response->download($alamatdata, null);
    }

    public function unduh_data_staf()
    {
        $alamatdata = "./assets/template/format_data_staf.xlsx";
        return $this->response->download($alamatdata, null);
    }

    public function upload_data($kodeacak)
    {
        if (!khususadmin())
            return redirect()->to("/");

        $uploadedFile = $this->request->getFile('file');
        $tahun_ajaran = $this->request->getVar('tahun_ajaran');
        $pengguna = $this->request->getVar('pengguna');

        if ($uploadedFile->isValid() && !$uploadedFile->hasMoved()) {
            $uploadedFile->move(WRITEPATH . 'uploads', 'fileexcel' . $kodeacak . '.xlsx');

            $this->import($kodeacak, $tahun_ajaran, $pengguna);

            unlink(WRITEPATH . 'uploads\fileexcel' . $kodeacak . '.xlsx');

            // return $this->response->setJSON(['success' => true]);
        } else {
            // return $this->response->setJSON(['success' => false]);
            return "gagal";
        }
    }

    // GURU ==========================================================
    public function tambah_guru()
    {
        if (!khususadmin())
            return redirect()->to("/");

        helper('form');
        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $data['sekolah'] = $datasekolah;
        $data['tahun_ajaran'] = tahun_ajaran('lengkap');
        $data['nama_user'] = session()->get('nama_user');
        return view('v_admin_guru_input', $data);
    }

    public function edit_guru($id_guru)
    {
        if (!khususadmin())
            return redirect()->to("/");

        helper('form');
        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $data['sekolah'] = $datasekolah;
        $data['tahun_ajaran'] = tahun_ajaran('lengkap');
        $data['nama_user'] = session()->get('nama_user');
        $data['data_guru'] = $this->M_user->getDataGuru($id_guru);
        $data['id_guru'] = $id_guru;
        return view('v_admin_guru_edit', $data);
    }

    public function simpan_guru()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $nuptk = ($this->request->getVar('nuptk'));
        $nama = ($this->request->getVar('nama'));
        $alamat = ($this->request->getVar('alamat'));
        $jenis_kelamin = ($this->request->getVar('jenis_kelamin'));
        $telp = ($this->request->getVar('telp'));
        $email = ($this->request->getVar('email'));

        $uuid = sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );

        $data = [
            'id_uploader'   => session()->get('id_user'),
            'id_guru'       => $uuid,
            'nuptk'         => htmlspecialchars($nuptk),
            'nama'          => htmlspecialchars($nama),
            'alamat'        => htmlspecialchars($alamat),
            'jenis_kelamin' => htmlspecialchars($jenis_kelamin),
            'telp'          => htmlspecialchars($telp),
            'email'         => htmlspecialchars($email),
            'token'         => password_hash('123456', PASSWORD_DEFAULT),
        ];

        $id_sekolah = session()->get('id_sekolah');
        $tahun_ajaran = $this->request->getVar('tahun_ajaran');
        $data2 = [
            'nuptk' => htmlspecialchars($nuptk),
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
        ];

        $this->M_user->tambah_guru($data);
        $this->M_user->tambah_guru_sekolah($data2);
        $getdaftarguru = $this->M_user->getDaftarGuru($id_sekolah, tahun_ajaran());
        $jumlah_user = sizeof($getdaftarguru);
        $this->M_sekolah->update_jumlah_guru($id_sekolah, $tahun_ajaran, $jumlah_user);

        return redirect()->to("/admin/user");
    }

    public function update_guru()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_guru = ($this->request->getVar('id_guru'));
        $nuptk = ($this->request->getVar('nuptk'));
        $nama = ($this->request->getVar('nama'));
        $alamat = ($this->request->getVar('alamat'));
        $jenis_kelamin = ($this->request->getVar('jenis_kelamin'));
        $telp = ($this->request->getVar('telp'));
        $email = ($this->request->getVar('email'));

        $data = [
            'id_uploader'   => session()->get('id_user'),
            'nuptk'         => htmlspecialchars($nuptk),
            'nama'          => htmlspecialchars($nama),
            'alamat'        => htmlspecialchars($alamat),
            'jenis_kelamin' => htmlspecialchars($jenis_kelamin),
            'telp'          => htmlspecialchars($telp),
            'email'         => htmlspecialchars($email),
        ];

        $this->M_user->update_guru($data, $id_guru);

        return redirect()->to("/admin/user");
    }

    public function hapus_guru_sekolah()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_guru = $this->request->getVar('id_guru');
        $id_sekolah = session()->get('id_sekolah');
        $tahun_ajaran = substr($this->request->getVar('tahun_ajaran'), 0, 4);
        $getdataguru = $this->M_user->getDataGuru($id_guru);
        $nuptk = $getdataguru['nuptk'];

        $this->M_user->hapus_guru_sekolah($nuptk, $id_sekolah, $tahun_ajaran);
        $getdaftarguru = $this->M_user->getDaftarGuru($id_sekolah, tahun_ajaran());
        $jumlah_user = sizeof($getdaftarguru);
        $this->M_sekolah->update_jumlah_guru($id_sekolah, $tahun_ajaran, $jumlah_user);
    }


    public function cek_nuptk_sekolah()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $nuptk = $this->request->getPost('nuptk');
        $cek_nuptk = $this->M_user->cek_nuptk($nuptk);
        if ($cek_nuptk) {
            echo "ada";
        } else {
            echo "aman";
        }
    }

    public function eksporDataGuru()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $daftarguru = $this->M_user->getDaftarGuru($id_sekolah, tahun_ajaran());
        $getsekolah = $this->M_sekolah->getSekolah($id_sekolah);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', "No");
        $sheet->setCellValue('B1', "NUPTK");
        $sheet->setCellValue('C1', "NIP");
        $sheet->setCellValue('D1', "Nama");
        $sheet->setCellValue('E1', "Alamat");
        $sheet->setCellValue('F1', "Jenis Kelamin");
        $sheet->setCellValue('G1', "Telp");
        $sheet->setCellValue('H1', "Email");

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(22);
        $sheet->getColumnDimension('E')->setWidth(35);
        $sheet->getColumnDimension('F')->setWidth(12);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(20);

        $style = $sheet->getStyle('A1:H1');
        $style->getFont()->setBold(true);
        $style->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $style = $sheet->getStyle('F2:F100');
        $style->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $range = 'B2:H100';
        $sheet->getStyle($range)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);

        $spreadsheet->getProperties()
            ->setCreator($getsekolah['nama'])
            ->setTitle('Data Guru');

        $spreadsheet->getActiveSheet()->setTitle('Guru');
        $spreadsheet->getActiveSheet()->setSelectedCell('A1');

        $row = 2;
        foreach ($daftarguru as $item) {

            $sheet->setCellValue('A' . $row, ($row - 1));
            $sheet->setCellValueExplicit('B' . $row, $item['nuptk'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('C' . $row, $item['nip'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('D' . $row, $item['nama']);
            $sheet->setCellValue('E' . $row, $item['alamat']);
            $sheet->setCellValue('F' . $row, $item['jenis_kelamin']);
            $sheet->setCellValueExplicit('G' . $row, $item['telp'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('H' . $row, $item['email']);
            $row++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="ekspor_data_guru.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    // SISWA ==========================================================
    public function tambah_siswa()
    {
        if (!khususadmin())
            return redirect()->to("/");

        helper('form');
        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $datarombel = $this->M_sekolah->get_rombel_sekolah($id_sekolah, tahun_ajaran());
        $dataadmin = $this->M_user->get_admin(session()->get('id_user'));
        $jenjang = $dataadmin['jenjang'];
        $data['sekolah'] = $datasekolah;
        $data['tahun_ajaran'] = tahun_ajaran('lengkap');
        $data['nama_user'] = session()->get('nama_user');
        $data['data_rombel'] = $datarombel;
        $data['kelas'] = kelasdarijenjang($jenjang);
        return view('v_admin_siswa_input', $data);
    }

    public function edit_siswa($id_siswa)
    {
        if (!khususadmin())
            return redirect()->to("/");

        helper('form');
        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $datarombel = $this->M_sekolah->get_rombel_sekolah($id_sekolah, tahun_ajaran());
        $dataadmin = $this->M_user->get_admin(session()->get('id_user'));
        $jenjang = $dataadmin['jenjang'];
        $data['sekolah'] = $datasekolah;
        $data['tahun_ajaran'] = tahun_ajaran('lengkap');
        $data['nama_user'] = session()->get('nama_user');
        $data['data_siswa'] = $this->M_user->getDataSiswa($id_siswa, tahun_ajaran());
        $data['id_siswa'] = $id_siswa;
        $data['data_rombel'] = $datarombel;
        $data['kelas'] = kelasdarijenjang($jenjang);
        return view('v_admin_siswa_edit', $data);
    }

    public function simpan_siswa()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $nisn = ($this->request->getVar('nisn'));
        $nis = ($this->request->getVar('nis'));
        $nama = ($this->request->getVar('nama'));
        $alamat = ($this->request->getVar('alamat'));
        $kelas = ($this->request->getVar('kelas'));
        $tempat_lahir = ($this->request->getVar('tempat_lahir'));
        $tanggal_lahir_0 = ($this->request->getVar('tanggal_lahir'));
        $tanggal_lahir_exp = explode("-", $tanggal_lahir_0);
        $tanggal_lahir = $tanggal_lahir_exp[2] . "-" . $tanggal_lahir_exp[1] . "-" . $tanggal_lahir_exp[0];
        $jenis_kelamin = ($this->request->getVar('jenis_kelamin'));
        $agama = ($this->request->getVar('agama'));
        $telp = ($this->request->getVar('telp'));
        $email = ($this->request->getVar('email'));
        $uuid = sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );

        $data = [
            'id_siswa'      => $uuid,
            'id_uploader'   => session()->get('id_user'),
            'nisn'          => htmlspecialchars($nisn),
            'nama'          => htmlspecialchars($nama),
            'alamat'        => htmlspecialchars($alamat),
            'tempat_lahir'  => htmlspecialchars($tempat_lahir),
            'tanggal_lahir' => htmlspecialchars($tanggal_lahir),
            'jenis_kelamin' => htmlspecialchars($jenis_kelamin),
            'agama'         => htmlspecialchars($agama),
            'telp'          => htmlspecialchars($telp),
            'email'         => htmlspecialchars($email),
            'token'         => password_hash('123456', PASSWORD_DEFAULT),
        ];

        $id_sekolah = session()->get('id_sekolah');
        $tahun_ajaran = $this->request->getVar('tahun_ajaran');
        $data2 = [
            'nisn'          => htmlspecialchars($nisn),
            'id_sekolah'    => $id_sekolah,
            'nis'           => htmlspecialchars($nis),
            'kelas'         => htmlspecialchars($kelas),
            'tahun_ajaran'  => $tahun_ajaran,
        ];

        $this->M_user->tambah_siswa($data);
        $this->M_user->tambah_siswa_sekolah($data2);
        $getdaftarsiswa = $this->M_user->getDaftarSiswa($id_sekolah, tahun_ajaran());
        $jumlah_user = sizeof($getdaftarsiswa);
        $this->M_sekolah->update_jumlah_siswa($id_sekolah, $tahun_ajaran, $jumlah_user);

        return redirect()->to("/admin/user");
    }

    public function update_siswa()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_siswa = ($this->request->getVar('id_siswa'));
        $nisn = ($this->request->getVar('nisn'));
        $nis = ($this->request->getVar('nis'));
        $nama = ($this->request->getVar('nama'));
        $kelas = ($this->request->getVar('kelas'));
        $alamat = ($this->request->getVar('alamat'));
        $tempat_lahir = ($this->request->getVar('tempat_lahir'));
        $tanggal_lahir_0 = ($this->request->getVar('tanggal_lahir'));
        $tanggal_lahir_exp = explode("-", $tanggal_lahir_0);
        $tanggal_lahir = $tanggal_lahir_exp[2] . "-" . $tanggal_lahir_exp[1] . "-" . $tanggal_lahir_exp[0];
        $jenis_kelamin = ($this->request->getVar('jenis_kelamin'));
        $agama = ($this->request->getVar('agama'));
        $telp = ($this->request->getVar('telp'));
        $email = ($this->request->getVar('email'));

        $data = [
            'id_uploader'   => session()->get('id_user'),
            'id_siswa'      => htmlspecialchars($id_siswa),
            'nisn'          => htmlspecialchars($nisn),
            'nama'          => htmlspecialchars($nama),
            'alamat'        => htmlspecialchars($alamat),
            'tempat_lahir'  => htmlspecialchars($tempat_lahir),
            'tanggal_lahir' => htmlspecialchars($tanggal_lahir),
            'jenis_kelamin' => htmlspecialchars($jenis_kelamin),
            'agama'         => htmlspecialchars($agama),
            'telp'          => htmlspecialchars($telp),
            'email'         => htmlspecialchars($email),
        ];

        $data2 = [
            'nis'           => htmlspecialchars($nis),
            'kelas'         => htmlspecialchars($kelas),
        ];

        $id_sekolah = session()->get('id_sekolah');
        $this->M_user->update_siswa($data, $id_siswa);
        $this->M_user->update_siswa_sekolah($data2, $nisn, $id_sekolah, tahun_ajaran());

        return redirect()->to("/admin/user");
    }

    public function hapus_siswa_sekolah()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_siswa = $this->request->getVar('id_siswa');
        $id_sekolah = session()->get('id_sekolah');
        $tahun_ajaran = substr($this->request->getVar('tahun_ajaran'), 0, 4);
        $getdatasiswa = $this->M_user->getDataSiswa($id_siswa, tahun_ajaran());
        $nisn = $getdatasiswa['nisn'];

        $this->M_user->hapus_siswa_sekolah($nisn, $id_sekolah, $tahun_ajaran);
        $getdaftarsiswa = $this->M_user->getDaftarSiswa($id_sekolah, tahun_ajaran());
        $jumlah_user = sizeof($getdaftarsiswa);
        $this->M_sekolah->update_jumlah_siswa($id_sekolah, $tahun_ajaran, $jumlah_user);
    }

    public function cek_npsn()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $npsn = $this->request->getPost('inpsn');
        $cek_npsn = $this->M_sekolah->cek_npsn($npsn);
        $data = [];

        if ($cek_npsn) {
            $data['pesan'] = "ada";
        } else {
            $getsekolah = $this->M_sekolah->getdatasekolahbaru($npsn);
            if ($getsekolah) {
                $data['pesan'] = "aman";
                $data['npsn'] = $getsekolah['npsn'];
                $data['nama_sekolah'] = $getsekolah['nama_sekolah'];
                $data['alamat_sekolah'] = $getsekolah['alamat_sekolah'];
                $data['kelurahan'] = $getsekolah['desa'];
                $data['kecamatan'] = $getsekolah['kecamatan'];
                $data['nama_kota'] = $getsekolah['nama_kota'];
                $data['nama_propinsi'] = $getsekolah['nama_propinsi'];
            } else {
                $data['pesan'] = $npsn . "abc";
            }
        }

        echo json_encode($data);
    }

    public function cek_nisn_sekolah()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $nisn = $this->request->getPost('nisn');
        $cek_nisn = $this->M_user->cek_nisn($nisn);
        if ($cek_nisn) {
            echo "ada";
        } else {
            echo "aman";
        }
    }

    public function cek_nis_sekolah()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $nis = $this->request->getPost('nis');
        $cek_nis = $this->M_user->cek_nis($nis);
        if ($cek_nis) {
            echo "ada";
        } else {
            echo "aman";
        }
    }

    public function eksporDataSiswa()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $daftarsiswa = $this->M_user->getDaftarSiswa($id_sekolah, tahun_ajaran());
        $jumlah_data = sizeof($daftarsiswa);

        $getsekolah = $this->M_sekolah->getSekolah($id_sekolah);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', "No");
        $sheet->setCellValue('B1', "NISN");
        $sheet->setCellValue('C1', "NIS");
        $sheet->setCellValue('D1', "Nama");
        $sheet->setCellValue('E1', "Kelas");
        $sheet->setCellValue('F1', "Alamat");
        $sheet->setCellValue('G1', "Tempat Lahir");
        $sheet->setCellValue('H1', "Tanggal Lahir");
        $sheet->setCellValue('I1', "Jenis Kelamin");
        $sheet->setCellValue('J1', "Agama");
        $sheet->setCellValue('K1', "Telp");
        $sheet->setCellValue('L1', "Email");

        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(11);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(6);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(13);
        $sheet->getColumnDimension('I')->setWidth(13);
        $sheet->getColumnDimension('J')->setWidth(13);
        $sheet->getColumnDimension('K')->setWidth(12);
        $sheet->getColumnDimension('L')->setWidth(20);

        $style = $sheet->getStyle('A1:L1');
        $style->getFont()->setBold(true);
        $style->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $style = $sheet->getStyle('C2:C' . ($jumlah_data + 5));
        $style->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $style = $sheet->getStyle('E2:E' . ($jumlah_data + 5));
        $style->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $style = $sheet->getStyle('H2:I' . ($jumlah_data + 5));
        $style->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $range = 'B2:G' . ($jumlah_data + 5);
        $sheet->getStyle($range)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);

        $range = 'H2:H' . ($jumlah_data + 5);
        $sheet->getStyle($range)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);

        $range = 'I2:L' . ($jumlah_data + 5);
        $sheet->getStyle($range)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);

        $spreadsheet->getProperties()
            ->setCreator($getsekolah['nama'])
            ->setTitle('Data Siswa');

        $spreadsheet->getActiveSheet()->setTitle('Siswa');
        $spreadsheet->getActiveSheet()->setSelectedCell('A1');

        $row = 2;
        foreach ($daftarsiswa as $item) {

            $sheet->setCellValue('A' . $row, ($row - 1));
            $sheet->setCellValueExplicit('B' . $row, $item['nisn'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('C' . $row, $item['nis']);
            $sheet->setCellValue('D' . $row, $item['nama']);
            $sheet->setCellValue('E' . $row, $item['kelas']);
            $sheet->setCellValue('F' . $row, $item['alamat']);
            $sheet->setCellValue('G' . $row, $item['tempat_lahir']);
            $sheet->setCellValueExplicit('H' . $row, $item['tanggal_lahir'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_ISO_DATE);
            $sheet->setCellValue('I' . $row, $item['jenis_kelamin']);
            $sheet->setCellValue('J' . $row, $item['agama']);
            $sheet->setCellValueExplicit('K' . $row, $item['telp'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('L' . $row, $item['email']);
            $row++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="ekspor_data_siswa.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    // staf ==========================================================
    public function tambah_staf()
    {
        if (!khususadmin())
            return redirect()->to("/");

        helper('form');
        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $data['sekolah'] = $datasekolah;
        $data['tahun_ajaran'] = tahun_ajaran('lengkap');
        $data['nama_user'] = session()->get('nama_user');
        return view('v_admin_staf_input', $data);
    }

    public function edit_staf($id_staf)
    {
        if (!khususadmin())
            return redirect()->to("/");

        helper('form');
        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $data['sekolah'] = $datasekolah;
        $data['tahun_ajaran'] = tahun_ajaran('lengkap');
        $data['nama_user'] = session()->get('nama_user');
        $data['data_staf'] = $this->M_user->getDataStaf($id_staf);
        $data['id_staf'] = $id_staf;
        return view('v_admin_staf_edit', $data);
    }

    public function simpan_staf()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $uuid = sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );

        $nama = ($this->request->getVar('nama'));
        $alamat = ($this->request->getVar('alamat'));
        $jenis_kelamin = ($this->request->getVar('jenis_kelamin'));
        $telp = ($this->request->getVar('telp'));
        $email = ($this->request->getVar('email'));

        $data = [
            'id_uploader'   => session()->get('id_user'),
            'id_staf'       => htmlspecialchars($uuid),
            'nama'          => htmlspecialchars($nama),
            'alamat'        => htmlspecialchars($alamat),
            'jenis_kelamin' => htmlspecialchars($jenis_kelamin),
            'telp'          => htmlspecialchars($telp),
            'email'         => htmlspecialchars($email),
            'token'         => password_hash('123456', PASSWORD_DEFAULT),
        ];

        $id_sekolah = session()->get('id_sekolah');
        $tahun_ajaran = $this->request->getVar('tahun_ajaran');
        $data2 = [
            'email'         => htmlspecialchars($email),
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
        ];

        $this->M_user->tambah_staf($data);
        $this->M_user->tambah_staf_sekolah($data2);
        $getdaftarstaf = $this->M_user->getDaftarStaf($id_sekolah, tahun_ajaran());
        $jumlah_user = sizeof($getdaftarstaf);
        $this->M_sekolah->update_jumlah_staf($id_sekolah, $tahun_ajaran, $jumlah_user);

        return redirect()->to("/admin/user");
    }

    public function update_staf()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_staf = ($this->request->getVar('id_staf'));
        $nama = ($this->request->getVar('nama'));
        $alamat = ($this->request->getVar('alamat'));
        $jenis_kelamin = ($this->request->getVar('jenis_kelamin'));
        $telp = ($this->request->getVar('telp'));
        $email = ($this->request->getVar('email'));
        $email_lama = ($this->request->getVar('email_lama'));

        $data = [
            'id_uploader'   => session()->get('id_user'),
            'nama'          => htmlspecialchars($nama),
            'alamat'        => htmlspecialchars($alamat),
            'jenis_kelamin' => htmlspecialchars($jenis_kelamin),
            'telp'          => htmlspecialchars($telp),
            'email'         => htmlspecialchars($email),
        ];

        $data2 = [
            'email'         => htmlspecialchars($email),
        ];

        $this->M_user->update_staf($data, $id_staf);
        $this->M_user->update_staf_sekolah($data2, $email_lama);

        return redirect()->to("/admin/user");
    }

    public function hapus_staf_sekolah()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_staf = $this->request->getVar('id_staf');
        $id_sekolah = session()->get('id_sekolah');
        $tahun_ajaran = substr($this->request->getVar('tahun_ajaran'), 0, 4);
        $getdatastaf = $this->M_user->getDataStaf($id_staf);
        $email = $getdatastaf['email'];

        $this->M_user->hapus_staf_sekolah($email, $id_sekolah, $tahun_ajaran);
        $getdaftarstaf = $this->M_user->getDaftarStaf($id_sekolah, tahun_ajaran());
        $jumlah_user = sizeof($getdaftarstaf);
        $this->M_sekolah->update_jumlah_staf($id_sekolah, $tahun_ajaran, $jumlah_user);
    }

    public function reset_guru_pass()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_guru = $this->request->getVar('id_guru');
        $data = [
            'token'         => password_hash('123456', PASSWORD_DEFAULT)
        ];

        $this->M_user->update_guru($data, $id_guru);
    }

    public function reset_siswa_pass()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_siswa = $this->request->getVar('id_siswa');
        $data = [
            'token'         => password_hash('123456', PASSWORD_DEFAULT)
        ];

        $this->M_user->update_siswa($data, $id_siswa);
    }

    public function reset_staf_pass()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_staf = $this->request->getVar('id_staf');
        $data = [
            'token'         => password_hash('123456', PASSWORD_DEFAULT)
        ];

        $this->M_user->update_staf($data, $id_staf);
    }

    public function cek_email_sekolah()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $email = $this->request->getPost('email');
        $cek_email = $this->M_user->cek_email($email);
        if ($cek_email) {
            echo "ada";
        } else {
            echo "aman";
        }
    }

    public function eksporDataStaf()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $daftarstaf = $this->M_user->getDaftarStaf($id_sekolah, tahun_ajaran());

        $getsekolah = $this->M_sekolah->getSekolah($id_sekolah);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', "No");
        $sheet->setCellValue('B1', "Nama");
        $sheet->setCellValue('C1', "Alamat");
        $sheet->setCellValue('D1', "Jenis Kelamin");
        $sheet->setCellValue('E1', "Telp");
        $sheet->setCellValue('F1', "Email");

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(22);
        $sheet->getColumnDimension('C')->setWidth(35);
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(20);

        $style = $sheet->getStyle('A1:F1');
        $style->getFont()->setBold(true);
        $style->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $style = $sheet->getStyle('D2:D100');
        $style->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $range = 'B2:F100';
        $sheet->getStyle($range)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);

        $spreadsheet->getProperties()
            ->setCreator($getsekolah['nama'])
            ->setTitle('Data Staf');

        $spreadsheet->getActiveSheet()->setTitle('Staf');
        $spreadsheet->getActiveSheet()->setSelectedCell('A1');

        $row = 2;
        foreach ($daftarstaf as $item) {
            $sheet->setCellValue('A' . $row, ($row - 1));
            $sheet->setCellValue('B' . $row, $item['nama']);
            $sheet->setCellValue('C' . $row, $item['alamat']);
            $sheet->setCellValue('D' . $row, $item['jenis_kelamin']);
            $sheet->setCellValueExplicit('E' . $row, $item['telp'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('F' . $row, $item['email']);
            $row++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="ekspor_data_staf.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    public function rombel()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $dataadmin = $this->M_user->get_admin(session()->get('id_user'));
        $jenjang = $dataadmin['jenjang'];
        $daftar_kelas = kelasdarijenjang($jenjang);
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $daftar_sub_kelas = $this->get_daftar_sub_kelas($id_sekolah, tahun_ajaran());
        $daftar_guru = $this->M_user->getDaftarGuru($id_sekolah, tahun_ajaran());
        $daftar_rombel = $this->M_sekolah->get_rombel_sekolah($id_sekolah, tahun_ajaran());
        if (sizeof($daftar_rombel) == 0) {
            $this->M_sekolah->duplikat_rombel_tahun_lalu($id_sekolah, tahun_ajaran());
            $daftar_rombel = $this->M_sekolah->get_rombel_sekolah($id_sekolah, tahun_ajaran());
        }

        // echo "<pre>";
        // echo var_dump($daftar_kelas);
        // echo "</pre>";

        $data['sekolah'] = $datasekolah;
        $data['tahun_ajaran'] = tahun_ajaran('lengkap');
        $data['nama_user'] = session()->get('nama_user');
        $data['daftar_kelas'] = $daftar_kelas;
        $data['daftar_guru'] = json_encode($daftar_guru);
        $data['daftar_sub_kelas'] = $daftar_sub_kelas;
        $data['daftar_rombel'] = $daftar_rombel;

        return view('v_admin_rombel', $data);
    }

    public function get_rombel_mapel()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $dataMapel = json_decode(file_get_contents('php://input'), true);

        $tahun_ajaran = $dataMapel['tahunsekarang'];
        $kelas = $dataMapel['kelas'];
        $subkelas = $dataMapel['pilihan'];
        $id_guru = $dataMapel['guru'];
        $id_mapel = $dataMapel['mapel'];

        $datarombel = $this->M_sekolah->get_rombel_mapel($id_sekolah, $tahun_ajaran, $kelas, $subkelas, $id_guru, $id_mapel);
        echo json_encode($datarombel);
        // $response = ['message' => $id_mapel];
        // return $this->response->setJSON($response);
    }

    public function simpan_rombel_sekolah()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $dataToSave = json_decode(file_get_contents('php://input'), true);

        $id_sekolah = session()->get('id_sekolah');
        $this->M_sekolah->hapus_rombel_sekolah($id_sekolah, tahun_ajaran());

        foreach ($dataToSave as $item) {
            $kelas = $item['kelas'];
            $rombel = $item['rombel'];
            $this->M_sekolah->tambah_rombel_sekolah($id_sekolah, $kelas, $rombel, tahun_ajaran());
        }

        // Setelah melakukan operasi yang diperlukan, Anda dapat memberikan respons kembali ke klien:
        $response = ['message' => 'Data berhasil disimpan'];
        return $this->response->setJSON($response);
    }

    public function simpan_rombel()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $dataToSave = json_decode(file_get_contents('php://input'), true);

        $id_sekolah = session()->get('id_sekolah');

        $kelas = $dataToSave['kelas'];
        $sub_kelas = $dataToSave['sub_kelas'];
        $rombel = $dataToSave['rombel'];
        $nuptk_wali_kelas = $dataToSave['nuptk_wali_kelas'];
        $this->M_sekolah->tambah_rombel_sekolah($id_sekolah, $kelas, $sub_kelas, $rombel, $nuptk_wali_kelas, tahun_ajaran());

        // Setelah melakukan operasi yang diperlukan, Anda dapat memberikan respons kembali ke klien:
        $response = ['message' => "Berhasil disimpan"];
        return $this->response->setJSON($response);
    }

    public function update_rombel()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $dataToSave = json_decode(file_get_contents('php://input'), true);

        $id_sekolah = session()->get('id_sekolah');

        $kelas = $dataToSave['kelas'];
        $sub_kelas = $dataToSave['sub_kelas'];
        $rombel = $dataToSave['rombel'];
        $rombellama = $dataToSave['rombellama'];
        $nuptk_wali_kelas = $dataToSave['nuptk_wali_kelas'];

        $this->M_sekolah->update_rombel_sekolah($id_sekolah, $kelas, $sub_kelas, $rombellama, $rombel, $nuptk_wali_kelas, tahun_ajaran());

        // Setelah melakukan operasi yang diperlukan, Anda dapat memberikan respons kembali ke klien:
        $response = ['message' => $kelas . "-" . $rombel . "-" . $rombellama];
        return $this->response->setJSON($response);
    }

    public function naik_kelas()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $data['sekolah'] = $datasekolah;
        $data['tahun_ajaran'] = tahun_ajaran('lengkap');
        $data['nama_user'] = session()->get('nama_user');
        return view('v_admin_siswa_naikkelas', $data);
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

    public function get_daftar_sub_kelas($id_sekolah, $tahun_ajaran)
    {
        $datamapel = $this->M_sekolah->get_daftar_mapel($id_sekolah, $tahun_ajaran);
        $daftar_sub_kelas = [];
        foreach ($datamapel as $row) {
            if (!in_array('[' . $row["kelas"] . ', "' . $row["sub_kelas"] . '"]', $daftar_sub_kelas)) {
                if (($row["kelas"] == 11 || $row["kelas"] == 12) && $row["sub_kelas"] == "-") {
                } else
                    $daftar_sub_kelas[] = '[' . $row["kelas"] . ', "' . $row["sub_kelas"] . '"]';
            }
        }
        return $daftar_sub_kelas;
    }

    public function ambil_daftar_kelas($id_sekolah, $tahun_ajaran)
    {
        $datarombel = $this->M_sekolah->get_rombel_sekolah($id_sekolah, $tahun_ajaran);
        $daftar_kelas = [];
        foreach ($datarombel as $row) {
            if (!in_array($row->kelas, $daftar_kelas)) {
                $daftar_kelas[] = $row->kelas;
            }
        }
        return json_encode($daftar_kelas);
    }

    public function get_rombel_kelas($tahun_ajaran, $kelas)
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $jumlah_rombel_kosong = 0;
        $getdaftarsiswa = $this->M_user->getDaftarSiswa($id_sekolah, $tahun_ajaran, $kelas, null);
        foreach ($getdaftarsiswa as $baris) {
            if ($baris['nama_rombel'] == "-")
                $jumlah_rombel_kosong++;
        }

        $datarombel = $this->M_sekolah->get_rombel_sekolah($id_sekolah, $tahun_ajaran, $kelas);
        if ($jumlah_rombel_kosong > 0) {
            $rombel = "-";
            $datarombel['rombel_kosong'] = $rombel;
        }


        return json_encode($datarombel);
    }

    public function get_sub_kelas_mapel($kelas)
    {
        $id_sekolah = session()->get('id_sekolah');
        $datasubkelas = $this->M_sekolah->get_sub_kelas_mapel($id_sekolah, tahun_ajaran(), $kelas);
        return json_encode($datasubkelas);
    }

    public function get_mapel($kelas, $subkelas)
    {
        $id_sekolah = session()->get('id_sekolah');
        $datamapel = $this->M_sekolah->get_daftar_mapel($id_sekolah, tahun_ajaran(), $kelas, $subkelas);
        return json_encode($datamapel);
    }

    public function get_daftar_siswa()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $kelas = $this->request->getVar('kelas');
        $rombel = $this->request->getVar('rombel');
        $tahun_ajaran = $this->request->getVar('tahun_ajaran');

        // echo "id_sekolah: $id_sekolah, kelas: $kelas, rombel: $rombel, tahun_ajaran: $tahun_ajaran";

        $datarombel = $this->M_sekolah->get_daftar_siswa($id_sekolah, $kelas, $rombel, $tahun_ajaran);

        return json_encode($datarombel);
    }

    public function simpan_siswa_pindah()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $dataSiswa = json_decode(file_get_contents('php://input'), true);

        foreach ($dataSiswa as $siswa) {
            $nis = $siswa['nis'];
            $nisn = $siswa['nisn'];
            $kelasasal = $siswa['kelas'];
            $rombelasal = $siswa['rombel'];
            $tahunasal = $siswa['tahun'];
            $kelastujuan = $siswa['kelastujuan'];
            $rombeltujuan = $siswa['rombeltujuan'];
            $tahuntujuan = $siswa['tahuntujuan'];

            $dafsiswa = ['nisn' => $nisn, 'id_sekolah' => $id_sekolah, 'nis' => $nis, 'kelas' => $kelastujuan, 'nama_rombel' => $rombeltujuan, 'tahun_ajaran' => $tahuntujuan];

            if ($tahunasal == $tahuntujuan) {
                $this->M_user->update_siswa_sekolah($dafsiswa, $nisn, $id_sekolah, $tahunasal);
            } else {
                $statuspindah = ['status_pindah' => 1];
                $this->M_user->update_siswa_sekolah($statuspindah, $nisn, $id_sekolah, $tahunasal);
                $this->M_user->tambah_siswa_sekolah($dafsiswa);
            }
        }

        $response = ['message' => 'Data siswa berhasil disimpan'];
        return $this->response->setJSON($response);
    }

    public function mapel()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $this->cekdaftarmapel();

        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $dataadmin = $this->M_user->get_admin(session()->get('id_user'));
        $jenjang = $dataadmin['jenjang'];
        $daftar_kelas = kelasdarijenjang($jenjang);
        $daftar_mapel = $this->M_sekolah->get_daftar_mapel($id_sekolah, tahun_ajaran());
        $data['sekolah'] = $datasekolah;
        $data['tahun_ajaran'] = tahun_ajaran('lengkap');
        $data['nama_user'] = session()->get('nama_user');
        $data['daftar_kelas'] = $daftar_kelas;
        $data['daftar_mapel'] = $daftar_mapel;

        return view('v_admin_mapel', $data);
    }

    public function cekdaftarmapel()
    {
        $id_sekolah = session()->get('id_sekolah');
        $dataadmin = $this->M_user->get_admin(session()->get('id_user'));
        $jenjang = $dataadmin['jenjang'];
        $cekmapel = $this->M_sekolah->cek_mapel($id_sekolah, tahun_ajaran(), kelasdarijenjang($jenjang)[0]);
        if (!$cekmapel) {
            $this->M_sekolah->hapus_semuamapel($id_sekolah, tahun_ajaran());
            foreach (kelasdarijenjang($jenjang) as $kelas) {
                $this->M_sekolah->impor_mapel($id_sekolah, tahun_ajaran(), $kelas);
            }
        }
    }

    public function mapel_pilihan()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $kelas = $_GET['kelas'];
        $sub_kelas = $_GET['sub_kelas'];

        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $dafmapelpilihan = $this->M_sekolah->get_daftar_mapel_pilihan($id_sekolah, tahun_ajaran(), $kelas, $sub_kelas);
        $data['sekolah'] = $datasekolah;
        $data['nama_user'] = session()->get('nama_user');
        $data['kelas'] = $kelas;
        $data['sub_kelas'] = $sub_kelas;
        $data['dafmapelpilihan'] = $dafmapelpilihan;

        return view('v_admin_mapel_pilihan', $data);
    }

    public function simpan_mapel_pilihan_kelas()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $datatosave = json_decode(file_get_contents('php://input'), true);

        $kelas = $datatosave['kelas'];
        $sub_kelas = $datatosave['sub_kelas'];

        $this->M_sekolah->hapus_mapelpilihan($id_sekolah, tahun_ajaran(), $kelas, $sub_kelas);
        foreach ($datatosave['mapelpilihan'] as $mapel_pilihan) {

            if ($mapel_pilihan != null) {
                $get_mapel = $this->M_sekolah->get_namamapel($mapel_pilihan);
                $nama_mapel = $get_mapel['nama_mapel'];
                $data['id_sekolah'] = $id_sekolah;
                $data['kelas'] = $kelas;
                $data['jenis'] = 2;
                $data['sub_kelas'] = $sub_kelas;
                $data['kd_mapel'] = $mapel_pilihan;
                $data['nama_mapel'] = $nama_mapel;
                $data['tahun_ajaran'] = tahun_ajaran();
                $simpandata = $this->M_sekolah->tambah_mapelpilihan($data);
            }
        }
        $simpandata = true;
        if ($simpandata)
            $response = ['pesan' => "Berhasil menyimpan"];
        else
            $response = ['pesan' => "Gagal Menyimpan"];

        return $this->response->setJSON($response);
    }

    public function impor_mapel_pilihan()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $dataMapel = json_decode(file_get_contents('php://input'), true);
        $kelas = $dataMapel['kelas'];
        // $kelas = '5';
        $impordata = $this->M_sekolah->impor_mapel($id_sekolah, tahun_ajaran(), $kelas);
        if ($impordata)
            $response = ['pesan' => "Berhasil"];
        else
            $response = ['pesan' => "Gagal Mengimpor"];

        return $this->response->setJSON($response);
    }

    public function simpan_mapel()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $dataMapel = json_decode(file_get_contents('php://input'), true);
        $jenis = 2;
        $sub_kelas = str_replace('pilihan', '', $dataMapel['jenis']);
        if ($dataMapel['jenis'] == "umum") {
            $jenis = 1;
            $sub_kelas = "-";
        }

        $data = array();
        $data['id_sekolah'] = $id_sekolah;
        $data['kelas'] = $dataMapel['kelas'];
        $data['jenis'] = $jenis;
        $data['sub_kelas'] = $sub_kelas;
        $data['nama_mapel'] = $dataMapel['cellContent'];
        $data['tahun_ajaran'] = tahun_ajaran();
        $addedit = $dataMapel['addedit'];
        $idedit = $dataMapel['idedit'];

        if ($addedit == "add")
            $simpandata = $this->M_sekolah->tambah_mapel($data);
        else
            $simpandata = $this->M_sekolah->update_mapel($data, $idedit);

        if ($simpandata)
            $response = ['pesan' => "Berhasil"];
        else
            $response = ['pesan' => "Gagal Menyimpan"];

        return $this->response->setJSON($response);
    }

    public function hapus_mapel()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $dataMapel = json_decode(file_get_contents('php://input'), true);
        $jenis = 2;
        $sub_kelas = str_replace('pilihan', '', $dataMapel['jenis']);
        if ($dataMapel['jenis'] == "umum") {
            $jenis = 1;
            $sub_kelas = "-";
        }

        $data = array();
        $data['id_sekolah'] = $id_sekolah;
        $data['kelas'] = $dataMapel['kelas'];
        $data['jenis'] = $jenis;
        $data['sub_kelas'] = $sub_kelas;
        $data['id'] = $dataMapel['id'];

        $cekadanilai = $this->M_sekolah->cek_nilai_mapel($id_sekolah, $dataMapel['id']);

        if ($cekadanilai) {
            $response = ['pesan' => "Sudah ada nilai"];
        } else {
            $hapusdata = $this->M_sekolah->hapus_mapel($data);
            if ($hapusdata)
                $response = ['pesan' => "Berhasil"];
            else
                $response = ['pesan' => "Gagal Menghapus"];
        }



        return $this->response->setJSON($response);
    }

    public function hapus_rombel()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $dataMapel = json_decode(file_get_contents('php://input'), true);

        $kelas = $dataMapel['kelas'];
        $rombel = $dataMapel['rombel'];

        // echo $rombel;

        $hapusdata = $this->M_sekolah->hapus_rombel($id_sekolah, $kelas, $rombel, tahun_ajaran());

        if ($hapusdata)
            $response = ['pesan' => $id_sekolah . "," . $kelas . "," . $rombel . "," . tahun_ajaran()];
        else
            $response = ['pesan' => "Gagal Menghapus"];

        return $this->response->setJSON($response);
    }

    public function hapus_mapel_pilihan()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $dataMapel = json_decode(file_get_contents('php://input'), true);

        $data = array();
        $data['id_sekolah'] = $id_sekolah;
        $data['tahun_ajaran'] = tahun_ajaran();
        $data['kelas'] = $dataMapel['kelas'];
        $data['sub_kelas'] = $dataMapel['sub_kelas'];

        $hapusdata = $this->M_sekolah->hapus_mapel_pilihan($data);

        if ($hapusdata)
            $response = ['pesan' => "Berhasil"];
        else
            $response = ['pesan' => "Gagal Menghapus"];

        return $this->response->setJSON($response);
    }

    public function projek()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $daftar_kelas = $this->get_daftar_kelas($id_sekolah, tahun_ajaran());
        $daftar_tema = $this->M_sekolah->get_tema();
        $projek_sekolah = $this->M_sekolah->get_projek_sekolah($id_sekolah, tahun_ajaran());
        $data['sekolah'] = $datasekolah;
        $data['tahun_ajaran'] = tahun_ajaran('lengkap');
        $data['nama_user'] = session()->get('nama_user');
        $data['daftar_kelas'] = $daftar_kelas;
        $data['daftar_tema'] = $daftar_tema;
        $data['projek_sekolah'] = $projek_sekolah;

        return view('v_admin_projek', $data);
    }

    public function simpan_projek()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $dataProjek = json_decode(file_get_contents('php://input'), true);

        $data = array();
        $data['id_projek'] = $dataProjek['id_projek'];
        $data['id_sekolah'] = $id_sekolah;
        $data['kelas'] = $dataProjek['kelas'];
        $data['id_tema'] = $dataProjek['id_tema'];
        $data['nama_projek'] = $dataProjek['nama_projek'];
        $data['tahun_ajaran'] = tahun_ajaran();
        $data['deskripsi_projek'] = $dataProjek['deskripsi_projek'];

        $simpandata = $this->M_sekolah->simpan_projek($data, "add");

        if ($simpandata)
            $response = ['pesan' => "Berhasil"];
        else
            $response = ['pesan' => "Gagal Menyimpan"];

        return $this->response->setJSON($response);
    }

    public function update_projek()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $dataProjek = json_decode(file_get_contents('php://input'), true);

        $data = array();
        $data['id_projek'] = $dataProjek['id_projek'];
        $data['id_sekolah'] = $id_sekolah;
        $data['kelas'] = $dataProjek['kelas'];
        $data['id_tema'] = $dataProjek['id_tema'];
        $data['nama_projek'] = $dataProjek['nama_projek'];
        $data['deskripsi_projek'] = $dataProjek['deskripsi_projek'];

        $simpandata = $this->M_sekolah->simpan_projek($data, "update");

        if ($simpandata)
            $response = ['pesan' => "Berhasil"];
        else
            $response = ['pesan' => "Gagal Menyimpan"];

        return $this->response->setJSON($response);
    }

    public function hapus_projek()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $dataProjek = json_decode(file_get_contents('php://input'), true);

        $data = array();
        $data['id_sekolah'] = $id_sekolah;
        $data['id_projek'] = $dataProjek['id_projek'];

        $hapusdata1 = $this->M_sekolah->hapus_projek($data);
        $hapusdata2 = $this->M_sekolah->hapus_dimensi_projek($data);

        if ($hapusdata2)
            $response = ['pesan' => "Berhasil"];
        else
            $response = ['pesan' => "Gagal Menghapus"];

        return $this->response->setJSON($response);
    }

    public function dimensi($kelas = null)
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $daftar_kelas = $this->get_daftar_kelas($id_sekolah, tahun_ajaran());
        if ($kelas == null && $daftar_kelas)
            $kelas = $daftar_kelas[0];
        $dimensi_projek = $this->M_sekolah->get_dimensi_projek($id_sekolah, $kelas);

        $daftar_dimensi = $this->M_sekolah->get_dimensi();
        $data['sekolah'] = $datasekolah;
        $data['tahun_ajaran'] = tahun_ajaran('lengkap');
        $data['nama_user'] = session()->get('nama_user');
        $data['daftar_kelas'] = $daftar_kelas;
        $data['kelas'] = $kelas;
        $data['fase'] = fase($kelas);
        $data['dimensi_projek'] = $dimensi_projek;
        $data['daftar_dimensi'] = $daftar_dimensi;

        return view('v_admin_dimensi', $data);
    }

    public function dimensi_penilaian($id_projek)
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $dataprojek =  $this->M_sekolah->get_projek($id_sekolah, $id_projek);
        $kelas = $dataprojek['kelas'];
        $daf_dimensi = $this->M_sekolah->get_dimensi();
        $daftar_elemen_d = [];
        $daftar_elemen_d1 = $this->M_sekolah->get_daftar_elemen($id_projek, 1);
        $daftar_elemen_d2 = $this->M_sekolah->get_daftar_elemen($id_projek, 2);
        $daftar_elemen_d3 = $this->M_sekolah->get_daftar_elemen($id_projek, 3);
        $daftar_elemen_d4 = $this->M_sekolah->get_daftar_elemen($id_projek, 4);
        $daftar_elemen_d5 = $this->M_sekolah->get_daftar_elemen($id_projek, 5);
        $daftar_elemen_d6 = $this->M_sekolah->get_daftar_elemen($id_projek, 6);
        $daftar_elemen_d[] = $daftar_elemen_d1;
        $daftar_elemen_d[] = $daftar_elemen_d2;
        $daftar_elemen_d[] = $daftar_elemen_d3;
        $daftar_elemen_d[] = $daftar_elemen_d4;
        $daftar_elemen_d[] = $daftar_elemen_d5;
        $daftar_elemen_d[] = $daftar_elemen_d6;

        $data['sekolah'] = $datasekolah;
        $data['tahun_ajaran'] = tahun_ajaran('lengkap');
        $data['nama_user'] = session()->get('nama_user');
        $data['data_projek'] = $dataprojek;
        $data['daf_dimensi'] = $daf_dimensi;
        $data['daftar_elemen_d'] = $daftar_elemen_d;
        $data['id_projek'] = $id_projek;
        $data['kelas'] = $kelas;

        return view('v_admin_dimensi_pilih', $data);
    }

    public function get_daftar_elemen()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_dimensi = $this->request->getVar('dimensiId');
        $daftar_elemen = $this->M_sekolah->get_elemen($id_dimensi);

        return json_encode($daftar_elemen);
    }

    public function simpan_penilaian($id_projek)
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $datasubelemen = json_decode(file_get_contents('php://input'), true);

        // $id_sub_elemen = explode(",", $datasubelemen);

        $this->M_sekolah->hapus_penilaian($id_sekolah, $id_projek);
        foreach ($datasubelemen['sub_elemen'] as $row) {
            if ($row != null)
                $simpandata = $this->M_sekolah->tambah_penilaian($id_sekolah, $id_projek, $row);
        }

        if ($simpandata)
            $response = ['pesan' => "Berhasil Menyimpan"];
        else
            $response = ['pesan' => "Gagal Menyimpan"];

        return $this->response->setJSON($response);
    }

    public function guru_mapel()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $getdaftarguru = $this->M_user->getDaftarGuru($id_sekolah, tahun_ajaran());
        if (sizeof($getdaftarguru) == 0) {
            $this->M_user->duplikat_guru_tahun_lalu($id_sekolah, tahun_ajaran());
            $getdaftarguru = $this->M_user->getDaftarGuru($id_sekolah, tahun_ajaran());
        }
        $daftar_mapel = $this->M_sekolah->get_daftar_mapel($id_sekolah, tahun_ajaran());
        $daftar_rombel = $this->M_sekolah->get_rombel_sekolah($id_sekolah, tahun_ajaran());
        $daftar_guru_mapel = $this->M_user->get_daftar_guru_mapel($id_sekolah);

        // echo var_dump($daftar_guru_mapel);

        $dataadmin = $this->M_user->get_admin(session()->get('id_user'));
        $jenjang = $dataadmin['jenjang'];
        $daftar_kelas = kelasdarijenjang($jenjang);

        $data['sekolah'] = $datasekolah;
        $data['tahun_ajaran'] = tahun_ajaran('lengkap');
        $data['nama_user'] = session()->get('nama_user');
        $data['daftar_guru'] = $getdaftarguru;
        $data['daftar_mapel'] = $daftar_mapel;
        $data['daftar_kelas'] = $daftar_kelas;
        $data['daftar_rombel'] = $daftar_rombel;
        $data['daftar_guru_mapel'] = $daftar_guru_mapel;

        return view('v_admin_guru_kelas', $data);
    }

    public function simpan_guru_mapel()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $dataMapel = json_decode(file_get_contents('php://input'), true);

        $tahun_ajaran = $dataMapel['tahunsekarang'];
        $kelas = $dataMapel['selectedKelas'];
        $subkelas = $dataMapel['selectedPilihan'];
        $daftarrombel = $dataMapel['rombelTerpilih'];

        $id_mapel = $dataMapel['selectedMapel'];
        $id_guru = $dataMapel['selectedGuru'];

        if ($id_mapel == "mpbk")
            $jenis_mapel = 1;
        else if ($id_mapel == "mpp5")
            $jenis_mapel = 2;
        if ($id_mapel == "mpbk" || ($id_mapel == "mpp5")) {
            $this->M_sekolah->hapus_guru_lain($jenis_mapel, $id_guru, $kelas);
        } else {
            $this->M_sekolah->hapus_guru_mapel($id_mapel, $id_guru, $kelas);
        }
        $id_rombel = "";
        if ($daftarrombel)
            foreach ($daftarrombel as $rombelterpilih) {
                $cek_rombel = $this->M_sekolah->cek_rombel($id_sekolah, $tahun_ajaran, $kelas, $rombelterpilih);
                $id_rombel = $cek_rombel['id'];
                if ($id_mapel == "mpbk")
                    $this->M_sekolah->insert_guru_bk_p5($id_rombel, 1, $id_guru);
                else if ($id_mapel == "mpp5")
                    $this->M_sekolah->insert_guru_bk_p5($id_rombel, 2, $id_guru);
                else
                    $this->M_sekolah->insert_guru_mapel($id_rombel, $id_mapel, $id_guru);
            }

        $response = ['message' => $id_rombel];
        return $this->response->setJSON($response);
    }

    public function ekskul()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $daftar_kelas = $this->get_daftar_kelas($id_sekolah, tahun_ajaran());
        $daftar_ekskul = $this->M_sekolah->get_daftar_ekskul($id_sekolah, tahun_ajaran());
        $daftar_guru = $this->M_user->getDaftarGuru($id_sekolah, tahun_ajaran());
        $data['daftar_guru'] = json_encode($daftar_guru);
        $data['sekolah'] = $datasekolah;
        $data['nama_user'] = session()->get('nama_user');
        $data['daftar_kelas'] = $daftar_kelas;
        $data['daftar_ekskul'] = $daftar_ekskul;
        $data['tahun_ajaran'] = tahun_ajaran();
        return view('v_admin_ekskul', $data);
    }

    public function simpan_ekskul()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $dataToSave = json_decode(file_get_contents('php://input'), true);

        $id_sekolah = session()->get('id_sekolah');

        $jenis = $dataToSave['jenis'];
        $ekskul = $dataToSave['ekskul'];
        $id_guru = $dataToSave['id_guru'];
        $this->M_sekolah->tambah_ekskul_sekolah($id_sekolah, $jenis, tahun_ajaran(), $ekskul, $id_guru);

        $response = ['message' => "Berhasil disimpan"];
        return $this->response->setJSON($response);
    }

    public function update_ekskul()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $dataToSave = json_decode(file_get_contents('php://input'), true);

        $id_sekolah = session()->get('id_sekolah');

        $jenis = $dataToSave['jenis'];
        $ekskul = $dataToSave['ekskul'];
        $ekskullama = $dataToSave['ekskullama'];
        $id_guru = $dataToSave['id_guru'];

        $this->M_sekolah->update_ekskul_sekolah($id_sekolah, $jenis, tahun_ajaran(), $ekskullama, $ekskul, $id_guru);

        $response = ['message' => "Berhasil diupdate"];
        return $this->response->setJSON($response);
    }

    public function hapus_ekskul()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $dataToSave = json_decode(file_get_contents('php://input'), true);

        $id_sekolah = session()->get('id_sekolah');

        $id = $dataToSave['id'];

        $this->M_sekolah->hapus_ekskul_sekolah($id_sekolah, $id);

        $response = ['message' => "Berhasil diupdate"];
        return $this->response->setJSON($response);
    }

    public function bobot_nilai()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $info_sekolah = $this->M_sekolah->getInfoSekolah($id_sekolah, tahun_ajaran());
        $bobot_tes = $info_sekolah['bobot_tes'];
        $data['sekolah'] = $datasekolah;
        $data['bobot_tes'] = $bobot_tes;
        $data['nama_user'] = session()->get('nama_user');
        $data['tahun_ajaran'] = tahun_ajaran();

        return view('v_admin_bobot_nilai', $data);
    }

    public function simpan_bobot_nilai()
    {
        $id_sekolah = session()->get('id_sekolah');

        $tahun_ajaran = $this->request->getPost('tahunajaran');
        $bobot_nilai = $this->request->getPost('bobotnilai');
        $this->M_sekolah->simpanBobotNilai($id_sekolah, $tahun_ajaran, $bobot_nilai);
        return redirect()->to("/admin/bobot_nilai");
    }

    public function kop_rapor()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $data['ckeditor'] = true;
        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $info_sekolah = $this->M_sekolah->getInfoSekolah($id_sekolah, tahun_ajaran());
        $kop_rapor = $info_sekolah['kop_rapor'];
        $data['sekolah'] = $datasekolah;
        $data['kop_rapor'] = $kop_rapor;
        $data['nama_user'] = session()->get('nama_user');
        $data['tahun_ajaran'] = tahun_ajaran();

        return view('v_admin_kop_rapor', $data);
    }

    public function simpanKopRapor()
    {
        $kop_rapor = $this->request->getPost('editor1');
        $id_sekolah = session()->get('id_sekolah');
        $this->M_sekolah->simpanKopRapor($id_sekolah, tahun_ajaran(), $kop_rapor);
        return redirect()->to("/admin/kop_rapor");
    }

    public function agenda()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $datakalender = $this->M_sekolah->getAgenda($id_sekolah);
        $dataagenda = $this->M_sekolah->getAgendaSaja($id_sekolah);
        $data['sekolah'] = $datasekolah;
        $data['tahun_ajaran'] = tahun_ajaran('lengkap');
        $data['nama_user'] = session()->get('nama_user');
        $data['datakalender'] = json_encode($datakalender);
        $data['jmldataagenda'] = sizeof($dataagenda);

        $pesan = session()->getFlashdata('pesan');
        $data['pesan'] = $pesan;

        return view('v_admin_agenda', $data);
    }

    public function list_agenda()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $datakalender = $this->M_sekolah->getAgenda($id_sekolah, tahun_ajaran());
        $data['sekolah'] = $datasekolah;
        $data['tahun_ajaran'] = tahun_ajaran('lengkap');
        $data['nama_user'] = session()->get('nama_user');
        $data['datakalender'] = $datakalender;
        $data['jmldatakalender'] = sizeof($datakalender);

        return view('v_admin_agenda_list', $data);
    }

    public function simpan_agenda()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $id_user = session()->get('id_user');

        $tanggal = $this->request->getVar('tanggal');
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $agenda = $this->request->getVar('iagenda');
        $jenis = $this->request->getVar('ipilih');
        $addedit = $this->request->getVar('addedit');

        session()->setFlashdata('pesan', $bulan . "-" . $tahun);

        $tanggalnya = $tahun . "-" . (intval($bulan) + 1) . "-" . $tanggal;

        if ($addedit == "add")
            $this->M_sekolah->tambah_agenda($id_sekolah, $tanggalnya, $agenda, $jenis, $id_user);
        else
            $this->M_sekolah->update_agenda($id_sekolah, $tanggalnya, $agenda, $jenis, $id_user);

        return redirect()->to(base_url() . 'admin/agenda');
    }

    public function hapus_agenda()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $id_user = session()->get('id_user');

        $tanggal = $this->request->getVar('tanggal');
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');

        session()->setFlashdata('pesan', $bulan . "-" . $tahun);

        $tanggalnya = $tahun . "-" . (intval($bulan) + 1) . "-" . $tanggal;

        $this->M_sekolah->hapus_agenda($id_sekolah, $tanggalnya, $id_user);

        return redirect()->to(base_url() . 'admin/agenda');
    }

    public function kepsek()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $daftar_guru = $this->M_user->getDaftarGuru($id_sekolah, tahun_ajaran());
        $data_kepsek = $this->M_user->getKepsek($id_sekolah);
        $infosekolah = $this->M_sekolah->getInfoSekolah($id_sekolah, tahun_ajaran());

        $addedit = "add";
        if ($data_kepsek) {
            $addedit = "edit";
        }
        $filetdtgn = "kosong";
        $namafile = './public/tandatangan/tandatangan1.png';

        if (file_exists($namafile)) {
            $filetdtgn = "ada";
        }

        $data['filetdtgn'] = $filetdtgn;
        $data['addedit'] = $addedit;
        $data['sekolah'] = $datasekolah;
        $data['info_sekolah'] = $infosekolah;
        $data['tahun_ajaran'] = tahun_ajaran('lengkap');
        $data['nama_user'] = session()->get('nama_user');
        $data['data_kepsek'] = $data_kepsek;
        $data['daftar_guru'] = $daftar_guru;

        return view('v_admin_kepsek', $data);
    }

    public function simpan_kepsek()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $id_kepsek = $this->request->getVar('kepsek');
        $addedit = $this->request->getVar('addedit');

        if ($addedit == "add")
            $this->M_user->tambah_kepsek($id_sekolah, $id_kepsek);
        else
            $this->M_user->update_kepsek($id_sekolah, $id_kepsek);

        return redirect()->to(base_url() . 'admin/kepsek');
    }

    public function upload_tdtgn()
    {
        $request = \Config\Services::request();
        $id_sekolah = session()->get('id_sekolah');
        $id_kepsek = $request->getPost('id_kepsek');
        $file_tdtgn = $request->getFile('file_tdtgn');

        if ($file_tdtgn->isValid()) {
            $namaFile = $file_tdtgn->getName();
            $ukuranFile = $file_tdtgn->getSize();
            $tipeFile = $file_tdtgn->getMimeType();
            $ext = $file_tdtgn->getClientExtension();

            if ($ukuranFile > 100 * 1024 || $ext !== 'png') {
                return redirect()->back()->with('error', 'Gagal unggah file. File harus berukuran kurang dari 100 KB dan berformat PNG.');
            }

            $namafilebaru = "tdtgn_" . substr($id_sekolah, 0, 8) . $id_kepsek . "." . $ext;

            $lokasiFile = 'tandatangan/' . $namafilebaru;

            if (is_file($lokasiFile)) {
                unlink($lokasiFile);
            }

            $file_tdtgn->move('tandatangan/', $namafilebaru);
        } else {
            echo $file_tdtgn->getError();
            if (session()->get('username') == "hardianto@kemdikbud.go.id") {
                echo "Eror file sk";
                die();
            }
        }
        return redirect()->to('/admin/kepsek');
    }

    public function kalender_sekolah()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $info_sekolah = $this->M_sekolah->getInfoSekolah($id_sekolah, tahun_ajaran());
        $tgl_awal_ganjil = $info_sekolah['tgl_awal_ganjil'];
        $tgl_awal_genap = $info_sekolah['tgl_awal_genap'];
        $tgl_mid_ganjil = $info_sekolah['tgl_mid_ganjil'];
        $tgl_mid_genap = $info_sekolah['tgl_mid_genap'];
        $tgl_rapor_ganjil = $info_sekolah['tgl_rapor_ganjil'];
        $tgl_rapor_genap = $info_sekolah['tgl_rapor_genap'];
        $data['ckeditor'] = true;
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $kop_rapor = $info_sekolah['kop_rapor'];
        $datakalender = $this->M_sekolah->getAgenda($id_sekolah);
        $data['datakalender'] = json_encode($datakalender);
        $data['sekolah'] = $datasekolah;
        $data['kop_rapor'] = $kop_rapor;
        $data['nama_user'] = session()->get('nama_user');
        $data['tahun_ajaran'] = tahun_ajaran();
        $data['tgl_awal_ganjil'] = $tgl_awal_ganjil;
        $data['tgl_awal_genap'] = $tgl_awal_genap;
        $data['tgl_mid_ganjil'] = $tgl_mid_ganjil;
        $data['tgl_mid_genap'] = $tgl_mid_genap;
        $data['tgl_rapor_ganjil'] = $tgl_rapor_ganjil;
        $data['tgl_rapor_genap'] = $tgl_rapor_genap;

        return view('v_admin_mid_semester', $data);
    }

    public function simpan_mid()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $dataToSave = json_decode(file_get_contents('php://input'), true);

        $id_sekolah = session()->get('id_sekolah');

        $idx_mid = $dataToSave['idx_mid'];
        $tgl_mid = $dataToSave['tgl_mid'];

        // $idx_mid = 0;
        // $tgl_mid = '2023-10-02';


        $response = ['message' => "Berhasil diupdate" . $idx_mid];
        $this->M_sekolah->simpanTglMid($id_sekolah, tahun_ajaran(), $idx_mid, $tgl_mid);

        return $this->response->setJSON($response);
    }

    private function ceklunas($id_sekolah, $tahun_ajaran)
    {
        $cekpembayaran = $this->M_sekolah->cek_pembayaran($id_sekolah, $tahun_ajaran);
        if ($cekpembayaran) {
            return "Aktif";
        } else {
            return "Trial";
        }
    }

    public function cek()
    {
        $get_mapel = $this->M_sekolah->get_namamapel('mp154');
        $nama_mapel = $get_mapel['nama_mapel'];
        $data['id_sekolah'] = '5d784c9e-f35a-4654-9851-b94d22be6f1e';
        $data['kelas'] = '7';
        $data['jenis'] = 2;
        $data['sub_kelas'] = 'B';
        $data['nama_mapel'] = $nama_mapel;
        $data['tahun_ajaran'] = tahun_ajaran();
        $simpandata = $this->M_sekolah->tambah_mapelpilihan($data);
    }

    public function jadwal_ujian()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $this->cekdaftarmapel();

        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $dataadmin = $this->M_user->get_admin(session()->get('id_user'));
        $jenjang = $dataadmin['jenjang'];
        $daftar_kelas = kelasdarijenjang($jenjang);
        $daftar_mapel = $this->M_sekolah->get_daftar_mapel($id_sekolah, tahun_ajaran());
        // dd($daftar_mapel);
        $datakalender = $this->M_sekolah->getAgenda($id_sekolah);
        $data['sekolah'] = $datasekolah;
        $data['tahun_ajaran'] = tahun_ajaran('lengkap');
        $data['nama_user'] = session()->get('nama_user');
        $data['daftar_kelas'] = $daftar_kelas;
        $data['daftar_mapel'] = $daftar_mapel;
        $data['datakalender'] = json_encode($datakalender);

        return view('v_admin_jadwal_ujian', $data);
    }

    public function simpan_jadwal_ujian()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $dataToSave = json_decode(file_get_contents('php://input'), true);
        // $dataToSave = json_decode($this->request->getBody(), true);
        // $dataToSave = $this->request->getJSON(true);

        if (!$dataToSave) {
            $response = ['message' => "Data JSON tidak tersedia"];
            return $this->response->setJSON($response);
        }

        $id_sekolah = session()->get('id_sekolah');
        $daftarsimpan = $dataToSave['daftarsimpan'];

        if (!$daftarsimpan) {
            $response = ['message' => "Daftar simpan tidak tersedia"];
            return $this->response->setJSON($response);
        }

        foreach ($daftarsimpan as $row) {
            $data['id'] = $row['id'];

            $data['jadwal_semester_ganjil_tgl'] = null;
            $data['jadwal_semester_ganjil_jam'] = null;
            $data['jadwal_semester_genap_tgl'] = null;
            $data['jadwal_semester_genap_jam'] = null;
            if ($row['jam_m'] != "") {
                $data['jadwal_semester_ganjil_tgl'] = $row['tgl'];
                $data['jadwal_semester_ganjil_jam'] = $row['jam_m'] . " - " . $row['jam_a'];
            }
            if ($row['jam_mb'] != "") {
                $data['jadwal_semester_genap_tgl'] = $row['tglb'];
                $data['jadwal_semester_genap_jam'] = $row['jam_mb'] . " - " . $row['jam_ab'];
            }
            $this->M_sekolah->simpan_jadwal_ujian($id_sekolah, $data);
        }

        $response = ['message' => "sukses"];
        return $this->response->setJSON($response);
    }


    public function tes()
    {

        // $queueModel = new EmailQueueModel();
        // $emails = $queueModel->where('status', 'queued')->findAll();

        // if (empty($emails)) {
        //     return 'No emails in the queue.';
        // }

        $emails = [
            'antok9000@gmail.com',
            'antok2000@yahoo.com',
            'antok2000@gmail.com',
            // Tambahkan alamat email lainnya jika diperlukan
        ];



        foreach ($emails as $recipient) {
            $email = \Config\Services::email();

            $email->setFrom('hardianto@kemdikbud.go.id', 'Sekretariat');
            $email->setSubject('Subject of Email');
            $email->setMessage('Content of Email');
            $email->setTo($recipient);

            if ($email->send()) {
                echo 'Email sent to ' . $recipient . '<br>';
            } else {
                echo 'Failed to send email to ' . $recipient . '<br>';
            }
        }
    }
}
