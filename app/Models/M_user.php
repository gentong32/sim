<?php

namespace App\Models;

use CodeIgniter\Model;

class M_user extends Model
{
    public function cekLoginAdmin($email, $kode)
    {
        $sql = "SELECT * FROM tb_admin WHERE email = :email:";

        $query = $this->db->query($sql, [
            'email' => $email,
        ]);

        $result = $query->getRow();

        $kembalian = array();

        $hasil = "-";
        $id_sekolah = "";
        $id_user = "";
        $nama = "";


        if ($result) {
            $token = $result->token;

            if (password_verify($kode, $token)) {
                $hasil = "ok";
                if ($email == "antok2000@gmail.com")
                    $hasil = "ganteng";
                $id_sekolah = $result->id_sekolah;
                $id_user = $result->id_user;
                $nama = $result->nama;
            }
        }

        $kembalian['hasil'] = $hasil;
        $kembalian['id_sekolah'] = $id_sekolah;
        $kembalian['id_user'] = $id_user;
        $kembalian['nama_user'] = $nama;
        $kembalian['jenis_kelamin'] = "-";

        return $kembalian;
    }

    public function getDaftarAdmin()
    {

        $query = $this->db->table('tb_admin a')
            ->select('a.*, g.status_sekolah,a.nama as nama,g.nama as nama_sekolah')
            ->join('tb_sekolah g', 'a.id_sekolah = g.id_sekolah', 'left')
            ->where('a.email<>', 'antok2000@gmail.com')
            ->orderBy('a.id')
            ->get();

        return $query->getResultArray();
    }

    public function getAdmin($id_user)
    {
        $query = $this->db->table('tb_admin')
            ->select('*')
            ->where('id_user', $id_user)
            ->get();

        return $query->getRowArray();
    }

    public function update_password($id_user, $token_baru)
    {
        $query = $this->db->table('tb_admin')
            ->where('id_user', $id_user)
            ->update(['token' => $token_baru]);
    }

    // FUNGSI UNTUK GURU =========================================================

    public function cekLoginGuru($email, $kode)
    {
        $sql = "SELECT g.id_guru as id_guru, g.*, gs.*
                FROM tb_guru g
                LEFT JOIN tb_guru_sekolah gs ON g.nuptk = gs.nuptk
                WHERE email = :email: 
                AND gs.tahun_ajaran = (
                    SELECT MAX(tahun_ajaran) 
                    FROM tb_guru_sekolah 
                    WHERE email = :email: 
                );";

        $query = $this->db->query($sql, [
            'email' => $email,
        ]);

        $result = $query->getRow();

        $kembalian = array();

        $hasil = "-";
        $id_sekolah = "";
        $id_user = "";
        $nama = "";
        $jenis_kelamin = "";


        if ($result) {
            $token = $result->token;

            if (password_verify($kode, $token)) {
                $hasil = "ok";
                $id_sekolah = $result->id_sekolah;
                $id_user = $result->id_guru;
                $nama = $result->nama;
                $jenis_kelamin = $result->jenis_kelamin;
            }
        }

        $kembalian['hasil'] = $hasil;
        $kembalian['id_sekolah'] = $id_sekolah;
        $kembalian['id_user'] = $id_user;
        $kembalian['nama_user'] = $nama;
        $kembalian['jenis_kelamin'] = $jenis_kelamin;

        return $kembalian;
    }

    public function delete_daftar_guru($id_user)
    {
        $this->db->table('tb_guru')->delete(['id_uploader' => $id_user]);
    }

    public function delete_daftar_guru_sekolah($id_sekolah, $tahun_ajaran)
    {
        $this->db->table('tb_guru_sekolah')->delete(['id_sekolah' => $id_sekolah, 'tahun_ajaran' => $tahun_ajaran]);
    }

    public function simpan_daftar_guru_sekolah($data)
    {
        $this->db->table('tb_guru_sekolah')->insertBatch($data);
    }

    public function simpan_daftar_guru($data)
    {
        foreach ($data as $row) {
            $existingRow = $this->db->table('tb_guru')->where('nuptk', $row['nuptk'])->get()->getRow();

            if (!$existingRow) {
                $this->db->table('tb_guru')->insert($row);
            }
        }
    }

    public function tambah_guru($data)
    {
        $existingRow = $this->db->table('tb_guru')->where('nuptk', $data['nuptk'])->get()->getRow();

        if (!$existingRow) {
            $this->db->table('tb_guru')->insert($data);
        } else {
        }
    }

    public function update_guru($data, $id_guru)
    {
        $this->db->table('tb_guru')->where('id_guru', $id_guru)->update($data);
    }

    public function tambah_guru_sekolah($data)
    {
        $this->db->table('tb_guru_sekolah')->insert($data);
    }

    public function getDaftarGuru($id_sekolah, $tahun_ajaran)
    {
        $sql = "SELECT *
                FROM tb_guru_sekolah gs
                LEFT JOIN tb_guru g ON g.nuptk = gs.nuptk
                WHERE id_sekolah = :id_sekolah: AND tahun_ajaran = :tahun_ajaran:
                ORDER BY nama";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
        ]);

        // $query = $this->db->table('tb_guru_sekolah gs')
        //     ->select('*')
        //     ->join('tb_guru g', 'g.nuptk = gs.nuptk', 'left')
        //     ->where('gs.id_sekolah', $id_sekolah)
        //     ->where('gs.tahun_ajaran', $tahun_ajaran)
        //     ->orderBy('gs.nama')
        //     ->get();

        return $query->getResultArray();
    }

    public function get_daftar_guru_mapel($id_sekolah)
    {
        $sql = "SELECT GROUP_CONCAT(nama_rombel ORDER BY nama_rombel ASC SEPARATOR ', ') AS nama_rombel, nama_mapel, nama, tr.kelas
                FROM tb_rombel tr
                LEFT JOIN tb_guru_mapel gm ON tr.id = gm.id_rombel
                LEFT JOIN tb_mapel tm ON tm.id = gm.id_mapel
                LEFT JOIN tb_guru_sekolah gs ON gs.id = gm.id_guru
                LEFT JOIN tb_guru tg ON tg.nuptk = gs.nuptk
                WHERE tr.id_sekolah = :id_sekolah: AND tahun_mulai = (SELECT MAX(tahun_mulai) FROM tb_rombel) 
                GROUP BY nama_mapel, nama, tr.kelas, tm.jenis, tm.sub_kelas
                ORDER BY tr.kelas, tm.nama_mapel, nama_rombel, tg.nama, tm.jenis, tm.sub_kelas";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
        ]);

        return $query->getResultArray();
    }

    public function duplikat_guru_tahun_lalu($id_sekolah, $tahun)
    {
        $sql = "INSERT INTO tb_guru_sekolah (nuptk, id_sekolah, tahun_ajaran)
                SELECT nuptk, id_sekolah, :tahun:
                FROM tb_guru_sekolah
                WHERE id_sekolah=:id_sekolah: AND tahun_ajaran = :tahun_lalu:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun' => $tahun,
            'tahun_lalu' => $tahun - 1,
        ]);
    }

    public function getDataGuru($id_guru)
    {
        $sql = "SELECT *
                FROM tb_guru
                WHERE id_guru = :id_guru:";

        $query = $this->db->query($sql, [
            'id_guru' => $id_guru,
        ]);

        return $query->getRowArray();
    }

    public function cekwalikelas($nuptk, $id_sekolah)
    {
        $sql = "SELECT *
                FROM tb_rombel
                WHERE id_sekolah = :id_sekolah: AND nuptk_wali_kelas = :nuptk:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'nuptk' => $nuptk,
        ]);

        return $query->getResultArray();
    }

    public function cekajarkelas($nuptk)
    {
        $sql = "SELECT * FROM tb_guru_mapel tgm 
                LEFT JOIN tb_guru_sekolah ts ON tgm.id_guru = ts.id 
                LEFT JOIN tb_mapel tm ON tgm.id_mapel = tm.id
                LEFT JOIN tb_rombel tr ON tgm.id_rombel = tr.id
                WHERE nuptk = :nuptk:";

        $query = $this->db->query($sql, [
            'nuptk' => $nuptk,
        ]);

        return $query->getResultArray();
    }

    public function cek_nuptk($nuptk)
    {
        $sql = "SELECT * FROM tb_guru_sekolah 
                WHERE nuptk = :nuptk:";

        $query = $this->db->query($sql, [
            'nuptk' => $nuptk,
        ]);

        return $query->getRow();
    }

    public function get_data_guru($id_user)
    {
        $sql = "SELECT * FROM tb_guru 
                WHERE id_guru = :id_user:";

        $query = $this->db->query($sql, [
            'id_user' => $id_user,
        ]);

        return $query->getRow();
    }

    public function hapus_guru_sekolah($nuptk, $id_sekolah, $tahun_ajaran)
    {
        $this->db->table('tb_guru_sekolah')->where(['nuptk' => $nuptk, 'id_sekolah' => $id_sekolah, 'tahun_ajaran' => $tahun_ajaran])->delete();
    }


    // FUNGSI UNTUK SISWA ==========================================================

    public function cekLoginSiswa($email, $kode)
    {
        $sql = "SELECT * FROM tb_siswa WHERE email = :email:";

        $query = $this->db->query($sql, [
            'email' => $email,
        ]);

        $result = $query->getRow();

        $kembalian = array();

        $hasil = "-";
        $id_sekolah = "";
        $id_user = "";
        $nama = "";


        if ($result) {
            $token = $result->token;

            if (password_verify($kode, $token)) {
                $hasil = "ok";
                $id_sekolah = $result->id_sekolah;
                $id_user = $result->id_siswa;
                $nama = $result->nama;
            }
        }

        $kembalian['hasil'] = $hasil;
        $kembalian['id_sekolah'] = $id_sekolah;
        $kembalian['id_user'] = $id_user;
        $kembalian['nama_user'] = $nama;

        return $kembalian;
    }

    public function delete_daftar_siswa($id_user)
    {
        $this->db->table('tb_siswa')->delete(['id_uploader' => $id_user]);
    }

    public function delete_daftar_siswa_sekolah($id_sekolah, $tahun_ajaran, $daftar_kelas)
    {
        foreach ($daftar_kelas as $kelas) {
            $this->db->table('tb_siswa_sekolah')->delete(['id_sekolah' => $id_sekolah, 'tahun_ajaran' => $tahun_ajaran, 'kelas' => $kelas]);
        }
    }

    public function simpan_daftar_siswa_sekolah($data)
    {
        $this->db->table('tb_siswa_sekolah')->insertBatch($data);
    }

    public function simpan_daftar_siswa($data)
    {
        foreach ($data as $row) {
            $existingRow = $this->db->table('tb_siswa')->where('nisn', $row['nisn'])->get()->getRow();

            if (!$existingRow) {
                $this->db->table('tb_siswa')->insert($row);
            }
        }
    }

    public function tambah_siswa($data)
    {
        $existingRow = $this->db->table('tb_siswa')->where('nisn', $data['nisn'])->get()->getRow();

        if (!$existingRow) {
            $this->db->table('tb_siswa')->insert($data);
        } else {
        }
    }

    public function update_siswa($data, $id_siswa)
    {
        $this->db->table('tb_siswa')->where('id_siswa', $id_siswa)->update($data);
    }

    public function update_siswa_sekolah($data, $nisn, $id_sekolah, $tahun_ajaran)
    {
        $this->db->table('tb_siswa_sekolah')->where(['nisn' => $nisn, 'id_sekolah' => $id_sekolah, 'tahun_ajaran' => $tahun_ajaran])->update($data);
    }

    public function tambah_siswa_sekolah($data)
    {
        $this->db->table('tb_siswa_sekolah')->insert($data);
    }

    public function getDaftarsiswa($id_sekolah, $tahun_ajaran, $kelas = null, $rombel = null)
    {
        $wherekelas = "";
        if ($kelas != null) {
            $wherekelas = "AND kelas = :kelas:";
        }

        $whererombel = "";
        if ($rombel != null) {
            $whererombel = " AND nama_rombel = :rombel:";
        }

        $sql = "SELECT * FROM tb_siswa_sekolah gs
                LEFT JOIN tb_siswa g ON g.nisn = gs.nisn
                WHERE id_sekolah = :id_sekolah: " . $wherekelas . $whererombel . " AND tahun_ajaran = :tahun_ajaran:
                ORDER BY kelas, nis";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
            'kelas' => $kelas,
            'rombel' => $rombel,
        ]);

        return $query->getResultArray();
    }

    public function getDaftarpresensi($id_sekolah, $tahun_ajaran, $kelas, $rombel, $tanggalpresensi)
    {
        $wherekelas = "AND kelas = :kelas:";
        $whererombel = " AND nama_rombel = :rombel:";

        $sql = "SELECT * FROM tb_siswa_sekolah gs
                LEFT JOIN tb_siswa g ON g.nisn = gs.nisn
                LEFT JOIN tb_presensi p ON p.nisn = gs.nisn AND tanggal = :tanggalpresensi: 
                WHERE gs.id_sekolah = :id_sekolah: " . $wherekelas . $whererombel . " AND tahun_ajaran = :tahun_ajaran: 
                ORDER BY kelas, nis";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
            'kelas' => $kelas,
            'rombel' => $rombel,
            'tanggalpresensi' => $tanggalpresensi,
        ]);

        return $query->getResultArray();
    }

    public function getnisnfromnis($id_sekolah, $nis)
    {
        $datasiswa = $this->db->table('tb_siswa_sekolah')->getWhere(['id_sekolah' => $id_sekolah, 'nis' => $nis])->getRowArray();

        return $datasiswa;
    }

    public function hapus_presensi($id_sekolah, $tanggal)
    {
        $this->db->table('tb_presensi')->where(['id_sekolah' => $id_sekolah, 'tanggal' => $tanggal])->delete();
    }

    public function simpan_presensi($data)
    {
        $this->db->table('tb_presensi')->insert($data);
    }

    public function getrekappresensi($id_sekolah, $tahun_ajaran, $kelas, $rombel, $semester)
    {
        if ($semester == 1)
            $batastanggal = "tanggal>='2023/07/01' AND tanggal <'2023/12/31'";
        else
            $batastanggal = "tanggal>='2024/01/01' AND tanggal <'2024/06/31'";
        $sql = "SELECT
                    gs.nis,
                    g.nama,
                    COALESCE(SUM(CASE WHEN p.status = 'I' THEN 1 ELSE 0 END), 0) as jml_ijin,
                    COALESCE(SUM(CASE WHEN p.status = 'S' THEN 1 ELSE 0 END), 0) as jml_sakit,
                    COALESCE(SUM(CASE WHEN p.status = 'A' THEN 1 ELSE 0 END), 0) as jml_alpha
                FROM tb_siswa_sekolah gs 
                LEFT JOIN tb_siswa g ON g.nisn = gs.nisn 
                LEFT JOIN tb_presensi p ON p.nisn = gs.nisn AND " . $batastanggal . "
                WHERE gs.id_sekolah = '5d784c9e-f35a-4654-9851-b94d22be6f1e' AND kelas = '10' AND nama_rombel = 'X - 1' AND tahun_ajaran = '2023'  
                GROUP BY gs.nisn, g.nama 
                ORDER BY nama";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
            'kelas' => $kelas,
            'rombel' => $rombel,
        ]);


        return $query->getResultArray();
    }

    public function getDatasiswa($id_siswa, $tahun_ajaran)
    {
        $sql = "SELECT *
                FROM tb_siswa ts
                LEFT JOIN tb_siswa_sekolah ss ON ts.nisn = ss.nisn
                WHERE id_siswa = :id_siswa: AND tahun_ajaran = :tahun_ajaran:";

        $query = $this->db->query($sql, [
            'id_siswa' => $id_siswa,
            'tahun_ajaran' => $tahun_ajaran,
        ]);

        return $query->getRowArray();
    }

    public function cek_nisn($nisn)
    {
        $sql = "SELECT * FROM tb_siswa_sekolah 
                WHERE nisn = :nisn:";

        $query = $this->db->query($sql, [
            'nisn' => $nisn,
        ]);

        return $query->getRow();
    }

    public function cek_nis($nis)
    {
        $sql = "SELECT * FROM tb_siswa_sekolah 
                WHERE nis = :nis:";

        $query = $this->db->query($sql, [
            'nis' => $nis,
        ]);

        return $query->getRow();
    }

    public function cek_email_admin($email)
    {
        $sql = "SELECT * FROM tb_admin 
                WHERE email = :email:";

        $query = $this->db->query($sql, [
            'email' => $email,
        ]);

        return $query->getRow();
    }

    public function hapus_siswa_sekolah($nisn, $id_sekolah, $tahun_ajaran)
    {
        $this->db->table('tb_siswa_sekolah')->where(['nisn' => $nisn, 'id_sekolah' => $id_sekolah, 'tahun_ajaran' => $tahun_ajaran])->delete();
    }

    // FUNGSI UNTUK STAF =========================================================

    public function cekLoginStaf($email, $kode, $tahun = null)
    {
        $wheretahun = "";
        if ($tahun != null) {
            $wheretahun = "WHERE tahun_ajaran <= :tahun:";
        }

        $sql = "SELECT g.id_staf as id_staf, *
                FROM tb_staf g
                JOIN tb_staf_sekolah gs ON g.email = gs.email
                JOIN (
                    SELECT id_staf, MAX(tahun_ajaran) as max_tahun
                    FROM tb_staf_sekolah
                    " . $wheretahun . "
                    GROUP BY id_staf
                ) latest_gs ON gs.email = latest_gs.email AND gs.tahun_ajaran = latest_gs.max_tahun WHERE email = :email:";

        $query = $this->db->query($sql, [
            'email' => $email,
            'tahun' => $tahun,
        ]);

        $result = $query->getRow();

        $kembalian = array();

        $hasil = "-";
        $id_sekolah = "";
        $id_user = "";
        $nama = "";


        if ($result) {
            $token = $result->token;

            if (password_verify($kode, $token)) {
                $hasil = "ok";
                $id_sekolah = $result->id_sekolah;
                $id_user = $result->id_staf;
                $nama = $result->nama;
            }
        }

        $kembalian['hasil'] = $hasil;
        $kembalian['id_sekolah'] = $id_sekolah;
        $kembalian['id_user'] = $id_user;
        $kembalian['nama_user'] = $nama;

        return $kembalian;
    }

    public function delete_daftar_staf($id_user)
    {
        $this->db->table('tb_staf')->delete(['id_uploader' => $id_user]);
    }

    public function delete_daftar_staf_sekolah($id_sekolah, $tahun_ajaran)
    {
        $this->db->table('tb_staf_sekolah')->delete(['id_sekolah' => $id_sekolah, 'tahun_ajaran' => $tahun_ajaran]);
    }

    public function simpan_daftar_staf_sekolah($data)
    {
        $this->db->table('tb_staf_sekolah')->insertBatch($data);
    }

    public function simpan_daftar_staf($data)
    {
        foreach ($data as $row) {
            $existingRow = $this->db->table('tb_staf')->where('email', $row['email'])->get()->getRow();

            if (!$existingRow) {
                $this->db->table('tb_staf')->insert($row);
            }
        }
    }

    public function tambah_staf($data)
    {
        $existingRow = $this->db->table('tb_staf')->where('email', $data['email'])->get()->getRow();

        if (!$existingRow) {
            $this->db->table('tb_staf')->insert($data);
        } else {
        }
    }

    public function update_staf($data, $id_staf)
    {
        $this->db->table('tb_staf')->where('id_staf', $id_staf)->update($data);
    }

    public function update_staf_sekolah($data, $email_lama)
    {
        $this->db->table('tb_staf_sekolah')->where('email', $email_lama)->update($data);
    }

    public function tambah_staf_sekolah($data)
    {
        $this->db->table('tb_staf_sekolah')->insert($data);
    }

    public function getDaftarStaf($id_sekolah, $tahun_ajaran)
    {
        $sql = "SELECT *
                FROM tb_staf_sekolah gs
                LEFT JOIN tb_staf g ON g.email = gs.email
                WHERE id_sekolah = :id_sekolah: AND tahun_ajaran = :tahun_ajaran:
                ORDER BY nama";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'tahun_ajaran' => $tahun_ajaran,
        ]);

        return $query->getResultArray();
    }

    public function getDataStaf($id_staf)
    {
        $sql = "SELECT *
                FROM tb_staf
                WHERE id_staf = :id_staf:";

        $query = $this->db->query($sql, [
            'id_staf' => $id_staf,
        ]);

        return $query->getRowArray();
    }

    public function cek_email($email)
    {
        $sql = "SELECT * FROM tb_staf_sekolah 
                WHERE email = :email:";

        $query = $this->db->query($sql, [
            'email' => $email,
        ]);

        return $query->getRow();
    }

    public function hapus_staf_sekolah($email, $id_sekolah, $tahun_ajaran)
    {
        $this->db->table('tb_staf_sekolah')->where(['email' => $email, 'id_sekolah' => $id_sekolah, 'tahun_ajaran' => $tahun_ajaran])->delete();
    }

    public function getKepsek($id_sekolah)
    {
        $sql = "SELECT * FROM tb_kepsek tk
                LEFT JOIN tb_guru_sekolah tgs ON tk.id_kepsek = tgs.id
                LEFT JOIN tb_guru tg ON tgs.nuptk = tg.nuptk
                WHERE tk.id_sekolah = :id_sekolah:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
        ]);

        return $query->getRow();
    }

    public function tambah_kepsek($id_sekolah, $id_kepsek)
    {
        $sql = "INSERT INTO tb_kepsek (id_sekolah, id_kepsek)
                VALUES (:id_sekolah:, :id_kepsek:)";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'id_kepsek' => $id_kepsek,
        ]);
    }

    public function update_kepsek($id_sekolah, $id_kepsek)
    {
        $sql = "UPDATE tb_kepsek SET id_kepsek=:id_kepsek: WHERE id_sekolah=:id_sekolah:";

        $query = $this->db->query($sql, [
            'id_sekolah' => $id_sekolah,
            'id_kepsek' => $id_kepsek,
        ]);
    }

    public function tambahlog()
    {
        $data = ['id_user' => session()->get('id_user')];
        $this->db->table('log_login')->insert($data);
    }

    public function tambah_admin($data)
    {
        $this->db->table('tb_admin')->insert($data);
    }

    public function get_admin($id_admin)
    {
        $sql = "SELECT * FROM tb_admin 
                WHERE id_user = :id_admin:";

        $query = $this->db->query($sql, [
            'id_admin' => $id_admin,
        ]);

        return $query->getRowArray();
    }

    public function update_admin($data, $id_admin)
    {
        $this->db->table('tb_admin')->where('id_user', $id_admin)->update($data);
    }

    public function hapus_admin($id_admin)
    {
        $this->db->table('tb_admin')->delete(['id_user' => $id_admin]);
    }
}
